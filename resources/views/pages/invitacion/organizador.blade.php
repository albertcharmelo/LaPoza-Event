@extends('layouts.invitaciones')
@section('css')
<link href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .plates-chooise {
        display: none;
    }

    .datos-chooise {
        display: none;
    }

    .qr-chooise {
        display: none;
    }

    /* input {
        background-color: #212130 !important;
    }

    input:hover {
        background-color: #212130 !important;
    } */

    @media (max-width: 768px) {
        iframe {
            width: 100%;
            /* Ocupa todo el ancho disponible */
            height: 500px;
            /* Altura fija para móviles */
        }

        .opcion_plato {
            width: 20px;
            height: 20px;
        }
    }

    /* Estilos para dispositivos de escritorio */
    @media (min-width: 769px) {
        iframe {
            width: 100%;
            height: 1000px;
            /* Altura fija para escritorio */
        }


    }

    .texto_invitacion,
    .texto_invitacion * {
        font-size: 2rem;
        color: #212130;
    }

    .alternating_1 {
        background-color: #f2f2f2;
    }

    label {
        font-size: 1.3rem;
    }

    .alternating_2 {
        background-color: #fff;
    }

    .borde-negro {
        border: 1px solid #b5b5cde3;
    }

    .font-roboto {
        font-family: 'Roboto', sans-serif !important;
    }
</style>
@endsection
@section('content')
@endsection
@section('scripts')
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('js/invitaciones/invitaciones.js') }}" type="text/javascript"></script>
@endsection