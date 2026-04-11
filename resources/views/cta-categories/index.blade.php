@extends('front.layouts.admin')

@section('title', 'CTA Categories')
@section('page-title', 'CTA Categories')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="fw-bold mb-1 fs-4">CTA Categories</h1>
        <p class="text-muted mb-0 small">Manage CTA category list</p>
    </div>
    <a href="{{ route('cta-categories.create') }}" class="btn btn-success px-4 fw-semibold">
        <i class="bi bi-plus-lg me-1"></i> New Category
    </a>
</div>

{{-- Flash --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Table Card --}}
<div class="dash-card">
    @if($categories->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f9fafb; border-bottom: 1px solid #e5e7eb;">
                    <tr>
                        <th class="px-4 py-3 text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">#</th>
                        <th class="px-4 py-3 text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Title</th>
                        <th class="px-4 py-3 text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Slug</th>
                        <th class="px-4 py-3 text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Description</th>
                        <th class="px-4 py-3 text-muted fw-semibold text-center" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">CTAs</th>
                        <th class="px-4 py-3 text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Created</th>
                        <th class="px-4 py-3 text-muted fw-semibold text-end" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr style="border-bottom: 1px solid #f3f4f6;">

                            {{-- # --}}
                            <td class="px-4 py-3 text-muted small">
                                {{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}
                            </td>

                            {{-- Title --}}
                            <td class="px-4 py-3">
                                <span class="fw-semibold" style="color:#111827; font-size:0.925rem;">
                                    {{ $category->title }}
                                </span>
                            </td>

                            {{-- Slug --}}
                            <td class="px-4 py-3">
                                <code class="px-2 py-1 rounded" style="background:#f3f4f6; color:#6b7280; font-size:0.8rem;">
                                    {{ $category->slug }}
                                </code>
                            </td>

                            {{-- Description --}}
                            <td class="px-4 py-3 text-muted small" style="max-width:260px;">
                                @if($category->description)
                                    <span style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                        {{ $category->description }}
                                    </span>
                                @else
                                    <span class="text-muted fst-italic">—</span>
                                @endif
                            </td>

                            {{-- CTAs count --}}
                            <td class="px-4 py-3 text-center">
                                <span class="badge rounded-pill"
                                      style="background:rgba(22,163,74,0.1);color:#16a34a;font-size:0.75rem;padding:4px 10px;">
                                    {{ $category->ctas_count }}
                                </span>
                            </td>

                            {{-- Created --}}
                            <td class="px-4 py-3 text-muted small">
                                {{ $category->created_at->format('M d, Y') }}
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-3 text-end">
                                <div class="d-flex align-items-center justify-content-end gap-2">
                                    <a href="{{ route('cta-categories.edit', $category) }}"
                                       class="btn btn-sm btn-outline-secondary px-3"
                                       style="font-size:0.8rem;">
                                        <i class="bi bi-pencil me-1"></i> Edit
                                    </a>

                                    <form action="{{ route('cta-categories.destroy', $category) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete \'{{ addslashes($category->title) }}\'? This will also delete all its CTAs.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger px-3"
                                                style="font-size:0.8rem;">
                                            <i class="bi bi-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($categories->hasPages())
            <div class="px-4 py-3 border-top">
                {{ $categories->links() }}
            </div>
        @endif

    @else
        <div class="text-center py-5">
            <i class="bi bi-megaphone" style="font-size:3rem;color:#d1d5db;"></i>
            <p class="mt-3 text-muted">No CTA categories yet.</p>
            <a href="{{ route('cta-categories.create') }}" class="btn btn-success px-4">
                <i class="bi bi-plus-lg me-1"></i> Create First Category
            </a>
        </div>
    @endif
</div>

@endsection