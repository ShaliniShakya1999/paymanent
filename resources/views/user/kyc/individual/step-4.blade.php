@extends('user.kyc.layout')
@section('kyc_content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4 p-md-5">
        <h2 class="h5 fw-semibold text-dark mb-1">{{ __('Business Proof') }}</h2>
        <p class="text-muted small mb-4">{{ __('Self-declaration OR Utility bill (shop/home address). If you have it, upload here; otherwise you can skip and continue.') }}</p>
        <form action="{{ route('user.kyc.individual.step.store', ['step' => 4]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-medium">{{ __('Upload document') }} <span class="text-muted">({{ __('optional') }})</span></label>
                <input type="file" name="business_proof" class="form-control @error('business_proof') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf">
                @if($uploaded->has('business_proof'))<span class="badge bg-success mt-1">{{ __('Uploaded') }}</span>@endif
                @error('business_proof')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Save & Continue') }}</button>
        </form>
    </div>
</div>
@endsection
