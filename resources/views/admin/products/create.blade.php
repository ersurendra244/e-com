@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
    @include('admin.common.message')

    <style>
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .rating input {
            display: none;
        }

        .rating label {
            font-size: 30px;
            color: gray;
            cursor: pointer;
        }

        .rating input:checked~label,
        .rating label:hover,
        .rating label:hover~label {
            color: gold;
        }
    </style>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.products') }}" class="btn btn-sm btn-dark float-right">Go Back</a>
                    <h3 class="card-title">{{ $title }}</h3>
                    <form action="{{ route('admin.products.save') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="name">Title</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="name">Sub Title</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="category">Category</label>
                                    <select onchange="getSubCategories(this);" name="category" class="form-control"
                                        id="category">
                                        <option value="">Choose a category</option>
                                        @foreach ($categories as $key => $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                        <span class="text-danger">{{ $errors->first('category') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="subcategory_id">Sub Category</label>
                                    <select onchange="getItems(this);" name="subcategory_id" class="form-control"
                                        id="subcategory_id">
                                        <option value="">Select Sub Category</option>
                                    </select>
                                    @if ($errors->has('subcategory_id'))
                                        <span class="text-danger">{{ $errors->first('subcategory_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="item_id">Item Type</label>
                                    <select onchange="getFormFields(this);" name="item_id" class="form-control" id="item_id">
                                        <option value="">Select Sub Category</option>
                                    </select>
                                    @if ($errors->has('item_id'))
                                        <span class="text-danger">{{ $errors->first('item_id') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row" id="form-fields-container">

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="stock">Stock</label>
                                    <input type="number" class="form-control" id="stock" name="stock"
                                        placeholder="Enter stock" value="{{ old('stock') }}" min="0">
                                    @if ($errors->has('stock'))
                                        <span class="text-danger">{{ $errors->first('stock') }}</span>
                                    @endif
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
                            <div class="col-md-6">
                                <label class="form-label" for="">Collections</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="is_featured"
                                                        value="1">
                                                    Featured<i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="is_trending"
                                                        value="1">
                                                    Trending<i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div id="my-dropzone" class="dropzone"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="is_rateing"
                                                value="1">
                                            If you want to rate and review this product.<i
                                                class="input-helper"></i></label>
                                    </div>
                                </div>
                                <div class="row d-none" id="reviews-container">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label" for="">Ratings</label>
                                            <div class="rating">
                                                <input type="radio" name="stars" id="star5"
                                                    value="5"><label for="star5">&#9733;</label>
                                                <input type="radio" name="stars" id="star4"
                                                    value="4"><label for="star4">&#9733;</label>
                                                <input type="radio" name="stars" id="star3"
                                                    value="3"><label for="star3">&#9733;</label>
                                                <input type="radio" name="stars" id="star2"
                                                    value="2"><label for="star2">&#9733;</label>
                                                <input type="radio" name="stars" id="star1"
                                                    value="1"><label for="star1">&#9733;</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label class="form-label" for="reviews">Review</label>
                                            <input type="text" class="form-control" id="reviews" name="reviews"
                                                placeholder="Enter reviews" value="{{ old('reviews') }}">
                                            @if ($errors->has('reviews'))
                                                <span class="text-danger">{{ $errors->first('reviews') }}</span>
                                            @endif
                                        </div>
                                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

    <script>
        $(document).ready(function() {
            $("input[name='is_rateing']").change(function() {
                if ($("input[name='is_rateing']:checked").val()) {
                    $("#reviews-container").removeClass("d-none").fadeIn();
                } else {
                    $("#reviews-container").fadeOut();
                }
            });
        });
    </script>
    <script>
        let myDropzone = new Dropzone("#my-dropzone", {
            url: "#", // prevent actual dropzone submit
            autoProcessQueue: false,
            uploadMultiple: true,
            addRemoveLinks: true,
            maxFilesize: 5,
            acceptedFiles: 'image/*',
            parallelUploads: 10,
            dictDefaultMessage: "Drag images here or click to upload",
        });

        document.querySelector("form").addEventListener("submit", function(e) {
            e.preventDefault();

            let form = this;
            let formData = new FormData(form);

            // Add Dropzone files to formData
            myDropzone.files.forEach(function(file, i) {
                formData.append('images[]', file, file.name);
            });

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = "{{ route('admin.products') }}";
                    } else if (data.errors) {
                        alert("Validation error");
                        console.log(data.errors);
                    } else {
                        alert("Error occurred");
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert("Unexpected error occurred");
                });
        });
    </script>


    <script>
        function getSubCategories(event) {
            var category_id = $(event).val();

            $('#subcategory_id').html('<option value="">Select Sub Category</option>');
            $('#form-fields-container').html('');

            $.ajax({
                url: "{{ route('admin.product.get_sub_categories') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    category_id: category_id
                },
                success: function(response) {
                    if (response.success) {
                        $('#subcategory_id').html(response.html);
                    }
                }
            });
        }

        function getItems(event) {
            var subcategory_id = $(event).val();

            $('#item_id').html('<option value="">Select Item Type</option>');
            $('#form-fields-container').html('');

            $.ajax({
                url: "{{ route('admin.product.get_sub_categories_items') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    subcategory_id: subcategory_id
                },
                success: function(response) {
                    if (response.success) {
                        $('#item_id').html(response.html);
                    }
                }
            });
        }

        function getFormFields(event) {
            var subcategory_id = $("#subcategory_id").val();
            var item_id = $(event).val();
            if (!subcategory_id) {
                $('#form-fields-container').html('');
                return;
            }

            $.ajax({
                url: "{{ route('admin.product.get_form_fields') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    subcategory_id: subcategory_id,
                    item_id: item_id
                },
                success: function(response) {
                    if (response.success) {
                        $('#form-fields-container').html(response.html);
                    }
                }
            });
        }
    </script>
@endpush
