@extends('user.kyc.layout')
@section('kyc_content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4 p-md-5">
        <h2 class="h5 fw-semibold text-dark mb-1">{{ __('PAN Card') }}</h2>
        <p class="text-muted small mb-4">{{ __('Complete this step to continue.') }}</p>
        <form id="kyc-pan-form" action="{{ route('user.kyc.individual.step.store', ['step' => 2]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-medium">{{ __('PAN Number') }} <span class="text-danger">*</span></label>
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    <input type="text" id="pan_number" name="pan_number" class="form-control form-control-lg text-uppercase" placeholder="AAAAA9999A" maxlength="10" value="{{ old('pan_number') }}" required style="max-width: 200px;">
                    <button type="button" id="pan-verify-btn" class="btn btn-primary">{{ __('Verify PAN') }}</button>
                </div>
                <div id="pan-verify-error" class="text-danger small mt-1 d-none"></div>
                <div id="pan-verify-result" class="mt-2 p-3 border rounded d-none"></div>
                @error('pan_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-medium">{{ __('PAN Card (Image/PDF)') }} <span class="text-danger">*</span></label>
                <input type="file" name="pan_file" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                @if($uploaded->has('pan'))<span class="badge bg-success mt-1">{{ __('Uploaded') }}</span>@endif
                @error('pan_file')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Save & Continue') }}</button>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('kyc-pan-form');
    var panInput = document.getElementById('pan_number');
    var verifyBtn = document.getElementById('pan-verify-btn');
    var errorEl = document.getElementById('pan-verify-error');
    var resultEl = document.getElementById('pan-verify-result');
    var token = form.querySelector('input[name="_token"]').value;
    var url = '{{ route("sprintverify.pan.details") }}';

    verifyBtn.addEventListener('click', function() {
        var pan = (panInput.value || '').toUpperCase().replace(/\s/g, '');
        if (pan.length !== 10) {
            errorEl.textContent = 'Please enter a valid 10-character PAN.';
            errorEl.classList.remove('d-none');
            resultEl.classList.add('d-none');
            return;
        }
        errorEl.classList.add('d-none');
        resultEl.classList.add('d-none');
        verifyBtn.disabled = true;
        verifyBtn.textContent = 'Verifying...';
        var refid = String(Date.now()).slice(-10) + Math.floor(Math.random() * 10000);

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify({ refid: refid, id_number: pan, _token: token })
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            verifyBtn.disabled = false;
            verifyBtn.textContent = '{{ __("Verify PAN") }}';
            resultEl.classList.remove('d-none');
            if (res.success && res.data) {
                var d = res.data;
                var name = d.fullName || (d.firstName && d.lastName ? d.firstName + ' ' + d.lastName : '') || '-';
                var status = d.idStatus || d.panStatus || '';
                resultEl.innerHTML = '<span class="text-success">' + (res.message || 'PAN verified.') + '</span>' +
                    (name ? '<br><strong>Name:</strong> ' + name : '') +
                    (status ? ' <strong>Status:</strong> ' + status : '');
            } else {
                resultEl.innerHTML = '<span class="text-danger">' + (res.message || 'Verification failed.') + '</span>';
            }
        })
        .catch(function() {
            verifyBtn.disabled = false;
            verifyBtn.textContent = '{{ __("Verify PAN") }}';
            resultEl.classList.remove('d-none');
            resultEl.innerHTML = '<span class="text-danger">Request failed. Try again.</span>';
        });
    });
});
</script>
@endsection
