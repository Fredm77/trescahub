@php
    $popularServices = \App\Models\Service::with('category')
        ->where('is_popular', true)
        ->latest()
        ->get();
@endphp

@if($popularServices->count() > 0)
<section class="py-5">
    <div class="container">

        {{-- Section Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1 d-flex align-items-center gap-2">
                    <i class="bi bi-fire" style="color: #16a34a;"></i>
                    Popular Services
                </h2>
                <p class="text-muted mb-0">Most requested service packages</p>
            </div>
            <a href="{{ route('services') }}" class="btn btn-outline-secondary btn-sm px-4">
                View All
            </a>
        </div>

        {{-- Scrollable Services Carousel --}}
        <div class="position-relative">

            {{-- Prev button --}}
            <button class="d-none d-md-flex position-absolute top-50 translate-middle-y z-1 align-items-center justify-content-center rounded-circle border-0 bg-white shadow-sm"
                    style="width:40px;height:40px;left:-20px;cursor:pointer;"
                    onclick="scrollServices(-320)">
                <i class="bi bi-chevron-left" style="color: #16a34a;"></i>
            </button>

            <div id="servicesScrollContainer"
                 class="d-flex gap-4 overflow-x-auto pb-3"
                 style="scroll-behavior:smooth;scrollbar-width:none;-ms-overflow-style:none;">

                @foreach($popularServices as $service)
                    <div class="service-card flex-shrink-0 rounded-3 border-0 shadow-sm bg-white"
                         style="width:280px;display:flex;flex-direction:column;">

                        {{-- Clickable Thumbnail --}}
                        <a href="{{ route('service.show', $service->slug) }}" class="text-decoration-none">
                            <div style="height: 160px; overflow: hidden; border-radius: 12px 12px 0 0; background: #f5f5f5;">
                                @if($service->thumbnail)
                                    <img src="{{ asset('public/' . $service->thumbnail) }}"
                                         alt="{{ $service->title }}"
                                         class="w-100 h-100"
                                         style="object-fit: cover; transition: transform 0.3s ease;">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-briefcase text-muted" style="font-size: 2.5rem;"></i>
                                    </div>
                                @endif
                            </div>
                        </a>

                        <div class="card-body d-flex flex-column px-3 pt-3 pb-3">

                            {{-- Category Badge --}}
                            @if($service->category)
                                <div class="d-flex gap-2 mb-2 flex-wrap">
                                    <span class="badge bg-light text-dark border" style="font-size: 0.7rem;">
                                        {{ $service->category->title }}
                                    </span>
                                </div>
                            @endif

                            {{-- Clickable Title --}}
                            <a href="{{ route('service.show', $service->slug) }}" class="text-decoration-none">
                                <h6 class="fw-bold mb-1" style="color: #1a2035; font-size: 0.95rem;">
                                    {{ $service->title }}
                                </h6>
                            </a>

                            {{-- Description --}}
                            @if($service->description)
                                <p class="text-muted small mb-2"
                                   style="font-size: 0.82rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $service->description }}
                                </p>
                            @endif

                            {{-- Price (left) + Order Button (right) --}}
                            <div class="d-flex justify-content-between align-items-center mt-auto">

                                {{-- Price left --}}
                                <div class="fw-bold" style="color: #16a34a; font-size: 1rem;">
                                    RWF {{ number_format($service->price, 0, '.', ',') }}
                                </div>

                                {{-- Order button right --}}
                                <a href="{{ route('service.show', $service->slug) }}"
                                   class="btn btn-sm d-flex align-items-center gap-1 px-2"
                                   style="background-color: #16a34a; color: white; border-radius: 6px; white-space: nowrap; font-size: 0.8rem;">
                                    Order
                                </a>

                            </div>

                        </div>
                    </div>
                @endforeach

            </div>

            {{-- Next button --}}
            <button class="d-none d-md-flex position-absolute top-50 translate-middle-y z-1 align-items-center justify-content-center rounded-circle border-0 bg-white shadow-sm"
                    style="width:40px;height:40px;right:-20px;cursor:pointer;"
                    onclick="scrollServices(320)">
                <i class="bi bi-chevron-right" style="color: #16a34a;"></i>
            </button>

        </div>
    </div>
</section>


<style>
    .service-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .service-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1) !important;
    }
    .service-card:hover img {
        transform: scale(1.05);
    }
    /* Hide scrollbar */
    #servicesScrollContainer::-webkit-scrollbar {
        display: none;
    }
</style>

<script>
    function scrollServices(amount) {
        document.getElementById('servicesScrollContainer').scrollBy({ left: amount, behavior: 'smooth' });
    }
</script>

@endif