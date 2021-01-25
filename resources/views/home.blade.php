@extends('layouts.app')
@section('content')
    <div class="home">
        @include('layouts.partials.filter')
        <div class="card2-container">
            @forelse ($products as $product)
                {{-- start - card2 --}}
                <div class="card2">
                    <div class="card2__image">
                        <img src="{{ setPhoto($product->photo) }}" alt="{{$product->name}}">
                        <small class="category-shadow"></small>
                        <div class="category">
                            <p>{{$product->category->name}}</p>
                        </div>
                    </div>
                    <div class="card2__description">
                        <h2>{{Str::limit($product->name, 13)}}</h2>
                        <small>{{$product->formattedPrice}}</small>
                    </div>
                </div>
                {{-- end - card2 --}}
            @empty
                <div class="alert alert-secondary mt-3" role="alert">
                    @lang('admin.products.empty')
                </div>
            @endforelse
        </div>
        @include('layouts.partials.pagination', ['table' => $products])
    </div>
@endsection
