@if($popularProducts->count() > 0)
<section class="py-5">
    <div class="container">

        {{-- Section Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1 d-flex align-items-center gap-2">
                    <i class="bi bi-fire" style="color: #16a34a;"></i>
                    Popular Products
                </h2>
                <p class="text-muted mb-0">Top-selling items from our shop</p>
            </div>
            <a href="{{ route('shop') }}" class="btn btn-outline-secondary btn-sm px-4">
                Visit Shop
            </a>
        </div>

        {{-- Products Grid --}}
        <div class="row g-4 justify-content-center">
            @foreach($popularProducts as $product)
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 product-card">

                        {{-- Clickable Thumbnail --}}
                        <a href="{{ route('shop-products.show', $product->slug) }}" class="text-decoration-none">
                            <div style="height: 200px; overflow: hidden; border-radius: 12px 12px 0 0; background: #f5f5f5;">
                                @if($product->thumbnail)
                                    <img src="{{ asset('public/assets/' . $product->thumbnail) }}"
                                         alt="{{ $product->product_name }}"
                                         class="w-100 h-100"
                                         style="object-fit: cover; transition: transform 0.3s ease;">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-box-seam text-muted" style="font-size: 3rem;"></i>
                                    </div>
                                @endif
                            </div>
                        </a>

                        <div class="card-body d-flex flex-column px-3 pt-3 pb-3">

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

                            {{-- Clickable Title --}}
                            <a href="{{ route('shop-products.show', $product->slug) }}" class="text-decoration-none">
                                <h6 class="fw-bold mb-1" style="color: #1a2035;">
                                    {{ $product->product_name }}
                                </h6>
                            </a>

                            {{-- Description --}}
                            @if($product->description)
                                <p class="text-muted small mb-2"
                                   style="font-size: 0.82rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $product->description }}
                                </p>
                            @endif

                            {{-- Price (left) + Order Button (right) --}}
                            <div class="d-flex justify-content-between align-items-center mt-auto">

                                {{-- Price left --}}
                                <div>
                                    <div class="fw-bold" style="color: #16a34a; font-size: 1.05rem;">
                                        RWF {{ number_format($product->price, 0, '.', ',') }}
                                    </div>
                                    <div class="text-muted" style="font-size: 0.75rem;">
                                        {{ $product->working_days }}-{{ $product->working_days + 1 }} working days
                                    </div>
                                </div>

                                {{-- WhatsApp Order button right --}}
                                @php
                                    $whatsappMessage = urlencode(
                                        "Hi TRESCA Hub! I'm interested in: *" . $product->product_name . "*\n" .
                                        "Price: RWF " . number_format($product->price, 0, '.', ',') . "\n" .
                                        "Please share more details.\n\n" .
                                        "Product Link: " . route('shop-products.show', $product->slug)
                                    );
                                    $whatsappUrl = "https://wa.me/250780290040?text=" . $whatsappMessage;
                                @endphp
                                <a href="{{ $whatsappUrl }}"
                                   target="_blank"
                                   class="btn btn-sm d-flex align-items-center gap-1"
                                   style="background-color: #16a34a; color: white; border-radius: 8px; white-space: nowrap;">
                                    <i class="bi bi-whatsapp"></i> Order
                                </a>

                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<style>
    .product-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1) !important;
    }
    .product-card:hover img {
        transform: scale(1.05);
    }
</style>
@endif