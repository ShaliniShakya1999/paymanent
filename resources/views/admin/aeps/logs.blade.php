@extends('admin.layouts.master')
@section('title', __('AEPS Logs'))

@section('page_content')
<div class="box">
    <div class="box-body">
        <form action="{{ url(config('adminPrefix').'/aeps/logs') }}" method="GET" class="form-inline">
            <input type="date" name="from" class="form-control mr-2" value="{{ $from }}">
            <input type="date" name="to" class="form-control mr-2" value="{{ $to }}">
            <button type="submit" class="btn btn-theme">{{ __('Filter') }}</button>
        </form>
    </div>
</div>
<div class="box">
    <div class="box-body">
        <div class="top-bar-title padding-bottom">{{ __('AEPS Logs') }}</div>
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
                @forelse($logs as $t)
                <tr>
                    <td>{{ $t->id }}</td>
                    <td>{{ $t->user ? getColumnValue($t->user) : '-' }}</td>
                    <td>{{ $t->reference_id }}</td>
                    <td>{{ $t->bank_name ?? '-' }}</td>
                    <td>{{ number_format($t->amount, 2) }}</td>
                    <td><span class="badge bg-{{ $t->status == 'success' ? 'success' : 'danger' }}">{{ $t->status }}</span></td>
                    <td>{{ $t->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">{{ __('No logs.') }}</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $logs->links() }}
    </div>
</div>
@endsection
