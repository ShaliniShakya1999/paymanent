@extends('user.layouts.app_no_sidebar')
@section('title', __('KYC'))
@section('content')
<style>
.kyc-wrap { background: linear-gradient(180deg, #f8f9fc 0%, #fff 100%); min-height: 100vh; }
.kyc-sidebar { background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(57, 47, 107, 0.08); border: 1px solid rgba(57, 47, 107, 0.06); }
.kyc-sidebar .progress { height: 8px; border-radius: 999px; background: #e8e7ea; }
.kyc-sidebar .progress-bar { border-radius: 999px; background: linear-gradient(90deg, #635bfe, #8b85ff); transition: width 0.4s ease; }
.kyc-sidebar .nav-link { border-radius: 10px; transition: background 0.2s, color 0.2s; }
.kyc-sidebar .nav-link:hover { background: #f3f2ff; color: #392f6b !important; }
.kyc-sidebar .nav-link .rounded-circle { transition: transform 0.2s; }
.kyc-sidebar .nav-link:hover .rounded-circle { transform: scale(1.05); }
.kyc-card { border: 0; border-radius: 16px; box-shadow: 0 4px 24px rgba(57, 47, 107, 0.08); overflow: hidden; }
.kyc-card .card-body { padding: 2rem 2.5rem; }
.kyc-card .form-control, .kyc-card .form-select { border-radius: 10px; border-color: #e2e6ee; }
.kyc-card .form-control:focus, .kyc-card .form-select:focus { border-color: #635bfe; box-shadow: 0 0 0 3px rgba(99, 91, 254, 0.15); }
.kyc-btn-primary { background: linear-gradient(135deg, #635bfe 0%, #7c75ff 100%); border: 0; border-radius: 12px; padding: 0.75rem 1.75rem; font-weight: 600; box-shadow: 0 4px 14px rgba(99, 91, 254, 0.4); transition: transform 0.2s, box-shadow 0.2s; }
.kyc-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99, 91, 254, 0.45); }
.kyc-btn-add { background: linear-gradient(135deg, #2AAA5E 0%, #34c76c 100%); color: #fff; border: 0; border-radius: 12px; padding: 0.6rem 1.5rem; font-weight: 600; box-shadow: 0 4px 14px rgba(42, 170, 94, 0.35); transition: transform 0.2s; }
.kyc-btn-add:hover { color: #fff; transform: translateY(-1px); }
.kyc-partner-block { background: linear-gradient(135deg, #f8f9fc 0%, #f3f2ff 100%); border: 1px solid #e8e7ea; border-radius: 14px; padding: 1.5rem; transition: box-shadow 0.2s; }
.kyc-partner-block:hover { box-shadow: 0 8px 24px rgba(57, 47, 107, 0.08); }
.kyc-signatory-box { background: linear-gradient(135deg, #fff 0%, #f8f9fc 100%); border: 1px solid #e2e6ee; border-left: 4px solid #635bfe; border-radius: 14px; padding: 1.75rem; }
.kyc-heading { color: #25212f; font-weight: 700; letter-spacing: -0.02em; }
.kyc-sub { color: #6a6b87; font-size: 0.9375rem; }
</style>
<div class="container-fluid py-4 kyc-wrap">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-3 mb-4 mb-md-0">
            <div class="kyc-sidebar card border-0 sticky-top p-3 p-md-4" style="top: 1rem;">
                <a href="{{ route('user.kyc.category') }}" class="d-inline-flex align-items-center text-decoration-none kyc-sub small mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-1" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/></svg>
                    {{ __('Change business type') }}
                </a>
                <div class="progress mb-2" style="height: 8px;">
                    <div class="progress-bar" role="progressbar" style="width: {{ $progress['percentage'] ?? 0 }}%;"></div>
                </div>
                <p class="small kyc-sub mb-3">{{ __('Progress') }}: <strong class="text-dark">{{ $progress['uploaded'] ?? 0 }}</strong> / {{ $progress['total'] ?? 0 }}</p>
                <nav class="nav flex-column gap-1">
                    @foreach($steps as $index => $s)
                        @if(($s['key'] ?? '') === 'review')
                            <a href="{{ route('user.kyc.' . $entity . '.review') }}" class="nav-link py-2 px-3 d-flex align-items-center {{ (isset($currentStep) && $currentStep === 'review') ? 'text-primary fw-semibold' : 'kyc-sub' }}">
                                <span class="rounded-circle d-inline-flex align-items-center justify-content-center me-3 {{ (isset($currentStep) && $currentStep === 'review') ? 'bg-primary text-white' : 'bg-light' }}" style="width: 32px; height: 32px; font-size: 13px;">{{ $index + 1 }}</span>
                                <span>{{ __($s['title']) }}</span>
                            </a>
                        @else
                            @php $stepNum = $index + 1; @endphp
                            <a href="{{ route('user.kyc.' . $entity . '.step', ['step' => $stepNum]) }}" class="nav-link py-2 px-3 d-flex align-items-center {{ (isset($step) && $step == $stepNum) ? 'text-primary fw-semibold' : 'kyc-sub' }}">
                                @if(isset($step) && $step > $stepNum)
                                    <span class="rounded-circle d-inline-flex align-items-center justify-content-center me-3 bg-success text-white" style="width: 32px; height: 32px;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg></span>
                                @else
                                    <span class="rounded-circle d-inline-flex align-items-center justify-content-center me-3 {{ (isset($step) && $step == $stepNum) ? 'bg-primary text-white' : 'bg-light' }}" style="width: 32px; height: 32px; font-size: 13px;">{{ $stepNum }}</span>
                                @endif
                                <span>{{ __($s['title']) }}</span>
                            </a>
                        @endif
                    @endforeach
                </nav>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-9">
            @yield('kyc_content')
        </div>
    </div>
</div>
@endsection
