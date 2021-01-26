<div class="form-group">
    <label for="exampleFormControlTextarea1"><small>@lang('Write the description for your order')</small></label>
    <textarea class="form-control @error('description') is-invalid @enderror"
              id="description"
              rows="3"
              name="description"
              placeholder=@lang('Description')>{{old('description', 'Ventus payment')}}</textarea>
</div>
@error('description')
<div class="alert alert-danger">{{ $message }}</div>
@enderror
