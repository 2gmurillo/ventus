@extends('layouts.app')
@section('content')
    <section class="container">
        <div class="row my-4">
            <div class="col-md-4">
                <div class="jumbotron mb-0 py-3">
                    <div class="alert
                        @if($order->status === \App\Models\Order::APPROVED)
                        alert-success
@endif
                    @if($order->status === \App\Models\Order::REJECTED)
                        alert-danger
@endif
                    @if($order->status === \App\Models\Order::PENDING)
                        alert-warning
@endif
                    @if($order->status == \App\Models\Order::IN_PROCESS)
                        alert-info
@endif
                        mx-auto" role="alert">
                        <h1 class="display-5 text-center">{{$order->status}}</h1>
                    </div>
                    <hr class="my-4">
                    <div class="d-flex flex-column align-items-center">
                        <p><span class="font-weight-bold">@lang('Date')</span>: {{$order->updated_at}}</p>
                        <p><span class="font-weight-bold">@lang('Original Amount')</span>:
                            ${{number_format($order->total)}} COP</p>
                        <p><span class="font-weight-bold">@lang('Reference')</span>: {{$order->reference}}</p>
                        <p><span class="font-weight-bold">@lang('Status')</span>: {{$order->status}}</p>
                        <p><span
                                class="font-weight-bold">@lang('Payment Gateway')</span>: {{$order->paymentGateway->name}}
                        </p>
                    </div>
                    <div class="d-flex justify-content-center">
                        @if($order->status !== \App\Models\Order::APPROVED && $order->status !== \App\Models\Order::PENDING)
                            <form class="d-flex justify-content-center"
                                  {{--                                  action="{{route('products.carts.orders.storeCartOrder', $order)}}" method="POST">--}}
                                  method="POST">
                                @csrf
                                <button class="btn btn-success" type="submit">@lang('Retry the order')</button>
                            </form>
                        @endif
{{--                        <a href="{{route('orders.index')}}" class="btn btn-danger ml-2">@lang('Back')</a>--}}
                        <a href="#" class="btn btn-danger ml-2">@lang('Back')</a>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mt-3">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-center" scope="col">@lang('admin.products.fields.photo')</th>
                        <td scope="col">@lang('admin.products.fields.name')</td>
                        <td scope="col">@lang('admin.products.fields.category')</td>
                        <td scope="col">@lang('admin.products.fields.price')</td>
                        <th class="text-center" scope="col">@lang('Quantity')</th>
                        <th class="text-center" scope="col">@lang('Total')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($order->products as $product)
                        <tr>
                            <td class="d-flex justify-content-center">
                                <img class="rounded" style="width: 50px" src="{{ setPhoto($product->photo) }}"
                                     alt="{{$product->name}}">
                            </td>
                            <td class="align-middle">{{$product->name}}</td>
                            <td class="align-middle">{{$product->category->name}}</td>
                            <td class="align-middle">{{$product->formattedPrice}}</td>
                            <td class="text-center align-middle">{{$product->pivot->quantity}}</td>
                            <td class="text-center align-middle">{{$product->formattedTotal}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
