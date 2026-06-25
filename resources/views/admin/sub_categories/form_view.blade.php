@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="{{ roleRoute('subcategory.form_fields', $subcategory->slug) }}"
                        class="btn btn-sm btn-dark float-right">Go Back</a>
                    <h3 class="card-title">{{ $title }}</h3>
                    <div class="row">
                        @foreach ($form_fields as $field)
                            @php
                                $options = $field->field_options ?? [];
                                $col = $field->row_class ?? '12';
                            @endphp

                            <div class="col-md-{{ $col }}">
                                <div class="form-group">

                                    <label class="form-label" for="{{ $field->field_name }}">
                                        {{ $field->field_label }}
                                    </label>

                                    {{-- TEXT --}}
                                    @if ($field->field_type == 'text')
                                        <input type="text" class="form-control {{ $field->field_class ?? '' }}"
                                            name="{{ $field->field_name }}" id="{{ $field->field_name }}"
                                            value="{{ old($field->field_name) }}"
                                            placeholder="Enter {{ $field->field_label }}"
                                            {{ $field->is_required ? 'required' : '' }}>

                                        {{-- TEXTAREA --}}
                                    @elseif ($field->field_type == 'textarea')
                                        <textarea class="form-control {{ $field->field_class ?? '' }}" name="{{ $field->field_name }}"
                                            id="{{ $field->field_name }}" placeholder="Enter {{ $field->field_label }}"
                                            {{ $field->is_required ? 'required' : '' }}>{{ old($field->field_name) }}</textarea>

                                        {{-- NUMBER --}}
                                    @elseif ($field->field_type == 'number')
                                        <input type="number" class="form-control {{ $field->field_class ?? '' }}"
                                            name="{{ $field->field_name }}" id="{{ $field->field_name }}"
                                            value="{{ old($field->field_name) }}"
                                            {{ $field->is_required ? 'required' : '' }}>

                                        {{-- SELECT --}}
                                    @elseif ($field->field_type == 'select')
                                        <select class="form-control {{ $field->field_class ?? '' }}"
                                            name="{{ $field->field_name }}" id="{{ $field->field_name }}"
                                            {{ $field->is_required ? 'required' : '' }}>

                                            <option value="">-- Select --</option>

                                            @foreach ($options as $option)
                                                <option value="{{ $option }}"
                                                    {{ old($field->field_name) == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>

                                        {{-- CHECKBOX --}}
                                    @elseif ($field->field_type == 'checkbox')
                                        <div class="row mx-0 py-2">
                                            @foreach ($options as $index => $option)
                                                @php $id = $field->field_name.'_'.Str::slug($option); @endphp

                                                <div class="form-check col-4">
                                                    <label class="form-check-label" for="{{ $id }}">
                                                        {{ $option }}
                                                        <input type="checkbox"
                                                        class="form-check-input {{ $field->field_class ?? '' }}"
                                                        id="{{ $id }}" name="{{ $field->field_name }}[]"
                                                        value="{{ $option }}"
                                                        {{ is_array(old($field->field_name)) && in_array($option, old($field->field_name)) ? 'checked' : '' }}
                                                        {{ $field->is_required && $index == 0 ? 'required' : '' }}>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- RADIO --}}
                                    @elseif ($field->field_type == 'radio')
                                        <div class="row">
                                            @foreach ($options as $index => $option)
                                                @php $id = $field->field_name.'_'.Str::slug($option); @endphp

                                                <div class="form-check col-4">
                                                    <input type="radio"
                                                        class="form-check-input {{ $field->field_class ?? '' }}"
                                                        id="{{ $id }}" name="{{ $field->field_name }}"
                                                        value="{{ $option }}"
                                                        {{ old($field->field_name) == $option ? 'checked' : '' }}
                                                        {{ $field->is_required && $index == 0 ? 'required' : '' }}>

                                                    <label class="form-check-label" for="{{ $id }}">
                                                        {{ $option }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- DATE --}}
                                    @elseif ($field->field_type == 'date')
                                        <input type="date" class="form-control {{ $field->field_class ?? '' }}"
                                            name="{{ $field->field_name }}" id="{{ $field->field_name }}"
                                            value="{{ old($field->field_name) }}"
                                            {{ $field->is_required ? 'required' : '' }}>

                                        {{-- FILE --}}
                                    @elseif ($field->field_type == 'file')
                                        <input type="file" class="form-control {{ $field->field_class ?? '' }}"
                                            name="{{ $field->field_name }}" id="{{ $field->field_name }}"
                                            {{ $field->is_required ? 'required' : '' }}>
                                    @endif

                                </div>
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
