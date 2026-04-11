@extends('front.layouts.admin')
@section('content')

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3">Shop Categories</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('shop-categories.create') }}" class="btn btn-primary">
                New Category
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Parent Category</th>
                                <th>Subcategories</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $category->name }}</strong></td>
                                    <td>
                                        @if($category->subcategories && $category->subcategories->count() > 0)
                                            <span class="badge bg-info">{{ $category->subcategories->count() }}</span>
                                            <small class="text-muted d-block">
                                                {{ implode(', ', $category->subcategories->pluck('name')->take(2)->toArray()) }}
                                                @if($category->subcategories->count() > 2)
                                                    ...
                                                @endif
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($category->active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('shop-categories.edit', $category) }}" class="btn btn-warning">
                                                Edit
                                            </a>
                                            <form action="{{ route('shop-categories.destroy', $category) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Sure?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $categories->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <p class="text-muted">No categories found.</p>
                    <a href="{{ route('shop-categories.create') }}" class="btn btn-primary btn-sm">
                        Create First Category
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection