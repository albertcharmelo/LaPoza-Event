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

    input {
        background-color: #212130 !important;
    }

    input:hover {
        background-color: #212130 !important;
    }
    @media (max-width: 768px) {
        iframe {
            width: 100%; /* Ocupa todo el ancho disponible */
            height: 500px; /* Altura fija para móviles */
        }
    }

    /* Estilos para dispositivos de escritorio */
    @media (min-width: 769px) {
        iframe {
            width: 100%;
            height: 1000px;/* Altura fija para escritorio */
        }
    }
    .alternating_1 {
        background-color: darkslategray;
    }
    .alternating_2 {
        background-color: black;
    }
</style>
@endsection
@section('content')
<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="post-details" id="postBox">
                <h1 class="mb-2 text-black">{{ $invitacion->titulo }}</h1>
                <ul class="mb-0 post-meta d-flex flex-wrap">
                    <li class="post-author me-3">Por {{ $invitacion->evento->nombre }}</li>
                    <li class="post-date me-3"><i class="fas fa-calendar-check me-2"></i>
                        {{
                        \Carbon\Carbon::parse($invitacion->evento->fecha)->format('d/m/Y') }}

                    </li>

                </ul>
                <p class="my-2 py-0">{!! $invitacion->texto !!}</p>
                @foreach ($invitacion->imagenes as $imagen)                
                @if ($imagen->pivot->tipo_imagen == 'imagen')
                    <img src="data:image/png;base64,{{ $imagen->imagen_base64 }}" alt="Imagen del evento"
                        class="img-fluid mb-3 w-100 rounded ">
                @endif
                @endforeach
            </div>
            <div class="plates-chooise" id="platosBox">


                @if ($invitacion->tipo_menu == 'Menu a Elegir con Precio' ||
                $invitacion->tipo_menu == 'Menu a Elegir sin Precio')
                <h1>Selecciona los platos del menú</h1>
                <h6 class="text-muted mb-4">Agrega las opciones para los {{ count($invitacion->platos_opciones) }}
                    platos
                    pulsando en el <span class="color-global">Seleccionador
                    </span> para cada platillo.</h6>
                <div class="row" style="background-color: white;">
                    @php
                        $alternating = 1;
                    @endphp
                    @foreach ($invitacion->platos_opciones as $key => $opciones)
                    <div class="my-2 col-12  p-2 platos_select">
                        @foreach ($opciones as $pregunta => $plato)
                        <div class="border border-primary p-4 rounded {{ $alternating == 1 ? 'alternating_1' : 'alternating_2' }}">

                            <h3 class="form-label my-3 plato_question">{{ $pregunta }}</h3>

                            <div class="d-flex flex-column gap-3 mb-3 opcion_plato_box">
                                @foreach ($plato as $plato_opcion)
                                <div class="d-flex gap-3 align-items-center">
                                    <input type="radio" name="{{ $pregunta }}" class="form-check-input opcion_plato"
                                        value="{{ $plato_opcion }}" id="">
                                    <h5 class="text-center mb-0">{{ $plato_opcion }}</h5>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @php
                            $alternating = $alternating == 1 ? 2 : 1;
                        @endphp
                        @endforeach

                    </div>
                    @endforeach

                </div>
                @else
                <h2>Menu a servir dentro del Evento</h2>
                <p class="text-muted">El siguiente menú fijo no estará sujeto a modificaciones </p>
                {{-- <img src="data:image/png;base64,{{ $invitacion->imagen }}" alt="Imagen del menu"
                    class="img-fluid mb-3 w-100 rounded "> --}}
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
                @endif

            </div>
            <div class="datos-chooise" id="datosBox">
                <h2>Datos de la invitación</h2>
                <p class="text-muted">A continuación complete los datos requeridos para confirmar su asistencia.</p>
                <form class="formulario d-flex flex-column gap-2" id="datosFormulario" method="POST">
                    @csrf
                    <input type="hidden" name="invitacion_id" value="{{ $invitacion->id }}">
                    <input type="hidden" name="evento_id" value="{{ $invitacion->evento->id }}">
                    <div class="">
                        <label class="form-label font-w600 text-black">Nombre *</label>
                        <input type="text" class="form-control" autocomplete="off" id="nombre" name="nombre"
                            placeholder="Introduzca su nombre">
                    </div>
                    <div class="">
                        <label class="form-label font-w600 text-black">
                            Correo electrónico
                        </label>
                        <input type="email" class="form-control" autocomplete="off" id="email" name="email"
                            placeholder="Introduzca su correo electrónico">
                    </div>
                    <div class="">
                        <label class="form-label font-w600 text-black">
                            Teléfono *
                        </label>
                        <input type="text" class="form-control" autocomplete="off" id="telefono" name="telefono"
                            pattern="[0-9]{9}" placeholder="Introduzca su teléfono">
                    </div>
                    <div class="d-none">
                        <label for="" class="form-label font-w600 text-black">
                            Número de invitados *
                        </label>
                        <input type="number" class="form-control" id="invitados" value="1" name="invitados" min="1" step="1"
                            placeholder="Introduzca el número de invitados">
                    </div>
                    <div class="">
                        <label for="" class="form-label font-w600 text-black">
                            Observaciones / Alergias / Intolerancias
                        </label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="4"
                            placeholder="Introduzca sus observaciones, alergias o intolerancias"></textarea>
                    </div>

                </form>
            </div>
            <div class="qr-chooise px-5 py-3" id="QrCodeBox">
                <div class="d-flex flex-column items-center justify-center w-100">
                    <h1 class="text-center">Invitacion confirmada con éxito
                    </h1>
                    <p class="text-muted text-center">Con el siguiente codigoQr podra
                        confirmar su asistencia el día evento. Además de con este poder consumir en el evento.</p>
                    <p class="text-center">Puede acceder a su codigo qr a
                        través del siguiente enlace <a id="urlToSeeQr" href="" target="_blank"></a>
                    </p>
                    <div class="d-flex justify-content-center w-100 align-items-center h-auto my-5">
                        <img src="" alt="Qr del evento" id="qrImageBase64" class="img-fluid mb-3 rounded"
                            style="max-height: 300px;width:auto">
                    </div>
                    <h2 class="text-center">
                        <span class="color-global">¡Gracias por confirmar su asistencia!, Te esperamos !!</span>
                    </h2>
                </div>

            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary btn-block" id="BtnNext">Continuar</button>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('js/invitaciones/invitaciones.js') }}" type="text/javascript"></script>
@endsection