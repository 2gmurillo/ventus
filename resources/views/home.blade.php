@extends('layouts.app')
@section('content')
    <div class="home">
        @include('layouts.partials.filter')
        <div class="card2-container">
            @forelse ($products as $product)
                @include('admin.products.show')
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
                    <div>
                        <button type="button" class="btn btn-outline-dark" data-toggle="modal"
                                data-target="{{"#showProduct{$product->id}"}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                 class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path
                                    d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-dark"
                                onclick="event.preventDefault(); document.getElementById('{{"{$product->id}-cart"}}').submit();">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                 class="bi bi-cart-check-fill" viewBox="0 0 16 16">
                                <path
                                    d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1.646-7.646l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                            </svg>
                        </button>
                        <form id="{{"{$product->id}-cart"}}" action="{{route('products.carts.addOne', $product)}}"
                              method="POST">
                            @csrf
                        </form>
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
