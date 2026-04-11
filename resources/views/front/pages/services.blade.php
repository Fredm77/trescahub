@extends('front.layouts.guest')
@section('content')

<main class="py-12 py-md-20">
    <div class="container">
        {{-- Header Section --}}
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold mb-4">Services Marketplace</h1>
            <p class="fs-5 text-muted mx-auto" style="max-width: 600px;">
                Browse our specialized service categories. Order packages like products — add to cart, checkout, and track your order.
            </p>
        </div>

        {{-- Services Grid --}}
        <div class="row g-4 mt-5">
            @forelse($categories as $category)
                <div class="col-12 col-md-6 col-lg-4">
                    <a href="{{ route('services.category', $category->slug) }}" class="text-decoration-none">
                        <div class="card h-100 service-card"
                             style="cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
                            <div class="card-body d-flex flex-column p-5">
                                {{-- Icon --}}
                                <div class="service-icon mb-4">
                                    @php
                                        // Map category names to Font Awesome icons
                                        $iconMap = [
                                            'graphic' => 'fas fa-palette',
                                            'design' => 'fas fa-palette',
                                            'content' => 'fas fa-pen-fancy',
                                            'writing' => 'fas fa-pen-fancy',
                                            'web' => 'fas fa-code',
                                            'development' => 'fas fa-code',
                                            'photography' => 'fas fa-camera',
                                            'photo' => 'fas fa-camera',
                                            'video' => 'fas fa-video',
                                            'production' => 'fas fa-video',
                                            'engineering' => 'fas fa-tools',
                                            'technical' => 'fas fa-tools',
                                            'construction' => 'fas fa-hammer',
                                            'shopping' => 'fas fa-shopping-cart',
                                            'supplies' => 'fas fa-box',
                                            'refreshments' => 'fas fa-utensils',
                                            'catering' => 'fas fa-utensils',
                                        ];

                                        $categoryLower = strtolower($category->title);
                                        $icon = 'fas fa-star'; // default icon

                                        foreach ($iconMap as $keyword => $faIcon) {
                                            if (stripos($categoryLower, $keyword) !== false) {
                                                $icon = $faIcon;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <i class="{{ $icon }}" style="font-size: 2.5rem; color: var(--bs-primary-color); display: inline-block;"></i>
                                </div>

                                {{-- Title --}}
                                <h2 class="card-title fw-bold fs-5 mb-2" style="color: var(--bs-body-color);">
                                    {{ $category->title }}
                                </h2>

                                {{-- Description --}}
                                <p class="card-text text-muted flex-grow-1 small mb-4" style="font-size: 0.875rem; line-height: 1.6;">
                                    {{ Str::limit($category->description, 100) }}
                                </p>

                                {{-- Package Count and Browse Link --}}
                                @php
                                    $packageCount = $category->services()->count();
                                @endphp

                                <div class="service-link d-flex align-items-center gap-2 small fw-semibold text-primary"
                                     style="font-size: 0.875rem; transition: gap 0.3s ease;">
                                    <span>Browse {{ $packageCount }} {{ Str::plural('service', $packageCount) }}</span>
                                    <i class="fas fa-arrow-right" style="font-size: 0.875rem; transition: transform 0.3s ease; display: inline-block;"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center py-5">
                        <h5 class="mb-2">No Services Available</h5>
                        <p class="text-muted">Please check back soon for new services.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</main>

<style>
    :root {
        --bs-body-color: #1f2937;
        --bs-border-color: #e5e7eb;
        --bs-primary-color: #16a34a;
        --bs-text-muted: #6b7280;
    }

    .py-md-20 {
        padding-top: 5rem;
        padding-bottom: 5rem;
    }

    @media (max-width: 768px) {
        .py-md-20 {
            padding-top: 3rem;
            padding-bottom: 3rem;
        }
    }

    .service-card {
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: #fff;
        border: none;
    }

    .service-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        transform: translateY(-4px);
    }

    .service-card:hover .service-link {
        gap: 0.75rem;
    }

    .service-card:hover .fa-arrow-right {
        transform: translateX(4px);
    }

    .service-icon {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        min-height: 2.5rem;
    }

    .flex-grow-1 {
        flex-grow: 1 !important;
    }

    .p-5 {
        padding: 1.5rem;
    }

    .mb-2 {
        margin-bottom: 0.5rem !important;
    }

    .mb-3 {
        margin-bottom: 0.75rem !important;
    }

    .mb-4 {
        margin-bottom: 1rem !important;
    }

    .mb-5 {
        margin-bottom: 1.5rem !important;
    }

    .text-primary {
        color: var(--bs-primary-color) !important;
    }

    .text-muted {
        color: var(--bs-text-muted) !important;
    }

    .display-4 {
        color: var(--bs-body-color);
        font-weight: 700;
    }

    .fs-5 {
        color: var(--bs-text-muted);
    }

    /* Responsive */
    @media (max-width: 576px) {
        .display-4 {
            font-size: 2rem;
        }

        .fs-5 {
            font-size: 1rem !important;
        }

        .p-5 {
            padding: 1.25rem;
        }
    }
</style>

@endsection