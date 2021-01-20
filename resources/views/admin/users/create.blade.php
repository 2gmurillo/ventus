<!-- Modal -->
<div class="modal fade" id="createUser" tabindex="-1" aria-labelledby="createUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('admin.users.store', '#create-user')}}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserLabel">@lang('admin.users.create-button')</h5>
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
                                   class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right"
                               for="email">@lang('admin.users.fields.email')</label>
                        <div class="col-md-6 align-self-center">
                            <input id="email" type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}">
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right"
                               for="password">@lang('admin.users.fields.password')</label>
                        <div class="col-md-6 align-self-center">
                            <input id="password" type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   autocomplete="new-password">
                            @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right"
                               for="password-confirm">@lang('admin.users.fields.password-confirm')</label>
                        <div class="col-md-6 align-self-center">
                            <input id="password-confirm" type="password" name="password_confirmation"
                                   class="form-control @error('password-confirm') is-invalid @enderror"
                                   autocomplete="new-password">
                            @error('password-confirm')
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
        const createModal = $('#createUser');
        if (window.location.hash === '#create-user') {
            createModal.modal('show');
        }
        createModal.on('hide.bs.modal', function () {
            window.location.hash = '#';
        });
    </script>
@endpush
