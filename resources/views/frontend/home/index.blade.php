@extends('frontend.layouts.app')
@section('content')

    <!-- Hero section -->
    <div class="bottom-head"> 
       <div class="px-240">
           <div class="row align-items-center">
               <div class="col-xl-7 col-lg-8 col-md-10 col-12 hero-content-col">
                   <div class="hero-text-card">
                       <span class="mb-2 gilroy-medium f-18 color-5Br d-inline-flex align-items-center gap-2 hero-kicker">
                           <span class="pulse-dot"></span>
                           {{ __('THE SAFEST & MOST RELIABLE') }}
                       </span>
                       <h1 class="hero-main-title mb-2">
                           <span class="gilroy-Semibold color-FFr hero-word-money d-block">{{ __('MONEY') }}</span>
                           <span class="gilroy-medium color-5Br hero-word-trans d-block">{{ __('TRANSACTION') }}</span>
                           <span class="gilroy-light color-B87r hero-word-plat d-block">{{ __('PLATFORM') }}</span>
                       </h1>

                       <p class="pb-0 mt-3 color-5Br gilroy-regular f-18 hero-desc">
                           {{ __('Send, receive, deposit, request, invest and exchange money globally in multiple currencies easily, quickly and safely with great rates and low fees.') }}
                       </p>

                       <p class="mt-4 mb-2 color-5Br gilroy-medium f-16">
                           {{ __('Let’s Get Started..') }}
                       </p>

                       <div class="d-flex flex-wrap gap-3 align-items-center mt-3 hero-action-buttons">
                           <a href="{{ auth()->check() ? url('dashboard') : url('register') }}" class="btn-paytm-cyan text-decoration-none d-inline-flex align-items-center gap-2 f-18">
                               <span>{{ auth()->check() ? __('Go to Dashboard') : __('Create Free Account') }}</span>
                               <i class="fas fa-arrow-right f-14"></i>
                           </a>
                           <a href="{{ auth()->check() ? route('user.merchants.index') : url('register') }}" class="btn-paytm-outline text-decoration-none d-inline-flex align-items-center gap-2 f-16">
                               <i class="fas fa-store"></i>
                               <span>{{ __('PayMoney for Business') }}</span>
                           </a>
                       </div>
                       <div class="d-flex flex-wrap align-items-center gap-3 mt-3 text-muted f-13 hero-trust-badges">
                           <span><i class="fas fa-check-circle text-success me-1"></i> {{ __('Zero Setup Fee') }}</span>
                           <span><i class="fas fa-check-circle text-success me-1"></i> {{ __('Instant Verification') }}</span>
                           <span><i class="fas fa-shield-alt text-primary me-1"></i> {{ __('Bank-Grade 256-Bit Security') }}</span>
                       </div>
                   </div>
               </div>
           </div>
       </div>
    </div>

	<!-- Quick Financial Actions & Portal Services Tray -->
	<div class="px-240 paytm-utility-tray-wrapper">
		<div class="paytm-utility-card">
			<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
				<div>
					<h3 class="gilroy-Semibold color-05B f-24 mb-1">{{ __('Digital Wallet & Financial Services') }}</h3>
					<p class="text-muted f-14 mb-0">{{ __('Seamless peer-to-peer transfers, multi-currency deposits, bank withdrawals, and business payment tools.') }}</p>
				</div>
				<a href="{{ url('services') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 f-13 gilroy-medium">
					{{ __('View All Services') }} <i class="fas fa-arrow-right ms-1"></i>
				</a>
			</div>

			<div class="row g-3 row-cols-2 row-cols-sm-4 row-cols-lg-8">
				<!-- 1. Send Money -->
				<div class="col">
					<a href="{{ auth()->check() ? route('user.send_money.create') : url('login') }}" class="paytm-service-tile" title="{{ __('Send Money to Anyone Instantly') }}">
						<div class="paytm-service-icon" style="background: rgba(16, 185, 129, 0.12); color: #10B981;">
							<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<line x1="22" y1="2" x2="11" y2="13"></line>
								<polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
							</svg>
						</div>
						<span class="paytm-service-title">{{ __('Send Money') }}</span>
						<span class="paytm-service-badge">{{ __('Zero Fee P2P') }}</span>
					</a>
				</div>

				<!-- 2. Request Money -->
				<div class="col">
					<a href="{{ auth()->check() ? route('user.request_money.create') : url('login') }}" class="paytm-service-tile" title="{{ __('Request Payment or Create Link') }}">
						<div class="paytm-service-icon" style="background: rgba(99, 91, 254, 0.12); color: #635BFE;">
							<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#635BFE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M17 14h6m-3-3v6"></path>
								<path d="M11 19H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v4"></path>
								<circle cx="12" cy="12" r="3"></circle>
							</svg>
						</div>
						<span class="paytm-service-title">{{ __('Request Money') }}</span>
						<span class="paytm-service-badge">{{ __('Payment Links') }}</span>
					</a>
				</div>

				<!-- 3. Deposit Money -->
				<div class="col">
					<a href="{{ auth()->check() ? route('user.deposit.create') : url('login') }}" class="paytm-service-tile" title="{{ __('Deposit Funds via Cards, Bank or Crypto') }}">
						<div class="paytm-service-icon" style="background: rgba(0, 186, 242, 0.12); color: #00BAF2;">
							<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#00BAF2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M12 2v14M5 9l7 7 7-7"></path>
								<rect x="2" y="18" width="20" height="4" rx="1"></rect>
							</svg>
						</div>
						<span class="paytm-service-title">{{ __('Deposit Money') }}</span>
						<span class="paytm-service-badge">{{ __('Instant Rails') }}</span>
					</a>
				</div>

				<!-- 4. Withdraw Money -->
				<div class="col">
					<a href="{{ auth()->check() ? route('user.withdrawal.create') : url('login') }}" class="paytm-service-tile" title="{{ __('Withdraw Funds to Bank or Payout Methods') }}">
						<div class="paytm-service-icon" style="background: rgba(245, 158, 11, 0.12); color: #F59E0B;">
							<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M12 18V4M5 11l7-7 7 7"></path>
								<rect x="2" y="18" width="20" height="4" rx="1"></rect>
							</svg>
						</div>
						<span class="paytm-service-title">{{ __('Withdraw Funds') }}</span>
						<span class="paytm-service-badge">{{ __('Bank Payout') }}</span>
					</a>
				</div>

				<!-- 5. Exchange Currency -->
				<div class="col">
					<a href="{{ auth()->check() ? route('user.exchange_money.create') : url('login') }}" class="paytm-service-tile" title="{{ __('Convert Between Fiat & Crypto Balances') }}">
						<div class="paytm-service-icon" style="background: rgba(249, 115, 22, 0.12); color: #F97316;">
							<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#F97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M16 3h5v5"></path>
								<path d="M4 20L21 3"></path>
								<path d="M21 16v5h-5"></path>
								<path d="M15 15l6 6"></path>
								<path d="M4 4l5 5"></path>
							</svg>
						</div>
						<span class="paytm-service-title">{{ __('Exchange Money') }}</span>
						<span class="paytm-service-badge">{{ __('Fiat & Crypto') }}</span>
					</a>
				</div>

				<!-- 6. Merchant Gateway -->
				<div class="col">
					<a href="{{ auth()->check() ? route('user.merchants.index') : url('login') }}" class="paytm-service-tile" title="{{ __('Payment Gateway & Merchant Accounts') }}">
						<div class="paytm-service-icon" style="background: rgba(0, 41, 112, 0.1); color: #002970;">
							<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#002970" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
								<polyline points="9 22 9 12 15 12 15 22"></polyline>
							</svg>
						</div>
						<span class="paytm-service-title">{{ __('Merchant Gateway') }}</span>
						<span class="paytm-service-badge">{{ __('Checkout & API') }}</span>
					</a>
				</div>

				<!-- 7. Virtual Debit Cards -->
				<div class="col">
					<a href="{{ auth()->check() ? route('user.virtualcard.create') : url('login') }}" class="paytm-service-tile" title="{{ __('Instant Virtual Debit Cards') }}">
						<div class="paytm-service-icon" style="background: rgba(99, 102, 241, 0.12); color: #6366F1;">
							<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#6366F1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<rect x="1" y="4" width="22" height="16" rx="3" ry="3"></rect>
								<line x1="1" y1="10" x2="23" y2="10"></line>
								<circle cx="7" cy="15" r="1.5" fill="#6366F1"></circle>
							</svg>
						</div>
						<span class="paytm-service-title">{{ __('Virtual Cards') }}</span>
						<span class="paytm-service-badge">{{ __('Visa & Master') }}</span>
					</a>
				</div>

				<!-- 8. Multi-Currency Wallets -->
				<div class="col">
					<a href="{{ auth()->check() ? route('user.wallets.index') : url('login') }}" class="paytm-service-tile" title="{{ __('Check Multi-Currency Wallet Balances') }}">
						<div class="paytm-service-icon" style="background: rgba(59, 130, 246, 0.12); color: #3B82F6;">
							<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path>
								<circle cx="16" cy="14" r="2"></circle>
								<path d="M4 7V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2"></path>
							</svg>
						</div>
						<span class="paytm-service-title">{{ __('My Wallets') }}</span>
						<span class="paytm-service-badge">{{ __('20+ Currencies') }}</span>
					</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Paytm-Style Trust & Scale Metrics Strip -->
	<div class="px-240 mb-5">
		<div class="paytm-metrics-strip">
			<div class="row text-center g-4">
				<div class="col-6 col-md-3 paytm-metric-box">
					<div class="f-36 gilroy-Semibold text-white mb-1">30M+</div>
					<div class="f-14 text-light opacity-75">{{ __('Trusted Registered Users') }}</div>
				</div>
				<div class="col-6 col-md-3 paytm-metric-box">
					<div class="f-36 gilroy-Semibold text-white mb-1">500K+</div>
					<div class="f-14 text-light opacity-75">{{ __('Active Business Merchants') }}</div>
				</div>
				<div class="col-6 col-md-3 paytm-metric-box">
					<div class="f-36 gilroy-Semibold text-white mb-1">180+</div>
					<div class="f-14 text-light opacity-75">{{ __('Countries & 20+ Currencies') }}</div>
				</div>
				<div class="col-6 col-md-3 paytm-metric-box">
					<div class="f-36 gilroy-Semibold text-white mb-1">99.99%</div>
					<div class="f-14 text-light opacity-75">{{ __('Bank-Grade Network Uptime') }}</div>
				</div>
			</div>
		</div>
	</div>
	<!-- What you get section design -->
	<div class="px-240 get-section">
		<div class="row">
			<div class="col-lg-6">
				<p class="mb-0 f-18 color-FE gilroy-medium mt-136 leading-24">
					{{ __('WHAT YOU GET') }}
				</p>
				<p class="mb-0 color-05B gilroy-Semibold f-36 mt-2">
					{{ __('ALL AROUND') }} <br> {{ __('PAYMENT SOLUTIONS') }}
				</p>

				<p class="small-border mb-0 mt-20 bgd-blue"></p>

				<p class="mb-0 gilroy-medium f-24 mt-36 color-5B">
					{{ __('The Secure, Easiest And Fastest') }} <br>
					{{ __('Money Transfer.') }}
				</p>
				<p class="mt-20 gilroy-light f-18 color-5B w-517">
					{{ __('Send, receive, deposit, request, invest and exchange money globally in multiple currencies easily, quickly and safely with great rates and low fees.') }}				</p>
				<a href="{{ auth()->check() ? route('user.dashboard') : url('register') }}" class="learn-btn text-lg gilroy-Semibold mt-32">{{ auth()->check() ? __('Explore Your Account') : __('Get Started Today') }}
					<svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M0 4.57143C0 4.25584 0.255837 4 0.571429 4L15.4286 4C15.7442 4 16 4.25584 16 4.57143C16 4.88702 15.7442 5.14286 15.4286 5.14286L0.571429 5.14286C0.255837 5.14286 0 4.88702 0 4.57143Z" fill="currentColor"/>
						<path fill-rule="evenodd" clip-rule="evenodd" d="M11.0243 0.167368C11.2475 -0.0557892 11.6093 -0.0557892 11.8324 0.167368L15.8324 4.16737C16.0556 4.39052 16.0556 4.75233 15.8324 4.97549L11.8324 8.97549C11.6093 9.19865 11.2475 9.19865 11.0243 8.97549C10.8011 8.75233 10.8011 8.39052 11.0243 8.16737L14.6202 4.57143L11.0243 0.97549C10.8011 0.752333 10.8011 0.390524 11.0243 0.167368Z" fill="currentColor"/>
					</svg>					
				</a>
			</div>
			<div class="col-lg-6 px-35">
				<div class="row mt-161">
					<div class="col-sm-6 border-end pl-0 px-20r border-n">
						<div class="d-flex">
							<svg class="w-r36" width="44" height="62" viewBox="0 0 44 62" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path class="path-yellow" d="M21.8375 42.201C29.6322 42.201 35.951 35.8822 35.951 28.0876C35.951 20.2929 29.6322 13.9741 21.8375 13.9741C14.0429 13.9741 7.72412 20.2929 7.72412 28.0876C7.72412 35.8822 14.0429 42.201 21.8375 42.201Z" fill="#9D80F8"/>
								<path class="path-black" fill-rule="evenodd" clip-rule="evenodd" d="M22.1393 22.0655C21.0238 22.0655 20.1219 22.9674 20.1219 24.0829C20.1219 24.7892 20.5847 25.4012 21.519 25.7933C21.829 25.923 22.0991 26.0043 22.4209 26.1012C22.641 26.1675 22.8853 26.2411 23.1831 26.3424C23.8167 26.5579 24.5685 26.8721 25.2094 27.4802C26.1417 28.3622 26.7002 29.6072 26.7002 30.915C26.7002 33.5737 24.5441 35.7298 21.8854 35.7298C20.4812 35.7298 19.2156 35.1295 18.3342 34.167C17.8796 33.6707 17.9135 32.8998 18.4099 32.4452C18.9062 31.9906 19.6771 32.0245 20.1317 32.5209C20.569 32.9984 21.1904 33.2924 21.8854 33.2924C23.198 33.2924 24.2628 32.2276 24.2628 30.915C24.2628 30.2983 23.9956 29.6869 23.5339 29.2503L23.5322 29.2487C23.2752 29.0047 22.9228 28.8284 22.3982 28.6499C22.2637 28.6042 22.0913 28.5512 21.8998 28.4924C21.4858 28.3654 20.9822 28.2108 20.5777 28.0416L20.5765 28.0411C19.1087 27.4253 17.6846 26.12 17.6846 24.0829C17.6846 21.6213 19.6777 19.6282 22.1393 19.6282C23.372 19.6282 24.4834 20.1312 25.287 20.9297C25.7645 21.404 25.767 22.1757 25.2926 22.6531C24.8182 23.1306 24.0466 23.1331 23.5691 22.6587C23.1981 22.2901 22.6952 22.0655 22.1393 22.0655Z" fill="white"/>
								<path class="path-black" fill-rule="evenodd" clip-rule="evenodd" d="M22.143 17.4417C22.8161 17.4417 23.3617 17.9873 23.3617 18.6603V20.8468C23.3617 21.5198 22.8161 22.0654 22.143 22.0654C21.4699 22.0654 20.9243 21.5198 20.9243 20.8468V18.6603C20.9243 17.9873 21.4699 17.4417 22.143 17.4417Z" fill="white"/>
								<path class="path-black" fill-rule="evenodd" clip-rule="evenodd" d="M22.143 33.4021C22.8161 33.4021 23.3617 33.9477 23.3617 34.6208V37.2923C23.3617 37.9653 22.8161 38.5109 22.143 38.5109C21.4699 38.5109 20.9243 37.9653 20.9243 37.2923V34.6208C20.9243 33.9477 21.4699 33.4021 22.143 33.4021Z" fill="white"/>
								<path class="path-white" fill-rule="evenodd" clip-rule="evenodd" d="M5.54818 3.46754C4.4018 3.46754 3.47145 4.39615 3.47145 5.54427V56.1107C3.47145 57.257 4.40005 58.1874 5.54818 58.1874H38.1348C39.2812 58.1874 40.2115 57.2588 40.2115 56.1107V25.9785C40.2115 25.021 40.9878 24.2447 41.9453 24.2447C42.9028 24.2447 43.6791 25.021 43.6791 25.9785V56.1107C43.6791 59.1764 41.1937 61.6549 38.1348 61.6549H5.54818C2.48244 61.6549 0.00390625 59.1696 0.00390625 56.1107V5.54427C0.00390625 2.47853 2.48928 0 5.54818 0H38.1348C41.2005 0 43.6791 2.48537 43.6791 5.54427V17.332C43.6791 18.2895 42.9028 19.0657 41.9453 19.0657C40.9878 19.0657 40.2115 18.2895 40.2115 17.332V5.54427C40.2115 4.3979 39.2829 3.46754 38.1348 3.46754H5.54818Z" fill="#403E5B"/>
								<path class="path-white" fill-rule="evenodd" clip-rule="evenodd" d="M0 9.04603C0 8.08849 0.776236 7.31226 1.73377 7.31226H41.9457C42.9032 7.31226 43.6795 8.08849 43.6795 9.04603C43.6795 10.0036 42.9032 10.7798 41.9457 10.7798H1.73377C0.776236 10.7798 0 10.0036 0 9.04603Z" fill="#403E5B"/>
								<path class="path-white" fill-rule="evenodd" clip-rule="evenodd" d="M6.12354 47.9835C6.12354 47.026 6.89977 46.2498 7.85731 46.2498H41.9458C42.9033 46.2498 43.6796 47.026 43.6796 47.9835C43.6796 48.9411 42.9033 49.7173 41.9458 49.7173H7.85731C6.89977 49.7173 6.12354 48.9411 6.12354 47.9835Z" fill="#403E5B"/>
								<path class="path-white" fill-rule="evenodd" clip-rule="evenodd" d="M16.9111 53.9137C16.9111 52.9562 17.6874 52.1799 18.6449 52.1799H25.0343C25.9919 52.1799 26.7681 52.9562 26.7681 53.9137C26.7681 54.8712 25.9919 55.6475 25.0343 55.6475H18.6449C17.6874 55.6475 16.9111 54.8712 16.9111 53.9137Z" fill="#403E5B"/>
							</svg>
							<div class="ml-29">
								<p class="mb-0 color-FF gilroy-medium f-18 leading-24 f-r16">{{ __('Payment') }}</p>
								<p class="mb-0 f-26 gilroy-medium f-r24 color-05B">{{ __('API') }}</p>
							</div>
								
						</div>
						<p class="mb-0 mt-30 color-5B text-lg gilroy-light mb-44 mb-49r pr-4 mt-r20">
							{{ __("It will manage customer's :x experience by integrating our seamless API interface within your website.", ['x' => settings('name')]) }}
						</p>
					</div>
					<div class="col-sm-6 p-r0 px-20r">
						<div class="d-flex ml-44 ml-0r">
							<svg class="w-r71" width="87" height="58" viewBox="0 0 87 58" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path class="path-yellow" d="M18.8664 31.7294C25.9704 31.7294 31.7294 25.9704 31.7294 18.8664C31.7294 11.7624 25.9704 6.00342 18.8664 6.00342C11.7624 6.00342 6.00342 11.7624 6.00342 18.8664C6.00342 25.9704 11.7624 31.7294 18.8664 31.7294Z" fill="#9D80F8"/>
								<path class="path-white" fill-rule="evenodd" clip-rule="evenodd" d="M24.6636 46.8892C25.2756 46.2041 26.327 46.1449 27.0121 46.7568C31.4109 50.6863 37.2097 53.0737 43.5746 53.0737C48.1263 53.0737 52.3899 51.8521 56.0567 49.7203C56.8508 49.2586 57.8689 49.528 58.3306 50.3222C58.7923 51.1163 58.5228 52.1344 57.7287 52.5961C53.5676 55.0153 48.7291 56.4002 43.5746 56.4002C36.3607 56.4002 29.7806 53.6905 24.7959 49.2377C24.1109 48.6257 24.0516 47.5743 24.6636 46.8892Z" fill="#403E5B"/>
								<path class="path-white" fill-rule="evenodd" clip-rule="evenodd" d="M43.5742 3.32654C38.9677 3.32654 34.6578 4.57537 30.9645 6.75337C30.1732 7.21999 29.1535 6.95682 28.6869 6.16556C28.2203 5.3743 28.4834 4.35459 29.2747 3.88797C33.4672 1.41561 38.3587 0 43.5742 0C51.3603 0 58.4146 3.1586 63.5173 8.26122C64.1668 8.91076 64.1668 9.96389 63.5173 10.6134C62.8677 11.263 61.8146 11.263 61.165 10.6134C56.6608 6.10916 50.4426 3.32654 43.5742 3.32654Z" fill="#403E5B"/>
								<path class="path-white" fill-rule="evenodd" clip-rule="evenodd" d="M18.8663 3.32654C10.2839 3.32654 3.32654 10.2839 3.32654 18.8663C3.32654 27.4487 10.2839 34.4061 18.8663 34.4061C27.4487 34.4061 34.4061 27.4487 34.4061 18.8663C34.4061 10.2839 27.4487 3.32654 18.8663 3.32654ZM0 18.8663C0 8.44673 8.44674 0 18.8663 0C29.2859 0 37.7326 8.44673 37.7326 18.8663C37.7326 29.2859 29.2859 37.7326 18.8663 37.7326C8.44674 37.7326 0 29.2859 0 18.8663Z" fill="#403E5B"/>
								<path class="path-white" fill-rule="evenodd" clip-rule="evenodd" d="M68.1339 22.6024C59.5515 22.6024 52.5941 29.5598 52.5941 38.1422C52.5941 46.7246 59.5515 53.682 68.1339 53.682C76.7162 53.682 83.6736 46.7246 83.6736 38.1422C83.6736 29.5598 76.7162 22.6024 68.1339 22.6024ZM49.2676 38.1422C49.2676 27.7226 57.7143 19.2759 68.1339 19.2759C78.5534 19.2759 87.0002 27.7226 87.0002 38.1422C87.0002 48.5618 78.5534 57.0085 68.1339 57.0085C57.7143 57.0085 49.2676 48.5618 49.2676 38.1422Z" fill="#6A6B87"/>
								<path class="path-white" d="M66.2511 11.7089L64.3521 6.18138C63.9756 5.08499 62.5524 4.80778 61.7911 5.68075L57.9558 10.087C57.1945 10.96 57.6661 12.3336 58.8039 12.5529L64.5383 13.6699C65.676 13.8975 66.6276 12.8052 66.2511 11.7089Z" fill="#403E5B"/>
								<path class="path-white" d="M21.0216 45.7219L22.9207 51.2494C23.2972 52.3458 24.7204 52.623 25.4817 51.75L29.317 47.3437C30.0783 46.4708 29.6066 45.0972 28.4688 44.8779L22.7345 43.7608C21.5967 43.5332 20.6451 44.6255 21.0216 45.7219Z" fill="#403E5B"/>
								<path class="path-white" fill-rule="evenodd" clip-rule="evenodd" d="M68.0714 31.6861C66.8535 31.6861 65.8687 32.6709 65.8687 33.8888C65.8687 34.6599 66.374 35.3281 67.3941 35.7563C67.7326 35.8979 68.0275 35.9867 68.3789 36.0925C68.6192 36.1648 68.8859 36.2452 69.211 36.3558C69.9029 36.5911 70.7237 36.9341 71.4235 37.5981C72.4414 38.5611 73.0512 39.9205 73.0512 41.3484C73.0512 44.2513 70.697 46.6054 67.7942 46.6054C66.261 46.6054 64.8791 45.9499 63.9168 44.8991C63.4205 44.3571 63.4575 43.5155 63.9994 43.0191C64.5414 42.5228 65.3831 42.5598 65.8794 43.1018C66.3568 43.6231 67.0354 43.9441 67.7942 43.9441C69.2273 43.9441 70.39 42.7815 70.39 41.3484C70.39 40.675 70.0982 40.0075 69.5941 39.5308L69.5922 39.529C69.3116 39.2626 68.9269 39.0701 68.354 38.8752C68.2072 38.8253 68.019 38.7675 67.8099 38.7033C67.3579 38.5646 66.808 38.3958 66.3663 38.211L66.3651 38.2105C64.7625 37.5381 63.2075 36.113 63.2075 33.8888C63.2075 31.2011 65.3837 29.0249 68.0714 29.0249C69.4173 29.0249 70.6308 29.5741 71.5082 30.4459C72.0295 30.9639 72.0323 31.8064 71.5143 32.3277C70.9963 32.849 70.1539 32.8517 69.6325 32.3338C69.2274 31.9313 68.6784 31.6861 68.0714 31.6861Z" fill="#403E5B"/>
								<path class="path-white" fill-rule="evenodd" clip-rule="evenodd" d="M68.0757 26.6377C68.8106 26.6377 69.4063 27.2334 69.4063 27.9683V30.3556C69.4063 31.0904 68.8106 31.6862 68.0757 31.6862C67.3409 31.6862 66.7451 31.0904 66.7451 30.3556V27.9683C66.7451 27.2334 67.3409 26.6377 68.0757 26.6377Z" fill="#403E5B"/>
								<path class="path-white" fill-rule="evenodd" clip-rule="evenodd" d="M68.0757 44.0642C68.8106 44.0642 69.4063 44.6599 69.4063 45.3948V48.3117C69.4063 49.0465 68.8106 49.6423 68.0757 49.6423C67.3409 49.6423 66.7451 49.0465 66.7451 48.3117V45.3948C66.7451 44.6599 67.3409 44.0642 68.0757 44.0642Z" fill="#403E5B"/>
								<path class="path-gray" fill-rule="evenodd" clip-rule="evenodd" d="M68.1339 22.6024C59.5515 22.6024 52.5941 29.5598 52.5941 38.1422C52.5941 46.7246 59.5515 53.682 68.1339 53.682C76.7162 53.682 83.6736 46.7246 83.6736 38.1422C83.6736 29.5598 76.7162 22.6024 68.1339 22.6024ZM49.2676 38.1422C49.2676 27.7226 57.7143 19.2759 68.1339 19.2759C78.5534 19.2759 87.0002 27.7226 87.0002 38.1422C87.0002 48.5618 78.5534 57.0085 68.1339 57.0085C57.7143 57.0085 49.2676 48.5618 49.2676 38.1422Z" fill="#6A6B87"/>
								<path class="path-black" fill-rule="evenodd" clip-rule="evenodd" d="M19.5942 24.55C20.1453 24.55 20.5921 24.9969 20.5921 25.548V28.3904C20.5921 28.9415 20.1453 29.3883 19.5942 29.3883C19.043 29.3883 18.5962 28.9415 18.5962 28.3904V25.548C18.5962 24.9969 19.043 24.55 19.5942 24.55Z" fill="white"/>
								<path class="path-black" fill-rule="evenodd" clip-rule="evenodd" d="M19.5942 8.34424C20.1453 8.34424 20.5921 8.79104 20.5921 9.3422V12.1845C20.5921 12.7357 20.1453 13.1825 19.5942 13.1825C19.043 13.1825 18.5962 12.7357 18.5962 12.1845V9.3422C18.5962 8.79104 19.043 8.34424 19.5942 8.34424Z" fill="white"/>
								<path class="path-black" fill-rule="evenodd" clip-rule="evenodd" d="M16.4994 8.34424C17.0506 8.34424 17.4974 8.79104 17.4974 9.3422V28.3905C17.4974 28.9417 17.0506 29.3885 16.4994 29.3885C15.9483 29.3885 15.5015 28.9417 15.5015 28.3905V9.3422C15.5015 8.79104 15.9483 8.34424 16.4994 8.34424Z" fill="white"/>
								<path class="path-black" fill-rule="evenodd" clip-rule="evenodd" d="M12.9243 12.1847C12.9243 11.6336 13.3711 11.1868 13.9223 11.1868H20.4924C22.8813 11.1868 24.8126 13.1238 24.8126 15.507V15.5401C24.8126 17.9291 22.8756 19.8604 20.4924 19.8604H16.504C15.9528 19.8604 15.506 19.4136 15.506 18.8624C15.506 18.3112 15.9528 17.8644 16.504 17.8644H20.4924C21.7749 17.8644 22.8167 16.8251 22.8167 15.5401V15.507C22.8167 14.2245 21.7774 13.1827 20.4924 13.1827H13.9223C13.3711 13.1827 12.9243 12.7359 12.9243 12.1847Z" fill="white"/>
								<path class="path-black" fill-rule="evenodd" clip-rule="evenodd" d="M15.5016 18.8664C15.5016 18.3152 15.9484 17.8684 16.4996 17.8684H20.488C22.8769 17.8684 24.8082 19.8055 24.8082 22.1887V22.2218C24.8082 24.6107 22.8712 26.542 20.488 26.542H13.9179C13.3667 26.542 12.9199 26.0952 12.9199 25.544C12.9199 24.9929 13.3667 24.5461 13.9179 24.5461H20.488C21.7705 24.5461 22.8123 23.5068 22.8123 22.2218V22.1887C22.8123 20.9062 21.773 19.8643 20.488 19.8643H16.4996C15.9484 19.8643 15.5016 19.4175 15.5016 18.8664Z" fill="white"/>
							</svg>
							<div class="ml-29">
								<p class="mb-0 color-FF gilroy-medium f-18 leading-24 f-r16">{{ __('Currency') }}</p>
								<p class="mb-0 f-26 gilroy-medium f-r24 color-05B">{{ __('Exchange') }}</p>
							</div>
								
						</div>
						<p class="mb-0 mt-30 color-5B text-lg gilroy-light mb-44 ml-44 mt-r20 ml-0r">
							{{ __('Exchange from one currency to another is a very simple & quick way. Crypto currency also supported.') }} 						</p>
					</div>
					<div class="col-sm-6 border-top border-end pl-0 border-n px-20r">
						<div class="d-flex mt-53">
							<svg width="54" height="60" viewBox="0 0 54 60" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path class="path-yellow" d="M26.7053 4.78027C18.2935 4.78027 11.4761 11.5977 11.4761 20.0095C11.4761 21.4783 11.6842 22.8998 12.073 24.2429H41.3415C41.7303 22.8998 41.9385 21.4783 41.9385 20.0095C41.9345 11.5977 35.1171 4.78027 26.7053 4.78027Z" fill="#9D80F8"/>
								<path class="path-black" fill-rule="evenodd" clip-rule="evenodd" d="M27.2315 8.45947C27.7328 8.45947 28.1392 8.86589 28.1392 9.36723V12.5403C28.1392 13.0417 27.7328 13.4481 27.2315 13.4481C26.7301 13.4481 26.3237 13.0417 26.3237 12.5403V9.36723C26.3237 8.86589 26.7301 8.45947 27.2315 8.45947Z" fill="white"/>
								<path class="path-black" fill-rule="evenodd" clip-rule="evenodd" d="M23.7676 8.45947C24.269 8.45947 24.6754 8.86589 24.6754 9.36723V23.9917C24.6754 24.4931 24.269 24.8995 23.7676 24.8995C23.2663 24.8995 22.8599 24.4931 22.8599 23.9917V9.36723C22.8599 8.86589 23.2663 8.45947 23.7676 8.45947Z" fill="white"/>
								<path class="path-black" fill-rule="evenodd" clip-rule="evenodd" d="M19.9775 12.5403C19.9775 12.039 20.384 11.6326 20.8853 11.6326H28.2289C30.7848 11.6326 32.8517 13.7047 32.8517 16.2554V16.2946C32.8517 18.8504 30.7796 20.9174 28.2289 20.9174H23.7678C23.2664 20.9174 22.86 20.511 22.86 20.0096C22.86 19.5083 23.2664 19.1019 23.7678 19.1019H28.2289C29.7781 19.1019 31.0362 17.8465 31.0362 16.2946V16.2554C31.0362 14.7061 29.7808 13.4481 28.2289 13.4481H20.8853C20.384 13.4481 19.9775 13.0417 19.9775 12.5403Z" fill="white"/>
								<path class="path-black" fill-rule="evenodd" clip-rule="evenodd" d="M22.8599 20.0098C22.8599 19.5085 23.2663 19.1021 23.7676 19.1021H28.2288C30.7846 19.1021 32.8516 21.1742 32.8516 23.7248V23.7641C32.8516 24.2654 32.4452 24.6719 31.9438 24.6719C31.4425 24.6719 31.0361 24.2654 31.0361 23.7641V23.7248C31.0361 22.1756 29.7807 20.9176 28.2288 20.9176H23.7676C23.2663 20.9176 22.8599 20.5111 22.8599 20.0098Z" fill="white"/>
								<path class="path-white" fill-rule="evenodd" clip-rule="evenodd" d="M26.7053 3.02586C17.3265 3.02586 9.72166 10.6307 9.72166 20.0095C9.72166 21.2696 9.85881 22.4918 10.1183 23.6702C10.2979 24.4862 9.78208 25.2934 8.96605 25.473C8.15003 25.6527 7.34286 25.1368 7.16319 24.3208C6.85714 22.9308 6.6958 21.4905 6.6958 20.0095C6.6958 8.9596 15.6554 0 26.7053 0C30.3484 0 33.7701 0.977238 36.7153 2.68142C37.4385 3.0999 37.6855 4.02544 37.267 4.74865C36.8485 5.47187 35.923 5.71891 35.1998 5.30042C32.702 3.85508 29.8011 3.02586 26.7053 3.02586Z" fill="#403E5B"/>
								<path class="path-white" fill-rule="evenodd" clip-rule="evenodd" d="M41.8806 9.32854C42.6003 8.90394 43.5278 9.14313 43.9524 9.86278C45.7085 12.8392 46.7111 16.3084 46.7111 20.0095C46.7111 21.3882 46.571 22.7392 46.3029 24.0413C46.1344 24.8597 45.3344 25.3866 44.516 25.2181C43.6976 25.0496 43.1707 24.2496 43.3392 23.4312C43.566 22.33 43.6852 21.1834 43.6852 20.0095C43.6852 16.8617 42.834 13.9218 41.3464 11.4004C40.9218 10.6807 41.161 9.75313 41.8806 9.32854Z" fill="#403E5B"/>
								<path class="path-white" fill-rule="evenodd" clip-rule="evenodd" d="M6.37859 25.5083C4.52331 25.5083 3.02586 27.0073 3.02586 28.8571V53.6252C3.02586 55.4742 4.52644 56.974 6.37859 56.974H47.0278C48.8804 56.974 50.3793 55.4742 50.3766 53.6274V28.8571C50.3766 27.0065 48.8784 25.5083 47.0278 25.5083H6.37859ZM0 28.8571C0 25.3346 2.85377 22.4824 6.37859 22.4824H47.0278C50.5495 22.4824 53.4025 25.3354 53.4025 28.8571L53.4025 53.623L53.4025 53.6252C53.4025 53.6245 53.4025 53.6237 53.4025 53.623M53.4025 53.6252C53.4064 57.1496 50.5468 59.9999 47.0278 59.9999H6.37859C2.85849 59.9999 0 57.1485 0 53.6252V28.8571" fill="#403E5B"/>
								<path class="path-white" fill-rule="evenodd" clip-rule="evenodd" d="M33.6523 37.6313C32.5372 37.6313 31.6347 38.5355 31.6347 39.6489V42.8298C31.6347 43.9449 32.5389 44.8473 33.6523 44.8473H50.3806V37.6313H33.6523ZM28.6089 39.6489C28.6089 36.8666 30.8639 34.6055 33.6523 34.6055H51.8936C52.7291 34.6055 53.4065 35.2828 53.4065 36.1184V46.3602C53.4065 47.1958 52.7291 47.8732 51.8936 47.8732H33.6523C30.87 47.8732 28.6089 45.6182 28.6089 42.8298V39.6489Z" fill="#403E5B"/>
								<path class="path-white" d="M37.7838 41.2393C37.7838 42.5902 36.6881 43.6859 35.3372 43.6859C33.9863 43.6859 32.8906 42.5902 32.8906 41.2393C32.8906 39.8884 33.9863 38.7927 35.3372 38.7927C36.6881 38.7927 37.7838 39.8884 37.7838 41.2393Z" fill="#403E5B"/>
							</svg>
								
							<div class="ml-29">
								<p class="mb-0 color-FF gilroy-medium f-18 leading-24 f-r16">{{ __('Online') }}</p>
								<p class="mb-0 f-26 gilroy-medium f-r24 color-05B">{{ __('Payments') }}</p>
							</div>
								
						</div>
						<p class="mb-0 mt-30 color-5B text-lg gilroy-light mb-44 pr-4 mt-r20">
							{{ __('Whether it is credit, debit or bank account you can pay in your preferred channel or method.') }}
						</p>					
					</div>
					<div class="col-sm-6 border-top border-n p-r0 px-20r">
						<div class="d-flex mt-53 ml-44 ml-0r">
							<svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path class="path-yellow" d="M28 49.9737C40.1357 49.9737 49.9737 40.1357 49.9737 28C49.9737 15.8643 40.1357 6.02637 28 6.02637C15.8643 6.02637 6.02637 15.8643 6.02637 28C6.02637 40.1357 15.8643 49.9737 28 49.9737Z" fill="#9D80F8"/>
								<path class="path-black" fill-rule="evenodd" clip-rule="evenodd" d="M27.8378 20.8125C26.3942 20.8125 25.227 21.9796 25.227 23.4232C25.227 24.3372 25.8259 25.1292 27.035 25.6367C27.4362 25.8045 27.7857 25.9097 28.2022 26.0351C28.487 26.1209 28.8031 26.2161 29.1885 26.3472C30.0085 26.6261 30.9815 27.0327 31.8109 27.8197C33.0173 28.9611 33.7401 30.5724 33.7401 32.2648C33.7401 35.7055 30.9498 38.4957 27.5092 38.4957C25.6919 38.4957 24.0541 37.7188 22.9134 36.4733C22.3252 35.831 22.369 34.8333 23.0114 34.2451C23.6537 33.6568 24.6513 33.7007 25.2396 34.343C25.8055 34.961 26.6098 35.3414 27.5092 35.3414C29.2078 35.3414 30.5858 33.9634 30.5858 32.2648C30.5858 31.4667 30.24 30.6755 29.6425 30.1104L29.6403 30.1083C29.3077 29.7926 28.8517 29.5644 28.1727 29.3334C27.9987 29.2743 27.7757 29.2058 27.5277 29.1297C26.992 28.9653 26.3403 28.7652 25.8168 28.5462L25.8153 28.5456C23.9158 27.7486 22.0728 26.0595 22.0728 23.4232C22.0728 20.2376 24.6522 17.6582 27.8378 17.6582C29.433 17.6582 30.8712 18.3092 31.9113 19.3425C32.5292 19.9564 32.5324 20.955 31.9185 21.5729C31.3046 22.1908 30.306 22.194 29.6881 21.5801C29.2079 21.103 28.5572 20.8125 27.8378 20.8125Z" fill="white"/>
								<path class="path-black" fill-rule="evenodd" clip-rule="evenodd" d="M27.8428 14.8286C28.7138 14.8286 29.4199 15.5347 29.4199 16.4057V19.2353C29.4199 20.1063 28.7138 20.8124 27.8428 20.8124C26.9717 20.8124 26.2656 20.1063 26.2656 19.2353V16.4057C26.2656 15.5347 26.9717 14.8286 27.8428 14.8286Z" fill="white"/>
								<path class="path-black" fill-rule="evenodd" clip-rule="evenodd" d="M27.8428 35.4834C28.7138 35.4834 29.4199 36.1895 29.4199 37.0605V40.5178C29.4199 41.3888 28.7138 42.0949 27.8428 42.0949C26.9717 42.0949 26.2656 41.3888 26.2656 40.5178V37.0605C26.2656 36.1895 26.9717 35.4834 27.8428 35.4834Z" fill="white"/>
								<path class="path-white" fill-rule="evenodd" clip-rule="evenodd" d="M28 3.29283C14.3561 3.29283 3.29283 14.3561 3.29283 28C3.29283 41.6439 14.3561 52.7072 28 52.7072C32.7563 52.7072 37.1912 51.3668 40.9567 49.0413C41.7304 48.5635 42.7449 48.8033 43.2227 49.5769C43.7005 50.3506 43.4606 51.3651 42.687 51.8429C38.4158 54.4807 33.3841 56 28 56C12.5375 56 0 43.4625 0 28C0 12.5375 12.5375 0 28 0C33.101 0 37.8834 1.3666 42.0052 3.75063C42.7923 4.20589 43.0614 5.21303 42.6061 6.00014C42.1508 6.78725 41.1437 7.05628 40.3566 6.60102C36.7211 4.49828 32.5053 3.29283 28 3.29283Z" fill="#403E5B"/>
								<path class="path-white" fill-rule="evenodd" clip-rule="evenodd" d="M49.8861 13.2198C50.6695 12.7583 51.6788 13.0192 52.1403 13.8027C54.5945 17.9688 56.0003 22.8212 56.0003 28.0001C56.0003 34.193 53.987 39.9186 50.5823 44.5586C50.0444 45.2917 49.014 45.4499 48.2809 44.912C47.5478 44.3741 47.3896 43.3437 47.9275 42.6106C50.9325 38.5154 52.7075 33.4678 52.7075 28.0001C52.7075 23.4248 51.4672 19.1475 49.3032 15.474C48.8417 14.6906 49.1026 13.6813 49.8861 13.2198Z" fill="#403E5B"/>
							</svg>
								
							<div class="ml-29">
								<p class="mb-0 color-FF gilroy-medium f-18 leading-24 f-r16">{{ __('Payment') }}</p>
								<p class="mb-0 f-26 gilroy-medium f-r24 color-05B">{{ __('Request') }}</p>
							</div>
								
						</div>
						<p class="mb-0 mt-30 color-5B text-lg gilroy-light mb-44 ml-44 ml-0r">
							{{ __('By these systems now you can request for payment from one person to another, within seconds.') }}						
						</p>
					</div>
				</div>
			</div>
		</div>

		<!-- Supported Global Payment Rails Strip -->
		<div class="paytm-payment-rails-strip py-4 my-4 border-top border-bottom text-center">
			<span class="f-13 text-uppercase font-weight-bold letter-spacing-1 text-muted d-block mb-3">{{ __('Trusted & Integrated Global Payment Rails') }}</span>
			<div class="d-flex flex-wrap align-items-center justify-content-center gap-4 gap-md-5">
				<span class="rail-badge d-inline-flex align-items-center gap-2 f-15 font-weight-600 text-dark">
					<i class="fab fa-cc-visa f-24" style="color: #1A1F71;"></i> Visa
				</span>
				<span class="rail-badge d-inline-flex align-items-center gap-2 f-15 font-weight-600 text-dark">
					<i class="fab fa-cc-mastercard f-24" style="color: #EB001B;"></i> Mastercard
				</span>
				<span class="rail-badge d-inline-flex align-items-center gap-2 f-15 font-weight-600 text-dark">
					<i class="fab fa-paypal f-22" style="color: #003087;"></i> PayPal
				</span>
				<span class="rail-badge d-inline-flex align-items-center gap-2 f-15 font-weight-600 text-dark">
					<i class="fab fa-stripe f-26" style="color: #635BFF;"></i> Stripe
				</span>
				<span class="rail-badge d-inline-flex align-items-center gap-2 f-15 font-weight-600 text-dark">
					<i class="fab fa-bitcoin f-22" style="color: #F7931A;"></i> Crypto Nodes
				</span>
				<span class="rail-badge d-inline-flex align-items-center gap-2 f-15 font-weight-600 text-dark">
					<i class="fas fa-university f-20 text-secondary"></i> Bank Wire / ACH
				</span>
			</div>
		</div>
	</div>


	<!-- Our Benefits section -->
	<div class="px-240 bg-ligt-pink py-5">
		<div class="text-center">
			<p class="color-FE gilroy-medium f-18 leading-24 mb-0">{{ __('WHY CHOOSE US') }}</p>
			<p class="color-05B gilroy-Semibold f-34 mb-23 mt-7" data-content="REASONS">{{ __('ENGINEERED FOR VALUE, SPEED & SECURITY') }}</p>
			<p class="small-border mb-0 bgd-blue m-auto"></p>
		</div>
		<div class="pb-137">
			<div class="row mt-72">
				<!-- Benefit 1: Low Cost -->
				<div class="col-md-6 col-xl-3 px-16 mb-32">
					<a href="{{ url('benefits') }}" class="bg-white p-4 h-100 white-shad text-decoration-none d-flex flex-column justify-content-between rounded-4 border">
						<div>
							<div class="d-flex align-items-center justify-content-between mb-3">
								<div class="p-3 rounded-circle bg-light text-primary f-24 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
									<i class="fas fa-percentage"></i>
								</div>
								<span class="badge bg-light text-primary border px-2 py-1 f-12 gilroy-medium">{{ __('From 0.5% Flat') }}</span>
							</div>
							<h3 class="color-05B gilroy-Semibold f-20 mb-2">{{ __('Ultra-Low Fees') }}</h3>
							<p class="color-5B f-15 leading-24 gilroy-light mb-3">
								{{ __('Maximize your revenue with transparent, competitive rates. No monthly account maintenance surcharges and zero hidden cross-border fees.') }}
							</p>
							<div class="f-13 color-5B gilroy-medium">
								<i class="fas fa-check text-success me-1"></i> {{ __('Free P2P Wallet Transfers') }}
							</div>
						</div>
						<div class="pt-3 border-top mt-3">
							<span class="text-primary gilroy-medium f-14">{{ __('View cost details') }} <i class="fas fa-arrow-right ms-1"></i></span>
						</div>
					</a>
				</div>

				<!-- Benefit 2: Easy Process -->
				<div class="col-md-6 col-xl-3 px-16 mb-32">
					<a href="{{ url('benefits') }}" class="bg-white p-4 h-100 white-shad text-decoration-none d-flex flex-column justify-content-between rounded-4 border">
						<div>
							<div class="d-flex align-items-center justify-content-between mb-3">
								<div class="p-3 rounded-circle bg-light text-success f-24 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
									<i class="fas fa-bolt"></i>
								</div>
								<span class="badge bg-light text-success border px-2 py-1 f-12 gilroy-medium">{{ __('3-Min Setup') }}</span>
							</div>
							<h3 class="color-05B gilroy-Semibold f-20 mb-2">{{ __('Frictionless Setup') }}</h3>
							<p class="color-5B f-15 leading-24 gilroy-light mb-3">
								{{ __('100% digital onboarding with automated KYC verification. Connect e-commerce plugins or generate merchant API keys instantly without paperwork.') }}
							</p>
							<div class="f-13 color-5B gilroy-medium">
								<i class="fas fa-check text-success me-1"></i> {{ __('Plug & Play Integrations') }}
							</div>
						</div>
						<div class="pt-3 border-top mt-3">
							<span class="text-primary gilroy-medium f-14">{{ __('View onboarding') }} <i class="fas fa-arrow-right ms-1"></i></span>
						</div>
					</a>
				</div>

				<!-- Benefit 3: Faster Payments -->
				<div class="col-md-6 col-xl-3 px-16 mb-32">
					<a href="{{ url('benefits') }}" class="bg-white p-4 h-100 white-shad text-decoration-none d-flex flex-column justify-content-between rounded-4 border">
						<div>
							<div class="d-flex align-items-center justify-content-between mb-3">
								<div class="p-3 rounded-circle bg-light text-warning f-24 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
									<i class="fas fa-rocket"></i>
								</div>
								<span class="badge bg-light text-warning border px-2 py-1 f-12 gilroy-medium">{{ __('Instant Settlement') }}</span>
							</div>
							<h3 class="color-05B gilroy-Semibold f-20 mb-2">{{ __('Real-Time Clearing') }}</h3>
							<p class="color-5B f-15 leading-24 gilroy-light mb-3">
								{{ __('Send and receive funds across borders in seconds. Wallet balances update in real-time with automated multi-rail bank and crypto confirmations.') }}
							</p>
							<div class="f-13 color-5B gilroy-medium">
								<i class="fas fa-check text-success me-1"></i> {{ __('24/7/365 Global Uptime') }}
							</div>
						</div>
						<div class="pt-3 border-top mt-3">
							<span class="text-primary gilroy-medium f-14">{{ __('View speed metrics') }} <i class="fas fa-arrow-right ms-1"></i></span>
						</div>
					</a>
				</div>

				<!-- Benefit 4: Secure and Safe -->
				<div class="col-md-6 col-xl-3 px-16 mb-32">
					<a href="{{ url('benefits') }}" class="bg-white p-4 h-100 white-shad text-decoration-none d-flex flex-column justify-content-between rounded-4 border">
						<div>
							<div class="d-flex align-items-center justify-content-between mb-3">
								<div class="p-3 rounded-circle bg-light text-danger f-24 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
									<i class="fas fa-shield-alt"></i>
								</div>
								<span class="badge bg-light text-danger border px-2 py-1 f-12 gilroy-medium">{{ __('256-Bit SSL & 2FA') }}</span>
							</div>
							<h3 class="color-05B gilroy-Semibold f-20 mb-2">{{ __('Institutional Security') }}</h3>
							<p class="color-5B f-15 leading-24 gilroy-light mb-3">
								{{ __('Bank-grade AES-256 encryption, mandatory 2FA authentication, multi-signature custodial architecture, and automated AI anti-fraud defense.') }}
							</p>
							<div class="f-13 color-5B gilroy-medium">
								<i class="fas fa-check text-success me-1"></i> {{ __('Custodial & Multi-Sig Vaults') }}
							</div>
						</div>
						<div class="pt-3 border-top mt-3">
							<span class="text-primary gilroy-medium f-14">{{ __('View security specs') }} <i class="fas fa-arrow-right ms-1"></i></span>
						</div>
					</a>
				</div>
			</div>

			<div class="text-center mt-4">
				<a href="{{ url('benefits') }}" class="btn btn-outline-primary px-4 py-2 rounded-pill gilroy-medium">
					{{ __('Explore All Benefits & Comparisons') }} <i class="fas fa-arrow-right ms-1"></i>
				</a>
			</div>
		</div>
	</div>



	<!-- Service we provide -->
	<div class="px-240 provide-sec position-relative">
		<div>
			<p class="pt-149 color-FE gilroy-medium f-18 leading-24 text-center mb-0">{{ __('FINANCIAL INFRASTRUCTURE') }}</p>
			<p class="color-05B gilroy-Semibold f-34 text-center mb-23 mt-7" data-content="REASONS">{{ __('SERVICES WE PROVIDE') }}</p>
			<p class="small-border mb-0 bgd-blue m-auto"></p>
		</div>
		<div class="pb-137">
			<div class="row mt-72">
				<!-- Service 1: Multi-Currency E-Wallet -->
				<div class="col-md-6 col-xl-4 px-16">
					<a href="{{ auth()->check() ? route('user.wallets.index') : url('register') }}" class="p-48-44 h-355 mb-32 gray-shad text-decoration-none d-flex flex-column justify-content-between">
						<div>
							<div>
								<img class="online-shop" src="{{ asset('public/frontend/templates/images/home/online-shop.png') }}" alt="{{ __('Multi-Currency Wallet') }}">
							</div>
							<p class="mb-0 color-5B gilroy-Semibold f-24 leading-32 f-r16 mt-28">{{ __('Multi-Currency Wallet') }}</p>
							<p class="mb-0 mt-21 color-5B f-18 leading-30 gilroy-light">
								{{ __('Hold, exchange, and manage balances in 20+ fiat currencies and cryptos. Instant zero-fee peer-to-peer transfers via email or mobile phone.') }} 						
							</p>
						</div>
						<div class="pt-3">
							<span class="text-primary gilroy-medium f-14">{{ auth()->check() ? __('Manage Wallets') : __('Open Free Wallet') }} <i class="fas fa-arrow-right ms-1"></i></span>
						</div>
					</a>
				</div>

				<!-- Service 2: Merchant Payment Gateway -->
				<div class="col-md-6 col-xl-4 px-16">
					<a href="{{ auth()->check() ? route('user.merchants.index') : url('register') }}" class="p-48-44 h-355 mb-32 gray-shad text-decoration-none d-flex flex-column justify-content-between">
						<div>
							<div>
								<img class="checkout-img" src="{{ asset('public/frontend/templates/images/home/checkout.png') }}" alt="{{ __('Payment Gateway') }}">
							</div>
							<p class="mb-0 color-5B gilroy-Semibold f-24 leading-32 f-r16 mt-28">{{ __('Merchant Gateway & Checkout') }}</p>
							<p class="mb-0 mt-21 color-5B f-18 leading-30 gilroy-light">
								{{ __('Accept credit cards, e-wallets, and alternative payment methods with Standard & Express Checkout, WooCommerce plugins, and webhooks.') }}
							</p>
						</div>
						<div class="pt-3">
							<span class="text-primary gilroy-medium f-14">{{ auth()->check() ? __('Manage Merchant Gateway') : __('Get Merchant Account') }} <i class="fas fa-arrow-right ms-1"></i></span>
						</div>
					</a>
				</div>

				<!-- Service 3: Crypto Payment & Nodes -->
				<div class="col-md-6 col-xl-4 px-16">
					<a href="{{ auth()->check() ? route('user.exchange_money.create') : url('register') }}" class="p-48-44 h-355 mb-32 gray-shad text-decoration-none d-flex flex-column justify-content-between">
						<div>
							<div>
								<img class="cryptocurrency-img" src="{{ asset('public/frontend/templates/images/home/cryptocurrency.png') }}" alt="{{ __('Crypto Payments') }}">
							</div>
							<p class="mb-0 color-5B gilroy-Semibold f-24 leading-32 f-r16 mt-28">{{ __('Crypto Payments & Tatum Nodes') }}</p>
							<p class="mb-0 mt-21 color-5B f-18 leading-30 gilroy-light">
								{{ __('Accept, send, and swap Bitcoin, Ethereum, USDT (TRC-20 & ERC-20), and Dogecoin with automatic address generation and instant settlement.') }}
							</p>
						</div>
						<div class="pt-3">
							<span class="text-primary gilroy-medium f-14">{{ auth()->check() ? __('Exchange Crypto') : __('Get Started With Crypto') }} <i class="fas fa-arrow-right ms-1"></i></span>
						</div>
					</a>
				</div>

				<!-- Service 4: Virtual Debit Cards -->
				<div class="col-md-6 col-xl-4 px-16">
					<a href="{{ auth()->check() ? route('user.virtualcard.create') : url('register') }}" class="p-48-44 h-355 mb-32 gray-shad text-decoration-none d-flex flex-column justify-content-between">
						<div>
							<div>
								<img class="clerk-img" src="{{ asset('public/frontend/templates/images/home/clerk.png') }}" alt="{{ __('Virtual Cards') }}">
							</div>
							<p class="mb-0 color-5B gilroy-Semibold f-24 leading-32 f-r16 mt-28">{{ __('Virtual Debit Cards') }}</p>
							<p class="mb-0 mt-21 color-5B f-18 leading-30 gilroy-light">
								{{ __('Generate instant prepaid virtual cards for secure online shopping, SaaS subscriptions, and digital marketing ad spend directly from your balance.') }}
							</p>
						</div>
						<div class="pt-3">
							<span class="text-primary gilroy-medium f-14">{{ auth()->check() ? __('Manage Virtual Cards') : __('Issue Virtual Card') }} <i class="fas fa-arrow-right ms-1"></i></span>
						</div>
					</a>
				</div>

				<!-- Service 5: Fast Deposits & Bank Payouts -->
				<div class="col-md-6 col-xl-4 px-16">
					<a href="{{ auth()->check() ? route('user.deposit.create') : url('register') }}" class="p-48-44 h-355 mb-32 gray-shad text-decoration-none d-flex flex-column justify-content-between">
						<div>
							<div>
								<img class="online-shop" src="{{ asset('public/frontend/templates/images/home/booking.png') }}" alt="{{ __('Deposits & Payouts') }}">
							</div>
							<p class="mb-0 color-5B gilroy-Semibold f-24 leading-32 f-r16 mt-28">{{ __('Deposits & Global Payouts') }}</p>
							<p class="mb-0 mt-21 color-5B f-18 leading-30 gilroy-light">
								{{ __('Fund via Credit Cards, PayPal, Stripe, or Bank Wire. Withdraw merchant revenues directly to linked bank accounts with transparent tracking.') }}
							</p>
						</div>
						<div class="pt-3">
							<span class="text-primary gilroy-medium f-14">{{ auth()->check() ? __('Deposit Funds') : __('Start Depositing') }} <i class="fas fa-arrow-right ms-1"></i></span>
						</div>
					</a>
				</div>

				<!-- Service 6: Contactless QR Code Pay -->
				<div class="col-md-6 col-xl-4 px-16">
					<a href="{{ auth()->check() ? route('user.profiles.index') : url('register') }}" class="p-48-44 h-355 mb-32 gray-shad text-decoration-none d-flex flex-column justify-content-between">
						<div>
							<div>
								<img class="online-shop" src="{{ asset('public/frontend/templates/images/home/party.png') }}" alt="{{ __('QR Code Payments') }}">
							</div>
							<p class="mb-0 color-5B gilroy-Semibold f-24 leading-32 f-r16 mt-28">{{ __('Contactless QR Code Pay') }}</p>
							<p class="mb-0 mt-21 color-5B f-18 leading-30 gilroy-light">
								{{ __('Turn any device into an in-person point of sale terminal. Generate dynamic and static QR codes for instant contactless buyer checkout.') }}
							</p>
						</div>
						<div class="pt-3">
							<span class="text-primary gilroy-medium f-14">{{ auth()->check() ? __('View My QR Code') : __('Get Started With QR') }} <i class="fas fa-arrow-right ms-1"></i></span>
						</div>
					</a>
				</div>
			</div>

			<div class="text-center mt-3">
				<a href="{{ url('services') }}" class="btn btn-outline-primary px-4 py-2 rounded-pill gilroy-medium">
					{{ __('View Full Services Catalog') }} <i class="fas fa-arrow-right ms-1"></i>
				</a>
			</div>
		</div>
	</div>

	<!-- how does it work section -->
	<div class="px-240 provide-sec position-relative">
		<div class="mt-n24">
			<p class="color-FE gilroy-medium f-18 leading-24 text-center mb-0">{{ __('THE PROCESS') }}</p>
			<p class="color-05B gilroy-Semibold f-34 text-center mb-23 mt-7" data-content="REASONS">{{ __('HOW DOES IT WORK?') }}</p>
			<p class="small-border mb-0 bgd-blue m-auto"></p>
		</div>
		<div class="pb-137">
			<div class="row g-4 mt-5">
				<!-- Step 1 -->
				<div class="col-md-6 col-xl-3">
					<div class="p-4 bg-white rounded-4 border shadow-sm h-100 d-flex flex-column justify-content-between">
						<div>
							<div class="d-flex align-items-center justify-content-between mb-4">
								<svg width="68" height="68" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
									<circle cx="48" cy="48" r="48" fill="#F2EFFC"/>
									<path d="M52.3086 61H47.7188V42.5625C47.7188 40.362 47.7708 38.6172 47.875 37.3281C47.5755 37.6406 47.2044 37.9857 46.7617 38.3633C46.332 38.7409 44.8737 39.9388 42.3867 41.957L40.082 39.0469L48.4805 32.4453H52.3086V61Z" fill="#635BFF"/>
								</svg>
								<span class="badge bg-light text-primary border f-12 px-3 py-1 rounded-pill gilroy-medium">{{ __('Step 01') }}</span>
							</div>
							<h4 class="color-05B gilroy-Semibold f-20 mb-2">{{ __('Create Account') }}</h4>
							<p class="color-5B text-muted f-15 leading-24 gilroy-regular mb-0">
								{{ __('Provide your credentials, verify your details and set up your secure digital wallet in under 2 minutes.') }}
							</p>
						</div>
					</div>
				</div>

				<!-- Step 2 -->
				<div class="col-md-6 col-xl-3">
					<div class="p-4 bg-white rounded-4 border shadow-sm h-100 d-flex flex-column justify-content-between">
						<div>
							<div class="d-flex align-items-center justify-content-between mb-4">
								<svg width="68" height="68" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
									<circle cx="48" cy="48" r="48" fill="#F2EFFC"/>
									<path d="M57.1875 61H37.832V57.5234L45.1953 50.1211C47.3698 47.8945 48.8086 46.319 49.5117 45.3945C50.2279 44.457 50.7487 43.5781 51.0742 42.7578C51.3997 41.9375 51.5625 41.0586 51.5625 40.1211C51.5625 38.832 51.1719 37.8164 50.3906 37.0742C49.6224 36.332 48.5547 35.9609 47.1875 35.9609C46.0938 35.9609 45.0326 36.1628 44.0039 36.5664C42.9883 36.9701 41.8099 37.6992 40.4688 38.7539L37.9883 35.7266C39.5768 34.3854 41.1198 33.4349 42.6172 32.875C44.1146 32.3151 45.7096 32.0352 47.4023 32.0352C50.0586 32.0352 52.1875 32.7318 53.7891 34.125C55.3906 35.5052 56.1914 37.3672 56.1914 39.7109C56.1914 41 55.957 42.224 55.4883 43.3828C55.0326 44.5417 54.3229 45.7396 53.3594 46.9766C52.4089 48.2005 50.8203 49.8607 48.5938 51.957L43.6328 56.7617V56.957H57.1875V61Z" fill="#635BFF"/>
								</svg>
								<span class="badge bg-light text-primary border f-12 px-3 py-1 rounded-pill gilroy-medium">{{ __('Step 02') }}</span>
							</div>
							<h4 class="color-05B gilroy-Semibold f-20 mb-2">{{ __('Send or Request') }}</h4>
							<p class="color-5B text-muted f-15 leading-24 gilroy-regular mb-0">
								{{ __('Send or request funds instantly using phone numbers, email addresses, or smart QR codes across currencies.') }}
							</p>
						</div>
					</div>
				</div>

				<!-- Step 3 -->
				<div class="col-md-6 col-xl-3">
					<div class="p-4 bg-white rounded-4 border shadow-sm h-100 d-flex flex-column justify-content-between">
						<div>
							<div class="d-flex align-items-center justify-content-between mb-4">
								<svg width="68" height="68" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
									<circle cx="48" cy="48" r="48" fill="#F2EFFC"/>
									<path d="M57.1133 40.0078C57.1133 41.8177 56.5859 43.3281 55.5312 44.5391C54.4766 45.737 52.9922 46.5443 51.0781 46.9609V47.1172C53.3698 47.4036 55.0885 48.1198 56.2344 49.2656C57.3802 50.3984 57.9531 51.9089 57.9531 53.7969C57.9531 56.5443 56.9831 58.6667 55.043 60.1641C53.1029 61.6484 50.3424 62.3906 46.7617 62.3906C43.5977 62.3906 40.9284 61.8763 38.7539 60.8477V56.7656C39.9648 57.3646 41.2474 57.8268 42.6016 58.1523C43.9557 58.4779 45.2578 58.6406 46.5078 58.6406C48.7214 58.6406 50.375 58.2305 51.4688 57.4102C52.5625 56.5898 53.1094 55.3203 53.1094 53.6016C53.1094 52.0781 52.5039 50.9583 51.293 50.2422C50.082 49.526 48.181 49.168 45.5898 49.168H43.1094V45.4375H45.6289C50.1862 45.4375 52.4648 43.862 52.4648 40.7109C52.4648 39.487 52.0677 38.543 51.2734 37.8789C50.4792 37.2148 49.3073 36.8828 47.7578 36.8828C46.6771 36.8828 45.6354 37.0391 44.6328 37.3516C43.6302 37.651 42.4453 38.2435 41.0781 39.1289L38.832 35.9258C41.4492 33.9987 44.4896 33.0352 47.9531 33.0352C50.8307 33.0352 53.0768 33.6536 54.6914 34.8906C56.306 36.1276 57.1133 37.8333 57.1133 40.0078Z" fill="#635BFF"/>
								</svg>
								<span class="badge bg-light text-primary border f-12 px-3 py-1 rounded-pill gilroy-medium">{{ __('Step 03') }}</span>
							</div>
							<h4 class="color-05B gilroy-Semibold f-20 mb-2">{{ __('Select Payment Method') }}</h4>
							<p class="color-5B text-muted f-15 leading-24 gilroy-regular mb-0">
								{{ __('Choose from credit cards, bank wire, PayPal, Stripe, local deposit agents, or top cryptocurrencies.') }}
							</p>
						</div>
					</div>
				</div>

				<!-- Step 4 -->
				<div class="col-md-6 col-xl-3">
					<div class="p-4 bg-white rounded-4 border shadow-sm h-100 d-flex flex-column justify-content-between">
						<div>
							<div class="d-flex align-items-center justify-content-between mb-4">
								<svg width="68" height="68" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
									<circle cx="48" cy="48" r="48" fill="#F2EFFC"/>
									<path d="M59.2031 54.7695H55.3555V61H50.8828V54.7695H37.8359V51.2344L50.8828 32.3672H55.3555V50.9609H59.2031V54.7695ZM50.8828 50.9609V43.793C50.8828 41.2409 50.9479 39.151 51.0781 37.5234H50.9219C50.5573 38.3828 49.9844 39.4245 49.2031 40.6484L42.1133 50.9609H50.8828Z" fill="#635BFF"/>
								</svg>
								<span class="badge bg-light text-primary border f-12 px-3 py-1 rounded-pill gilroy-medium">{{ __('Step 04') }}</span>
							</div>
							<h4 class="color-05B gilroy-Semibold f-20 mb-2">{{ __('Instant Confirmation') }}</h4>
							<p class="color-5B text-muted f-15 leading-24 gilroy-regular mb-0">
								{{ __('Confirm with 2FA or biometric verification. Your transaction settles immediately with full audit receipts.') }}
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Unified Crypto Exchange & Digital Assets Section -->
	<div class="px-240 crypto-showcase-section position-relative py-5">
		<div class="row align-items-center g-5">
			<div class="col-lg-6 mb-4 mb-lg-0">
				<div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(99, 91, 254, 0.08); color: #635BFE; font-weight: 700; font-size: 13px;">
					<i class="fab fa-bitcoin"></i> {{ __('INSTANT & SECURE CRYPTO RAILS') }}
				</div>
				<h2 class="mb-3 color-05B gilroy-Semibold f-36 leading-44">
					{{ __('Currency Exchange & Digital Assets') }}
				</h2>

				<p class="small-border mb-3 bgd-blue"></p>

				<p class="mt-3 gilroy-regular f-16 color-5B leading-26">
					{{ __(':x bridges fiat and digital assets. Buy, sell, convert, and securely hold major cryptocurrencies and custom tokens with institutional Tatum blockchain nodes, live market pricing, and multi-signature security.', ['x' => settings('name')]) }}
				</p>

				<!-- Supported Cryptocurrencies Grid -->
				<div class="my-4 p-3 bg-light rounded-4 border">
					<div class="d-flex align-items-center justify-content-between mb-3 px-2">
						<span class="f-13 gilroy-Semibold text-muted text-uppercase">{{ __('Supported Networks & Currencies') }}</span>
						<span class="badge bg-success-subtle text-success border border-success f-11 px-2 py-1 rounded-pill">{{ __('Live Tatum Node') }}</span>
					</div>
					<div class="row g-2 text-center" id="cryptoCoinsShowcaseRow">
						<div class="col-6 col-sm-3">
							<div class="crypto-coin-chip shadow-xs cursor-pointer" data-coin="BTC" role="button" title="{{ __('Select Bitcoin') }}">
								<div class="coin-svg-wrapper">
									{!! svgIcons('bitcoin') !!}
								</div>
								<span>BTC</span>
							</div>
						</div>
						<div class="col-6 col-sm-3">
							<div class="crypto-coin-chip shadow-xs cursor-pointer" data-coin="ETH" role="button" title="{{ __('Select Ethereum') }}">
								<div class="coin-svg-wrapper">
									{!! svgIcons('ethereum') !!}
								</div>
								<span>ETH</span>
							</div>
						</div>
						<div class="col-6 col-sm-3">
							<div class="crypto-coin-chip shadow-xs cursor-pointer" data-coin="USDT" role="button" title="{{ __('Select Tether USDT') }}">
								<div class="coin-svg-wrapper">
									{!! svgIcons('tether') !!}
								</div>
								<span>USDT</span>
							</div>
						</div>
						<div class="col-6 col-sm-3">
							<div class="crypto-coin-chip shadow-xs cursor-pointer" data-coin="LTC" role="button" title="{{ __('Select Litecoin') }}">
								<div class="coin-svg-wrapper">
									{!! svgIcons('litcoin') !!}
								</div>
								<span>LTC</span>
							</div>
						</div>
						<div class="col-6 col-sm-3">
							<div class="crypto-coin-chip shadow-xs cursor-pointer" data-coin="TRX" role="button" title="{{ __('Select TRON') }}">
								<div class="coin-svg-wrapper">
									{!! svgIcons('tron') !!}
								</div>
								<span>TRX</span>
							</div>
						</div>
						<div class="col-6 col-sm-3">
							<div class="crypto-coin-chip shadow-xs cursor-pointer" data-coin="DOGE" role="button" title="{{ __('Select Dogecoin') }}">
								<div class="coin-svg-wrapper">
									{!! svgIcons('doge') !!}
								</div>
								<span>DOGE</span>
							</div>
						</div>
						<div class="col-6 col-sm-3">
							<div class="crypto-coin-chip shadow-xs cursor-pointer" data-coin="USDT" role="button" title="{{ __('Select TRC-20 USDT') }}">
								<div class="coin-svg-wrapper">
									{!! svgIcons('trc-20') !!}
								</div>
								<span>TRC-20</span>
							</div>
						</div>
						<div class="col-6 col-sm-3">
							<div class="crypto-coin-chip shadow-xs cursor-pointer" data-coin="ETH" role="button" title="{{ __('Select Custom Token') }}">
								<div class="coin-svg-wrapper">
									{!! svgIcons('custom-token') !!}
								</div>
								<span>Token</span>
							</div>
						</div>
					</div>
				</div>

				<!-- Dynamic Live FX & Crypto Converter Widget -->
				<div class="p-3 rounded-4 bg-white border shadow-xs mb-3 live-fx-calc-box">
					<div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-1">
						<span class="f-12 gilroy-Semibold text-muted text-uppercase d-flex align-items-center gap-1">
							<i class="fas fa-calculator text-primary"></i> {{ __('Live Exchange Estimator') }}
						</span>
						<span class="badge bg-light text-primary border f-11 px-2 py-0.5 rounded-pill" id="liveFxRateBadge">1 BTC &approx; $64,250.00 USD</span>
					</div>
					<div class="row g-2 align-items-center">
						<div class="col-12 col-sm-5">
							<div class="input-group input-group-sm">
								<input type="number" class="form-control form-control-sm f-14 fw-bold" id="liveFxAmount" value="1000" min="0.00001" step="any" placeholder="{{ __('Amount') }}">
								<select class="form-select form-select-sm f-12 fw-semibold" id="liveFxFrom" style="max-width: 90px;">
									<option value="USD" selected>USD</option>
									<option value="EUR">EUR</option>
									<option value="GBP">GBP</option>
									<option value="BTC">BTC</option>
									<option value="ETH">ETH</option>
									<option value="USDT">USDT</option>
									<option value="TRX">TRX</option>
									<option value="LTC">LTC</option>
									<option value="DOGE">DOGE</option>
								</select>
							</div>
						</div>
						<div class="col-12 col-sm-2 text-center py-1 py-sm-0">
							<button type="button" class="btn btn-sm btn-light border rounded-circle p-1" id="liveFxSwapBtn" title="{{ __('Swap currencies') }}" style="width: 32px; height: 32px;">
								<i class="fas fa-exchange-alt f-11 text-primary"></i>
							</button>
						</div>
						<div class="col-12 col-sm-5">
							<div class="input-group input-group-sm">
								<input type="text" class="form-control form-control-sm f-14 fw-bold bg-light" id="liveFxResult" readonly value="0.01556">
								<select class="form-select form-select-sm f-12 fw-semibold" id="liveFxTo" style="max-width: 90px;">
									<option value="BTC" selected>BTC</option>
									<option value="USDT">USDT</option>
									<option value="ETH">ETH</option>
									<option value="USD">USD</option>
									<option value="EUR">EUR</option>
									<option value="GBP">GBP</option>
									<option value="TRX">TRX</option>
									<option value="LTC">LTC</option>
									<option value="DOGE">DOGE</option>
								</select>
							</div>
						</div>
					</div>
					<div class="d-flex justify-content-between align-items-center mt-2 pt-1 text-muted f-11 border-top">
						<span><i class="fas fa-bolt text-warning me-1"></i> {{ __('Zero Slippage Guarantee') }}</span>
						<span class="text-success"><i class="fas fa-check-circle me-1"></i> {{ __('Real-Time Market Rate') }}</span>
					</div>
				</div>

				<div class="d-flex flex-wrap gap-3 align-items-center mt-4">
					<a href="{{ auth()->check() ? route('user.exchange_money.create') : url('register') }}" class="btn btn-primary rounded-pill px-4 py-2 font-weight-bold d-inline-flex align-items-center gap-2">
						<span>{{ __('Exchange Currency Now') }}</span>
						<svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M0 4.57143C0 4.25584 0.255837 4 0.571429 4L15.4286 4C15.7442 4 16 4.25584 16 4.57143C16 4.88702 15.7442 5.14286 15.4286 5.14286L0.571429 5.14286C0.255837 5.14286 0 4.88702 0 4.57143Z" fill="currentColor"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M11.0243 0.167368C11.2475 -0.0557892 11.6093 -0.0557892 11.8324 0.167368L15.8324 4.16737C16.0556 4.39052 16.0556 4.75233 15.8324 4.97549L11.8324 8.97549C11.6093 9.19865 11.2475 9.19865 11.0243 8.97549C10.8011 8.75233 10.8011 8.39052 11.0243 8.16737L14.6202 4.57143L11.0243 0.97549C10.8011 0.752333 10.8011 0.390524 11.0243 0.167368Z" fill="currentColor"/>
						</svg>					
					</a>
					<button type="button" class="btn btn-outline-primary d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill font-weight-bold" data-bs-toggle="modal" data-bs-target="#cryptoVideoModal">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
						<span>{{ __('Watch Video Demo') }}</span>
					</button>
				</div>
			</div>

			<div class="col-lg-6 position-relative">
				<div class="video-preview-wrapper cursor-pointer shadow-lg rounded-4 overflow-hidden border position-relative" data-bs-toggle="modal" data-bs-target="#cryptoVideoModal" role="button" tabindex="0" title="{{ __('Click to watch video demo') }}">
					<img class="custom-z w-100 h-auto" src="{{ asset('public/frontend/templates/images/home/rectangle.png') }}" alt="{{ __('Watch Crypto Exchange Demo') }}">
					
					<!-- Live Floating Tech Badges -->
					<div class="position-absolute top-0 start-0 m-3 px-3 py-1 rounded-pill bg-dark bg-opacity-75 text-white f-12 gilroy-medium shadow-sm d-flex align-items-center gap-2">
						<span class="status-pulse d-inline-block"></span>
						<span>{{ __('Tatum Node Live') }}</span>
					</div>
					<div class="position-absolute top-0 end-0 m-3 px-3 py-1 rounded-pill bg-primary bg-opacity-90 text-white f-12 gilroy-medium shadow-sm">
						<i class="fas fa-shield-alt me-1"></i> {{ __('Multi-Sig Vault') }}
					</div>

					<div class="video-play-overlay">
						<div class="play-pulse-circle">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="#ffffff">
								<path d="M8 5v14l11-7z"/>
							</svg>
						</div>
						<span class="video-badge-pill">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="me-1"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
							{{ __('Watch Product Walkthrough') }}
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Faq section -->
	<div class="third-section pt-121 position-relative">
		<div class="container-fluid px3-460p row-heads position-relative">
			<div class="mt-n24">
				<p class="color-FE gilroy-medium f-18 leading-24 text-center mb-0">{{ __('WE GOT YOU COVERED') }}</p>
				<p class="color-05B gilroy-Semibold f-34 text-center mb-23 mt-7" data-content="REASONS">{{ __('FREQUENTLY ASKED QUESTIONS') }}</p>
				<p class="small-border mb-0 bgd-blue m-auto"></p>
			</div>

			<div class="row mt-55">
				<div class="col-md-12 p-0-res">
					<div id="main">
						<div class="container contain">
							<div class="accordion" id="faq">
								<div class="accordion-item">
									<div class="accordion-header" id="faqhead1">
										<a class="btn btn-header-link f-20 color-B87 gilroy-medium collapsed" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="false" aria-controls="faq1">
											{{ __('How secure and reliable is :x?', ['x' => settings('name')]) }}
										</a>
									</div>

									<div id="faq1" class="accordion-collapse collapse" aria-labelledby="faqhead1" data-bs-parent="#faq">
										<div class="accordion-body gilroy-light color-05B">
											{{ __(':x is built with bank-grade 256-bit encryption, strict two-factor authentication (2FA), automated anti-fraud monitoring, and secure custodial vaults to ensure your funds and personal information remain completely protected.', ['x' => settings('name')]) }}
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<div class="accordion-header" id="faqhead2">
										<a class="btn btn-header-link f-20 color-B87 gilroy-medium collapsed" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
											{{ __('How does money transfer and exchange work?') }}
										</a>
									</div>

									<div id="faq2" class="accordion-collapse collapse" aria-labelledby="faqhead2" data-bs-parent="#faq">
										<div class="accordion-body gilroy-light color-05B">
											{{ __('Sending money or exchanging currencies takes just seconds. Simply select your destination currency or recipient, enter the amount, and confirm. Funds are instantly credited with transparent live rates and low transaction fees.') }}
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<div class="accordion-header" id="faqhead3">
										<a class="btn btn-header-link f-20 color-B87 gilroy-medium collapsed" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
											{{ __('How fast are transactions and crypto deposits processed?') }}
										</a>
									</div>

									<div id="faq3" class="accordion-collapse collapse" aria-labelledby="faqhead3" data-bs-parent="#faq">
										<div class="accordion-body gilroy-light color-05B">
											{{ __('Internal wallet transfers and crypto deposits are confirmed instantly. For standard bank deposits and withdrawals, transactions typically complete within minutes to 1 business day depending on your local banking network.') }}
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<div class="accordion-header" id="faqhead4">
										<a class="btn btn-header-link f-20 color-B87 gilroy-medium collapsed" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
											{{ __('How can I track or manage my transactions?') }}
										</a>
									</div>

									<div id="faq4" class="accordion-collapse collapse" aria-labelledby="faqhead4" data-bs-parent="#faq">
										<div class="accordion-body gilroy-light color-05B">
											{{ __('You can monitor real-time transaction statuses, download downloadable invoices, and track your wallet balances directly from your user dashboard. You also receive instant email notifications for every transaction.') }}
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<div class="accordion-header" id="faqhead5">
										<a class="btn btn-header-link f-20 color-B87 gilroy-medium collapsed" data-bs-toggle="collapse" data-bs-target="#faq5" aria-expanded="false" aria-controls="faq5">
											{{ __('What fees are charged during currency conversion and withdrawals?') }}
										</a>
									</div>

									<div id="faq5" class="accordion-collapse collapse" aria-labelledby="faqhead5" data-bs-parent="#faq">
										<div class="accordion-body gilroy-light color-05B">
											{{ __('We believe in 100% pricing transparency. There are zero hidden fees, and all applicable processing or exchange rates are clearly displayed upfront before you review and confirm any transaction.') }}
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<div class="accordion-header" id="faqhead6">
										<a class="btn btn-header-link f-20 color-B87 gilroy-medium collapsed" data-bs-toggle="collapse" data-bs-target="#faq6" aria-expanded="false" aria-controls="faq6">
											{{ __('How do I verify my account and increase limits?') }}
										</a>
									</div>

									<div id="faq6" class="accordion-collapse collapse" aria-labelledby="faqhead6" data-bs-parent="#faq">
										<div class="accordion-body gilroy-light color-05B">
											{{ __('Verification is quick and straightforward. Simply upload a valid government-issued ID and address proof in your profile settings. Once approved by our compliance team, your account limits will be upgraded immediately.') }}
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>



	<!-- Download the app section -->
	<div class="pt-86 dark-app pb-144 position-relative">
		<div class="px-240 position-relative">
			<div class="bg-app overflow-hidden rounded-4">
				<div class="row align-items-center g-4 p-4 p-lg-5">
					<div class="col-md-6 order-last order-md-first text-center pay-img">
						<img class="img-fluid app-mockup-img" src="{{ asset('public/frontend/templates/images/home/app-img.png') }}" alt="{{ __('Mobile App Preview') }}" style="max-height: 440px; width: auto; object-fit: contain;">
					</div>
					<div class="col-md-6 order-first order-md-last">
						<div class="app-text-content text-center text-md-start">
							<div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(99, 91, 254, 0.12); color: #635BFE; font-weight: 700; font-size: 13px;">
								<i class="fas fa-mobile-alt"></i> {{ __('DOWNLOAD THE APP') }}
							</div>
							<h2 class="color-05B gilroy-Semibold f-34 mb-2 app-content" data-content="REASONS">
								{{ __('Fast, Secure Payments on Mobile') }}
							</h2>
							<p class="small-border mb-3 bgd-blue mx-auto mx-md-0"></p>
							<p class="gilroy-regular color-5B f-16 leading-26 mb-4">
								{{ __('Manage multi-currency balances, transfer money, exchange currencies, and track live payouts instantly from your smartphone.') }}
							</p>
							<div class="d-flex flex-wrap gap-3 justify-content-center justify-content-md-start app-sec">
								@foreach(getAppStoreLinkFrontEnd() as $app)
									@php
										$logoPath = !empty($app->logo) && file_exists(public_path('uploads/app-store-logos/thumb/' . $app->logo))
											? asset('public/uploads/app-store-logos/thumb/' . $app->logo)
											: ($app->company == 'Apple' 
												? asset('public/frontend/templates/images/home/ios.svg') 
												: asset('public/frontend/templates/images/home/playstore.svg'));
									@endphp
									<a href="{{ $app->link }}" target="_blank" class="app-store-btn" title="{{ $app->company }}">
										<img class="cursor-pointer app-image" src="{{ $logoPath }}" alt="{{ $app->company }}">
									</a>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Crypto Video Modal -->
	<div class="modal fade" id="cryptoVideoModal" tabindex="-1" aria-labelledby="cryptoVideoModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg" style="background-color: #0f172a;">
				<div class="modal-header border-0 pb-0 pt-3 px-4">
					<h5 class="modal-title text-white f-18 gilroy-Semibold d-flex align-items-center gap-2" id="cryptoVideoModalLabel">
						<span class="badge bg-primary px-2 py-1">{{ __('Demo') }}</span>
						{{ __(':x Crypto Exchange & Node Walkthrough', ['x' => settings('name')]) }}
					</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body p-3 p-md-4">
					<div class="ratio ratio-16x9 rounded-3 overflow-hidden shadow" style="background-color: #000;">
						<iframe id="cryptoDemoVideo" src="https://www.youtube-nocookie.com/embed/1YyAzVmP9xQ?enablejsapi=1&rel=0" title="{{ __('Crypto Platform Demo') }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
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

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			// Video modal
			var videoModal = document.getElementById('cryptoVideoModal');
			if (videoModal) {
				var iframe = document.getElementById('cryptoDemoVideo');
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

			// Dynamic Live FX & Crypto Calculator
			var fxRates = {
				USD: 1,
				EUR: 1.082,
				GBP: 1.285,
				BTC: 64250.00,
				ETH: 3450.00,
				USDT: 1.00,
				LTC: 85.50,
				TRX: 0.124,
				DOGE: 0.138
			};

			function calculateLiveFx() {
				var amountInput = document.getElementById('liveFxAmount');
				var fromSelect = document.getElementById('liveFxFrom');
				var toSelect = document.getElementById('liveFxTo');
				var resultInput = document.getElementById('liveFxResult');
				var badge = document.getElementById('liveFxRateBadge');

				if (!amountInput || !fromSelect || !toSelect || !resultInput) return;

				var amount = parseFloat(amountInput.value) || 0;
				var from = fromSelect.value;
				var to = toSelect.value;

				var rateFrom = fxRates[from] || 1;
				var rateTo = fxRates[to] || 1;

				var valInUSD = amount * rateFrom;
				var result = rateTo > 0 ? (valInUSD / rateTo) : 0;

				var decimals = (to === 'BTC' || to === 'ETH') ? 6 : (to === 'USD' || to === 'EUR' || to === 'GBP' ? 2 : 4);
				resultInput.value = result.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: decimals });

				if (badge) {
					var singleTargetUSD = rateTo;
					badge.innerText = '1 ' + to + ' ≈ $' + singleTargetUSD.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: (rateTo < 1 ? 4 : 2) }) + ' USD';
				}
			}

			var fxAmt = document.getElementById('liveFxAmount');
			var fxFrom = document.getElementById('liveFxFrom');
			var fxTo = document.getElementById('liveFxTo');
			var fxSwap = document.getElementById('liveFxSwapBtn');

			if (fxAmt) fxAmt.addEventListener('input', calculateLiveFx);
			if (fxFrom) fxFrom.addEventListener('change', calculateLiveFx);
			if (fxTo) fxTo.addEventListener('change', calculateLiveFx);

			if (fxSwap) {
				fxSwap.addEventListener('click', function () {
					var temp = fxFrom.value;
					fxFrom.value = fxTo.value;
					fxTo.value = temp;
					calculateLiveFx();
				});
			}

			// Coin chips click interactivity
			var coinChips = document.querySelectorAll('#cryptoCoinsShowcaseRow .crypto-coin-chip');
			coinChips.forEach(function (chip) {
				chip.addEventListener('click', function () {
					coinChips.forEach(function (c) { c.classList.remove('active-coin-chip'); });
					this.classList.add('active-coin-chip');
					var coin = this.getAttribute('data-coin');
					if (coin && fxTo) {
						fxTo.value = coin;
						calculateLiveFx();
					}
				});
			});

			calculateLiveFx();
		});
	</script>
@endsection


