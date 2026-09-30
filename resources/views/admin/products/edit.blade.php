@extends('admin.layouts.master')
@section('title', __('Edit Product'))
@section('page_content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('Edit Product') }}</h3>
        <a href="{{ route('admin.products.index') }}" class="btn btn-default pull-right">{{ __('Back to list') }}</a>
    </div>
    <form action="{{ route('admin.products.update', $product->id) }}" method="post" class="form-horizontal">
        @csrf
        @method('PUT')
        <div class="box-body">
            <div class="form-group row">
                <label class="col-sm-2 control-label mt-11 fw-bold" for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                <div class="col-sm-6">
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $product->title) }}" required maxlength="191">
                    @error('title')<span class="help-block text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label mt-11 fw-bold" for="description">{{ __('Description') }}</label>
                <div class="col-sm-6">
                    <textarea name="description" id="description" class="form-control" rows="2" maxlength="500">{{ old('description', $product->description) }}</textarea>
                    @error('description')<span class="help-block text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label mt-11 fw-bold" for="icon_class">{{ __('Icon class') }}</label>
                <div class="col-sm-6">
                    <input type="text" name="icon_class" id="icon_class" class="form-control" value="{{ old('icon_class', $product->icon_class) }}">
                    @error('icon_class')<span class="help-block text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label mt-11 fw-bold" for="section">{{ __('Section') }} <span class="text-danger">*</span></label>
                <div class="col-sm-6">
                    <select name="section" id="section" class="form-control" required>
                        <option value="activated" {{ old('section', $product->section) === 'activated' ? 'selected' : '' }}>{{ __('Activated Products') }}</option>
                        <option value="available" {{ old('section', $product->section) === 'available' ? 'selected' : '' }}>{{ __('Available Products') }}</option>
                    </select>
                    @error('section')<span class="help-block text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label mt-11 fw-bold" for="sort_order">{{ __('Sort order') }}</label>
                <div class="col-sm-6">
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $product->sort_order) }}" min="0">
                    @error('sort_order')<span class="help-block text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label mt-11 fw-bold">{{ __('Active') }}</label>
                <div class="col-sm-6 mt-11">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-theme">{{ __('Update Product') }}</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-default">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
@endsection
