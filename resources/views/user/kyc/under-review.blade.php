@extends('user.layouts.app_no_sidebar')
@section('title', __('KYC Under Verification'))
@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 text-center">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-warning bg-opacity-25 text-warning" style="width: 80px; height: 80px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                            </svg>
                        </span>
                    </div>
                    <h1 class="h4 fw-semibold text-dark mb-2">{{ __('KYC Under Verification') }}</h1>
                    <p class="text-muted mb-0">{{ __('Please wait, your documents are under verification. We will notify you once the verification is complete.') }}</p>
                    <p class="small text-muted mt-2">{{ __('Dashboard access will be enabled after approval.') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
