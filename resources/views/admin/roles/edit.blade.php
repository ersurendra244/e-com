@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    @include('admin.common.message')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.roles') }}" class="btn btn-sm btn-dark float-right">Go Back</a>
                    <h4 class="card-title">{{ $title }}</h4>
                    <form action="{{ route('admin.roles.update', $data->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong><label class="form-label" for="name">Role</label></strong>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter Role" value="{{ $data->name ?? '' }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <h4 class="card-title">Permissions</h4>

                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="data_table" class="table table-bordered w-100">
                                        <thead>
                                            <tr>
                                                <th> # </th>
                                                <th style="width: 20%">
                                                    <div class="form-group mb-0">
                                                        <div class="form-check">
                                                            <label class="form-check-label py-1 mb-0"
                                                                style="line-height: 1;">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="all_permissions" id="all_permissions"
                                                                    value="">All Menu<i class="input-helper"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </th>
                                                <th>Permissions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $i = 1; @endphp
                                            @foreach ($permissions as $key => $perms)
                                                @if (count($perms) && ($perms[0]->menu->id ?? 0) == 0)
                                                    @continue
                                                @endif

                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>
                                                        @if (count($perms))
                                                            <div class="form-group mb-0">
                                                                <div class="form-check">
                                                                    <label class="form-check-label py-1 mb-0" style="line-height: 1;">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            name="menu_permissions"
                                                                            value="{{ $perms[0]->menu->id ?? '' }}">
                                                                        {{ $perms[0]->menu->name ?? 'No Menu' }}
                                                                        <i class="input-helper"></i>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="d-flex flex-wrap gap-2">
                                                        @foreach ($perms as $permission)
                                                            @php
                                                                $checked = isset($data->permissions) &&
                                                                    $data->permissions->contains('name', $permission->name) ? 'checked' : '';
                                                                $color = isset($data->permissions) &&
                                                                    $data->permissions->contains('name', $permission->name) ? 'info' : 'outline-dark';
                                                            @endphp
                                                            <div class="btn btn-sm btn-{{ $color }} mb-0 mr-2">
                                                                <div class="form-group mb-0">
                                                                    <div class="form-check">
                                                                        <label class="form-check-label mb-0" style="line-height: 1;">
                                                                            <input type="checkbox"
                                                                                class="form-check-input permission-checkbox"
                                                                                name="permissions[]"
                                                                                data-menu-id="{{ $permission->menu_id }}"
                                                                                value="{{ $permission->name }}"
                                                                                {{ $checked }}>
                                                                            {{ $permission->name }}
                                                                            <i class="input-helper"></i>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('child_scripts')
    <script>
        $(document).ready(function() {
            $('#data_table').DataTable();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const allPermissionsCheckbox = document.getElementById('all_permissions');
            const menuCheckboxes = document.querySelectorAll('input[name="menu_permissions"]');
            const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');

            // Handle global "Check All Menus" checkbox
            allPermissionsCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                menuCheckboxes.forEach(menuCheckbox => {
                    menuCheckbox.checked = isChecked;
                    toggleMenuPermissions(menuCheckbox.value, isChecked);
                });
                updatePermissionStyles();
            });

            // Handle each menu-level checkbox
            menuCheckboxes.forEach(menuCheckbox => {
                menuCheckbox.addEventListener('change', function() {
                    toggleMenuPermissions(this.value, this.checked);
                    updateGlobalCheckbox();
                    updatePermissionStyles();
                });
            });

            // Handle individual permission checkboxes
            permissionCheckboxes.forEach(permissionCheckbox => {
                permissionCheckbox.addEventListener('change', function() {
                    updateMenuCheckbox(this);
                    updateGlobalCheckbox();
                    updatePermissionStyles();
                });
            });

            // Toggle all permissions under a menu
            function toggleMenuPermissions(menuId, isChecked) {
                document.querySelectorAll(`.permission-checkbox[data-menu-id="${menuId}"]`).forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
            }

            // Update menu checkbox based on its permission checkboxes
            function updateMenuCheckbox(changedPermission) {
                const menuId = changedPermission.getAttribute('data-menu-id');
                const relatedPermissions = document.querySelectorAll(
                    `.permission-checkbox[data-menu-id="${menuId}"]`);
                const allChecked = [...relatedPermissions].every(cb => cb.checked);
                const menuCheckbox = document.querySelector(`input[name="menu_permissions"][value="${menuId}"]`);
                if (menuCheckbox) {
                    menuCheckbox.checked = allChecked;
                }
            }

            // Update global checkbox based on all menus
            function updateGlobalCheckbox() {
                const allMenusChecked = [...menuCheckboxes].every(cb => cb.checked);
                allPermissionsCheckbox.checked = allMenusChecked;
            }

            // Update class styling (info/outline-dark) based on checked state
            function updatePermissionStyles() {
                permissionCheckboxes.forEach(cb => {
                    const wrapper = cb.closest('.btn');
                    if (wrapper) {
                        wrapper.classList.toggle('btn-info', cb.checked);
                        wrapper.classList.toggle('btn-outline-dark', !cb.checked);
                    }
                });
            }

            // Initial setup on page load
            updatePermissionStyles();
            permissionCheckboxes.forEach(updateMenuCheckbox);
            updateGlobalCheckbox();
        });
    </script>
@endpush
