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
    @if(!empty(config('dz.public.pagelevel.css.'.$action)))
    @foreach(config('dz.public.pagelevel.css.'.$action) as $style)
    <link href="{{ asset($style) }}" rel="stylesheet" type="text/css" />
    @endforeach
    @endif

    {{-- Global Theme Styles (used by all pages) --}}
    @if(!empty(config('dz.public.global.css')))
    @foreach(config('dz.public.global.css') as $style)
    <link href="{{ asset($style) }}" rel="stylesheet" type="text/css" />
    @endforeach
    @endif

</head>

<body>

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
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="{!! url('/index'); !!}" class="brand-logo">
                @include('elements.svg_logo')
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->

        @include('elements.header')


        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        @include('elements.sidebar')
        <!--**********************************
            Sidebar end
        ***********************************-->



        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
            @yield('content')
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->

        @include('elements.footer')

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
    @if(!empty(config('dz.public.pagelevel.js.'.$action)))
    @foreach(config('dz.public.pagelevel.js.'.$action) as $script)
    <script src="{{ asset($script) }}" type="text/javascript"></script>
    @endforeach
    @endif
    @if(!empty(config('dz.public.global.js.bottom')))
    @foreach(config('dz.public.global.js.bottom') as $script)
    <script src="{{ asset($script) }}" type="text/javascript"></script>
    @endforeach
    @endif

    @yield('scripts')
</body>

</html>