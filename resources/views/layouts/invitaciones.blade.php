@php
$controller = DzHelper::controller();
$action = DzHelper::action();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('page_description', $page_description ?? '')" />
    <meta property="og:title" content="Lezato : Restaurant Admin Laravel Template" />
    <meta property="og:description" content="{{ config('dz.name') }} | @yield('title', $page_title ?? '')" />
    <meta name="format-detection" content="telephone=no">

    <!-- PAGE TITLE HERE -->
    <title>{{ config('dz.name') }} | @yield('title', $page_title ?? '')</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}" />

    <!-- Style css -->
    @php
    $action = isset($action) ? $controller.'_'.$action : 'dashboard_1';
    @endphp
    @include('layouts.globalCss')
    @if(!empty(config('dz.public.pagelevel.css.'.$action)))
    @foreach(config('dz.public.pagelevel.css.'.$action) as $style)
    <link href="{{ asset($style) }}" rel="stylesheet" type="text/css" />
    @endforeach
    @endif
    @include('elements.icons')
    {{-- Global Theme Styles (used by all pages) --}}
    @if(!empty(config('dz.public.global.css')))
    @foreach(config('dz.public.global.css') as $style)
    <link href="{{ asset($style) }}" rel="stylesheet" type="text/css" />
    @endforeach
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .color-global {
            color: #FD683E !important;
        }

        .bg-global {
            background-color: #FD683E !important;
        }

        .body-color {
            background-color: #f2f2f2 !important;
        }


        .logoHeader {
            width: 26%;
            height: auto;
        }

        @media (max-width: 47.9375rem) {
            .brand-title {
                display: inline !important;
            }

            .logoHeader {
                width: 40%;
                height: auto;
            }
        }
    </style>
    @yield('css')
</head>

<body class="body-color">

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="gooey">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">


        <!--**********************************
            Header start
        ***********************************-->

        @include('elements.headerInvitaciones')


        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->



        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body mx-1 my-4 mx-lg-5 px-1 px-lg-5" style>
            <!-- row -->
            @yield('content')

        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->

        {{-- @include('elements.footer') --}}

        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->

    @if(!empty(config('dz.public.global.js.top')))
    @foreach(config('dz.public.global.js.top') as $script)
    <script src="{{ asset($script) }}" type="text/javascript"></script>
    @endforeach
    @endif

    @if(!empty(config('dz.public.global.js.bottom')))
    @foreach(config('dz.public.global.js.bottom') as $script)
    <script src="{{ asset($script) }}" type="text/javascript"></script>
    @endforeach
    @endif
    <script src="{{ asset('js/deznav-init-ligth.js') }}"></script>

    <script src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/plugins-init/toastr-init.js') }}"></script>
    <script src="{{ asset('js/utils.js') }}"></script>
    @yield('scripts')
</body>

</html>