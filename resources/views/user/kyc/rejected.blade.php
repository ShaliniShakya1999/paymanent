@extends('user.layouts.app_no_sidebar')
@section('title', __('KYC Rejected'))
@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 text-center">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-25 text-danger" style="width: 80px; height: 80px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354z"/>
                            </svg>
                        </span>
                    </div>
                    <h1 class="h4 fw-semibold text-dark mb-2">{{ __('Your KYC documents have been rejected') }}</h1>
                    <p class="text-muted mb-3">{{ __('Please see the reason below, correct the issues and re-upload your documents.') }}</p>

                    @if(!empty($rejection_reason))
                    <div class="alert alert-warning border text-start mb-4">
                        <strong class="d-block small mb-1">{{ __('Reason for rejection') }}</strong>
                        <p class="mb-0">{{ $rejection_reason }}</p>
                    </div>
                    @endif

                    @if($can_resubmit ?? true)
                    <p class="text-muted small mb-3">
                        {{ __('Verification attempts left') }}: <strong>{{ $remaining_attempts ?? 0 }}</strong> / {{ $max_attempts ?? 3 }}
                    </p>
                    <a href="{{ route("user.kyc.{$entity}.step", ['step' => 1]) }}" class="btn btn-primary btn-lg px-4">{{ __('Correct and submit again') }}</a>
                    @else
                    <div class="alert alert-secondary text-start mb-4">
                        <strong>{{ __('You have used all verification attempts.') }}</strong>
                        <p class="mb-0 mt-1">{{ __('You can submit your documents for verification only :max times. Please contact support for further assistance.', ['max' => $max_attempts ?? 3]) }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
