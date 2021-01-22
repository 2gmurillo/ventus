@extends('adminlte::page')

@section('title', __('admin.users.title'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@lang('admin.users.edit') <strong>{{$user->email}}</strong></h1>
    </div>
@stop

@section('content')
    <form action="{{route('admin.users.update', $user)}}" method="post">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="{{$user->email}}">@lang('admin.users.fields.name')</label>
            <input id="{{$user->email}}" type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{old('name', $user->name)}}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <a href="{{route('admin.users.index')}}" type="button" class="btn btn-secondary">@lang('Back')</a>
            <button type="submit" class="btn btn-primary">@lang('Update')</button>
        </div>
    </form>
@endsection
