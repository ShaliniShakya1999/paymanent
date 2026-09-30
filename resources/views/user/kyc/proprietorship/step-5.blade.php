@extends('user.kyc.layout')
@section('kyc_content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4 p-md-5">
        <h2 class="h5 fw-semibold text-dark mb-1">{{ __('Address Proof') }}</h2>
        <p class="text-muted small mb-4">{{ __('Enter your business address and upload proof document.') }}</p>
        <form action="{{ route('user.kyc.proprietorship.step.store', ['step' => 5]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label class="form-label fw-medium">{{ __('Address line 1') }} <span class="text-danger">*</span></label>
                    <input type="text" name="address_1" class="form-control form-control-lg @error('address_1') is-invalid @enderror" value="{{ old('address_1', $detail->address_1 ?? '') }}" placeholder="{{ __('Street, building, area') }}" required>
                    @error('address_1')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-medium">{{ __('Address line 2') }} <span class="text-muted">({{ __('optional') }})</span></label>
                    <input type="text" name="address_2" class="form-control form-control-lg @error('address_2') is-invalid @enderror" value="{{ old('address_2', $detail->address_2 ?? '') }}" placeholder="{{ __('Landmark, floor, etc.') }}">
                    @error('address_2')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label fw-medium">{{ __('City') }} <span class="text-danger">*</span></label>
                    <input type="text" name="city" class="form-control form-control-lg @error('city') is-invalid @enderror" value="{{ old('city', $detail->city ?? '') }}" placeholder="{{ __('City') }}" required>
                    @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label fw-medium">{{ __('State') }} <span class="text-danger">*</span></label>
                    <input type="text" name="state" class="form-control form-control-lg @error('state') is-invalid @enderror" value="{{ old('state', $detail->state ?? '') }}" placeholder="{{ __('State') }}" required>
                    @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-medium">{{ __('Upload document') }} <span class="text-danger">*</span></label>
                <input type="file" name="address_proof" class="form-control @error('address_proof') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf" required>
                @if($uploaded->has('address_proof'))<span class="badge bg-success mt-1">{{ __('Uploaded') }}</span>@endif
                @error('address_proof')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                <small class="text-muted d-block mt-1">{{ __('Utility bill, rent agreement or other proof of business address.') }}</small>
            </div>
            <button type="submit" class="btn btn-primary btn-lg px-4 rounded-3 fw-semibold">{{ __('Save & Continue') }}</button>
        </form>
    </div>
</div>
@endsection
