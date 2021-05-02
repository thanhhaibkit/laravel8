@extends('layouts.admin')

@push('styles')
@endpush


@section('title', 'Accounts')

@section('header')
    @parent

    <div class="container">
        <div class="row">
            <div class="col-sm-6 offset-sm-3 mb-5">
                <div class="mt-lg-5 text-center">
                    <h2>@lang('account.text.page_heading')</h2>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        @if(count($accounts) > 0)
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>@lang('account.text.account_name')</th>
                                <th class="text-center">@lang('global.text.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($accounts as $account)
                            <tr class="mapping-row">
                                <td>{{ $account->name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
