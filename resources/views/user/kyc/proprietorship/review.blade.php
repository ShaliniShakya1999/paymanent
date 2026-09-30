@extends('user.kyc.layout')
@section('kyc_content')
@php $currentStep = 'review'; @endphp
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4 p-md-5">
        <h2 class="h5 fw-semibold text-dark mb-1">{{ __('Review & Submit') }}</h2>
        <p class="text-muted small mb-2">{{ __('Complete this step to continue.') }}</p>
        <p class="text-muted small mb-4">{{ __('Document checklist for your entity. Upload any missing items in the steps above, then click Submit for Verification.') }}</p>
        <ul class="list-group list-group-flush mb-4">
            @foreach($checklist['documents'] ?? [] as $docKey => $doc)
                <li class="list-group-item d-flex align-items-center justify-content-between px-0">
                    <span>{{ __($doc['label']) }}</span>
                    @if($uploaded->has($docKey))
                        <span class="badge bg-success">{{ __('Uploaded') }}</span>
                    @else
                        <span class="badge bg-secondary">{{ __('Missing') }}</span>
                    @endif
                </li>
            @endforeach
        </ul>
        <p class="text-muted small mb-2">{{ __('Verification attempts') }}: {{ $remainingAttempts ?? 0 }} {{ __('left out of') }} {{ $maxAttempts ?? 3 }}</p>
        <form action="{{ route('user.kyc.proprietorship.submit') }}" method="post">
            @csrf
            @if($canSubmit)
                <button type="submit" class="btn btn-primary btn-lg">{{ __('Submit for Verification') }}</button>
            @else
                @if(($remainingAttempts ?? 0) <= 0)
                    <p class="text-danger small mb-2">{{ __('You have used all verification attempts. Please contact support.') }}</p>
                @else
                    <p class="text-warning small mb-2">{{ __('Upload all required documents in the steps above before submitting.') }}</p>
                @endif
                <button type="button" class="btn btn-secondary btn-lg" disabled>{{ __('Submit for Verification') }}</button>
            @endif
        </form>
    </div>
</div>
@endsection
