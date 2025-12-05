@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    @include('admin.common.message')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.subcategory') }}" class="btn btn-sm btn-dark float-right">Go Back</a>
                    <h4 class="card-title">{{ $title }}</h4>
                    <form action="{{ route('admin.subcategory.form_update', $edit_data->slug) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Select Fields for Product Form</label>
                            </div>
                        </div>
                        @php
                            $allFields = fields();
                            $selected = $edit_data->form_fields ?? [];
                        @endphp
                        @foreach ($allFields as $key => $field)
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="form_fields[]"
                                                {{ in_array($field, $selected) ? 'checked' : '' }}
                                                value="{{ $field }}">{{ ucfirst($field) }}
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('child_scripts')
@endpush
