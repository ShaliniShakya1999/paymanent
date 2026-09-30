@extends('user.layouts.app')

@section('content')
<div class="bg-white pxy-62 shadow" id="billPaymentDashboard">
    <p class="mb-0 f-26 gilroy-Semibold text-uppercase text-center">{{ __('Bill Payment (BBPS)') }}</p>
    <p class="mb-0 text-center f-13 gilroy-medium text-gray mt-4 dark-A0">{{ __('Pay electricity, water, gas, mobile and other utility bills') }}</p>
    <p class="mb-0 text-center f-18 gilroy-medium text-dark dark-5B mt-2">{{ $content_title ?? __('Bill Payment') }}</p>

    @include('user.common.alert')

    <div class="mt-28" style="max-width: 980px; margin: 0 auto;">
        <div class="row">
            <div class="col-md-12">
                <div class="p-0">
                    <div>
                        <p class="mb-1 f-18 gilroy-Semibold text-dark">{{ __('Pay a Bill') }}</p>
                        <p class="mb-0 text-muted f-13">{{ __('Select category, operator and fetch the latest bill details before payment.') }}</p>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6 mt-20">
                            <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Category') }}</label>
                            <select class="form-control" id="bbps_category" style="display:block;visibility:visible;width:100%;">
                                <option value="">{{ __('Select category') }}</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-20">
                            <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Operator') }}</label>
                            <select class="form-control" id="bbps_operator" style="display:block;visibility:visible;width:100%;">
                                <option value="">{{ __('Select operator') }}</option>
                            </select>
                            <input type="hidden" id="bbps_operator_name" value="">
                        </div>

                        <div class="col-md-12 mt-20">
                            <label class="gilroy-medium text-gray-100 mb-2 f-15" id="bbps_consumer_label">{{ __('Consumer / Account Number') }}</label>
                            <input type="text" class="form-control input-form-control apply-bg" id="bbps_consumer_number" placeholder="{{ __('Select operator first, then enter as per label') }}">
                            <small class="text-muted f-12 mt-1 d-block" id="bbps_consumer_hint">{{ __('Select category and operator to see what to enter, such as Consumer ID, CA Number, Mobile Number or K Number.') }}</small>
                        </div>

                    </div>

                    <div class="mt-4">
                        <button type="button" class="btn btn-primary" id="bbps_fetch_bill_btn">{{ __('Fetch Bill Details') }}</button>
                        <button type="button" class="btn btn-default" id="bbps_reset_btn" style="margin-left: 8px;">{{ __('Reset') }}</button>
                    </div>

                    <div id="bbps_inline_message" class="mt-3 d-none p-3 border rounded"></div>
                </div>
            </div>
        </div>

        <div id="bbps_bill_summary" class="mt-20 p-4 d-none bg-white">
            <div>
                <p class="mb-1 f-18 gilroy-Semibold">{{ __('Bill Summary') }}</p>
                <p class="mb-0 text-muted f-13">{{ __('Review fetched details carefully before making payment.') }}</p>
            </div>

            <input type="hidden" id="bbps_bill_fetch" value="">
            <input type="hidden" id="bbps_bill_amount_val" value="">

            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="p-3 bg-light" style="border-radius: 8px;">
                        <small class="text-muted d-block">{{ __('Amount') }}</small>
                        <strong id="bbps_bill_amount">0</strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light" style="border-radius: 8px;">
                        <small class="text-muted d-block">{{ __('Customer Name') }}</small>
                        <strong id="bbps_bill_name">—</strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light" style="border-radius: 8px;">
                        <small class="text-muted d-block">{{ __('Due Date') }}</small>
                        <strong id="bbps_bill_due_date">—</strong>
                    </div>
                </div>
            </div>

            <div class="mt-3 p-3 bg-light d-none" id="bbps_bill_raw_wrap" style="border-radius: 8px;">
                <small class="text-muted d-block mb-2">{{ __('Fetched Bill Data') }}</small>
                <div id="bbps_bill_raw" class="row"></div>
            </div>

            <div class="mt-4">
                <button type="button" class="btn btn-success" id="bbps_pay_btn">{{ __('Confirm & Pay') }}</button>
                <button type="button" class="btn btn-default" id="bbps_hide_summary_btn" style="margin-left: 8px;">{{ __('Hide Summary') }}</button>
            </div>
        </div>

        <div class="mt-20 p-4 bg-white">
            <div>
                <p class="mb-1 f-18 gilroy-Semibold">{{ __('Status Enquiry') }}</p>
                <p class="mb-0 text-muted f-13">{{ __('Check the payment status any time using the reference ID.') }}</p>
            </div>

            <div class="row mt-3">
                <div class="col-md-9">
                    <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Reference ID') }}</label>
                    <input type="text" class="form-control input-form-control apply-bg" id="bbps_reference_id" placeholder="{{ __('Enter payment reference id') }}">
                </div>
                <div class="col-md-3">
                    <label class="gilroy-medium text-gray-100 mb-2 f-15">&nbsp;</label>
                    <button type="button" class="btn btn-default btn-block" id="bbps_status_btn">{{ __('Check Status') }}</button>
                </div>
            </div>
        </div>

        <div id="bbps_status_card" class="mt-20 p-3 border rounded d-none"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var baseUrl = '{{ url("/") }}';
    var csrf = '{{ csrf_token() }}';
    var operators = [];
    var categories = [];

    function showInlineMessage(success, message) {
        var el = document.getElementById('bbps_inline_message');
        el.classList.remove('d-none');
        el.className = 'mt-3 p-3 border rounded ' + (success ? 'border-success text-success' : 'border-danger text-danger');
        el.textContent = message || '';
    }

    function showStatusCard(success, html) {
        var card = document.getElementById('bbps_status_card');
        card.classList.remove('d-none');
        card.innerHTML = html || '';
        card.className = 'mt-20 p-3 border rounded ' + (success ? 'border-success' : 'border-danger');
    }

    function resetSummary() {
        document.getElementById('bbps_bill_summary').classList.add('d-none');
        document.getElementById('bbps_bill_fetch').value = '';
        document.getElementById('bbps_bill_amount_val').value = '';
        document.getElementById('bbps_bill_amount').textContent = '0';
        document.getElementById('bbps_bill_name').textContent = '—';
        document.getElementById('bbps_bill_due_date').textContent = '—';
        document.getElementById('bbps_bill_raw').innerHTML = '';
        document.getElementById('bbps_bill_raw_wrap').classList.add('d-none');
    }

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatBillData(raw) {
        var html = '';
        Object.keys(raw || {}).forEach(function(key) {
            var value = raw[key];
            if (value !== null && typeof value === 'object') {
                value = JSON.stringify(value);
            }
            html += ''
                + '<div class="col-md-6 mt-2">'
                + '  <div class="bg-white p-3" style="border-radius: 8px;">'
                + '    <small class="text-muted d-block">' + escapeHtml(key) + '</small>'
                + '    <strong style="word-break: break-word;">' + escapeHtml(value === null || value === undefined || value === '' ? '—' : value) + '</strong>'
                + '  </div>'
                + '</div>';
        });
        return html;
    }

    function buildFormattedResponse(raw) {
        if (!raw || typeof raw !== 'object') {
            return '';
        }
        return '<div class="mt-3"><div class="row">' + formatBillData(raw) + '</div></div>';
    }

    function getOperators() {
        fetch(baseUrl + '/bill-payment/get-operators', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: JSON.stringify({ mode: document.getElementById('bbps_category').value })
        }).then(function(r) { return r.json(); }).then(function(res) {
            if (res.success && res.operators && res.operators.length) {
                operators = res.operators;
                categories = res.categories || [];
                var catSel = document.getElementById('bbps_category');
                catSel.innerHTML = '<option value="">{{ __("Select category") }}</option>';
                categories.forEach(function(c) {
                    catSel.innerHTML += '<option value="' + c + '">' + c + '</option>';
                });
                showInlineMessage(true, '{{ __("Operator list loaded successfully.") }}');
            } else {
                showInlineMessage(false, res.message || '{{ __("Unable to load operator list.") }}');
            }
            fillOperators();
        }).catch(function() {
            document.getElementById('bbps_operator').innerHTML = '<option value="">{{ __("Failed to load") }}</option>';
            showInlineMessage(false, '{{ __("Request failed while loading operators.") }}');
        });
    }

    function fillOperators() {
        var cat = document.getElementById('bbps_category').value;
        var opSel = document.getElementById('bbps_operator');
        opSel.innerHTML = '<option value="">{{ __("Select operator") }}</option>';
        operators.filter(function(o) {
            return !cat || (o.category || o.operator_type) === cat;
        }).forEach(function(o) {
            var id = o.operator_id || o.id || o.operatorId;
            var name = o.operator_name || o.name || o.operatorName || id;
            var displayName = (o.displayname || o.display_name || 'Consumer / Account Number').replace(/"/g, '&quot;');
            opSel.innerHTML += '<option value="' + id + '" data-name="' + (name || '').replace(/"/g, '&quot;') + '" data-displayname="' + displayName + '">' + name + '</option>';
        });
        updateConsumerFieldHint();
    }

    function updateConsumerFieldHint() {
        var opSel = document.getElementById('bbps_operator');
        var opt = opSel.options[opSel.selectedIndex];
        var labelEl = document.getElementById('bbps_consumer_label');
        var inputEl = document.getElementById('bbps_consumer_number');
        var hintEl = document.getElementById('bbps_consumer_hint');
        var displayName = opt ? (opt.getAttribute('data-displayname') || '').replace(/&quot;/g, '"') : '';
        if (displayName) {
            labelEl.textContent = displayName;
            inputEl.placeholder = '{{ __("Enter") }} ' + displayName;
            hintEl.textContent = '{{ __("Enter the") }} ' + displayName + ' {{ __("exactly as shown on your bill.") }}';
        } else {
            labelEl.textContent = '{{ __("Consumer / Account Number") }}';
            inputEl.placeholder = '{{ __("Select operator first, then enter as per label") }}';
            hintEl.textContent = '{{ __("Select category and operator to see what to enter, such as Consumer ID, CA Number, Mobile Number or K Number.") }}';
        }
    }

    document.getElementById('bbps_category').addEventListener('change', function() {
        fillOperators();
        resetSummary();
    });

    document.getElementById('bbps_operator').addEventListener('change', function() {
        var opt = this.options[this.selectedIndex];
        document.getElementById('bbps_operator_name').value = opt ? opt.getAttribute('data-name') || '' : '';
        updateConsumerFieldHint();
        resetSummary();
    });

    document.getElementById('bbps_reset_btn').addEventListener('click', function() {
        document.getElementById('bbps_category').value = '';
        document.getElementById('bbps_operator').innerHTML = '<option value="">{{ __("Select operator") }}</option>';
        document.getElementById('bbps_operator_name').value = '';
        document.getElementById('bbps_consumer_number').value = '';
        document.getElementById('bbps_reference_id').value = '';
        document.getElementById('bbps_inline_message').classList.add('d-none');
        document.getElementById('bbps_status_card').classList.add('d-none');
        fillOperators();
        resetSummary();
    });

    document.getElementById('bbps_hide_summary_btn').addEventListener('click', function() {
        resetSummary();
    });

    document.getElementById('bbps_fetch_bill_btn').addEventListener('click', function() {
        var opId = document.getElementById('bbps_operator').value;
        var canumber = document.getElementById('bbps_consumer_number').value.trim();
        if (!opId || !canumber) {
            showInlineMessage(false, '{{ __("Please select operator and enter consumer number.") }}');
            return;
        }
        this.disabled = true;
        fetch(baseUrl + '/bill-payment/fetch-bill', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: JSON.stringify({
                operator_id: opId,
                consumer_number: canumber,
                mode: document.getElementById('bbps_category').value
            })
        }).then(function(r) { return r.json(); }).then(function(res) {
            document.getElementById('bbps_fetch_bill_btn').disabled = false;
            if (res.success && res.bill_fetch != null) {
                var raw = (typeof res.bill_fetch === 'object') ? res.bill_fetch : {};
                document.getElementById('bbps_bill_fetch').value = typeof res.bill_fetch === 'object' ? JSON.stringify(res.bill_fetch) : res.bill_fetch;
                document.getElementById('bbps_bill_amount').textContent = res.amount != null ? res.amount : '—';
                document.getElementById('bbps_bill_amount_val').value = res.amount != null ? res.amount : '0';
                document.getElementById('bbps_bill_name').textContent = (raw.name || raw.userName || (res.data && res.data.name) || '—');
                document.getElementById('bbps_bill_due_date').textContent = (raw.duedate || raw.dueDate || (res.data && res.data.duedate) || '—');
                if (typeof res.bill_fetch === 'object') {
                    document.getElementById('bbps_bill_raw').innerHTML = formatBillData(res.bill_fetch);
                    document.getElementById('bbps_bill_raw_wrap').classList.remove('d-none');
                }
                document.getElementById('bbps_bill_summary').classList.remove('d-none');
                showInlineMessage(true, res.message || '{{ __("Bill details fetched successfully.") }}');
            } else {
                resetSummary();
                showInlineMessage(false, res.message || '{{ __("Failed to fetch bill.") }}');
            }
        }).catch(function() {
            document.getElementById('bbps_fetch_bill_btn').disabled = false;
            showInlineMessage(false, '{{ __("Request failed while fetching bill.") }}');
        });
    });

    document.getElementById('bbps_pay_btn').addEventListener('click', function() {
        var payload = {
            operator_id: document.getElementById('bbps_operator').value,
            operator_name: document.getElementById('bbps_operator_name').value,
            category: document.getElementById('bbps_category').value,
            consumer_number: document.getElementById('bbps_consumer_number').value.trim(),
            amount: document.getElementById('bbps_bill_amount_val').value,
            bill_fetch: document.getElementById('bbps_bill_fetch').value,
            mode: document.getElementById('bbps_category').value,
            _token: csrf
        };
        this.disabled = true;
        fetch(baseUrl + '/bill-payment/pay', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        }).then(function(r) { return r.json(); }).then(function(res) {
            document.getElementById('bbps_pay_btn').disabled = false;
            var html = res.success
                ? '<p class="text-success mb-0">' + (res.message || 'Success') + '</p><p class="f-12 mt-1">Ref: ' + (res.reference_id || '') + '</p>'
                : '<p class="text-danger mb-0">' + (res.message || 'Payment failed') + '</p>';
            if (res.data) {
                html += buildFormattedResponse(res.data);
            }
            showStatusCard(!!res.success, html);
            if (res.reference_id) {
                document.getElementById('bbps_reference_id').value = res.reference_id;
            }
            if (res.success) {
                resetSummary();
            }
        }).catch(function() {
            document.getElementById('bbps_pay_btn').disabled = false;
            showStatusCard(false, '<p class="text-danger mb-0">{{ __("Request failed while paying bill.") }}</p>');
        });
    });

    document.getElementById('bbps_status_btn').addEventListener('click', function() {
        var referenceId = document.getElementById('bbps_reference_id').value.trim();
        if (!referenceId) {
            showStatusCard(false, '<p class="text-danger mb-0">{{ __("Please enter reference ID.") }}</p>');
            return;
        }
        this.disabled = true;
        fetch(baseUrl + '/bill-payment/status', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: JSON.stringify({ reference_id: referenceId, _token: csrf })
        }).then(function(r) { return r.json(); }).then(function(res) {
            document.getElementById('bbps_status_btn').disabled = false;
            var success = !!(res.success || res.status || (res.response_code === 1));
            var html = '<p class="' + (success ? 'text-success' : 'text-danger') + ' mb-2">' + (res.message || '{{ __("Status fetched.") }}') + '</p>';
            html += buildFormattedResponse(res);
            showStatusCard(success, html);
        }).catch(function() {
            document.getElementById('bbps_status_btn').disabled = false;
            showStatusCard(false, '<p class="text-danger mb-0">{{ __("Request failed while checking status.") }}</p>');
        });
    });

    getOperators();
});
</script>
@endsection
