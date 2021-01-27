<!-- Modal -->
<div class="modal fade" id="{{"deleteProduct{$product->id}"}}" tabindex="-1"
     aria-labelledby="{{"deleteProduct{$product->id}Label"}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{"deleteProduct{$product->id}Label"}}">@lang('Warning')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.products.destroy', $product)}}" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    @lang('admin.products.question')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">@lang('No')</button>
                    <button type="submit" class="btn btn-danger">@lang('Yes')</button>
                </div>
            </form>
        </div>
    </div>
</div>
