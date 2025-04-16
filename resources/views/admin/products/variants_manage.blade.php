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
                    <a href="{{ route('admin.products.variants', $productData->id?? '') }}" class="btn btn-sm btn-dark float-right">Go Back</a>
                    <h3 class="card-title">{{ $title }}</h3>
                    <form action="{{ route('admin.products.variants_save') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="name">Product Name</label>
                                    <input readonly type="text" class="form-control" id="name" name="name" value="{{ $productData->name ?? '' }}">
                                    <input type="hidden" class="form-control" id="product_id" name="product_id"
                                        value="{{ $productData->id ?? '' }}">
                                    <input type="hidden" class="form-control" id="edit_id" name="edit_id"
                                        value="{{ $variantData->id?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="category">Category</label>
                                    <input readonly type="text" class="form-control" id="category" name="category"
                                        placeholder="Enter category" value="{{ $productData->category ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="color">Color</label>
                                    <select name="color" class="form-control" id="color">
                                        <option value="">Choose a color</option>
                                        @php $colors = colors(); @endphp
                                        @foreach ($colors as $key => $color)
                                            <option {{ !empty($variantData->color) && $variantData->color == $key ? 'selected' : '' }} value="{{ $key }}">{{ $color }}</option>
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
                                            <option {{ !empty($variantData->size) && $variantData->size == $key ? 'selected' : '' }} value="{{ $key }}">{{ $size }}</option>
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
                                        placeholder="Enter price" value="{{ $variantData->price ?? '' }}">
                                    @if ($errors->has('price'))
                                        <span class="text-danger">{{ $errors->first('price') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="stock">Stock</label>
                                    <input type="number" class="form-control" id="stock" name="stock"
                                        placeholder="Enter stock" value="{{ $variantData->stock ?? '' }}" min="0">
                                    @if ($errors->has('stock'))
                                        <span class="text-danger">{{ $errors->first('stock') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="status">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option {{ !empty($variantData->status) && $variantData->status == 1 ? 'selected' : '' }}
                                            value="1">Active
                                        </option>
                                        <option {{ !empty($variantData->status) && $variantData->status == 0 ? 'selected' : '' }}
                                            value="0">Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3" id="image-container">
                            @if (!empty($variantData->images))
                                @foreach ($variantData->images as $key => $image)
                                    <div class="col-md-3 image-box">
                                        <label class="form-label" for="">Image {{ $key + 1 }}</label>
                                        <div class="image-container-box" onclick="this.querySelector('.image-input').click()">
                                            <span class="btn-remove" onclick="removeImage(event, '{{ $key }}')">&times;</span>
                                            <span class="btn-add-more" onclick="addMoreImage(event)">+</span>
                                            <img class="preview-image" src="{{ asset('uploads/products/' . $image) }}" />
                                            <p class="upload-text">Click and upload an image</p>
                                            <input type="file" class="image-input" name="images[{{ $key }}]" accept="image/*" onchange="loadFile(event)" />
                                            <input type="hidden" name="existing_images[{{ $key }}]" value="{{ $image }}" />
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
                                        <input type="file" class="image-input d-none" name="images[]" accept="image/*"
                                            onchange="loadFile(event)" />
                                    </div>
                                </div>
                            @endif
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
