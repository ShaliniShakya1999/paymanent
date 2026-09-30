@extends('user.kyc.layout')
@section('kyc_content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4 p-md-5">
        <h2 class="h5 fw-semibold text-dark mb-1">{{ __('Bank Proof') }}</h2>
        <p class="text-muted small mb-4">{{ __('Current Account Cancelled Cheque.') }}</p>
        <form action="{{ route('user.kyc.proprietorship.step.store', ['step' => 4]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label class="form-label fw-medium">{{ __('Bank name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="kyc_bank_name" class="form-control @error('kyc_bank_name') is-invalid @enderror" value="{{ old('kyc_bank_name', $detail->kyc_bank_name ?? '') }}" placeholder="{{ __('e.g. State Bank of India') }}" required>
                    @error('kyc_bank_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-medium">{{ __('Account holder name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="kyc_bank_account_holder_name" class="form-control @error('kyc_bank_account_holder_name') is-invalid @enderror" value="{{ old('kyc_bank_account_holder_name', $detail->kyc_bank_account_holder_name ?? '') }}" placeholder="{{ __('Name as in bank account') }}" required>
                    @error('kyc_bank_account_holder_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label fw-medium">{{ __('Account number') }} <span class="text-danger">*</span></label>
                    <input type="text" name="kyc_bank_account_number" class="form-control @error('kyc_bank_account_number') is-invalid @enderror" value="{{ old('kyc_bank_account_number', $detail->kyc_bank_account_number ?? '') }}" placeholder="{{ __('e.g. 123456789012') }}" required>
                    @error('kyc_bank_account_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label fw-medium">{{ __('IFSC code') }} <span class="text-danger">*</span></label>
                    <input type="text" name="kyc_bank_ifsc_code" class="form-control @error('kyc_bank_ifsc_code') is-invalid @enderror" value="{{ old('kyc_bank_ifsc_code', $detail->kyc_bank_ifsc_code ?? '') }}" placeholder="{{ __('e.g. SBIN0001234') }}" maxlength="11" required>
                    @error('kyc_bank_ifsc_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-medium">{{ __('Upload document') }} <span class="text-danger">*</span></label>
                <input type="file" name="bank_proof" class="form-control @error('bank_proof') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf" required>
                @if($uploaded->has('bank_proof'))<span class="badge bg-success mt-1">{{ __('Uploaded') }}</span>@endif
                @error('bank_proof')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Save & Continue') }}</button>
        </form>
    </div>
</div>
@endsection
