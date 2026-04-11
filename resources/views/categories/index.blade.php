@extends('front.layouts.admin')

@section('title', 'All Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0"><i class="bi bi-tags-fill me-2 text-primary"></i>All Categories</h4>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> New Category
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Classification</th>
                        <th>Subcategories</th>
                        <th>Description</th>
                        <th style="width:130px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="text-muted small">{{ $category->id }}</td>
                        <td class="fw-semibold">{{ $category->title }}</td>
                        <td><code class="badge bg-secondary">{{ $category->slug }}</code></td>

                        {{-- Classification: now a JSON array of strings --}}
                        <td>
                            @if(!empty($category->classification_name))
                                @foreach($category->classification_name as $name)
                                    <span class="badge bg-info text-dark me-1">{{ $name }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        {{-- Subcategories: now a JSON array of strings --}}
                        <td>
                            @if(!empty($category->subcategory))
                                @foreach($category->subcategory as $sub)
                                    <span class="badge bg-light text-dark border me-1">{{ $sub }}</span>
                                @endforeach
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>

                        <td class="text-muted small">{{ Str::limit($category->description, 50) }}</td>
                        <td>
                            <a href="{{ route('categories.index', $category) }}"
                               class="btn btn-sm btn-outline-secondary" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('categories.edit', $category) }}"
                               class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Delete \'{{ addslashes($category->title) }}\'?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            No categories found. <a href="{{ route('categories.create') }}">Create one</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($categories->hasPages())
    <div class="mt-3 d-flex justify-content-end">{{ $categories->links() }}</div>
@endif
@endsection