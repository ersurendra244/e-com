@if (!empty($item_id))
    <div class="col-md-12">
        <label class="form-label">Variants</label>
        <div class="card card-inverse-info">
            <div class="card-body">
                <div id="variant-wrapper">
                    @if (!empty($edit_data->variants))
                        @php $totalVariants = count($edit_data->variants); @endphp
                        @foreach ($edit_data->variants as $index => $variant)
                            <div class="variant-group row">
                                <input type="hidden" name="variant_id[{{ $index }}]" value="{{ $variant->id }}">
                                @if ($item_id == 1)
                                    <div class="col-md-3">
                                        <div class="form-group mb-2">
                                            <label>Color</label>
                                            <select name="color[{{ $index }}]" id="color_{{ $index }}"
                                                class="form-control color-select">
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
                                @if ($item_id != 1)
                                    <div class="col-md-3">
                                        <div class="form-group mb-2">
                                            <label>Size</label>
                                            <select name="size[{{ $index }}]" id="size_{{ $index }}"
                                                class="form-control">
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
                                @if ($item_id == 1)
                                    <div class="col-md-3">
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="quantity">Quantity</label>
                                            <input type="number" class="form-control"
                                                id="quantity_{{ $index }}" name="quantity[{{ $index }}]"
                                                placeholder="Enter quantity"
                                                value="{{ !empty($variant->quantity) ? $variant->quantity : '' }}"
                                                min="0">
                                            @if ($errors->has('quantity'))
                                                <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-3">
                                    <p class="form-label mb-1">Attribute Images</p>
                                    <div class="form-group mb-2">
                                        <div class="input-group">
                                            <input type="file" class="form-control image-input"
                                                name="images[{{ $index }}][]" multiple accept="image/*" />
                                        </div>
                                        @if ($errors->has('image'))
                                            <span class="text-danger">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="preview-container d-flex flex-wrap gap-2 mt-2">
                                        @if (!empty($variant->images))
                                            @foreach ($variant->images as $image)
                                                <div class="image-wrapper" data-path="{{ $image }}"
                                                    style="display: inline-block; position: relative;">
                                                    <img src="{{ asset('uploads/products/' . $image) }}"
                                                        class="preview-image"
                                                        style="width: 70px; height: 70px; border: 1px solid #ddd; border-radius: 5px; margin-right: 5px;">
                                                    <div onclick="removeImage(this)"
                                                        class="btn btn-danger btn-sm remove-image"
                                                        style="position: absolute; top: -8px; right: 0px; border-radius: 50%; line-height: 0.9; padding: 2px 6px;">
                                                        ×</div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="button"
                                        class="btn btn-danger btn-sm remove-variant mt-2">Remove</button>
                                    <button type="button" class="btn btn-sm btn-success mt-2 add-variant">Add
                                        More</button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="variant-group row">
                            @if ($item_id == 1 || $item_id == 22 || $item_id == 23)
                                <div class="col-md-3">
                                    <div class="form-group mb-2">
                                        <label>Color</label>
                                        <select name="color[0]" id="color_0" class="form-control color-select">
                                            <option value="">Select color</option>
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
                            {{-- @if ($item_id == 1)
                                <div class="col-md-3">
                                    <div class="form-group mb-2">
                                        <label>Size</label>
                                        <select name="size[0]" id="size_0" class="form-control">
                                            <option value="">Choose a size</option>
                                            @php $sizes = sizes(); @endphp
                                            @foreach ($sizes as $key => $size)
                                                <option value="{{ $key }}">
                                                    {{ $size }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif --}}
                            @if ($item_id == 23)
                                <div class="col-md-3">
                                    <div class="form-group mb-2">
                                        <label>Size</label>
                                        <select name="size[0]" id="size_0" class="form-control">
                                            <option value="">Choose a size</option>
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
                            @if ($item_id == 23)
                                <div class="col-md-3">
                                    <div class="form-group mb-2">
                                        <label>Occasion</label>
                                        <select name="occasion[0]" id="occasion_0" class="form-control">
                                            <option value="">Choose a occasion</option>
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
                            @if ($item_id == 22)
                                <div class="col-md-3">
                                    <div class="form-group mb-2">
                                        <label>Screen Size</label>
                                        <select name="size[0]" id="size_0" class="form-control">
                                            <option value="">Choose a size</option>
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
                            @if ($item_id == 22)
                                <div class="col-md-3">
                                    <div class="form-group mb-2">
                                        <label>Resolution</label>
                                        <select name="resolution[0]" id="resolution_0" class="form-control">
                                            <option value="">Choose a resolution</option>
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
                            @if ($item_id == 1)
                                <div class="col-md-3">
                                    <div class="form-group mb-2">
                                        <label>Video Resolution</label>
                                        <select name="resolution[0]" id="resolution_0" class="form-control">
                                            <option value="">Choose a resolution</option>
                                            @php $resolutions = video_resolutions(); @endphp
                                            @foreach ($resolutions as $key => $resolution)
                                                <option value="{{ $key }}">
                                                    {{ $resolution }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            @if ($item_id == 1 || $item_id == 22 || $item_id == 23)
                                <div class="col-md-3">
                                    <div class="form-group mb-2">
                                        <label class="form-label" for="quantity">Quantity</label>
                                        <input type="number" class="form-control" id="quantity_0" name="quantity[0]"
                                            placeholder="Enter quantity" value="" min="0">
                                        @if ($errors->has('quantity'))
                                            <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if ($item_id == 1 || $item_id == 22 || $item_id == 23)
                                <div class="col-md-3">
                                    <p class="form-label mb-1">Attribute Images</p>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="file" class="form-control image-input" name="images[0][]"
                                                multiple accept="image/*" />
                                        </div>
                                        @if ($errors->has('image'))
                                            <span class="text-danger">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-12">
                                <div class="preview-container d-flex flex-wrap gap-2 mt-2">

                                </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <button type="button"
                                    class="btn btn-danger btn-sm remove-variant mt-2">Remove</button>
                                <button type="button" class="btn btn-sm btn-success mt-2 add-variant">Add
                                    More</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if ($item_id == 1 || $item_id == 22 || $item_id == 23)
        <div class="col-md-12 mt-3">
            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea name="description" class="form-control summernote" id="description" rows="10">{{ !empty($edit_data->description) ? $edit_data->description : '' }}</textarea>
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
            </div>
        </div>
    @endif
    @if ($item_id == 1 || $item_id == 22 || $item_id == 23)
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label" for="highlights">Highlights</label>
                <textarea name="highlights" class="form-control summernote" id="highlights" rows="15">{{ !empty($edit_data->highlights) ? $edit_data->highlights : '' }}</textarea>
                @if ($errors->has('highlights'))
                    <span class="text-danger">{{ $errors->first('highlights') }}</span>
                @endif
            </div>
        </div>
    @endif
    @if ($item_id == 1 || $item_id == 22 || $item_id == 23)
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label" for="specifications">Specifications</label>
                <textarea name="specifications" class="form-control summernote" id="specifications" rows="15">{{ !empty($edit_data->specifications) ? $edit_data->specifications : '' }}</textarea>
                @if ($errors->has('specifications'))
                    <span class="text-danger">{{ $errors->first('specifications') }}</span>
                @endif
            </div>
        </div>
    @endif
    @if ($item_id == 1)
    @endif
@endif
