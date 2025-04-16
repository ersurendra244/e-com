<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MultiShop {{ $title ? '| ' . $title : '' }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="{{ asset('web/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('web/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('web/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('web/css/style.css') }}" rel="stylesheet">

    <style>
        .error-message {
            font-size: small !important;
        }
    </style>
</head>

<body>
    <!-- Header Start -->
    @include('web.common.header')
    <!-- Header End -->


    <!-- Navbar Start -->
    @include('web.common.navbar')
    <!-- Navbar End -->

    @yield('content')

    <!-- Footer Start -->
    @include('web.common.footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('web/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('web/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('web/js/main.js') }}"></script>

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
    </script>
    {{-- <script>
        function addToCart(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('web.products.addToCart') }}",
                data: {
                    id: id,
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
    </script> --}}
</body>

</html>
