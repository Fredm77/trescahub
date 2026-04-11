@extends('front.layouts.admin')
@section('content')

<div class="container py-4">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <h1 class="h3 mb-4">Create Shop Category</h1>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('shop-categories.store') }}" method="POST">
                        @csrf

                        {{-- Parent Slug --}}
                        <div class="mb-4">
                            <label for="slug" class="form-label fw-bold">Parent Category Slug *</label>
                            <input type="text"
                                   class="form-control @error('slug') is-invalid @enderror"
                                   id="slug"
                                   name="slug"
                                   value="{{ old('slug') }}"
                                   placeholder="e.g., electronics"
                                   required>
                            <small class="text-muted">This will be the unique identifier for the parent category</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Subcategories --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Subcategories
                                <span class="text-muted fw-normal">(Quick-add children)</span>
                            </label>

                            <div id="subcategories-container">
                                {{-- Row 0 --}}
                                <div class="subcategory-row border rounded p-2 mb-2">
                                    <div class="mb-2">
                                        <input type="text"
                                               class="form-control sub-name"
                                               name="subcategories[0][name]"
                                               placeholder="Subcategory name e.g., Laptops"
                                               value="{{ old('subcategories.0.name') }}"
                                               oninput="syncSlug(this)">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text text-muted" style="font-size:.8rem;">slug</span>
                                        <input type="text"
                                               class="form-control sub-slug"
                                               name="subcategories[0][slug]"
                                               placeholder="Auto-generated"
                                               value="{{ old('subcategories.0.slug') }}">
                                        <button type="button" class="btn btn-outline-danger" onclick="removeSubcategory(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addSubcategory()">
                                + Add Subcategory
                            </button>
                            <div class="form-text text-muted mt-1">
                                Slugs are auto-generated from the subcategory name.
                            </div>
                        </div>

                        {{-- Active --}}
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="active"
                                       name="active"
                                       value="1"
                                       {{ old('active', '1') ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">Active</label>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Create Category</button>
                            <a href="{{ route('shop-categories.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toSlug(value) {
        return value
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    }

    function syncSlug(nameInput) {
        const row       = nameInput.closest('.subcategory-row');
        const slugInput = row.querySelector('.sub-slug');
        slugInput.value = toSlug(nameInput.value);
    }

    let rowIndex = 1;

    function addSubcategory() {
        const container = document.getElementById('subcategories-container');
        const row       = document.createElement('div');
        row.className   = 'subcategory-row border rounded p-2 mb-2';
        row.innerHTML   = `
            <div class="mb-2">
                <input type="text"
                       class="form-control sub-name"
                       name="subcategories[${rowIndex}][name]"
                       placeholder="Subcategory name e.g., Laptops"
                       oninput="syncSlug(this)">
            </div>
            <div class="input-group">
                <span class="input-group-text text-muted" style="font-size:.8rem;">slug</span>
                <input type="text"
                       class="form-control sub-slug"
                       name="subcategories[${rowIndex}][slug]"
                       placeholder="Auto-generated">
                <button type="button" class="btn btn-outline-danger" onclick="removeSubcategory(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
        row.querySelector('.sub-name').focus();
        rowIndex++;
    }

    function removeSubcategory(button) {
        const container = document.getElementById('subcategories-container');
        if (container.children.length > 1) {
            button.closest('.subcategory-row').remove();
        } else {
            container.querySelectorAll('input').forEach(i => i.value = '');
        }
    }
</script>

@endsection