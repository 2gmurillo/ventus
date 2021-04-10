@extends('layouts.app')
@section('content')
    <section class="container d-flex flex-column align-items-center">
        @foreach($errors->all() as $message)
            {{ $message }}
        @endforeach
        <h1>Payment details</h1>
        <form class="center-col" action="{{route('equipments.store')}}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col">
                    <input name="name" type="text" class="form-control" placeholder="Nombre">
                </div>
                <div class="col">
                    <select name="risk" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                        <option value="{{ null }}">Choose...</option>
                        @foreach(\App\Constants\EquipmentRisks::toArray() as $risk)
                            <option value="{{ $risk }}">{{ $risk }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <input name="maintenance" type="date" class="form-control" placeholder="Mantenimiento">
                </div>
                <div class="col">
                    <input name="calibration" type="date" class="form-control" placeholder="Calibración">
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button class="btn btn-success mb-3" type="submit">Guardar equipo</button>
                <a href="{{ route('equipments.index') }}" class="btn btn-info mb-3 ml-3" type="submit">Volver</a>
            </div>
        </form>
    </section>
@endsection
