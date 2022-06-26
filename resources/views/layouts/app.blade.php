<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="">
    <meta name="description" content="BetterMart">
    <meta name="author" content="BetterMart :: Zubayer Hossain :: https://zubayerhs.com/">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') </title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}">

<!-- All CSS is here
        ============================================
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/vendor/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/vendor/signericafat.css')}}">
        <link rel="stylesheet" href="{{asset('css/vendor/cerebrisans.css')}}">
        <link rel="stylesheet" href="{{ asset('css/vendor/elegant.css') }}">
        <link rel="stylesheet" href="{{ asset('css/vendor/linear-icon.css') }}">
        <link rel="stylesheet" href="{{ asset('css/plugins/nice-select.css') }}">
        <link rel="stylesheet" href="{{ asset('css/plugins/easyzoom.css') }}">
        <link rel="stylesheet" href="{{ asset('css/plugins/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('css/plugins/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('css/plugins/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('css/plugins/jquery-ui.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        -->
    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <link rel="stylesheet" href="{{ asset('css/vendor/vendor.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">
    @yield('styles')

</head>
<body>
<div class="main-wrapper">
    {{--        @include('includes.category')--}}
    {{--        @include('includes.search')--}}
    {{--        @include('includes.my-cart')--}}
    @include('includes.header')

    <div class="wrapper">
        @yield('content')
    </div>

    @include('includes.footer')
</div>
<!-- All JS is here -->
<script src="{{ asset('js/vendor/modernizr-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/vendor/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
<script src="{{ asset('js/vendor/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/plugins/slick.js') }}"></script>
<script src="{{ asset('js/plugins/jquery.syotimer.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery.instagramfeed.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('js/plugins/wow.js') }}"></script>
<script src="{{ asset('js/plugins/jquery-ui-touch-punch.js') }}"></script>
<script src="{{ asset('js/plugins/jquery-ui.js') }}"></script>
<script src="{{ asset('js/plugins/magnific-popup.js') }}"></script>
<script src="{{ asset('js/plugins/sticky-sidebar.js') }}"></script>
<script src="{{ asset('js/plugins/easyzoom.js') }}"></script>
<script src="{{ asset('js/plugins/scrollup.js') }}"></script>
<script src="{{ asset('js/plugins/ajax-mail.js') }}"></script>
<script src="{{ asset('js/plugins/toastr.min.js') }}"></script>

<!--  Use the minified version files listed below for better performance and remove the files listed above   -->
{{--<script src="{{ asset('js/vendor/vendor.min.js') }}"></script>--}}
{{--<script src="{{ asset('js/plugins/plugins.min.js') }}"></script>--}}
<!-- Main JS -->
<script src="{{ asset('js/main.js') }}"></script>
@yield('scripts')

{{--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.0/dist/sweetalert2.all.min.js"></script>--}}

<script type="text/javascript">
    $(document).ready(function () {
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        };

        @if(Session::has('message'))
        toastr.success("{{ session('message') }}");
        @endif

        @if(Session::has('error'))
        toastr.error("{{ session('error') }}");
        @endif

        @if(Session::has('warning'))
        toastr.warning("{{ session('warning') }}");
        @endif
    });
</script>
</body>
</html>
