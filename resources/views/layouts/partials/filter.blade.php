<div class="filter mb-2 mt-3">
    <div class="filter__search">
        <div class="container">
            <div class="row">
                <div class="col-10 d-flex align-items-center">
                    <form id="filter-form-2" action="{{route('home')}}">
                        @csrf
                        <div class="mr-3">
                            <label for="category_selected">@lang('Category'):</label>
                            <select name="category_selected" id="category_selected">
                                <option value="">@lang('All')</option>
                                @foreach ($categories as $category)
                                    <option
                                        value="{{$category->id}}" {{$categorySelected == $category->id ? 'selected' : ''}}>
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
                                <option
                                    value="new" {{$orderBy === 'new' ? 'selected' : ''}}>@lang('Newer products')</option>
                                <option
                                    value="old" {{$orderBy === 'old' ? 'selected' : ''}}>@lang('Older products')</option>
                                <option
                                    value="asc" {{$orderBy === 'asc' ? 'selected' : ''}}>@lang('Lowest price')</option>
                                <option
                                    value="desc" {{$orderBy === 'desc' ? 'selected' : ''}}>@lang('Highest price')</option>
                            </select>
                            <input type="text" name="search" value="{{$search}}" placeholder="@lang('Search')...">
                            @error('search')
                            <div>{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="col-2 d-flex justify-content-end">
                    <button type="submit" class="btn btn-outline-info mr-1"
                            onclick="event.preventDefault(); document.getElementById('filter-form-2').submit();">
                        @lang('Search')
                    </button>
                    <form action="{{route('home', null)}}">
                        <button class="btn btn-outline-secondary" type="submit">@lang('Clear')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
