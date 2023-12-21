@php
$controller = DzHelper::controller();
$action = DzHelper::action();
// si la url es el login crea una variable llamada $loginbackground
if (request()->is('login')) {
$loginbackground = 'authincation-content';
$page_title = 'Login';
$page_description = 'Login';
}else {
$loginbackground = '';
}

@endphp

<!DOCTYPE html>
<html lang="es" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('page_description', $page_description ?? '')" />
    <meta property="og:title" content="La poza eventos : Crear invitaciones para enventos en el restaurante LaPoza" />
    <meta property="og:description" content="{{ config('dz.name') }} | @yield('title', $page_title ?? '')" />
    <meta name="format-detection" content="telephone=no">
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    <!-- PAGE TITLE HERE -->
    <title>{{ config('dz.name') }} | @yield('title', $page_title ?? '')</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Style css -->
    @include('layouts.globalCss')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @include('elements.icons')
    <style>
        .body-color {
            background-color: #f2f2f2 !important;
        }
    </style>
</head>

<body class="vh-100  ">
    <div class="authincation h-100" @if(!empty($loginbackground)) style="background-color: rgb(226, 226, 226);" @endif>
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                @yield('content')
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->

    @php
    $action = isset($action) ? $controller.'_'.$action : 'dashboard_1';
    @endphp


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
    <script src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/plugins-init/toastr-init.js') }}"></script>
    <script src="{{ asset('js/utils.js') }}"></script>

    @yield('scripts')


</body>

</html>