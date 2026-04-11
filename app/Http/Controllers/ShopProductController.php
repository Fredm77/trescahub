<?php

namespace App\Http\Controllers;

use App\Models\Shopcategory;
use App\Models\ShopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ShopProductController extends Controller
{
    // ── Public ─────────────────────────────────────────────────────────────

    public function publicIndex(Request $request)
    {
        $popularProducts = ShopProduct::with(['category', 'subcategory'])
            ->where('is_popular', true)
            ->latest()
            ->get();

        $products = ShopProduct::with(['category', 'subcategory'])
            ->when($request->category, function ($q) use ($request) {
                $q->whereHas('category', fn($c) => $c->where('slug', $request->category));
            })
            ->when($request->subcategory, function ($q) use ($request) {
                $q->whereHas('subcategory', fn($c) => $c->where('slug', $request->subcategory));
            })
            ->when($request->status, function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->search, function ($q) use ($request) {
                $q->where('product_name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->get();

        $parentCategories = Shopcategory::with('subcategories')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('front.pages.shop', compact('products', 'popularProducts', 'parentCategories'));
    }

    public function publicShow(ShopProduct $shopProduct)
    {
        $shopProduct->load(['category', 'subcategory']);

        $related = ShopProduct::with(['category', 'subcategory'])
            ->where('shop_category_id', $shopProduct->shop_category_id)
            ->where('id', '!=', $shopProduct->id)
            ->limit(4)
            ->get();

        return view('front.pages.shopproduct', compact('shopProduct', 'related'));
    }

    // ── Admin ──────────────────────────────────────────────────────────────

    public function index()
    {
        $products = ShopProduct::with(['category', 'subcategory'])
            ->latest()
            ->paginate(15);

        return view('shop-products.index', compact('products'));
    }

    public function create()
    {
        $parentCategories = Shopcategory::with('subcategories')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('shop-products.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name'           => ['required', 'string', 'max:255'],
            'status'                 => ['required', Rule::in(['in_stock', 'out_of_stock'])],
            'is_popular'             => ['nullable', 'boolean'],
            'description'            => ['nullable', 'string'],
            'price'                  => ['required', 'numeric', 'min:0'],
            'working_days'           => ['required', 'integer', 'min:1'],
            'features'               => ['nullable', 'array'],
            'features.*'             => ['nullable', 'string', 'max:255'],
            'specifications'         => ['nullable', 'array'],
            'specifications.*.label' => ['nullable', 'string', 'max:255'],
            'specifications.*.value' => ['nullable', 'string', 'max:255'],
            'thumbnail'              => ['nullable', 'image', 'max:2048'],
            'images'                 => ['nullable', 'array'],
            'images.*'               => ['image', 'max:2048'],
            'shop_category_id'       => ['required', 'integer', 'exists:shop_categories,id'],
            'subcategory_id'         => ['nullable', 'integer', 'exists:shop_categories,id'],
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $this->saveImage($request->file('thumbnail'), 'shop-products/thumbnails');
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $this->saveImage($image, 'shop-products/images');
            }
        }

        $features       = array_values(array_filter($validated['features'] ?? [], fn($f) => !empty(trim($f))));
        $specifications = array_values(array_filter($validated['specifications'] ?? [], fn($s) => !empty($s['label']) && !empty($s['value'])));

        // Auto-generate unique slug
        $baseSlug = Str::slug($validated['product_name']);
        $slug     = $baseSlug;
        $count    = 1;
        while (ShopProduct::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }

        ShopProduct::create([
            'product_name'     => $validated['product_name'],
            'status'           => $validated['status'],
            'is_popular'       => $request->boolean('is_popular', false),
            'description'      => $validated['description'] ?? null,
            'price'            => $validated['price'],
            'working_days'     => $validated['working_days'],
            'features'         => $features,
            'specifications'   => $specifications,
            'thumbnail'        => $thumbnailPath,
            'images'           => $imagePaths,
            'shop_category_id' => $validated['shop_category_id'],
            'subcategory_id'   => $validated['subcategory_id'] ?? null,
            'slug'             => $slug,
        ]);

        return redirect()->route('admin.shop-products.index')
            ->with('success', 'Product created successfully!');
    }

    public function show(ShopProduct $shopProduct)
    {
        $shopProduct->load(['category', 'subcategory']);
        return view('front.pages.shopproduct', compact('shopProduct'));
    }

    public function edit(ShopProduct $shopProduct)
    {
        $shopProduct->load(['category', 'subcategory']);

        $parentCategories = Shopcategory::with('subcategories')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('shop-products.edit', compact('shopProduct', 'parentCategories'));
    }

    public function update(Request $request, ShopProduct $shopProduct)
    {
        $validated = $request->validate([
            'product_name'           => ['required', 'string', 'max:255'],
            'status'                 => ['required', Rule::in(['in_stock', 'out_of_stock'])],
            'is_popular'             => ['nullable', 'boolean'],
            'description'            => ['nullable', 'string'],
            'price'                  => ['required', 'numeric', 'min:0'],
            'working_days'           => ['required', 'integer', 'min:1'],
            'features'               => ['nullable', 'array'],
            'features.*'             => ['nullable', 'string', 'max:255'],
            'specifications'         => ['nullable', 'array'],
            'specifications.*.label' => ['nullable', 'string', 'max:255'],
            'specifications.*.value' => ['nullable', 'string', 'max:255'],
            'thumbnail'              => ['nullable', 'image', 'max:2048'],
            'images'                 => ['nullable', 'array'],
            'images.*'               => ['image', 'max:2048'],
            'shop_category_id'       => ['required', 'integer', 'exists:shop_categories,id'],
            'subcategory_id'         => ['nullable', 'integer', 'exists:shop_categories,id'],
        ]);

        $thumbnailPath = $shopProduct->thumbnail;
        if ($request->hasFile('thumbnail')) {
            $this->deleteImage($thumbnailPath);
            $thumbnailPath = $this->saveImage($request->file('thumbnail'), 'shop-products/thumbnails');
        }

        $imagePaths = $shopProduct->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($shopProduct->images ?? [] as $old) {
                $this->deleteImage($old);
            }
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $this->saveImage($image, 'shop-products/images');
            }
        }

        $features       = array_values(array_filter($validated['features'] ?? [], fn($f) => !empty(trim($f))));
        $specifications = array_values(array_filter($validated['specifications'] ?? [], fn($s) => !empty($s['label']) && !empty($s['value'])));

        $shopProduct->update([
            'product_name'     => $validated['product_name'],
            'status'           => $validated['status'],
            'is_popular'       => $request->boolean('is_popular', false),
            'description'      => $validated['description'] ?? null,
            'price'            => $validated['price'],
            'working_days'     => $validated['working_days'],
            'features'         => $features,
            'specifications'   => $specifications,
            'thumbnail'        => $thumbnailPath,
            'images'           => $imagePaths,
            'shop_category_id' => $validated['shop_category_id'],
            'subcategory_id'   => $validated['subcategory_id'] ?? null,
        ]);

        return redirect()->route('admin.shop-products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(ShopProduct $shopProduct)
    {
        $this->deleteImage($shopProduct->thumbnail);
        foreach ($shopProduct->images ?? [] as $img) {
            $this->deleteImage($img);
        }

        $name = $shopProduct->product_name;
        $shopProduct->delete();

        return redirect()->route('admin.shop-products.index')
            ->with('success', "Product '{$name}' deleted successfully!");
    }

    // ── Private Helpers ────────────────────────────────────────────────────

    private function saveImage($file, string $folder): string
    {
        $destination = public_path('assets/' . $folder);

        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move($destination, $filename);

        return $folder . '/' . $filename;
    }

    private function deleteImage(?string $path): void
    {
        if ($path && File::exists(public_path('assets/' . $path))) {
            File::delete(public_path('assets/' . $path));
        }
    }
}