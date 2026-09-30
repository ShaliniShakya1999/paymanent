@extends('admin.layouts.master')
@section('title', __('Transaction Reports'))

@section('page_content')
<div class="box">
    <div class="box-body">
        <form action="{{ url(config('adminPrefix').'/reports/transactions') }}" method="GET" class="form-inline">
            <input type="date" name="from" class="form-control mr-2" value="{{ $from }}">
            <input type="date" name="to" class="form-control mr-2" value="{{ $to }}">
            <button type="submit" class="btn btn-theme">{{ __('Filter') }}</button>
        </form>
    </div>
</div>
<div class="box">
    <div class="box-body">
        <div class="top-bar-title padding-bottom">{{ __('Transaction Reports') }} ({{ $from }} to {{ $to }})</div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('Module') }}</th>
                        <th>{{ __('Total') }}</th>
                        <th>{{ __('Success') }}</th>
                        <th>{{ __('Failed') }}</th>
                        <th>{{ __('Pending') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ __('Bill Payment (BBPS)') }}</td>
                        <td>{{ $bill_payment->count() }}</td>
                        <td>{{ $bill_payment->where('status', 'success')->count() }}</td>
                        <td>{{ $bill_payment->where('status', 'failed')->count() }}</td>
                        <td>{{ $bill_payment->where('status', 'pending')->count() }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Recharge') }}</td>
                        <td>{{ $recharge->count() }}</td>
                        <td>{{ $recharge->where('status', 'success')->count() }}</td>
                        <td>{{ $recharge->where('status', 'failed')->count() }}</td>
                        <td>{{ $recharge->where('status', 'pending')->count() }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('AEPS') }}</td>
                        <td>{{ $aeps->count() }}</td>
                        <td>{{ $aeps->where('status', 'success')->count() }}</td>
                        <td>{{ $aeps->where('status', 'failed')->count() }}</td>
                        <td>{{ $aeps->where('status', 'pending')->count() }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Bus Booking') }}</td>
                        <td>{{ $bus->count() }}</td>
                        <td>{{ $bus->where('status', 'confirmed')->count() }}</td>
                        <td>{{ $bus->where('status', 'cancelled')->count() }}</td>
                        <td>{{ $bus->whereNotIn('status', ['confirmed', 'cancelled'])->count() }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
