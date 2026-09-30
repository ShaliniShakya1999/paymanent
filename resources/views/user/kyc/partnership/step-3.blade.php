@extends('user.kyc.layout')
@section('kyc_content')
<div class="kyc-card card">
    <div class="card-body">
        <h2 class="h5 kyc-heading mb-1">{{ __('Add Partners') }}</h2>
        <p class="kyc-sub mb-4">{{ __('For each partner: Name, Aadhaar (12 digits) + file, PAN + file. Minimum 1 partner.') }}</p>

        <form action="{{ route('user.kyc.partnership.step.store', ['step' => 3]) }}" method="post" enctype="multipart/form-data" id="partners-form">
            @csrf
            <div id="partners-container">
                @forelse($partners ?? [] as $idx => $p)
                <div class="partner-row kyc-partner-block mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <strong class="text-dark">{{ __('Partner') }} {{ $idx + 1 }}</strong>
                        @if($idx > 0)
                        <button type="button" class="btn btn-sm btn-outline-danger rounded-3 remove-partner">{{ __('Cancel') }}</button>
                        @endif
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small text-muted mb-0">{{ __('Partner Name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="partners[{{ $idx }}][name]" class="form-control form-control-lg" placeholder="{{ __('Full name') }}" value="{{ $p->name }}" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-0">{{ __('Aadhaar (12 digits)') }} <span class="text-danger">*</span></label>
                            <input type="text" name="partners[{{ $idx }}][aadhaar_number]" class="form-control" placeholder="{{ __('12 digits') }}" maxlength="12" value="{{ $p->aadhaar_number }}" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-0">{{ __('Aadhaar document') }} <span class="text-danger">*</span></label>
                            <input type="file" name="partners[{{ $idx }}][aadhaar_file]" class="form-control" accept=".jpg,.jpeg,.png,.pdf">@if($p->aadhaar_file_id)<span class="badge bg-success ms-1">{{ __('Uploaded') }}</span>@endif
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-0">{{ __('PAN') }} <span class="text-danger">*</span></label>
                            <input type="text" name="partners[{{ $idx }}][pan_number]" class="form-control text-uppercase" placeholder="{{ __('10 characters') }}" maxlength="10" value="{{ $p->pan_number }}" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-0">{{ __('PAN document') }} <span class="text-danger">*</span></label>
                            <input type="file" name="partners[{{ $idx }}][pan_file]" class="form-control" accept=".jpg,.jpeg,.png,.pdf">@if($p->pan_file_id)<span class="badge bg-success ms-1">{{ __('Uploaded') }}</span>@endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="partner-row kyc-partner-block mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <strong class="text-dark">{{ __('Partner') }} 1</strong>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small text-muted mb-0">{{ __('Partner Name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="partners[0][name]" class="form-control form-control-lg" placeholder="{{ __('Full name') }}" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-0">{{ __('Aadhaar (12 digits)') }} <span class="text-danger">*</span></label>
                            <input type="text" name="partners[0][aadhaar_number]" class="form-control" placeholder="{{ __('12 digits') }}" maxlength="12" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-0">{{ __('Aadhaar document') }} <span class="text-danger">*</span></label>
                            <input type="file" name="partners[0][aadhaar_file]" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-0">{{ __('PAN') }} <span class="text-danger">*</span></label>
                            <input type="text" name="partners[0][pan_number]" class="form-control text-uppercase" placeholder="{{ __('10 characters') }}" maxlength="10" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-0">{{ __('PAN document') }} <span class="text-danger">*</span></label>
                            <input type="file" name="partners[0][pan_file]" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            <div class="d-flex flex-wrap gap-2 mb-4">
                <button type="button" class="btn kyc-btn-add px-4" id="add-partner">
                    <span class="me-1">+</span> {{ __('Add Partner') }}
                </button>
            </div>

            <hr class="my-4 border-2">

            {{-- AUTHORISED SIGNATORY SECTION --}}
            <div class="kyc-signatory-box mb-4">
                <h3 class="h6 fw-bold text-dark mb-2">{{ __('AUTHORISED SIGNATORY') }}</h3>
                <p class="kyc-sub small mb-3">{{ __('Person authorised to sign for the partnership firm.') }}</p>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-medium">{{ __('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="kyc_signatory_name" class="form-control form-control-lg @error('kyc_signatory_name') is-invalid @enderror" value="{{ old('kyc_signatory_name', $detail->kyc_signatory_name ?? '') }}" placeholder="{{ __('Full name') }}" required maxlength="191">
                        @error('kyc_signatory_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-medium">{{ __('Mobile') }} <span class="text-danger">*</span></label>
                        <input type="text" name="kyc_signatory_phone" class="form-control form-control-lg @error('kyc_signatory_phone') is-invalid @enderror" value="{{ old('kyc_signatory_phone', $detail->kyc_signatory_phone ?? '') }}" placeholder="{{ __('10-digit mobile') }}" required maxlength="15">
                        @error('kyc_signatory_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-medium">{{ __('Email') }} <span class="text-danger">*</span></label>
                        <input type="email" name="kyc_signatory_email" class="form-control form-control-lg @error('kyc_signatory_email') is-invalid @enderror" value="{{ old('kyc_signatory_email', $detail->kyc_signatory_email ?? '') }}" placeholder="{{ __('email@example.com') }}" required maxlength="191">
                        @error('kyc_signatory_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary kyc-btn-primary btn-lg px-4">{{ __('Save & Continue') }}</button>
            </div>
        </form>
    </div>
</div>

@push('js')
<script>
(function() {
    var container = document.getElementById('partners-container');
    var form = document.getElementById('partners-form');

    document.getElementById('add-partner').onclick = function() {
        var n = container.querySelectorAll('.partner-row').length;
        var row = document.createElement('div');
        row.className = 'partner-row kyc-partner-block mb-4';
        row.innerHTML =
            '<div class="d-flex justify-content-between align-items-center mb-3">' +
                '<strong class="text-dark">Partner ' + (n + 1) + '</strong>' +
                '<button type="button" class="btn btn-sm btn-outline-danger rounded-3 remove-partner">Cancel</button>' +
            '</div>' +
            '<div class="row g-3">' +
                '<div class="col-12"><label class="form-label small text-muted mb-0">Partner Name *</label><input type="text" name="partners[' + n + '][name]" class="form-control form-control-lg" placeholder="Full name" required></div>' +
                '<div class="col-12 col-md-6"><label class="form-label small text-muted mb-0">Aadhaar (12 digits) *</label><input type="text" name="partners[' + n + '][aadhaar_number]" class="form-control" placeholder="12 digits" maxlength="12" required></div>' +
                '<div class="col-12 col-md-6"><label class="form-label small text-muted mb-0">Aadhaar document *</label><input type="file" name="partners[' + n + '][aadhaar_file]" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required></div>' +
                '<div class="col-12 col-md-6"><label class="form-label small text-muted mb-0">PAN *</label><input type="text" name="partners[' + n + '][pan_number]" class="form-control text-uppercase" placeholder="10 characters" maxlength="10" required></div>' +
                '<div class="col-12 col-md-6"><label class="form-label small text-muted mb-0">PAN document *</label><input type="file" name="partners[' + n + '][pan_file]" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required></div>' +
            '</div>';
        container.appendChild(row);
    };

    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-partner')) {
            var rows = container.querySelectorAll('.partner-row');
            if (rows.length > 1) e.target.closest('.partner-row').remove();
        }
    });

    form.addEventListener('submit', function(e) {
        var name = (document.querySelector('input[name="kyc_signatory_name"]') || {}).value || '';
        var phone = (document.querySelector('input[name="kyc_signatory_phone"]') || {}).value || '';
        var email = (document.querySelector('input[name="kyc_signatory_email"]') || {}).value || '';
        var phoneNum = (phone || '').replace(/\D/g, '');
        if (!name.trim()) {
            e.preventDefault();
            alert('Please enter Authorised Signatory name.');
            document.querySelector('input[name="kyc_signatory_name"]').focus();
            return;
        }
        if (phoneNum.length < 10) {
            e.preventDefault();
            alert('Please enter a valid 10-digit mobile number.');
            document.querySelector('input[name="kyc_signatory_phone"]').focus();
            return;
        }
        if (!email.trim()) {
            e.preventDefault();
            alert('Please enter Authorised Signatory email.');
            document.querySelector('input[name="kyc_signatory_email"]').focus();
            return;
        }
    });
})();
</script>
@endpush
@endsection
