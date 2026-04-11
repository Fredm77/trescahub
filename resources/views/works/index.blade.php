@extends('front.layouts.admin')

@section('title', 'Works')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-grid-3x3-gap-fill me-2 text-primary"></i>Works
    </h4>
    <a href="{{ route('works.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Add Work
    </a>
</div>

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
                        <th>Title</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th style="width:120px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($works as $work)
                    <tr>
                        <td class="text-muted small">{{ $work->id }}</td>

                        <td class="fw-semibold">{{ $work->title }}</td>

                        <td class="text-muted small" style="max-width:300px;">
                            {{ Str::limit($work->description, 80) ?: '—' }}
                        </td>

                        <td class="small text-muted">
                            {{ $work->created_at->diffForHumans() }}
                        </td>

                        <td>
                            <a href="{{ route('works.edit', $work) }}"
                               class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('works.destroy', $work) }}" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Delete \'{{ addslashes($work->title) }}\'?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            No works yet. <a href="{{ route('works.create') }}">Add one</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($works->hasPages())
    <div class="mt-3 d-flex justify-content-end">{{ $works->links() }}</div>
@endif

@endsection