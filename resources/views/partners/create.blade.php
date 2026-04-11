@extends('front.layouts.admin')
@section('content')

<div class="container py-5">

    {{-- Header --}}
    <div class="mb-5">
        <a href="{{ route('partners.index') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none text-muted mb-3">
            <i class="bi bi-arrow-left"></i>
            Back to Partners
        </a>
        <h1 class="fw-bold mb-2">Create Partner</h1>
        <p class="text-muted">Add a new partner to your system</p>
    </div>

    {{-- Form --}}
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card border shadow-sm">
                <div class="card-body p-4">

                    <form action="{{ route('partners.store') }}" method="POST" novalidate>
                        @csrf

                        {{-- Title --}}
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">
                                Title <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   id="title"
                                   name="title"
                                   placeholder="Enter partner title"
                                   value="{{ old('title') }}"
                                   required>
                            @error('title')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                E.g., "Tech Innovation Inc." or "Global Solutions Ltd."
                            </small>
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">
                                Description <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="6"
                                      placeholder="Enter partner description"
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                Provide a detailed description of the partner and their services
                            </small>
                        </div>

                        {{-- Slug Info --}}
                        <div class="alert alert-info" role="alert">
                            <i class="bi bi-info-circle"></i>
                            <strong>Note:</strong> The slug will be automatically generated from the title. You can also edit it later if needed.
                        </div>

                        {{-- Form Actions --}}
                        <div class="d-flex gap-3 pt-3">
                            <button type="submit" class="btn btn-primary gap-2">
                                <i class="bi bi-check-lg"></i>
                                Create Partner
                            </button>
                            <a href="{{ route('partners.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        {{-- Info Sidebar --}}
        <div class="col-12 col-lg-4">
            <div class="card border-0 bg-light">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Tips</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="bi bi-check text-success"></i>
                            <strong>Clear Title:</strong> Use a descriptive and clear title
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check text-success"></i>
                            <strong>Detailed Description:</strong> Include relevant information about the partnership
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check text-success"></i>
                            <strong>Auto Slug:</strong> Your slug will be created automatically from the title
                        </li>
                        <li>
                            <i class="bi bi-check text-success"></i>
                            <strong>Easy Editing:</strong> You can always edit or delete this partner later
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection