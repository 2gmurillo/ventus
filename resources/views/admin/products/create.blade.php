<!-- Modal -->
<div class="modal fade" id="createProduct" tabindex="-1" aria-labelledby="createProductLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProductLabel">@lang('admin.products.create-button')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.products.store', '#create-product')}}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">@lang('admin.products.fields.name')</label>
                        <input placeholder="name" id="name" type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
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
                                       value="{{old('price')}}">
                                @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="stock">@lang('admin.products.fields.stock')</label>
                                <input placeholder="stock" id="stock" type="number" name="stock"
                                       class="form-control @error('stock') is-invalid @enderror"
                                       value="{{old('stock')}}">
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
                                        {{old('category_id') == $category->id ? 'selected' : ''}}>
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
                                    value="{{\App\Models\Product::STATUSES['available']}}" {{old('status') === \App\Models\Product::STATUSES['available'] ? 'selected' : ''}}>
                                    @lang('admin.products.enabled')
                                </option>
                                <option
                                    value="{{\App\Models\Product::STATUSES['unavailable']}}" {{old('status') === \App\Models\Product::STATUSES['unavailable'] ? 'selected' : ''}}>
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
                               class="form-control @error('photo') is-invalid @enderror" value="{{old('photo')}}">
                        @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-primary">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const createModal = $('#createProduct');
        @if($errors->any())
        if (window.location.hash === '#create-product') {
            createModal.modal('show');
            window.location.hash = '#';
        }
        @else
            window.location.hash = '#';
        @endif
    </script>
@endpush
