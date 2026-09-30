@extends('admin.layouts.master')
@section('title', __('Verification') . ' - ' . $typeLabel)

@section('head_style')
<style>
.verification-filter-form .form-group { margin-bottom: 15px; }
.verification-filter-form .verification-date-input {
    min-height: 38px;
    width: 100%;
    max-width: 100%;
}
.verification-filter-btn { min-height: 38px; font-weight: 600; }
@media (min-width: 992px) {
    .verification-filter-actions { margin-top: 25px; }
}
@media (max-width: 991px) {
    .verification-filter-actions { margin-top: 8px; }
}
.verification-logs-table-wrap { width: 100%; overflow-x: auto; }
.verification-logs-table { width: 100% !important; min-width: 720px; }
.verification-logs-table thead th {
    background: #f9f9f9;
    font-weight: 600;
    white-space: nowrap;
}
.verification-cell-break {
    word-break: break-word;
    max-width: 280px;
}
</style>
@endsection

@section('page_content')
<div class="box box-primary verification-logs-page">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('Filter by date') }}</h3>
    </div>
    <div class="box-body">
        <form action="{{ url(config('adminPrefix').'/verification/'.$type) }}" method="GET" class="verification-filter-form">
            <div class="row">
                <div class="col-md-5 col-sm-6">
                    <div class="form-group">
                        <label for="verification_from" class="control-label">{{ __('From') }}</label>
                        <input type="date" name="from" id="verification_from" class="form-control verification-date-input" value="{{ $from }}">
                    </div>
                </div>
                <div class="col-md-5 col-sm-6">
                    <div class="form-group">
                        <label for="verification_to" class="control-label">{{ __('To') }}</label>
                        <input type="date" name="to" id="verification_to" class="form-control verification-date-input" value="{{ $to }}">
                    </div>
                </div>
                <div class="col-md-2 col-sm-12">
                    <div class="form-group verification-filter-actions">
                        <button type="submit" class="btn btn-theme btn-block verification-filter-btn">{{ __('Filter') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $typeLabel }} — {{ __('Verification Logs') }}</h3>
    </div>
    <div class="box-body no-padding">
        <div class="table-responsive verification-logs-table-wrap">
            <table class="table table-striped table-bordered table-hover verification-logs-table mb-0">
                <thead>
                    <tr>
                        <th style="width:72px;">ID</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Identifier') }}</th>
                        <th>{{ __('Request Ref') }}</th>
                        <th style="width:100px;">{{ __('Success') }}</th>
                        <th style="width:150px;">{{ __('Date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->user ? getColumnValue($log->user) : '-' }}</td>
                        <td class="verification-cell-break">{{ $log->identifier_masked ?? '-' }}</td>
                        <td class="verification-cell-break">{{ $log->request_ref ?? '-' }}</td>
                        <td><span class="badge bg-{{ $log->success ? 'success' : 'danger' }}">{{ $log->success ? __('Yes') : __('No') }}</span></td>
                        <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted" style="padding:24px;">{{ __('No verification logs.') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="box-footer clearfix text-center" style="border-top:1px solid #f4f4f4;">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
