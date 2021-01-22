<!-- Modal -->
<div class="modal fade" id="createUser" tabindex="-1" aria-labelledby="createUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserLabel">@lang('admin.users.create-button')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.users.store', '#create-user')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">@lang('admin.users.fields.name')</label>
                        <input placeholder="name" id="name" type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">@lang('admin.users.fields.email')</label>
                        <input placeholder="email" id="email" type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="password">@lang('admin.users.fields.password')</label>
                                <input placeholder="password" id="password" type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       autocomplete="new-password">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="password-confirm">@lang('admin.users.fields.password-confirm')</label>
                                <input placeholder="password" id="password-confirm" type="password" name="password_confirmation"
                                       class="form-control @error('password-confirm') is-invalid @enderror"
                                       autocomplete="new-password">
                                @error('password-confirm')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
        @if($errors->any())
        if (window.location.hash === '#create-user') {
            createModal.modal('show');
            window.location.hash = '#';
        }
        @else
            window.location.hash = '#';
        @endif
    </script>
@endpush
