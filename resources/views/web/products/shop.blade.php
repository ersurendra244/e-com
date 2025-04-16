@extends('web.layout', ['title' => $title ?? ''])

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Shop List</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Size Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by
                        Category</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input check-all" id="category-all">
                            <label class="custom-control-label" for="category-all">All Category</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        @foreach ($categories as $key => $category)
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input filter-option" data-filter="category"
                                    id="category-{{ $category->id }}" value="{{ $category->name }}">
                                <label class="custom-control-label"
                                    for="category-{{ $category->id }}">{{ $category->name }}</label>
                                <span class="badge border font-weight-normal">150</span>
                            </div>
                        @endforeach
                    </form>
                </div>
                <!-- Size End -->
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by
                        price</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input check-all" id="price-all">
                            <label class="custom-control-label" for="price-all">All Price</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        @php $prices = priceRange(); @endphp
                        @foreach ($prices as $key => $price)
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input filter-option" data-filter="price"
                                    id="price-{{ $key }}" value="{{ $key }}">
                                <label class="custom-control-label"
                                    for="price-{{ $key }}">{{ $price }}</label>
                                <span class="badge border font-weight-normal">150</span>
                            </div>
                        @endforeach
                    </form>
                </div>
                <!-- Price End -->

                <!-- Color Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by
                        color</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input check-all" id="color-all">
                            <label class="custom-control-label" for="color-all">All Color</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        @php $colors = colors(); @endphp
                        @foreach ($colors as $key => $color)
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input filter-option" data-filter="color"
                                    id="color-{{ $key }}" value="{{ $key }}">
                                <label class="custom-control-label"
                                    for="color-{{ $key }}">{{ $color }}</label>
                                <span class="badge border font-weight-normal">150</span>
                            </div>
                        @endforeach
                    </form>
                </div>
                <!-- Color End -->

                <!-- Size Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by
                        size</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input check-all" id="size-all">
                            <label class="custom-control-label" for="size-all">All Size</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        @php $sizes = sizes(); @endphp
                        @foreach ($sizes as $key => $size)
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input filter-option" data-filter="size"
                                    id="size-{{ $key }}" value="{{ $key }}">
                                <label class="custom-control-label"
                                    for="size-{{ $key }}">{{ $size }}</label>
                                <span class="badge border font-weight-normal">150</span>
                            </div>
                        @endforeach
                    </form>
                </div>
                <!-- Size End -->
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                                <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                        data-toggle="dropdown">Sorting</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">Latest</a>
                                        <a class="dropdown-item" href="#">Popularity</a>
                                        <a class="dropdown-item" href="#">Best Rating</a>
                                    </div>
                                </div>
                                <div class="btn-group ml-2">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                        data-toggle="dropdown">Showing</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">10</a>
                                        <a class="dropdown-item" href="#">20</a>
                                        <a class="dropdown-item" href="#">30</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="product-list">

                </div>

            </div>
        </div>
    </div>
    <!-- Shop End -->
@endsection

@push('child_scripts')
    <script>
        $(document).ready(function() {
            loadProducts();

            $('.filter-option').on('change', function() {
                loadProducts();
            });

            $(document).on('click', '.filter-pagination', function(e) {
                e.preventDefault();
                let page = $(this).data('page');
                loadProducts(page);
            });

            function loadProducts(page = 1) {
                let filters = {};

                $('.filter-option:checked').each(function() {
                    let filterType = $(this).data('filter');
                    if (!filters[filterType]) {
                        filters[filterType] = [];
                    }
                    filters[filterType].push($(this).val());
                });

                filters.page = page;

                $.ajax({
                    url: "{{ route('web.products.list') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        filters: filters
                    },
                    beforeSend: function() {
                        $('#product-list').html('<h5>Loading...</h5>');
                    },
                    success: function(response) {
                        $('#product-list').html(response.html);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.check-all').on('click', function() {
                let isChecked = $(this).is(':checked');
                let form = $(this).closest('form');

                form.find('.filter-option').prop('checked', isChecked).trigger('change');
            });

            $('.filter-option').on('change', function() {
                let form = $(this).closest('form');
                let total = form.find('.filter-option').length;
                let checked = form.find('.filter-option:checked').length;
                form.find('.check-all').prop('checked', total === checked);
            });
        });
    </script>
@endpush
