<!-- navbar -->
<div class="navigation-wrap bg-white start-header start-style {{ request()->is('login') || request()->is('forget-password') || request()->is('password/resets/*') || request()->is('register') || request()->is('register/store-personal-info') || request()->is('2fa') || request()->is('google2fa') ? 'd-none' : '' }}">
	<div class="nav-container-fluid">
		<nav class="navbar navbar-expand-lg navbar-light py-2">
			<a class="navbar-brand d-flex align-items-center" href="{{ request()->path() != 'merchant/payment' ? url('/') : 'javascript:void(0)' }}">
				<img src="{{ image(settings('logo'), 'logo') }}" alt="{{ settings('name') }}" class="navbar-logo-img">
			</a>	
			
			<button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<line x1="3" y1="12" x2="21" y2="12"></line>
					<line x1="3" y1="6" x2="21" y2="6"></line>
					<line x1="3" y1="18" x2="21" y2="18"></line>
				</svg>
			</button>
			
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<!-- Center: Spacious, Uncluttered Navigation Links -->
				<ul class="navbar-nav mx-auto py-3 py-lg-0 gilroy-medium align-items-lg-center">
					<li class="nav-item {{ isset( $menu ) && ( $menu == 'home' ) ? 'nav-active': '' }}">
						<a class="nav-link" href="{{ url('/') }}">{{ __('Home') }}</a>
					</li>

					<li class="nav-item {{ isset( $menu ) && ( $menu == 'services' ) ? 'nav-active': '' }}">
						<a class="nav-link" href="{{ url('services') }}">{{ __('Services') }}</a>
					</li>

					<li class="nav-item {{ isset( $menu ) && ( $menu == 'benefits' ) ? 'nav-active': '' }}">
						<a class="nav-link" href="{{ url('benefits') }}">{{ __('Benefits') }}</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="{{ url('services') }}#gateway">{{ __('For Business') }}</a>
					</li>

					<li class="nav-item {{ isset( $menu ) && ( $menu == 'privacy-policy' ) ? 'nav-active': '' }}">
						<a class="nav-link" href="{{ route('privacy_policy') }}">{{ __('Privacy Policy') }}</a>
					</li>

					@if(!empty(getMenuContent('Header')))
						@foreach(getMenuContent('Header') as $top_navbar)
							<li class="nav-item {{ isset( $menu ) && ( $menu == $top_navbar->url ) ? 'nav-active': '' }}">
								<a href="{{ url($top_navbar->url) }}" class="nav-link"> {{ $top_navbar->name }}</a>
							</li>
						@endforeach
					@endif
					
					<!-- Custom Addons Header Menu -->
					@if (count(getCustomAddonNames()) > 0)
						@foreach (getCustomAddonNames() as $addon)
							@if (isActive($addon) && view()->exists(strtolower($addon) . '::frontend.header'))
								@include(strtolower($addon) . '::frontend.header')
							@endif
						@endforeach
					@endif
					<!-- Custom Addons Header Menu End -->

					@php
						$menuModules = activeModulesMenu();
					@endphp

					@if ($menuModules->count() > 1)
						<li class="nav-item custom-dropdown menu-item position-md-relative">
							<a id="megaMenuId" href="#" class="desktop-item nav-link custom-link">
								{{ __('More') }}
								{!! megaMenuSvg('arrow-down') !!}
							</a>
							
							<!-- Mega Menu -->
							<div id="megaMenuChildId" class="mega-links py-3 mega-menu-width-2 sidebar-scrollbar">
								<button id="closeMegaMenuId" class="mega-close-btn d-block d-md-none">×</button>
								<div class="mega-scrollable-div row">
									@foreach ($menuModules as $moduleMenu)
										@if (!isset($moduleMenu->condition) || (isset($moduleMenu->condition) && $moduleMenu->condition))
											<div class="col-12 col-md-6 py-2">
												<a href="{{ !empty($moduleMenu->route) ? route($moduleMenu->route) : 'javascript:void(0)' }}" class="d-flex gap-2 justify-content-start align-items-start px-md-2">
													<span>
														{!! $moduleMenu->icon !!}
													</span>
													<span>
														<span class="d-flex gap-2 justify-content-start align-items-center">
															<span>{{ $moduleMenu->name }}</span>
															{!! megaMenuSvg('arrow-right') !!}
														</span>
														<p class="descriptions mb-0">
															{{ __($moduleMenu->description) }}
														</p>
													</span>
												</a>
											</div>
										@endif
									@endforeach
								</div>
							</div>
						</li>
					@endif
				</ul>

				<!-- Right: Dark Mode Toggle & Auth Buttons -->
				<div class="d-flex align-items-center gap-3 ms-lg-auto py-2 py-lg-0">
					<div class="theme-switch-wrapper">
						<div class="switch">
							<div id="switch" class="d-flex align-items-center justify-content-center cursor-pointer" title="{{ __('Toggle Dark/Light Mode') }}">
								<img src="{{ asset('public/frontend/templates/images/home/moon.png') }}" class="moon img-none" width="20px" alt="Dark Mode">
								<img src="{{ asset('public/frontend/templates/images/home/sun2.png') }}" class="img-none sun" width="20px" alt="Light Mode">
							</div>
						</div>
					</div>

					@guest
						<a href="{{ url('login') }}" class="btn-nav-signin">
							{{ __('Sign In') }}
						</a>

						<a href="{{ url('register') }}" class="btn-paytm-cyan text-white text-decoration-none">
							{{ __('Get Started') }}
						</a>
					@endguest

					@auth
						<a href="{{ url('dashboard') }}" class="btn-paytm-cyan text-white text-decoration-none">
							{{ __('Dashboard') }}
						</a>

						<a href="{{ url('logout') }}" class="btn-nav-signin">
							{{ __('Logout') }}
						</a>
					@endauth
				</div>
			</div>
		</nav>		
	</div>
</div>