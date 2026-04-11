@extends('front.layouts.guest')

@section('title', 'Request a Service')

@section('content')

<main class="py-5 py-md-6">
    <div class="container" style="max-width: 720px;">

        {{-- Success State --}}
        @if(session('success'))
        <div class="text-center py-5">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4"
                 style="width:80px;height:80px;background:rgba(22,163,74,0.1);">
                <i class="bi bi-check-circle-fill" style="font-size:2.5rem;color:#16a34a;"></i>
            </div>
            <h1 class="fw-bold mb-2" style="font-family:'Space Grotesk',sans-serif;font-size:2rem;">
                Request Submitted!
            </h1>
            <p class="text-muted mb-4">We'll get back to you within 24 hours.</p>
            <a href="{{ route('request-service') }}" class="btn btn-success px-5">
                Submit Another
            </a>
        </div>

        @else

        {{-- Header --}}
        <h1 class="fw-bold mb-2" style="font-family:'Space Grotesk',sans-serif;font-size:clamp(1.75rem,4vw,2.25rem);">
            Request a Service
        </h1>
        <p class="text-muted mb-5" style="font-size:1rem;max-width:560px;">
            Can't find what you need in our marketplace? Describe your requirements and we'll create a custom package for you.
        </p>

        {{-- Errors --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="bi bi-exclamation-circle me-2"></i>
                <strong>Please fix the following:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('request-service.store') }}" method="POST" enctype="multipart/form-data"
              class="rounded-4 border p-4 p-md-5"
              style="border-color:#e5e7eb;background:#fff;box-shadow:0 2px 16px rgba(0,0,0,0.06);">
            @csrf

            {{-- Name + Phone --}}
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6">
                    <label for="name" class="form-label fw-semibold">
                        Full Name <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Your full name"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-sm-6">
                    <label for="phone" class="form-label fw-semibold">
                        Phone <span class="text-danger">*</span>
                    </label>
                    <input type="tel"
                           id="phone"
                           name="phone"
                           value="{{ old('phone') }}"
                           class="form-control @error('phone') is-invalid @enderror"
                           placeholder="+250 7XX XXX XXX"
                           required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="you@example.com">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Service Category --}}
            <div class="mb-4">
                <label for="service_category" class="form-label fw-semibold">Service Category</label>
                <select id="service_category"
                        name="service_category"
                        class="form-select @error('service_category') is-invalid @enderror">
                    <option value="" disabled {{ old('service_category') ? '' : 'selected' }}>Select a category</option>
                    <option value="Engineering & Technical"     {{ old('service_category') == 'Engineering & Technical'     ? 'selected' : '' }}>Engineering & Technical</option>
                    <option value="Graphic Design & Media"     {{ old('service_category') == 'Graphic Design & Media'     ? 'selected' : '' }}>Graphic Design & Media</option>
                    <option value="Construction & Works"       {{ old('service_category') == 'Construction & Works'       ? 'selected' : '' }}>Construction & Works</option>
                    <option value="Online Shopping & Supplies" {{ old('service_category') == 'Online Shopping & Supplies' ? 'selected' : '' }}>Online Shopping & Supplies</option>
                    <option value="Refreshments & Events"      {{ old('service_category') == 'Refreshments & Events'      ? 'selected' : '' }}>Refreshments & Events</option>
                    <option value="Other"                      {{ old('service_category') == 'Other'                      ? 'selected' : '' }}>Other</option>
                </select>
                @error('service_category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label for="description" class="form-label fw-semibold">
                    Describe Your Requirements <span class="text-danger">*</span>
                </label>
                <textarea id="description"
                          name="description"
                          class="form-control @error('description') is-invalid @enderror"
                          rows="5"
                          placeholder="Tell us exactly what you need, any specific details, materials, or specifications..."
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Budget + Timeline --}}
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6">
                    <label for="budget" class="form-label fw-semibold">Budget Range</label>
                    <input type="text"
                           id="budget"
                           name="budget"
                           value="{{ old('budget') }}"
                           class="form-control @error('budget') is-invalid @enderror"
                           placeholder="e.g. 100,000 – 500,000 RWF">
                    @error('budget')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-sm-6">
                    <label for="timeline" class="form-label fw-semibold">Preferred Timeline</label>
                    <input type="text"
                           id="timeline"
                           name="timeline"
                           value="{{ old('timeline') }}"
                           class="form-control @error('timeline') is-invalid @enderror"
                           placeholder="e.g. Within 2 weeks">
                    @error('timeline')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- File Upload --}}
            <div class="mb-5">
                <label for="files" class="form-label fw-semibold">
                    Attach Files <span class="text-muted fw-normal">(optional)</span>
                </label>
                <input type="file"
                       id="files"
                       name="files[]"
                       multiple
                       class="form-control @error('files.*') is-invalid @enderror"
                       style="cursor:pointer;">
                <div class="form-text">You can attach images, PDFs, or documents up to 5MB each.</div>
                @error('files.*')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="btn btn-success w-100 fw-semibold py-3"
                    style="font-size:1rem;letter-spacing:0.02em;">
                <i class="bi bi-send me-2"></i> Submit Request
            </button>

        </form>
        @endif

    </div>
</main>

@endsection