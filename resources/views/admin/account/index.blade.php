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
                                <th>@lang('account.text.users_name')</th>
                                <th class="text-center">@lang('global.text.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($accounts as $account)
                            <tr class="mapping-row">
                                <td>{{ $account->name }}</td>
                                <td>
                                    @if ($totalUser = count($account->users))
                                        @php
                                            $counter  = 1;
                                            $showMax = $totalUser < 2 ?: 2;
                                        @endphp
                                        @foreach ($account->users->take($showMax) as $user)
                                            {{ $user->name }}
                                            @if ($counter++ < $showMax)
                                                ,
                                            @endif
                                        @endforeach
                                        @if ($showMax < $totalUser)
                                            ...
                                        @endif
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-success" title="{{__('global.button.edit')}}"
                                       href="{{ route('admin.account.index',['account' => $account->id]) }}" >
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a class="btn btn-danger" title="{{__('global.button.delete')}}"
                                       href="{{ route('admin.account.index', ['account' => $account->id]) }}">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </td>
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
