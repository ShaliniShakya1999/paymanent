@extends('admin.layouts.master')
@section('title', __('Recharge Transactions'))

@section('page_content')
<div class="box">
    <div class="box-body pb-20">
        <form action="{{ url(config('adminPrefix').'/recharge-transactions') }}" method="GET" class="form-inline">
            <label class="mr-2">{{ __('From') }}</label>
            <input type="date" name="from" class="form-control mr-3" value="{{ $from }}">
            <label class="mr-2">{{ __('To') }}</label>
            <input type="date" name="to" class="form-control mr-3" value="{{ $to }}">
            <select name="status" class="form-control mr-3">
                <option value="all" {{ $status == 'all' ? 'selected' : '' }}>{{ __('All') }}</option>
                <option value="success" {{ $status == 'success' ? 'selected' : '' }}>{{ __('Success') }}</option>
                <option value="failed" {{ $status == 'failed' ? 'selected' : '' }}>{{ __('Failed') }}</option>
                <option value="refunded" {{ $status == 'refunded' ? 'selected' : '' }}>{{ __('Refunded') }}</option>
                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
            </select>
            <button type="submit" class="btn btn-theme">{{ __('Filter') }}</button>
        </form>
    </div>
</div>
<div class="box">
    <div class="box-body">
        <div class="top-bar-title padding-bottom">{{ __('Recharge Transactions') }}</div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Reference') }}</th>
                        <th>{{ __('Operator') }}</th>
                        <th>{{ __('Mobile') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                    <tr>
                        <td>{{ $t->id }}</td>
                        <td>{{ $t->user ? getColumnValue($t->user) : '-' }}</td>
                        <td>{{ $t->reference_id }}</td>
                        <td>{{ $t->operator_name ?? $t->operator_id }}</td>
                        <td>{{ $t->mobile_number ? substr($t->mobile_number, 0, 4) . '****' : '-' }}</td>
                        <td>{{ number_format($t->amount, 2) }}</td>
                        <td><span class="badge bg-{{ $t->status == 'success' ? 'success' : ($t->status == 'refunded' ? 'info' : ($t->status == 'failed' ? 'danger' : 'warning')) }}">{{ $t->status }}</span></td>
                        <td>{{ $t->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center">{{ __('No transactions.') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $transactions->links() }}
    </div>
</div>
@endsection
