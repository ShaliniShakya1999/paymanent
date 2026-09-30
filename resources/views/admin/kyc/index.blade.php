@extends('admin.layouts.master')
@section('title', __('KYC Verifications'))
@section('page_content')
<div class="box">
    <div class="box-body pb-20">
        <form class="form-horizontal" action="{{ url(config('adminPrefix') . '/kyc') }}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <label class="fw-bold mb-1">{{ __('Status') }}</label>
                    <select class="form-control" name="status">
                        <option value="all" {{ $status_filter == 'all' ? 'selected' : '' }}>{{ __('All') }}</option>
                        @foreach($statuses as $key => $label)
                        <option value="{{ $key }}" {{ $status_filter == $key ? 'selected' : '' }}>{{ __($label) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-theme">{{ __('Filter') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="box">
    <div class="box-body">
        <p class="panel-title text-bold mb-3">{{ __('KYC Submissions') }}</p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Submitted') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $row)
                    <tr>
                        <td>{{ $row->user ? getColumnValue($row->user) : '–' }}</td>
                        <td>{{ $row->user ? $row->user->email : '–' }}</td>
                        <td>{{ ucfirst($row->merchant_category) }}</td>
                        <td>
                            @if($row->kyc_status == 'in_review')
                            <span class="badge badge-warning">{{ __('Under Review') }}</span>
                            @elseif($row->kyc_status == 'approved')
                            <span class="badge badge-success">{{ __('Approved') }}</span>
                            @elseif($row->kyc_status == 'rejected')
                            <span class="badge badge-danger">{{ __('Rejected') }}</span>
                            @else
                            <span class="badge badge-secondary">{{ __('Pending') }}</span>
                            @endif
                        </td>
                        <td>{{ $row->kyc_submitted_at ? \Carbon\Carbon::parse($row->kyc_submitted_at)->format('d M Y H:i') : '–' }}</td>
                        <td>
                            <a href="{{ url(config('adminPrefix') . '/kyc/' . $row->user_id) }}" class="btn btn-sm btn-theme">{{ __('View') }}</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">{{ __('No KYC submissions found.') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $submissions->links() }}
        </div>
    </div>
</div>
@endsection
