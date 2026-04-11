@extends('front.layouts.admin')

@section('title', 'Create CTA Category')
@section('page-title', 'Create CTA Category')

@section('content')

<div style="max-width: 680px;">

    {{-- Header --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('cta-categories.index') }}"
           class="btn btn-sm btn-outline-secondary px-3">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        <div>
            <h1 class="fw-bold mb-0 fs-4">New CTA Category</h1>
            <p class="text-muted mb-0 small">Add a new category for your CTAs</p>
        </div>
    </div>

    {{-- Errors --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            <i class="bi bi-exclamation-circle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('cta-categories.store') }}" method="POST">
        @csrf

        <div class="dash-card p-4">

            {{-- Title --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">
                    Title <span class="text-danger">*</span>
                </label>
                <input type="text"
                       name="title"
                       id="titleInput"
                       value="{{ old('title') }}"
                       class="form-control @error('title') is-invalid @enderror"
                       placeholder="e.g. Hero Banners"
                       required
                       autofocus>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Title is used as a foreign key — must be unique.</div>
            </div>

            {{-- Slug --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Slug</label>
                <div class="input-group">
                    <span class="input-group-text text-muted" style="font-size:0.85rem;">/cta/</span>
                    <input type="text"
                           name="slug"
                           id="slugInput"
                           value="{{ old('slug') }}"
                           class="form-control @error('slug') is-invalid @enderror"
                           placeholder="auto-generated from title">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-text">Leave empty to auto-generate from title.</div>
            </div>

            {{-- Description --}}
            <div class="mb-2">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description"
                          class="form-control @error('description') is-invalid @enderror"
                          rows="3"
                          placeholder="Brief description of this CTA category (optional)">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>

        {{-- Submit --}}
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-success px-4 fw-semibold">
                <i class="bi bi-check-lg me-1"></i> Create Category
            </button>
            <a href="{{ route('cta-categories.index') }}" class="btn btn-outline-secondary px-4">
                Cancel
            </a>
        </div>

    </form>
</div>

@push('scripts')
<script>
    // Auto-generate slug from title
    const titleInput = document.getElementById('titleInput');
    const slugInput  = document.getElementById('slugInput');

    titleInput.addEventListener('input', function () {
        if (slugInput.dataset.manual) return;
        slugInput.value = this.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    });

    slugInput.addEventListener('input', function () {
        this.dataset.manual = this.value ? 'true' : '';
    });
</script>
@endpush

@endsection