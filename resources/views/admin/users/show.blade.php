<!-- Modal -->
<div class="modal fade" id="{{"showUser{$user->id}"}}" tabindex="-1" aria-labelledby="{{"showUser{$user->id}Label"}}"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{"showUser{$user->id}Label"}}">{{$user->name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang('admin.users.fields.email'): {{$user->email}}</p>
                <p>@lang('admin.users.fields.verified'): @if ($user->email_verified_at)
                        <span class="text-success">{{$user->email_verified_at->diffForHumans()}}</span>
                    @else
                        <i class="fas fa-times" style="color: #ff0000;"></i>
                    @endif
                </p>
                <p>@lang('admin.users.fields.status'): @if ($user->disabled_at)
                        <span
                            class="text-danger">@lang('admin.users.disabled') {{$user->disabled_at->diffForHumans()}}</span>
                    @else
                        <span class="text-success">@lang('admin.users.enabled')</span>
                    @endif
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>
