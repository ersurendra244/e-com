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

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <strong><label class="form-label mb-3" for="name">Permissions</label></strong>
                                <div class="form-group">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="all_permissions"
                                                id="all_permissions" value="">
                                            Check All<i class="input-helper"></i>
                                        </label>
                                    </div>
                                </div>
                                @foreach ($permissions as $group => $perms)
                                    <div class="row">
                                        @foreach ($perms as $permission)
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox"
                                                                class="form-check-input permission-checkbox"
                                                                name="permissions[]" value="{{ $permission->name }}"
                                                                {{ isset($data->permissions) && $data->permissions->contains('name', $permission->name) ? 'checked' : '' }}>
                                                            {{ $permission->name }}<i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
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
        // Function to update the "Check All" checkbox based on individual checkbox states.
        function updateCheckAll() {
            var allChecked = true;
            document.querySelectorAll('.permission-checkbox').forEach(function(chk) {
                if (!chk.checked) {
                    allChecked = false;
                }
            });
            document.getElementById('all_permissions').checked = allChecked;
        }

        // Toggle all individual checkboxes when "Check All" is clicked
        document.getElementById('all_permissions').addEventListener('change', function() {
            var isChecked = this.checked;
            document.querySelectorAll('.permission-checkbox').forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });

        // Update "Check All" checkbox whenever an individual checkbox is changed
        document.querySelectorAll('.permission-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', updateCheckAll);
        });

        // On page load, update the "Check All" checkbox based on current permissions state
        document.addEventListener('DOMContentLoaded', updateCheckAll);
    </script>
@endpush
