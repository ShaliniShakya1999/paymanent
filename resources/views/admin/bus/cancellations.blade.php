@extends('admin.layouts.master')
@section('title', __('Bus Ticket Cancellations'))

@section('page_content')
<div class="box">
    <div class="box-body">
        <form action="{{ url(config('adminPrefix').'/bus/cancellations') }}" method="GET" class="form-inline">
            <input type="date" name="from" class="form-control mr-2" value="{{ $from }}">
            <input type="date" name="to" class="form-control mr-2" value="{{ $to }}">
            <button type="submit" class="btn btn-theme">{{ __('Filter') }}</button>
        </form>
    </div>
</div>
<div class="box">
    <div class="box-body">
        <div class="top-bar-title padding-bottom">{{ __('Bus Ticket Cancellations') }}</div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('User') }}</th>
                    <th>{{ __('Reference') }}</th>
                    <th>{{ __('Source') }}</th>
                    <th>{{ __('Destination') }}</th>
                    <th>{{ __('Cancelled At') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cancellations as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->user ? getColumnValue($c->user) : '-' }}</td>
                    <td>{{ $c->reference_id ?? '-' }}</td>
                    <td>{{ $c->source_city_name ?? '-' }}</td>
                    <td>{{ $c->destination_city_name ?? '-' }}</td>
                    <td>{{ $c->cancelled_at ? date('d M Y H:i', strtotime($c->cancelled_at)) : '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">{{ __('No cancellations.') }}</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $cancellations->links() }}
    </div>
</div>
@endsection
