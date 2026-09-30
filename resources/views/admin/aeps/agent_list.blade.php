@extends('admin.layouts.master')

@section('title', __('Aeps Agent List'))

@section('head_style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/dist/plugins/DataTables/DataTables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/dist/plugins/DataTables/Responsive/css/responsive.dataTables.min.css') }}">
@endsection

@section('page_content')
    {{-- Filter bar --}}
    <div class="box box-default">
        <div class="box-body">
            <h4 class="top-bar-title padding-bottom pull-left mb-0">{{ __('Aeps Agent List') }}</h4>
        </div>
    </div>
    <div class="box">
        <div class="box-body pb-20">
            <form action="{{ url(config('adminPrefix').'/aeps/agent-list') }}" method="GET" class="form-inline">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex flex-wrap align-items-end gap-2">
                            <div class="form-group mb-0">
                                <label class="f-14 fw-bold mb-1 d-block">{{ __('From Date') }}</label>
                                <input type="text" name="from" class="form-control f-14" placeholder="{{ __('From Date') }}" value="{{ $from ?? '' }}" autocomplete="off" style="min-width: 130px;">
                            </div>
                            <div class="form-group mb-0">
                                <label class="f-14 fw-bold mb-1 d-block">{{ __('To Date') }}</label>
                                <input type="text" name="to" class="form-control f-14" placeholder="{{ __('To Date') }}" value="{{ $to ?? '' }}" autocomplete="off" style="min-width: 130px;">
                            </div>
                            <div class="form-group mb-0">
                                <label class="f-14 fw-bold mb-1 d-block">{{ __('Search Value') }}</label>
                                <input type="text" name="search_value" class="form-control f-14" placeholder="{{ __('Search Value') }}" value="{{ $search_value ?? '' }}" style="min-width: 140px;">
                            </div>
                            <div class="form-group mb-0">
                                <label class="f-14 fw-bold mb-1 d-block">{{ __('User Id') }}</label>
                                <input type="text" name="user_id" class="form-control f-14" placeholder="{{ __('Agent/Parent id') }}" value="{{ $user_id ?? '' }}" style="min-width: 130px;">
                            </div>
                            <div class="form-group mb-0">
                                <label class="f-14 fw-bold mb-1 d-block">{{ __('Status') }}</label>
                                <select name="status" class="form-control select2 f-14" style="min-width: 140px;">
                                    <option value="all">{{ __('Select status') }}</option>
                                    <option value="Active" {{ isset($status) && $status === 'Active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="Inactive" {{ isset($status) && $status === 'Inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                    <option value="Suspended" {{ isset($status) && $status === 'Suspended' ? 'selected' : '' }}>{{ __('Suspended') }}</option>
                                </select>
                            </div>
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-theme f-14">{{ __('Search') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Table section --}}
    <div class="box">
        <div class="box-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <h4 class="top-bar-title padding-bottom mb-0">{{ __('Aeps Agent List') }}</h4>
                <a href="{{ url(config('adminPrefix').'/aeps/agent-list/excel?' . http_build_query(request()->only(['from','to','search_value','user_id','status']))) }}" class="btn btn-success btn-sm f-14" id="aeps-agent-excel">
                    <i class="fa fa-file-excel-o"></i> {{ __('Excel') }}
                </a>
            </div>
            <div class="table-responsive">
                {!! $dataTable->table(['class' => 'table table-striped table-hover dt-responsive', 'width' => '100%', 'cellspacing' => '0']) !!}
            </div>
        </div>
    </div>
@endsection

@push('extra_body_scripts')
    <script src="{{ asset('public/dist/plugins/DataTables/DataTables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/dist/plugins/DataTables/Responsive/js/dataTables.responsive.min.js') }}" type="text/javascript"></script>
    {!! $dataTable->scripts() !!}
    <script type="text/javascript">
        $(function() {
            $(".select2").select2();
        });
    </script>
@endpush
