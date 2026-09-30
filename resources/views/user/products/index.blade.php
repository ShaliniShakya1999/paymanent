@extends('user.layouts.app')
@section('content')
@include('user.common.alert')
<div class="container-fluid py-4">
    <h1 class="h4 fw-semibold text-dark mb-4">{{ __('Products') }}</h1>

    @if($activated->isNotEmpty())
    <h2 class="h6 text-primary fw-bold text-uppercase mb-3">{{ __('Activated Products') }}</h2>
    <div class="row g-3 mb-5">
        @foreach($activated as $product)
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start">
                        @if($product->icon_class)
                        <div class="rounded-3 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                            <i class="fa {{ $product->icon_class }} fa-lg"></i>
                        </div>
                        @endif
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <h3 class="h6 fw-semibold text-primary mb-1">{{ $product->title }}</h3>
                                <span class="badge bg-success small">{{ __('Activated') }}</span>
                            </div>
                            @if($product->description)
                            <p class="mb-0 small text-muted">{{ $product->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if(($availableProductsWithStatus ?? collect())->isNotEmpty())
    <h2 class="h6 text-primary fw-bold text-uppercase mb-3">{{ __('Available Products') }}</h2>
    <div class="row g-3">
        @foreach($availableProductsWithStatus as $item)
        @php $product = $item->product; $reqStatus = $item->status; @endphp
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex align-items-start mb-3">
                        @if($product->icon_class)
                        <div class="rounded-3 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                            <i class="fa {{ $product->icon_class }} fa-lg"></i>
                        </div>
                        @endif
                        <div class="flex-grow-1">
                            <h3 class="h6 fw-semibold text-primary mb-1">{{ $product->title }}</h3>
                            @if($product->description)
                            <p class="mb-0 small text-muted">{{ $product->description }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="mt-auto">
                        @if($reqStatus === 'pending')
                        <span class="badge bg-warning text-dark px-3 py-2">{{ __('Pending') }}</span>
                        @elseif($reqStatus === 'rejected')
                        <span class="badge bg-danger px-3 py-2 mb-2 d-inline-block">{{ __('Rejected') }}</span>
                        <form action="{{ route('user.products.request', $product->id) }}" method="post" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">{{ __('Request again') }}</button>
                        </form>
                        @else
                        <form action="{{ route('user.products.request', $product->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm w-100">{{ __('Request Activation') }}</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if($activated->isEmpty() && ($availableProductsWithStatus ?? collect())->isEmpty())
    <div class="alert alert-light text-center py-5">
        <p class="mb-0 text-muted">{{ __('No products available at the moment.') }}</p>
    </div>
    @endif
</div>
@endsection
