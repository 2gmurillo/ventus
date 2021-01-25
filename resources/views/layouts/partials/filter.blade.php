<div class="filter mb-2">
    <div class="filter__search">
        <form id="filter-form-2" action="{{route('home')}}">
            @csrf
            <div>
                <label for="category_selected">@lang('Category'):</label>
                <select name="category_selected" id="category_selected">
                    <option value="">@lang('All')</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" {{$categorySelected == $category->id ? 'selected' : ''}}>
                            {{$category->name}}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="order_by">@lang('Order by'):</label>
                <select name="order_by" id="order_by">
                    <option value="new" {{$orderBy === 'new' ? 'selected' : ''}}>@lang('Newer products')</option>
                    <option value="old" {{$orderBy === 'old' ? 'selected' : ''}}>@lang('Older products')</option>
                    <option value="asc" {{$orderBy === 'asc' ? 'selected' : ''}}>@lang('Lowest price')</option>
                    <option value="desc" {{$orderBy === 'desc' ? 'selected' : ''}}>@lang('Highest price')</option>
                </select>
                <input type="text" name="search" value="{{$search}}" placeholder="@lang('Search')...">
                @error('search')
                <div>{{ $message }}</div>
                @enderror
                <button type="submit" class="btn btn-outline-info" type="submit">@lang('Search')</button>
            </div>
        </form>
    </div>
</div>
