<style>
    .header {
        position: relative;
        background: #fff;
        padding: 10px 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    .navbar {
        padding: 0px 20px!important;
    }

    .navbar-nav .nav-link {
        color: #000;
        padding: 10px 15px;
        font-weight: 500;
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
        color: #e74c3c;
    }
    .nav-item.dropdown:hover .dropdown-menu {
        display: block;
    }
.dropdown-menu {
    display: none;
}
.nav-item.dropdown:hover .dropdown-menu {
    display: block;
}
    .mega-menu {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        display: none;
        background: #fff;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        padding: 20px;
        z-index: 99;
    }

    .menu-item-has-children:hover .mega-menu {
        display: flex;
    }

    .mega-menu-column-4 {
        display: flex;
        justify-content: space-between;
        flex-wrap: nowrap;
    }

    .list-item {
        flex: 1;
        padding: 0 15px;
    }

    .list-item h4.title {
        font-size: 16px;
        font-weight: 600;
        color: #e74c3c;
        margin-bottom: 10px;
    }

    .list-item ul {
        list-style: none;
        padding: 0;
        margin: 0 0 20px 0;
    }

    .list-item ul li {
        margin: 5px 0;
    }

    .list-item ul li a {
        color: #333;
        text-decoration: none;
        font-size: 14px;
    }

    .list-item ul li a:hover {
        text-decoration: underline;
    }

    .list-item.text-center {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .list-item.text-center img {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
    }
</style>

<div class="container-fluid bg-dark mb-30">
    <div class="row px-xl-5">
        <div class="col-lg-12">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="mainNav">
                        <ul class="navbar-nav mr-auto">
                            @php
                                $categories = \App\Models\Category::where('parent_id', '0')->where('is_home', '1')->where('status', '1')->latest('order')->get();
                            @endphp
                            @foreach ($categories as $key => $value)
                            <li class="nav-item dropdown mega-dropdown position-static">
                                <a class="nav-link text-white" href="{{ route('web.products.shop', $value->slug) }}">{{ $value->name }}
                                </a>

                                <div class="dropdown-menu w-100 border-0 p-3"
                                    style="background-color:#fff;">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="row">
                                                    @php
                                                $subCategories = \App\Models\Category::where('parent_id', $value->id)->where('status', '1')->latest('order')->get();
                                                // print_r($subCategories->toArray()); exit;
                                            @endphp
                                            @foreach ($subCategories as $subCategory)
                                                <div class="col-md-3 mb-3">
                                                <h6 class="text-danger font-weight-bold">{{ $subCategory->name }}</h6>
                                                @php
                                                    $items = \App\Models\SubCategory::where('category', $subCategory->id)
                                                            ->where('status', '1')->where('is_delete', '0')->orderBy('name', 'asc')->select('id', 'name')
                                                            ->get();
                                                @endphp
                                                <ul class="list-unstyled">
                                                    @foreach ($items as $item)
                                                        <li><a href="{{ route('web.products.shop', [$subCategory->slug, $item->slug]) }}" class="text-dark">{{ $item->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endforeach
                                                </div>
                                            </div>

                                            <div class="col-md-3 text-center">
                                                <img src="https://images.unsplash.com/photo-1549497538-303791108f95?auto=format&fit=crop&w=761&q=80"
                                                    class="img-fluid rounded" alt="Chair" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach

                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('web.products.shop') }}">Shop</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('web.home.contact_us') }}">Contact Us</a>
                            </li>
                        </ul>

                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="#"><i class="far fa-heart"></i> 0</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="#"><i class="fas fa-shopping-cart"></i>
                                    0</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

        </div>
    </div>
</div>
