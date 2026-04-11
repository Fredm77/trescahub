@extends('front.layouts.admin')

@section('title', 'Testimonials')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-chat-quote-fill me-2 text-primary"></i>Testimonials
        @if($pendingCount > 0)
            <span class="badge bg-warning text-dark ms-2">{{ $pendingCount }} pending</span>
        @endif
    </h4>
</div>

{{-- Flash messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Contact</th>
                        <th>Testimonial</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th style="width:150px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $testimonial)
                    <tr>
                        <td class="text-muted small">{{ $testimonial->id }}</td>

                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
                                     style="width:36px;height:36px;background-color:#16a34a;font-size:13px;">
                                    {{ $testimonial->initial }}
                                </div>
                                <span class="fw-semibold">{{ $testimonial->name }}</span>
                            </div>
                        </td>

                        <td class="small text-muted">{{ $testimonial->position }}</td>

                        <td class="small">
                            <div>{{ $testimonial->email }}</div>
                            <div class="text-muted">{{ $testimonial->phone_number }}</div>
                        </td>

                        <td style="max-width:250px;">
                            <p class="small text-muted mb-0"
                               style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                "{{ $testimonial->description }}"
                            </p>
                        </td>

                        <td>
                            @if($testimonial->isApproved())
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>Approved
                                </span>
                            @else
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-hourglass-split me-1"></i>Pending
                                </span>
                            @endif
                        </td>

                        <td class="small text-muted">
                            {{ $testimonial->created_at->diffForHumans() }}
                        </td>

                        <td>
                            {{-- Approve (only if pending) --}}
                            @if($testimonial->isPending())
                                <form action="{{ route('testimonials.approve', $testimonial) }}"
                                      method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-success" title="Approve">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                            @endif

                            {{-- Delete --}}
                            <form action="{{ route('testimonials.destroy', $testimonial) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete testimonial from \'{{ addslashes($testimonial->name) }}\'?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-chat-quote fs-3 d-block mb-2"></i>
                            No testimonials yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($testimonials->hasPages())
    <div class="mt-3 d-flex justify-content-end">{{ $testimonials->links() }}</div>
@endif

@endsection