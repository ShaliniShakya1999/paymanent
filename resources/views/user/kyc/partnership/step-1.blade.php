@extends('user.kyc.layout')
@section('kyc_content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4 p-md-5">
        <h2 class="h5 fw-semibold text-dark mb-1">{{ __('Firm PAN') }}</h2>
        <p class="text-muted small mb-4">{{ __('Complete this step to continue.') }}</p>
        <form action="{{ route('user.kyc.partnership.step.store', ['step' => 1]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-medium">{{ __('Firm PAN Number') }} <span class="text-danger">*</span></label>
                <input type="text" name="firm_pan_number" class="form-control form-control-lg text-uppercase" placeholder="AAAAA9999A" maxlength="10" value="{{ old('firm_pan_number') }}" required>
                @error('firm_pan_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-medium">{{ __('Firm PAN Card (Image/PDF)') }} <span class="text-danger">*</span></label>
                <input type="file" name="firm_pan_file" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                @if($uploaded->has('firm_pan'))<span class="badge bg-success mt-1">{{ __('Uploaded') }}</span>@endif
                @error('firm_pan_file')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Save & Continue') }}</button>
        </form>
    </div>
</div>
@endsection
