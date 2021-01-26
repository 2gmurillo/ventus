@extends('layouts.app')
@section('content')
    <section class="container d-flex flex-column align-items-center">
        <h1>Payment details</h1>
        @if ($cart->total === 0)
            <div class="alert alert-info w-25 mx-auto" role="alert">
                <p class="text-center mb-0">
                    @lang('There is no order available')
                </p>
            </div>
        @else
            <div class="alert alert-info w-25 mx-auto" role="alert">
                <p class="text-center mb-0">
                    @lang('Total'): {{$cart->formattedTotal}}
                </p>
            </div>
            {{--            <form class="center-col" action="{{route('orders.store')}}" method="POST">--}}
            <form class="center-col" method="POST">
                @csrf
                <div class="row mt-3">
                    <div class="col">
                        <div class="alert alert-secondary mx-auto" role="alert">
                            <p class="text-center mb-0">
                                @lang('Select the payment gateway'):
                            </p>
                        </div>
                        <div class="form-group" id="toggler">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                @foreach ($paymentGateways as $paymentGateway)
                                    <label
                                        class="btn btn-outline-secondary rounded m-2 p-1"
                                        data-target="#{{ $paymentGateway->name }}Collapse"
                                        data-toggle="collapse">
                                        <input
                                            type="radio"
                                            name="payment_gateway_id"
                                            value="{{ $paymentGateway->id }}"
                                            required
                                        >
                                        <img class="img-thumbnail h-100" src="{{ asset($paymentGateway->image) }}">
                                    </label>
                                @endforeach
                            </div>
                            @foreach ($paymentGateways as $paymentGateway)
                                <div
                                    id="{{ $paymentGateway->name }}Collapse"
                                    class="collapse"
                                    data-parent="#toggler"
                                >
                                    @includeIf('components.' . strtolower($paymentGateway->name) . '-collapse')
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-success mb-3" type="submit">@lang('Confirm order')</button>
                </div>
            </form>
        @endif
    </section>
@endsection
