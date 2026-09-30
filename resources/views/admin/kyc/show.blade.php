@extends('admin.layouts.master')
@section('title', __('KYC Review') . ' - ' . getColumnValue($user))
@section('page_content')
<div class="box">
    <div class="box-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ url(config('adminPrefix') . '/kyc') }}" class="btn btn-default">{{ __('Back to list') }}</a>
            <span class="badge badge-{{ $detail->kyc_status == 'approved' ? 'success' : ($detail->kyc_status == 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst(str_replace('_', ' ', $detail->kyc_status)) }}</span>
        </div>

        <h5 class="mb-3">{{ __('User') }}</h5>
        <table class="table table-bordered table-sm">
            <tr><th width="180">{{ __('Name') }}</th><td>{{ $user->first_name }} {{ $user->last_name }}</td></tr>
            <tr><th>{{ __('Email') }}</th><td>{{ $user->email }}</td></tr>
            <tr><th>{{ __('Merchant Category') }}</th><td>{{ ucfirst($detail->merchant_category) }}</td></tr>
            <tr><th>{{ __('Submitted at') }}</th><td>{{ $detail->kyc_submitted_at ? $detail->kyc_submitted_at->format('d M Y H:i') : '–' }}</td></tr>
            @if($detail->kyc_rejection_reason)
            <tr><th>{{ __('Rejection reason') }}</th><td>{{ $detail->kyc_rejection_reason }}</td></tr>
            @endif
        </table>

        @if(($partners ?? collect())->isNotEmpty())
        <h5 class="mb-3 mt-4">{{ __('Partners') }}</h5>
        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('Partner') }}</th>
                        <th>{{ __('Aadhaar number') }}</th>
                        <th>{{ __('Aadhaar document') }}</th>
                        <th>{{ __('PAN number') }}</th>
                        <th>{{ __('PAN document') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($partners as $idx => $partner)
                    <tr>
                        <td><strong>{{ $partner->name }}</strong></td>
                        <td>{{ $partner->aadhaar_number ?? '–' }}</td>
                        <td>
                            @if($partner->aadhaarFile)
                            @php
                                $aadhaarUrl = asset('public/uploads/kyc-documents/' . $partner->aadhaarFile->filename);
                                $aadhaarExt = strtolower(pathinfo($partner->aadhaarFile->filename, PATHINFO_EXTENSION));
                                $aadhaarPdf = ($aadhaarExt === 'pdf');
                                $aadhaarImg = in_array($aadhaarExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            @endphp
                            <div class="d-flex flex-wrap align-items-center gap-1">
                                <a href="{{ $aadhaarUrl }}" target="_blank" class="btn btn-sm btn-default">{{ Str::limit($partner->aadhaarFile->originalname ?? $partner->aadhaarFile->filename, 20) }}</a>
                                <button type="button" class="btn btn-sm btn-info view-doc" data-url="{{ $aadhaarUrl }}" data-type="{{ $aadhaarPdf ? 'pdf' : ($aadhaarImg ? 'image' : 'link') }}" data-title="{{ $partner->name }} – {{ __('Aadhaar') }}">{{ __('View') }}</button>
                            </div>
                            @else – @endif
                        </td>
                        <td>{{ $partner->pan_number ?? '–' }}</td>
                        <td>
                            @if($partner->panFile)
                            @php
                                $panUrl = asset('public/uploads/kyc-documents/' . $partner->panFile->filename);
                                $panExt = strtolower(pathinfo($partner->panFile->filename, PATHINFO_EXTENSION));
                                $panPdf = ($panExt === 'pdf');
                                $panImg = in_array($panExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            @endphp
                            <div class="d-flex flex-wrap align-items-center gap-1">
                                <a href="{{ $panUrl }}" target="_blank" class="btn btn-sm btn-default">{{ Str::limit($partner->panFile->originalname ?? $partner->panFile->filename, 20) }}</a>
                                <button type="button" class="btn btn-sm btn-info view-doc" data-url="{{ $panUrl }}" data-type="{{ $panPdf ? 'pdf' : ($panImg ? 'image' : 'link') }}" data-title="{{ $partner->name }} – {{ __('PAN') }}">{{ __('View') }}</button>
                            </div>
                            @else – @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <h5 class="mb-3 mt-4">{{ __('Documents') }}</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('Document') }}</th>
                        <th>{{ __('Identity number') }}</th>
                        <th>{{ __('File') }}</th>
                        <th>{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $doc)
                    <tr>
                        <td>{{ $entity_config['documents'][$doc->document_type]['label'] ?? $doc->document_type }}</td>
                        <td>{{ $doc->identity_number ?? '–' }}</td>
                        <td>
                            @if($doc->file)
                            @php
                                $fileUrl = asset('public/uploads/kyc-documents/' . $doc->file->filename);
                                $ext = strtolower(pathinfo($doc->file->filename, PATHINFO_EXTENSION));
                                $isPdf = ($ext === 'pdf');
                                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            @endphp
                            <div class="d-flex flex-wrap align-items-center gap-1">
                                <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-default" title="{{ __('Open in new tab') }}">{{ Str::limit($doc->file->originalname ?? $doc->file->filename, 25) }}</a>
                                <button type="button" class="btn btn-sm btn-info view-doc" data-url="{{ $fileUrl }}" data-type="{{ $isPdf ? 'pdf' : ($isImage ? 'image' : 'link') }}" data-title="{{ $entity_config['documents'][$doc->document_type]['label'] ?? $doc->document_type }}" title="{{ __('View') }}">
                                    {{ __('View') }}
                                </button>
                            </div>
                            @else
                            –
                            @endif
                        </td>
                        <td>{{ ucfirst($doc->status) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($detail->kyc_status == 'in_review' || $detail->kyc_status == 'rejected')
        <div class="mt-4 d-flex gap-2 flex-wrap">
            @if($detail->kyc_status == 'in_review')
            <form action="{{ url(config('adminPrefix') . '/kyc/' . $user->id . '/approve') }}" method="post" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success">{{ __('Approve KYC') }}</button>
            </form>
            @endif
            <button type="button" class="btn btn-danger" id="rejectKycBtn" data-toggle="modal" data-target="#rejectModal" data-bs-toggle="modal" data-bs-target="#rejectModal">{{ __('Reject KYC') }}</button>
        </div>
        @endif
    </div>
</div>

<div class="modal fade" id="viewDocModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDocModalTitle">{{ __('Document') }}</h5>
                <button type="button" class="close" id="viewDocModalClose" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body p-0 text-center bg-light" style="min-height: 70vh;">
                <iframe id="viewDocIframe" style="display:none; width:100%; height:70vh; border:0;"></iframe>
                <img id="viewDocImage" style="display:none; max-width:100%; max-height:70vh; object-fit: contain;" alt="">
                <div id="viewDocLink" style="display:none;" class="p-4">
                    <a id="viewDocLinkAnchor" href="#" target="_blank" class="btn btn-primary">{{ __('Open in new tab') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url(config('adminPrefix') . '/kyc/' . $user->id . '/reject') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Reject KYC') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <label class="fw-bold">{{ __('Reason (required)') }}</label>
                    <textarea name="kyc_rejection_reason" class="form-control" rows="4" required placeholder="{{ __('Specify reason for rejection...') }}"></textarea>
                    @error('kyc_rejection_reason')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('Reject') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('extra_body_scripts')
<script>
document.querySelectorAll('.view-doc').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var url = this.getAttribute('data-url');
        var type = this.getAttribute('data-type') || 'link';
        var title = this.getAttribute('data-title') || 'Document';
        var modal = document.getElementById('viewDocModal');
        var titleEl = document.getElementById('viewDocModalTitle');
        var iframe = document.getElementById('viewDocIframe');
        var img = document.getElementById('viewDocImage');
        var linkWrap = document.getElementById('viewDocLink');
        var linkAnchor = document.getElementById('viewDocLinkAnchor');

        iframe.style.display = 'none';
        img.style.display = 'none';
        linkWrap.style.display = 'none';
        iframe.src = '';

        titleEl.textContent = title;

        if (type === 'pdf') {
            iframe.src = url;
            iframe.style.display = 'block';
        } else if (type === 'image') {
            img.src = url;
            img.style.display = 'inline';
        } else {
            linkAnchor.href = url;
            linkWrap.style.display = 'block';
        }

        $(modal).modal('show');
    });
});
var viewDocCloseBtn = document.getElementById('viewDocModalClose');
if (viewDocCloseBtn) viewDocCloseBtn.addEventListener('click', function() { $('#viewDocModal').modal('hide'); });
var rejectKycBtn = document.getElementById('rejectKycBtn');
if (rejectKycBtn) rejectKycBtn.addEventListener('click', function() { $('#rejectModal').modal('show'); });
$('#viewDocModal').on('hidden.bs.modal', function() {
    document.getElementById('viewDocIframe').src = '';
    document.getElementById('viewDocIframe').style.display = 'none';
    document.getElementById('viewDocImage').src = '';
    document.getElementById('viewDocImage').style.display = 'none';
});
</script>
@endpush
@endsection
