<div class="form-group">
    <label>Select Category Level</label>
    <select name="parent_id" id="parent_id" class="form-control select2" style="width: 100%;">
        <option value="0" {{ $category->parent_id == 0 ? 'selected': ''}}>Main Category</option>
        @if (!empty($categories))
            @foreach ($categories as $cat)
                <option value="{{ $cat['id'] }}" {{$category->parent_id == $cat['id'] ? 'selected': ''}}
                    >{{ $cat['category_name'] }}</option>
                @if (!empty($cat['sub_categories']))
                    @foreach ($cat['sub_categories'] as $subCategory)
                        <option value="{{ $subCategory['id'] }}">
                            &nbsp;&raquo;&nbsp;{{ $subCategory['category_name'] }}
                        </option>
                    @endforeach
                @endif
            @endforeach
        @endif
    </select>
</div>
