@extends('admin.layouts.master')
@section('title', __('Service Commission'))

@section('page_content')
<div class="row">
    <div class="col-md-3 settings_bar_gap">
        @include('admin.common.settings_bar')
    </div>
    <div class="col-md-9">
        <div class="box box-info">
            <div class="box-header with-border text-center">
                <h3 class="box-title">{{ __('Service Commission') }}</h3>
            </div>
            <p class="padding text-muted">{{ __('Set admin commission (percentage and/or fixed amount) per service. This will be applied when users use these services.') }}</p>
            <form action="{{ url(config('adminPrefix').'/settings/service-commission') }}" method="post" class="form-horizontal" id="service-commission-form">
                @csrf
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Service') }}</th>
                                    <th>{{ __('Commission %') }}</th>
                                    <th>{{ __('Fixed Commission') }}</th>
                                    <th>{{ __('Active') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commissions as $c)
                                <tr>
                                    <td>{{ $c->service_name }}</td>
                                    <td>
                                        <input type="number" step="0.01" min="0" max="100" name="commission_percent[{{ $c->service_slug }}]" class="form-control" value="{{ old('commission_percent.'.$c->service_slug, $c->commission_percent) }}" placeholder="0">
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" min="0" name="commission_fixed[{{ $c->service_slug }}]" class="form-control" value="{{ old('commission_fixed.'.$c->service_slug, $c->commission_fixed) }}" placeholder="0.00">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="is_active[{{ $c->service_slug }}]" value="1" {{ old('is_active.'.$c->service_slug, $c->is_active) ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-theme">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
