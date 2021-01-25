<!-- Modal -->
<div class="modal fade" id="{{"showProduct{$product->id}"}}" tabindex="-1"
     aria-labelledby="{{"showProduct{$product->id}Label"}}"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{"showProduct{$product->id}Label"}}">{{$product->name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="jumbotron p-3 d-flex flex-column align-items-center">
                    <img src="{{setPhoto($product->photo)}}" class="img-thumbnail mb-3" alt="{{$product->name}}">
                    <p class="lead"><span
                            class="font-weight-bold">@lang('admin.products.fields.price'): </span>{{$product->formattedPrice}}
                    </p>
                    <p class="lead"><span
                            class="font-weight-bold">@lang('admin.products.fields.category'): </span>{{$product->category->name}}
                    </p>
                    <p class="lead"><span
                            class="font-weight-bold">@lang('admin.products.fields.stock'): </span>@if ($product->stock <= \App\Models\Product::MINIMUM_STOCK)
                            <span class="text-danger">{{$product->stock}}</span>
                        @else
                            <span class="text-success">{{$product->stock}}</span>
                        @endif
                    </p>
                    <p class="lead"><span
                            class="font-weight-bold">@lang('admin.products.fields.status'): </span>@if ($product->status === \App\Models\Product::STATUSES['available'])
                            <span
                                class="text-success">@lang('admin.products.enabled')</span>
                        @else
                            <span class="text-danger">@lang('admin.products.disabled')</span>
                        @endif
                    </p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
