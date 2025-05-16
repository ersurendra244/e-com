@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    @include('admin.common.message')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.items') }}" class="btn btn-sm btn-dark float-right">Go Back</a>
                    <h4 class="card-title">{{ $title }}</h4>
                    <form action="{{ route('admin.items.update', $edit_data->slug ) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter name" value="{{ $edit_data->name ?? '' }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="status">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option {{ isset($edit_data->status) && $edit_data->status == 1 ? 'selected' : '' }}
                                            value="1">Active
                                        </option>
                                        <option {{ isset($edit_data->status) && $edit_data->status == 0 ? 'selected' : '' }}
                                            value="0">Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Sub Categories</label>
                                </div>
                            </div>
                            @php
                                $selected = is_array($edit_data->sub_cat_id) ? $edit_data->sub_cat_id : [];
                            @endphp
                            @foreach ($subcategories as $key => $subcategory)
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="sub_cat_id[]" value="{{ $subcategory->id }}"
                                                    {{ in_array($subcategory->id, $selected ?? []) ? 'checked' : '' }}>
                                                {{ $subcategory->name }}
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
