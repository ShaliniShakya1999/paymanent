@extends('admin.layouts.master')
@section('title', __('Bus Source Cities'))

@section('page_content')
<div class="box">
    <div class="box-body">
        <div class="top-bar-title padding-bottom">{{ __('Bus Source Cities') }}</div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>{{ __('City ID') }}</th>
                    <th>{{ __('City Name') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cities as $c)
                <tr>
                    <td>{{ $c->source_city_id }}</td>
                    <td>{{ $c->source_city_name }}</td>
                </tr>
                @empty
                <tr><td colspan="2" class="text-center">{{ __('No source cities.') }}</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $cities->links() }}
    </div>
</div>
@endsection
