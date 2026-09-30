@extends('user.layouts.app')

@section('content')
<div class="bg-white pxy-62 shadow" id="panOcrIndex">
    <p class="mb-0 f-26 gilroy-Semibold text-uppercase text-center">{{ __('PAN OCR') }}</p>
    <p class="mb-0 text-center f-13 gilroy-medium text-gray mt-4 dark-A0">{{ __('Upload PAN card image or PDF to fetch OCR details from provider API') }}</p>
    <p class="mb-0 text-center f-18 gilroy-medium text-dark dark-5B mt-2">{{ $content_title ?? __('PAN OCR') }}</p>

    @include('user.common.alert')

    <div class="mt-28">
        <div class="label-top mt-20">
            <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Document Type') }}</label>
            <input type="text" class="form-control input-form-control apply-bg" value="PAN" readonly>
        </div>

        <div class="label-top mt-20">
            <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Side Selection') }}</label>
            <select class="form-control input-form-control apply-bg" id="pan_ocr_back">
                <option value="both">{{ __('Both Sides') }}</option>
                <option value="front">{{ __('Front Only') }}</option>
                <option value="back">{{ __('Back Only') }}</option>
            </select>
        </div>

        <div class="label-top mt-20">
            <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Upload PAN Document') }}</label>
            <input type="file" class="form-control input-form-control apply-bg" id="pan_ocr_document" accept=".jpg,.jpeg,.png,.pdf">
            <small class="text-muted d-block mt-2">{{ __('Allowed: JPG, JPEG, PNG, PDF. Max 5MB.') }}</small>
        </div>

        <div class="mt-4">
            <button type="button" class="btn btn-primary" id="pan_ocr_verify_btn">{{ __('Upload & Verify') }}</button>
        </div>

        <div id="pan_ocr_status_card" class="mt-20 p-3 border rounded d-none" style="display:none;"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var verifyUrl = '{{ route("sprintverify.pan.ocr") }}';
    var csrf = '{{ csrf_token() }}';
    var verifyBtn = document.getElementById('pan_ocr_verify_btn');

    function escapeHtml(value) {
        return String(value === null || value === undefined ? '' : value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatField(label, field) {
        if (!field || typeof field !== 'object') {
            return '';
        }

        var value = field.value !== undefined && field.value !== null ? field.value : '';
        var confidence = field.confidence !== undefined && field.confidence !== null ? field.confidence : '';

        return '' +
            '<div class="col-md-6 mt-12">' +
                '<div class="p-3" style="border:1px solid #e9ecef;border-radius:8px;">' +
                    '<p class="mb-1 text-muted f-12">' + escapeHtml(label) + '</p>' +
                    '<p class="mb-0 text-dark gilroy-medium">' + escapeHtml(value || '-') + '</p>' +
                    (confidence !== '' ? '<p class="mb-0 mt-1 text-success f-12">{{ __("Confidence") }}: ' + escapeHtml(confidence) + '%</p>' : '') +
                '</div>' +
            '</div>';
    }

    function renderOcrResult(res) {
        var card = document.getElementById('pan_ocr_status_card');
        var html = '';
        var items = Array.isArray(res.data) ? res.data : [];

        card.classList.remove('d-none');
        card.style.display = 'block';

        html += res.success
            ? '<p class="text-success mb-0">' + escapeHtml(res.message || '{{ __("PAN OCR verified successfully.") }}') + '</p>'
            : '<p class="text-danger mb-0">' + escapeHtml(res.message || '{{ __("PAN OCR failed.") }}') + '</p>';

        if (res.reference_id) {
            html += '<p class="f-12 text-muted mt-1 mb-0">{{ __("Reference ID") }}: ' + escapeHtml(res.reference_id) + '</p>';
        }

        if (items.length) {
            html += '<div class="row mt-3">';
            items.forEach(function(item) {
                html += formatField('{{ __("Document Type") }}', { value: item.document_type || '-' });
                html += formatField('{{ __("PAN Number") }}', item.pan_number);
                html += formatField('{{ __("Full Name") }}', item.full_name);
                html += formatField('{{ __("Father Name") }}', item.father_name);
                html += formatField('{{ __("Date of Birth") }}', item.dob);
            });
            html += '</div>';
        } else if (res.raw) {
            html += '<pre class="f-12 mt-3 mb-0 bg-light p-3 rounded">' + escapeHtml(JSON.stringify(res.raw, null, 2)) + '</pre>';
        }

        card.innerHTML = html;
    }

    verifyBtn.addEventListener('click', function() {
        var back = document.getElementById('pan_ocr_back').value;
        var documentFile = document.getElementById('pan_ocr_document').files[0];

        if (!documentFile) {
            alert('{{ __("Please select a document.") }}');
            return;
        }

        var formData = new FormData();
        formData.append('_token', csrf);
        formData.append('type', 'PAN');
        formData.append('back', back);
        formData.append('document', documentFile);

        verifyBtn.disabled = true;
        fetch(verifyUrl, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: formData
        }).then(function(r) { return r.json(); }).then(function(res) {
            verifyBtn.disabled = false;
            renderOcrResult(res || {});
        }).catch(function() {
            verifyBtn.disabled = false;
            var card = document.getElementById('pan_ocr_status_card');
            card.classList.remove('d-none');
            card.style.display = 'block';
            card.innerHTML = '<p class="text-danger mb-0">{{ __("Request failed. Please try again.") }}</p>';
        });
    });
});
</script>
@endsection
