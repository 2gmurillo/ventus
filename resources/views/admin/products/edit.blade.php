@extends('adminlte::page')

@section('title', __('admin.products.title'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@lang('admin.products.edit') <strong>{{$product->name}}</strong></h1>
    </div>
@stop

@section('content')
    <form action="{{route('admin.products.update', $product)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="name">@lang('admin.products.fields.name')</label>
            <input placeholder="name" id="name" type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror" value="{{old('name', $product->name)}}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col">
                    <label for="price">@lang('admin.products.fields.price')</label>
                    <input placeholder="price" id="price" type="number" name="price"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{old('price', $product->price)}}">
                    @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col">
                    <label for="stock">@lang('admin.products.fields.stock')</label>
                    <input placeholder="stock" id="stock" type="number" name="stock"
                           class="form-control @error('stock') is-invalid @enderror"
                           value="{{old('stock', $product->stock)}}">
                    @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col">
                    <select class="custom-select @error('category_id') is-invalid @enderror" name="category_id">
                        <option value="0">@lang('admin.products.fields.select-category')</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}"
                                {{old('category_id', $product->category_id) == $category->id ? 'selected' : ''}}>
                                {{$category->name}}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col">
                    <select class="custom-select @error('status') is-invalid @enderror" name="status">
                        <option
                            value="{{\App\Models\Product::STATUSES['available']}}" {{old('status', $product->status) === \App\Models\Product::STATUSES['available'] ? 'selected' : ''}}>
                            @lang('admin.products.enabled')
                        </option>
                        <option
                            value="{{\App\Models\Product::STATUSES['unavailable']}}" {{old('status', $product->status) === \App\Models\Product::STATUSES['unavailable'] ? 'selected' : ''}}>
                            @lang('admin.products.disabled')
                        </option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="photo">@lang('admin.products.fields.photo')</label>
            <input style="padding: 3px;" placeholder="photo" id="photo" type="file" name="photo"
                   class="form-control @error('photo') is-invalid @enderror" value="{{old('photo', $product->photo)}}">
            @error('photo')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <a href="{{route('admin.products.index')}}" type="button" class="btn btn-secondary">@lang('Back')</a>
            <button type="submit" class="btn btn-primary">@lang('Update')</button>
        </div>
    </form>
@endsection
