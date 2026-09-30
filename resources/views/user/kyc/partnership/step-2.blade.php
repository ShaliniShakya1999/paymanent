@extends('user.kyc.layout')
@section('kyc_content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4 p-md-5">
        <h2 class="h5 fw-semibold text-dark mb-1">{{ __('Partnership Deed') }}</h2>
        <p class="text-muted small mb-4">{{ __('Signed Partnership Deed.') }}</p>
        <form action="{{ route('user.kyc.partnership.step.store', ['step' => 2]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-medium">{{ __('Upload document') }} <span class="text-danger">*</span></label>
                <input type="file" name="partnership_deed" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                @if($uploaded->has('partnership_deed'))<span class="badge bg-success mt-1">{{ __('Uploaded') }}</span>@endif
                @error('partnership_deed')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Save & Continue') }}</button>
        </form>
    </div>
</div>
@endsection
