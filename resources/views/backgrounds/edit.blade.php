@extends('front.layouts.admin')

@section('title', 'Edit Background')
@section('page-title', 'Edit Background')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-pencil-square me-2 text-primary"></i>Edit Background
    </h4>
    <a href="{{ route('backgrounds.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

@php
    // Safely resolve fields whether stored as array or plain string
    $bgTitle      = is_array($background->title)       ? ($background->title[0]       ?? '') : ($background->title       ?? '');
    $bgDesc       = is_array($background->description) ? ($background->description[0] ?? '') : ($background->description ?? '');
    $bgThumbnail  = is_array($background->thumbnail)   ? ($background->thumbnail[0]   ?? '') : ($background->thumbnail   ?? '');
    $bgGoTo       = is_array($background->go_to)       ? ($background->go_to[0]       ?? '') : ($background->go_to       ?? '');
    $bgButtonText = is_array($background->button_text) ? ($background->button_text[0] ?? '') : ($background->button_text ?? '');
@endphp

<div class="dash-card">
    <div class="card-body p-4">
        <form action="{{ route('backgrounds.update', $background) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">

                {{-- Title --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="titleInput"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $bgTitle) }}"
                           placeholder="e.g. Our Company Story"
                           required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Slug --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Slug
                        <span class="text-muted fw-normal small">(auto-generated if empty)</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text text-muted">/</span>
                        <input type="text" name="slug" id="slugInput"
                               class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug', $background->slug) }}"
                               placeholder="e.g. our-company-story">
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Description --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" rows="4"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Describe this background…">{{ old('description', $bgDesc) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Thumbnail --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Thumbnail Image</label>

                    @if(!empty($bgThumbnail))
                        <div class="mb-2">
                            <img src="{{ asset('public/' . $bgThumbnail) }}"
                                 alt="{{ $bgTitle }}"
                                 class="rounded"
                                 style="width:120px;height:80px;object-fit:cover;">
                            <small class="text-muted d-block mt-1">Current thumbnail</small>
                        </div>
                    @endif

                    <input type="file" name="thumbnail" accept="image/*"
                           class="form-control @error('thumbnail') is-invalid @enderror"
                           id="thumbnailInput">
                    <small class="text-muted">Upload new image to replace</small>
                    @error('thumbnail')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="mt-2" id="thumbnailPreview"></div>
                </div>

                {{-- Go To --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Go To
                        <span class="text-muted fw-normal small">(text, link, or URL)</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                        <input type="text" name="go_to"
                               class="form-control @error('go_to') is-invalid @enderror"
                               value="{{ old('go_to', $bgGoTo) }}"
                               placeholder="e.g. /about, about-us, or https://example.com">
                        @error('go_to')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Button Text --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Button Text</label>
                    <input type="text" name="button_text"
                           class="form-control @error('button_text') is-invalid @enderror"
                           value="{{ old('button_text', $bgButtonText) }}"
                           placeholder="e.g. Learn More">
                    @error('button_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

            </div>

            {{-- Timestamps --}}
            <div class="alert alert-light mt-4 mb-4">
                <small class="text-muted">
                    <strong>Created:</strong> {{ $background->created_at->format('M d, Y H:i') }} |
                    <strong>Updated:</strong> {{ $background->updated_at->format('M d, Y H:i') }}
                </small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i> Update Background
                </button>
                <a href="{{ route('backgrounds.index') }}" class="btn btn-outline-secondary px-4">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('titleInput').addEventListener('input', function () {
        const slug = this.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        const slugInput = document.getElementById('slugInput');
        if (!slugInput.dataset.manual) {
            slugInput.value = slug;
        }
    });

    document.getElementById('slugInput').addEventListener('input', function () {
        this.dataset.manual = 'true';
    });

    document.getElementById('thumbnailInput').addEventListener('change', function () {
        const preview = document.getElementById('thumbnailPreview');
        preview.innerHTML = '';
        if (this.files[0]) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(this.files[0]);
            img.className = 'rounded';
            img.style = 'width:120px;height:80px;object-fit:cover;';
            preview.appendChild(img);
        }
    });
</script>
@endpush