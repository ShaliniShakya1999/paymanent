@extends('admin.layouts.master')
@section('title', __('Product Activation Requests'))
@section('page_content')
<div class="box">
    <div class="box-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="panel-title text-bold mb-0">{{ __('Product Activation Requests') }}</p>
            <a href="{{ route('admin.products.index') }}" class="btn btn-default">{{ __('Back to Products') }}</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Product') }}</th>
                        <th>{{ __('Requested at') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $row)
                    <tr>
                        <td>
                            <strong>{{ $row->user->first_name ?? '' }} {{ $row->user->last_name ?? '' }}</strong><br>
                            <small class="text-muted">{{ $row->user->email ?? '-' }}</small>
                        </td>
                        <td>
                            <strong>{{ $row->product->title ?? '-' }}</strong>
                            @if(!empty($row->product->description))
                            <br><small class="text-muted">{{ Str::limit($row->product->description, 60) }}</small>
                            @endif
                        </td>
                        <td>{{ $row->requested_at ? $row->requested_at->format('M d, Y H:i') : '-' }}</td>
                        <td>
                            <form action="{{ route('admin.product-activation.approve', $row->id) }}" method="post" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">{{ __('Approve') }}</button>
                            </form>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $row->id }}">{{ __('Reject') }}</button>
                            <div class="modal fade" id="rejectModal{{ $row->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.product-activation.reject', $row->id) }}" method="post">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ __('Reject activation request') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="mb-2">{{ __('User') }}: <strong>{{ $row->user->first_name }} {{ $row->user->last_name }}</strong> – {{ $row->product->title }}</p>
                                                <label for="rejection_reason{{ $row->id }}" class="form-label">{{ __('Reason (optional)') }}</label>
                                                <textarea name="rejection_reason" id="rejection_reason{{ $row->id }}" class="form-control" rows="3" maxlength="500" placeholder="{{ __('Optional reason for rejection') }}"></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                <button type="submit" class="btn btn-danger">{{ __('Reject') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">{{ __('No pending activation requests.') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $requests->links() }}
        </div>
    </div>
</div>
@endsection
