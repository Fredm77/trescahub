@php
    $approvedTestimonials = \App\Models\Testimonial::approved()->latest()->get();
@endphp

<section class="py-5 border-top" style="background-color:hsl(var(--muted));">
    <div class="container-xl px-4 px-lg-5">

        {{-- Header --}}
        <div class="text-center mb-2">
            <h2 class="fw-bold mb-2"
                style="font-family:'Space Grotesk',sans-serif;font-size:clamp(1.75rem,4vw,2.5rem);">
                What Our Clients Say
            </h2>
            <button type="button" onclick="openTestimonialModal()"
                    class="btn btn-sm px-4 fw-semibold mb-5"
                    style="background-color:#16a34a;color:#fff;border-radius:8px;">
                <i class="bi bi-plus-lg me-1"></i> Add Your Testimonial
            </button>
        </div>

        {{-- Success message --}}
        @if(session('testimonial_success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('testimonial_success') }}
                <button type="button" class="btn-close" onclick="this.closest('.alert').remove()"></button>
            </div>
        @endif

        {{-- Testimonials Grid --}}
        @if($approvedTestimonials->count() > 0)
            <div class="row g-4 row-cols-1 row-cols-md-3">
                @foreach($approvedTestimonials as $testimonial)
                    <div class="col">
                        <div class="rounded-3 border p-4 h-100"
                             style="border-color:hsl(var(--border));background:hsl(var(--card));box-shadow:var(--shadow-card);">

                            {{-- Quote --}}
                            <p class="fst-italic text-muted small mb-4">"{{ $testimonial->description }}"</p>

                            {{-- Name & Position --}}
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
                                     style="width:36px;height:36px;background-color:#16a34a;font-size:13px;">
                                    {{ $testimonial->initial }}
                                </div>
                                <div>
                                    <p class="fw-semibold mb-0" style="font-size:14px;">{{ $testimonial->name }}</p>
                                    <p class="text-muted mb-0" style="font-size:12px;">{{ $testimonial->position }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-chat-quote fs-1 d-block mb-3 opacity-25"></i>
                <p>No testimonials yet. Be the first to share your experience!</p>
            </div>
        @endif

    </div>
</section>

{{-- ── Pure CSS/JS Modal ──────────────────────── --}}
<div id="tModal" onclick="if(event.target===this)closeTestimonialModal()"
     style="display:none;position:fixed;inset:0;z-index:99999;
            background:rgba(0,0,0,.55);align-items:center;justify-content:center;padding:1rem;">
    <div style="background:#fff;border-radius:16px;width:100%;max-width:520px;
                max-height:90vh;overflow-y:auto;box-shadow:0 25px 60px rgba(0,0,0,.2);
                animation:tSlideIn .25s ease;">

        {{-- Modal Header --}}
        <div style="padding:1.25rem 1.5rem .75rem;border-bottom:1px solid #f0f0f0;
                    display:flex;align-items:center;justify-content:space-between;">
            <h5 class="fw-bold mb-0" style="font-size:1rem;">
                <i class="bi bi-chat-quote-fill me-2" style="color:#16a34a;"></i>Share Your Experience
            </h5>
            <button onclick="closeTestimonialModal()" type="button"
                    style="background:none;border:none;font-size:1.25rem;cursor:pointer;
                           color:#6b7280;line-height:1;padding:0;">&times;</button>
        </div>

        {{-- Modal Body --}}
        <div style="padding:1.25rem 1.5rem 1.5rem;">
            <p class="text-muted small mb-4">Your testimonial will be reviewed before being published.</p>

            <form action="{{ route('testimonials.store') }}" method="POST">
                @csrf
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                               class="form-control form-control-sm @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="e.g. Jean-Pierre K." required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Position / Role <span class="text-danger">*</span></label>
                        <input type="text" name="position"
                               class="form-control form-control-sm @error('position') is-invalid @enderror"
                               value="{{ old('position') }}" placeholder="e.g. Property Developer" required>
                        @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email"
                               class="form-control form-control-sm @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="your@email.com" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" name="phone_number"
                               class="form-control form-control-sm @error('phone_number') is-invalid @enderror"
                               value="{{ old('phone_number') }}" placeholder="+250 7XX XXX XXX" required>
                        @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold small">Your Testimonial <span class="text-danger">*</span></label>
                        <textarea name="description" rows="4"
                                  class="form-control form-control-sm @error('description') is-invalid @enderror"
                                  placeholder="Share your experience with TRESCA Hub…" required>{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-sm px-4 fw-semibold flex-grow-1"
                            style="background-color:#16a34a;color:#fff;">
                        <i class="bi bi-send me-1"></i> Submit Testimonial
                    </button>
                    <button type="button" onclick="closeTestimonialModal()"
                            class="btn btn-sm btn-outline-secondary px-3">
                        Cancel
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<style>
    @keyframes tSlideIn {
        from { opacity: 0; transform: translateY(-20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    function openTestimonialModal() {
        var m = document.getElementById('tModal');
        m.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeTestimonialModal() {
        var m = document.getElementById('tModal');
        m.style.display = 'none';
        document.body.style.overflow = '';
    }

    @if($errors->any() && old('description'))
        document.addEventListener('DOMContentLoaded', function() {
            openTestimonialModal();
        });
    @endif
</script>