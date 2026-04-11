@extends('front.layouts.guest')
@section('content')

<main class="py-12 py-md-20">
    <div class="container" style="max-width: 900px;">

        {{-- Header --}}
        <div class="text-center mb-5">
            <div style="font-size: 4rem; margin-bottom: 20px;">
                <i class="fas fa-handshake" style="color: #16a34a;"></i>
            </div>
            <h1 class="display-4 fw-bold mb-4">For Partners & Clients</h1>
            <p class="fs-5 text-muted mx-auto" style="max-width: 700px; line-height: 1.8;">
                Whether you're a corporate client, an NGO, or a fellow business — TRESCA Hub offers 
                a streamlined way to access, order, and manage professional services.
            </p>
        </div>

        {{-- Key Benefits --}}
        <div class="row g-4 my-5">
            <div class="col-12 col-md-6">
                <div class="card border shadow-sm rounded-3 h-100" style="border-color: #e5e7eb;">
                    <div class="card-body p-4">
                        <div style="font-size: 2rem; margin-bottom: 15px; color: #16a34a;">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">Dedicated Account Support</h5>
                        <p class="card-text text-muted mb-0">
                            Get priority handling, direct communication, and tailored service delivery.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card border shadow-sm rounded-3 h-100" style="border-color: #e5e7eb;">
                    <div class="card-body p-4">
                        <div style="font-size: 2rem; margin-bottom: 15px; color: #16a34a;">
                            <i class="fas fa-box"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">Bulk & Recurring Orders</h5>
                        <p class="card-text text-muted mb-0">
                            Order at scale with custom pricing and flexible delivery schedules.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card border shadow-sm rounded-3 h-100" style="border-color: #e5e7eb;">
                    <div class="card-body p-4">
                        <div style="font-size: 2rem; margin-bottom: 15px; color: #16a34a;">
                            <i class="fas fa-map-location-dot"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">Transparent Tracking</h5>
                        <p class="card-text text-muted mb-0">
                            Monitor all orders in one place with status updates and payment tracking.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card border shadow-sm rounded-3 h-100" style="border-color: #e5e7eb;">
                    <div class="card-body p-4">
                        <div style="font-size: 2rem; margin-bottom: 15px; color: #16a34a;">
                            <i class="fas fa-link"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">Partnership Opportunities</h5>
                        <p class="card-text text-muted mb-0">
                            Join the TRESCA GROUP ecosystem as a service provider or distribution partner.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Partners Section --}}
        @if($partners->count() > 0)
            <div class="mt-5 pt-5 border-top">
                <h2 class="fw-bold mb-4 text-center">Our Partners</h2>

                <div class="row g-4">
                    @foreach($partners as $partner)
                        <div class="col-12 col-md-6">
                            <div class="card border shadow-sm rounded-3 h-100" 
                                 style="border-color: #e5e7eb;">
                                <div class="card-body p-4">
                                    <div style="font-size: 2.5rem; margin-bottom: 15px; color: #16a34a;">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <h5 class="card-title fw-bold mb-2" style="color: #1a2035;">
                                        {{ $partner->title }}
                                    </h5>
                                    <p class="card-text text-muted small mb-0" 
                                       style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $partner->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- CTA Section --}}
        <div class="mt-5 pt-5 border-top text-center">
            <h3 class="fw-bold mb-3">Ready to Partner With Us?</h3>
            <p class="text-muted mb-4" style="font-size: 1.1rem;">
                Get in touch with our team to discuss partnership opportunities and custom solutions.
            </p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('request-service') }}" class="btn btn-primary btn-lg gap-2" style="background-color: #16a34a; border-color: #16a34a;">
                    <i class="fas fa-envelope"></i>
                    Get in Touch
                </a>
                <a href="{{ route('shop') }}" class="btn btn-outline-primary btn-lg gap-2">
                    <i class="fas fa-shopping-bag"></i>
                    Browse Services
                </a>
            </div>
        </div>

    </div>
</main>

<style>
    .py-md-20 { padding-top: 5rem; padding-bottom: 5rem; }

    @media (max-width: 768px) {
        .py-md-20 { padding-top: 3rem; padding-bottom: 3rem; }
    }

    .card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-primary {
        background-color: #16a34a;
        border-color: #16a34a;
    }

    .btn-primary:hover {
        background-color: #15803d;
        border-color: #15803d;
    }

    .btn-outline-primary {
        color: #16a34a;
        border-color: #16a34a;
    }

    .btn-outline-primary:hover {
        background-color: #16a34a;
        border-color: #16a34a;
        color: #fff;
    }

    .text-primary {
        color: #16a34a !important;
    }
</style>

@endsection