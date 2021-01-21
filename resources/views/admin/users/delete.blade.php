<!-- Modal -->
<div class="modal fade" id="{{"deleteUser{$user->id}"}}" tabindex="-1"
     aria-labelledby="{{"deleteUser{$user->id}Label"}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{"deleteUser{$user->id}Label"}}">@lang('Warning')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.users.destroy', $user)}}" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    @lang('admin.users.question')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">@lang('No')</button>
                    <button type="submit" class="btn btn-danger">@lang('Yes')</button>
                </div>
            </form>
        </div>
    </div>
</div>
