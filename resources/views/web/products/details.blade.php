@extends('web.layout', ['title' => $title ?? ''])

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Shop Detail</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
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
            /* font-size: 30px; */
            color: gray;
            cursor: pointer;
        }

        .rating input:checked~label,
        .rating label:hover,
        .rating label:hover~label {
            color: gold;
        }
    </style>

    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light" id="carousel-images">
                        @foreach ($productData->variants[0]->images as $key => $image)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img class="w-100 h-100" src="{{ asset('uploads/products/' . $image) }}" alt="Image">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3>{{ ucWords($productData->name) }}</h3>
                    @php
                        $reviews = $productData->reviews()->latest()->get();
                        $rating = ceil($productData->reviews_avg_rating);
                    @endphp
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $rating)
                                    <small class="fas fa-star"></small>
                                @else
                                    <small class="far fa-star"></small>
                                @endif
                            @endfor
                        </div>
                        <small class="pt-1">({{ $reviews->count() }} Reviews)</small>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <h3 class="font-weight-semi-bold mb-0">₹{{ $productData->variants[0]->price }}/ </h3>
                        <h6 class="text-muted mb-0">
                            <del>₹{{ $productData->variants[0]->price * 1.1 }}</del>
                        </h6>
                    </div>
                    <p class="mb-4">{{ $productData->short_description }}</p>

                    <div class="d-flex mb-3">
                        <strong class="text-dark mr-3">Colors:</strong>
                        <form>
                            @foreach ($productData->variants as $key => $variant)
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input color-option" id="color-{{ $key }}"
                                        name="color" value="{{ $variant->color }}">
                                    <label class="custom-control-label"
                                        for="color-{{ $key }}">{{ $variant->color }}</label>
                                </div>
                            @endforeach
                        </form>
                    </div>
                    <div id="size-form">
                        <div class="d-flex mb-3">
                            <strong class="text-dark mr-3">Sizes:</strong>
                            <form>
                                @foreach ($productData->variants as $key => $variant)
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input size-option" id="size-{{ $key }}"
                                            name="size">
                                        <label class="custom-control-label"
                                            for="size-{{ $key }}">{{ $variant->size }}</label>
                                    </div>
                                @endforeach
                            </form>
                        </div>
                    </div>

                    <input type="text" name="product_id" id="product_id" class="form-control" value="{{ $productData->id }}">
                    <input type="text" name="variant_id" id="variant_id" class="form-control" value="">
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            {{-- <input type="text" name="quantity" id="quantity" class="form-control bg-secondary border-0 text-center" min="1" value="1"> --}}
                            <input type="text" name="variant_id" id="variant_id" class="form-control bg-secondary border-0 text-center" value="1">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button class="btn btn-primary px-3" onclick="addToCart({{ $productData->id }})"><i class="fa fa-shopping-cart mr-1"></i> Add To
                            Cart</button>
                    </div>
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Description</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Information</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews
                            ({{ $reviews->count() }})</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <h4 class="mb-3">Product Description</h4>
                            <p>{!! $productData->full_description !!}</p>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-2">
                            <h4 class="mb-3">Additional Information</h4>
                            <p>{!! $productData->add_description !!}</p>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="mb-4">{{ $reviews->count() }} review for "{{ $productData->name }}"
                                    </h4>

                                    @foreach ($reviews as $key => $review)
                                        <div class="media mb-4">
                                            @php $userimg = $review->user && $review->user->image
                                            ? asset('uploads/profile/' . $review->user->image)
                                            : asset('web/img/user.jpg'); @endphp
                                            <img src="{{ $userimg }}" alt="Image"
                                                class="img-fluid mr-3 mt-1" style="width: 45px;">
                                            <div class="media-body">
                                                <h6>{{ $review->user_name }}<small> -
                                                        <i>{{ date('d M Y', strtotime($review->created_at)) }}</i></small>
                                                </h6>
                                                <div class="text-primary mb-2">
                                                    @php
                                                        $rating2 = ceil($review->rating);
                                                    @endphp
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $rating2)
                                                            <small class="fas fa-star"></small>
                                                        @else
                                                            <small class="far fa-star"></small>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <p>{{ $review->reviews }}</p>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                <div class="col-md-6">
                                    <h4 class="mb-4">Leave a review</h4>
                                    <small>Your email address will not be published. Required fields are marked *</small>
                                    <form id="reviewForm" action="{{ route('web.products.reviews.save') }}" method="post">
                                        @csrf
                                        <div class="d-flex my-3">
                                            <p class="mb-0 mr-2">Your Rating * :</p>
                                            <div class="rating text-primary">
                                                <input type="radio" name="stars" id="star5"
                                                    value="5"><label for="star5"><i
                                                        class="far fa-star"></i></label>
                                                <input type="radio" name="stars" id="star4"
                                                    value="4"><label for="star4"><i
                                                        class="far fa-star"></i></label>
                                                <input type="radio" name="stars" id="star3"
                                                    value="3"><label for="star3"><i
                                                        class="far fa-star"></i></label>
                                                <input type="radio" name="stars" id="star2"
                                                    value="2"><label for="star2"><i
                                                        class="far fa-star"></i></label>
                                                <input type="radio" name="stars" id="star1"
                                                    value="1"><label for="star1"><i
                                                        class="far fa-star"></i></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="reviews">Your Review *</label>
                                            <textarea name="reviews" id="reviews" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                        @if (!Auth::user())
                                            <div class="form-group">
                                                <label for="user_name">Your Name *</label>
                                                <input type="text" class="form-control" name="user_name" id="user_name">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Your Email *</label>
                                                <input type="email" class="form-control" name="email" id="email">
                                            </div>
                                        @endif
                                        <div id="successMessage" style="display:none;"></div>
                                        <div class="form-group mb-0">
                                            <input type="hidden" name="product_id" value="{{ $productData->id }}">
                                            <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->

    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May
                Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="img/product-1.jpg" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-search"></i></a>
                            </div>
                        </div>

                    </div>
                    @foreach ($relatedProducts as $key => $related)
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                @php $image = $related->images[0] ?? ''; @endphp
                                <img class="img-fluid w-100" src="{{ asset('uploads/products/' . $image) }}" alt="">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                            class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                            class="far fa-heart"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate"
                                    href="{{ route('web.products.details', $related->id) }}">{{ ucWords($related->name) }}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>₹{{ $related->variants[0]->price }}</h5>
                                    <h6 class="text-muted ml-2"><del>₹{{ $related->variants[0]->price * 1.1 }}</del></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    @php
                                        $rating = ceil($related->reviews_avg_rating);
                                    @endphp

                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $rating)
                                            <small class="fa fa-star text-warning mr-1"></small>
                                        @else
                                            <small class="fa fa-star text-secondary mr-1"></small>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
@endsection

@push('child_scripts')
<script>
    $(document).ready(function () {
        $('.color-option').on('change', function () {
            let color = $(this).val();
            let productId = $('#product_id').val();
            $.ajax({
                url: "{{ url('/get-sizes-by-color') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    color: color,
                    product_id: productId
                },
                success: function (response) {
                    console.log(response);
                    let sizes = response.sizes;
                    let sizeForm = $('#size-form');
                    sizeForm.empty(); // Clear previous size options

                    if (sizes.length > 0) {
                        sizes.forEach(function (size, index) {
                            let id = `size-${index}`;
                            let sizeOption = `
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input size-option"
                                        id="${id}" name="size" value="${size}">
                                    <label class="custom-control-label" for="${id}">${size}</label>
                                </div>
                            `;
                            sizeForm.append(sizeOption);
                        });
                    } else {
                        sizeForm.append('<p>No sizes available for this color.</p>');
                    }
                },
                error: function () {
                    alert('Something went wrong while fetching sizes.');
                }
            });
        });
    });
    </script>


    <script>
        // $(document).ready(function () {
        //     $(".color-option").change(function () {
        //         var selectedVariantIndex = $(this).val();
        //         var images = @json($productData->variants->map->images);
        //         $("#variant_id").val($productData->variants->map->id[selectedVariantIndex]);
        //         var carouselInner = $("#carousel-images");
        //         carouselInner.empty();

        //         images[selectedVariantIndex].forEach((image, index) => {
        //             carouselInner.append(`
        //                 <div class="carousel-item ${index === 0 ? 'active' : ''}">
        //                     <img class="w-100 h-100" src="{{ asset('uploads/products/') }}/` + image + `" alt="Image">
        //                 </div>
        //             `);
        //         });
        //     });
        // });

        <script>
    const variants = @json($productData->variants);

    function updateVariantId() {
        const selectedColor = $("input[name='color']:checked").val();
        const selectedSize = $("input[name='size']:checked").val();

        const matchedVariant = variants.find(v =>
            v.color === selectedColor && v.size === selectedSize
        );

        if (matchedVariant) {
            $("#variant_id").val(matchedVariant.id);

            // Update carousel images
            const carouselInner = $("#carousel-images");
            carouselInner.empty();

            matchedVariant.images.forEach((image, index) => {
                carouselInner.append(`
                    <div class="carousel-item ${index === 0 ? 'active' : ''}">
                        <img class="w-100 h-100" src="{{ asset('uploads/products/') }}/` + image + `" alt="Image">
                    </div>
                `);
            });
        } else {
            $("#variant_id").val('');
        }
    }

    $(document).ready(function () {
        $(".color-option, .size-option").change(function () {
            updateVariantId();
        });
    });
</script>

    </script>
    <script>
        $("#reviewForm").submit(function(e) {
            e.preventDefault(); // Prevent form submission
            $(".error-message").remove();
            var stars = $("input[name='stars']:checked").val();
            if (stars == null) {
                $(".rating").after('<span class="text-danger error-message ml-3">Please rate the product</span>');
                return false;
            }
            let formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: $(this).attr("action"),
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.status == "success") {
                        $("#successMessage").html(
                            '<div class="alert alert-success">Review submitted successfully.' +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                            '</div>'
                        ).fadeIn();
                        $("#reviewForm")[0].reset();
                    } else if (response.status == "error") {
                        $.each(response.errors, function(key, value) {
                            $("#" + key).after('<span class="text-danger error-message">' + value[0] + '</span>');
                        });
                    }
                },
                error: function(response) {
                    $("#successMessage").html(
                        '<div class="alert alert-danger">Something went wrong. Please try again.' +
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                        '</div>'
                    ).fadeIn();
                }
            });
            setTimeout(function() {
                $("#successMessage").fadeOut();
            }, 3000);
        });

    </script>
    <script>
        function addToCart(id) {
            var quantity = $("#quantity").val();
            var variant_id = $("#variant_id").val();
            console.log(variant_id);
            $.ajax({
                type: "POST",
                url: "{{ route('web.products.addToCart') }}",
                data: {
                    id: id,
                    quantity: quantity,
                    variant_id: variant_id,
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.status == "success") {
                        $("#successMessage").html(
                            '<div class="alert alert-success">' + response.message +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                            '</div>'
                        ).fadeIn();
                    } else if (response.status == "error") {
                        $("#successMessage").html(
                            '<div class="alert alert-danger">' + response.message +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                            '</div>'
                        ).fadeIn();
                    }
                },
                error: function(response) {
                    $("#successMessage").html(
                        '<div class="alert alert-danger">Something went wrong. Please try again.' +
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                        '</div>'
                    ).fadeIn();
                }
            });
        }
    </script>
@endpush
