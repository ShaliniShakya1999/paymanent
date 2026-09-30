@extends('user.layouts.app')

@section('content')
<div class="bg-white pxy-62 shadow" id="aepsIndex">
    <p class="mb-0 f-26 gilroy-Semibold text-uppercase text-center">{{ __('AEPS') }}</p>
    <p class="mb-0 text-center f-13 gilroy-medium text-gray mt-4">{{ __('Aadhaar Enabled Payment System') }}</p>
    <p class="mb-0 text-center f-18 gilroy-medium text-dark dark-5B mt-2">{{ $content_title ?? __('AEPS') }}</p>
    @include('user.common.alert')

    <div class="mt-28">
        <div class="card mb-4">
            <div class="card-header fw-semibold">{{ __('Step 1: Two Factor Authentication') }}</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Mobile Number') }}</label>
                        <input type="text" class="form-control" id="aeps_mobile" placeholder="{{ __('Enter mobile number') }}" maxlength="15">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('OTP') }}</label>
                        <input type="text" class="form-control" id="aeps_otp" placeholder="{{ __('Enter OTP after send') }}" maxlength="6">
                    </div>
                </div>
                <div class="mt-3 d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-outline-primary" id="aeps_2fa_send_btn">{{ __('Send OTP') }}</button>
                    <button type="button" class="btn btn-primary" id="aeps_2fa_verify_btn">{{ __('Verify OTP') }}</button>
                </div>
                <div id="aeps_2fa_msg" class="mt-2 small"></div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header fw-semibold">{{ __('Step 2: Bank Selection') }}</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">{{ __('Select Bank') }}</label>
                        <select class="form-control" id="aeps_bank_id">
                            <option value="">{{ __('Select bank') }}</option>
                        </select>
                        <input type="hidden" id="aeps_bank_name" value="">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Transaction Type') }}</label>
                        <select class="form-control" id="aeps_transaction_type">
                            <option value="registration">{{ __('Registration') }}</option>
                            <option value="authentication">{{ __('Authentication') }}</option>
                        </select>
                    </div>
                </div>
                <div id="aeps_bank_msg" class="mt-2 small"></div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header fw-semibold">{{ __('Step 3: Registration') }}</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Aadhaar Number (12 digits)') }}</label>
                        <input type="text" class="form-control" id="aeps_reg_aadhaar" placeholder="XXXXXXXXXXXX" maxlength="12">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Mobile Number') }}</label>
                        <input type="text" class="form-control" id="aeps_reg_mobile" placeholder="{{ __('Enter mobile number') }}" maxlength="15">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">{{ __('PID / Biometric Data (Optional)') }}</label>
                        <textarea class="form-control" id="aeps_reg_pid_data" rows="4" placeholder="{{ __('Paste encrypted biometric / PID data if provider requires it') }}"></textarea>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" class="btn btn-outline-secondary" id="aeps_register_btn">{{ __('Register') }}</button>
                </div>
                <div id="aeps_register_msg" class="mt-2 small"></div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header fw-semibold">{{ __('Step 4: Authenticate / Transaction') }}</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Aadhaar Number (12 digits)') }}</label>
                        <input type="text" class="form-control" id="aeps_aadhaar" placeholder="XXXXXXXXXXXX" maxlength="12">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Mobile Number') }}</label>
                        <input type="text" class="form-control" id="aeps_auth_mobile" placeholder="{{ __('Enter mobile number') }}" maxlength="15">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Amount') }} (₹)</label>
                        <input type="number" class="form-control" id="aeps_amount" placeholder="0" min="1" step="1">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">{{ __('PID / Biometric Data (Optional)') }}</label>
                        <textarea class="form-control" id="aeps_auth_pid_data" rows="5" placeholder="{{ __('Paste biometric / PID XML or encrypted body if your provider requires it') }}"></textarea>
                    </div>
                </div>
                <div class="mt-3 d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-primary" id="aeps_authenticate_btn">{{ __('Authenticate') }}</button>
                </div>
                <div id="aeps_result" class="mt-20 p-3 border rounded d-none"></div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header fw-semibold">{{ __('Step 5: Status Enquiry') }}</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">{{ __('Reference ID') }}</label>
                        <input type="text" class="form-control" id="aeps_status_reference_id" placeholder="{{ __('Enter reference id or use one returned above') }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-dark w-100" id="aeps_status_btn">{{ __('Check Status') }}</button>
                    </div>
                </div>
                <div id="aeps_status_result" class="mt-20 p-3 border rounded d-none"></div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var token = '{{ csrf_token() }}';
    var twoFaUrl = '{{ route("user.aeps.2fa") }}';
    var getBanksUrl = '{{ route("user.aeps.get_banks") }}';
    var registerUrl = '{{ route("user.aeps.register") }}';
    var authUrl = '{{ route("user.aeps.authenticate") }}';
    var statusUrl = '{{ route("user.aeps.status") }}';

    function setMessage(targetId, success, html) {
        var el = document.getElementById(targetId);
        el.classList.remove('d-none');
        el.innerHTML = html;
        if (!el.classList.contains('border')) {
            el.className = 'mt-2 small ' + (success ? 'text-success' : 'text-danger');
        }
    }

    function digitsOnly(value) {
        return (value || '').replace(/\D/g, '');
    }

    function postJson(url, body, done) {
        var payload = Object.assign({ _token: token }, body || {});
        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(function(r) { return r.json(); })
        .then(done)
        .catch(function() { done({ success: false, message: 'Request failed.' }); });
    }

    function syncMobileToForms() {
        var mobile = document.getElementById('aeps_mobile').value;
        if (!document.getElementById('aeps_reg_mobile').value) {
            document.getElementById('aeps_reg_mobile').value = mobile;
        }
        if (!document.getElementById('aeps_auth_mobile').value) {
            document.getElementById('aeps_auth_mobile').value = mobile;
        }
    }

    document.getElementById('aeps_2fa_send_btn').addEventListener('click', function() {
        var mobile = digitsOnly(document.getElementById('aeps_mobile').value);
        syncMobileToForms();
        postJson(twoFaUrl, { type: 'send', mobile: mobile }, function(res) {
            setMessage('aeps_2fa_msg', !!res.success, res.message || (res.success ? 'OTP sent.' : 'Failed to send OTP.'));
        });
    });

    document.getElementById('aeps_2fa_verify_btn').addEventListener('click', function() {
        var otp = digitsOnly(document.getElementById('aeps_otp').value);
        postJson(twoFaUrl, { type: 'verify', otp: otp }, function(res) {
            setMessage('aeps_2fa_msg', !!res.success, res.message || (res.success ? 'OTP verified.' : 'OTP verification failed.'));
        });
    });

    postJson(getBanksUrl, {}, function(res) {
        var sel = document.getElementById('aeps_bank_id');
        if (res.success && res.banks && res.banks.length) {
            res.banks.forEach(function(b) {
                var id = b.id || b.bank_id || b.code || '';
                var name = b.name || b.bank_name || id;
                sel.innerHTML += '<option value="' + id + '" data-name="' + (name || '').replace(/"/g, '&quot;') + '">' + name + '</option>';
            });
            setMessage('aeps_bank_msg', true, '{{ __("Bank list loaded.") }}');
        } else {
            setMessage('aeps_bank_msg', false, res.message || '{{ __("Unable to load bank list.") }}');
        }
    });

    document.getElementById('aeps_bank_id').addEventListener('change', function() {
        var opt = this.selectedOptions[0];
        document.getElementById('aeps_bank_name').value = opt ? (opt.getAttribute('data-name') || '') : '';
    });

    document.getElementById('aeps_register_btn').addEventListener('click', function() {
        var bankId = document.getElementById('aeps_bank_id').value;
        var bankName = document.getElementById('aeps_bank_name').value;
        var aadhaar = digitsOnly(document.getElementById('aeps_reg_aadhaar').value);
        var mobile = digitsOnly(document.getElementById('aeps_reg_mobile').value || document.getElementById('aeps_mobile').value);
        var pidData = document.getElementById('aeps_reg_pid_data').value.trim();
        var transactionType = document.getElementById('aeps_transaction_type').value;

        if (!bankId || aadhaar.length !== 12) {
            setMessage('aeps_register_msg', false, '{{ __("Select bank and enter valid 12-digit Aadhaar.") }}');
            return;
        }

        this.disabled = true;
        postJson(registerUrl, {
            bank_id: bankId,
            bank_name: bankName,
            aadhaar_number: aadhaar,
            mobile: mobile,
            transaction_type: transactionType,
            pid_data: pidData
        }, function(res) {
            document.getElementById('aeps_register_btn').disabled = false;
            setMessage('aeps_register_msg', !!res.success, res.message || (res.success ? 'Registered successfully.' : 'Registration failed.'));
        });
    });

    document.getElementById('aeps_authenticate_btn').addEventListener('click', function() {
        var bankId = document.getElementById('aeps_bank_id').value;
        var bankName = document.getElementById('aeps_bank_name').value;
        var aadhaar = digitsOnly(document.getElementById('aeps_aadhaar').value);
        var mobile = digitsOnly(document.getElementById('aeps_auth_mobile').value || document.getElementById('aeps_mobile').value);
        var amount = document.getElementById('aeps_amount').value;
        var pidData = document.getElementById('aeps_auth_pid_data').value.trim();
        var transactionType = document.getElementById('aeps_transaction_type').value;

        if (!bankId || aadhaar.length !== 12 || !amount || parseFloat(amount) < 1) {
            setMessage('aeps_result', false, '<span class="text-danger">{{ __("Please select bank, enter valid 12-digit Aadhaar and amount.") }}</span>');
            return;
        }

        this.disabled = true;
        postJson(authUrl, {
            bank_id: bankId,
            bank_name: bankName,
            aadhaar_number: aadhaar,
            mobile: mobile,
            amount: amount,
            transaction_type: transactionType,
            pid_data: pidData
        }, function(res) {
            document.getElementById('aeps_authenticate_btn').disabled = false;
            var html = (res.success ? '<span class="text-success">' : '<span class="text-danger">') + (res.message || '') + '</span>';
            if (res.reference_id) {
                html += '<br><small>Ref: ' + res.reference_id + '</small>';
                document.getElementById('aeps_status_reference_id').value = res.reference_id;
            }
            if (res.data) {
                html += '<pre class="mt-2 mb-0 bg-light p-2 rounded small">' + JSON.stringify(res.data, null, 2) + '</pre>';
            }
            setMessage('aeps_result', !!res.success, html);
        });
    });

    document.getElementById('aeps_status_btn').addEventListener('click', function() {
        var referenceId = document.getElementById('aeps_status_reference_id').value.trim();
        if (!referenceId) {
            setMessage('aeps_status_result', false, '<span class="text-danger">{{ __("Please enter reference id.") }}</span>');
            return;
        }
        this.disabled = true;
        postJson(statusUrl, { reference_id: referenceId }, function(res) {
            document.getElementById('aeps_status_btn').disabled = false;
            var html = (res.success ? '<span class="text-success">' : '<span class="text-danger">') + (res.message || '') + '</span>';
            html += '<pre class="mt-2 mb-0 bg-light p-2 rounded small">' + JSON.stringify(res, null, 2) + '</pre>';
            setMessage('aeps_status_result', !!res.success, html);
        });
    });
});
</script>
@endsection
