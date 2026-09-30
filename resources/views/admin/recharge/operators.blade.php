@extends('admin.layouts.master')
@section('title', __('Recharge Operator List'))

@section('page_content')
<div class="box">
    <div class="box-body">
        <div class="top-bar-title padding-bottom">{{ __('Recharge Operator List') }}</div>
        <p class="text-muted">{{ __('Operators are fetched from the Recharge API. Manage operators via the API configuration.') }}</p>
    </div>
</div>
@endsection
