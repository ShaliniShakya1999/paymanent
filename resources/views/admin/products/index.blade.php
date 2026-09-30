@extends('admin.layouts.master')
@section('title', __('Products'))
@section('page_content')
<div class="box">
    <div class="box-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="panel-title text-bold mb-0">{{ __('Products') }}</p>
            <a href="{{ route('admin.products.create') }}" class="btn btn-theme">{{ __('Add Product') }}</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Section') }}</th>
                        <th>{{ __('Order') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $row)
                    <tr>
                        <td>
                            @if($row->icon_class)
                            <i class="fa {{ $row->icon_class }} text-info me-2"></i>
                            @endif
                            {{ $row->title }}
                        </td>
                        <td>{{ Str::limit($row->description, 50) }}</td>
                        <td>
                            <span class="badge badge-{{ $row->section === 'activated' ? 'success' : 'secondary' }}">{{ ucfirst($row->section) }}</span>
                        </td>
                        <td>{{ $row->sort_order }}</td>
                        <td>
                            @if($row->is_active)
                            <span class="badge badge-success">{{ __('Active') }}</span>
                            @else
                            <span class="badge badge-default">{{ __('Inactive') }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $row->id) }}" class="btn btn-sm btn-theme">{{ __('Edit') }}</a>
                            <form action="{{ route('admin.products.destroy', $row->id) }}" method="post" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this product?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">{{ __('No products found. Add a product to show on user dashboard.') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
