@extends('user.layouts.app_no_sidebar')
@section('title', __('Complete KYC'))
@section('content')
<style>
/* KYC category – full-width, stable flex; visible radio on every card */
.kyc-wrap { background: linear-gradient(180deg, #f8f9fc 0%, #fff 100%); min-height: 100vh; }
.kyc-cat-card { border: 0; border-radius: 20px; box-shadow: 0 8px 32px rgba(57, 47, 107, 0.1); }
.kyc-cat-card .card-body { overflow: visible; }

.kyc-entity-option {
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    margin: 0;
    gap: 1rem;
    border: 2px solid #e2e6ee;
    border-radius: 14px;
    padding: 1.25rem 1.35rem;
    cursor: pointer;
    transition: border-color 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
    background: #fff;
    position: relative;
    overflow: visible;
}
.kyc-entity-option:hover {
    border-color: #a8a0f0;
    background: #fafaff;
}
/* Use kyc-entity-option--active only — global .selected { height:64px } in style.css breaks this page */
.kyc-entity-option.kyc-entity-option--active,
.kyc-entity-option:has(input:checked) {
    border-color: #635bfe;
    background: linear-gradient(135deg, #f8f9ff 0%, #f3f2ff 100%);
    box-shadow: 0 4px 16px rgba(99, 91, 254, 0.12);
}

/* Left radio ring — same for every row, selected = filled dot */
.kyc-radio-ring {
    flex-shrink: 0;
    width: 22px;
    height: 22px;
    min-width: 22px;
    margin-top: 2px;
    border-radius: 50%;
    border: 2px solid #c8cdd8;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: border-color 0.2s ease, background 0.2s ease;
    pointer-events: none;
}
.kyc-entity-option.kyc-entity-option--active .kyc-radio-ring,
.kyc-entity-option:has(input:checked) .kyc-radio-ring {
    border-color: #635bfe;
}
.kyc-radio-ring::after {
    content: '';
    width: 0;
    height: 0;
    border-radius: 50%;
    background: #635bfe;
    transition: width 0.15s ease, height 0.15s ease;
}
.kyc-entity-option.kyc-entity-option--active .kyc-radio-ring::after,
.kyc-entity-option:has(input:checked) .kyc-radio-ring::after {
    width: 10px;
    height: 10px;
}

.kyc-entity-option .entity-content {
    flex: 1 1 auto;
    min-width: 0;
    padding: 0;
    border: none !important;
    box-shadow: none !important;
    background: transparent !important;
}
.kyc-entity-option .entity-title {
    font-weight: 700;
    color: #25212f;
    font-size: 1.05rem;
    line-height: 1.35;
    display: block;
}
.kyc-entity-option .entity-desc {
    color: #6a6b87;
    font-size: 0.9rem;
    margin-top: 0.35rem;
    display: block;
    line-height: 1.6;
    word-wrap: break-word;
    overflow-wrap: anywhere;
}

.kyc-entity-option::after,
.kyc-entity-option::before,
.kyc-entity-option .entity-content::after,
.kyc-entity-option .entity-content::before {
    display: none !important;
    content: none !important;
}

.kyc-btn-continue {
    background: linear-gradient(135deg, #635bfe 0%, #7c75ff 100%);
    border: 0;
    border-radius: 12px;
    padding: 0.85rem 2rem;
    font-weight: 600;
    font-size: 1rem;
    box-shadow: 0 4px 18px rgba(99, 91, 254, 0.4);
    transition: transform 0.2s, box-shadow 0.2s;
}
.kyc-btn-continue:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(99, 91, 254, 0.45); color: #fff; }

@media (min-width: 992px) {
    .kyc-category-inner { max-width: 920px; margin-left: auto; margin-right: auto; }
}
</style>
<div class="container-fluid py-4 py-md-5 kyc-wrap">
    <div class="row justify-content-center">
        <div class="col-12 kyc-category-inner px-3 px-md-4">
            <div class="kyc-cat-card card">
                <div class="card-body p-4 p-md-5">
                    <h1 class="h4 mb-1 fw-bold text-dark" style="letter-spacing: -0.02em;">{{ __('Complete KYC') }}</h1>
                    <p class="text-muted mb-4">{{ __('Select your merchant category to proceed with document verification.') }}</p>

                    <form action="{{ route('user.kyc.category.store') }}" method="post">
                        @csrf
                        <div class="row g-3">
                            @foreach($entities as $key => $entity)
                            <div class="col-12">
                                <label class="d-block kyc-entity-option mb-0 {{ old('merchant_category') == $key ? 'kyc-entity-option--active' : '' }}" data-entity="{{ $key }}">
                                    <input type="radio" name="merchant_category" value="{{ $key }}" class="visually-hidden" {{ old('merchant_category') == $key ? 'checked' : '' }} required>
                                    <span class="kyc-radio-ring" aria-hidden="true"></span>
                                    <span class="entity-content">
                                        <span class="entity-title">{{ __($entity['label']) }}</span>
                                        <span class="entity-desc">{{ __($entity['description']) }}</span>
                                    </span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @error('merchant_category')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <div class="mt-4 pt-2">
                            <button type="submit" class="btn btn-primary kyc-btn-continue px-4">{{ __('Continue') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
(function() {
    function syncSelected() {
        document.querySelectorAll('.kyc-entity-option').forEach(function(opt) {
            var radio = opt.querySelector('input[type="radio"]');
            if (radio && radio.checked) {
                opt.classList.add('kyc-entity-option--active');
            } else {
                opt.classList.remove('kyc-entity-option--active');
            }
        });
    }
    document.querySelectorAll('.kyc-entity-option').forEach(function(el) {
        el.addEventListener('click', function() {
            document.querySelectorAll('.kyc-entity-option').forEach(function(o) { o.classList.remove('kyc-entity-option--active'); });
            this.classList.add('kyc-entity-option--active');
            var r = this.querySelector('input[type="radio"]');
            if (r) r.checked = true;
        });
    });
    document.querySelectorAll('.kyc-entity-option input[type="radio"]').forEach(function(radio) {
        radio.addEventListener('change', syncSelected);
    });
    syncSelected();
})();
</script>
@endpush
@endsection
