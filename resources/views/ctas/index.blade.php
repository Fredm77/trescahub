@extends('front.layouts.admin')

@section('title', 'CTAs')
@section('page-title', 'CTAs')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="fw-bold mb-1 fs-4">CTAs</h1>
        <p class="text-muted mb-0 small">Manage your call-to-action items</p>
    </div>
    <a href="{{ route('ctas.create') }}" class="btn btn-success px-4 fw-semibold">
        <i class="bi bi-plus-lg me-1"></i> New CTA
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
    @if($ctas->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f9fafb; border-bottom: 1px solid #e5e7eb;">
                    <tr>
                        <th class="px-4 py-3 text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">#</th>
                        <th class="px-4 py-3 text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Category</th>
                        <th class="px-4 py-3 text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Items</th>
                        <th class="px-4 py-3 text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Preview</th>
                        <th class="px-4 py-3 text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Created</th>
                        <th class="px-4 py-3 text-muted fw-semibold text-end" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ctas as $cta)
                        <tr style="border-bottom: 1px solid #f3f4f6;">

                            {{-- # --}}
                            <td class="px-4 py-3 text-muted small">
                                {{ $loop->iteration + ($ctas->currentPage() - 1) * $ctas->perPage() }}
                            </td>

                            {{-- Category --}}
                            <td class="px-4 py-3">
                                <span class="badge rounded-pill fw-semibold"
                                      style="background:rgba(22,163,74,0.1);color:#16a34a;font-size:0.8rem;padding:5px 12px;">
                                    <i class="bi bi-megaphone me-1"></i>
                                    {{ $cta->cta_category_title }}
                                </span>
                            </td>

                            {{-- Items count --}}
                            <td class="px-4 py-3">
                                <span class="badge rounded-pill"
                                      style="background:#f3f4f6;color:#6b7280;font-size:0.75rem;padding:4px 10px;">
                                    {{ count($cta->items ?? []) }} item(s)
                                </span>
                            </td>

                            {{-- Preview first 2 item titles --}}
                            <td class="px-4 py-3" style="max-width:280px;">
                                @php $items = $cta->items ?? []; @endphp
                                @if(count($items) > 0)
                                    <div class="d-flex flex-column gap-1">
                                        @foreach(array_slice($items, 0, 2) as $item)
                                            <span class="small" style="color:#374151;">
                                                <i class="bi bi-dot text-success"></i>
                                                {{ $item['title'] ?? '—' }}
                                            </span>
                                        @endforeach
                                        @if(count($items) > 2)
                                            <span class="small text-muted fst-italic">
                                                +{{ count($items) - 2 }} more...
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted fst-italic small">No items</span>
                                @endif
                            </td>

                            {{-- Created --}}
                            <td class="px-4 py-3 text-muted small">
                                {{ $cta->created_at->format('M d, Y') }}
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-3 text-end">
                                <div class="d-flex align-items-center justify-content-end gap-2">

                                    <a href="{{ route('ctas.edit', $cta) }}"
                                       class="btn btn-sm btn-outline-secondary px-3"
                                       style="font-size:0.8rem;">
                                        <i class="bi bi-pencil me-1"></i> Edit
                                    </a>

                                    <form action="{{ route('ctas.destroy', $cta) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this CTA? This cannot be undone.')">
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
        @if($ctas->hasPages())
            <div class="px-4 py-3 border-top">
                {{ $ctas->links() }}
            </div>
        @endif

    @else
        <div class="text-center py-5">
            <i class="bi bi-lightning-charge" style="font-size:3rem;color:#d1d5db;"></i>
            <p class="mt-3 text-muted">No CTAs yet.</p>
            <a href="{{ route('ctas.create') }}" class="btn btn-success px-4">
                <i class="bi bi-plus-lg me-1"></i> Create First CTA
            </a>
        </div>
    @endif
</div>

@endsection