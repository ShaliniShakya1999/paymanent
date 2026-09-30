@extends('user.layouts.app')
@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h4 mb-0 fw-semibold text-dark">{{ __('Individual – Identity & Documents') }}</h1>
                <a href="{{ route('user.kyc.category') }}" class="btn btn-outline-secondary btn-sm">{{ __('Change category') }}</a>
            </div>

            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted small">{{ __('Progress') }}</span>
                        <div class="flex-grow-1" style="max-width: 200px;">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progress['percentage'] }}%;" aria-valuenow="{{ $progress['uploaded'] }}" aria-valuemin="0" aria-valuemax="{{ $progress['total'] }}"></div>
                            </div>
                        </div>
                        <span class="small fw-medium">{{ $progress['uploaded'] }}/{{ $progress['total'] }}</span>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('user.kyc.individual.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-medium">{{ __('PAN Number') }} <span class="text-danger">*</span></label>
                            <input type="text" name="pan_number" class="form-control form-control-lg text-uppercase" placeholder="AAAAA9999A" maxlength="10" value="{{ old('pan_number') }}" required>
                            @error('pan_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium">{{ __('PAN Card (Image/PDF)') }} <span class="text-danger">*</span></label>
                            <input type="file" name="pan_file" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                            @if($uploaded->has('pan'))<span class="badge bg-success mt-1">{{ __('Uploaded') }}</span>@endif
                            @error('pan_file')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium">{{ __('Aadhaar Number (12 digits)') }} <span class="text-danger">*</span></label>
                            <input type="text" name="aadhaar_number" class="form-control form-control-lg" placeholder="123456789012" maxlength="12" pattern="[0-9]{12}" value="{{ old('aadhaar_number') }}" required>
                            @error('aadhaar_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium">{{ __('Aadhaar Card – Front') }} <span class="text-danger">*</span></label>
                            <input type="file" name="aadhaar_front" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                            @if($uploaded->has('aadhaar_front'))<span class="badge bg-success mt-1">{{ __('Uploaded') }}</span>@endif
                            @error('aadhaar_front')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium">{{ __('Aadhaar Card – Back') }} <span class="text-danger">*</span></label>
                            <input type="file" name="aadhaar_back" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                            @if($uploaded->has('aadhaar_back'))<span class="badge bg-success mt-1">{{ __('Uploaded') }}</span>@endif
                            @error('aadhaar_back')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium">{{ __('Passport Size Photo') }} <span class="text-danger">*</span></label>
                            <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png" required>
                            @if($uploaded->has('photo'))<span class="badge bg-success mt-1">{{ __('Uploaded') }}</span>@endif
                            @error('photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <hr class="my-4">
                        <button type="submit" class="btn btn-primary btn-lg px-4">{{ __('Submit for verification') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
