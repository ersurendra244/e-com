@if(in_array($subcategory_id, ['1', '2']) && in_array($item_id, ['18', '19']))

    <div class="col-md-6">
        <div class="form-group">
            <label for="color">Color</label>
            <select name="color" id="color" class="form-control">
                <option value="">select color</option>
                @php $colors = colors(); @endphp
                @foreach($colors as $key => $color)
                    <option value="{{ $key }}">{{ $color }}</option>
                @endforeach
            </select>
            @if ($errors->has('color'))
                <span class="text-danger">{{ $errors->first('color') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label" for="size">Size</label>
            <select name="size" class="form-control" id="size">
                <option value="">Choose a size</option>
                @php $sizes = sizes(); @endphp
                @foreach ($sizes as $key => $size)
                    <option value="{{ $key }}">{{ $size }}</option>
                @endforeach
            </select>
            @if ($errors->has('size'))
                <span class="text-danger">{{ $errors->first('size') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label" for="price">Price</label>
            <input type="text" class="form-control" id="price" name="price"
                placeholder="Enter price" value="{{ old('price') }}">
            @if ($errors->has('price'))
                <span class="text-danger">{{ $errors->first('price') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label" for="base_price">Base Price</label>
            <input type="text" class="form-control" id="base_price" name="base_price"
                placeholder="Enter base price" value="{{ old('price') }}">
            @if ($errors->has('base_price'))
                <span class="text-danger">{{ $errors->first('base_price') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="">Short Description</label>
            <textarea name="short_description" class="form-control" id="short_description" rows="3">{{ $data->short_description ?? '' }}</textarea>
            @if ($errors->has('short_description'))
                <span class="text-danger">{{ $errors->first('short_description') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="full_description">Description</label>
            <textarea name="full_description" class="form-control summernote" id="full_description" rows="15">{{ $data->full_description ?? '' }}</textarea>
            @if ($errors->has('full_description'))
                <span class="text-danger">{{ $errors->first('full_description') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="add_description">Additional Information</label>
            <textarea name="add_description" class="form-control summernote" id="add_description" rows="15">{{ $data->add_description ?? '' }}</textarea>
            @if ($errors->has('add_description'))
                <span class="text-danger">{{ $errors->first('add_description') }}</span>
            @endif
        </div>
    </div>
@endif
