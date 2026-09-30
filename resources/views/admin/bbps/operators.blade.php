@extends('admin.layouts.master')
@section('title', __('BBPS Operators'))

@section('page_content')
<div class="box">
    <div class="box-body">
        <div class="top-bar-title padding-bottom">{{ __('BBPS Operators') }}</div>
        @if(!empty($categories))
        <p class="text-muted">{{ __('Categories') }}: {{ implode(', ', $categories) }}</p>
        @endif
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('Operator ID') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Category') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php $opList = $operators ?? []; @endphp
                    @forelse($opList as $op)
                    <tr>
                        <td>{{ $op['operatorId'] ?? $op['id'] ?? '-' }}</td>
                        <td>{{ $op['operatorName'] ?? $op['name'] ?? '-' }}</td>
                        <td>{{ $op['category'] ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center">{{ __('No operators found. Check API configuration.') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
