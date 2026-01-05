<style>
    .variant-group {
        background: #ffefef;
        padding: 20px 10px;
        margin: 0px;
        margin-bottom: 10px;
    }
</style>

@if (!empty($form_fields))
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
                    <input type="hidden" name="variant_id[1]" value="1">
                    @foreach ($form_fields as $field)
                        @if ($field->formField->field_type == 'text')
                            <div class="col-md-{{ $field->row_class ?? '6' }}">
                                <div class="form-group">
                                    <label class="form-label"
                                        for="{{ $field->formField->field_name }}">{{ $field->formField->field_label }}</label>
                                    <input type="text" class="form-control {{ $field->field_class ?? '' }}"
                                        id="{{ $field->formField->field_name }}"
                                        name="{{ $field->formField->field_name }}[1]"
                                        placeholder="Enter {{ $field->formField->field_label }}"
                                        value="{{ old($field->formField->field_name) }}"
                                        {{ $field->is_required == 1 ? 'required' : '' }}>
                                </div>
                            </div>
                        @elseif ($field->formField->field_type == 'textarea')
                            <div class="col-md-{{ $field->row_class ?? '6' }}">
                                <div class="form-group">
                                    <label class="form-label"
                                        for="{{ $field->formField->field_name }}">{{ $field->formField->field_label }}</label>
                                    <textarea class="form-control {{ $field->field_class ?? '' }}" id="{{ $field->formField->field_name }}"
                                        name="{{ $field->formField->field_name }}[1]" placeholder="Enter {{ $field->formField->field_label }}"
                                        {{ $field->is_required == 1 ? 'required' : '' }}>{{ old($field->formField->field_name) }}</textarea>
                                </div>
                            </div>
                        @elseif ($field->formField->field_type == 'number')
                            <div class="col-md-{{ $field->row_class ?? '6' }}">
                                <div class="form-group">
                                    <label class="form-label"
                                        for="{{ $field->formField->field_name }}">{{ $field->formField->field_label }}</label>
                                    <input type="number" class="form-control {{ $field->field_class ?? '' }}"
                                        id="{{ $field->formField->field_name }}"
                                        name="{{ $field->formField->field_name }}[1]"
                                        placeholder="Enter {{ $field->formField->field_label }}"
                                        value="{{ old($field->formField->field_name) }}"
                                        {{ $field->is_required == 1 ? 'required' : '' }}>
                                </div>
                            </div>
                        @elseif ($field->formField->field_type == 'select')
                            <div class="col-md-{{ $field->row_class ?? '6' }}">
                                <div class="form-group">
                                    <label class="form-label"
                                        for="{{ $field->formField->field_name }}">{{ $field->formField->field_label }}</label>
                                    <select class="form-control {{ $field->field_class ?? '' }}"
                                        id="{{ $field->formField->field_name }}"
                                        name="{{ $field->formField->field_name }}[1]"
                                        {{ $field->is_required == 1 ? 'required' : '' }}>
                                        <option value="">--select--</option>
                                        @php
                                            $options = json_decode($field->formField->field_options, true);
                                            if (!is_array($options)) {
                                                $options = preg_split(
                                                    "/\r\n|\n|\r/",
                                                    $field->formField->field_options,
                                                );
                                            }
                                        @endphp
                                        @foreach ($options as $option)
                                            <option value="{{ $option }}"
                                                {{ old($field->formField->field_name) == $option ? 'selected' : '' }}>
                                                {{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @elseif ($field->formField->field_type == 'checkbox')
                            <div class="col-md-{{ $field->row_class ?? '6' }}">
                                <div class="form-group row mx-0">
                                    <label class="form-label col-12 px-0 pb-2"
                                        for="{{ $field->formField->field_name }}">{{ $field->formField->field_label }}</label>
                                    @php
                                        $options = json_decode($field->formField->field_options, true);
                                        if (!is_array($options)) {
                                            $options = preg_split("/\r\n|\n|\r/", $field->formField->field_options);
                                        }
                                        $option_class =
                                            $field->row_class < 5 ? '6' : ($field->row_class > 9 ? '3' : '4');
                                    @endphp
                                    @foreach ($options as $index => $option)
                                        @php $option_id = strtolower(str_replace(' ', '_', $option)); @endphp
                                        <div class="form-check col-{{ $option_class }}">
                                            <label class="form-check-label"
                                                for="{{ $field->formField->field_name }}_{{ $option_id }}">{{ $option }}
                                                <input class="form-check-input {{ $field->field_class ?? '' }}"
                                                    type="checkbox"
                                                    id="{{ $field->formField->field_name }}_{{ $option_id }}"
                                                    name="{{ $field->formField->field_name }}[1][{{ $option_id }}]"
                                                    value="{{ $option }}" {{ $field->is_required == 1 && $index == 0 ? 'required' : '' }}
                                                    {{ is_array(old($field->formField->field_name)) && in_array($option, old($field->formField->field_name)) ? 'checked' : '' }}>
                                                <i class="input-helper"></i>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @elseif ($field->formField->field_type == 'radio')
                            <div class="col-md-{{ $field->row_class ?? '6' }}">
                                <div class="form-group row mx-0">
                                    <label class="form-label col-12 px-0 pb-2"
                                        for="{{ $field->formField->field_name }}">{{ $field->formField->field_label }}</label>
                                    @php
                                        $options = json_decode($field->formField->field_options, true);
                                        if (!is_array($options)) {
                                            $options = preg_split("/\r\n|\n|\r/", $field->formField->field_options);
                                        }
                                    @endphp
                                    @foreach ($options as $index => $option)
                                        @php $option_id = strtolower(str_replace(' ', '_', $option)); @endphp
                                        <div class="form-check col-4">
                                            <label class="form-check-label"
                                                for="{{ $field->formField->field_name }}_{{ $option_id }}">{{ $option }}
                                                <input class="form-check-input {{ $field->field_class ?? '' }}"
                                                    type="radio"
                                                    id="{{ $field->formField->field_name }}_{{ $option_id }}"
                                                    name="{{ $field->formField->field_name }}[1]"
                                                    value="{{ $option }}"
                                                    {{ old($field->formField->field_name) == $option ? 'checked' : '' }}
                                                    {{ $field->is_required == 1 && $index == 0 ? 'required' : '' }}>
                                                <i class="input-helper"></i>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @elseif ($field->formField->field_type == 'date')
                            <div class="col-md-{{ $field->row_class ?? '6' }}">
                                <div class="form-group">
                                    <label class="form-label"
                                        for="{{ $field->formField->field_name }}">{{ $field->formField->field_label }}</label>
                                    <input type="date" class="form-control {{ $field->field_class ?? '' }}"
                                        id="{{ $field->formField->field_name }}"
                                        name="{{ $field->formField->field_name }}[1]"
                                        value="{{ old($field->formField->field_name) }}"
                                        {{ $field->is_required == 1 ? 'required' : '' }}>
                                </div>
                            </div>
                        @elseif ($field->formField->field_type == 'file')
                            <div class="col-md-{{ $field->row_class ?? '6' }}">
                                <div class="form-group">
                                    <label class="form-label"
                                        for="{{ $field->formField->field_name }}">{{ $field->formField->field_label }}</label>
                                    <input type="file" class="form-control image-input {{ $field->field_class ?? '' }}"
                                        id="{{ $field->formField->field_name }}" name="{{ $field->formField->field_name }}[1][]"
                                        value="{{ old($field->formField->field_name) }}" multiple accept="image/*"
                                        {{ $field->is_required == 1 ? 'required' : '' }}/>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <div class="col-md-12 d-flex flex-wrap justify-content-between align-items-start">
                        <div class="preview-container d-flex flex-wrap gap-2">

                        </div>
                        <div class="text-right align-self-center">
                            <button type="button" class="btn btn-sm btn-success add-variant">Add
                                More</button>
                            <button type="button" class="btn btn-danger btn-sm remove-variant">Remove</button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endif
