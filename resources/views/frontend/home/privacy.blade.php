@extends('frontend.layouts.app')

@section('content')
    <!-- Top Reading Progress Indicator -->
    <div id="policyProgressBar" aria-hidden="true"></div>

    <!-- Hero Header -->
    <div class="privacy-hero-header">
        <div class="px-240">
            <nav class="customize-bcrm mb-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Privacy Policy') }}</li>
                </ol>
            </nav>

            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(99, 91, 254, 0.08); color: #635BFE; font-weight: 700; font-size: 13px;">
                <span class="pulse-dot"></span>
                <span>{{ __('INSTITUTIONAL DATA PROTECTION & PRIVACY STANDARDS') }}</span>
            </div>

            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h1 class="gilroy-Semibold color-05B f-40 leading-48 mb-3">
                        {{ __('Privacy Policy & Security Standards') }}
                    </h1>
                    <p class="gilroy-regular color-5B f-17 leading-28 mb-4 max-w-910p">
                        {{ __('At :x, we prioritize your data security and financial sovereignty. This policy explains how we collect, safeguard, tokenize, and manage your personal and transaction data across our global payments infrastructure.', ['x' => settings('name')]) }}
                    </p>

                    <!-- Policy Meta Badges -->
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill f-13 font-weight-normal">
                            <i class="far fa-calendar-alt text-primary me-1"></i> {{ __('Last Revised: December 2024') }}
                        </span>
                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill f-13 font-weight-normal">
                            <i class="far fa-clock text-info me-1"></i> {{ __('6 Min Read') }}
                        </span>
                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill f-13 font-weight-normal">
                            <i class="fas fa-lock text-success me-1"></i> {{ __('256-Bit SSL/TLS & PCI-DSS Certified') }}
                        </span>
                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill f-13 font-weight-normal">
                            <i class="fas fa-user-shield text-warning me-1"></i> {{ __('GDPR & AML Compliant') }}
                        </span>
                    </div>
                </div>

                <div class="col-lg-4 text-lg-end">
                    <div class="d-inline-block p-4 rounded-4 bg-light border text-start shadow-xs">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="p-3 rounded-circle bg-white border text-primary f-20 shadow-xs">
                                <i class="fas fa-shield-virus"></i>
                            </div>
                            <div>
                                <div class="gilroy-Semibold color-05B f-16">{{ __('Zero Data Selling') }}</div>
                                <div class="f-12 text-muted">{{ __('Strict confidentiality guarantee') }}</div>
                            </div>
                        </div>
                        <p class="f-13 color-5B mb-0 leading-20">
                            {{ __('We never sell, broker, or monetize your personal or financial records to third-party advertisers or data brokers.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Layout with Sticky Animated Navigation -->
    <div class="px-240 py-5">
        <div class="row g-4">
            <!-- Left Sticky Table of Contents -->
            <div class="col-lg-4 col-xl-3">
                <div class="privacy-toc-sidebar">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <span class="f-13 gilroy-Semibold text-muted text-uppercase">{{ __('Table of Contents') }}</span>
                        <span class="badge bg-primary-subtle text-primary rounded-pill f-11">9 {{ __('Sections') }}</span>
                    </div>

                    <nav id="privacyScrollNav" class="d-flex flex-column gap-1">
                        <a href="#item-1" class="privacy-toc-link active">
                            <i class="fas fa-shield-alt f-14"></i>
                            <span>{{ __('1. Scope & Principles') }}</span>
                        </a>
                        <a href="#item-2" class="privacy-toc-link">
                            <i class="fas fa-database f-14"></i>
                            <span>{{ __('2. Information We Collect') }}</span>
                        </a>
                        <a href="#item-3" class="privacy-toc-link">
                            <i class="fas fa-cogs f-14"></i>
                            <span>{{ __('3. How We Use Data') }}</span>
                        </a>
                        <a href="#item-4" class="privacy-toc-link">
                            <i class="fas fa-share-alt f-14"></i>
                            <span>{{ __('4. Information Sharing') }}</span>
                        </a>
                        <a href="#security-compliance" class="privacy-toc-link text-primary font-weight-bold">
                            <i class="fas fa-lock f-14"></i>
                            <span>{{ __('5. Security & PCI-DSS') }}</span>
                        </a>
                        <a href="#item-6" class="privacy-toc-link">
                            <i class="fas fa-cookie-bite f-14"></i>
                            <span>{{ __('6. Cookies & Tracking') }}</span>
                        </a>
                        <a href="#item-7" class="privacy-toc-link">
                            <i class="fas fa-user-check f-14"></i>
                            <span>{{ __('7. Your Privacy Rights') }}</span>
                        </a>
                        <a href="#item-8" class="privacy-toc-link">
                            <i class="fas fa-history f-14"></i>
                            <span>{{ __('8. Policy Updates') }}</span>
                        </a>
                        <a href="#item-9" class="privacy-toc-link">
                            <i class="fas fa-envelope f-14"></i>
                            <span>{{ __('9. Contact Us') }}</span>
                        </a>
                    </nav>

                    <div class="mt-4 pt-3 border-top text-center">
                        <a href="{{ url('/services') }}" class="btn btn-outline-primary btn-sm rounded-pill w-100 py-2 f-13">
                            <i class="fas fa-arrow-left me-1"></i> {{ __('Back to Services') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Content Cards -->
            <div class="col-lg-8 col-xl-9">
                <div class="privacy-content-stream">

                    <!-- Section 1: Scope & Core Principles -->
                    <div class="privacy-section-card" id="item-1">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="p-2 rounded-3 bg-light text-primary f-18">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h2 class="gilroy-Semibold color-05B f-24 mb-0">{{ __('1. Scope & Core Principles') }}</h2>
                        </div>
                        <p class="gilroy-regular color-5B f-15 leading-26">
                            {{ __('This Privacy Policy governs your use of the :x web portal, mobile applications, APIs, multi-currency wallet rails, and merchant checkout gateways. By using our services, you acknowledge and agree to the data handling practices outlined in this document.', ['x' => settings('name')]) }}
                        </p>
                        <div class="p-3 rounded-3 bg-light border f-14 color-5B leading-24">
                            <strong class="text-dark">{{ __('Our Privacy Commitment:') }}</strong>
                            {{ __('We adhere to privacy-by-design engineering principles. Data collected is strictly minimized to what is required to execute transactions safely, fulfill anti-money laundering obligations, and protect your digital assets against unauthorized breach.') }}
                        </div>
                    </div>

                    <!-- Section 2: Information We Collect -->
                    <div class="privacy-section-card" id="item-2">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="p-2 rounded-3 bg-light text-info f-18">
                                <i class="fas fa-database"></i>
                            </div>
                            <h2 class="gilroy-Semibold color-05B f-24 mb-0">{{ __('2. Information We Collect') }}</h2>
                        </div>
                        <p class="gilroy-regular color-5B f-15 leading-26 mb-4">
                            {{ __('To facilitate frictionless transactions and maintain regulatory compliance, we collect information in the following structured categories:') }}
                        </p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 rounded-3 bg-light border h-100">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="fas fa-user-circle text-primary"></i>
                                        <span class="gilroy-Semibold color-05B f-15">{{ __('Personal Identity Data') }}</span>
                                    </div>
                                    <p class="f-13 color-5B mb-0 leading-22">
                                        {{ __('Full legal name, verified email address, mobile phone number, residential billing address, and date of birth.') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3 bg-light border h-100">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="fas fa-credit-card text-success"></i>
                                        <span class="gilroy-Semibold color-05B f-15">{{ __('Financial & Payment Data') }}</span>
                                    </div>
                                    <p class="f-13 color-5B mb-0 leading-22">
                                        {{ __('Bank account details, tokenized payment card numbers, wallet ledger balances, transaction history, and settlement vouchers.') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3 bg-light border h-100">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="fas fa-id-card text-warning"></i>
                                        <span class="gilroy-Semibold color-05B f-15">{{ __('KYC / AML Compliance') }}</span>
                                    </div>
                                    <p class="f-13 color-5B mb-0 leading-22">
                                        {{ __('Government-issued passports, driver licenses, national ID cards, tax registration numbers, and proof-of-address documents.') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3 bg-light border h-100">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="fas fa-laptop-code text-info"></i>
                                        <span class="gilroy-Semibold color-05B f-15">{{ __('Technical & Usage Logs') }}</span>
                                    </div>
                                    <p class="f-13 color-5B mb-0 leading-22">
                                        {{ __('IP address, browser user-agent, geolocation metadata, device hardware fingerprints, and API request timestamps for fraud anomaly prevention.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: How We Use Your Information -->
                    <div class="privacy-section-card" id="item-3">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="p-2 rounded-3 bg-light text-primary f-18">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <h2 class="gilroy-Semibold color-05B f-24 mb-0">{{ __('3. How We Use Your Information') }}</h2>
                        </div>
                        <p class="gilroy-regular color-5B f-15 leading-26">
                            {{ __('We use your data solely for legitimate operational and compliance purposes, including:') }}
                        </p>
                        <div class="row g-2 mt-2">
                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-2 f-14 color-5B mb-2">
                                    <i class="fas fa-check-circle text-success mt-1"></i>
                                    <span>{{ __('Executing real-time internal wallet transfers and global cross-border payments.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-2 f-14 color-5B mb-2">
                                    <i class="fas fa-check-circle text-success mt-1"></i>
                                    <span>{{ __('Automated KYC identity verification and anti-terrorist financing checks.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-2 f-14 color-5B mb-2">
                                    <i class="fas fa-check-circle text-success mt-1"></i>
                                    <span>{{ __('Real-time ML fraud monitoring and prevention of unauthorized account takeover.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-2 f-14 color-5B mb-2">
                                    <i class="fas fa-check-circle text-success mt-1"></i>
                                    <span>{{ __('Transmitting critical security alerts, two-factor OTP codes, and transaction receipts.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: How We Share Your Information -->
                    <div class="privacy-section-card" id="item-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="p-2 rounded-3 bg-light text-warning f-18">
                                <i class="fas fa-share-alt"></i>
                            </div>
                            <h2 class="gilroy-Semibold color-05B f-24 mb-0">{{ __('4. How We Share Your Information') }}</h2>
                        </div>
                        <p class="gilroy-regular color-5B f-15 leading-26">
                            {{ __('We only share personal data with trusted partners strictly necessary to complete financial settlement:') }}
                        </p>
                        <ul class="list-unstyled mb-0 feature-specs-list f-15 color-5B">
                            <li class="d-flex align-items-start mb-3">
                                <i class="fas fa-arrow-right text-primary me-2 mt-1"></i>
                                <span><strong class="text-dark">{{ __('Licensed Banking Partners & Payment Rails:') }}</strong> {{ __('To route wire transfers, ACH deposits, and SEPA clearances directly through authorized correspondent banks.') }}</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <i class="fas fa-arrow-right text-primary me-2 mt-1"></i>
                                <span><strong class="text-dark">{{ __('Blockchain Node Infrastructure (Tatum.io):') }}</strong> {{ __('To broadcast cryptographic deposits and withdrawals across public decentralized ledgers (Bitcoin, Ethereum, Tron, Polygon).') }}</span>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="fas fa-arrow-right text-primary me-2 mt-1"></i>
                                <span><strong class="text-dark">{{ __('Legal & Regulatory Authorities:') }}</strong> {{ __('Only when compelled by valid legal process, judicial court order, or international AML treaties.') }}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Section 5: Data Security, 256-Bit SSL & PCI-DSS Compliance (TARGET OF FOOTER TRUST BADGES) -->
                    <div class="privacy-section-card" id="security-compliance">
                        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="p-2 rounded-3 bg-success-subtle text-success f-20">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h2 class="gilroy-Semibold color-05B f-24 mb-0">{{ __('5. Data Security & PCI-DSS Compliance') }}</h2>
                            </div>
                            <span class="badge bg-success text-white px-3 py-2 rounded-pill f-12">
                                <i class="fas fa-check-double me-1"></i> {{ __('Institutional Grade') }}
                            </span>
                        </div>

                        <p class="gilroy-regular color-5B f-15 leading-26">
                            {{ __('Security is the non-negotiable core of :x. We implement defense-in-depth protective architecture across all application tiers:', ['x' => settings('name')]) }}
                        </p>

                        <!-- Security Architecture Visual Box -->
                        <div class="security-compliance-box">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="p-2 rounded-circle bg-white border text-primary f-18">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                        <div>
                                            <div class="gilroy-Semibold color-05B f-16 mb-1">{{ __('256-Bit SSL/TLS Encryption') }}</div>
                                            <p class="f-13 color-5B mb-0 leading-20">
                                                {{ __('All network communication between your browser and our servers is secured using modern TLS 1.3 protocol and AES-256 ciphers.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="p-2 rounded-circle bg-white border text-success f-18">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                        <div>
                                            <div class="gilroy-Semibold color-05B f-16 mb-1">{{ __('PCI-DSS Level 1 Compliance') }}</div>
                                            <p class="f-13 color-5B mb-0 leading-20">
                                                {{ __('Raw credit card numbers never touch our web servers. All card data is securely tokenized within isolated PCI-certified hardware vaults.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="p-2 rounded-circle bg-white border text-info f-18">
                                            <i class="fas fa-key"></i>
                                        </div>
                                        <div>
                                            <div class="gilroy-Semibold color-05B f-16 mb-1">{{ __('Multi-Factor Authentication (2FA)') }}</div>
                                            <p class="f-13 color-5B mb-0 leading-20">
                                                {{ __('Time-based One-Time Passwords (TOTP via Google Authenticator) and SMS OTP protection for all withdrawals and password changes.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="p-2 rounded-circle bg-white border text-warning f-18">
                                            <i class="fas fa-coins"></i>
                                        </div>
                                        <div>
                                            <div class="gilroy-Semibold color-05B f-16 mb-1">{{ __('Cold Custody for Cryptocurrencies') }}</div>
                                            <p class="f-13 color-5B mb-0 leading-20">
                                                {{ __('Over 95% of digital asset reserves are held in offline multi-signature cold storage vaults inaccessible from public networks.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 6: Cookies & Tracking Technologies -->
                    <div class="privacy-section-card" id="item-6">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="p-2 rounded-3 bg-light text-primary f-18">
                                <i class="fas fa-cookie-bite"></i>
                            </div>
                            <h2 class="gilroy-Semibold color-05B f-24 mb-0">{{ __('6. Cookies & Tracking Technologies') }}</h2>
                        </div>
                        <p class="gilroy-regular color-5B f-15 leading-26">
                            {{ __('We use strictly necessary session cookies to maintain your authenticated login session, preserve your dark/light theme preference, and protect forms against Cross-Site Request Forgery (CSRF). We do NOT deploy invasive third-party ad tracking pixels.') }}
                        </p>
                    </div>

                    <!-- Section 7: User Privacy Rights (GDPR & CCPA) -->
                    <div class="privacy-section-card" id="item-7">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="p-2 rounded-3 bg-light text-success f-18">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <h2 class="gilroy-Semibold color-05B f-24 mb-0">{{ __('7. Your Data Rights (GDPR & CCPA)') }}</h2>
                        </div>
                        <p class="gilroy-regular color-5B f-15 leading-26 mb-3">
                            {{ __('Under global data privacy laws, you possess the following enforceable rights:') }}
                        </p>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <strong class="color-05B f-14 d-block mb-1">{{ __('Right to Access & Portability') }}</strong>
                                    <span class="f-13 color-5B">{{ __('Request a complete copy of all personal information and transaction ledgers stored on your profile.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <strong class="color-05B f-14 d-block mb-1">{{ __('Right to Rectification') }}</strong>
                                    <span class="f-13 color-5B">{{ __('Update or correct inaccurate or incomplete profile records directly via your user dashboard.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <strong class="color-05B f-14 d-block mb-1">{{ __('Right to Erasure (To Be Forgotten)') }}</strong>
                                    <span class="f-13 color-5B">{{ __('Request deletion of your profile data, subject to mandatory legal tax and AML transaction retention periods.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <strong class="color-05B f-14 d-block mb-1">{{ __('Right to Restrict Processing') }}</strong>
                                    <span class="f-13 color-5B">{{ __('Limit how we use your data if you dispute its accuracy or legitimacy.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 8: Policy Updates -->
                    <div class="privacy-section-card" id="item-8">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="p-2 rounded-3 bg-light text-info f-18">
                                <i class="fas fa-history"></i>
                            </div>
                            <h2 class="gilroy-Semibold color-05B f-24 mb-0">{{ __('8. Updates to this Privacy Policy') }}</h2>
                        </div>
                        <p class="gilroy-regular color-5B f-15 leading-26 mb-0">
                            {{ __('We periodically update this policy to reflect new regulatory requirements or feature rollouts. When significant changes occur, we notify users via registered email and display an prominent in-app notification banner prior to the update taking effect.') }}
                        </p>
                    </div>

                    <!-- Section 9: Contact Us -->
                    <div class="privacy-section-card" id="item-9">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="p-2 rounded-3 bg-light text-primary f-18">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h2 class="gilroy-Semibold color-05B f-24 mb-0">{{ __('9. Contact Our Data Protection Officer') }}</h2>
                        </div>
                        <p class="gilroy-regular color-5B f-15 leading-26 mb-4">
                            {{ __('If you have questions, regulatory inquiries, or wish to exercise your data privacy rights, please reach out to our dedicated compliance team:') }}
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="mailto:privacy@paymoney.com" class="btn btn-primary px-4 py-2 rounded-pill f-14">
                                <i class="fas fa-envelope me-2"></i> {{ __('Contact Privacy Team') }}
                            </a>
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill f-14">
                                <i class="fas fa-home me-2"></i> {{ __('Return to Home') }}
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Interactive ScrollSpy & Reading Progress Animation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Reading Progress Bar
            var progressBar = document.getElementById('policyProgressBar');
            window.addEventListener('scroll', function () {
                var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                var docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                if (docHeight > 0 && progressBar) {
                    var scrolled = (scrollTop / docHeight) * 100;
                    progressBar.style.width = Math.min(100, Math.max(0, scrolled)) + '%';
                }
            }, { passive: true });

            // 2. Active Section Highlight in Table of Contents
            var cards = document.querySelectorAll('.privacy-section-card');
            var tocLinks = document.querySelectorAll('.privacy-toc-link');

            function updateActiveTOC() {
                var scrollPosition = window.pageYOffset + 150;
                var currentId = '';

                cards.forEach(function (card) {
                    var cardTop = card.offsetTop;
                    var cardHeight = card.offsetHeight;
                    if (scrollPosition >= cardTop && scrollPosition < cardTop + cardHeight) {
                        currentId = card.getAttribute('id');
                    }
                });

                if (currentId) {
                    tocLinks.forEach(function (link) {
                        var href = link.getAttribute('href');
                        if (href === '#' + currentId) {
                            link.classList.add('active');
                        } else {
                            link.classList.remove('active');
                        }
                    });
                }
            }

            window.addEventListener('scroll', updateActiveTOC, { passive: true });

            // 3. Highlight animation when target anchor is opened
            function checkTargetHash() {
                if (window.location.hash) {
                    var targetEl = document.querySelector(window.location.hash);
                    if (targetEl && targetEl.classList.contains('privacy-section-card')) {
                        targetEl.classList.add('highlight-target');
                        setTimeout(function () {
                            targetEl.classList.remove('highlight-target');
                        }, 2500);
                    }
                }
            }

            checkTargetHash();
            window.addEventListener('hashchange', checkTargetHash);
        });
    </script>
@endsection
