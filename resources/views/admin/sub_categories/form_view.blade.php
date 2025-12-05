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
                        @foreach ($form_fields as $field)
                            <div class="col-md-6">
                                @if ($field->field_type == 'text')
                                    <div class="form-group">
                                        <label class="form-label"
                                            for="{{ $field->field_name }}">{{ $field->field_label }}</label>
                                        <input type="text" class="form-control" id="{{ $field->field_name }}"
                                            name="{{ $field->field_name }}" placeholder="Enter {{ $field->field_label }}"
                                            value="{{ old($field->field_name) }}">
                                    </div>
                                @elseif ($field->field_type == 'number')
                                    <div class="form-group">
                                        <label class="form-label"
                                            for="{{ $field->field_name }}">{{ $field->field_label }}</label>
                                        <input type="number" class="form-control" id="{{ $field->field_name }}"
                                            name="{{ $field->field_name }}" placeholder="Enter {{ $field->field_label }}"
                                            value="{{ old($field->field_name) }}">
                                    </div>
                                @elseif ($field->field_type == 'select')
                                    <div class="form-group">
                                        <label class="form-label"
                                            for="{{ $field->field_name }}">{{ $field->field_label }}</label>
                                        <select class="form-control" id="{{ $field->field_name }}"
                                            name="{{ $field->field_name }}">
                                            <option value="">Select {{ $field->field_label }}</option>
                                            @php
                                                $options = json_decode($field->field_options, true);
                                                // If JSON decoding fails (maybe stored as newline-separated string), fallback to splitting by newlines
                                                if (!is_array($options)) {
                                                    $options = preg_split("/\r\n|\n|\r/", $field->field_options);
                                                }
                                            @endphp
                                            @foreach ($options as $option)
                                                <option value="{{ $option }}"
                                                    {{ old($field->field_name) == $option ? 'selected' : '' }}>
                                                    {{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @elseif ($field->field_type == 'checkbox')
                                    <div class="form-group row mx-0">
                                        <label class="form-label col-12 px-0 pb-2"
                                            for="{{ $field->field_name }}">{{ $field->field_label }}</label>
                                        @php
                                            $options = json_decode($field->field_options, true);
                                            // If JSON decoding fails (maybe stored as newline-separated string), fallback to splitting by newlines
                                            if (!is_array($options)) {
                                                $options = preg_split("/\r\n|\n|\r/", $field->field_options);
                                            }
                                        @endphp
                                        @foreach ($options as $option)
                                            <div class="form-check col-4">
                                                <label class="form-check-label"
                                                    for="{{ $field->field_name }}_{{ $option }}">{{ $option }}
                                                    <input class="form-check-input" type="checkbox"
                                                        id="{{ $field->field_name }}_{{ $option }}"
                                                        name="{{ $field->field_name }}[]" value="{{ $option }}"
                                                        {{ is_array(old($field->field_name)) && in_array($option, old($field->field_name)) ? 'checked' : '' }}>
                                                    <i class="input-helper"></i>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif ($field->field_type == 'radio')
                                    <div class="form-group row mx-0">
                                        <label class="form-label col-12 px-0 pb-2"
                                            for="{{ $field->field_name }}">{{ $field->field_label }}</label>
                                        @php
                                            $options = json_decode($field->field_options, true);
                                            // If JSON decoding fails (maybe stored as newline-separated string), fallback to splitting by newlines
                                            if (!is_array($options)) {
                                                $options = preg_split("/\r\n|\n|\r/", $field->field_options);
                                            }
                                        @endphp
                                        @foreach ($options as $option)
                                            <div class="form-check col-4">
                                                <label class="form-check-label"
                                                    for="{{ $field->field_name }}_{{ $option }}">{{ $option }}
                                                    <input class="form-check-input" type="radio"
                                                        id="{{ $field->field_name }}_{{ $option }}"
                                                        name="{{ $field->field_name }}" value="{{ $option }}"
                                                        {{ old($field->field_name) == $option ? 'checked' : '' }}>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif ($field->field_type == 'date')
                                    <div class="form-group">
                                        <label class="form-label"
                                            for="{{ $field->field_name }}">{{ $field->field_label }}</label>
                                        <input type="date" class="form-control" id="{{ $field->field_name }}"
                                            name="{{ $field->field_name }}" value="{{ old($field->field_name) }}">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('child_scripts')
@endpush
