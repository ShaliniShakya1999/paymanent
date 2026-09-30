@extends('admin.layouts.master')
@section('title', __('Bus Trips'))

@section('page_content')
<div class="box">
    <div class="box-body">
        <form action="{{ url(config('adminPrefix').'/bus/trips') }}" method="GET" class="form-inline">
            <input type="date" name="from" class="form-control mr-2" value="{{ $from }}">
            <input type="date" name="to" class="form-control mr-2" value="{{ $to }}">
            <button type="submit" class="btn btn-theme">{{ __('Filter') }}</button>
        </form>
    </div>
</div>
<div class="box">
    <div class="box-body">
        <div class="top-bar-title padding-bottom">{{ __('Bus Trips') }}</div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('User') }}</th>
                    <th>{{ __('Source') }}</th>
                    <th>{{ __('Destination') }}</th>
                    <th>{{ __('Travel Date') }}</th>
                    <th>{{ __('Status') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($trips as $t)
                <tr>
                    <td>{{ $t->id }}</td>
                    <td>{{ $t->user ? getColumnValue($t->user) : '-' }}</td>
                    <td>{{ $t->source_city_name ?? '-' }}</td>
                    <td>{{ $t->destination_city_name ?? '-' }}</td>
                    <td>{{ $t->travel_date ? date('d M Y', strtotime($t->travel_date)) : '-' }}</td>
                    <td><span class="badge bg-{{ $t->status == 'confirmed' ? 'success' : ($t->status == 'cancelled' ? 'danger' : 'warning') }}">{{ $t->status ?? '-' }}</span></td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">{{ __('No trips.') }}</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $trips->links() }}
    </div>
</div>
@endsection
