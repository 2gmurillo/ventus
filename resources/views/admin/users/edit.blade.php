<!-- Modal -->
<div class="modal fade" id="{{"editUser{$user->id}"}}" tabindex="-1" aria-labelledby="{{"editUser{$user->id}Label"}}"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('admin.users.update', [$user, '#edit-user'])}}" method="post">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="{{"editUser{$user->id}Label"}}">@lang('admin.users.edit') <strong>{{$user->email}}</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right"
                               for="name">@lang('admin.users.fields.name')</label>
                        <div class="col-md-6 align-self-center">
                            <input id="name" type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror" value="{{old('name', $user->name)}}">
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
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
        const createModal = $({{"#editUser{$user->id}"}});
        if (window.location.hash === '#edit-user') {
            createModal.modal('show');
        }
        createModal.on('hide.bs.modal', function () {
            window.location.hash = '#';
        });
    </script>
@endpush
