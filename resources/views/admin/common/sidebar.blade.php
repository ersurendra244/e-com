<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="profile-image">
                    <img src="{{ asset('uploads/profile/' . Auth::user()->image) }}" alt="image" />
                </div>
                <div class="profile-name">
                    <p class="name">
                        {{ Auth::user()->name??'Guest' }}
                    </p>
                    <p class="designation">
                        {{ ucfirst(Auth::user()->roles()->first()->name)??'Guest' }}
                    </p>
                </div>
            </div>
        </li>
        @php $dashboardRoute = strtolower(Auth::user()->roles()->first()->name) . '.dashboard'; @endphp
        <li class="nav-item {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}">
            <a class="nav-link" href="{{ route($dashboardRoute) }}">
                <i class="fas fa-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @can('user list')
            <li class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.users') }}">
                    <i class="fa fa-user menu-icon"></i>
                    <span class="menu-title">Users</span>
                </a>
            </li>
        @endcan
        @can('category list')
            <li class="nav-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.categories') }}">
                    <i class="fa fa-window-restore menu-icon"></i>
                    <span class="menu-title">Categories</span>
                </a>
            </li>
        @endcan
        @can('product list')
            <li class="nav-item {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.products') }}">
                    <i class="fa fa-window-restore menu-icon"></i>
                    <span class="menu-title">Products</span>
                </a>
            </li>
        @endcan
        @can('role list')
            <li class="nav-item {{ request()->routeIs('admin.roles*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.roles') }}">
                    <i class="far fa-stop-circle menu-icon"></i>
                    <span class="menu-title">Roles</span>
                </a>
            </li>
        @endcan
        @can('permission list')
            <li class="nav-item {{ request()->routeIs('admin.permissions*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.permissions') }}">
                    <i class="fas fa-pen-square menu-icon"></i>
                    <span class="menu-title">Permissions</span>
                </a>
            </li>
        @endcan
        @can('file list')
            <li class="nav-item {{ request()->routeIs('admin.files*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.files') }}">
                    <i class="fas fa-pen-square menu-icon"></i>
                    <span class="menu-title">Files</span>
                </a>
            </li>
        @endcan

        @if(Auth::user()->hasRole('User'))
            <li class="nav-item {{ request()->routeIs('user.edit_profile') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.edit_profile') }}">
                    <i class="fas fa-pen-square menu-icon"></i>
                    <span class="menu-title">Edit Profile</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.files*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.files') }}">
                    <i class="fas fa-shopping-bag menu-icon"></i>
                    <span class="menu-title">Orders</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.files*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.files') }}">
                    <i class="fas fa-heart menu-icon"></i>
                    <span class="menu-title">Wishlist</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.files*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.files') }}">
                    <i class="fas fa-shopping-cart menu-icon"></i>
                    <span class="menu-title">Cart</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('user.saved_address') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.saved_address') }}">
                    <i class="fas fa-address-card menu-icon"></i>
                    <span class="menu-title">Saved Address</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('user.reviews') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.reviews') }}">
                    <i class="fas fa-star menu-icon"></i>
                    <span class="menu-title">Reviews</span>
                </a>
            </li>
        @endif
    </ul>
</nav>
