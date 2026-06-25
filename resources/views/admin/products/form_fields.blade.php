<style>
    .variant-group {
        background: #ffefef;
        padding: 20px 10px;
        margin-bottom: 10px;
    }
</style>

@if (!empty($form_fields))
    <div class="col-md-12">
        <label class="form-label">Variants</label>

        <div id="variant-wrapper">

            @php
                $variants = !empty($variants) ? $variants : [['variant_id' => 1]];
            @endphp

            @foreach ($variants as $key => $variant)
                <div class="variant-group row">
                    <input type="hidden" name="variant_id[]" value="{{ $variant['variant_id'] }}">

                    @foreach ($form_fields as $field)
                        @php
                            $options = $field->field_options ?? [];
                            $col = $field->row_class ?? 6;
                            $name = $field->field_name . '[' . $variant['variant_id'] . ']';
                            $value = $variant[$field->field_name] ?? old($field->field_name);
                        @endphp

                        <div class="col-md-{{ $col }}">
                            <div class="form-group">

                                <label class="form-label">{{ $field->field_label }}</label>

                                {{-- TEXT --}}
                                @if ($field->field_type == 'text')
                                    <input type="text" class="form-control" name="{{ $name }}"
                                        value="{{ $value }}" {{ $field->is_required ? 'required' : '' }}>

                                    {{-- TEXTAREA --}}
                                @elseif ($field->field_type == 'textarea')
                                    <textarea class="form-control" name="{{ $name }}" {{ $field->is_required ? 'required' : '' }}>{{ $value }}</textarea>

                                    {{-- NUMBER --}}
                                @elseif ($field->field_type == 'number')
                                    <input type="number" class="form-control" name="{{ $name }}"
                                        value="{{ $value }}" {{ $field->is_required ? 'required' : '' }}>

                                    {{-- SELECT --}}
                                @elseif ($field->field_type == 'select')
                                    <select class="form-control" name="{{ $name }}"
                                        {{ $field->is_required ? 'required' : '' }}>

                                        <option value="">--select--</option>

                                        @foreach ($options as $opt)
                                            <option value="{{ $opt }}"
                                                {{ $value == $opt ? 'selected' : '' }}>
                                                {{ $opt }}
                                            </option>
                                        @endforeach
                                    </select>

                                    {{-- CHECKBOX --}}
                                @elseif ($field->field_type == 'checkbox')
                                    <div class="row mx-0 py-2">
                                        @foreach ($options as $opt)
                                            @php
                                                $checkedValues = is_array($value) ? $value : [];
                                                $id = $field->field_name . '_' . Str::slug($opt);
                                            @endphp

                                            <div class="form-check col-4">
                                                <label class="form-check-label" for="{{ $id }}">
                                                    {{ $opt }}
                                                    <input type="checkbox"
                                                        name="{{ $field->field_name }}[{{ $variant['variant_id'] }}][]"
                                                        value="{{ $opt }}" id="{{ $id }}"
                                                        class="form-check-input"
                                                        {{ in_array($opt, $checkedValues) ? 'checked' : '' }}>
                                                    <i class="input-helper"></i>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- RADIO --}}
                                @elseif ($field->field_type == 'radio')
                                    <div class="row">
                                        @foreach ($options as $opt)
                                            @php $id = $field->field_name.'_'.Str::slug($opt); @endphp

                                            <div class="form-check col-4">
                                                <input type="radio" name="{{ $name }}"
                                                    value="{{ $opt }}" id="{{ $id }}"
                                                    class="form-check-input" {{ $value == $opt ? 'checked' : '' }}>
                                                <i class="input-helper"></i>
                                                <label class="form-check-label" for="{{ $id }}">
                                                    {{ $opt }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- DATE --}}
                                @elseif ($field->field_type == 'date')
                                    <input type="date" class="form-control" name="{{ $name }}"
                                        value="{{ $value }}">

                                    {{-- FILE --}}
                                @elseif ($field->field_type == 'file')
                                    <input type="file" class="form-control image-input" name="{{ $field->field_name }}[{{ $variant['variant_id'] }}][]" multiple>
                                @endif

                            </div>
                        </div>
                    @endforeach

                    {{-- ACTION BUTTONS --}}

                    <div class="col-md-12 d-flex flex-wrap justify-content-between align-items-start">
                        <div class="preview-container d-flex flex-wrap gap-2">
                            @if (!empty($variant_images[$variant['variant_id']]) && is_array($variant_images[$variant['variant_id']]))
                                            @foreach ($variant_images[$variant['variant_id']] as $image)
                                                @if (is_string($image) && $image !== '')
                                                    <div class="image-wrapper" data-path="{{ $image }}"
                                                        style="display:inline-block; position:relative;">
                                                        <img src="{{ asset('uploads/products/' . $image) }}"
                                                            class="preview-image"
                                                            style="width:70px; height:70px; border:1px solid #ddd; border-radius:5px; margin-right:5px;">
                                                        <div onclick="removeImage(this)"
                                                            class="btn btn-danger btn-sm remove-image"
                                                            style="position:absolute; top:-8px; right:0px; border-radius:50%; line-height:0.9; padding:2px 5px; width:20px; height:20px;">
                                                            ×
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                        </div>
                        <div class="text-right align-self-center">
                            <button type="button" class="btn btn-sm btn-success add-variant">Add
                                More</button>
                            <button type="button" class="btn btn-danger btn-sm remove-variant">Remove</button>
                        </div>
                    </div>

                </div>
            @endforeach

        </div>
    </div>
@endif
