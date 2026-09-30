@extends('user.kyc.layout')
@section('kyc_content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4 p-md-5">
        <h2 class="h5 fw-semibold text-dark mb-1">{{ __('Selfie & Agreement') }}</h2>
        <p class="text-muted small mb-4">{{ __('Live photo/selfie and Merchant agreement (e-sign).') }}</p>
        <form action="{{ route('user.kyc.individual.step.store', ['step' => 6]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-medium">{{ __('Live photo / Selfie') }} <span class="text-danger">*</span></label>
                <input type="file" name="selfie" class="form-control" accept=".jpg,.jpeg,.png" required>
                @if($uploaded->has('selfie'))<span class="badge bg-success mt-1">{{ __('Uploaded') }}</span>@endif
                @error('selfie')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-medium">{{ __('Merchant agreement (e-sign)') }} <span class="text-danger">*</span></label>
                <input type="file" name="merchant_agreement" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                @if($uploaded->has('merchant_agreement'))<span class="badge bg-success mt-1">{{ __('Uploaded') }}</span>@endif
                @error('merchant_agreement')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Save & Continue') }}</button>
        </form>
    </div>
</div>
@endsection
