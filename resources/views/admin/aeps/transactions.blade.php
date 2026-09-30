@extends('admin.layouts.master')
@section('title', __('AEPS Transactions'))

@section('page_content')
<div class="box">
    <div class="box-body">
        <form action="{{ url(config('adminPrefix').'/aeps/transactions') }}" method="GET" class="form-inline">
            <input type="date" name="from" class="form-control mr-2" value="{{ $from }}">
            <input type="date" name="to" class="form-control mr-2" value="{{ $to }}">
            <select name="status" class="form-control mr-2">
                <option value="all" {{ $status == 'all' ? 'selected' : '' }}>{{ __('All') }}</option>
                <option value="success" {{ $status == 'success' ? 'selected' : '' }}>{{ __('Success') }}</option>
                <option value="failed" {{ $status == 'failed' ? 'selected' : '' }}>{{ __('Failed') }}</option>
                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
            </select>
            <button type="submit" class="btn btn-theme">{{ __('Filter') }}</button>
        </form>
    </div>
</div>
<div class="box">
    <div class="box-body">
        <div class="top-bar-title padding-bottom">{{ __('AEPS Transactions') }}</div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('User') }}</th>
                    <th>{{ __('Reference') }}</th>
                    <th>{{ __('Bank') }}</th>
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
                    <td>{{ $t->bank_name ?? $t->bank_id ?? '-' }}</td>
                    <td>{{ number_format($t->amount, 2) }}</td>
                    <td><span class="badge bg-{{ $t->status == 'success' ? 'success' : ($t->status == 'failed' ? 'danger' : 'warning') }}">{{ $t->status }}</span></td>
                    <td>{{ $t->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">{{ __('No transactions.') }}</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $transactions->links() }}
    </div>
</div>
@endsection
