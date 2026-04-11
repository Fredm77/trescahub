@php
    $services = \App\Models\Service::with('category')
        ->where('is_in_stock', true)
        ->latest()
        ->get();
    
    // Category icons mapping
    $categoryIcons = [
        'engineering' => 'bi-tools',
        'graphic' => 'bi-palette',
        'construction' => 'bi-building',
        'shopping' => 'bi-bag-check',
        'refreshment' => 'bi-cup-hot',
        'event' => 'bi-calendar-event',
        'design' => 'bi-brush',
        'technical' => 'bi-gear',
        'works' => 'bi-hammer',
        'supplies' => 'bi-box2',
        'support' => 'bi-life-ring',
    ];
@endphp

@if($services->count() > 0)
<section class="py-5 py-lg-6" style="background-color: #f9fafb;">
    <div class="container-xl px-4 px-lg-5">
        <!-- Section Header -->
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3" style="font-family: 'Space Grotesk', sans-serif; font-size: clamp(1.75rem, 4vw, 2.5rem); color: #000;">
                Our Service Stores
            </h2>
            <p class="text-muted mx-auto" style="max-width: 600px; font-size: 1rem; color: #777;">
                Five specialized stores, one powerful platform. Find exactly what you need.
            </p>
        </div>

        <!-- Services Grid -->
        <div class="row g-4">
            @foreach($services as $service)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-2-4">
                    <a href="{{ route('service.show', $service->slug) }}"
                       class="service-card d-flex flex-column h-100 overflow-hidden rounded-4 border text-decoration-none bg-white"
                       style="border-color: #e5e7eb; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">

                        <!-- Image Container with Icon -->
                        <div class="position-relative overflow-hidden" style="height: 160px; background: #f3f4f6;">
                            @if($service->thumbnail)
                                <img src="{{ asset('public/' . $service->thumbnail) }}"
                                     class="service-img w-100 h-100"
                                     alt="{{ $service->title }}"
                                     style="object-fit: cover; object-position: center; transition: transform 0.3s ease;">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                                    <i class="bi bi-briefcase text-muted" style="font-size: 2.5rem;"></i>
                                </div>
                            @endif
                            
                            <!-- Dark Overlay Gradient -->
                            <div class="position-absolute top-0 start-0 w-100 h-100"
                                 style="background: linear-gradient(to top, rgba(0, 0, 0, 0.25), transparent);"></div>
                            
                            <!-- Category Icon Badge (Bottom Left) -->
                            <div class="position-absolute bottom-0 start-0 p-3">
                                @php
                                    $categoryName = strtolower($service->category?->title ?? 'default');
                                    $iconClass = 'bi-briefcase';
                                    
                                    foreach($categoryIcons as $key => $icon) {
                                        if (strpos($categoryName, $key) !== false) {
                                            $iconClass = $icon;
                                            break;
                                        }
                                    }
                                @endphp
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                                      style="width: 36px; height: 36px; background-color: rgba(255, 255, 255, 0.9); box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                                    <i class="bi {{ $iconClass }}" style="font-size: 1.25rem; color: #F67723;"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-4 text-center d-flex flex-column flex-grow-1">
                            <!-- Service Title -->
                            <h3 class="fw-bold mb-2" 
                                style="font-family: 'Space Grotesk', sans-serif; font-size: 15px; color: #000; line-height: 1.4;">
                                {{ $service->title }}
                            </h3>

                            <!-- Category / Company Name -->
                            <p class="mb-3" style="font-size: 12px; color: #888; margin-bottom: auto !important;">
                                {{ $service->category?->title ?? 'TRESCA GROUP' }}
                            </p>

                            <!-- Shop Service Link -->
                            <span class="d-inline-flex align-items-center justify-content-center gap-2 fw-medium"
                                  style="font-size: 13px; color: #16a34a; transition: color 0.3s ease;">
                                Shop Service
                                <i class="bi bi-arrow-right" style="font-size: 11px;"></i>
                            </span>
                        </div>

                    </a>
                </div>
            @endforeach
        </div>

    </div>
</section>
@endif

@push('styles')
<style>
    /* Responsive Column for 5 items per row on desktop */
    @media (min-width: 1400px) {
        .col-xl-2-4 {
            flex: 0 0 calc(20% - 1rem) !important;
            max-width: calc(20% - 1rem) !important;
        }
    }

    /* Service Card Styles */
    .service-card {
        border: 1px solid #e5e7eb;
        background-color: #ffffff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .service-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
        border-color: #16a34a;
    }

    .service-card:hover .service-img {
        transform: scale(1.06);
    }

    .service-card:hover span {
        color: #15803d !important;
    }

    /* Grid Gap Fix */
    .row {
        --bs-gutter-x: 1rem;
        --bs-gutter-y: 1rem;
    }

    /* Mobile Responsive */
    @media (max-width: 576px) {
        .col-12 {
            width: 100%;
        }
    }

    @media (min-width: 576px) and (max-width: 767px) {
        .col-sm-6 {
            width: 50%;
        }
    }

    @media (min-width: 768px) and (max-width: 991px) {
        .col-lg-4 {
            width: 33.333%;
        }
    }

    @media (min-width: 992px) and (max-width: 1199px) {
        .col-lg-4 {
            width: 33.333%;
        }
    }

    /* Smooth transitions */
    .service-img {
        transition: transform 0.3s ease;
    }
</style>
@endpush

@push('scripts')
<script>
    console.log('✅ Service Stores Grid Loaded');
    console.log('Total Services:', document.querySelectorAll('.service-card').length);
</script>
@endpush