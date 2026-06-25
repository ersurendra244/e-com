@php
    $role = currentRole(); // e.g. 'admin', 'vendor', 'user'
@endphp

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        {{-- Profile Section --}}
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="profile-image">
                    <img src="{{ asset('uploads/profile/' . Auth::user()->image) }}" alt="image" />
                </div>
                <div class="profile-name">
                    <p class="name">
                        {{ Auth::user()->name ?? 'Guest' }}
                    </p>
                    <p class="designation">
                        {{ ucfirst(Auth::user()->roles()->first()?->name ?? 'Guest') }}
                    </p>
                </div>
            </div>
        </li>

        {{-- Dashboard --}}
        <li class="nav-item {{ request()->routeIs($role . '.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ roleRoute('dashboard') }}">
                <i class="fas fa-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        {{-- Issue Ticket --}}
        <li class="nav-item {{ request()->routeIs($role . '.issues') ? 'active' : '' }}">
            <a class="nav-link" href="{{ roleRoute('issues') }}">
                <i class="fas fa-pen-square menu-icon"></i>
                <span class="menu-title">Issue Ticket</span>
            </a>
        </li>

        {{-- Users --}}
        @can('user list')
            <li class="nav-item {{ request()->routeIs($role . '.users*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ roleRoute('users') }}">
                    <i class="fa fa-user menu-icon"></i>
                    <span class="menu-title">Users</span>
                </a>
            </li>
        @endcan

        {{-- Products --}}
        @can('product list')
            <li class="nav-item {{ request()->routeIs($role . '.products*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ roleRoute('products') }}">
                    <i class="fa fa-window-restore menu-icon"></i>
                    <span class="menu-title">Products</span>
                </a>
            </li>
        @endcan

        {{-- Roles --}}
        @can('role list')
            <li class="nav-item {{ request()->routeIs($role . '.roles*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ roleRoute('roles') }}">
                    <i class="far fa-stop-circle menu-icon"></i>
                    <span class="menu-title">Roles</span>
                </a>
            </li>
        @endcan

        {{-- Permissions --}}
        @can('permission list')
            <li class="nav-item {{ request()->routeIs($role . '.permissions*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ roleRoute('permissions') }}">
                    <i class="fas fa-pen-square menu-icon"></i>
                    <span class="menu-title">Permissions</span>
                </a>
            </li>
        @endcan

        {{-- Files --}}
        @can('file list')
            <li class="nav-item {{ request()->routeIs($role . '.files*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ roleRoute('files') }}">
                    <i class="fas fa-pen-square menu-icon"></i>
                    <span class="menu-title">Files</span>
                </a>
            </li>
        @endcan

        {{-- File Manager --}}
        <li class="nav-item {{ request()->routeIs($role . '.file_manager*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ roleRoute('file_manager') }}">
                <i class="fas fa-folder-open menu-icon"></i>
                <span class="menu-title">File Manager</span>
            </a>
        </li>

        {{-- Settings --}}
        @canany(['site settings'])
            <li class="nav-item {{ request()->routeIs($role . '.settings') ? 'active' : '' }}">
                <a class="nav-link" href="{{ roleRoute('settings') }}">
                    <i class="fas fa-cog menu-icon"></i>
                    <span class="menu-title">Settings</span>
                </a>
            </li>
        @endcanany

        {{-- Masters (dropdown) --}}
        @canany(['menu list', 'brand list', 'item type list', 'category list', 'category edit', 'subcategory list'])
            @php
                $mastersActive = request()->routeIs(
                    $role . '.masters.*',
                    $role . '.categories*',
                    $role . '.subcategory*'
                );
            @endphp
            <li class="nav-item d-none d-lg-block {{ $mastersActive ? 'active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#masters"
                   aria-expanded="{{ $mastersActive ? 'true' : 'false' }}"
                   aria-controls="masters">
                    <i class="fas fa-cog menu-icon"></i>
                    <span class="menu-title">Masters</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse {{ $mastersActive ? 'show' : '' }}" id="masters">
                    <ul class="nav flex-column sub-menu">
                        @can('menu list')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs($role . '.masters.menu*') ? 'active' : '' }}"
                                   href="{{ roleRoute('masters.menu') }}">Menus</a>
                            </li>
                        @endcan
                        @can('brand list')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs($role . '.masters.brand*') ? 'active' : '' }}"
                                   href="{{ roleRoute('masters.brand') }}">Brands</a>
                            </li>
                        @endcan
                        @can('category list')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs($role . '.categories*') ? 'active' : '' }}"
                                   href="{{ roleRoute('categories') }}">Categories</a>
                            </li>
                        @endcan
                        @can('subcategory list')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs($role . '.subcategory*') ? 'active' : '' }}"
                                   href="{{ roleRoute('subcategory') }}">Subcategories</a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcanany

        {{-- Pages --}}
        @canany(['page list', 'page create', 'page edit', 'page delete'])
            <li class="nav-item {{ request()->routeIs($role . '.pages*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ roleRoute('pages') }}">
                    <i class="fas fa-file-alt menu-icon"></i>
                    <span class="menu-title">Pages</span>
                </a>
            </li>
        @endcanany

        {{-- User-specific menu items (profile, orders, wishlist, etc.) --}}
        <li class="nav-item {{ request()->routeIs($role . '.edit_profile') ? 'active' : '' }}">
            <a class="nav-link" href="{{ roleRoute('edit_profile') }}">
                <i class="fas fa-user-edit menu-icon"></i>
                <span class="menu-title">Edit Profile</span>
            </a>
        </li>

        @if (Auth::user()->hasRole('User'))
            <li class="nav-item {{ request()->routeIs($role . '.saved_address') ? 'active' : '' }}">
                <a class="nav-link" href="{{ roleRoute('saved_address') }}">
                    <i class="fas fa-address-card menu-icon"></i>
                    <span class="menu-title">Saved Address</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs($role . '.reviews') ? 'active' : '' }}">
                <a class="nav-link" href="{{ roleRoute('reviews') }}">
                    <i class="fas fa-star menu-icon"></i>
                    <span class="menu-title">Reviews</span>
                </a>
            </li>
        @endif

    </ul>
</nav>
