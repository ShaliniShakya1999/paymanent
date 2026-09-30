<!-- Footer section -->
<div class="footer-sec {{ request()->is('login') || request()->is('forget-password') || request()->is('register') || request()->is('register/store-personal-info') || request()->is('2fa') || request()->is('google2fa') || request()->is('password/resets/*') ? 'd-none' : '' }}">
	<div class="px-240">
		<div class="row footer-grid-row">
			<!-- Column 1: Brand & Security -->
			<div class="col-lg-4 col-md-6 col-12 footer-col-brand">
				<a class="footer-brand-wrap" href="{{ request()->path() != 'merchant/payment' ? url('/') : 'javascript:void(0)' }}">
					<img class="footer-logo" src="{{ image(settings('logo'), 'logo') }}" alt="{{ __('Brand Logo') }}">
				</a>

				<p class="footer-brand-desc">
					{{ __(':x, a secured online payment gateway that allows payment in multiple currencies easily, safely and securely.', ['x' => settings('name')]) }}
				</p>

				<div class="footer-trust-pills">
					<a href="{{ url('/benefits#security') }}" class="footer-trust-pill text-decoration-none" title="{{ __('View 256-Bit SSL Security Standards') }}">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
						{{ __('256-Bit SSL Encrypted') }}
					</a>
					<a href="{{ route('privacy_policy') }}#security-compliance" class="footer-trust-pill text-decoration-none" title="{{ __('View PCI-DSS Compliance & Protection') }}">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
						{{ __('PCI-DSS Compliant') }}
					</a>
				</div>
			</div>

			<!-- Column 2: Solutions -->
			<div class="col-lg-3 col-md-6 col-6 footer-col-links">
				<p class="footer-col-title">{{ __('Solutions') }}</p>
				<ul class="footer-nav-list links">
					<li><a href="{{ url('/services#wallet') }}">{{ __('Multi-Currency Wallet') }}</a></li>
					<li><a href="{{ url('/services#gateway') }}">{{ __('Merchant Gateway') }}</a></li>
					<li><a href="{{ url('/services#virtual-cards') }}">{{ __('Virtual Cards') }}</a></li>
					<li><a href="{{ url('/services#fx-exchange') }}">{{ __('Currency Exchange') }}</a></li>
					<li><a href="{{ url('/benefits#security') }}">{{ __('Security & Benefits') }}</a></li>
				</ul>
			</div>

			<!-- Column 3: Company & Quick Links -->
			<div class="col-lg-2 col-md-6 col-6 footer-col-links">
				<p class="footer-col-title">{{ __('Company') }}</p>
				<ul class="footer-nav-list links">
					<li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
					<li><a href="{{ url('/services') }}">{{ __('Services') }}</a></li>
					<li><a href="{{ url('/benefits') }}">{{ __('Benefits') }}</a></li>
					@if(!empty(getMenuContent('Footer')))
						@foreach(getMenuContent('Footer') as $footer_navbar)
							@if(!in_array(strtolower($footer_navbar->url), ['portfoilo', 'portfolio']) && !in_array(strtolower($footer_navbar->name), ['portfoilo', 'portfolio']))
								<li>
									<a href="{{ url($footer_navbar->url) }}">{{ $footer_navbar->name }}</a>
								</li>
							@endif
						@endforeach
					@endif
					<li><a href="{{ url('/developer') }}">{{ __('Developer API') }}</a></li>
					<li><a href="{{ route('privacy_policy') }}">{{ __('Privacy Policy') }}</a></li>
				</ul>
			</div>

			<!-- Column 4: App Download -->
			<div class="col-lg-3 col-md-6 col-12 footer-col-app">
				<p class="footer-col-title">{{ __('Download Our App') }}</p>
				<p class="footer-app-desc">
					{{ __('Manage your wallets, transfer money, and make instant payments directly from your mobile device.') }}
				</p>
				<div class="footer-app-badges">
					@foreach(getAppStoreLinkFrontEnd() as $app)
						@php
							$logoPath = !empty($app->logo) && file_exists(public_path('uploads/app-store-logos/thumb/' . $app->logo))
								? asset('public/uploads/app-store-logos/thumb/' . $app->logo)
								: ($app->company == 'Apple' 
									? asset('public/frontend/templates/images/home/appstorefooter.png') 
									: asset('public/frontend/templates/images/home/googleplay-footer.png'));
						@endphp
						<a href="{{ $app->link }}" target="_blank" class="footer-app-link">
							<img class="app-imgs" src="{{ $logoPath }}" alt="{{ $app->company }}">
						</a>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>

<div class="{{ request()->is('login') || request()->is('forget-password') || request()->is('register') || request()->is('register/store-personal-info') || request()->is('2fa') || request()->is('google2fa') || request()->is('password/resets/*') ? 'd-none' : '' }} bottom-footer">
	<div class="px-240">
		<div class="bottom-footer-inner">
			<div class="bottom-footer-left">
				<p class="mb-0 footer-copyright-text">
					{{ __('Copyright') }} &copy; {{ date('Y') }} <span class="footer-brand-name">{{ settings('name') }}</span>. {{ __('All Rights Reserved.') }}
				</p>
			</div>
			<div class="bottom-footer-right">
				<div class="footer-lang-wrap sp">
					<label for="lang" class="footer-lang-label">
						<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1 4-10z"></path></svg>
						<span class="lan">{{ __('Language') }} :</span>
					</label>
					<div class="form-group selectParent mb-0">
						<select class="select2 form-control footer-lang-select" data-minimum-results-for-search="Infinity" id="lang">
							@foreach (getLanguagesListAtFooterFrontEnd() as $lang)
								<option value='{{ $lang->short_name }}' {{ \Session::get('dflt_lang') == $lang->short_name ? 'selected' : '' }}>{{ $lang->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
