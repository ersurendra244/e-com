<!DOCTYPE html>
<html lang="en">

<head>
    @php $setting = App\Models\Setting::where('id', 1)->first(); @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Melody Admin</title>
    <link rel="stylesheet" href="{{ asset('admin/vendors/iconfonts/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/css/vendor.bundle.addons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/summernote/dist/summernote-bs4.css') }}">
    <style>
        .error-message {
            font-size: small !important;
        }

        .btn.btn-icon {
            width: 35px !important;
            height: 35px !important;
        }
        .dataTables_wrapper select {
            padding: .4rem!important;
        }
    </style>
</head>

<body class="sidebar-fixed">
    <div class="container-scroller">
        @include('admin.common.navbar')
        <div class="container-fluid page-body-wrapper">
            @include('admin.common.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2018.
                            All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made
                            with <i class="far fa-heart text-danger"></i></span>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/vendor.bundle.addons.js') }}"></script>
    <script src="{{ asset('admin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('admin/js/misc.js') }}"></script>
    <script src="{{ asset('admin/js/settings.js') }}"></script>
    <script src="{{ asset('admin/js/todolist.js') }}"></script>
    <script src="{{ asset('admin/js/dashboard.js') }}"></script>
    <script src="{{ asset('admin/js/data-table.js') }}"></script>
    <script src="{{ asset('admin/vendors/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('notify.js') }}"></script>

    @stack('child_scripts')
    <script>
        function notifyMessage(message, type) {
            $.notify(message, {
                className: type,
                closeOnClick: true,
                globalPosition: 'top right'
            });
        }
    </script>
    @if (Session::has('success'))
        {{ Session::get('success') }}"
    @endif
    @if (Session::has('error'))
        {{ Session::get('error') }}"
    @endif
    <script>
        setTimeout(function() {
            let successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.display = 'none';
            }

            let errorMessage = document.getElementById('errorMessage');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }, 2000);

        function getUser(role_id) {
            $.ajax({
                url: "{{ route('admin.dashboard.getUser') }}",
                type: 'POST',
                data: {
                    role_id: role_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#user_id').html(response);
                }
            });
        }
    </script>
    <script>
        function deleteData(url) {
            swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                buttons: ["Cancel", "Yes, delete it!"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function(response) {
                            location.reload();
                        },
                        error: function() {
                            swal("Error", "Something went wrong. Please try again.", "error");
                        }
                    });
                }
            });
        }
    </script>

</body>


</html>
