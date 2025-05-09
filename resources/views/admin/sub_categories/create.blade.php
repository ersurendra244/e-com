@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    <style>
        .select2-container .select2-selection--multiple .select2-selection__rendered {
            display: inline-block ! important;
            padding-right: 5px ! important;
        }
        .select2-container--default .select2-selection--multiple {
            padding-bottom: 0px ! important;
            border: solid #e0e0ef 1px !important;
            min-height: calc(2.25rem + 10px) !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            padding: 10px 5px ! important;
            font-size: small ! important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            position: relative !important;
            padding: 0 3px !important;
        }
    </style>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @include('admin.common.message')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.subcategory') }}" class="btn btn-sm btn-dark float-right">Go Back</a>
                    <h4 class="card-title">{{ $title }}</h4>
                    <form action="{{ route('admin.subcategory.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="cat_id">Category</label>
                                    <select name="cat_id" class="form-control" id="cat_id">
                                        <option value="">--select--</option>
                                        <option value="0">None</option>
                                        @foreach ($categories as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('cat_id'))
                                        <span class="text-danger">{{ $errors->first('cat_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="item_type">Item Type</label>
                                    <select name="item_type[]" class="form-control" id="item_type" multiple size="3">
                                        <option value="">--select--</option>
                                        @foreach ($item_types as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('item_type'))
                                        <span class="text-danger">{{ $errors->first('item_type') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex flex-row">
                                    <img id="output" src=""
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
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter description">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="order">Order By</label>
                                    <input type="number" class="form-control" id="order" name="order"
                                        placeholder="Enter order" value="{{ old('order') }}" min="1">
                                    @if ($errors->has('order'))
                                        <span class="text-danger">{{ $errors->first('order') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="is_home">Is Home</label>
                                    <select name="is_home" class="form-control" id="is_home">
                                        <option value="1">Publish</option>
                                        <option value="0">Unpublish</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="status">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="1">Active
                                        </option>
                                        <option value="0">Inactive
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
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#item_type').select2({
                placeholder: "Select Item Types",
                allowClear: true
            });
        });
    </script>
    <script>
        const loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.style.display = 'block';
        };
    </script>
@endpush
