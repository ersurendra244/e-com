@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.subcategory.form_fields', $subcategory->slug) }}"
                        class="btn btn-sm btn-dark float-right">Go Back</a>
                    <h3 class="card-title">{{ $title }}</h3>
                    <div class="row">
                        @foreach ($selected as $field)
                            @if ($field->formField->field_type == 'text')
                                <div class="col-md-{{ $field->row_class ?? '6' }}">
                                    <div class="form-group">
                                        <label class="form-label"
                                            for="{{ $field->formField->field_name }}">{{ $field->formField->field_label }}</label>
                                        <input type="text" class="form-control {{ $field->field_class ?? '' }}"
                                            id="{{ $field->formField->field_name }}"
                                            name="{{ $field->formField->field_name }}"
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
                                            name="{{ $field->formField->field_name }}" placeholder="Enter {{ $field->formField->field_label }}"
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
                                            name="{{ $field->formField->field_name }}"
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
                                            name="{{ $field->formField->field_name }}"
                                            {{ $field->is_required == 1 ? 'required' : '' }}>
                                            <option value="">--select--</option>
                                            @php
                                                $options = json_decode($field->formField->field_options, true);
                                                // If JSON decoding fails (maybe stored as newline-separated string), fallback to splitting by newlines
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
                                            // If JSON decoding fails (maybe stored as newline-separated string), fallback to splitting by newlines
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
                                                        name="{{ $field->formField->field_name }}[]"
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
                                            // If JSON decoding fails (maybe stored as newline-separated string), fallback to splitting by newlines
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
                                                        name="{{ $field->formField->field_name }}"
                                                        value="{{ $option }}"
                                                        {{ old($field->formField->field_name) == $option ? 'checked' : '' }}
                                                        {{ $field->is_required == 1 && $index == 0 ? 'required' : '' }}>
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
                                            name="{{ $field->formField->field_name }}"
                                            value="{{ old($field->formField->field_name) }}"
                                            {{ $field->is_required == 1 ? 'required' : '' }}>
                                    </div>
                                </div>
                            @elseif ($field->formField->field_type == 'file')
                                <div class="col-md-{{ $field->row_class ?? '6' }}">
                                    <div class="form-group">
                                        <label class="form-label"
                                            for="{{ $field->formField->field_name }}">{{ $field->formField->field_label }}</label>
                                        <input type="file" class="form-control {{ $field->field_class ?? '' }}"
                                            id="{{ $field->formField->field_name }}"
                                            name="{{ $field->formField->field_name }}"
                                            value="{{ old($field->formField->field_name) }}"
                                            {{ $field->is_required == 1 ? 'required' : '' }}>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('child_scripts')
@endpush
