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
                    <a href="{{ route('admin.products') }}" class="btn btn-sm btn-dark float-right">Go Back</a>
                    <h3 class="card-title">{{ $title }}</h3>
                    <form id="manageForm" action="{{ route('admin.products.save') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="Enter title" value="{{ old('title') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="sub_title">Sub Title</label>
                                    <input type="text" class="form-control" id="sub_title" name="sub_title"
                                        placeholder="Enter sub title" value="{{ old('sub_title') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="main_category">Main Category</label>
                                    <select onchange="getCategories(this);" name="main_category" class="form-control"
                                        id="main_category">
                                        <option value="">--select--</option>
                                        @foreach ($categories as $key => $main_category)
                                            <option value="{{ $main_category->id }}">{{ $main_category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="category">Category</label>
                                    <select onchange="getSubCategories(this);" name="category" class="form-control"
                                        id="category">
                                        <option value="">--select--</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="subcategory">Sub Category</label>
                                    <select onchange="getFormFields(this);" name="subcategory" class="form-control"
                                        id="subcategory">
                                        <option value="">--select--</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="price">Price</label>
                                    <input type="text" class="form-control" id="price" name="price"
                                        placeholder="Enter price" value="{{ old('price') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="base_price">Base Price</label>
                                    <input type="text" class="form-control" id="base_price" name="base_price"
                                        placeholder="Enter base price" value="{{ old('base_price') }}">
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
                                    </div>
                                    <img id="output" src=""
                                        style="width: 70px; height: 70px; border: 1px solid #ddd; border-radius: 5px;" />
                                </div>
                            </div>
                            <div class="col-md-4">
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
                            <div class="col-md-4">
                                <p class="form-label" for="">Collections</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="is_featured"
                                                        value="1">
                                                    Featured<i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
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

                        <div class="row" id="form-fields-container">


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

                // Get new index based on how many groups exist
                const newIndex = $('.variant-group').length;

                // Update name and id attributes
                $newVariant.find('input, select').each(function() {
                    const nameAttr = $(this).attr('name');
                    const idAttr = $(this).attr('id');

                    if (nameAttr) {
                        const updatedName = nameAttr.replace(/\[\d+\]/, `[${newIndex}]`);
                        $(this).attr('name', updatedName);
                    }

                    if (idAttr) {
                        const updatedId = idAttr.replace(/_\d+$/, `_${newIndex}`);
                        $(this).attr('id', updatedId);
                    }

                    if ($(this).is('input[type="number"]') || $(this).is('select')) {
                        $(this).val('');
                    }

                    if ($(this).hasClass('image-input')) {
                        $(this).val('');
                    }
                });

                // Clear image previews
                $newVariant.find('.preview-container').empty();
                $newVariant.find('input[name^="variant_id"]').val('');
                // Append and toggle buttons
                $('#variant-wrapper').append($newVariant);
                updateColorOptions();
                toggleButtons();
            });

            // Remove variant logic
            $(document).on('click', '.remove-variant', function() {
                if ($('.variant-group').length > 1) {
                    $(this).closest('.variant-group').remove();
                    updateColorOptions();
                    toggleButtons();
                } else {
                    alert("At least one variant is required.");
                }
            });

            // Color dropdown onchange
            $(document).on('change', '.color-select', function() {
                updateColorOptions();
            });
        });

        function updateColorOptions() {
            const selectedColors = [];

            $('.color-select').each(function() {
                const val = $(this).val();
                if (val) selectedColors.push(val);
            });

            $('.color-select').each(function() {
                const currentVal = $(this).val();
                let optionsHtml = '<option value="">Select color</option>';

                $.each(allColors, function(key, label) {
                    if (!selectedColors.includes(key) || currentVal === key) {
                        optionsHtml +=
                            `<option value="${key}" ${currentVal === key ? 'selected' : ''}>${label}</option>`;
                    }
                });

                $(this).html(optionsHtml);
            });
        }

        function toggleButtons() {
            const variants = $('.variant-group');
            variants.each(function(index) {
                const isLast = index === variants.length - 1;
                $(this).find('.remove-variant').toggle(variants.length > 1);
                $(this).find('.add-variant').toggle(isLast);
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
            var main_category = $(selector).val();

            $('#category').html('<option value="">--select--</option>');
            $('#form-fields-container').html('');

            if (main_category) {
                $.ajax({
                    url: "{{ route('admin.product.get_categories') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        main_category: main_category
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#category').html(response.html);
                        }
                    }
                });
            }
        }

        function getSubCategories(selector) {
            var category = $(selector).val();

            $('#subcategory').html('<option value="">--select--</option>');
            $('#form-fields-container').html('');

            if (category) {
                $.ajax({
                    url: "{{ route('admin.product.get_sub_categories') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        category: category
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#subcategory').html(response.html);
                        }
                    }
                });
            }
        }

        function getFormFields(selector) {
            var category = $("#category").val();
            var subcategory = $(selector).val();
            if (!subcategory) {
                $('#form-fields-container').html('');
                return;
            }

            $.ajax({
                url: "{{ route('admin.product.get_form_fields') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    category: category,
                    subcategory: subcategory
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
            getCategories('#main_category');
            setTimeout(function() {
                getSubCategories('#category');
                setTimeout(function() {
                    getFormFields('#subcategory')
                }, 1000);
            }, 1000);
        });
    </script>

    <script>
        $('#manageForm').on('submit', function(e) {
            e.preventDefault();
            $(".error-message").remove();

            let form = $(this)[0];
            let formData = new FormData(form);

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    $(".error-message").remove();

                    if (response.success) {
                        location.href = "{{ route('admin.products') }}";
                    } else if (response.errors) {
                        $.each(response.errors, function(key, value) {
                            let cleanKey = key.replace(/\s*\(.*?\)\s*/g, '').trim();
                            let input = $('[name^="' + cleanKey + '["]');
                            if (input.length === 0) {
                                input = $('[name="' + cleanKey + '"]');
                            }
                            if (input.length > 0) {
                                input.after(
                                    '<span class="text-danger error-message">' + value[0] +
                                    '</span>'
                                );
                            }
                        });
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endpush
