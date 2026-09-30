@extends('admin.layouts.master')
@section('title', __('Bus Bookings'))

@section('page_content')
<div class="box">
    <div class="box-body">
        <form action="{{ url(config('adminPrefix').'/bus/bookings') }}" method="GET" class="form-inline">
            <input type="date" name="from" class="form-control mr-2" value="{{ $from }}">
            <input type="date" name="to" class="form-control mr-2" value="{{ $to }}">
            <select name="status" class="form-control mr-2">
                <option value="all" {{ $status == 'all' ? 'selected' : '' }}>{{ __('All') }}</option>
                <option value="confirmed" {{ $status == 'confirmed' ? 'selected' : '' }}>{{ __('Confirmed') }}</option>
                <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
            </select>
            <button type="submit" class="btn btn-theme">{{ __('Filter') }}</button>
        </form>
    </div>
</div>
<div class="box">
    <div class="box-body">
        <div class="top-bar-title padding-bottom">{{ __('Bus Bookings') }}</div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('User') }}</th>
                    <th>{{ __('Reference') }}</th>
                    <th>{{ __('Source') }}</th>
                    <th>{{ __('Destination') }}</th>
                    <th>{{ __('Amount') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Date') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                <tr>
                    <td>{{ $b->id }}</td>
                    <td>{{ $b->user ? getColumnValue($b->user) : '-' }}</td>
                    <td>{{ $b->reference_id ?? '-' }}</td>
                    <td>{{ $b->source_city_name ?? '-' }}</td>
                    <td>{{ $b->destination_city_name ?? '-' }}</td>
                    <td>{{ isset($b->amount) ? number_format($b->amount, 2) : '-' }}</td>
                    <td><span class="badge bg-{{ $b->status == 'confirmed' ? 'success' : ($b->status == 'cancelled' ? 'danger' : 'warning') }}">{{ $b->status ?? '-' }}</span></td>
                    <td>{{ $b->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center">{{ __('No bookings.') }}</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $bookings->links() }}
    </div>
</div>
@endsection
