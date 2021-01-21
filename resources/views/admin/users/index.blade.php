@extends('adminlte::page')

@section('title', __('admin.users.title'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@lang('admin.users.title')</h1>
        <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#createUser">
            @lang('admin.users.create-button')
        </button>
    </div>
@stop

@section('content')
    @include('admin.users.create')
    <div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th class="text-center" scope="col">@lang('admin.users.fields.id')</th>
                <td scope="col">@lang('admin.users.fields.name')</td>
                <td scope="col">@lang('admin.users.fields.email')</td>
                <td class="text-center" scope="col">@lang('admin.users.fields.verified')</td>
                <td class="text-center" scope="col">@lang('admin.users.fields.actions')</td>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <th class="text-center align-middle" scope="row">{{$user->id}}</th>
                    <td class="align-middle">{{$user->name}}</td>
                    <td class="align-middle">
                        {{$user->email}} <br>
                        <small>
                            @if ($user->disabled_at)
                                <span class="text-danger">
                                    @lang('Disabled') {{$user->disabled_at->diffForHumans()}}
                                </span>
                            @else
                                <span class="text-success">@lang('Enabled')</span>
                            @endif
                        </small>
                    </td>
                    <td class="text-center align-middle">
                        @if ($user->email_verified_at)
                            <i class="fas fa-check" style="color: green;"></i>
                        @else
                            <i class="fas fa-times" style="color: red;"></i>
                        @endif
                    </td>
                    <td class="text-center align-middle">
                        Botones
                    </td>
                </tr>
            @empty
                <td colspan="4">@lang('admin.users.empty')</td>
            @endforelse
            </tbody>
        </table>
        @include('layouts.partials.pagination', ['table' => $users])
    </div>
@endsection

@section('js')
    @stack('scripts')
@stop
