@extends('front.layouts.guest')
@section('content')

<main class="py-12 py-md-20">
    <div class="container">

        {{-- Header --}}
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold mb-4">Shop & Order</h1>
            <p class="fs-5 text-muted mx-auto" style="max-width: 600px;">
                Physical products, digital services, and tech accessories — delivered to your door or activated instantly.
            </p>
        </div>

        {{-- Type Tabs --}}
        @php
            $activeStatus   = request('status', 'all');
            $activeCategory = request('category', 'all');
            $activeSubcat   = request('subcategory', 'all');
            $searchQuery    = request('search', '');

            $totalCount    = $products->count();
            $inStockCount  = $products->where('status', 'in_stock')->count();
            $outStockCount = $products->where('status', 'out_of_stock')->count();

            $tabs = [
                ['key' => 'all',          'label' => 'All Products', 'count' => $totalCount],
                ['key' => 'in_stock',     'label' => 'In Stock',     'count' => $inStockCount],
                ['key' => 'out_of_stock', 'label' => 'Out of Stock', 'count' => $outStockCount],
            ];
        @endphp

        <div class="d-flex justify-content-center gap-3 flex-wrap mt-4 mb-4">
            @foreach($tabs as $tab)
                <a href="{{ route('shop', array_merge(request()->query(), ['status' => $tab['key']])) }}"
                   class="btn btn-sm {{ $activeStatus === $tab['key'] ? 'btn-primary' : 'btn-outline-secondary' }} d-flex align-items-center gap-2"
                   style="border-radius: 9999px; padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                    <span>{{ $tab['label'] }}</span>
                    <span class="badge {{ $activeStatus === $tab['key'] ? 'bg-white text-primary' : 'bg-secondary' }}"
                          style="font-size: 0.7rem;">
                        {{ $tab['count'] }}
                    </span>
                </a>
            @endforeach
        </div>

        {{-- Search --}}
        <div class="row justify-content-center mb-4">
            <div class="col-12 col-md-6" style="max-width: 500px;">
                <form action="{{ route('shop') }}" method="GET" class="input-group input-group-lg">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="hidden" name="status"   value="{{ $activeStatus }}">
                    <input type="hidden" name="category" value="{{ $activeCategory }}">
                    <input type="text"
                           name="search"
                           class="form-control border-start-0"
                           placeholder="Search products..."
                           value="{{ $searchQuery }}"
                           onchange="this.form.submit()"
                           style="font-size: 0.875rem;">
                </form>
            </div>
        </div>

        {{-- Parent Category Filter --}}
        <div class="d-flex justify-content-center flex-wrap gap-2 mb-2">
            <a href="{{ route('shop', array_merge(request()->query(), ['category' => 'all', 'subcategory' => 'all'])) }}"
               class="btn btn-sm {{ $activeCategory === 'all' ? 'btn-secondary' : 'btn-outline-secondary' }}"
               style="border-radius: 9999px; padding: 0.375rem 1rem; font-size: 0.875rem;">
                All
            </a>
            @foreach($parentCategories as $cat)
                <a href="{{ route('shop', array_merge(request()->query(), ['category' => $cat->slug, 'subcategory' => 'all'])) }}"
                   class="btn btn-sm {{ $activeCategory === $cat->slug ? 'btn-secondary' : 'btn-outline-secondary' }}"
                   style="border-radius: 9999px; padding: 0.375rem 1rem; font-size: 0.875rem;">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        {{-- Subcategory Filter (shown when a parent is selected) --}}
        @if($activeCategory !== 'all')
            @php
                $selectedParent = $parentCategories->firstWhere('slug', $activeCategory);
            @endphp
            @if($selectedParent && $selectedParent->subcategories->count() > 0)
                <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
                    <a href="{{ route('shop', array_merge(request()->query(), ['subcategory' => 'all'])) }}"
                       class="btn btn-sm {{ $activeSubcat === 'all' ? 'btn-dark' : 'btn-outline-dark' }}"
                       style="border-radius: 9999px; padding: 0.3rem 0.9rem; font-size: 0.8rem;">
                        All {{ $selectedParent->name }}
                    </a>
                    @foreach($selectedParent->subcategories as $sub)
                        <a href="{{ route('shop', array_merge(request()->query(), ['subcategory' => $sub->slug])) }}"
                           class="btn btn-sm {{ $activeSubcat === $sub->slug ? 'btn-dark' : 'btn-outline-dark' }}"
                           style="border-radius: 9999px; padding: 0.3rem 0.9rem; font-size: 0.8rem;">
                            {{ $sub->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        @endif

        {{-- Products Grid --}}
        @if($products->isEmpty())
            <div class="alert alert-light border mt-5 p-5 text-center">
                <p class="text-muted mb-3">No products found matching your criteria.</p>
                <a href="{{ route('shop') }}" class="btn btn-outline-secondary btn-sm">
                    Clear Filters
                </a>
            </div>
        @else
            <div class="row g-4 mt-3">
                @foreach($products as $product)
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <a href="{{ route('shop-products.show', $product) }}" class="text-decoration-none">
                            <div class="card h-100 product-card shadow-sm">

                                {{-- Thumbnail --}}
                                <div class="product-img-wrap">
                                    @if($product->thumbnail)
                                        <img src="{{ asset('public/assets/' . $product->thumbnail) }}"
                                             alt="{{ $product->product_name }}"
                                             class="product-img">
                                    @else
                                        <div class="product-img-placeholder">
                                            <i class="bi bi-box-seam"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column">

                                    {{-- Badges --}}
                                    <div class="d-flex gap-2 mb-2 flex-wrap">
                                        @if($product->category)
                                            <span class="badge bg-light text-dark border" style="font-size: 0.7rem;">
                                                {{ $product->category->name }}
                                            </span>
                                        @endif
                                        <span class="badge {{ $product->status === 'in_stock' ? 'bg-success' : 'bg-danger' }}"
                                              style="font-size: 0.7rem;">
                                            {{ $product->status === 'in_stock' ? 'In Stock' : 'Out of Stock' }}
                                        </span>
                                    </div>

                                    {{-- Title --}}
                                    <h5 class="card-title fw-bold mb-2" style="font-size: 0.95rem;">
                                        {{ $product->product_name }}
                                    </h5>

                                    {{-- Description --}}
                                    @if($product->description)
                                        <p class="card-text text-muted small flex-grow-1 mb-3"
                                           style="font-size: 0.85rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                            {{ $product->description }}
                                        </p>
                                    @endif

                                    {{-- Working Days --}}
                                    <div class="d-flex align-items-center gap-1 mb-3 text-muted" style="font-size: 0.8rem;">
                                        <i class="bi bi-clock"></i>
                                        <span>{{ $product->working_days }} working day(s)</span>
                                    </div>

                                    {{-- Price & Button --}}
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <span class="fw-bold fs-5 text-primary">
                                            RWF {{ number_format($product->price, 0, '.', ',') }}
                                        </span>
                                        <span class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye me-1"></i> View
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- CTA --}}
        <div class="alert alert-light border mt-5 p-5 text-center">
            <h4 class="fw-bold mb-2">Can't Find What You Need?</h4>
            <p class="text-muted mb-4">
                We can source any product for you through our Assisted Online Purchase service.
            </p>
            <a href="{{ route('request-service') }}" class="btn btn-primary">
                <i class="bi bi-question-circle me-2"></i>Request a Product
            </a>
        </div>

    </div>
</main>

<style>
    .py-md-20 { padding-top: 5rem; padding-bottom: 5rem; }

    @media (max-width: 768px) {
        .py-md-20 { padding-top: 3rem; padding-bottom: 3rem; }
    }

    .product-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        overflow: hidden;
        border: none;
    }

    .product-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04) !important;
        transform: translateY(-4px);
    }

    .product-img-wrap {
        width: 100%;
        height: 180px;
        overflow: hidden;
        background: #f3f4f6;
    }

    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-img { transform: scale(1.05); }

    .product-img-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: #9ca3af;
    }

    .text-primary { color: #16a34a !important; }
    .btn-primary  { background-color: #16a34a; border-color: #16a34a; }
    .btn-primary:hover { background-color: #15803d; border-color: #15803d; }
</style>

@endsection