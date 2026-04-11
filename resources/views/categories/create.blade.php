@extends('front.layouts.admin')

@section('title', 'Create Category')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0"><i class="bi bi-plus-circle-fill me-2 text-primary"></i>Create Category</h4>
    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="row g-3">

                {{-- Title --}}
                <div class="col-md-6">
                    <label for="title" class="form-label fw-semibold">
                        Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" id="title" name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}" placeholder="e.g. Electronics" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Slug --}}
                <div class="col-md-6">
                    <label for="slug" class="form-label fw-semibold">
                        Slug <small class="text-muted fw-normal">(auto-generated if blank)</small>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                        <input type="text" id="slug" name="slug"
                               class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug') }}" placeholder="e.g. electronics">
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Classification Name → plain text input, stored as array --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Classification <span class="text-danger">*</span>
                        <small class="text-muted fw-normal">(type &amp; press Add)</small>
                    </label>

                    <div class="input-group mb-2">
                        <input type="text" id="classification-input" class="form-control"
                               placeholder="e.g. Electronics">
                        <button type="button" class="btn btn-outline-primary" id="add-classification">
                            <i class="bi bi-plus-lg"></i> Add
                        </button>
                    </div>

                    {{-- Tags --}}
                    <div id="classification-tags" class="d-flex flex-wrap gap-2 mb-1"></div>

                    {{-- Hidden inputs submitted as classification_name[] --}}
                    <div id="classification-inputs"></div>

                    @error('classification_name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                    @error('classification_name.*')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Subcategories → plain text input, stored as array --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Subcategories <small class="text-muted fw-normal">(type &amp; press Add)</small>
                    </label>

                    <div class="input-group mb-2">
                        <input type="text" id="subcategory-input" class="form-control"
                               placeholder="e.g. Mobile Phones">
                        <button type="button" class="btn btn-outline-primary" id="add-subcategory">
                            <i class="bi bi-plus-lg"></i> Add
                        </button>
                    </div>

                    {{-- Tags --}}
                    <div id="subcategory-tags" class="d-flex flex-wrap gap-2 mb-1"></div>

                    {{-- Hidden inputs submitted as subcategory[] --}}
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
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Short description…">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

            </div>

            <hr class="my-4">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i> Save Category
                </button>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// ── Slug auto-generate ──────────────────────────────────────────────────────
const titleInput = document.getElementById('title');
const slugInput  = document.getElementById('slug');
titleInput.addEventListener('input', () => {
    if (slugInput.dataset.manual) return;
    slugInput.value = titleInput.value.toLowerCase().trim()
        .replace(/[^\w\s-]/g, '').replace(/[\s_]+/g, '-').replace(/^-+|-+$/g, '');
});
slugInput.addEventListener('input', () => {
    slugInput.dataset.manual = slugInput.value ? '1' : '';
});

// ── Generic tag-list builder ────────────────────────────────────────────────
function makeTagManager({ inputId, addBtnId, tagsId, hiddenId, inputName }) {
    const inputEl  = document.getElementById(inputId);
    const addBtn   = document.getElementById(addBtnId);
    const tagsDiv  = document.getElementById(tagsId);
    const hiddenDiv = document.getElementById(hiddenId);
    const items    = []; // array of strings

    function render() {
        tagsDiv.innerHTML   = '';
        hiddenDiv.innerHTML = '';

        items.forEach((value, index) => {
            // Badge tag
            const badge = document.createElement('span');
            badge.className = 'badge bg-primary d-flex align-items-center gap-1 px-2 py-2';
            badge.innerHTML = `${value}
                <button type="button" class="btn-close btn-close-white ms-1"
                        style="font-size:.6rem" data-index="${index}"></button>`;
            badge.querySelector('.btn-close').addEventListener('click', () => {
                items.splice(index, 1);
                render();
            });
            tagsDiv.appendChild(badge);

            // Hidden input
            const inp = document.createElement('input');
            inp.type  = 'hidden';
            inp.name  = inputName;
            inp.value = value;
            hiddenDiv.appendChild(inp);
        });
    }

    function addItem() {
        const val = inputEl.value.trim();
        if (!val) return;
        if (items.includes(val)) {
            inputEl.classList.add('is-invalid');
            setTimeout(() => inputEl.classList.remove('is-invalid'), 1500);
            return;
        }
        items.push(val);
        inputEl.value = '';
        inputEl.focus();
        render();
    }

    addBtn.addEventListener('click', addItem);
    inputEl.addEventListener('keydown', e => {
        if (e.key === 'Enter') { e.preventDefault(); addItem(); }
    });

    return { items, render };
}

// ── Classification tag manager ──────────────────────────────────────────────
const classificationManager = makeTagManager({
    inputId:   'classification-input',
    addBtnId:  'add-classification',
    tagsId:    'classification-tags',
    hiddenId:  'classification-inputs',
    inputName: 'classification_name[]',
});

// ── Subcategory tag manager ─────────────────────────────────────────────────
const subcategoryManager = makeTagManager({
    inputId:   'subcategory-input',
    addBtnId:  'add-subcategory',
    tagsId:    'subcategory-tags',
    hiddenId:  'subcategory-inputs',
    inputName: 'subcategory[]',
});

// ── Restore old() values on validation error ────────────────────────────────
@if(old('classification_name'))
    @foreach(old('classification_name') as $val)
        classificationManager.items.push(@json($val));
    @endforeach
    classificationManager.render();
@endif

@if(old('subcategory'))
    @foreach(old('subcategory') as $val)
        subcategoryManager.items.push(@json($val));
    @endforeach
    subcategoryManager.render();
@endif
</script>
@endpush