@extends('front.layouts.admin')
@section('content')

<div class="container py-5">

    {{-- Header --}}
    <div class="mb-5">
        <a href="{{ route('partners.index') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none text-muted mb-3">
            <i class="bi bi-arrow-left"></i>
            Back to Partners
        </a>
        <h1 class="fw-bold mb-2">Edit Partner</h1>
        <p class="text-muted">Update partner information</p>
    </div>

    {{-- Form --}}
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card border shadow-sm">
                <div class="card-body p-4">

                    <form action="{{ route('partners.update', $partner) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

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
                                   value="{{ old('title', $partner->title) }}"
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
                                      required>{{ old('description', $partner->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                Provide a detailed description of the partner and their services
                            </small>
                        </div>

                        {{-- Slug Display --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Current Slug</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-link-45deg"></i>
                                </span>
                                <input type="text" class="form-control bg-light" value="{{ $partner->slug }}" disabled>
                            </div>
                            <small class="text-muted d-block mt-2">
                                The slug is auto-generated from the title and is used in URLs
                            </small>
                        </div>

                        {{-- Timestamps --}}
                        <div class="row mb-4">
                            <div class="col-6">
                                <small class="text-muted d-block">
                                    <strong>Created:</strong> {{ $partner->created_at->format('M d, Y H:i') }}
                                </small>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">
                                    <strong>Updated:</strong> {{ $partner->updated_at->format('M d, Y H:i') }}
                                </small>
                            </div>
                        </div>

                        {{-- Form Actions --}}
                        <div class="d-flex gap-3 pt-3 border-top">
                            <button type="submit" class="btn btn-primary gap-2">
                                <i class="bi bi-check-lg"></i>
                                Update Partner
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
                    <h5 class="fw-bold mb-3">Info</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="bi bi-check text-success"></i>
                            <strong>Changes Saved:</strong> Your updates will be saved immediately
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check text-success"></i>
                            <strong>Auto Slug Update:</strong> Slug updates when you change the title
                        </li>
                        <li>
                            <i class="bi bi-check text-success"></i>
                            <strong>Full History:</strong> All changes are tracked with timestamps
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection