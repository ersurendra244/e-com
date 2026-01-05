<style>
    .variant-group {
        background: #ffefef;
        padding: 20px 10px;
        margin: 0px;
        margin-bottom: 10px;
    }
</style>

@if (!empty($fields))
    <div class="col-md-12">
        <label class="form-label">Variants</label>
        <div id="variant-wrapper">
            @if (!empty($edit_data->variants))
                @php $totalVariants = count($edit_data->variants); @endphp
                @foreach ($edit_data->variants as $index => $variant)
                    <div class="variant-group row">
                        <input type="hidden" name="variant_id[]" value="{{ $variant->id }}">
                        @if (in_array('color', $fields))
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Color</label>
                                    <select name="color[]" class="form-control">
                                        <option value="">Select color</option>
                                        @php $colors = colors(); @endphp
                                        @foreach ($colors as $key => $color)
                                            <option
                                                {{ !empty($variant->color) && $variant->color == $key ? 'selected' : '' }}
                                                value="{{ $key }}">
                                                {{ $color }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        @if (in_array('size (XX)', $fields))
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Size (XX)</label>
                                    <select name="size[]" class="form-control">
                                        <option value="">Choose a size</option>
                                        @php $sizes = sizes(); @endphp
                                        @foreach ($sizes as $key => $size)
                                            <option
                                                {{ !empty($variant->size) && $variant->size == $key ? 'selected' : '' }}
                                                value="{{ $key }}">
                                                {{ $size }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        @if (in_array('size (1 to 14)', $fields))
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Size (1 to 14)</label>
                                    <select name="size[]" class="form-control">
                                        <option value="">--select--</option>
                                        @php $footwear_sizes = footwear_sizes(); @endphp
                                        @foreach ($footwear_sizes as $key => $size)
                                            <option value="{{ $key }}"
                                                {{ !empty($variant->size) && $variant->size == $key ? 'selected' : '' }}>
                                                {{ $size }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        @if (in_array('size (Inch)', $fields))
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Size (Inch)</label>
                                    <select name="size[]" class="form-control">
                                        <option value="">--select--</option>
                                        @php $screen_sizes = screen_sizes(); @endphp
                                        @foreach ($screen_sizes as $key => $size)
                                            <option value="{{ $key }}"
                                                {{ !empty($variant->size) && $variant->size == $key ? 'selected' : '' }}>
                                                {{ $size }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        @if (in_array('occasion', $fields))
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Occasion</label>
                                    <select name="occasion[]" class="form-control">
                                        <option value="">--select--</option>
                                        @php $occasions = occasions(); @endphp
                                        @foreach ($occasions as $key => $occasion)
                                            <option value="{{ $key }}"
                                                {{ !empty($variant->occasion) && $variant->occasion == $key ? 'selected' : '' }}>
                                                {{ $occasion }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        @if (in_array('quality (HD)', $fields))
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Quality (HD)</label>
                                    <select name="quality[]" class="form-control">
                                        <option value="">--select--</option>
                                        @php $qualities = qualities(); @endphp
                                        @foreach ($qualities as $key => $quality)
                                            <option value="{{ $key }}"
                                                {{ !empty($variant->quality) && $variant->quality == $key ? 'selected' : '' }}>
                                                {{ $quality }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        @if (in_array('resolution (1280 x 720)', $fields))
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Resolution (1280 x 720)</label>
                                    <select name="resolution[]" class="form-control">
                                        <option value="">--select--</option>
                                        @php $resolutions = resolutions(); @endphp
                                        @foreach ($resolutions as $key => $resolution)
                                            <option value="{{ $key }}"
                                                {{ !empty($variant->resolution) && $variant->resolution == $key ? 'selected' : '' }}>
                                                {{ $resolution }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif


                        @if (in_array('quantity', $fields))
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" class="form-control" name="quantity[]"
                                        placeholder="Enter quantity"
                                        value="{{ !empty($variant->quantity) ? $variant->quantity : '' }}"
                                        min="0">
                                </div>
                            </div>
                        @endif
                        <div class="col-md-3">
                            <p class="form-label mb-1">Attribute Images</p>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="file" class="form-control image-input" name="images[]" multiple
                                        accept="image/*" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 d-flex flex-wrap justify-content-between align-items-start">
                            <div class="preview-container d-flex flex-wrap gap-2">
                                @if (!empty($variant->images))
                                    @foreach ($variant->images as $image)
                                        <div class="image-wrapper" data-path="{{ $image }}"
                                            style="display: inline-block; position: relative;">
                                            <img src="{{ asset('uploads/products/' . $image) }}" class="preview-image"
                                                style="width: 70px; height: 70px; border: 1px solid #ddd; border-radius: 5px; margin-right: 5px;">
                                            <div onclick="removeImage(this)" class="btn btn-danger btn-sm remove-image"
                                                style="position: absolute; top: -8px; right: 0px; border-radius: 50%; line-height: 0.9; padding: 2px 6px;">
                                                ×</div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            @else
                <div class="variant-group row">
                    @if (in_array('color', $fields))
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Color</label>
                                <select name="color[]" class="form-control">
                                    <option value="">--select--</option>
                                    @php $colors = colors(); @endphp
                                    @foreach ($colors as $key => $color)
                                        <option value="{{ $key }}">
                                            {{ $color }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    @if (in_array('size (XX)', $fields))
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Size (XX)</label>
                                <select name="size[]" class="form-control">
                                    <option value="">--select--</option>
                                    @php $sizes = sizes(); @endphp
                                    @foreach ($sizes as $key => $size)
                                        <option value="{{ $key }}">
                                            {{ $size }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    @if (in_array('size (1 to 14)', $fields))
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Size (1 to 14)</label>
                                <select name="size[]" class="form-control">
                                    <option value="">--select--</option>
                                    @php $footwear_sizes = footwear_sizes(); @endphp
                                    @foreach ($footwear_sizes as $key => $size)
                                        <option value="{{ $key }}">
                                            {{ $size }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    @if (in_array('size (Inch)', $fields))
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Size (Inch)</label>
                                <select name="size[]" class="form-control">
                                    <option value="">--select--</option>
                                    @php $screen_sizes = screen_sizes(); @endphp
                                    @foreach ($screen_sizes as $key => $size)
                                        <option value="{{ $key }}">
                                            {{ $size }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    @if (in_array('occasion', $fields))
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Occasion</label>
                                <select name="occasion[]" class="form-control">
                                    <option value="">--select--</option>
                                    @php $occasions = occasions(); @endphp
                                    @foreach ($occasions as $key => $occasion)
                                        <option value="{{ $key }}">
                                            {{ $occasion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    @if (in_array('quality (HD)', $fields))
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Quality (HD)</label>
                                <select name="quality[]" class="form-control">
                                    <option value="">--select--</option>
                                    @php $qualities = qualities(); @endphp
                                    @foreach ($qualities as $key => $quality)
                                        <option value="{{ $key }}">
                                            {{ $quality }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    @if (in_array('resolution (1280 x 720)', $fields))
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Resolution (1280 x 720)</label>
                                <select name="resolution[]" class="form-control">
                                    <option value="">--select--</option>
                                    @php $resolutions = resolutions(); @endphp
                                    @foreach ($resolutions as $key => $resolution)
                                        <option value="{{ $key }}">
                                            {{ $resolution }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    @if (in_array('quantity', $fields))
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="quantity[]"
                                    placeholder="Enter quantity" value="" min="0">
                            </div>
                        </div>
                    @endif
                    @if (in_array('images', $fields))
                        <div class="col-md-3">
                            <p class="form-label mb-1">Attribute Images</p>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="file" class="form-control image-input" name="images[]" multiple
                                        accept="image/*" />
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-12 d-flex flex-wrap justify-content-between align-items-start mt-2">
                        <div class="preview-container d-flex flex-wrap gap-2">

                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @if (in_array('description', $fields))
        <div class="col-md-12 mt-3">
            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea name="description" class="form-control summernote" id="description" rows="10">{{ !empty($edit_data->description) ? $edit_data->description : '' }}</textarea>
            </div>
        </div>
    @endif
    @if (in_array('highlights', $fields))
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label" for="highlights">Highlights</label>
                <textarea name="highlights" class="form-control summernote" id="highlights" rows="15">{{ !empty($edit_data->highlights) ? $edit_data->highlights : '' }}</textarea>
            </div>
        </div>
    @endif
    @if (in_array('specifications', $fields))
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label" for="specifications">Specifications</label>
                <textarea name="specifications" class="form-control summernote" id="specifications" rows="15">{{ !empty($edit_data->specifications) ? $edit_data->specifications : '' }}</textarea>
            </div>
        </div>
    @endif
@endif
