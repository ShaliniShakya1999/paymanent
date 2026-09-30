@extends('user.layouts.app')

@section('content')
<div class="bg-white pxy-62 shadow" id="rechargeIndex">
    <p class="mb-0 f-26 gilroy-Semibold text-uppercase text-center">{{ __('Recharge') }}</p>
    <p class="mb-0 text-center f-13 gilroy-medium text-gray mt-4 dark-A0">{{ __('Mobile / DTH Recharge') }}</p>
    <p class="mb-0 text-center f-18 gilroy-medium text-dark dark-5B mt-2">{{ $content_title ?? __('Recharge') }}</p>

    @include('user.common.alert')

    <div class="mt-28" style="max-width: 980px; margin: 0 auto;">
        <div class="param-ref mt-20">
            <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Operator') }}</label>
            <select class="form-control select2" id="recharge_operator" style="display:block;visibility:visible;">
                <option value="">{{ __('Select operator') }}</option>
            </select>
            <input type="hidden" id="recharge_operator_name" value="">
        </div>

        <div class="label-top mt-20">
            <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Mobile Number') }}</label>
            <input type="text" class="form-control input-form-control apply-bg" id="recharge_mobile" placeholder="{{ __('Enter mobile number') }}" maxlength="15">
        </div>

        <div class="label-top mt-20">
            <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Amount') }} (₹)</label>
            <input type="text" class="form-control input-form-control apply-bg" id="recharge_amount" placeholder="{{ __('Enter amount') }}" onkeypress="return /[0-9.]/.test(String.fromCharCode(event.keyCode || event.which));">
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="button" class="btn btn-outline-primary" id="recharge_fetch_plans_btn">{{ __('Fetch Plans') }}</button>
            <button type="button" class="btn btn-primary" id="recharge_do_btn">{{ __('Recharge') }}</button>
        </div>

        <div id="recharge_status_card" class="mt-20 p-3 border rounded d-none" style="display:none;"></div>

        <div class="mt-20 p-4 bg-white">
            <p class="mb-1 f-18 gilroy-Semibold">{{ __('Status Enquiry') }}</p>
            <p class="mb-0 text-muted f-13">{{ __('Check recharge status using the reference ID returned after recharge.') }}</p>

            <div class="row mt-3">
                <div class="col-md-9">
                    <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Reference ID') }}</label>
                    <input type="text" class="form-control input-form-control apply-bg" id="recharge_reference_id" placeholder="{{ __('Enter recharge reference id') }}">
                </div>
                <div class="col-md-3">
                    <label class="gilroy-medium text-gray-100 mb-2 f-15">&nbsp;</label>
                    <button type="button" class="btn btn-primary btn-block w-100" id="recharge_status_btn">{{ __('Check Status') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('public/user/customs/js/rechargeService.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var baseUrl = '{{ url("/") }}';
    var csrf = '{{ csrf_token() }}';

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatResponseData(raw) {
        if (!raw || typeof raw !== 'object') {
            return '';
        }
        var html = '<div class="row mt-3">';
        Object.keys(raw).forEach(function(key) {
            var value = raw[key];
            if (value !== null && typeof value === 'object') {
                value = JSON.stringify(value);
            }
            html += ''
                + '<div class="col-md-6 mt-2">'
                + '  <div class="bg-light p-3" style="border-radius:8px;">'
                + '    <small class="text-muted d-block">' + escapeHtml(key) + '</small>'
                + '    <strong style="word-break:break-word;">' + escapeHtml(value === null || value === undefined || value === '' ? '—' : value) + '</strong>'
                + '  </div>'
                + '</div>';
        });
        html += '</div>';
        return html;
    }

    function renderRechargeResult(res, successFallback, failureFallback) {
        var card = document.getElementById('recharge_status_card');
        card.classList.remove('d-none');
        card.style.display = 'block';
        var html = res.success
            ? '<p class="text-success mb-0">' + (res.message || successFallback || 'Success') + '</p>'
            : '<p class="text-danger mb-0">' + (res.message || failureFallback || 'Recharge failed') + '</p>';
        if (res.reference_id) {
            html += '<p class="f-12 mt-1">Ref: ' + escapeHtml(res.reference_id) + '</p>';
            var refEl = document.getElementById('recharge_reference_id');
            if (refEl) refEl.value = res.reference_id;
        }
        if (res.data) {
            html += formatResponseData(res.data);
        }
        card.innerHTML = html;
    }

    function loadOperators() {
        if (typeof RechargeService !== 'undefined' && RechargeService.getOperators) {
            RechargeService.getOperators(baseUrl + '/recharge/get-operators', csrf, function(res) {
                if (res && res.success && res.operators && res.operators.length) {
                    var sel = document.getElementById('recharge_operator');
                    var first = sel.innerHTML;
                    sel.innerHTML = first;
                    res.operators.forEach(function(o) {
                        var id = o.operator_id || o.id || o.operatorId;
                        if (!/^\d+$/.test(String(id || '').trim())) return;
                        var name = o.operator_name || o.name || o.operatorName || id;
                        sel.innerHTML += '<option value="' + id + '" data-name="' + (name || '').replace(/"/g, '&quot;') + '">' + name + '</option>';
                    });
                }
            });
        } else {
            fetch(baseUrl + '/recharge/get-operators', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: JSON.stringify({})
            }).then(r => r.json()).then(function(res) {
                if (res.success && res.operators && res.operators.length) {
                    var sel = document.getElementById('recharge_operator');
                    var keep = '<option value="">Select operator</option>';
                    sel.innerHTML = keep;
                    res.operators.forEach(function(o) {
                        var id = o.operator_id || o.id || o.operatorId;
                        if (!/^\d+$/.test(String(id || '').trim())) return;
                        var name = o.operator_name || o.name || o.operatorName || id;
                        sel.innerHTML += '<option value="' + id + '" data-name="' + (name || '').replace(/"/g, '&quot;') + '">' + name + '</option>';
                    });
                }
            });
        }
    }

    document.getElementById('recharge_operator').addEventListener('change', function() {
        var opt = this.options[this.selectedIndex];
        document.getElementById('recharge_operator_name').value = opt ? opt.getAttribute('data-name') || '' : '';
    });

    document.getElementById('recharge_fetch_plans_btn').addEventListener('click', function() {
        renderRechargeResult({
            success: false,
            message: '{{ __("Plans / offers are not available because plan API is not configured. Recharge will work with manual amount entry.") }}'
        });
    });

    document.getElementById('recharge_do_btn').addEventListener('click', function() {
        var opId = document.getElementById('recharge_operator').value;
        var mobile = document.getElementById('recharge_mobile').value.trim();
        var amount = document.getElementById('recharge_amount').value.trim();
        if (opId && !/^\d+$/.test(opId)) {
            alert('{{ __("Please select a valid operator from the list.") }}');
            return;
        }
        if (!opId || !mobile || !amount || parseFloat(amount) < 1) {
            alert('{{ __("Please select operator, enter mobile number and valid amount.") }}');
            return;
        }
        var payload = {
            operator_id: opId,
            operator_name: document.getElementById('recharge_operator_name').value,
            mobile_number: mobile,
            amount: amount,
            _token: csrf
        };
        this.disabled = true;
        if (typeof RechargeService !== 'undefined' && RechargeService.doRecharge) {
            RechargeService.doRecharge(baseUrl + '/recharge/do', csrf, payload, function(res) {
                document.getElementById('recharge_do_btn').disabled = false;
                renderRechargeResult(res || { success: false, message: 'Recharge failed' }, 'Success', 'Recharge failed');
            });
        } else {
            fetch(baseUrl + '/recharge/do', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: JSON.stringify(payload)
            }).then(r => r.json()).then(function(res) {
                document.getElementById('recharge_do_btn').disabled = false;
                renderRechargeResult(res || { success: false, message: 'Recharge failed' }, 'Success', 'Recharge failed');
            }).catch(function() {
                document.getElementById('recharge_do_btn').disabled = false;
                renderRechargeResult({ success: false, message: 'Request failed.' });
            });
        }
    });

    document.getElementById('recharge_status_btn').addEventListener('click', function() {
        var referenceId = document.getElementById('recharge_reference_id').value.trim();
        if (!referenceId) {
            renderRechargeResult({ success: false, message: '{{ __("Please enter reference ID.") }}' });
            return;
        }
        this.disabled = true;
        fetch(baseUrl + '/recharge/status', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: JSON.stringify({ reference_id: referenceId, _token: csrf })
        }).then(function(r) { return r.json(); }).then(function(res) {
            document.getElementById('recharge_status_btn').disabled = false;
            var normalized = {
                success: !!(res.success || res.status || (res.response_code === 1)),
                message: res.message || '{{ __("Status fetched.") }}',
                data: res.data || res,
                reference_id: referenceId
            };
            renderRechargeResult(normalized, 'Status fetched.', 'Status check failed.');
        }).catch(function() {
            document.getElementById('recharge_status_btn').disabled = false;
            renderRechargeResult({ success: false, message: 'Request failed.' });
        });
    });

    loadOperators();
});
</script>
@endsection
