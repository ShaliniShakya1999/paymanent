@extends('user.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('Modules/Virtualcard/Resources/assets/css/swiper.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Modules/Virtualcard/Resources/assets/css/virtual-card.min.css') }}">
@endpush
@section('content')
    @include('user.common.alert')
    @if (empty($verification) &&
            settings('kyc_mandatory') == 'Yes' &&
            (settings('kyc_required_for') === 'All' || settings('kyc_required_for') == auth()->user()->role_id))
        <div class="alert alert-danger text-center" role="alert">
            {!! __('You need to verify your account first. To verify your account please :x', [
                'x' => '<a href="' . route('user.kyc.verifications.initiate') . '">' . __('click here') . '</a>',
            ]) !!}
        </div>
    @endif
    <div class="d-flex justify-content-between dash-left-profile dash-profile-flex-wrap">
        <div class="dash-left-profile d-flex gap-14">
            <div class="dash-left-img">
                <img src="{{ image(auth()->user()->picture, 'profile') }}" alt="{{ __('Profile') }}" class="img-fluid">
            </div>
            <div class="qr-icon">
                <p class="mb-0 f-32 gilroy-Semibold text-dark"><span>{{ getColumnValue(auth()->user()) }}</span>
                    <a href="{{ route('user.profiles.index') }}" class="px-1">
                        <svg class="cursor-pointer" width="18" height="18" viewBox="0 0 18 18" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.8448 2.09484C12.759 1.18063 14.2412 1.18063 15.1554 2.09484C16.0696 3.00905 16.0696 4.49129 15.1554 5.4055L5.73337 14.8276C5.71852 14.8424 5.70381 14.8571 5.68921 14.8718C5.47363 15.0878 5.28355 15.2782 5.0544 15.4186C4.85309 15.542 4.63361 15.6329 4.40403 15.688C4.1427 15.7507 3.87364 15.7505 3.56847 15.7502C3.54781 15.7502 3.52698 15.7502 3.50598 15.7502H2.25008C1.83586 15.7502 1.50008 15.4144 1.50008 15.0002V13.7443C1.50008 13.7233 1.50006 13.7025 1.50004 13.6818C1.49975 13.3766 1.4995 13.1076 1.56224 12.8462C1.61736 12.6167 1.70827 12.3972 1.83164 12.1959C1.97206 11.9667 2.16249 11.7766 2.37848 11.5611C2.3931 11.5465 2.40784 11.5317 2.42269 11.5169L11.8448 2.09484ZM14.0948 3.1555C13.7663 2.82707 13.2339 2.82707 12.9054 3.1555L3.48335 12.5776C3.19868 12.8622 3.14619 12.9215 3.1106 12.9796C3.06948 13.0467 3.03917 13.1199 3.0208 13.1964C3.0049 13.2626 3.00008 13.3417 3.00008 13.7443V14.2502H3.50598C3.90857 14.2502 3.98762 14.2453 4.05386 14.2294C4.13039 14.2111 4.20354 14.1808 4.27065 14.1396C4.32873 14.1041 4.38804 14.0516 4.67271 13.7669L14.0948 4.34484C14.4232 4.01641 14.4232 3.48393 14.0948 3.1555ZM8.25006 15.0002C8.25006 14.586 8.58584 14.2502 9.00006 14.2502H15.7501C16.1643 14.2502 16.5001 14.586 16.5001 15.0002C16.5001 15.4144 16.1643 15.7502 15.7501 15.7502H9.00006C8.58584 15.7502 8.25006 15.4144 8.25006 15.0002Z"
                                fill="currentColor" />
                        </svg>
                    </a>
                </p>
                <p class="mb-0 f-16 leading-18 gilroy-medium text-gray-100 mt-1 dash-w-262">
                    {{ __('Welcome, here is a brief summary of your account.') }}</p>
            </div>
        </div>

        <div class="dash-right-profile d-flex align-items-end">
            <a href="{{ route('user.deposit.create') }}" class="btn btn-lg btn-primary w-160">
                <span class="mb-0 f-14 leading-20 gilroy-medium">{{ __('Deposit Money') }}</span>
                <svg class="ml-10" width="18" height="18" viewBox="0 0 18 18" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M12.75 12C13.1642 12 13.5 12.3358 13.5 12.75C13.5 13.1642 13.1642 13.5 12.75 13.5L5.25 13.5C4.83579 13.5 4.5 13.1642 4.5 12.75L4.5 5.25C4.5 4.83579 4.83579 4.5 5.25 4.5C5.66421 4.5 6 4.83579 6 5.25L6 10.9393L12.2197 4.71967C12.5126 4.42678 12.9874 4.42678 13.2803 4.71967C13.5732 5.01256 13.5732 5.48744 13.2803 5.78033L7.06066 12L12.75 12Z"
                        fill="currentColor" />
                </svg>
            </a>
            <a href="{{ route('user.withdrawal.create') }}"
                class="btn btn-lg btn-warning cursor-pointer ml-12 w-160 yellow-btn">
                <span class="mb-0 f-14 leading-20 gilroy-medium text-dark">{{ __('Withdraw Money') }}</span>
                <svg class="ml-10 nscaleX-1" width="18" height="18" viewBox="0 0 18 18" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M5.25 6C4.83579 6 4.5 5.66421 4.5 5.25C4.5 4.83579 4.83579 4.5 5.25 4.5L12.75 4.5C13.1642 4.5 13.5 4.83579 13.5 5.25L13.5 12.75C13.5 13.1642 13.1642 13.5 12.75 13.5C12.3358 13.5 12 13.1642 12 12.75V7.06066L5.78033 13.2803C5.48744 13.5732 5.01256 13.5732 4.71967 13.2803C4.42678 12.9874 4.42678 12.5126 4.71967 12.2197L10.9393 6L5.25 6Z"
                        fill="#3F405B" />
                </svg>
            </a>
        </div>
    </div>
    <div class="d-flex dasboard-wallet-card gap-20 flex-wrap mt-40">
        @if ($wallets->count() > 0)
            @foreach ($wallets as $wallet)
                <div class="dash-wallet-box bg-white">
                    <div class="d-flex justify-content-between">
                        <div class="dash-box-one">
                            <p class="mb-0 gilroy-Semibold text-primary f-16 leading-20">{{ $wallet->currency?->code }}</p>
                            <p class="mb-0 f-12 leading-15 text-gray-100 gilroy-regular mt-1">
                                {{ ucwords(str_replace('_', ' ', $wallet->currency?->type)) }}</p>
                        </div>
                        <div class="dash-currency-sign d-flex justify-content-center align-items-center">
                            <img src="{{ image($wallet->currency?->logo, 'currency') }}" alt="{{ __('Currency') }}"
                                class="img-fluid">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-15">
                        <p class="mb-0 f-24 leading-30 gilroy-Semibold l-s1 text-dark">
                            {{ formatNumber($wallet->balance, $wallet->currency?->id) }}</p>
                        <p class="mb-0 text-success f-12 leading-15 l-s1 gilroy-medium d-flex align-items-center">
                            <span>{{ $wallet->is_default == 'Yes' ? 'Default' : '' }}</span>
                        </p>
                    </div>
                </div>
            @endforeach
        @endif
        <div class="dash-wallet-box bg-white d-flex gap-14 align-items-center h-112 cursor-pointer">
            <div class="dash-check-all bg-white-50 d-flex justify-content-center align-items-center">
                <svg width="22" height="18" viewBox="0 0 22 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4.58887 0.562501L15.5361 0.562501C16.0303 0.562485 16.4567 0.562471 16.8078 0.591163C17.1785 0.621445 17.5471 0.688303 17.9019 0.869048C18.4311 1.13869 18.8613 1.56895 19.131 2.09816C19.3117 2.45289 19.3786 2.82153 19.4088 3.19216C19.4375 3.54332 19.4375 3.96965 19.4375 4.46385V5.8795C20.3635 6.20662 21.0631 7.00018 21.2585 7.98256C21.3131 8.25711 21.3128 8.56446 21.3125 8.92137C21.3125 8.94732 21.3125 8.97353 21.3125 9C21.3125 9.02649 21.3125 9.0527 21.3125 9.07866C21.3128 9.43556 21.3131 9.7429 21.2585 10.0174C21.0631 10.9998 20.3635 11.7934 19.4375 12.1205V13.5362C19.4375 14.0304 19.4375 14.4567 19.4088 14.8078C19.3786 15.1785 19.3117 15.5471 19.131 15.9018C18.8613 16.4311 18.4311 16.8613 17.9019 17.131C17.5471 17.3117 17.1785 17.3786 16.8078 17.4088C16.4567 17.4375 16.0304 17.4375 15.5362 17.4375L4.58885 17.4375C4.09465 17.4375 3.66832 17.4375 3.31716 17.4088C2.94653 17.3786 2.57788 17.3117 2.22315 17.131C1.69395 16.8613 1.26369 16.4311 0.994046 15.9018C0.813301 15.5471 0.746443 15.1785 0.716161 14.8078C0.68747 14.4567 0.687484 14.0303 0.687501 13.5361V4.46387C0.687484 3.96966 0.68747 3.54332 0.716161 3.19216C0.746443 2.82153 0.813302 2.45288 0.994046 2.09815C1.26369 1.56895 1.69395 1.13869 2.22315 0.869046C2.57788 0.688302 2.94653 0.621443 3.31716 0.591161C3.66833 0.56247 4.09467 0.562484 4.58887 0.562501ZM17.5625 12.2813H16.1563C16.1298 12.2813 16.1036 12.2813 16.0776 12.2813C15.7207 12.2816 15.4134 12.2818 15.1388 12.2272C14.0231 12.0053 13.151 11.1331 12.929 10.0174C12.8744 9.74289 12.8747 9.43555 12.875 9.07864C12.875 9.05269 12.875 9.02648 12.875 9C12.875 8.97352 12.875 8.94731 12.875 8.92136C12.8747 8.56446 12.8744 8.25711 12.929 7.98256C13.151 6.86687 14.0231 5.99472 15.1388 5.77279C15.4134 5.71818 15.7207 5.71843 16.0776 5.71871C16.1036 5.71873 16.1298 5.71875 16.1563 5.71875H17.5625V4.5C17.5625 3.95948 17.5618 3.61048 17.5401 3.34485C17.5193 3.09017 17.4839 2.99574 17.4603 2.94939C17.3704 2.77299 17.227 2.62957 17.0506 2.53969C17.0043 2.51607 16.9098 2.48074 16.6552 2.45994C16.3895 2.43823 16.0405 2.4375 15.5 2.4375H4.625C4.08448 2.4375 3.73548 2.43823 3.46985 2.45993C3.21516 2.48074 3.12074 2.51606 3.07439 2.53968C2.89798 2.62956 2.75457 2.77298 2.66468 2.94939C2.64107 2.99574 2.60574 3.09016 2.58493 3.34485C2.56323 3.61048 2.5625 3.95948 2.5625 4.5V13.5C2.5625 14.0405 2.56323 14.3895 2.58493 14.6552C2.60574 14.9098 2.64107 15.0043 2.66468 15.0506C2.75456 15.227 2.89798 15.3704 3.07439 15.4603C3.12074 15.4839 3.21516 15.5193 3.46985 15.5401C3.73548 15.5618 4.08448 15.5625 4.625 15.5625L15.5 15.5625C16.0405 15.5625 16.3895 15.5618 16.6552 15.5401C16.9098 15.5193 17.0043 15.4839 17.0506 15.4603C17.227 15.3704 17.3704 15.227 17.4603 15.0506C17.4839 15.0043 17.5193 14.9098 17.5401 14.6552C17.5618 14.3895 17.5625 14.0405 17.5625 13.5V12.2813ZM16.1563 7.59375C15.6757 7.59375 15.5723 7.59829 15.5046 7.61177C15.1327 7.68574 14.842 7.97646 14.768 8.34835C14.7545 8.41609 14.75 8.51945 14.75 9C14.75 9.48055 14.7545 9.58391 14.768 9.65165C14.842 10.0235 15.1327 10.3143 15.5046 10.3882C15.5723 10.4017 15.6757 10.4063 16.1563 10.4063H18.0313C18.5118 10.4063 18.6152 10.4017 18.6829 10.3882C19.0548 10.3143 19.3455 10.0235 19.4195 9.65165C19.433 9.58392 19.4375 9.48055 19.4375 9C19.4375 8.51945 19.433 8.41609 19.4195 8.34835C19.3455 7.97646 19.0548 7.68574 18.6829 7.61177C18.6152 7.59829 18.5118 7.59375 18.0313 7.59375H16.1563Z"
                        fill="currentColor" />
                </svg>
            </div>
            <div class="check-all">
                <p class="mb-0 f-14 leading-17 gilroy-medium text-gray-100">{{ __('Check all') }}</p>
                <p class="mb-0 f-18 leading-22 text-dark gilroy-Semibold">{{ __('Wallet Balance') }}</p>
            </div>
            <a href="{{ route('user.wallets.index') }}"
                class="nscaleX-1 cursor-pointer d-flex justify-content-center align-items-center dash-arrow-div">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M12.1852 4.85247C11.8272 5.21045 11.8272 5.79085 12.1852 6.14883L16.1203 10.084H3.66667C3.16041 10.084 2.75 10.4944 2.75 11.0007C2.75 11.5069 3.16041 11.9173 3.66667 11.9173H16.1203L12.1852 15.8525C11.8272 16.2105 11.8272 16.7909 12.1852 17.1488C12.5431 17.5068 13.1235 17.5068 13.4815 17.1488L18.9815 11.6488C19.3395 11.2909 19.3395 10.7105 18.9815 10.3525L13.4815 4.85247C13.1235 4.49449 12.5431 4.49449 12.1852 4.85247Z"
                        fill="#3F405B" />
                </svg>
            </a>
        </div>
    </div>

    <!--Virtualcard Section-->
    @if (!$virtualcards->isEmpty())
        <div class="row mt-20 gy-4">

            <!-- Card list Left Side -->
            <div class="col-lg-12 col-xl-6 col-md-6">
                <div class="slider-component position-relative">
                    <!-- Slider main container -->
                    <div class="swiper">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Card Slides -->
                            @foreach ($virtualcards as $virtualcard)
                           
                                <div class="swiper-slide">
                                    <a href="{{ route('user.virtualcard.show', $virtualcard->id) }}"
                                        class="text-decoration-none">
                                        <div class="background-white">
                                            @php
                                                $cardBackgroundImage =
                                                    $virtualcard->card_brand == 'Visa Card'
                                                        ? 'visacard.png'
                                                        : 'mastercard.png';
                                                $cardLogo =
                                                    $virtualcard->card_brand == 'Visa Card'
                                                        ? 'visa_logo'
                                                        : 'master_logo';
                                            @endphp
                                            <input type="hidden" id="totalBalance"
                                                value="{{ moneyFormat($virtualcard->currency()?->symbol, formatNumber($virtualcard->amount, $virtualcard->currency()?->id)) }}">
                                            <input type="hidden" id="cardType" value="{{ $virtualcard->card_type }}">
                                            <input type="hidden" id="cardCurrency"
                                                value="{{ $virtualcard->currency_code }}">
                                            <input type="hidden" id="cardStatus" value="{{ $virtualcard->status }}">
                                            <input type="hidden" id="cardTopupLink" value="{{ route('user.topup.create', ['card_id' => $virtualcard->id]) }}">
                                            <input type="hidden" id="cardWithdrawalLink" value="{{route('user.virtualcard_withdrawal.create', ['card_id' => $virtualcard->id]) }}">
                                            <div class="relative h-64 rounded-xl p-6 shadow w-100 bg-gradient-1"
                                                style="background-image: url('{{ asset("Modules/Virtualcard/Resources/assets/images/$cardBackgroundImage") }}')">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    {!! virtualcardSvgIcons('card_network') !!}
                                                    {!! virtualcardSvgIcons($cardLogo) !!}
                                                </div>
                                                <div id="card-number"
                                                    class="text-2xl font-semibold text-white gilroy-Semibold">
                                                    {{ maskCardNumber($virtualcard->card_number) }}
                                                </div>
                                                <div class="mt-3 grid grid-cols-5 gap-2 text-white">
                                                    <div class="col-span-2 mt-2">
                                                        <p class="text-sm  gilroy-medium mb-0">{{ __('Name') }}</p>
                                                        <p id="card-holder"
                                                            class="mt-2 text-xs gilroy-regular text-capitalize">
                                                            {{ cardTitle($virtualcard->virtualcardHolder) }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="whitespace-nowrap text-sm gilroy-medium mb-0 mt-2">
                                                            {{ __('Expiry date') }}</p>
                                                        <p id="exp-date" class="mt-2 text-xs gilroy-regular">
                                                            {{ formatCardExpiryDate($virtualcard->expiry_month, $virtualcard->expiry_year) }}
                                                        </p>
                                                    </div>
                                                    <div class="ml-30px">
                                                        <p class="mb-2 text-center text-sm gilroy-medium mt-2">
                                                            {{ __('CVC') }}
                                                        </p>
                                                        <div id="cvc-number" class="ml-24p text-center gilroy-regular">
                                                            {{ str_repeat('*', strlen($virtualcard->card_cvc)) }}</div>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        {!! virtualcardSvgIcons('card_chip') !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                
                            @endforeach
                            <!-- End card Slider -->
                            <div class="swiper-slide">
                                <a href="{{ route('user.virtualcard.create') }}" class="text-decoration-none">
                                    <div class="background-white">
                                        <div class=" card-bg  rounded-xl position-relative">
                                            <div class="relative  h-64 p-6 shadow w-100 add-card-bg">
                                                
                                                <div class="new-card-btn1 position-absolute">
                                                    <div class="card-bg p-3 rounded-3 w-max mx-auto">
                                                        <svg style="width:25px; height:25px"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" fill="#303033"
                                                            version="1.1" id="Capa_1" width="800px"
                                                            height="800px" viewBox="0 0 45.402 45.402"
                                                            xml:space="preserve">
                                                            <g>
                                                                <path d="M41.267,18.557H26.832V4.134C26.832,1.851,24.99,0,22.707,0c-2.283,0-4.124,1.851-4.124,4.135v14.432H4.141   c-2.283,0-4.139,1.851-4.138,4.135c-0.001,1.141,0.46,2.187,1.207,2.934c0.748,0.749,1.78,1.222,2.92,1.222h14.453V41.27   c0,1.142,0.453,2.176,1.201,2.922c0.748,0.748,1.777,1.211,2.919,1.211c2.282,0,4.129-1.851,4.129-4.133V26.857h14.435   c2.283,0,4.134-1.867,4.133-4.15C45.399,20.425,43.548,18.557,41.267,18.557z" />
                                                            </g>
                                                        </svg>
                                                    </div>
                                                    <span class="text-sm text-white gilroy-light">{{ __('New Card') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-next h-40 w-40 rounded-circle">
                        <svg class="h-20 w-20  neg-transition-scale" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor" height="800px" width="800px" version="1.1" id="Layer_1" viewBox="0 0 330 330" xml:space="preserve">
                            <g id="XMLID_103_">
                                <path id="XMLID_104_" d="M310.607,154.391l-150-149.997c-5.857-5.858-15.355-5.858-21.213,0.001   c-5.857,5.858-5.857,15.355,0,21.213l139.393,139.39L139.394,304.394c-5.857,5.858-5.857,15.355,0,21.213   c2.929,2.929,6.768,4.393,10.606,4.393s7.678-1.464,10.607-4.394l150-150.003c2.813-2.813,4.393-6.628,4.393-10.606   C315,161.019,313.42,157.204,310.607,154.391z"/>
                                <path id="XMLID_105_" d="M195.001,164.996c0-3.979-1.581-7.794-4.394-10.607L40.606,4.393c-5.858-5.858-15.355-5.858-21.213,0.001   c-5.857,5.858-5.857,15.355,0.001,21.213l139.394,139.39L19.393,304.394c-5.857,5.858-5.857,15.355,0.001,21.213   C22.322,328.536,26.161,330,30,330s7.678-1.464,10.607-4.394l150.001-150.004C193.42,172.79,195.001,168.974,195.001,164.996z"/>
                            </g>
                            </svg>
                    </div>
                    <div class="swiper-button-prev h-40 w-40 rounded-circle">
                        <svg class="h-20 w-20  neg-transition-scale" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor" height="800px" width="800px" version="1.1" id="Layer_1" viewBox="0 0 330 330" xml:space="preserve">
                            <g id="XMLID_106_">
                                <path id="XMLID_107_" d="M51.213,165.004L190.607,25.607c5.857-5.858,5.857-15.355-0.001-21.213   c-5.857-5.858-15.355-5.858-21.213,0.001l-150,150.004C16.58,157.211,15,161.026,15,165.004c0,3.979,1.581,7.794,4.394,10.607   l150,149.996C172.322,328.536,176.161,330,180,330s7.678-1.464,10.607-4.394c5.857-5.858,5.857-15.355-0.001-21.213L51.213,165.004   z"/>
                                <path id="XMLID_108_" d="M171.213,165.004L310.607,25.607c5.858-5.858,5.858-15.355,0-21.213   c-5.857-5.858-15.355-5.858-21.213,0.001l-150,150.004c-2.813,2.813-4.393,6.628-4.393,10.606c0,3.979,1.581,7.794,4.394,10.607   l150,149.996C292.322,328.536,296.161,330,300,330c3.839,0,7.678-1.464,10.607-4.394c5.858-5.858,5.858-15.355,0-21.213   L171.213,165.004z"/>
                            </g>
                            </svg>
                    </div>
                </div>
            </div>
            <!-- End Card list Left Side -->

            <!-- Card Details -->
            <div class="col-lg-12 col-xl-6 col-md-6 ">
                <div class="bg-white rounded-xl pt-2">
                    <div id="selected-card-info" class="px-4">
                        <div class="left-profile-info mt-3">
                            <!-- Details info section -->
                            <div class="row g-3">
                                <div class="col-6">
                                    <p class="mb-2 f-14 leading-18 text-gray-100  gilroy-medium text-align-initial">
                                        {{ __('Total Balance') }}</p>
                                    <p id="selected-card-amount"
                                        class="balance mb-0 f-18 leading-18 text-dark gilroy-Semibold">
                                    </p>
                                </div>
                                <div class="col-6 text-end ">
                                    <p class="mb-2 f-14 leading-18 text-gray-100  gilroy-medium text-end">
                                        {{ __('Card Type') }}
                                    </p>
                                    <p id="selected-card-type"
                                        class="limit mb-0 f-18 leading-18 text-dark gilroy-Semibold "></p>
                                </div>
                                <div class="col-6 pt-3">
                                    <p class="mb-2 f-14 leading-18 text-gray-100  gilroy-medium text-align-initial">
                                        {{ __('Currency') }}</p>
                                    <p id="selected-card-currency"
                                        class="holder mb-0 f-18 leading-18 text-dark gilroy-Semibold">
                                    </p>
                                </div>
                                <div class="col-6 text-end pt-3">
                                    <p class="mb-2 f-14 leading-18 text-gray-100 gilroy-medium text-end">
                                        {{ __('Status') }}
                                    </p>
                                    <p id="selected-card-status"
                                        class="status-text mb-0 rounded-pill bg-success text-end ms-auto">
                                    </p>
                                </div>
                            </div>
                            <!-- End Details info section -->

                            <!-- Topup & Withdraw Button -->
                            <div class="d-flex justify-content-center gap-78 pb-3 mt-4">
                                <a href="javascript:void(0)" id="topup-link"
                                    class="d-flex justify-content-center align-items-center flex-column cursor-pointer">
                                    {!! virtualcardSvgIcons('topup_icon') !!}
                                    <p class="mb-0 f-14 leading-18 text-dark gilroy-medium">{{ __('Topup') }}</p>
                                </a>
                                <a href="javascript:void(0)" id="withdrawal-link"
                                    class="d-flex justify-content-center align-items-center flex-column cursor-pointer">
                                    {!! virtualcardSvgIcons('withdraw_icon') !!}
                                    <p class="mb-0 f-14 leading-18 text-dark gilroy-medium">{{ __('Withdraw') }}</p>
                                </a>
                            </div>
                            <!-- End Topup & Withdraw Button -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End card details -->
        </div>
    @endif
    <!-- End virtualcard Section -->

    <div class="row mt-20 gy-4">
        <div class="col-12 col-xl-4">
            <div class="dash-profile-qr-div bg-white profile-mt-24">
                <div class="d-flex justify-content-between qr-icon">
                    <p class="mb-0 f-18 leading-22 text-dark gilroy-Semibold">{{ __('Profile QR Code') }}</p>
                    <a href="{{ route('user.profiles.index') }}">{!! svgIcons('edit_icon_lg') !!}</a>
                </div>
                <div class="d-flex">
                    <div class="dash-profile-qrCode mt-20">
                        <img src="{{ image($qrCode?->qr_image, 'user_qrcode') }}" alt="{{ __('QrCode') }}"
                            class="img-fluid">
                    </div>
                    <div class="w-154 ml-20 qr-text">
                        <p class="mb-0 f-16 leading-22 gilroy-Semibold text-dark mt-25">{{ __('Send or Receive Money') }}
                        </p>
                        <p class="mb-0 f-14 leading-22 gilroy-medium text-gray-100 mt-8">
                            {{ __('Use the QR code to easily handle your transactions.') }}</p>
                    </div>
                </div>
                <button class="btn btn-lg btn-primary dash-print-btn mt-24 green-btn" id="printQrCodeBtn">
                    <svg class="mr-10" width="14" height="14" viewBox="0 0 14 14" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M3.23077 12.8333H10.7692V10.5H3.23077V12.8333ZM3.23077 7H10.7692V3.5H9.42308C9.19872 3.5 9.00801 3.41493 8.85096 3.24479C8.69391 3.07465 8.61538 2.86806 8.61538 2.625V1.16667H3.23077V7ZM12.9231 7.58333C12.9231 7.42535 12.8698 7.28863 12.7632 7.17318C12.6567 7.05773 12.5304 7 12.3846 7C12.2388 7 12.1126 7.05773 12.006 7.17318C11.8994 7.28863 11.8462 7.42535 11.8462 7.58333C11.8462 7.74132 11.8994 7.87804 12.006 7.99349C12.1126 8.10894 12.2388 8.16667 12.3846 8.16667C12.5304 8.16667 12.6567 8.10894 12.7632 7.99349C12.8698 7.87804 12.9231 7.74132 12.9231 7.58333ZM14 7.58333V11.375C14 11.454 13.9734 11.5224 13.9201 11.5801C13.8668 11.6378 13.8037 11.6667 13.7308 11.6667H11.8462V13.125C11.8462 13.3681 11.7676 13.5747 11.6106 13.7448C11.4535 13.9149 11.2628 14 11.0385 14H2.96154C2.73718 14 2.54647 13.9149 2.38942 13.7448C2.23237 13.5747 2.15385 13.3681 2.15385 13.125V11.6667H0.269231C0.196314 11.6667 0.133213 11.6378 0.0799279 11.5801C0.0266426 11.5224 0 11.454 0 11.375V7.58333C0 7.1033 0.158453 6.69162 0.475361 6.34831C0.792268 6.00499 1.17228 5.83333 1.61538 5.83333H2.15385V0.875C2.15385 0.631944 2.23237 0.425347 2.38942 0.255208C2.54647 0.0850694 2.73718 0 2.96154 0H8.61538C8.83974 0 9.08654 0.0607639 9.35577 0.182292C9.625 0.303819 9.83814 0.449653 9.99519 0.619792L11.274 2.00521C11.4311 2.17535 11.5657 2.40625 11.6779 2.69792C11.7901 2.98958 11.8462 3.25694 11.8462 3.5V5.83333H12.3846C12.8277 5.83333 13.2077 6.00499 13.5246 6.34831C13.8415 6.69162 14 7.1033 14 7.58333Z"
                            fill="Currentcolor" />
                    </svg>
                    <span class="f-14 leading-20 gilroy-medium">{{ __('Print Code') }}</span>
                </button>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="contact-support bg-white h-100 d-flex flex-column justify-content-between p-4 rounded-4 shadow-sm border">
                <div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-3 rounded-circle" style="background: rgba(99, 91, 254, 0.1); color: #635BFE; width: 54px; height: 54px; display: flex; align-items: center; justify-content: center;">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#635BFE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                <line x1="9" y1="9" x2="15" y2="9"></line>
                                <line x1="9" y1="13" x2="13" y2="13"></line>
                            </svg>
                        </div>
                        <div>
                            <p class="mb-0 f-18 text-dark leading-22 gilroy-Semibold">
                                {{ __('Contact Ticket Support') }}</p>
                            <span class="badge bg-light text-primary f-11">{{ __('24/7 Dedicated Help') }}</span>
                        </div>
                    </div>
                    <p class="mb-0 f-14 leading-22 text-gray-100 gilroy-medium mt-3">
                        {{ __('Create a ticket on the problem you are facing and our team will get back to you soon. Our dedicated support team is here to assist you every step of the way.') }}
                    </p>
                </div>
                <div class="mt-4">
                    <a href="{{ route('user.tickets.create') }}" class="btn btn-primary w-100 rounded-pill py-2 font-weight-600 d-inline-flex align-items-center justify-content-center gap-2">
                        <span>{{ __('Create Ticket Now') }}</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                </div>
            </div>
        </div>
        @if (Common::has_permission(auth()->id(), 'manage_merchant'))
            <div class="col-12 col-xl-4">
                <div class="contact-support bg-white h-100 d-flex flex-column justify-content-between p-4 rounded-4 shadow-sm border">
                    <div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded-circle" style="background: rgba(0, 186, 242, 0.1); color: #00BAF2; width: 54px; height: 54px; display: flex; align-items: center; justify-content: center;">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#00BAF2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                            </div>
                            <div>
                                <p class="mb-0 f-18 text-dark leading-22 gilroy-Semibold">{{ __('Create Merchant') }}</p>
                                <span class="badge bg-light text-info f-11">{{ __('Business Gateway') }}</span>
                            </div>
                        </div>
                        <p class="mb-0 f-14 leading-22 text-gray-100 gilroy-medium mt-3">
                            {{ __('A Merchant User is a special type of user who operates a business and sells products. Set up a business account to accept global customer payments.') }}
                        </p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('user.merchants.create') }}" class="btn btn-outline-primary w-100 rounded-pill py-2 font-weight-600 d-inline-flex align-items-center justify-content-center gap-2">
                            <span>{{ __('Create New Merchant') }}</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if ($transactions->count() > 0)
        <div>
            <div class="mt-22 mt-sm-4">
                <div class="d-flex justify-content-between align-items-center r-pb-8 pb-10">
                    <p class="mb-0 text-gray-100 f-16 r-f-12 gilroy-medium dark-CDO">{{ __('Recent Activities') }}</p>
                    <div class="d-flex align-items-center">
                        <p class="mb-0 text-gray-100 f-16 r-f-12 gilroy-medium dark-CDO">{{ __('See All Transactions') }}
                        </p>
                        <a href="{{ route('user.transactions.index') }}"
                            class="fil-btn-arow ml-12 d-flex align-items-center justify-content-center">
                            <svg class="nscaleX-1" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.96967 3.96967C9.67678 4.26256 9.67678 4.73744 9.96967 5.03033L13.1893 8.25H3C2.58579 8.25 2.25 8.58579 2.25 9C2.25 9.41421 2.58579 9.75 3 9.75H13.1893L9.96967 12.9697C9.67678 13.2626 9.67678 13.7374 9.96967 14.0303C10.2626 14.3232 10.7374 14.3232 11.0303 14.0303L15.5303 9.53033C15.8232 9.23744 15.8232 8.76256 15.5303 8.46967L11.0303 3.96967C10.7374 3.67678 10.2626 3.67678 9.96967 3.96967Z"
                                    fill="white" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction List -->
        <div class="transac-parent">
            @include('user.transaction.info')
        </div>
    @endif
@endsection

@push('js')
    <script src="{{ asset('Modules/Virtualcard/Resources/assets/js/user/swiper.min.js') }}" type="text/javascript">
    </script>
    <script>
        'use strict';
        var cancellingText = "{{ __('Cancelling...') }}";
        var cancelledText = "{{ __('Cancelled') }}";
        var requestPaymentCancelUrl = "{{ route('user.request_money.cancel') }}";
        var printQrCodeUrl = "{{ route('user.profile.qrcode.print', [auth()->id(), 'user']) }}";
        var requestPaymentCreatorStatusCheckUrl = "{{ route('user.request_money.creator_status_check') }}";
        var requestPaymentCreatorSuspendUrl = "{{ route('user.request_money.creator_suspend') }}";
        var requestPaymentCreatorInactiveUrl = "{{ route('user.request_money.creator_inactive') }}";
        var userStatus = "{{ auth()->user()->status }}";
        var userStatusCheckUrl = "{{ url('check-user-status') }}";
        var walletRoute = "{{ route('user.wallets.index') }}";
    </script>
    <script src="{{ asset('Modules/Virtualcard/Resources/assets/js/user/dashboard.min.js') }}"></script>
    <script src="{{ asset('public/user/customs/js/user-status.min.js') }}"></script>
    <script src="{{ asset('public/user/customs/js/user-transaction.min.js') }}"></script>
    <script src="{{ asset('public/user/customs/js/dashboard.min.js') }}" type="text/javascript"></script>
@endpush
