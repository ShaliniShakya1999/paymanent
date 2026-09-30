@extends('user.kyc.layout')
@section('kyc_content')
@php
    $registrationTypes = $business_registration_types ?? config('kyc.entities.proprietorship.business_registration_types', []);
@endphp

<div class="kyc-card card">
    <div class="card-body">
        {{-- BUSINESS PROOF (ANY ONE MANDATORY) --}}
        <h2 class="h5 kyc-heading mb-1">{{ __('Business Proof') }}</h2>
        <p class="kyc-sub small mb-4">{{ __('Any one mandatory. Select type, enter number, upload document. Use ADD to add to list, then Save & Continue.') }}</p>

        <form id="business-registration-form" action="{{ route('user.kyc.proprietorship.step.store', ['step' => 3]) }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-4 param-ref">
                <label class="form-label fw-medium" for="registration-type">{{ __('Registration Type') }} <span class="text-danger">*</span></label>
                <select name="business_registration_type" id="registration-type" class="form-control select2 @error('business_registration_type') is-invalid @enderror" required data-minimum-results-for-search="Infinity">
                    <option value="">{{ __('Select') }}</option>
                    @foreach($registrationTypes as $key => $label)
                        <option value="{{ $key }}" {{ old('business_registration_type', $detail->business_registration_type ?? '') == $key ? 'selected' : '' }}>{{ __($label) }}</option>
                    @endforeach
                </select>
                @error('business_registration_type')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-medium">{{ __('Registration / GST / License Number') }} <span class="text-danger">*</span></label>
                <input type="text" name="kyc_business_registration_number" id="registration-number" class="form-control form-control-lg @error('kyc_business_registration_number') is-invalid @enderror" value="{{ old('kyc_business_registration_number', $detail->kyc_business_registration_number ?? '') }}" placeholder="{{ __('e.g. GSTIN, License no.') }}" maxlength="100">
                @error('kyc_business_registration_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4 d-none" id="other-document-wrap">
                <label class="form-label fw-medium">{{ __('Document Name') }} <span class="text-danger">*</span></label>
                <input type="text" name="kyc_business_registration_other_name" id="other-document-name" class="form-control form-control-lg @error('kyc_business_registration_other_name') is-invalid @enderror" value="{{ old('kyc_business_registration_other_name', $detail->kyc_business_registration_other_name ?? '') }}" placeholder="{{ __('e.g. Trade License, Local Permit') }}" maxlength="191">
                @error('kyc_business_registration_other_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-medium">{{ __('Upload document') }} <span class="text-danger">*</span></label>
                <input type="file" name="business_registration" id="business-registration-file" class="form-control @error('business_registration') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf" required>
                @if($uploaded->has('business_registration'))<span class="badge bg-success mt-1">{{ __('Uploaded') }}</span>@endif
                @error('business_registration')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex flex-wrap gap-2 mb-4">
                <button type="button" id="btn-add-doc" class="btn kyc-btn-add px-4">
                    <span class="me-1">+</span> {{ __('ADD') }}
                </button>
            </div>

            <div id="document-list" class="mb-4"></div>

            <hr class="my-4">

            {{-- AUTHORISED SIGNATORY --}}
            <div class="kyc-signatory-box mb-4">
            <h3 class="h6 fw-bold text-dark mb-2">{{ __('AUTHORISED SIGNATORY') }}</h3>
            <p class="kyc-sub small mb-3">{{ __('Details of the person authorised to sign for the business.') }}</p>

            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label class="form-label fw-medium">{{ __('Name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="kyc_signatory_name" class="form-control form-control-lg @error('kyc_signatory_name') is-invalid @enderror" value="{{ old('kyc_signatory_name', $detail->kyc_signatory_name ?? '') }}" placeholder="{{ __('Full name') }}" required maxlength="191">
                    @error('kyc_signatory_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label fw-medium">{{ __('Mobile Number') }} <span class="text-danger">*</span></label>
                    <input type="text" name="kyc_signatory_phone" class="form-control form-control-lg @error('kyc_signatory_phone') is-invalid @enderror" value="{{ old('kyc_signatory_phone', $detail->kyc_signatory_phone ?? '') }}" placeholder="{{ __('10-digit mobile') }}" required maxlength="15" pattern="[0-9]{10,15}">
                    @error('kyc_signatory_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label fw-medium">{{ __('Email ID') }} <span class="text-danger">*</span></label>
                    <input type="email" name="kyc_signatory_email" class="form-control form-control-lg @error('kyc_signatory_email') is-invalid @enderror" value="{{ old('kyc_signatory_email', $detail->kyc_signatory_email ?? '') }}" placeholder="{{ __('email@example.com') }}" required maxlength="191">
                    @error('kyc_signatory_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            </div>

            <button type="submit" class="btn btn-primary kyc-btn-primary btn-lg px-4">{{ __('Save & Continue') }}</button>
        </form>
    </div>
</div>

<style>
.kyc-doc-card { background: #f8f9fc; border: 1px solid #e2e6ee; border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 0.75rem; }
.kyc-doc-card .doc-type { font-weight: 600; color: #392f6b; }
.kyc-doc-card .doc-meta { font-size: 0.875rem; color: #6c757d; margin-top: 0.25rem; }
.kyc-doc-card .btn-remove { font-size: 0.8rem; padding: 0.25rem 0.5rem; }
</style>

@push('js')
<script>
(function() {
    var typeLabels = @json($registrationTypes);

    function toggleOtherBox() {
        var typeSelect = document.getElementById('registration-type');
        var otherWrap = document.getElementById('other-document-wrap');
        var otherInput = document.getElementById('other-document-name');
        if (!typeSelect || !otherWrap) return;
        var val = (typeSelect.value || '').trim().toLowerCase();
        var isOther = (val === 'other');
        if (isOther) {
            otherWrap.classList.remove('d-none');
            otherInput.setAttribute('required', 'required');
        } else {
            otherWrap.classList.add('d-none');
            otherInput.removeAttribute('required');
            otherInput.value = '';
        }
    }

    function getTypeLabel(key) {
        return typeLabels[key] || key;
    }

    function updateDocumentList() {
        var typeSelect = document.getElementById('registration-type');
        var number = document.getElementById('registration-number').value.trim();
        var otherName = document.getElementById('other-document-name').value.trim();
        var fileInput = document.getElementById('business-registration-file');
        var typeKey = (typeSelect && typeSelect.value) || '';
        var typeLabel = getTypeLabel(typeKey);
        var docName = (typeKey === 'other' && otherName) ? otherName : typeLabel;
        var fileName = (fileInput.files && fileInput.files[0]) ? fileInput.files[0].name : '';

        var listEl = document.getElementById('document-list');
        listEl.innerHTML = '';
        if (!typeKey || !number || !fileName) return;

        var card = document.createElement('div');
        card.className = 'kyc-doc-card d-flex justify-content-between align-items-start flex-wrap gap-2';
        card.innerHTML =
            '<div><div class="doc-type">' + (docName.replace(/</g, '&lt;').replace(/>/g, '&gt;')) + '</div>' +
            '<div class="doc-meta">' + (number.replace(/</g, '&lt;')) + ' &middot; ' + (fileName.replace(/</g, '&lt;')) + '</div></div>' +
            '<button type="button" class="btn btn-outline-danger btn-sm btn-remove rounded-3">' + '{{ __("REMOVE") }}' + '</button>';
        listEl.appendChild(card);

        card.querySelector('.btn-remove').addEventListener('click', function() {
            listEl.innerHTML = '';
            document.getElementById('registration-number').value = '';
            document.getElementById('other-document-name').value = '';
            document.getElementById('business-registration-file').value = '';
            if (typeSelect) typeSelect.value = '';
            $(typeSelect).trigger('change');
        });
    }

    $(document).ready(function() {
        $('#registration-type').on('change', toggleOtherBox);
        toggleOtherBox();
        setTimeout(toggleOtherBox, 100);

        document.getElementById('btn-add-doc').addEventListener('click', function() {
            var typeSelect = document.getElementById('registration-type');
            var type = (typeSelect && typeSelect.value || '').trim();
            var regNum = document.getElementById('registration-number').value.trim();
            var otherInput = document.getElementById('other-document-name');
            var fileInput = document.getElementById('business-registration-file');
            var hasFile = fileInput.files && fileInput.files.length > 0;

            if (!type) {
                alert('{{ __("Please select a registration type.") }}');
                return;
            }
            if (!regNum) {
                alert('{{ __("Please enter Registration / GST / License number.") }}');
                document.getElementById('registration-number').focus();
                return;
            }
            if (type === 'other' && !otherInput.value.trim()) {
                alert('{{ __("Please enter document name.") }}');
                otherInput.focus();
                return;
            }
            if (!hasFile) {
                alert('{{ __("Please upload the document.") }}');
                fileInput.focus();
                return;
            }
            updateDocumentList();
        });
    });

    document.getElementById('business-registration-form').addEventListener('submit', function(e) {
        var typeSelect = document.getElementById('registration-type');
        var type = (typeSelect && typeSelect.value || '').trim();
        var regNum = document.getElementById('registration-number').value.trim();
        var otherInput = document.getElementById('other-document-name');
        var fileInput = document.getElementById('business-registration-file');
        var hasFile = fileInput.files && fileInput.files.length > 0;
        var signatoryName = (document.querySelector('input[name="kyc_signatory_name"]') || {}).value || '';
        var signatoryPhone = (document.querySelector('input[name="kyc_signatory_phone"]') || {}).value || '';
        var signatoryEmail = (document.querySelector('input[name="kyc_signatory_email"]') || {}).value || '';

        if (!type) {
            e.preventDefault();
            alert('{{ __("Please select a registration type.") }}');
            return;
        }
        if (!regNum) {
            e.preventDefault();
            alert('{{ __("Please enter Registration / GST / License number.") }}');
            document.getElementById('registration-number').focus();
            return;
        }
        if (type === 'other' && !otherInput.value.trim()) {
            e.preventDefault();
            alert('{{ __("Please enter document name.") }}');
            otherInput.focus();
            return;
        }
        if (!hasFile) {
            e.preventDefault();
            alert('{{ __("Please upload the document.") }}');
            fileInput.focus();
            return;
        }
        if (!signatoryName.trim()) {
            e.preventDefault();
            alert('{{ __("Please enter Authorised Signatory name.") }}');
            document.querySelector('input[name="kyc_signatory_name"]').focus();
            return;
        }
        var phoneNum = signatoryPhone.replace(/\D/g, '');
        if (phoneNum.length < 10) {
            e.preventDefault();
            alert('{{ __("Please enter a valid 10-digit mobile number.") }}');
            document.querySelector('input[name="kyc_signatory_phone"]').focus();
            return;
        }
        if (!signatoryEmail.trim()) {
            e.preventDefault();
            alert('{{ __("Please enter Authorised Signatory email.") }}');
            document.querySelector('input[name="kyc_signatory_email"]').focus();
            return;
        }
    });
})();
</script>
@endpush
@endsection
