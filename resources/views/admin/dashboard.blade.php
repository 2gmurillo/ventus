@extends('adminlte::page')

@section('title', __('admin.panel.title'))

@section('content_header')
    <h1>@lang('admin.panel.title')</h1>
@stop

@section('content')
    <div>
        Aqui el contenido del panel
    </div>
@endsection

@section('js')
    <script> console.log('Hi!'); </script>
@stop

