@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
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
    <style>
        .image-container-box {
            width: 100%;
            height: 200px;
            border: 2px dashed #e0e0ef;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .preview-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }

        .upload-text {
            color: #777;
            font-size: 14px;
        }

        /* Remove Button */
        .btn-remove {
            position: absolute;
            top: 5px;
            left: 5px;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            z-index: 10;
        }

        /* Add More Button */
        .btn-add-more {
            position: absolute;
            top: 5px;
            right: 5px;
            background: green;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            z-index: 10;
        }
    </style>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.products') }}" class="btn btn-sm btn-dark float-right">Go Back</a>
                    <h3 class="card-title">{{ $title }}</h3>
                    <form action="{{ route('admin.products.update', $data->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter name" value="{{ $data->name ?? '' }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="category">Category</label>
                                    <select name="category" class="form-control" id="category">
                                        <option value="">Choose a category</option>
                                        @foreach ($categories as $key => $category)
                                            <option {{ !empty($data->category) && $data->category == $category->name ? 'selected' : '' }} value="{{ $category->name }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                        <span class="text-danger">{{ $errors->first('category') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="color">Color</label>
                                    <select name="color" class="form-control" id="color">
                                        <option value="">Choose a color</option>
                                        @php $colors = colors(); @endphp
                                        @foreach ($colors as $key => $color)
                                            <option {{ !empty($data->variants[0]->color) && $data->variants[0]->color == $key ? 'selected' : '' }} value="{{ $key }}">{{ $color }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('color'))
                                        <span class="text-danger">{{ $errors->first('color') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="size">Size</label>
                                    <select name="size" class="form-control" id="size">
                                        <option value="">Choose a size</option>
                                        @php $sizes = sizes(); @endphp
                                        @foreach ($sizes as $key => $size)
                                            <option {{ !empty($data->variants[0]->size) && $data->variants[0]->size == $key ? 'selected' : '' }} value="{{ $key }}">{{ $size }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('size'))
                                        <span class="text-danger">{{ $errors->first('size') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="price">Price</label>
                                    <input type="text" class="form-control" id="price" name="price"
                                        placeholder="Enter price" value="{{ $data->variants[0]->price ?? '' }}">
                                    @if ($errors->has('price'))
                                        <span class="text-danger">{{ $errors->first('price') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="stock">Stock</label>
                                    <input type="number" class="form-control" id="stock" name="stock"
                                        placeholder="Enter stock" value="{{ $data->variants[0]->stock ?? '' }}" min="0">
                                    @if ($errors->has('stock'))
                                        <span class="text-danger">{{ $errors->first('stock') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="status">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option {{ !empty($data->status) && $data->status == 1 ? 'selected' : '' }}
                                            value="1">Active
                                        </option>
                                        <option {{ !empty($data->status) && $data->status == 0 ? 'selected' : '' }}
                                            value="0">Inactive
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
                                                    <input
                                                        {{ !empty($data->is_featured) && $data->is_featured == 1 ? 'checked' : '' }}
                                                        type="checkbox" class="form-check-input" name="is_featured"
                                                        value="1">
                                                    Featured<i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input
                                                        {{ !empty($data->is_trending) && $data->is_trending == 1 ? 'checked' : '' }}
                                                        type="checkbox" class="form-check-input" name="is_trending"
                                                        value="1">
                                                    Trending<i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3" id="image-container">
                            @if (!empty($data->images))
                                @foreach ($data->images as $key => $image)
                                    <div class="col-md-3 image-box">
                                        <label class="form-label" for="">Image {{ $key+1 }}</label>
                                        <div class="image-container-box"
                                            onclick="this.querySelector('.image-input').click()">
                                            <span class="btn-remove"
                                                onclick="removeImage(event, '{{ $key }}')">&times;</span>
                                            <span class="btn-add-more" onclick="addMoreImage(event)">+</span>
                                            <img class="preview-image" src="{{ asset('uploads/products/' . $image) }}" />
                                            <p class="upload-text">Click and upload an image</p>
                                            <input type="file" class="image-input" name="images[{{ $key }}]"
                                                accept="image/*" onchange="loadFile(event)" />
                                            <input type="hidden" name="existing_images[{{ $key }}]"
                                                value="{{ $image }}" />
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-md-3 image-box">
                                    <label class="form-label" for="">Image 1</label>
                                    <div class="image-container-box" onclick="this.querySelector('.image-input').click()">
                                        <span class="btn-remove d-none" onclick="removeImage(event)">&times;</span>
                                        <span class="btn-add-more" onclick="addMoreImage(event)">+</span>
                                        <img class="preview-image d-none" />
                                        <p class="upload-text">Click and upload an image</p>
                                        <input type="file" class="image-input d-none" name="images[]"
                                            accept="image/*" onchange="loadFile(event)" />
                                    </div>
                                </div>
                            @endif
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
                                    <div class="col-md-6">
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
                                    <div class="col-md-6">
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="">Short Description</label>
                                    <textarea name="short_description" class="form-control" id="short_description" rows="3">{{ $data->short_description ?? '' }}</textarea>
                                    @if ($errors->has('short_description'))
                                        <span class="text-danger">{{ $errors->first('short_description') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="full_description">Description</label>
                                    <textarea name="full_description" class="form-control summernote" id="full_description" rows="15">{{ $data->full_description ?? '' }}</textarea>
                                    @if ($errors->has('full_description'))
                                        <span class="text-danger">{{ $errors->first('full_description') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="add_description">Additional Information</label>
                                    <textarea name="add_description" class="form-control summernote" id="add_description" rows="15">{{ $data->add_description ?? '' }}</textarea>
                                    @if ($errors->has('add_description'))
                                        <span class="text-danger">{{ $errors->first('add_description') }}</span>
                                    @endif
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
        $(document).ready(function() {
            $("input[name='is_rateing']").change(function() {
                if ($("input[name='is_rateing']:checked").val()) {
                    $("#reviews-container").removeClass("d-none").fadeIn();
                } else {
                    $("#reviews-container").fadeOut();
                }
            });
            if ($(".summernote").length) {
                $('.summernote').summernote({
                    height: 300,
                    tabsize: 2
                });
            }
        });
    </script>
    <script>
        function loadFile(event) {
            var input = event.target;
            var dropzone = input.closest('.image-container-box');
            var image = dropzone.querySelector('.preview-image');
            var removeBtn = dropzone.querySelector('.btn-remove');

            if (input.files.length > 0) {
                image.src = URL.createObjectURL(input.files[0]);
                image.classList.remove('d-none');
                removeBtn.classList.remove('d-none');
                dropzone.querySelector('.upload-text').classList.add('d-none');
            }
            updateButtons();
        }

        function removeImage(event, key = null) {
            event.stopPropagation();
            var imageBox = event.target.closest('.image-box');

            if (key !== null) {
                var hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = "remove_images[]";
                hiddenInput.value = key;
                imageBox.appendChild(hiddenInput);
            }

            imageBox.remove();
            updateButtons();
        }

        function addMoreImage(event) {
            event.stopPropagation();
            var container = document.getElementById('image-container');
            var existingBoxes = container.querySelectorAll('.image-box');

            if (existingBoxes.length >= 4) {
                alert("You can only upload a maximum of 4 images.");
                return;
            }

            var newBox = document.createElement('div');
            newBox.classList.add('col-md-3', 'image-box');
            newBox.innerHTML = `
                <label class="form-label" for="">Image ${existingBoxes.length + 1}</label>
                <div class="image-container-box" onclick="this.querySelector('.image-input').click()">
                    <span class="btn-remove" onclick="removeImage(event)">&times;</span>
                    <span class="btn-add-more" onclick="addMoreImage(event)">+</span>
                    <img class="preview-image d-none" />
                    <p class="upload-text">Click and upload an image</p>
                    <input type="file" class="image-input d-none" name="images[]" accept="image/*" onchange="loadFile(event)" />
                </div>
            `;

            container.appendChild(newBox);
            updateButtons();
        }

        function updateButtons() {
            var boxes = document.querySelectorAll('.image-box');
            var totalBoxes = boxes.length;

            boxes.forEach((box, index) => {
                var addMoreBtn = box.querySelector('.btn-add-more');
                var removeBtn = box.querySelector('.btn-remove');

                // Show add button only in the last box if less than 4 boxes exist
                addMoreBtn.classList.toggle('d-none', totalBoxes >= 4 || index !== totalBoxes - 1);

                // Show remove button on all except when only one box is left
                removeBtn.classList.toggle('d-none', totalBoxes === 1);
            });
        }

        document.addEventListener("DOMContentLoaded", updateButtons);
    </script>
@endpush
