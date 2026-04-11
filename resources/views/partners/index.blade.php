@extends('front.layouts.admin')
@section('content')

<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-bold mb-2">Partners</h1>
            <p class="text-muted">Manage all your partners</p>
        </div>
        <a href="{{ route('partners.create') }}" class="btn btn-primary gap-2">
            <i class="bi bi-plus-lg"></i>
            Add Partner
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Partners Table --}}
    <div class="card border shadow-sm">
        @if($partners->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 25%;">Title</th>
                            <th style="width: 40%;">Description</th>
                            <th style="width: 15%;">Slug</th>
                            <th style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($partners as $partner)
                            <tr>
                                <td class="fw-semibold text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <h6 class="mb-0 fw-bold">{{ $partner->title }}</h6>
                                </td>
                                <td>
                                    <p class="text-muted mb-0 small" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $partner->description }}
                                    </p>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $partner->slug }}</span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('partners.edit', $partner) }}" class="btn btn-outline-secondary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('partners.destroy', $partner) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this partner?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <p class="text-muted mb-3">No partners found</p>
                                    <a href="{{ route('partners.create') }}" class="btn btn-sm btn-primary">
                                        Create First Partner
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($partners->hasPages())
                <div class="card-footer border-top">
                    {{ $partners->links() }}
                </div>
            @endif
        @else
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">No partners yet</p>
                <a href="{{ route('partners.create') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-plus-lg"></i> Add First Partner
                </a>
            </div>
        @endif
    </div>

</div>

@endsection