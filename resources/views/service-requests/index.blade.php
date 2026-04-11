@extends('front.layouts.admin')

@section('title', 'Service Requests')
@section('page-title', 'Service Requests')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="fw-bold mb-1 fs-4">Service Requests</h1>
        <p class="text-muted mb-0 small">Customer service requests submitted from the website</p>
    </div>
</div>

{{-- Flash --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Status Filter Tabs --}}
<div class="d-flex gap-2 mb-4 flex-wrap">
    <a href="{{ route('service-requests.index') }}"
       class="btn btn-sm {{ !request('status') ? 'btn-dark' : 'btn-outline-secondary' }} px-3">
        All
        <span class="badge ms-1 rounded-pill" style="background:rgba(255,255,255,0.25);">
            {{ $counts['all'] }}
        </span>
    </a>
    <a href="{{ route('service-requests.index', ['status' => 'pending']) }}"
       class="btn btn-sm {{ request('status') == 'pending' ? 'btn-warning text-dark' : 'btn-outline-warning' }} px-3">
        Pending
        <span class="badge ms-1 rounded-pill bg-warning text-dark">{{ $counts['pending'] }}</span>
    </a>
    <a href="{{ route('service-requests.index', ['status' => 'reviewed']) }}"
       class="btn btn-sm {{ request('status') == 'reviewed' ? 'btn-primary' : 'btn-outline-primary' }} px-3">
        Reviewed
        <span class="badge ms-1 rounded-pill bg-primary">{{ $counts['reviewed'] }}</span>
    </a>
    <a href="{{ route('service-requests.index', ['status' => 'completed']) }}"
       class="btn btn-sm {{ request('status') == 'completed' ? 'btn-success' : 'btn-outline-success' }} px-3">
        Completed
        <span class="badge ms-1 rounded-pill bg-success">{{ $counts['completed'] }}</span>
    </a>
</div>

{{-- Table --}}
<div class="dash-card">
    @if($serviceRequests->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f9fafb; border-bottom: 1px solid #e5e7eb;">
                    <tr>
                        <th class="px-4 py-3 text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">#</th>
                        <th class="px-4 py-3 text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Client</th>
                        <th class="px-4 py-3 text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Category</th>
                        <th class="px-4 py-3 text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Requirements</th>
                        <th class="px-4 py-3 text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Budget</th>
                        <th class="px-4 py-3 text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Files</th>
                        <th class="px-4 py-3 text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Status</th>
                        <th class="px-4 py-3 text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Date</th>
                        <th class="px-4 py-3 text-muted fw-semibold text-end" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($serviceRequests as $sr)
                        <tr style="border-bottom: 1px solid #f3f4f6;">

                            {{-- # --}}
                            <td class="px-4 py-3 text-muted small">
                                {{ $loop->iteration + ($serviceRequests->currentPage() - 1) * $serviceRequests->perPage() }}
                            </td>

                            {{-- Client --}}
                            <td class="px-4 py-3">
                                <div class="fw-semibold" style="font-size:0.9rem;color:#111827;">
                                    {{ $sr->name }}
                                </div>
                                <div class="small text-muted">{{ $sr->phone }}</div>
                                @if($sr->email)
                                    <div class="small text-muted">{{ $sr->email }}</div>
                                @endif
                            </td>

                            {{-- Category --}}
                            <td class="px-4 py-3">
                                @if($sr->service_category)
                                    <span class="badge rounded-pill"
                                          style="background:rgba(22,163,74,0.1);color:#16a34a;font-size:0.75rem;padding:4px 10px;">
                                        {{ $sr->service_category }}
                                    </span>
                                @else
                                    <span class="text-muted fst-italic small">—</span>
                                @endif
                            </td>

                            {{-- Requirements --}}
                            <td class="px-4 py-3 small text-muted" style="max-width:220px;">
                                <span style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                    {{ $sr->description }}
                                </span>
                                @if($sr->timeline)
                                    <div class="mt-1">
                                        <i class="bi bi-clock text-muted"></i>
                                        <span class="text-muted">{{ $sr->timeline }}</span>
                                    </div>
                                @endif
                            </td>

                            {{-- Budget --}}
                            <td class="px-4 py-3 small">
                                @if($sr->budget)
                                    <span class="fw-semibold" style="color:#16a34a;">{{ $sr->budget }}</span>
                                @else
                                    <span class="text-muted fst-italic">—</span>
                                @endif
                            </td>

                            {{-- Files --}}
                            <td class="px-4 py-3">
                                @if($sr->files && count($sr->files) > 0)
                                    <div class="d-flex flex-column gap-1">
                                        @foreach($sr->files as $file)
                                            <a href="{{ asset($file) }}"
                                               target="_blank"
                                               class="small text-primary text-decoration-none d-flex align-items-center gap-1">
                                                <i class="bi bi-paperclip"></i>
                                                File {{ $loop->iteration }}
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted fst-italic small">—</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-3">
                                <form action="{{ route('service-requests.status', $sr) }}"
                                      method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status"
                                            class="form-select form-select-sm"
                                            style="font-size:0.78rem;min-width:110px;"
                                            onchange="this.form.submit()">
                                        <option value="pending"   {{ $sr->status == 'pending'   ? 'selected' : '' }}>Pending</option>
                                        <option value="reviewed"  {{ $sr->status == 'reviewed'  ? 'selected' : '' }}>Reviewed</option>
                                        <option value="completed" {{ $sr->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>
                            </td>

                            {{-- Date --}}
                            <td class="px-4 py-3 text-muted small">
                                {{ $sr->created_at->format('M d, Y') }}<br>
                                <span style="font-size:0.7rem;">{{ $sr->created_at->format('H:i') }}</span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-3 text-end">
                                <form action="{{ route('service-requests.destroy', $sr) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this request from {{ addslashes($sr->name) }}? This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger px-3"
                                            style="font-size:0.8rem;">
                                        <i class="bi bi-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($serviceRequests->hasPages())
            <div class="px-4 py-3 border-top">
                {{ $serviceRequests->links() }}
            </div>
        @endif

    @else
        <div class="text-center py-5">
            <i class="bi bi-inbox" style="font-size:3rem;color:#d1d5db;"></i>
            <p class="mt-3 text-muted">
                No service requests
                {{ request('status') ? 'with status "' . request('status') . '"' : 'yet' }}.
            </p>
        </div>
    @endif
</div>

@endsection