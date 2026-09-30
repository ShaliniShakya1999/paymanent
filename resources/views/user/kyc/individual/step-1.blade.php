@extends('user.kyc.layout')
@section('kyc_content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4 p-md-5">
        <h2 class="h5 fw-semibold text-dark mb-1">{{ __('Aadhaar') }}</h2>
        <p class="text-muted small mb-4">{{ __('Complete this step to continue.') }}</p>
        <form id="kyc-aadhaar-form" action="{{ route('user.kyc.individual.step.store', ['step' => 1]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-medium">{{ __('Aadhaar Number (12 digits)') }} <span class="text-danger">*</span></label>
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    <input type="text" id="aadhaar_number" name="aadhaar_number" class="form-control form-control-lg" placeholder="123456789012" maxlength="12" value="{{ old('aadhaar_number') }}" required style="max-width: 220px;">
                    <button type="button" id="send-otp-btn" class="btn btn-primary">{{ __('Send OTP') }}</button>
                </div>
                <div id="aadhaar-send-error" class="text-danger small mt-1 d-none"></div>
                @error('aadhaar_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div id="otp-verify-block" class="mb-4 d-none">
                <label class="form-label fw-medium">{{ __('Enter OTP received on registered mobile') }} <span class="text-danger">*</span></label>
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    <input type="text" id="aadhaar_otp" class="form-control form-control-lg" placeholder="{{ __('6-digit OTP') }}" maxlength="6" autocomplete="one-time-code" style="max-width: 140px;">
                    <button type="button" id="verify-otp-btn" class="btn btn-success">{{ __('Verify OTP') }}</button>
                </div>
                <div id="aadhaar-verify-error" class="text-danger small mt-1 d-none"></div>
                <div id="aadhaar-verify-success" class="text-success small mt-1 d-none">{{ __('Aadhaar verified. You can now upload the document and continue.') }}</div>
                <input type="hidden" id="aadhaar_client_id" name="aadhaar_client_id" value="">
                <input type="hidden" id="aadhaar_refid" name="aadhaar_refid" value="">
            </div>
            <div class="mb-4">
                <label class="form-label fw-medium">{{ __('Aadhaar Card') }} <span class="text-danger">*</span></label>
                <input type="file" name="aadhaar_file" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                @if($uploaded->has('aadhaar'))<span class="badge bg-success mt-1">{{ __('Uploaded') }}</span>@endif
                @error('aadhaar_file')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary kyc-btn-primary">{{ __('Save & Continue') }}</button>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('kyc-aadhaar-form');
    var sendOtpBtn = document.getElementById('send-otp-btn');
    var verifyOtpBtn = document.getElementById('verify-otp-btn');
    var aadhaarInput = document.getElementById('aadhaar_number');
    var otpBlock = document.getElementById('otp-verify-block');
    var otpInput = document.getElementById('aadhaar_otp');
    var clientIdInput = document.getElementById('aadhaar_client_id');
    var refidInput = document.getElementById('aadhaar_refid');
    var sendError = document.getElementById('aadhaar-send-error');
    var verifyError = document.getElementById('aadhaar-verify-error');
    var verifySuccess = document.getElementById('aadhaar-verify-success');
    var token = form.querySelector('input[name="_token"]').value;
    var sendUrl = '{{ route("sprintverify.aadhaar.send_otp") }}';
    var verifyUrl = '{{ route("sprintverify.aadhaar.verify_otp") }}';
    function showSendError(msg) { sendError.textContent = msg || ''; sendError.classList.remove('d-none'); }
    function hideSendError() { sendError.classList.add('d-none'); }
    function showVerifyError(msg) { verifyError.textContent = msg || ''; verifyError.classList.remove('d-none'); verifySuccess.classList.add('d-none'); }
    function hideVerifyError() { verifyError.classList.add('d-none'); }
    function showVerifySuccess() { verifySuccess.classList.remove('d-none'); verifyError.classList.add('d-none'); }
    sendOtpBtn.addEventListener('click', function() {
        var num = (aadhaarInput.value || '').replace(/\D/g, '');
        if (num.length !== 12) { showSendError('{{ __("Please enter a valid 12-digit Aadhaar number.") }}'); return; }
        hideSendError(); sendOtpBtn.disabled = true; sendOtpBtn.textContent = '{{ __("Sending...") }}';
        fetch(sendUrl, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: JSON.stringify({ id_number: num, _token: token }) })
        .then(function(r) {
            return r.text().then(function(t) {
                try { return JSON.parse(t); } catch(e) {
                    return { success: false, message: r.status === 419 ? 'Session expired. Refresh and try again.' : 'Request failed. Try again.' };
                }
            });
        })
        .then(function(data) {
            sendOtpBtn.disabled = false;
            sendOtpBtn.textContent = '{{ __("Send OTP") }}';
            if (data.success && data.client_id) {
                clientIdInput.value = data.client_id;
                refidInput.value = data.refid || '';
                otpBlock.classList.remove('d-none');
                otpInput.value = '';
                otpInput.focus();
                hideSendError();
            } else {
                showSendError(data.message || 'Failed to send OTP. Try again.');
            }
        })
        .catch(function() {
            sendOtpBtn.disabled = false;
            sendOtpBtn.textContent = '{{ __("Send OTP") }}';
            showSendError('Request failed. Try again.');
        });
    });
    verifyOtpBtn.addEventListener('click', function() {
        var otp = (otpInput.value || '').trim(); var clientId = clientIdInput.value; var refid = refidInput.value; var aadhaarNum = (aadhaarInput.value || '').replace(/\D/g, '');
        if (!otp || !clientId) { showVerifyError('Please enter the OTP. Send OTP first if you have not.'); return; }
        if (!refid) refidInput.value = (Date.now() + '').slice(-10);
        hideVerifyError(); verifyOtpBtn.disabled = true; verifyOtpBtn.textContent = '{{ __("Verifying...") }}';
        fetch(verifyUrl, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: JSON.stringify({ client_id: clientId, otp: otp, refid: refidInput.value, aadhaar_number: aadhaarNum, _token: token }) })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            verifyOtpBtn.disabled = false; verifyOtpBtn.textContent = '{{ __("Verify OTP") }}';
            if (data.success) { showVerifySuccess(); otpInput.setAttribute('readonly', 'readonly'); verifyOtpBtn.classList.add('d-none'); }
            else { showVerifyError(data.message || '{{ __("Verification failed. Check OTP and try again.") }}'); }
        })
        .catch(function() { verifyOtpBtn.disabled = false; verifyOtpBtn.textContent = '{{ __("Verify OTP") }}'; showVerifyError('{{ __("Request failed. Try again.") }}'); });
    });
});
</script>
@endsection
