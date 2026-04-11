@extends('front.layouts.admin')

@section('title', 'Add Background')
@section('page-title', 'Add Background')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-plus-circle-fill me-2 text-primary"></i>Add Backgrounds
    </h4>
    <a href="{{ route('backgrounds.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

<div class="dash-card">
    <div class="card-body p-4">
        <form action="{{ route('backgrounds.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="slides-wrapper">

                {{-- Slide Row Template --}}
                <div class="slide-row border rounded p-4 mb-4 position-relative" data-index="0">
                    <h6 class="fw-bold mb-3 text-primary">Slide #1</h6>

                    <button type="button" class="btn btn-sm btn-outline-danger position-absolute remove-slide"
                            style="top:12px;right:12px;display:none;">
                        <i class="bi bi-trash"></i> Remove
                    </button>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="slides[0][title]"
                                   class="form-control title-input"
                                   placeholder="e.g. Our Company Story" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Slug <span class="text-muted fw-normal small">(auto)</span></label>
                            <div class="input-group">
                                <span class="input-group-text text-muted">/</span>
                                <input type="text" name="slides[0][slug]"
                                       class="form-control slug-input"
                                       placeholder="auto-generated">
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="slides[0][description]" rows="3"
                                      class="form-control"
                                      placeholder="Describe this slide…"></textarea>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Thumbnail Image</label>
                            <input type="file" name="slides[0][thumbnail]" accept="image/*"
                                   class="form-control thumbnail-input">
                            <div class="mt-2 thumbnail-preview"></div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Go To</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                                <input type="text" name="slides[0][go_to]"
                                       class="form-control"
                                       placeholder="e.g. shop or https://example.com">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Button Text</label>
                            <input type="text" name="slides[0][button_text]"
                                   class="form-control"
                                   placeholder="e.g. Learn More">
                        </div>

                    </div>
                </div>

            </div>

            {{-- Add Slide Button --}}
            <div class="mb-4">
                <button type="button" id="addSlideBtn" class="btn btn-outline-primary">
                    <i class="bi bi-plus-lg me-1"></i> Add Another Slide
                </button>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i> Save All Slides
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
    let slideIndex = 1;

    document.getElementById('addSlideBtn').addEventListener('click', function () {
        const wrapper = document.getElementById('slides-wrapper');
        const newSlide = document.querySelector('.slide-row').cloneNode(true);

        // Update index
        newSlide.dataset.index = slideIndex;
        newSlide.querySelector('h6').textContent = 'Slide #' + (slideIndex + 1);

        // Clear values and update names
        newSlide.querySelectorAll('input, textarea').forEach(el => {
            el.value = '';
            el.name = el.name.replace(/\[\d+\]/, '[' + slideIndex + ']');
        });

        // Clear preview
        newSlide.querySelector('.thumbnail-preview').innerHTML = '';

        // Show remove button
        newSlide.querySelector('.remove-slide').style.display = 'inline-block';

        wrapper.appendChild(newSlide);
        slideIndex++;

        // Bind events to new slide
        bindSlideEvents(newSlide);
    });

    function bindSlideEvents(slide) {
        // Auto slug
        slide.querySelector('.title-input').addEventListener('input', function () {
            const slugInput = slide.querySelector('.slug-input');
            if (!slugInput.dataset.manual) {
                slugInput.value = this.value
                    .toLowerCase().trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            }
        });

        slide.querySelector('.slug-input').addEventListener('input', function () {
            this.dataset.manual = 'true';
        });

        // Thumbnail preview
        slide.querySelector('.thumbnail-input').addEventListener('change', function () {
            const preview = slide.querySelector('.thumbnail-preview');
            preview.innerHTML = '';
            if (this.files[0]) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(this.files[0]);
                img.className = 'rounded';
                img.style = 'width:120px;height:80px;object-fit:cover;';
                preview.appendChild(img);
            }
        });

        // Remove slide
        slide.querySelector('.remove-slide').addEventListener('click', function () {
            slide.remove();
            // Renumber slides
            document.querySelectorAll('.slide-row').forEach((s, i) => {
                s.querySelector('h6').textContent = 'Slide #' + (i + 1);
            });
        });
    }

    // Bind to first slide
    bindSlideEvents(document.querySelector('.slide-row'));
</script>
@endpush