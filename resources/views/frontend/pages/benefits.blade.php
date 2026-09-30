@extends('frontend.layouts.app')

@section('content')
    <!-- Benefits Hero Section -->
    <div class="benefits-hero-section border-bottom">
        <div class="px-240">
            <div class="row align-items-center">
                <div class="col-lg-7 col-xl-7">
                    <nav class="customize-bcrm mb-2">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Benefits') }}</li>
                        </ol>
                    </nav>
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(99, 91, 254, 0.12); color: #635BFE; font-weight: 700; font-size: 12px; letter-spacing: 0.5px;">
                        <span class="live-status-dot"></span>
                        {{ __('THE PLATFORM ADVANTAGE') }}
                    </div>
                    <div class="merchant-text">
                        <h1 class="gilroy-Semibold color-05B f-40 leading-48 mb-3">{{ __('Engineered for Speed, Built for Trust, Priced for Growth') }}</h1>
                        <p class="gilroy-regular color-5B f-17 leading-26 mb-4">
                            {{ __('Discover how :x empowers individuals and businesses with low costs, instantaneous settlement, multi-currency versatility, and uncompromising security standards.', ['x' => settings('name')]) }}
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ auth()->check() ? url('dashboard') : url('register') }}" class="btn btn-primary px-4 py-3 gilroy-medium rounded-pill text-white shadow-sm">
                                <i class="fas fa-rocket me-2"></i> {{ auth()->check() ? __('Go to Dashboard') : __('Join Now') }}
                            </a>
                            <a href="{{ url('services') }}" class="btn btn-outline-secondary px-4 py-3 gilroy-medium rounded-pill">
                                <i class="fas fa-th-large me-2"></i> {{ __('Explore Services') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Core Pillars + Extended Advantages -->
    <div class="px-240 py-5">
        <div class="row g-4 mb-5">
            <!-- Benefit 1: Low Cost -->
            <div class="col-lg-6">
                <div class="p-4 p-md-5 rounded-4 bg-white border h-100 shadow-sm benefit-pillar-box">
                    <div class="d-flex align-items-center mb-4">
                        <div class="benefit-icon-wrapper p-3 rounded-circle bg-light me-3">
                            <svg width="40" height="40" viewBox="0 0 58 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="29" cy="32" r="28" fill="#F8B12C" fill-opacity="0.2"/>
                                <path d="M29 16V48M21 24H33C35.2091 24 37 25.7909 37 28C37 30.2091 35.2091 32 33 32H25C22.7909 32 21 33.7909 21 36C21 38.2091 22.7909 40 25 40H37" stroke="#F8B12C" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <span class="badge bg-light text-warning mb-1">{{ __('Cost Efficiency') }}</span>
                            <h3 class="gilroy-Semibold color-05B f-24 mb-0">{{ __('Ultra-Low Transaction Costs') }}</h3>
                        </div>
                    </div>
                    <p class="gilroy-regular color-5B f-16 mb-4">
                        {{ __('Traditional financial systems impose heavy layers of intermediary fees. We streamline payment routing to pass deep savings directly to you.') }}
                    </p>
                    <ul class="list-unstyled mb-0 feature-specs-list">
                        <li class="d-flex align-items-start mb-2 f-15 color-5B">
                            <i class="fas fa-check text-success me-2 mt-1"></i>
                            <span>{{ __('Zero monthly maintenance, account setup, or hidden inactivity fees.') }}</span>
                        </li>
                        <li class="d-flex align-items-start mb-2 f-15 color-5B">
                            <i class="fas fa-check text-success me-2 mt-1"></i>
                            <span>{{ __('Competitive merchant transaction fees with transparent volume pricing tiers.') }}</span>
                        </li>
                        <li class="d-flex align-items-start f-15 color-5B">
                            <i class="fas fa-check text-success me-2 mt-1"></i>
                            <span>{{ __('Free internal wallet-to-wallet transfers between verified platform users.') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Benefit 2: Easy Process -->
            <div class="col-lg-6">
                <div class="p-4 p-md-5 rounded-4 bg-white border h-100 shadow-sm benefit-pillar-box">
                    <div class="d-flex align-items-center mb-4">
                        <div class="benefit-icon-wrapper p-3 rounded-circle bg-light me-3">
                            <svg width="40" height="40" viewBox="0 0 58 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="29" cy="32" r="28" fill="#58B868" fill-opacity="0.2"/>
                                <path d="M19 32L26 39L39 24" stroke="#58B868" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <span class="badge bg-light text-success mb-1">{{ __('Simplicity First') }}</span>
                            <h3 class="gilroy-Semibold color-05B f-24 mb-0">{{ __('Frictionless Onboarding & Setup') }}</h3>
                        </div>
                    </div>
                    <p class="gilroy-regular color-5B f-16 mb-4">
                        {{ __('No tedious in-person branch appointments or stacks of physical paperwork. Our entire onboarding workflow is 100% digital and intuitive.') }}
                    </p>
                    <ul class="list-unstyled mb-0 feature-specs-list">
                        <li class="d-flex align-items-start mb-2 f-15 color-5B">
                            <i class="fas fa-check text-success me-2 mt-1"></i>
                            <span>{{ __('Quick registration in under 2 minutes with email and password.') }}</span>
                        </li>
                        <li class="d-flex align-items-start mb-2 f-15 color-5B">
                            <i class="fas fa-check text-success me-2 mt-1"></i>
                            <span>{{ __('Automated KYC identity validation with rapid compliance approval.') }}</span>
                        </li>
                        <li class="d-flex align-items-start f-15 color-5B">
                            <i class="fas fa-check text-success me-2 mt-1"></i>
                            <span>{{ __('Simple, clean user interface with zero steep learning curves.') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Benefit 3: Faster Payments -->
            <div class="col-lg-6">
                <div class="p-4 p-md-5 rounded-4 bg-white border h-100 shadow-sm benefit-pillar-box">
                    <div class="d-flex align-items-center mb-4">
                        <div class="benefit-icon-wrapper p-3 rounded-circle bg-light me-3">
                            <svg width="40" height="40" viewBox="0 0 58 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="29" cy="32" r="28" fill="#635BFE" fill-opacity="0.2"/>
                                <path d="M31 16L19 34H29L27 48L39 30H29L31 16Z" fill="#635BFE"/>
                            </svg>
                        </div>
                        <div>
                            <span class="badge bg-light text-primary mb-1">{{ __('Lightning Speed') }}</span>
                            <h3 class="gilroy-Semibold color-05B f-24 mb-0">{{ __('Instant Real-Time Settlement') }}</h3>
                        </div>
                    </div>
                    <p class="gilroy-regular color-5B f-16 mb-4">
                        {{ __('Move money at the speed of the internet. Internal transactions clear within seconds, ensuring your cash flow stays continuous and uninterrupted.') }}
                    </p>
                    <ul class="list-unstyled mb-0 feature-specs-list">
                        <li class="d-flex align-items-start mb-2 f-15 color-5B">
                            <i class="fas fa-check text-success me-2 mt-1"></i>
                            <span>{{ __('Sub-second domestic and international wallet-to-wallet transfers.') }}</span>
                        </li>
                        <li class="d-flex align-items-start mb-2 f-15 color-5B">
                            <i class="fas fa-check text-success me-2 mt-1"></i>
                            <span>{{ __('Instant blockchain deposit confirmations via high-throughput Tatum nodes.') }}</span>
                        </li>
                        <li class="d-flex align-items-start f-15 color-5B">
                            <i class="fas fa-check text-success me-2 mt-1"></i>
                            <span>{{ __('Automated payouts and batch settlement for vendor payments and payroll.') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Benefit 4: Secure & Safe -->
            <div class="col-lg-6" id="security">
                <div class="p-4 p-md-5 rounded-4 bg-white border h-100 shadow-sm benefit-pillar-box">
                    <div class="d-flex align-items-center mb-4">
                        <div class="benefit-icon-wrapper p-3 rounded-circle bg-light me-3">
                            <svg width="40" height="40" viewBox="0 0 58 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="29" cy="32" r="28" fill="#1C60DD" fill-opacity="0.2"/>
                                <path d="M29 16L41 22V32C41 39.5 35.8 46.5 29 48C22.2 46.5 17 39.5 17 32V22L29 16Z" fill="#1C60DD"/>
                            </svg>
                        </div>
                        <div>
                            <span class="badge bg-light text-info mb-1">{{ __('Institutional Security') }}</span>
                            <h3 class="gilroy-Semibold color-05B f-24 mb-0">{{ __('Cryptographic Security & Safety') }}</h3>
                        </div>
                    </div>
                    <p class="gilroy-regular color-5B f-16 mb-4">
                        {{ __('Security is our foundation. From multi-factor authentication to cold custodial architecture, your balances and sensitive records remain protected.') }}
                    </p>
                    <ul class="list-unstyled mb-0 feature-specs-list">
                        <li class="d-flex align-items-start mb-2 f-15 color-5B">
                            <i class="fas fa-check text-success me-2 mt-1"></i>
                            <span>{{ __('End-to-end 256-bit TLS encryption across all web and mobile endpoints.') }}</span>
                        </li>
                        <li class="d-flex align-items-start mb-2 f-15 color-5B">
                            <i class="fas fa-check text-success me-2 mt-1"></i>
                            <span>{{ __('Two-factor authentication (Google Authenticator & SMS OTP) for withdrawals.') }}</span>
                        </li>
                        <li class="d-flex align-items-start f-15 color-5B">
                            <i class="fas fa-check text-success me-2 mt-1"></i>
                            <span>{{ __('Active machine learning anomaly detection to stop fraudulent charges in real time.') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparison Table: Legacy Banking vs PayMoney -->
    <div class="bg-light py-5">
        <div class="px-240">
            <div class="text-center mb-5">
                <span class="badge modal-badge text-uppercase mb-2">{{ __('Side-by-Side Comparison') }}</span>
                <h2 class="gilroy-Semibold color-05B f-34 mb-2">{{ __('How We Compare to Traditional Banking') }}</h2>
                <p class="gilroy-regular color-5B f-16 m-auto w-530">{{ __('See why forward-thinking companies are leaving legacy banking bottlenecks behind.') }}</p>
            </div>

            <div class="table-responsive rounded-4 shadow-sm bg-white border">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light border-bottom">
                        <tr>
                            <th class="py-4 px-4 gilroy-Semibold color-05B f-16" style="width: 35%;">{{ __('Feature / Service') }}</th>
                            <th class="py-4 px-4 text-muted f-15" style="width: 30%;">{{ __('Traditional Banks') }}</th>
                            <th class="py-4 px-4 text-primary gilroy-Semibold f-16 bg-light" style="width: 35%;">{{ settings('name') }}</th>
                        </tr>
                    </thead>
                    <tbody class="f-15 color-5B">
                        <tr>
                            <td class="py-3 px-4 gilroy-medium color-05B">{{ __('Transfer Settlement Time') }}</td>
                            <td class="py-3 px-4 text-muted"><i class="fas fa-times text-danger me-2"></i> {{ __('3 - 5 business days') }}</td>
                            <td class="py-3 px-4 text-success bg-light"><i class="fas fa-check-circle text-success me-2"></i> {{ __('Instant (sub-second)') }}</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 gilroy-medium color-05B">{{ __('Cross-Border FX Markup') }}</td>
                            <td class="py-3 px-4 text-muted"><i class="fas fa-times text-danger me-2"></i> {{ __('3.5% - 5.0% + wire fees') }}</td>
                            <td class="py-3 px-4 text-success bg-light"><i class="fas fa-check-circle text-success me-2"></i> {{ __('Real-time interbank rates (<1%)') }}</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 gilroy-medium color-05B">{{ __('Crypto & Fiat Unified Wallet') }}</td>
                            <td class="py-3 px-4 text-muted"><i class="fas fa-times text-danger me-2"></i> {{ __('Not supported / prohibited') }}</td>
                            <td class="py-3 px-4 text-success bg-light"><i class="fas fa-check-circle text-success me-2"></i> {{ __('Native BTC, ETH, USDT & Fiat') }}</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 gilroy-medium color-05B">{{ __('Account Opening Duration') }}</td>
                            <td class="py-3 px-4 text-muted"><i class="fas fa-times text-danger me-2"></i> {{ __('1 - 3 weeks with in-person visit') }}</td>
                            <td class="py-3 px-4 text-success bg-light"><i class="fas fa-check-circle text-success me-2"></i> {{ __('Under 2 minutes, 100% digital') }}</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 gilroy-medium color-05B">{{ __('Developer REST API & Webhooks') }}</td>
                            <td class="py-3 px-4 text-muted"><i class="fas fa-times text-danger me-2"></i> {{ __('Proprietary, expensive contracts') }}</td>
                            <td class="py-3 px-4 text-success bg-light"><i class="fas fa-check-circle text-success me-2"></i> {{ __('Open sandbox & instant API keys') }}</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 gilroy-medium color-05B">{{ __('Support Availability') }}</td>
                            <td class="py-3 px-4 text-muted"><i class="fas fa-times text-danger me-2"></i> {{ __('Banking hours only (Mon-Fri)') }}</td>
                            <td class="py-3 px-4 text-success bg-light"><i class="fas fa-check-circle text-success me-2"></i> {{ __('24/7/365 priority assistance') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Final Call to Action -->
    <div class="px-240 py-5 text-center">
        <div class="p-5 rounded-4 bg-primary text-white position-relative overflow-hidden">
            <h2 class="gilroy-Semibold f-34 mb-3 text-white">{{ __('Start Benefiting from Modern Fintech Today') }}</h2>
            <p class="gilroy-regular f-18 mb-4 text-white opacity-75 max-w-910p mx-auto">
                {{ __('Open your account now to unlock faster payments, lower costs, and complete digital asset control.') }}
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ auth()->check() ? url('dashboard') : url('register') }}" class="btn btn-light px-4 py-3 gilroy-medium rounded-pill text-primary">
                    {{ __('Open Your Account') }}
                </a>
                <a href="{{ url('services') }}" class="btn btn-outline-light px-4 py-3 gilroy-medium rounded-pill">
                    {{ __('Explore All Services') }}
                </a>
            </div>
        </div>
    </div>
@endsection
