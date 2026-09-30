@extends('admin.layouts.master')
@section('title', __('Add Product'))
@section('page_content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('Add Product') }}</h3>
        <a href="{{ route('admin.products.index') }}" class="btn btn-default pull-right">{{ __('Back to list') }}</a>
    </div>
    <form action="{{ route('admin.products.store') }}" method="post" class="form-horizontal">
        @csrf
        <div class="box-body">
            <div class="form-group row">
                <label class="col-sm-2 control-label mt-11 fw-bold" for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                <div class="col-sm-6">
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required maxlength="191" placeholder="{{ __('e.g. Payouts') }}">
                    @error('title')<span class="help-block text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label mt-11 fw-bold" for="description">{{ __('Description') }}</label>
                <div class="col-sm-6">
                    <textarea name="description" id="description" class="form-control" rows="2" maxlength="500" placeholder="{{ __('e.g. Transfer money instantly to bank accounts.') }}">{{ old('description') }}</textarea>
                    @error('description')<span class="help-block text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label mt-11 fw-bold" for="icon_class">{{ __('Icon class') }}</label>
                <div class="col-sm-6">
                    <input type="text" name="icon_class" id="icon_class" class="form-control" value="{{ old('icon_class') }}" placeholder="{{ __('e.g. fa fa-hand-holding-dollar') }}">
                    <span class="help-block small text-muted">{{ __('Font Awesome class, e.g. fa fa-money-bill, fa fa-mobile-alt') }}</span>
                    @error('icon_class')<span class="help-block text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label mt-11 fw-bold" for="section">{{ __('Section') }} <span class="text-danger">*</span></label>
                <div class="col-sm-6">
                    <select name="section" id="section" class="form-control" required>
                        <option value="activated" {{ old('section') === 'activated' ? 'selected' : '' }}>{{ __('Activated Products') }}</option>
                        <option value="available" {{ old('section', 'available') === 'available' ? 'selected' : '' }}>{{ __('Available Products') }}</option>
                    </select>
                    @error('section')<span class="help-block text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label mt-11 fw-bold" for="sort_order">{{ __('Sort order') }}</label>
                <div class="col-sm-6">
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                    @error('sort_order')<span class="help-block text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label mt-11 fw-bold">{{ __('Active') }}</label>
                <div class="col-sm-6 mt-11">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-theme">{{ __('Add Product') }}</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-default">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
@endsection
