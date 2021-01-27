@extends('layouts.app')
@section('content')
    <section class="container d-flex flex-column align-items-center">
        <h1>@lang('My Orders')</h1>
        @if (!isset($orders) || $orders->isEmpty())
            <div class="alert alert-info w-25 mx-auto" role="alert">
                <p class="text-center mb-0">
                    @lang('There are no orders availables')
                </p>
            </div>
        @else
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="text-center">@lang('Reference')</th>
                    <th>@lang('Payment Gateway')</th>
                    <th>@lang('Amount')</th>
                    <th class="text-center">@lang('Status')</th>
                    <th class="text-center">@lang('Actions')</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td class="text-center align-middle">{{$order->reference}}</td>
                        <td class="align-middle">{{$order->PaymentGateway->name}}</td>
                        <td class="align-middle">{{$order->formattedTotal}}</td>
                        <td class="text-center align-middle">
                            <span class="badge
                        @if($order->status === \App\Models\Order::APPROVED)
                                badge-success
@endif
                            @if($order->status === \App\Models\Order::REJECTED)
                                badge-danger
@endif
                            @if($order->status === \App\Models\Order::PENDING)
                                badge-warning
@endif
                            @if($order->status == \App\Models\Order::IN_PROCESS)
                                badge-info
@endif
                                text-wrap mx-auto" style="font-size: 14px;">
                                <span class="display-5 text-center">{{$order->status}}</span>
                            </span>
                        </td>
                        <td class="text-center align-middle">
                            <a href="{{route('orders.show', $order)}}"
                               class="btn btn-outline-dark">@lang('See')</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        <div class="w-25 mx-auto mb-3">
            <a href="{{route('home')}}" class="link-bold btn btn-outline-danger w-100">@lang('Back')</a>
        </div>
    </section>
@endsection
