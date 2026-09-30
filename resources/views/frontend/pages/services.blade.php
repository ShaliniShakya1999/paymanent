@extends('frontend.layouts.app')

@section('content')
    <!-- Services Hero Section -->
    <div class="services-hero-header border-bottom">
        <div class="px-240">
            <nav class="customize-bcrm mb-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Services') }}</li>
                </ol>
            </nav>

            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(99, 91, 254, 0.08); color: #635BFE; font-weight: 700; font-size: 13px;">
                <span class="live-status-dot"></span>
                <i class="fas fa-cubes"></i> {{ __('ENTERPRISE & PERSONAL FINTECH INFRASTRUCTURE') }}
            </div>

            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h1 class="gilroy-Semibold color-05B f-40 leading-48 mb-3">
                        {{ __('Financial Services Engineered for Modern Global Commerce') }}
                    </h1>
                    <p class="gilroy-regular color-5B f-17 leading-28 mb-4 max-w-910p">
                        {{ __('From multi-currency digital wallets and hosted merchant checkout to enterprise Tatum blockchain node integrations and virtual card issuance, :x delivers an institutional-grade financial platform for individuals, online merchants, and scaling enterprises.', ['x' => settings('name')]) }}
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ auth()->check() ? route('user.dashboard') : url('register') }}" class="btn btn-primary px-4 py-3 gilroy-medium rounded-pill text-white shadow-sm">
                            <i class="fas fa-rocket me-2"></i> {{ auth()->check() ? __('Go to Dashboard') : __('Create Free Account') }}
                        </a>
                        <a href="#developer-api" class="btn btn-outline-secondary px-4 py-3 gilroy-medium rounded-pill">
                            <i class="fas fa-code me-2"></i> {{ __('Explore Developer API') }}
                        </a>
                    </div>
                </div>

                <!-- Quick Stats Matrix -->
                <div class="col-lg-4">
                    <div class="p-4 rounded-4 bg-light border shadow-xs">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                            <span class="f-13 gilroy-Semibold text-muted text-uppercase">{{ __('Platform Reliability') }}</span>
                            <span class="badge bg-success-subtle text-success border border-success f-11 px-2 py-1 rounded-pill d-inline-flex align-items-center gap-1">
                                <span class="live-status-dot bg-success" style="width: 7px; height: 7px;"></span>
                                {{ __('All Systems Operational') }}
                            </span>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="p-3 bg-white rounded-3 border text-center">
                                    <div class="gilroy-Semibold f-22 color-05B text-primary">20+</div>
                                    <div class="f-12 text-muted mt-1">{{ __('Global Currencies') }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-white rounded-3 border text-center">
                                    <div class="gilroy-Semibold f-22 color-05B text-success">0%</div>
                                    <div class="f-12 text-muted mt-1">{{ __('Fee P2P Wallet') }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-white rounded-3 border text-center">
                                    <div class="gilroy-Semibold f-22 color-05B text-info" id="liveUptimeCounter">99.99%</div>
                                    <div class="f-12 text-muted mt-1">{{ __('API Node Uptime') }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-white rounded-3 border text-center">
                                    <div class="gilroy-Semibold f-22 color-05B text-warning">256-Bit</div>
                                    <div class="f-12 text-muted mt-1">{{ __('AES TLS Security') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Interactive Real-time Search & Filter Toolbar -->
            <div class="services-toolbar-box mt-5 pt-3 border-top">
                <div class="row align-items-center g-3">
                    <!-- Search Input -->
                    <div class="col-md-5 col-lg-4">
                        <div class="input-group service-search-group">
                            <span class="input-group-text bg-white border-end-0 text-muted ps-3">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" id="serviceSearchInput" class="form-control border-start-0 py-2" placeholder="{{ __('Search services, APIs, features...') }}" aria-label="{{ __('Search services') }}">
                            <button class="btn btn-outline-secondary border-start-0 bg-white text-muted d-none" type="button" id="clearSearchBtn">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Category Filter Tabs (Horizontally scrollable on mobile) -->
                    <div class="col-md-7 col-lg-8">
                        <div class="services-filter-scroll-wrapper" id="servicesFilterGroup">
                            <button type="button" class="service-filter-pill active" data-filter="all">
                                <i class="fas fa-th-large me-1"></i> {{ __('All Services') }}
                                <span class="badge bg-secondary-subtle text-dark ms-1 rounded-pill" id="count-all">6</span>
                            </button>
                            <button type="button" class="service-filter-pill" data-filter="personal">
                                <i class="fas fa-wallet me-1"></i> {{ __('Personal Wallets') }}
                                <span class="badge bg-secondary-subtle text-dark ms-1 rounded-pill" id="count-personal">3</span>
                            </button>
                            <button type="button" class="service-filter-pill" data-filter="business">
                                <i class="fas fa-store me-1"></i> {{ __('Merchant & Business') }}
                                <span class="badge bg-secondary-subtle text-dark ms-1 rounded-pill" id="count-business">3</span>
                            </button>
                            <button type="button" class="service-filter-pill" data-filter="crypto">
                                <i class="fab fa-bitcoin me-1"></i> {{ __('Crypto & Web3') }}
                                <span class="badge bg-secondary-subtle text-dark ms-1 rounded-pill" id="count-crypto">1</span>
                            </button>
                            <button type="button" class="service-filter-pill" data-filter="cards">
                                <i class="fas fa-credit-card me-1"></i> {{ __('Virtual Cards & Banking') }}
                                <span class="badge bg-secondary-subtle text-dark ms-1 rounded-pill" id="count-cards">2</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Search Status Bar -->
                <div class="d-flex justify-content-between align-items-center mt-2 px-1">
                    <span class="f-12 text-muted" id="serviceSearchStatus">{{ __('Showing all 6 enterprise & personal services') }}</span>
                    <a href="javascript:void(0)" class="f-12 text-primary text-decoration-none d-none" id="resetServicesFilterBtn">
                        <i class="fas fa-undo-alt me-1"></i> {{ __('Reset filters') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Services Grid -->
    <div class="px-240 py-5">
        <div class="row g-4" id="servicesCatalogGrid">

            <!-- 1. Multi-Currency Digital E-Wallet -->
            <div class="col-md-6 col-lg-4 service-grid-item" id="wallet" data-category="personal business" data-keywords="wallet multi-currency usd eur gbp p2p internal transfer instant tax voucher ledger personal">
                <div class="service-product-card">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="service-icon-box" style="background: rgba(99, 91, 254, 0.12); color: #635BFE;">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <span class="badge bg-light text-primary border px-3 py-1 rounded-pill f-12 gilroy-medium">{{ __('Personal & Business') }}</span>
                        </div>
                        <h3 class="gilroy-Semibold color-05B f-22 mb-2">{{ __('Multi-Currency Digital Wallet') }}</h3>
                        <p class="gilroy-regular color-5B f-15 leading-24 mb-4">
                            {{ __('Hold, convert, and manage balances in 20+ fiat currencies and cryptos with isolated ledger sub-accounts. Send instant payments to any user via email or phone.') }}
                        </p>
                        <div class="mb-3">
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Multi-Currency Ledgers (USD, EUR, GBP, CAD & more)') }}</span>
                            </div>
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Zero-fee peer-to-peer internal transfers in sub-seconds') }}</span>
                            </div>
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Transparent real-time foreign exchange conversions') }}</span>
                            </div>
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Branded payment requests & downloadable tax vouchers') }}</span>
                            </div>
                        </div>

                        <!-- Technical Specs Accordion Drawer -->
                        <div class="specs-drawer mb-3">
                            <button class="btn btn-sm btn-link text-decoration-none text-muted p-0 f-13 toggle-specs-btn" type="button" data-bs-toggle="collapse" data-bs-target="#specs-wallet" aria-expanded="false">
                                <span><i class="fas fa-sliders-h me-1 text-primary"></i> {{ __('Technical Specs & Rails') }}</span>
                                <i class="fas fa-chevron-down ms-1 chevron-icon"></i>
                            </button>
                            <div class="collapse mt-2" id="specs-wallet">
                                <div class="p-3 bg-light rounded-3 border f-12 text-muted">
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span class="gilroy-medium text-dark">{{ __('Transfer Latency:') }}</span>
                                        <span class="text-success">&lt; 350 ms (Real-time Internal)</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span class="gilroy-medium text-dark">{{ __('Ledger Architecture:') }}</span>
                                        <span>Double-entry isolated sub-accounts</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span class="gilroy-medium text-dark">{{ __('Supported Rails:') }}</span>
                                        <span>Internal, SEPA, Swift, Bank Wire</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1">
                                        <span class="gilroy-medium text-dark">{{ __('API Endpoints:') }}</span>
                                        <code>POST /api/v2/wallets/transfer</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ auth()->check() ? route('user.wallets.index') : url('register') }}" class="service-card-btn service-card-btn-primary">
                            <span>{{ auth()->check() ? __('Manage Your Wallets') : __('Open Free Wallet') }}</span>
                            <i class="fas fa-arrow-right f-13"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 2. Merchant Payment Gateway & Hosted Checkout -->
            <div class="col-md-6 col-lg-4 service-grid-item" id="gateway" data-category="business" data-keywords="merchant payment gateway hosted checkout woocommerce shopify api webhooks sdk recurring business">
                <div class="service-product-card">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="service-icon-box" style="background: rgba(0, 186, 242, 0.12); color: #00BAF2;">
                                <i class="fas fa-store"></i>
                            </div>
                            <span class="badge bg-light text-info border px-3 py-1 rounded-pill f-12 gilroy-medium">{{ __('Merchant Gateway') }}</span>
                        </div>
                        <h3 class="gilroy-Semibold color-05B f-22 mb-2">{{ __('Merchant Gateway & Checkout') }}</h3>
                        <p class="gilroy-regular color-5B f-15 leading-24 mb-4">
                            {{ __('Turnkey checkout engine with ready-to-use plugins for WooCommerce, WHMCS, custom webhooks, and REST APIs. Receive online payments globally with auto-conversion.') }}
                        </p>
                        <div class="mb-3">
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Embeddable Standard & Express Hosted Checkout pages') }}</span>
                            </div>
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('One-click CMS integrations (WooCommerce, Shopify, WHMCS)') }}</span>
                            </div>
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Real-time signed HTTP webhooks with automated retries') }}</span>
                            </div>
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Custom branded checkout buttons & multi-tier API keys') }}</span>
                            </div>
                        </div>

                        <!-- Technical Specs Accordion Drawer -->
                        <div class="specs-drawer mb-3">
                            <button class="btn btn-sm btn-link text-decoration-none text-muted p-0 f-13 toggle-specs-btn" type="button" data-bs-toggle="collapse" data-bs-target="#specs-gateway" aria-expanded="false">
                                <span><i class="fas fa-sliders-h me-1 text-info"></i> {{ __('Technical Specs & Rails') }}</span>
                                <i class="fas fa-chevron-down ms-1 chevron-icon"></i>
                            </button>
                            <div class="collapse mt-2" id="specs-gateway">
                                <div class="p-3 bg-light rounded-3 border f-12 text-muted">
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span class="gilroy-medium text-dark">{{ __('Integration Modes:') }}</span>
                                        <span>Redirect Checkout, Modal, REST API</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span class="gilroy-medium text-dark">{{ __('Webhook Signatures:') }}</span>
                                        <span>HMAC SHA-256 with timestamp</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span class="gilroy-medium text-dark">{{ __('Supported Plugins:') }}</span>
                                        <span>WooCommerce 6+, WHMCS 8+</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1">
                                        <span class="gilroy-medium text-dark">{{ __('Endpoint:') }}</span>
                                        <code>POST /merchant/api/v1/payment</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ auth()->check() ? route('user.merchants.index') : url('register') }}" class="service-card-btn service-card-btn-primary">
                            <span>{{ auth()->check() ? __('Access Merchant Portal') : __('Start Accepting Payments') }}</span>
                            <i class="fas fa-arrow-right f-13"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 3. Enterprise Tatum Crypto Exchange & Wallets -->
            <div class="col-md-6 col-lg-4 service-grid-item" id="crypto" data-category="crypto personal" data-keywords="crypto tatum bitcoin btc ethereum eth usdt trc20 blockchain wallet node custody address deposit">
                <div class="service-product-card">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="service-icon-box" style="background: rgba(247, 147, 26, 0.12); color: #F7931A;">
                                <i class="fab fa-bitcoin"></i>
                            </div>
                            <span class="badge bg-light text-warning border px-3 py-1 rounded-pill f-12 gilroy-medium">{{ __('Web3 & Tatum Nodes') }}</span>
                        </div>
                        <h3 class="gilroy-Semibold color-05B f-22 mb-2">{{ __('Crypto Custody & Tatum Nodes') }}</h3>
                        <p class="gilroy-regular color-5B f-15 leading-24 mb-4">
                            {{ __('Native on-chain Bitcoin, Ethereum, and TRON integration powered by Tatum.io infrastructure. Generate unique deposit addresses and execute on-chain payouts.') }}
                        </p>
                        <div class="mb-3">
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Supported Chains: BTC, ETH, USDT (ERC-20 & TRC-20), TRX, LTC') }}</span>
                            </div>
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Automated on-chain block monitoring & confirmations') }}</span>
                            </div>
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Tatum KMS & multi-sig protected cryptographic vaults') }}</span>
                            </div>
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Instant crypto-to-fiat and fiat-to-crypto auto-exchange') }}</span>
                            </div>
                        </div>

                        <!-- Technical Specs Accordion Drawer -->
                        <div class="specs-drawer mb-3">
                            <button class="btn btn-sm btn-link text-decoration-none text-muted p-0 f-13 toggle-specs-btn" type="button" data-bs-toggle="collapse" data-bs-target="#specs-crypto" aria-expanded="false">
                                <span><i class="fas fa-sliders-h me-1 text-warning"></i> {{ __('Technical Specs & Rails') }}</span>
                                <i class="fas fa-chevron-down ms-1 chevron-icon"></i>
                            </button>
                            <div class="collapse mt-2" id="specs-crypto">
                                <div class="p-3 bg-light rounded-3 border f-12 text-muted">
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span class="gilroy-medium text-dark">{{ __('Custody Architecture:') }}</span>
                                        <span>Tatum HD Wallets & KMS HSM</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span class="gilroy-medium text-dark">{{ __('Confirmations:') }}</span>
                                        <span>BTC: 2 blocks | ETH/USDT: 12 blocks</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span class="gilroy-medium text-dark">{{ __('Smart Contracts:') }}</span>
                                        <span>ERC-20, TRC-20 Standard</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1">
                                        <span class="gilroy-medium text-dark">{{ __('API Endpoints:') }}</span>
                                        <code>POST /api/v2/crypto/address</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ auth()->check() ? route('user.wallets.index') : url('register') }}" class="service-card-btn service-card-btn-primary">
                            <span>{{ auth()->check() ? __('Open Crypto Wallets') : __('Get Started With Crypto') }}</span>
                            <i class="fas fa-arrow-right f-13"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 4. Virtual Cards Issuance -->
            <div class="col-md-6 col-lg-4 service-grid-item" id="virtual-cards" data-category="cards personal business" data-keywords="virtual card prepaid visa mastercard 3ds spend limit cardholder billing subscriptions online checkout cards">
                <div class="service-product-card">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="service-icon-box" style="background: rgba(16, 185, 129, 0.12); color: #10B981;">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <span class="badge bg-light text-success border px-3 py-1 rounded-pill f-12 gilroy-medium">{{ __('Instant Virtual Cards') }}</span>
                        </div>
                        <h3 class="gilroy-Semibold color-05B f-22 mb-2">{{ __('Virtual Prepaid Cards') }}</h3>
                        <p class="gilroy-regular color-5B f-15 leading-24 mb-4">
                            {{ __('Issue dynamic virtual cards for corporate SaaS subscriptions, ad spend, and online shopping. Instant top-ups directly from your multi-currency wallet balance.') }}
                        </p>
                        <div class="mb-3">
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Instant digital issuance with 16-digit PAN, CVV, and expiry') }}</span>
                            </div>
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Custom spending limits and merchant category locks') }}</span>
                            </div>
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('3D Secure (3DS) OTP authentication for fraud defense') }}</span>
                            </div>
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Real-time transaction authorization and spend ledger') }}</span>
                            </div>
                        </div>

                        <!-- Technical Specs Accordion Drawer -->
                        <div class="specs-drawer mb-3">
                            <button class="btn btn-sm btn-link text-decoration-none text-muted p-0 f-13 toggle-specs-btn" type="button" data-bs-toggle="collapse" data-bs-target="#specs-cards" aria-expanded="false">
                                <span><i class="fas fa-sliders-h me-1 text-success"></i> {{ __('Technical Specs & Rails') }}</span>
                                <i class="fas fa-chevron-down ms-1 chevron-icon"></i>
                            </button>
                            <div class="collapse mt-2" id="specs-cards">
                                <div class="p-3 bg-light rounded-3 border f-12 text-muted">
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span class="gilroy-medium text-dark">{{ __('Card Schemes:') }}</span>
                                        <span>Visa / Mastercard Virtual BINs</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span class="gilroy-medium text-dark">{{ __('Settlement Rail:') }}</span>
                                        <span>Direct Debit from Multi-Currency Wallet</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span class="gilroy-medium text-dark">{{ __('Security Protocols:') }}</span>
                                        <span>3D Secure 2.2, Dynamic CVV support</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1">
                                        <span class="gilroy-medium text-dark">{{ __('API Endpoints:') }}</span>
                                        <code>POST /api/v2/cards/virtual/issue</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ auth()->check() ? route('user.dashboard') : url('register') }}" class="service-card-btn service-card-btn-primary">
                            <span>{{ auth()->check() ? __('Manage Virtual Cards') : __('Create Account to Issue Card') }}</span>
                            <i class="fas fa-arrow-right f-13"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 5. Dynamic Currency Exchange & Hedging -->
            <div class="col-md-6 col-lg-4 service-grid-item" id="fx-exchange" data-category="personal business" data-keywords="currency exchange fx rates foreign exchange fiat convert usd eur gbp automated fee hedging exchange">
                <div class="service-product-card">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="service-icon-box" style="background: rgba(139, 92, 246, 0.12); color: #8B5CF6;">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                            <span class="badge bg-light text-primary border px-3 py-1 rounded-pill f-12 gilroy-medium">{{ __('Real-time FX') }}</span>
                        </div>
                        <h3 class="gilroy-Semibold color-05B f-22 mb-2">{{ __('Real-time FX Conversion') }}</h3>
                        <p class="gilroy-regular color-5B f-15 leading-24 mb-4">
                            {{ __('Exchange between 20+ fiat currencies at transparent interbank-grade exchange rates. Automatic conversions for cross-border business invoices and payouts.') }}
                        </p>
                        <div class="mb-3">
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Live mid-market rates refreshed continuously') }}</span>
                            </div>
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Zero hidden markups with transparent slippage protection') }}</span>
                            </div>
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Batch conversions for corporate payroll & contractor payouts') }}</span>
                            </div>
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Audit-ready FX execution timestamps and historical reporting') }}</span>
                            </div>
                        </div>

                        <!-- Technical Specs Accordion Drawer -->
                        <div class="specs-drawer mb-3">
                            <button class="btn btn-sm btn-link text-decoration-none text-muted p-0 f-13 toggle-specs-btn" type="button" data-bs-toggle="collapse" data-bs-target="#specs-fx" aria-expanded="false">
                                <span><i class="fas fa-sliders-h me-1 text-primary"></i> {{ __('Technical Specs & Rails') }}</span>
                                <i class="fas fa-chevron-down ms-1 chevron-icon"></i>
                            </button>
                            <div class="collapse mt-2" id="specs-fx">
                                <div class="p-3 bg-light rounded-3 border f-12 text-muted">
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span class="gilroy-medium text-dark">{{ __('Price Feed Latency:') }}</span>
                                        <span>Sub-second aggregation via Tier-1 liquidity</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span class="gilroy-medium text-dark">{{ __('Supported Pairs:') }}</span>
                                        <span>USD/EUR, GBP/USD, EUR/GBP, CAD, AUD + 15 others</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span class="gilroy-medium text-dark">{{ __('Execution Model:') }}</span>
                                        <span>Atomic Instant Fill or Cancel</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1">
                                        <span class="gilroy-medium text-dark">{{ __('API Endpoints:') }}</span>
                                        <code>POST /api/v2/fx/convert</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ auth()->check() ? route('user.exchange_money.create') : url('register') }}" class="service-card-btn service-card-btn-primary">
                            <span>{{ auth()->check() ? __('Exchange Currency') : __('Create Account to Convert') }}</span>
                            <i class="fas fa-arrow-right f-13"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 6. Developer Financial REST API & Webhooks -->
            <div class="col-md-6 col-lg-4 service-grid-item" id="developer-api-card" data-category="business" data-keywords="developer api rest webhooks integration sdk curl node php python tokens oauth merchant">
                <div class="service-product-card">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="service-icon-box" style="background: rgba(236, 72, 153, 0.12); color: #EC4899;">
                                <i class="fas fa-code"></i>
                            </div>
                            <span class="badge bg-light text-danger border px-3 py-1 rounded-pill f-12 gilroy-medium">{{ __('Developer Tools') }}</span>
                        </div>
                        <h3 class="gilroy-Semibold color-05B f-22 mb-2">{{ __('REST API & Webhooks Engine') }}</h3>
                        <p class="gilroy-regular color-5B f-15 leading-24 mb-4">
                            {{ __('Embed comprehensive financial capabilities directly into your web applications, mobile apps, or backend microservices with granular bearer token authentication.') }}
                        </p>
                        <div class="mb-3">
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('OpenAPI 3.0 specification with complete Postman collections') }}</span>
                            </div>
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Scoped API keys with IP whitelisting & rate-limit tiers') }}</span>
                            </div>
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Idempotency keys on all POST requests preventing duplicate charges') }}</span>
                            </div>
                            <div class="service-perk-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Sandbox staging environment with mock payment gateways') }}</span>
                            </div>
                        </div>

                        <!-- Technical Specs Accordion Drawer -->
                        <div class="specs-drawer mb-3">
                            <button class="btn btn-sm btn-link text-decoration-none text-muted p-0 f-13 toggle-specs-btn" type="button" data-bs-toggle="collapse" data-bs-target="#specs-dev" aria-expanded="false">
                                <span><i class="fas fa-sliders-h me-1 text-danger"></i> {{ __('Technical Specs & Rails') }}</span>
                                <i class="fas fa-chevron-down ms-1 chevron-icon"></i>
                            </button>
                            <div class="collapse mt-2" id="specs-dev">
                                <div class="p-3 bg-light rounded-3 border f-12 text-muted">
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span class="gilroy-medium text-dark">{{ __('Auth Protocol:') }}</span>
                                        <span>OAuth 2.0 / Bearer Tokens / HMAC Headers</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span class="gilroy-medium text-dark">{{ __('Rate Limiting:') }}</span>
                                        <span>120 req/min (Standard) | 1,000 req/min (Enterprise)</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span class="gilroy-medium text-dark">{{ __('Idempotency:') }}</span>
                                        <span>Supported via Idempotency-Key HTTP header</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1">
                                        <span class="gilroy-medium text-dark">{{ __('Spec Document:') }}</span>
                                        <code>GET /api/v2/openapi.json</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="#developer-api" class="service-card-btn service-card-btn-outline">
                            <span>{{ __('View Developer Documentation') }}</span>
                            <i class="fas fa-arrow-down f-13"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- No Results Fallback State -->
        <div id="servicesNoResults" class="text-center py-5 d-none">
            <div class="p-5 rounded-4 bg-light border max-w-600p mx-auto">
                <div class="f-48 text-muted mb-3">
                    <i class="fas fa-search-minus"></i>
                </div>
                <h4 class="gilroy-Semibold color-05B mb-2">{{ __('No matching services found') }}</h4>
                <p class="gilroy-regular color-5B f-15 mb-4">
                    {{ __('We could not find any services matching your search criteria. Try modifying your keywords or clear your current category filter.') }}
                </p>
                <button type="button" class="btn btn-primary rounded-pill px-4 py-2" id="resetServicesFilterBtn2">
                    <i class="fas fa-undo-alt me-2"></i> {{ __('Reset All Filters') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Live Blockchain & Tatum Infrastructure Status Banner -->
    <div class="px-240 pb-5">
        <div class="p-4 p-md-5 rounded-4 border bg-dark text-white position-relative overflow-hidden shadow-sm" style="background: linear-gradient(135deg, #0B0F19 0%, #171F38 100%) !important;">
            <div class="row align-items-center g-4 position-relative z-1">
                <div class="col-lg-7">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(247, 147, 26, 0.15); color: #F7931A; font-size: 13px; font-weight: 600;">
                        <span class="live-status-dot bg-warning" style="width: 8px; height: 8px;"></span>
                        {{ __('TATUM BLOCKCHAIN RPC ENGINE') }}
                    </div>
                    <h3 class="gilroy-Semibold text-white f-28 leading-36 mb-3">
                        {{ __('Direct Decentralized Nodes with Real-time Confirmation Webhooks') }}
                    </h3>
                    <p class="text-light opacity-75 f-15 leading-26 mb-4 max-w-650p">
                        {{ __('All crypto deposit generation and automated payment dispatching run directly through institutional Tatum RPC nodes with dedicated mempool tracking and automated cryptographic signing.') }}
                    </p>
                    <div class="d-flex flex-wrap gap-4">
                        <div class="border-start border-warning ps-3">
                            <div class="f-12 text-light opacity-50 text-uppercase">{{ __('Bitcoin Block Height') }}</div>
                            <div class="gilroy-Semibold f-20 text-warning" id="liveBtcBlock">884,912</div>
                        </div>
                        <div class="border-start border-info ps-3">
                            <div class="f-12 text-light opacity-50 text-uppercase">{{ __('Ethereum Block Height') }}</div>
                            <div class="gilroy-Semibold f-20 text-info" id="liveEthBlock">21,834,105</div>
                        </div>
                        <div class="border-start border-success ps-3">
                            <div class="f-12 text-light opacity-50 text-uppercase">{{ __('Average Cluster Latency') }}</div>
                            <div class="gilroy-Semibold f-20 text-success" id="liveClusterLatency">32 ms</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 text-center text-lg-end">
                    <div class="p-3 p-md-4 rounded-4 bg-white bg-opacity-10 border border-white border-opacity-10 d-inline-block text-start w-100 max-w-400p">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-circle p-2 bg-success text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div>
                                <h6 class="text-white mb-0 gilroy-Semibold">{{ __('Tatum Node Cluster') }}</h6>
                                <span class="badge bg-success-subtle text-success border border-success f-11 px-2 py-0 rounded-pill">{{ __('Live & Synced') }}</span>
                            </div>
                        </div>
                        <p class="f-13 text-light opacity-75 mb-3">
                            {{ __('Watch our 3-minute architectural demo showing how our automated blockchain listener handles transactions and updates user ledgers.') }}
                        </p>
                        <button type="button" class="btn btn-warning w-100 rounded-pill py-2 gilroy-medium text-dark d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#cryptoVideoModal">
                            <i class="fas fa-play-circle f-16"></i>
                            <span>{{ __('Watch Architecture Demo') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive Developer REST API Section -->
    <div class="border-top py-5" id="developer-api" style="background-color: #F8FAFC;">
        <div class="px-240">
            <div class="text-center mb-5">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2" style="background: rgba(99, 91, 254, 0.08); color: #635BFE; font-weight: 700; font-size: 13px;">
                    <i class="fas fa-terminal"></i> {{ __('DEVELOPER-FIRST FINTECH PLATFORM') }}
                </div>
                <h2 class="gilroy-Semibold color-05B f-36 leading-44 mb-2">
                    {{ __('Integrate Institutional Payments in Minutes') }}
                </h2>
                <p class="gilroy-regular color-5B f-16 leading-26 max-w-700p mx-auto">
                    {{ __('Execute transfers, generate checkout sessions, query real-time wallet balances, and configure webhooks with our modern REST API and comprehensive SDKs.') }}
                </p>
            </div>

            <!-- Developer Code Terminal -->
            <div class="api-code-terminal">
                <div class="api-terminal-nav">
                    <div class="d-flex align-items-center gap-2">
                        <span class="rounded-circle" style="width: 12px; height: 12px; background: #EF4444; display: inline-block;"></span>
                        <span class="rounded-circle" style="width: 12px; height: 12px; background: #F59E0B; display: inline-block;"></span>
                        <span class="rounded-circle" style="width: 12px; height: 12px; background: #10B981; display: inline-block;"></span>
                        <span class="ms-3 text-light opacity-50 f-13 d-none d-sm-inline">api.{{ parse_url(url('/'), PHP_URL_HOST) ?? 'paymoney.test' }} / v2 / payments</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex gap-1" id="apiLangTabs">
                            <button type="button" class="api-tab-btn active" data-tab="curl">cURL</button>
                            <button type="button" class="api-tab-btn" data-tab="node">Node.js</button>
                            <button type="button" class="api-tab-btn" data-tab="php">PHP</button>
                            <button type="button" class="api-tab-btn" data-tab="python">Python</button>
                        </div>
                        <button type="button" class="api-copy-btn ms-2" id="copyCodeBtn" title="{{ __('Copy Snippet') }}">
                            <i class="fas fa-copy me-1"></i> <span id="copyBtnText">{{ __('Copy') }}</span>
                        </button>
                    </div>
                </div>

                <!-- Code Snippets Display -->
                <div class="position-relative">
                    <!-- cURL -->
                    <pre class="api-code-pre api-snippet-content" id="tab-curl"><code>curl -X POST "{{ url('/api/v2/payment/create') }}" \
  -H "Authorization: Bearer sk_live_948fbc2e7a10984da0e82" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: idemp_{{ md5(uniqid()) }}" \
  -d '{
    "amount": 250.00,
    "currency": "USD",
    "payer_email": "customer@example.com",
    "description": "Enterprise SaaS Subscription Plan",
    "success_url": "https://yourdomain.com/checkout/success",
    "cancel_url": "https://yourdomain.com/checkout/cancel"
  }'</code></pre>

                    <!-- Node.js (Axios) -->
                    <pre class="api-code-pre api-snippet-content d-none" id="tab-node"><code>const axios = require('axios');

async function createPaymentSession() {
  const response = await axios.post('{{ url("/api/v2/payment/create") }}', {
    amount: 250.00,
    currency: 'USD',
    payer_email: 'customer@example.com',
    description: 'Enterprise SaaS Subscription Plan',
    success_url: 'https://yourdomain.com/checkout/success',
    cancel_url: 'https://yourdomain.com/checkout/cancel'
  }, {
    headers: {
      'Authorization': 'Bearer sk_live_948fbc2e7a10984da0e82',
      'Content-Type': 'application/json',
      'Idempotency-Key': 'idemp_' + Date.now()
    }
  });

  console.log('Payment URL:', response.data.data.checkout_url);
}

createPaymentSession();</code></pre>

                    <!-- PHP (Guzzle) -->
                    <pre class="api-code-pre api-snippet-content d-none" id="tab-php"><code>&lt;?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();
$response = $client-&gt;request('POST', '{{ url("/api/v2/payment/create") }}', [
  'headers' =&gt; [
    'Authorization' =&gt; 'Bearer sk_live_948fbc2e7a10984da0e82',
    'Content-Type'  =&gt; 'application/json',
    'Idempotency-Key' =&gt; 'idemp_' . bin2hex(random_bytes(8))
  ],
  'json' =&gt; [
    'amount'      =&gt; 250.00,
    'currency'    =&gt; 'USD',
    'payer_email' =&gt; 'customer@example.com',
    'description' =&gt; 'Enterprise SaaS Subscription Plan',
    'success_url' =&gt; 'https://yourdomain.com/checkout/success',
    'cancel_url'  =&gt; 'https://yourdomain.com/checkout/cancel'
  ]
]);

$data = json_decode($response-&gt;getBody(), true);
echo "Checkout URL: " . $data['data']['checkout_url'];</code></pre>

                    <!-- Python (Requests) -->
                    <pre class="api-code-pre api-snippet-content d-none" id="tab-python"><code>import requests
import uuid

url = "{{ url('/api/v2/payment/create') }}"
headers = {
    "Authorization": "Bearer sk_live_948fbc2e7a10984da0e82",
    "Content-Type": "application/json",
    "Idempotency-Key": f"idemp_{uuid.uuid4().hex}"
}
payload = {
    "amount": 250.00,
    "currency": "USD",
    "payer_email": "customer@example.com",
    "description": "Enterprise SaaS Subscription Plan",
    "success_url": "https://yourdomain.com/checkout/success",
    "cancel_url": "https://yourdomain.com/checkout/cancel"
}

response = requests.post(url, json=payload, headers=headers)
print("Response Status:", response.status_code)
print("Payment Data:", response.json())</code></pre>
                </div>

                <!-- API Terminal Footer with Interactive Simulator -->
                <div class="p-3 bg-dark border-top border-secondary border-opacity-25 d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3" id="simulateApiCallBtn">
                            <i class="fas fa-play me-1 text-success"></i> <span>{{ __('Simulate API Call') }}</span>
                        </button>
                        <span class="text-light opacity-50 f-12 d-none d-md-inline">{{ __('Test response in mock staging sandbox') }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-light opacity-75 f-13"><i class="fas fa-book me-1 text-primary"></i> {{ __('Postman Collection Available') }}</span>
                        <a href="{{ auth()->check() ? route('user.merchants.index') : url('register') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                            {{ auth()->check() ? __('Get API Keys') : __('Generate Sandbox Key') }}
                        </a>
                    </div>
                </div>

                <!-- Simulated Response Output Drawer -->
                <div id="apiSimulateResponseBanner" class="p-3 border-top border-secondary border-opacity-25 bg-black text-start d-none">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success-subtle text-success border border-success f-11 px-2 py-0 rounded-pill">HTTP 200 OK</span>
                            <span class="text-light opacity-75 f-12" id="apiSimulateLatency">{{ __('Latency: 142ms') }}</span>
                        </div>
                        <button type="button" class="btn-close btn-close-white f-10" id="closeApiSimulateBtn"></button>
                    </div>
                    <pre class="m-0 text-success f-12 font-monospace" style="white-space: pre-wrap;" id="apiSimulateOutputJson"></pre>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action Banner -->
    <div class="services-cta-section text-center py-5 bg-white border-top">
        <div class="px-240">
            <h2 class="gilroy-Semibold color-05B f-36 leading-44 mb-3">
                {{ __('Ready to Transform Your Financial Infrastructure?') }}
            </h2>
            <p class="gilroy-regular color-5B f-16 leading-26 max-w-650p mx-auto mb-4">
                {{ __('Join thousands of individuals and global businesses already moving billions seamlessly with :x.', ['x' => settings('name')]) }}
            </p>
            <div class="d-flex justify-content-center flex-wrap gap-3">
                <a href="{{ auth()->check() ? route('user.dashboard') : url('register') }}" class="btn btn-primary px-5 py-3 gilroy-medium rounded-pill text-white shadow-sm">
                    <i class="fas fa-user-plus me-2"></i> {{ auth()->check() ? __('Go to Your Dashboard') : __('Get Started in 2 Minutes') }}
                </a>
                <a href="{{ url('contact-us') }}" class="btn btn-outline-secondary px-5 py-3 gilroy-medium rounded-pill">
                    <i class="fas fa-headset me-2"></i> {{ __('Contact Sales & Support') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Crypto Video Walkthrough Modal -->
    <div class="modal fade" id="cryptoVideoModal" tabindex="-1" aria-labelledby="servicesCryptoVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark border-secondary">
                <div class="modal-header border-secondary border-opacity-50">
                    <h5 class="modal-title text-white f-18 gilroy-Semibold d-flex align-items-center gap-2" id="servicesCryptoVideoModalLabel">
                        <span class="badge bg-primary px-2 py-1">{{ __('Demo') }}</span>
                        {{ __(':x Crypto Exchange & Node Walkthrough', ['x' => settings('name')]) }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3 p-md-4">
                    <div class="ratio ratio-16x9 rounded-3 overflow-hidden shadow" style="background-color: #000;">
                        <iframe id="servicesCryptoDemoVideo" src="https://www.youtube-nocookie.com/embed/1YyAzVmP9xQ?enablejsapi=1&rel=0" title="{{ __('Crypto Platform Demo') }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                    <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 pt-2 text-muted f-14">
                        <span class="text-light opacity-75">{{ __('Learn how instant crypto deposit addresses and Tatum nodes process transactions.') }}</span>
                        <a href="{{ auth()->check() ? route('user.exchange_money.create') : url('register') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 mt-2 mt-sm-0">
                            {{ auth()->check() ? __('Exchange Crypto Now') : __('Get Started With Crypto') }} &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Client-side Interactive Dynamic Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Elements
            var filterButtons = document.querySelectorAll('#servicesFilterGroup .service-filter-pill');
            var serviceCards = document.querySelectorAll('#servicesCatalogGrid .service-grid-item');
            var searchInput = document.getElementById('serviceSearchInput');
            var clearSearchBtn = document.getElementById('clearSearchBtn');
            var searchStatus = document.getElementById('serviceSearchStatus');
            var resetBtn = document.getElementById('resetServicesFilterBtn');
            var resetBtn2 = document.getElementById('resetServicesFilterBtn2');
            var noResultsBox = document.getElementById('servicesNoResults');

            var currentCategory = 'all';
            var currentSearchQuery = '';

            // 2. Count calculator
            function updateCategoryCounts() {
                var counts = { all: serviceCards.length, personal: 0, business: 0, crypto: 0, cards: 0 };
                serviceCards.forEach(function (card) {
                    var cat = card.getAttribute('data-category') || '';
                    if (cat.indexOf('personal') !== -1) counts.personal++;
                    if (cat.indexOf('business') !== -1) counts.business++;
                    if (cat.indexOf('crypto') !== -1) counts.crypto++;
                    if (cat.indexOf('cards') !== -1) counts.cards++;
                });
                for (var key in counts) {
                    var el = document.getElementById('count-' + key);
                    if (el) el.innerText = counts[key];
                }
            }
            updateCategoryCounts();

            // 3. Combined Filter & Search Engine
            function filterServices() {
                var query = currentSearchQuery.toLowerCase().trim();
                var visibleCount = 0;

                serviceCards.forEach(function (card) {
                    var cardCategory = card.getAttribute('data-category') || '';
                    var cardKeywords = (card.getAttribute('data-keywords') || '') + ' ' + card.innerText;
                    var matchesCategory = (currentCategory === 'all' || cardCategory.indexOf(currentCategory) !== -1);
                    var matchesSearch = (!query || cardKeywords.toLowerCase().indexOf(query) !== -1);

                    if (matchesCategory && matchesSearch) {
                        card.style.display = 'block';
                        card.style.opacity = '0';
                        setTimeout(function () {
                            card.style.transition = 'opacity 0.2s ease';
                            card.style.opacity = '1';
                        }, 20);
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Update Status Bar
                if (searchStatus) {
                    if (query || currentCategory !== 'all') {
                        searchStatus.innerText = 'Showing ' + visibleCount + ' of ' + serviceCards.length + ' services';
                        if (resetBtn) resetBtn.classList.remove('d-none');
                    } else {
                        searchStatus.innerText = 'Showing all ' + serviceCards.length + ' enterprise & personal services';
                        if (resetBtn) resetBtn.classList.add('d-none');
                    }
                }

                // Show/hide empty state
                if (noResultsBox) {
                    if (visibleCount === 0) {
                        noResultsBox.classList.remove('d-none');
                    } else {
                        noResultsBox.classList.add('d-none');
                    }
                }
            }

            // 4. Category Pills Click Handler
            filterButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    filterButtons.forEach(function (btn) { btn.classList.remove('active'); });
                    this.classList.add('active');
                    currentCategory = this.getAttribute('data-filter');
                    filterServices();
                });
            });

            // 5. Real-time Search Handler
            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    currentSearchQuery = this.value;
                    if (clearSearchBtn) {
                        if (this.value.length > 0) {
                            clearSearchBtn.classList.remove('d-none');
                        } else {
                            clearSearchBtn.classList.add('d-none');
                        }
                    }
                    filterServices();
                });
            }

            // 6. Clear Search Button
            if (clearSearchBtn) {
                clearSearchBtn.addEventListener('click', function () {
                    if (searchInput) searchInput.value = '';
                    currentSearchQuery = '';
                    clearSearchBtn.classList.add('d-none');
                    filterServices();
                    if (searchInput) searchInput.focus();
                });
            }

            // 7. Reset Filters Handlers
            function resetAllFilters() {
                if (searchInput) searchInput.value = '';
                currentSearchQuery = '';
                if (clearSearchBtn) clearSearchBtn.classList.add('d-none');
                currentCategory = 'all';
                filterButtons.forEach(function (btn) {
                    if (btn.getAttribute('data-filter') === 'all') {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                });
                filterServices();
            }

            if (resetBtn) resetBtn.addEventListener('click', resetAllFilters);
            if (resetBtn2) resetBtn2.addEventListener('click', resetAllFilters);

            // 8. Tabbed Code Terminal
            var codeTabs = document.querySelectorAll('.api-tab-btn');
            var codeSnippets = document.querySelectorAll('.api-snippet-content');

            codeTabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    codeTabs.forEach(function (t) { t.classList.remove('active'); });
                    this.classList.add('active');

                    var targetTab = this.getAttribute('data-tab');
                    codeSnippets.forEach(function (snippet) {
                        if (snippet.id === 'tab-' + targetTab) {
                            snippet.classList.remove('d-none');
                        } else {
                            snippet.classList.add('d-none');
                        }
                    });
                });
            });

            // 9. Copy Code Button
            var copyBtn = document.getElementById('copyCodeBtn');
            var copyBtnText = document.getElementById('copyBtnText');

            if (copyBtn) {
                copyBtn.addEventListener('click', function () {
                    var activeSnippet = document.querySelector('.api-snippet-content:not(.d-none) code');
                    if (activeSnippet) {
                        navigator.clipboard.writeText(activeSnippet.innerText).then(function () {
                            copyBtnText.innerText = '{{ __("Copied!") }}';
                            setTimeout(function () {
                                copyBtnText.innerText = '{{ __("Copy") }}';
                            }, 2000);
                        });
                    }
                });
            }

            // 10. Interactive REST API Simulator Runner
            var simulateBtn = document.getElementById('simulateApiCallBtn');
            var simBanner = document.getElementById('apiSimulateResponseBanner');
            var simClose = document.getElementById('closeApiSimulateBtn');
            var simOutput = document.getElementById('apiSimulateOutputJson');
            var simLatency = document.getElementById('apiSimulateLatency');

            if (simulateBtn && simBanner && simOutput) {
                simulateBtn.addEventListener('click', function () {
                    var origHtml = simulateBtn.innerHTML;
                    simulateBtn.disabled = true;
                    simulateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> {{ __("Executing Request...") }}';

                    var latencyMs = Math.floor(Math.random() * 80) + 110;

                    setTimeout(function () {
                        var orderId = 'ORD_' + Math.random().toString(36).substring(2, 9).toUpperCase();
                        var transId = 'TXN_' + Date.now().toString(36).toUpperCase();
                        var mockResponse = {
                            "status": "success",
                            "http_code": 200,
                            "timestamp": new Date().toISOString(),
                            "data": {
                                "order_id": orderId,
                                "transaction_id": transId,
                                "amount": 250.00,
                                "currency": "USD",
                                "status": "APPROVED",
                                "checkout_url": "{{ url('/merchant/payment') }}?token=" + transId,
                                "fee": 0.00,
                                "idempotency_cached": false
                            },
                            "message": "Payment intent initialized successfully."
                        };

                        if (simLatency) simLatency.innerText = 'Latency: ' + latencyMs + 'ms';
                        simOutput.innerText = JSON.stringify(mockResponse, null, 2);
                        simBanner.classList.remove('d-none');
                        simulateBtn.disabled = false;
                        simulateBtn.innerHTML = origHtml;
                    }, latencyMs);
                });

                if (simClose) {
                    simClose.addEventListener('click', function () {
                        simBanner.classList.add('d-none');
                    });
                }
            }

            // 11. Live Blockchain Heartbeat Simulation
            var btcEl = document.getElementById('liveBtcBlock');
            var ethEl = document.getElementById('liveEthBlock');
            var latEl = document.getElementById('liveClusterLatency');

            if (btcEl && ethEl) {
                var btcHeight = 884912;
                var ethHeight = 21834105;

                setInterval(function () {
                    // Random small latency jitter (26ms - 39ms)
                    if (latEl) {
                        var randLat = Math.floor(Math.random() * 14) + 26;
                        latEl.innerText = randLat + ' ms';
                    }

                    // Ethereum produces blocks every ~12s
                    ethHeight += 1;
                    ethEl.innerText = ethHeight.toLocaleString();
                }, 12000);

                setInterval(function () {
                    // Bitcoin blocks every 10 mins (simulated every 60s for demo feedback)
                    btcHeight += 1;
                    btcEl.innerText = btcHeight.toLocaleString();
                }, 60000);
            }

            // 12. Accordion Drawer Chevron Rotation
            document.querySelectorAll('.toggle-specs-btn').forEach(function (btn) {
                var targetId = btn.getAttribute('data-bs-target');
                if (targetId) {
                    var collapseEl = document.querySelector(targetId);
                    if (collapseEl) {
                        collapseEl.addEventListener('show.bs.collapse', function () {
                            var icon = btn.querySelector('.chevron-icon');
                            if (icon) icon.classList.add('rotate-180');
                        });
                        collapseEl.addEventListener('hide.bs.collapse', function () {
                            var icon = btn.querySelector('.chevron-icon');
                            if (icon) icon.classList.remove('rotate-180');
                        });
                    }
                }
            });

            // 13. Crypto Video Modal
            var videoModal = document.getElementById('cryptoVideoModal');
            if (videoModal) {
                var iframe = document.getElementById('servicesCryptoDemoVideo');
                var origSrc = iframe ? iframe.src : '';
                videoModal.addEventListener('hidden.bs.modal', function () {
                    if (iframe) {
                        iframe.src = '';
                        setTimeout(function () {
                            iframe.src = origSrc;
                        }, 100);
                    }
                });
            }

            // 14. URL Hash Auto-Focus & Filter Activation
            var hash = window.location.hash;
            if (hash) {
                var targetEl = document.querySelector(hash);
                if (targetEl) {
                    var cat = targetEl.getAttribute('data-category');
                    if (cat) {
                        var primaryCat = cat.split(' ')[0];
                        var btn = document.querySelector('#servicesFilterGroup [data-filter="' + primaryCat + '"]');
                        if (btn) btn.click();
                    }
                    setTimeout(function () {
                        targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 250);
                }
            }
        });
    </script>
@endsection
