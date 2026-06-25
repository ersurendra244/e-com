@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    @include('admin.common.message')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="{{ roleRoute('subcategory') }}" class="btn btn-sm btn-dark float-right">Go Back</a>
                    <h4 class="card-title">{{ $title }}</h4>
                    <form action="{{ roleRoute('subcategory.update', $edit_data->id) }}" method="post"
                        enctype="multipart/form-data">
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
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="category">Category</label>
                                    <select name="category" onchange="getCategoryItems(this.value);" class="form-control" id="category">
                                        <option value="">--select--</option>
                                        <option value="0">None</option>
                                        @foreach ($categories as $key => $value)
                                            <option
                                                {{ isset($edit_data->category) && $edit_data->category == $value->id ? 'selected' : '' }}
                                                value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                        <span class="text-danger">{{ $errors->first('category') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex flex-row">
                                    <img id="output" src="{{ asset('uploads/categories/' . $edit_data->image) }}"
                                        style="width: 70px; height: 70px; border: 1px solid #ddd; border-radius: 5px;" />
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="form-label" for="image">Image</label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="image" name="image"
                                                    onchange="loadFile(event)" />
                                            </div>
                                            @if ($errors->has('image'))
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter description">{{ $edit_data->description ?? old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="order">Order By</label>
                                    <input type="number" class="form-control" id="order" name="order"
                                        placeholder="Enter order" value="{{ $edit_data->order ?? '' }}" min="1">
                                    @if ($errors->has('order'))
                                        <span class="text-danger">{{ $errors->first('order') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="is_home">Is Home</label>
                                    <select name="is_home" class="form-control" id="is_home">
                                        <option
                                            {{ isset($edit_data->is_home) && $edit_data->is_home == 1 ? 'selected' : '' }}
                                            value="1">Publish</option>
                                        <option
                                            {{ isset($edit_data->is_home) && $edit_data->is_home == 0 ? 'selected' : '' }}
                                            value="0">Unpublish</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="status">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option
                                            {{ isset($edit_data->status) && $edit_data->status == 1 ? 'selected' : '' }}
                                            value="1">Active
                                        </option>
                                        <option
                                            {{ isset($edit_data->status) && $edit_data->status == 0 ? 'selected' : '' }}
                                            value="0">Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('child_scripts')

    <script>
        const loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.style.display = 'block';
        };
    </script>
@endpush
