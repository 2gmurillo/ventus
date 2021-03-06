@extends('adminlte::page')

@section('title', __('admin.products.title'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@lang('admin.products.title')</h1>
        <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#createProduct">
            @lang('admin.products.create-button')
        </button>
    </div>
@stop

@section('content')
    @include('admin.products.create')
    <div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th class="text-center" scope="col">@lang('admin.products.fields.id')</th>
                <th class="text-center" scope="col">@lang('admin.products.fields.photo')</th>
                <td scope="col">@lang('admin.products.fields.name')</td>
                <td scope="col">@lang('admin.products.fields.category')</td>
                <td scope="col">@lang('admin.products.fields.price')</td>
                <td class="text-center" scope="col">@lang('admin.products.fields.stock')</td>
                <td class="text-center" scope="col">@lang('admin.products.fields.status')</td>
                <td class="text-center" scope="col">@lang('admin.products.fields.actions')</td>
            </tr>
            </thead>
            <tbody>
            @forelse($products as $product)
                <tr>
                    <th class="text-center align-middle" scope="row">{{$product->id}}</th>
                    <td class="d-flex justify-content-center">
                        <img class="rounded" style="width: 50px" src="{{ setPhoto($product->photo) }}"
                             alt="{{$product->name}}">
                    </td>
                    <td class="align-middle">{{$product->name}}</td>
                    <td class="align-middle">{{$product->category->name}}</td>
                    <td class="align-middle">{{$product->formattedPrice}}</td>
                    <td class="text-center align-middle">
                        @if ($product->stock <= \App\Models\Product::MINIMUM_STOCK)
                            <p class="text-danger mb-0">{{$product->stock}}</p>
                        @else
                            <p class="text-success mb-0">{{$product->stock}}</p>
                        @endif
                    </td>
                    <td class="text-center align-middle">
                        @if ($product->status === \App\Models\Product::STATUSES['available'])
                            <p class="text-success mb-0">@lang('admin.products.enabled')</p>
                        @else
                            <p class="text-danger mb-0">@lang('admin.products.disabled')</p>
                        @endif
                    </td>
                    <td class="text-center align-middle">
                        <div>
                            @include('admin.products.show')
                            @include('admin.products.delete')
                            <form id="{{"{$product->id}-status"}}" method="POST"
                                  action="{{route('admin.products.status', $product)}}">
                                @csrf
                                @method('PATCH')
                            </form>
                            <i type="button" class="fas fa-eye" data-toggle="modal"
                               data-target="{{"#showProduct{$product->id}"}}"></i>
                            <i type="button"
                               class="fas @if($product->status === \App\Models\Product::STATUSES['available']) text-success fa-toggle-on @else text-danger fa-toggle-off @endif"
                               onclick="event.preventDefault(); document.getElementById('{{"{$product->id}-status"}}').submit();"></i>
                            <a type="button" class="fas fa-edit" href="{{route('admin.products.edit', $product)}}"></a>
                            <i type="button" class="fas fa-trash-alt" data-toggle="modal"
                               data-target="{{"#deleteProduct{$product->id}"}}"></i>
                        </div>
                    </td>
                </tr>
            @empty
                <td colspan="4">@lang('admin.products.empty')</td>
            @endforelse
            </tbody>
        </table>
        @include('layouts.partials.pagination', ['table' => $products])
    </div>
@endsection

@section('js')
    @include('sweetalert::alert')
    @stack('scripts')
@stop
