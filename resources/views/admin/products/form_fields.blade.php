@if($category == 'Men')

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
@endif
