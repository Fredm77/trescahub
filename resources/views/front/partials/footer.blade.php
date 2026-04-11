{{-- resources/views/front/partials/footer.blade.php --}}

@php
    use App\Models\Category;
    use App\Models\Service;

    $footerServices = Service::with('category')
        ->where('is_in_stock', true)
        ->latest()
        ->limit(5)
        ->get();
@endphp

<footer style="background:#141a24; color:#e2e8f0;">
    <div class="container-xl px-4 px-lg-5 py-5">

        <div class="row g-4">

            {{-- Brand --}}
            <div class="col-12 col-md-3">
                <h3 class="fw-bold fs-5 mb-1" style="font-family:'Space Grotesk',sans-serif; color:#fff;">
                    TRESCA <span style="font-weight:300;">Hub</span>
                </h3>
                <p class="mb-1 small" style="color:#94a3b8;">Your Link to Services</p>
                <p class="mb-3" style="font-size:11px; color:#64748b;">Powered by TRESCA GROUP</p>

                {{-- Social / WhatsApp --}}
                <a href="https://wa.me/250789078690891?text={{ urlencode('Hello TRESCA, I want to talk about the products you are selling') }}"
                   target="_blank"
                   class="d-inline-flex align-items-center gap-2 text-decoration-none px-3 py-2 rounded-pill"
                   style="background:rgba(37,211,102,0.12); color:#25D366; font-size:13px; font-weight:500; border:1px solid rgba(37,211,102,0.25);">
                    <i class="fab fa-whatsapp"></i> WhatsApp Us
                </a>
            </div>

            {{-- Services (dynamic, limit 5) --}}
            <div class="col-6 col-md-3">
                <h4 class="text-uppercase fw-semibold mb-3"
                    style="font-size:12px; letter-spacing:0.08em; color:#64748b;">Services</h4>
                <ul class="list-unstyled mb-0">
                    @forelse($footerServices as $service)
                        <li class="mb-2">
                            <a href="{{ route('service.show', $service->slug) }}"
                               class="text-decoration-none footer-link"
                               style="color:#cbd5e1; font-size:14px;">
                                {{ $service->title }}
                            </a>
                        </li>
                    @empty
                        <li class="mb-2" style="color:#64748b; font-size:14px;">No services yet</li>
                    @endforelse

                    <li class="mt-3">
                        <a href="{{ route('services') }}"
                           class="text-decoration-none"
                           style="color:#F67723; font-size:13px; font-weight:500;">
                            View all services →
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Quick Links --}}
            <div class="col-6 col-md-3">
                <h4 class="text-uppercase fw-semibold mb-3"
                    style="font-size:12px; letter-spacing:0.08em; color:#64748b;">Quick Links</h4>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="{{ route('home') }}" class="text-decoration-none footer-link" style="color:#cbd5e1; font-size:14px;">Home</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('shop') }}" class="text-decoration-none footer-link" style="color:#cbd5e1; font-size:14px;">Shop</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('for-partners') }}" class="text-decoration-none footer-link" style="color:#cbd5e1; font-size:14px;">For Partners</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('request-service') }}" class="text-decoration-none footer-link" style="color:#cbd5e1; font-size:14px;">Request a Service</a>
                    </li>
                    <li class="mb-0">
                        <a href="{{ route('services') }}" class="text-decoration-none footer-link" style="color:#cbd5e1; font-size:14px;">All Services</a>
                    </li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="col-12 col-md-3">
                <h4 class="text-uppercase fw-semibold mb-3"
                    style="font-size:12px; letter-spacing:0.08em; color:#64748b;">Contact</h4>
                <ul class="list-unstyled mb-0">
                    <li class="mb-3 d-flex align-items-center gap-2">
                        <span style="width:28px; height:28px; border-radius:50%; background:rgba(246,119,35,0.12); display:inline-flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="bi bi-telephone-fill" style="color:#F67723; font-size:0.7rem;"></i>
                        </span>
                        <a href="tel:+250789078690891" class="text-decoration-none footer-link" style="color:#cbd5e1; font-size:14px;">
                            +250 789 078 690 891
                        </a>
                    </li>
                    <li class="mb-3 d-flex align-items-center gap-2">
                        <span style="width:28px; height:28px; border-radius:50%; background:rgba(246,119,35,0.12); display:inline-flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="bi bi-envelope-fill" style="color:#F67723; font-size:0.7rem;"></i>
                        </span>
                        <a href="mailto:info@trescahub.com" class="text-decoration-none footer-link" style="color:#cbd5e1; font-size:14px;">
                            info@trescahub.com
                        </a>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <span style="width:28px; height:28px; border-radius:50%; background:rgba(246,119,35,0.12); display:inline-flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="bi bi-geo-alt-fill" style="color:#F67723; font-size:0.7rem;"></i>
                        </span>
                        <span style="color:#cbd5e1; font-size:14px;">Kigali, Rwanda</span>
                    </li>
                </ul>
            </div>

        </div>

        {{-- Bottom Bar --}}
        <div class="mt-5 pt-4 text-center" style="border-top:1px solid rgba(255,255,255,0.07);">
            <p class="mb-2" style="font-size:12px; color:#475569;">
                TRESCA Hub is not a separate registered company. It is a services coordination
                and ordering platform operated under the TRESCA GROUP umbrella.
            </p>
            <p class="mb-0" style="font-size:12px; color:#475569;">
                © {{ date('Y') }} TRESCA GROUP. All rights reserved.
            </p>
        </div>

    </div>

    {{-- Spacer for mobile bottom nav --}}
    <div class="d-xl-none" style="height: 64px;"></div>
</footer>

<style>
    .footer-link:hover { color: #F67723 !important; }
</style>