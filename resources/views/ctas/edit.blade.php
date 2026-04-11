@extends('front.layouts.admin')
@section('content')

<div class="container py-4" style="max-width: 760px;">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('ctas.index') }}" class="btn btn-sm btn-outline-secondary">← Back</a>
        <h1 class="fw-bold mb-0 fs-4">Edit CTA</h1>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('ctas.update', $cta) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Category select ──────────────────────────────────── --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">CTA Category</h5>
                <div>
                    <label class="form-label fw-semibold">Select Category <span class="text-danger">*</span></label>
                    <select name="cta_category_title"
                            class="form-select @error('cta_category_title') is-invalid @enderror"
                            required>
                        <option value="">-- Choose a category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->title }}"
                                {{ (old('cta_category_title', $cta->cta_category_title) === $cat->title) ? 'selected' : '' }}>
                                {{ $cat->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('cta_category_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Items array ──────────────────────────────────────── --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold mb-0">Items</h5>
                    <button type="button"
                            class="btn btn-sm btn-outline-success"
                            onclick="addCtaItem()">
                        + Add Item
                    </button>
                </div>

                <div id="ctaItemsContainer">
                    @php
                        $existingItems = old('items', $cta->items ?? []);
                    @endphp

                    @forelse($existingItems as $i => $item)
                        <div class="cta-item border rounded-3 p-3 mb-3 position-relative">
                            <button type="button"
                                    class="btn btn-sm btn-outline-danger position-absolute"
                                    style="top: 10px; right: 10px;"
                                    onclick="removeCtaItem(this)">✕</button>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Title <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="items[{{ $i }}][title]"
                                       value="{{ $item['title'] ?? '' }}"
                                       class="form-control @error('items.'.$i.'.title') is-invalid @enderror"
                                       placeholder="Item title"
                                       required>
                                @error('items.'.$i.'.title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label fw-semibold small">Description</label>
                                <textarea name="items[{{ $i }}][description]"
                                          class="form-control"
                                          rows="2"
                                          placeholder="Item description (optional)">{{ $item['description'] ?? '' }}</textarea>
                            </div>
                        </div>
                    @empty
                        {{-- Empty fallback --}}
                        <div class="cta-item border rounded-3 p-3 mb-3 position-relative">
                            <button type="button"
                                    class="btn btn-sm btn-outline-danger position-absolute"
                                    style="top: 10px; right: 10px;"
                                    onclick="removeCtaItem(this)">✕</button>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Title <span class="text-danger">*</span></label>
                                <input type="text" name="items[0][title]" class="form-control" placeholder="Item title" required>
                            </div>
                            <div>
                                <label class="form-label fw-semibold small">Description</label>
                                <textarea name="items[0][description]" class="form-control" rows="2" placeholder="Item description (optional)"></textarea>
                            </div>
                        </div>
                    @endforelse
                </div>

                <p class="text-muted small mb-0">Each item has a title and optional description.</p>
            </div>
        </div>

        {{-- Submit ───────────────────────────────────────────── --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success px-4 fw-semibold">
                Update CTA
            </button>
            <a href="{{ route('ctas.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
        </div>

    </form>
</div>

<script>
    let ctaItemIndex = {{ count(old('items', $cta->items ?? [])) }};

    function addCtaItem() {
        const container = document.getElementById('ctaItemsContainer');
        const div = document.createElement('div');
        div.className = 'cta-item border rounded-3 p-3 mb-3 position-relative';
        div.innerHTML = `
            <button type="button"
                    class="btn btn-sm btn-outline-danger position-absolute"
                    style="top:10px;right:10px;"
                    onclick="removeCtaItem(this)">✕</button>
            <div class="mb-3">
                <label class="form-label fw-semibold small">Title <span class="text-danger">*</span></label>
                <input type="text"
                       name="items[${ctaItemIndex}][title]"
                       class="form-control"
                       placeholder="Item title"
                       required>
            </div>
            <div>
                <label class="form-label fw-semibold small">Description</label>
                <textarea name="items[${ctaItemIndex}][description]"
                          class="form-control"
                          rows="2"
                          placeholder="Item description (optional)"></textarea>
            </div>
        `;
        container.appendChild(div);
        ctaItemIndex++;
    }

    function removeCtaItem(btn) {
        const item = btn.closest('.cta-item');
        const allItems = document.querySelectorAll('.cta-item');
        if (allItems.length > 1) {
            item.remove();
        } else {
            alert('At least one item is required.');
        }
    }
</script>

@endsection