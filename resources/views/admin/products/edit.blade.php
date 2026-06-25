@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    <script>
        const allColors = @json(colors());
    </script>
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
                    <a href="{{ roleRoute('products') }}" class="btn btn-sm btn-dark float-right">Go Back</a>
                    <h3 class="card-title">{{ $title }}</h3>
                    <form action="{{ roleRoute('products.update', $edit_data->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="Enter title"
                                        value="{{ !empty($edit_data->title) ? $edit_data->title : old('title') }}">
                                    @if ($errors->has('title'))
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="sub_title">Sub Title</label>
                                    <input type="text" class="form-control" id="sub_title" name="sub_title"
                                        placeholder="Enter sub title"
                                        value="{{ !empty($edit_data->sub_title) ? $edit_data->sub_title : old('sub_title') }}">
                                    @if ($errors->has('sub_title'))
                                        <span class="text-danger">{{ $errors->first('sub_title') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="main_cat_id">Main Category</label>
                                    <select onchange="getCategories(this);" name="main_cat_id" class="form-control"
                                        id="main_cat_id">
                                        <option value="">--select--</option>
                                        @foreach ($categories as $key => $main_category)
                                            <option {{ $edit_data->main_cat_id == $main_category->id ? 'selected' : '' }}
                                                value="{{ $main_category->id }}">{{ $main_category->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('main_cat_id'))
                                        <span class="text-danger">{{ $errors->first('main_cat_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="cat_id">Category</label>
                                    <select onchange="getSubCategories(this);" name="cat_id" class="form-control"
                                        id="cat_id">
                                        <option value="">--select--</option>
                                    </select>
                                    @if ($errors->has('cat_id'))
                                        <span class="text-danger">{{ $errors->first('cat_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="sub_cat_id">Sub Category</label>
                                    <select onchange="getFormFields(this);" name="sub_cat_id" class="form-control"
                                        id="sub_cat_id">
                                        <option value="">--select--</option>
                                    </select>
                                    @if ($errors->has('sub_cat_id'))
                                        <span class="text-danger">{{ $errors->first('sub_cat_id') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="price">Price</label>
                                    <input type="text" class="form-control" id="price" name="price"
                                        placeholder="Enter price"
                                        value="{{ !empty($edit_data->price) ? $edit_data->price : old('price') }}">
                                    @if ($errors->has('price'))
                                        <span class="text-danger">{{ $errors->first('price') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="base_price">Base Price</label>
                                    <input type="text" class="form-control" id="base_price" name="base_price"
                                        placeholder="Enter base price"
                                        value="{{ !empty($edit_data->base_price) ? $edit_data->base_price : old('base_price') }}">
                                    @if ($errors->has('base_price'))
                                        <span class="text-danger">{{ $errors->first('base_price') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex">
                                    <div class="form-group">
                                        <label class="form-label" for="image">Main Image</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control mr-1" id="image" name="image"
                                                onchange="loadFile(event)" />
                                        </div>
                                        @if ($errors->has('image'))
                                            <span class="text-danger">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                    <img id="output" src="{{ asset('uploads/products/' . $edit_data->image) }}"
                                        style="width: 70px; height: 70px; border: 1px solid #ddd; border-radius: 5px;" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="status">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option {{ $edit_data->status == 1 ? 'selected' : '' }} value="1">Active
                                        </option>
                                        <option {{ $edit_data->status == 0 ? 'selected' : '' }} value="0">Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <p class="form-label" for="">Collections</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input {{ $edit_data->is_featured == 1 ? 'checked' : '' }}
                                                        type="checkbox" class="form-check-input" name="is_featured"
                                                        value="1">
                                                    Featured<i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input {{ $edit_data->is_trending == 1 ? 'checked' : '' }}
                                                        type="checkbox" class="form-check-input" name="is_trending"
                                                        value="1">
                                                    Trending<i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="form-fields-container">
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea name="description" class="form-control summernote" id="description" rows="10"> {!! !empty($edit_data->description) ? $edit_data->description : '' !!}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="highlights">Highlights</label>
                                    <textarea name="highlights" class="form-control summernote" id="highlights" rows="15">{!! !empty($edit_data->highlights) ? $edit_data->highlights : '' !!}</textarea>
                                    @if ($errors->has('highlights'))
                                        <span class="text-danger">{{ $errors->first('highlights') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="specifications">Specifications</label>
                                    <textarea name="specifications" class="form-control summernote" id="specifications" rows="15">{!! !empty($edit_data->specifications) ? $edit_data->specifications : '' !!}</textarea>
                                    @if ($errors->has('specifications'))
                                        <span class="text-danger">{{ $errors->first('specifications') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
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
    <script>
        const loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.style.display = 'block';
        };
    </script>
    <script>
        function removeImage(element) {
            if (!confirm('Are you sure you want to delete this image?')) return;
            const wrapper = element.closest('.image-wrapper');
            const imagePath = wrapper.getAttribute('data-path');
            const variantGroup = element.closest('.variant-group');
            const variantIdInput = variantGroup.querySelector('input[name="variant_id[]"]');
            if (imagePath && variantIdInput) {
                const variantId = variantIdInput.value;
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `remove_images[${variantId}][]`;
                input.value = imagePath;
                variantGroup.appendChild(input);
            }
            wrapper.remove();
        }
    </script>
    <script>
        $(document).ready(function() {
            toggleButtons();
            // Image preview handler
            $(document).on('change', '.image-input', function(event) {
                const input = event.target;
                const files = input.files;
                const $container = $(input).closest('.variant-group').find('.preview-container');
                // $container.empty(); // Clear old previews

                Array.from(files).forEach(file => {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.style.width = '70px';
                    img.style.height = '70px';
                    img.style.border = '1px solid #ddd';
                    img.style.borderRadius = '5px';
                    img.style.marginRight = '5px';
                    img.onload = () => URL.revokeObjectURL(img.src);
                    $container.append(img);
                });
            });

            // Clone variant with reset
            $(document).on('click', '.add-variant', function() {
                const $lastVariant = $('.variant-group').last();
                const $newVariant = $lastVariant.clone();

                const newIndex = $('.variant-group').length + 1;

                $newVariant.find('input, select, textarea').each(function() {
                    const $input = $(this);
                    const nameAttr = $input.attr('name');
                    const idAttr = $input.attr('id');

                    if (nameAttr) $input.attr('name', nameAttr.replace(/\[\d+\]/, `[${newIndex}]`));
                    if (idAttr) $input.attr('id', idAttr.replace(/_\d+$/, `_${newIndex}`));

                    if ($input.is(':checkbox, :radio')) $input.prop('checked', false);
                    else $input.val('');
                });

                $newVariant.find('.preview-container').empty();
                $newVariant.find('input[name^="variant_id"]').val(newIndex);
                $('#variant-wrapper').append($newVariant);
                toggleButtons();
            });

            $(document).on('click', '.remove-variant', function() {
                if (!confirm('Are you sure you want to delete this variant?')) return;
                const $group = $(this).closest('.variant-group');
                if ($('.variant-group').length > 1) {
                    $group.remove();
                    toggleButtons();
                } else {
                    alert('At least one variant is required.');
                }
            });

        });

        function toggleButtons() {
            const $variants = $('.variant-group');
            $variants.each(function(index) {
                const isLast = index == $variants.length - 1;
                const $remove = $(this).find('.remove-variant');
                const $add = $(this).find('.add-variant');
                $remove.toggle($variants.length > 1);
                $add.toggle(isLast);
            });
        }
    </script>
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
        function getCategories(selector) {
            var main_cat_id = $(selector).val();

            $('#cat_id').html('<option value="">--select--</option>');
            $('#form-fields-container').html('');

            if (main_cat_id) {
                $.ajax({
                    url: "{{ roleRoute('product.get_categories') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        main_cat_id: main_cat_id,
                        product_id: "{{ $edit_data->id }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#cat_id').html(response.html);
                        }
                    }
                });
            }
        }

        function getSubCategories(selector) {
            var cat_id = $(selector).val();

            $('#sub_cat_id').html('<option value="">--select--</option>');
            $('#form-fields-container').html('');

            if (cat_id) {
                $.ajax({
                    url: "{{ roleRoute('product.get_sub_categories') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        cat_id: cat_id,
                        product_id: "{{ $edit_data->id }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#sub_cat_id').html(response.html);
                        }
                    }
                });
            }
        }

        function getFormFields(selector) {
            var sub_cat_id = $(selector).val();
            if (!sub_cat_id) {
                $('#form-fields-container').html('');
                return;
            }

            $.ajax({
                url: "{{ roleRoute('product.get_form_fields') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: "{{ $edit_data->id }}",
                    sub_cat_id: sub_cat_id
                },
                success: function(response) {
                    if (response.success) {
                        $('#form-fields-container').html(response.html);
                        if ($(".summernote").length) {
                            $(".summernote").each(function() {
                                // Destroy previous instance if exists
                                if ($(this).next().hasClass('note-editor')) {
                                    $(this).summernote('destroy');
                                }

                                // Initialize again
                                $(this).summernote({
                                    height: 300,
                                    tabsize: 2
                                });
                            });
                        }
                    }
                }
            });
        }

        $(document).ready(function() {
            getCategories('#main_cat_id');
            setTimeout(function() {
                getSubCategories('#cat_id');
                setTimeout(function() {
                    getFormFields('#sub_cat_id')
                }, 1000);
            }, 1000);
        });
    </script>
@endpush
