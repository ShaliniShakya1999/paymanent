@extends('user.layouts.app')

@section('content')
<div class="bg-white pxy-62 shadow" id="mcaVerifyIndex" style="width:100%; max-width:100%; box-sizing:border-box;">
    <p class="mb-0 f-26 gilroy-Semibold text-uppercase text-center">{{ __('MCA Verification') }}</p>
    <p class="mb-0 text-center f-13 gilroy-medium text-gray mt-4 dark-A0">{{ __('Verify company details by CIN / company number (PaySprint SprintVerify UAT)') }}</p>
    <p class="mb-0 text-center f-18 gilroy-medium text-dark dark-5B mt-2">{{ $content_title ?? __('MCA Verification') }}</p>

    @include('user.common.alert')

    <div class="mt-28 container-fluid" style="width:100%; max-width:100%; margin:0; padding-left:0; padding-right:0;">
        <div class="label-top mt-20 mca-field-row">
            <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Reference ID') }} (refid)</label>
            <input type="text" class="form-control input-form-control apply-bg w-100 mca-wide-input" id="mca_refid" placeholder="{{ __('e.g. 34543') }}" maxlength="64">
        </div>

        <div class="label-top mt-20 mca-field-row">
            <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('CIN / Company ID') }} (id_number)</label>
            <input type="text" class="form-control input-form-control apply-bg w-100 mca-wide-input" id="mca_id_number" placeholder="{{ __('e.g. U72900MH2017PTC294101') }}" maxlength="64">
        </div>

        <div class="mt-4">
            <button type="button" class="btn btn-primary px-4 py-2" id="mca_verify_btn">{{ __('Verify') }}</button>
        </div>

        <div id="mca_result_card" class="mt-20 p-3 p-md-4 border rounded d-none mca-result-full" style="display:none;width:100%;max-width:100%;box-sizing:border-box;"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var verifyUrl = '{{ route("sprintverify.mca.verify") }}';
    var csrf = '{{ csrf_token() }}';
    var card = document.getElementById('mca_result_card');

    function escapeHtml(value) {
        return String(value === null || value === undefined ? '' : value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function kvTableRow(label, value) {
        if (value === null || value === undefined || value === '') value = '-';
        return '<tr><th scope="row" class="mca-kv-label gilroy-medium f-14 text-muted align-top">' + escapeHtml(label) + '</th>' +
            '<td class="mca-kv-value gilroy-medium f-14 text-dark align-top">' + escapeHtml(String(value)) + '</td></tr>';
    }

    function kvTableFromPairs(pairs) {
        if (!pairs.length) return '';
        var body = '';
        pairs.forEach(function(p) {
            body += kvTableRow(p[0], p[1]);
        });
        return '<div class="table-responsive mca-kv-wrap w-100 mb-3">' +
            '<table class="table table-bordered table-striped mca-data-table mca-kv-table w-100 mb-0"><tbody>' + body + '</tbody></table></div>';
    }

    function renderMcaData(data) {
        if (!data || typeof data !== 'object') {
            return '<pre class="f-12 mt-2 mb-0 bg-light p-3 rounded">' + escapeHtml(JSON.stringify(data, null, 2)) + '</pre>';
        }

        var html = '';
        var top = ['client_id', 'company_id', 'company_type', 'company_name'];
        var topPairs = [];
        top.forEach(function(k) {
            if (data[k] !== undefined) {
                topPairs.push([k.replace(/_/g, ' '), data[k]]);
            }
        });
        html += kvTableFromPairs(topPairs);

        var details = data.details || {};
        var ci = details.company_info || {};
        if (Object.keys(ci).length) {
            var ciPairs = [];
            Object.keys(ci).forEach(function(k) {
                ciPairs.push([k.replace(/_/g, ' '), ci[k]]);
            });
            html += '<p class="mt-4 mb-2 f-16 gilroy-Semibold text-dark">{{ __("Company info") }}</p>' + kvTableFromPairs(ciPairs);
        }

        var directors = details.directors;
        if (Array.isArray(directors) && directors.length) {
            html += '<p class="mt-4 mb-2 f-16 gilroy-Semibold text-dark">{{ __("Directors") }}</p>' +
                '<div class="table-responsive mca-kv-wrap w-100"><table class="table table-bordered table-striped table-sm mca-data-table w-100">' +
                '<thead><tr><th>DIN</th><th>{{ __("Name") }}</th><th>{{ __("Start") }}</th><th>{{ __("End") }}</th></tr></thead><tbody>';
            directors.forEach(function(d) {
                html += '<tr><td>' + escapeHtml(d.din_number || '') + '</td><td>' + escapeHtml(d.director_name || '') + '</td>' +
                    '<td>' + escapeHtml(d.start_date || '') + '</td><td>' + escapeHtml(d.end_date || '') + '</td></tr>';
            });
            html += '</tbody></table></div>';
        }

        var charges = details.charges;
        if (Array.isArray(charges) && charges.length) {
            html += '<p class="mt-4 mb-2 f-16 gilroy-Semibold text-dark">{{ __("Charges") }}</p>' +
                '<div class="table-responsive mca-kv-wrap w-100"><table class="table table-bordered table-striped table-sm mca-data-table w-100">' +
                '<thead><tr><th>{{ __("Assets") }}</th><th>{{ __("Amount") }}</th><th>{{ __("Created") }}</th><th>{{ __("Status") }}</th></tr></thead><tbody>';
            charges.forEach(function(c) {
                html += '<tr><td>' + escapeHtml(c.assets_under_charge || '-') + '</td><td>' + escapeHtml(c.charge_amount || '') + '</td>' +
                    '<td>' + escapeHtml(c.date_of_creation || '') + '</td><td>' + escapeHtml(c.status || '') + '</td></tr>';
            });
            html += '</tbody></table></div>';
        }

        if (html === '') {
            return '<pre class="f-12 mt-2 mb-0 bg-light p-3 rounded">' + escapeHtml(JSON.stringify(data, null, 2)) + '</pre>';
        }
        return html;
    }

    document.getElementById('mca_verify_btn').addEventListener('click', function() {
        var refid = document.getElementById('mca_refid').value.trim();
        var idNumber = document.getElementById('mca_id_number').value.trim();
        if (!refid || !idNumber) {
            alert('{{ __("Please enter Reference ID and CIN / company ID.") }}');
            return;
        }
        this.disabled = true;
        fetch(verifyUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ refid: refid, id_number: idNumber })
        }).then(function(r) { return r.json(); }).then(function(res) {
            document.getElementById('mca_verify_btn').disabled = false;
            card.classList.remove('d-none');
            card.style.display = 'block';
            var ok = res && res.success;
            var head = ok
                ? '<p class="text-success mb-1">' + escapeHtml(res.message || '{{ __("Success") }}') + '</p>'
                : '<p class="text-danger mb-1">' + escapeHtml((res && res.message) || '{{ __("Verification failed.") }}') + '</p>';
            if (res && res.reference_id) {
                head += '<p class="f-12 text-muted mb-2">{{ __("Provider reference_id") }}: ' + escapeHtml(String(res.reference_id)) + '</p>';
            }
            if (res && res.data) {
                head += renderMcaData(res.data);
            } else if (res && res.raw) {
                head += '<pre class="f-12 mt-2 mb-0 bg-light p-3 rounded">' + escapeHtml(JSON.stringify(res.raw, null, 2)) + '</pre>';
            }
            card.innerHTML = head;
        }).catch(function() {
            document.getElementById('mca_verify_btn').disabled = false;
            card.classList.remove('d-none');
            card.style.display = 'block';
            card.innerHTML = '<p class="text-danger mb-0">{{ __("Request failed. Please try again.") }}</p>';
        });
    });
});
</script>
<style>
/* MCA page only: full-width content (theme default uses large horizontal padding on .main-containt) */
.main-containt {
  padding-left: 20px !important;
  padding-right: 20px !important;
}
#mcaVerifyIndex .mca-field-row,
#mcaVerifyIndex .mca-field-row .mca-wide-input {
  width: 100%;
  max-width: 100%;
  box-sizing: border-box;
}
#mcaVerifyIndex .mca-wide-input {
  min-height: 52px;
}
#mcaVerifyIndex .mca-result-full .mca-kv-wrap {
  margin-left: 0;
  margin-right: 0;
}
#mcaVerifyIndex .mca-kv-table {
  table-layout: fixed;
  width: 100% !important;
}
#mcaVerifyIndex .mca-kv-table th.mca-kv-label {
  width: 32%;
  max-width: 280px;
  padding: 12px 14px;
  font-weight: 500;
  vertical-align: top;
}
#mcaVerifyIndex .mca-kv-table td.mca-kv-value {
  padding: 12px 14px;
  word-break: break-word;
  overflow-wrap: anywhere;
  white-space: normal;
}
#mcaVerifyIndex .mca-data-table thead th {
  padding: 10px 12px;
}
#mcaVerifyIndex .mca-data-table {
  width: 100% !important;
}
</style>
@endsection
