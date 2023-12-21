@extends('layouts.invitaciones')
@section('css')

<link href="{{ asset('vendor/carrusel/dist/assets/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('vendor/carrusel/dist/assets/owl.theme.default.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<style>
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
</style>
@endsectio
@endsection
@section('content')
<input id="idInvitado" value="{{ $invitado->id }}" type="hidden" />
<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="plates-chooise" id="platosBox">
                @php
                $menuImages = $invitacion->imagenes->filter(function ($imagen) {
                return $imagen->pivot->tipo_imagen == 'menu';
                });
                @endphp
                @if ($menuImages->count() > 0)
                <h2>Menú a servir dentro del Evento</h2>
                @endif
                @foreach ($invitacion->imagenes as $imagen)
                @if ($imagen->pivot->tipo_imagen == 'menu')
                @if ($imagen->formato == 'application/pdf')
                <iframe src="data:application/pdf;base64,{{ $imagen->imagen_base64 }}" frameborder="0"
                    class="mb-3 rounded"></iframe>
                @else
                <img src="data:image/png;base64,{{ $imagen->imagen_base64 }}" alt="Imagen del evento"
                    class="img-fluid mb-3 w-100 rounded">
                @endif
                @endif
                @endforeach

                @if ($invitacion->tipo_menu == 'Menu a Elegir con Precio' ||
                $invitacion->tipo_menu == 'Menu a Elegir sin Precio')
                <h1>Selecciona los platos del menú</h1>
                <div class="row" style="background-color: white;">
                    @php
                    $alternating = 1;
                    @endphp
                    @foreach ($invitacion->platos_opciones as $key => $opciones)
                    <div class="my-2 col-12  p-2 platos_select">
                        @foreach ($opciones as $pregunta => $plato)


                        <div class="border border-primary p-4 rounded ">
                            <h2 class="form-label my-3 plato_question">{{ $pregunta }}</h2>
                            <div class="d-flex flex-column gap-3 mb-3 opcion_plato_box">
                                @foreach ($plato as $plato_opcion)
                                @php
                                $plato_seleccionado = get_object_vars($invitado->platos_elegidos[$key])[$pregunta] ==
                                $plato_opcion
                                @endphp
                                <div onclick="selectPlato(event)" style="cursor: pointer"
                                    class="d-flex flex-wrap gap-3 align-items-center py-2 px-1 rounded {{ $alternating == 1 ? 'alternating_1' : 'alternating_2' }}">
                                    <input type="radio" {{ $plato_seleccionado ? 'checked' : '' }}
                                        name="{{ $pregunta }}" class="form-check-input opcion_plato"
                                        value="{{ $plato_opcion }}" id="">
                                    <h4 onclick="selectPlatoH4(event)" class="text-center mb-0">{{ $plato_opcion }}</h4>
                                </div>
                                @php
                                $alternating = $alternating == 1 ? 2 : 1;
                                @endphp
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            <div class="owl-carousel owl-theme">
                <div class="item">
                    <img
                        src="https://multimarca.com.ve/wp-content/uploads/2022/11/Captura-de-Pantalla-2022-11-21-a-las-6.50.59-p.-m.png" />
                </div>
                <div class="item">
                    <img src="https://eldiario.com/wp-content/uploads/2023/01/tsize-600x400-VEHICULOS-SAIPA-IR.jpg" />
                </div>

            </div>

            <div class="card-footer">
                <button class="btn btn-primary btn-block" id="btnActualizarPlatos">actualizar platos</button>
            </div>
        </div>
    </div>

    @endsection
    @section('scripts')
    <script src="https://unpkg.com/imask"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('vendor/carrusel/dist/owl.carousel.js') }}"></script>
    <script src="{{ asset('js/invitado/editarPlato.js') }}" type="text/javascript"></script>

    @endsection