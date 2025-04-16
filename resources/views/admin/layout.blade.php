<!DOCTYPE html>
<html lang="en">

<head>
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
    </style>
</head>

<body>
    <div class="container-scroller">
        @include('admin.common.navbar')
        <div class="container-fluid page-body-wrapper">
            @include('admin.common.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">{{ $title ?? 'Dashboard' }}</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                @if (!empty($subtitle))
                                    <li class="breadcrumb-item active" aria-current="page">{{ $subtitle ?? '' }}</li>
                                @endif
                                @if (!empty($title) && $title != 'Dashboard')
                                    <li class="breadcrumb-item active">{{ $title ?? 'Dashboard' }}</li>
                                @endif
                            </ol>
                        </nav>
                    </div>
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

    @stack('child_scripts')
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

        /*Summernote editor*/
        // if ($(".summernote").length) {
        //     $('.summernote').summernote({
        //         height: 300,
        //         tabsize: 2
        //     });
        // }
    </script>
</body>


</html>
