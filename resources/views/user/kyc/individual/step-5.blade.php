@extends('user.kyc.layout')
@section('kyc_content')
@php
    $user = auth()->user();
    $mobile = $user->formattedPhone ?? $user->phone ?? null;
    $email = $user->email ?? null;
@endphp
<div class="card border-0 shadow-sm rounded-3 overflow-hidden">
    <div class="card-body p-4 p-md-5">
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary mb-3" style="width: 56px; height: 56px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                </svg>
            </div>
            <h2 class="h5 fw-semibold text-dark mb-1">{{ __('Contact Verification') }}</h2>
            <p class="text-muted small mb-0">{{ __('Your mobile and email are linked to your account.') }}</p>
        </div>

        <form action="{{ route('user.kyc.individual.step.store', ['step' => 5]) }}" method="post">
            @csrf
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 border bg-light bg-opacity-50">
                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-white border shadow-sm text-primary flex-shrink-0" style="width: 44px; height: 44px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3 2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V2zm6.5 0a.5.5 0 0 0-1 0v1a.5.5 0 0 0 1 0V2zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="text-muted small text-uppercase fw-medium mb-0">{{ __('Mobile') }}</div>
                            <div class="fw-semibold text-dark">{{ $mobile ?: __('Not set') }}</div>
                        </div>
                        @if($mobile)
                        <span class="badge bg-success rounded-pill px-2 py-1 flex-shrink-0">{{ __('Linked') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 border bg-light bg-opacity-50">
                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-white border shadow-sm text-primary flex-shrink-0" style="width: 44px; height: 44px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Zm3.708 6.208L1 11.105V5.383l4.708 2.825ZM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2Z"/>
                                <path d="M14.247 14.269c1.01 0 1.587-.493 1.93-1.177a2.636 2.636 0 0 0 0-2.184c-.343-.684-.92-1.177-1.93-1.177h-.013a2.997 2.997 0 0 0-2.083 1.098A3.636 3.636 0 0 0 13 14.09c0 .784.182 1.914.954 2.126.769.21 1.865-.468 1.865-1.956h.003Z"/>
                            </svg>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="text-muted small text-uppercase fw-medium mb-0">{{ __('Email') }}</div>
                            <div class="fw-semibold text-dark text-break">{{ $email ?: __('Not set') }}</div>
                        </div>
                        @if($email)
                        <span class="badge bg-success rounded-pill px-2 py-1 flex-shrink-0">{{ __('Linked') }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg px-4 py-2 rounded-3 fw-semibold">{{ __('Continue') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
