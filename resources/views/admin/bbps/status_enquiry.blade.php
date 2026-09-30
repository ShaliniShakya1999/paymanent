@extends('admin.layouts.master')
@section('title', __('BBPS Status Enquiry'))

@section('page_content')
<div class="box">
    <div class="box-body">
        <div class="top-bar-title padding-bottom">{{ __('BBPS Status Enquiry') }}</div>
        <form action="{{ url(config('adminPrefix').'/bbps/status-enquiry') }}" method="POST" class="form-inline mb-4">
            @csrf
            <input type="text" name="referenceid" class="form-control mr-2" placeholder="{{ __('Reference ID') }}" value="{{ old('referenceid') }}" required>
            <button type="submit" class="btn btn-theme">{{ __('Check Status') }}</button>
        </form>
        @if(isset($result))
        <div class="alert alert-info">
            <pre class="mb-0">{{ is_array($result) ? json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : (is_string($result) ? $result : json_encode($result)) }}</pre>
        </div>
        @endif
    </div>
</div>
@endsection
