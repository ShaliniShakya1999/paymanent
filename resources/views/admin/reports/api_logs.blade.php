@extends('admin.layouts.master')
@section('title', __('API Logs'))

@section('page_content')
<div class="box">
    <div class="box-body">
        <form action="{{ url(config('adminPrefix').'/reports/api-logs') }}" method="GET" class="form-inline">
            <input type="date" name="from" class="form-control mr-2" value="{{ $from }}">
            <input type="date" name="to" class="form-control mr-2" value="{{ $to }}">
            <button type="submit" class="btn btn-theme">{{ __('Filter') }}</button>
        </form>
    </div>
</div>
<div class="box">
    <div class="box-body">
        <div class="top-bar-title padding-bottom">{{ __('API Logs') }}</div>
        @if(!$logs || (is_object($logs) && $logs->isEmpty()))
        <p class="text-muted">{{ __('No API logs found for this period or ApiLog model is not configured.') }}</p>
        @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('Service') }}</th>
                        <th>{{ __('Endpoint') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->service ?? $log->api_name ?? '-' }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($log->endpoint ?? $log->url ?? '-', 50) }}</td>
                        <td><span class="badge bg-{{ ($log->status_code ?? $log->status ?? 0) >= 200 && ($log->status_code ?? $log->status ?? 0) < 300 ? 'success' : 'danger' }}">{{ $log->status_code ?? $log->status ?? '-' }}</span></td>
                        <td>{{ isset($log->created_at) ? $log->created_at->format('d M Y H:i') : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if(method_exists($logs, 'links'))
        {{ $logs->links() }}
        @endif
        @endif
    </div>
</div>
@endsection
