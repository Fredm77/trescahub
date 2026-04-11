@extends('front.layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-pencil-square me-2 text-primary"></i>Edit Category
        <small class="text-muted fw-normal fs-6 ms-2">{{ $category->title }}</small>
    </h4>
    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                {{-- Title --}}
                <div class="col-md-6">
                    <label for="title" class="form-label fw-semibold">
                        Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" id="title" name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $category->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Slug --}}
                <div class="col-md-6">
                    <label for="slug" class="form-label fw-semibold">Slug</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                        <input type="text" id="slug" name="slug"
                               class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug', $category->slug) }}">
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-text">Clear to auto-regenerate from title on save.</div>
                </div>

                {{-- Classification → FK to services --}}
                <div class="col-md-6">
                    <label for="classification_name" class="form-label fw-semibold">
                        Classification <span class="text-danger">*</span>
                        <small class="text-muted fw-normal">(Service)</small>
                    </label>
                    <select id="classification_name" name="classification_name"
                            class="form-select @error('classification_name') is-invalid @enderror" required>
                        <option value="">— Select service —</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}"
                                {{ old('classification_name', $category->classification_name) == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('classification_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Subcategory → JSON array of service IDs --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Subcategories <small class="text-muted fw-normal">(FK → Services)</small>
                    </label>

                    <div class="input-group mb-2">
                        <select id="subcategory-select" class="form-select">
                            <option value="">— Select a service to add —</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" data-name="{{ $service->name }}">
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-outline-primary" id="add-subcategory">
                            <i class="bi bi-plus-lg"></i> Add
                        </button>
                    </div>

                    <div id="subcategory-tags" class="d-flex flex-wrap gap-2 mb-1"></div>
                    <div id="subcategory-inputs"></div>

                    @error('subcategory')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                    @error('subcategory.*')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="col-12">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea id="description" name="description" rows="4"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

            </div>

            <hr class="my-4">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i> Update Category
                </button>
                <a href="{{ route('categories.show', $category) }}" class="btn btn-outline-secondary px-4">Cancel</a>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ── Slug ───────────────────────────────────────────────────────────────
    const titleInput = document.getElementById('title');
    const slugInput  = document.getElementById('slug');
    titleInput.addEventListener('input', () => {
        if (slugInput.value === '') {
            slugInput.value = titleInput.value.toLowerCase().trim()
                .replace(/[^\w\s-]/g, '').replace(/[\s_]+/g, '-').replace(/^-+|-+$/g, '');
        }
    });

    // ── Subcategory tag manager ────────────────────────────────────────────
    const selected  = new Map();
    const tagsDiv   = document.getElementById('subcategory-tags');
    const inputsDiv = document.getElementById('subcategory-inputs');
    const addBtn    = document.getElementById('add-subcategory');
    const selectEl  = document.getElementById('subcategory-select');

    function renderTags() {
        tagsDiv.innerHTML   = '';
        inputsDiv.innerHTML = '';
        selected.forEach((name, id) => {
            const badge = document.createElement('span');
            badge.className = 'badge bg-primary d-flex align-items-center gap-1 px-2 py-2';
            badge.innerHTML = `${name}
                <button type="button" class="btn-close btn-close-white ms-1"
                        style="font-size:.6rem" data-id="${id}"></button>`;
            badge.querySelector('.btn-close').addEventListener('click', () => {
                selected.delete(id);
                renderTags();
            });
            tagsDiv.appendChild(badge);

            const inp = document.createElement('input');
            inp.type  = 'hidden';
            inp.name  = 'subcategory[]';
            inp.value = id;
            inputsDiv.appendChild(inp);
        });
    }

    addBtn.addEventListener('click', () => {
        const opt = selectEl.options[selectEl.selectedIndex];
        if (!opt.value) return;
        selected.set(opt.value, opt.dataset.name);
        selectEl.value = '';
        renderTags();
    });

    // Pre-fill existing subcategories (from DB or old())
    const existing = @json(old('subcategory', $selectedSubcategory));
    const services  = @json($services->pluck('name', 'id'));
    if (existing && existing.length) {
        existing.forEach(id => {
            const sid = String(id);
            if (services[sid]) selected.set(sid, services[sid]);
        });
        renderTags();
    }
</script>
@endpush