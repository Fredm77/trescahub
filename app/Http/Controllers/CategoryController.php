<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    // ─── PUBLIC INDEX (Front-end) ─────────────────────────────────────────────

    public function publicIndex()
    {
        return redirect()->route('services');
    }

    // ─── INDEX (Admin) ────────────────────────────────────────────────────────

    public function index()
    {
        // ← FIXED: removed Category::with('service') and $services variable
        $categories = Category::latest()->paginate(10);

        return view('categories.index', compact('categories'));
    }

    // ─── CREATE ───────────────────────────────────────────────────────────────

    public function create()
    {
        return view('categories.create');
    }

    // ─── STORE ────────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $validated = $request->validate([
            'classification_name'   => ['required', 'array', 'min:1'],
            'classification_name.*' => ['required', 'string', 'max:255'],
            'subcategory'           => ['nullable', 'array'],
            'subcategory.*'         => ['nullable', 'string', 'max:255'],
            'title'                 => ['required', 'string', 'max:255'],
            'slug'                  => ['nullable', 'string', 'max:255', 'unique:categories,slug'],
            'description'           => ['nullable', 'string'],
        ]);

        if (empty($validated['slug'])) {
            unset($validated['slug']);
        }

        $validated['classification_name'] = array_values(array_unique(
            array_filter($validated['classification_name'])
        ));

        $validated['subcategory'] = !empty($validated['subcategory'])
            ? array_values(array_unique(array_filter($validated['subcategory'])))
            : null;

        $category = Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', "Category \"{$category->title}\" created successfully.");
    }

    // ─── SHOW ─────────────────────────────────────────────────────────────────

    public function show(Category $category)
    {
        // ← FIXED: removed $category->load('service') and subcategoryServices()
        return view('categories.index', compact('category'));
    }

    // ─── EDIT ─────────────────────────────────────────────────────────────────

    public function edit(Category $category)
    {
        // ← FIXED: removed $services — no longer needed
        return view('categories.edit', compact('category'));
    }

    // ─── UPDATE ───────────────────────────────────────────────────────────────

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'classification_name'   => ['required', 'array', 'min:1'],
            'classification_name.*' => ['required', 'string', 'max:255'],
            'subcategory'           => ['nullable', 'array'],
            'subcategory.*'         => ['nullable', 'string', 'max:255'],
            'title'                 => ['required', 'string', 'max:255'],
            'slug'                  => [
                'nullable', 'string', 'max:255',
                Rule::unique('categories', 'slug')->ignore($category->id),
            ],
            'description'           => ['nullable', 'string'],
        ]);

        if (empty($validated['slug'])) {
            unset($validated['slug']);
        }

        $validated['classification_name'] = array_values(array_unique(
            array_filter($validated['classification_name'])
        ));

        $validated['subcategory'] = !empty($validated['subcategory'])
            ? array_values(array_unique(array_filter($validated['subcategory'])))
            : null;

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', "Category \"{$category->title}\" updated successfully.");
    }

    // ─── DESTROY ──────────────────────────────────────────────────────────────

    public function destroy(Category $category)
    {
        $title = $category->title;
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', "Category \"{$title}\" deleted successfully.");
    }
}