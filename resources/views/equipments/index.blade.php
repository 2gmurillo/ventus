@extends('layouts.app')
@section('content')
    <section class="container d-flex flex-column align-items-center">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Listado de Equipos</h1>
            <a href="{{ route('equipments.create') }}" class="btn btn-outline-success ml-3">
                Crear un nuevo equipo
            </a>
        </div>
        @if (!isset($equipments) || $equipments->isEmpty())
            <div class="alert alert-info w-25 mx-auto" role="alert">
                <p class="text-center mb-0">
                    No hay equipos disponibles
                </p>
            </div>
        @else
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="text-center" scope="col">ID</th>
                    <th class="text-center" scope="col">Nombre</th>
                    <th class="text-center" scope="col">Riesgo</th>
                    <th class="text-center" scope="col">Mantenimiento</th>
                    <th class="text-center" scope="col">Calibración</th>
                    <th class="text-center" scope="col">Próximo mantenimiento</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($equipments as $equipment)
                    <tr>
                        <th class="text-center align-middle" scope="row">{{ $equipment->id }}</th>
                        <th class="text-center align-middle" scope="row">{{ $equipment->name ?? 'No requiere'}}</th>
                        <th class="text-center align-middle" scope="row">{{ $equipment->risk ?? 'Ninguno'}}</th>
                        <th class="text-center align-middle" scope="row">{{ $equipment->maintenance ? $equipment->maintenance->diffForHumans() : 'No requiere'}}</th>
                        <th class="text-center align-middle" scope="row">{{ $equipment->calibration ? $equipment->calibration->diffForHumans() : 'No requiere'}}</th>
                        <th class="text-center align-middle" scope="row">{{ $equipment->next_maintenance ? $equipment->next_maintenance->diffForHumans() : 'No requiere'}}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @include('layouts.partials.pagination', ['table' => $equipments])
        @endif
        <div class="w-25 mx-auto mb-3">
            <a href="{{route('home')}}" class="link-bold btn btn-outline-danger w-100">@lang('Back')</a>
        </div>
    </section>
@endsection
