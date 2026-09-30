@extends('user.kyc.layout')
@section('kyc_content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4 p-md-5">
        <h2 class="h5 fw-semibold text-dark mb-1">{{ __('Authorization') }}</h2>
        <p class="text-muted small mb-4">{{ __('Letter authorizing one partner and Bank mandate.') }}</p>
        <form action="{{ route('user.kyc.partnership.step.store', ['step' => 4]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-medium">{{ __('Letter authorizing one partner') }} <span class="text-danger">*</span></label>
                <input type="file" name="letter_authorizing_partner" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                @if($uploaded->has('letter_authorizing_partner'))<span class="badge bg-success mt-1">{{ __('Uploaded') }}</span>@endif
                @error('letter_authorizing_partner')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-medium">{{ __('Bank mandate') }} <span class="text-danger">*</span></label>
                <input type="file" name="bank_mandate" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                @if($uploaded->has('bank_mandate'))<span class="badge bg-success mt-1">{{ __('Uploaded') }}</span>@endif
                @error('bank_mandate')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Save & Continue') }}</button>
        </form>
    </div>
</div>
@endsection
