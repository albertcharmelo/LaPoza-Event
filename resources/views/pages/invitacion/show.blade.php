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
</style>
@endsection
@section('content')
<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="post-details" id="postBox">
                <h1 class="mb-2 text-black" style="font-size: 3rem !important">{{ $invitacion->titulo }}</h1>
                <ul class="mb-0 post-meta d-flex flex-wrap">
                    <li class="post-author me-3">
                        <h4>Por {{ $invitacion->evento->nombre }}</h4>
                    </li>
                    <li class="post-date me-3">
                        <h4>
                            <i class="fas fa-calendar-check me-2"></i>
                            {{\Carbon\Carbon::parse($invitacion->evento->fecha)->format('d/m/Y') }}
                        </h4>
                    </li>

                </ul>
                <div class="my-2 py-0 texto_invitacion">{!! $invitacion->texto !!}</div>
                @php
                    $menuImages = $invitacion->imagenes->filter(function ($imagen) {
                        return $imagen->pivot->tipo_imagen == 'imagen';
                    });
                @endphp
                @if ($menuImages->count() > 0)  
                    <h2>Imagenes</h2>
                 @endif
                @foreach ($invitacion->imagenes as $imagen)
                @if ($imagen->pivot->tipo_imagen == 'imagen')
                    @if ($imagen->formato == 'application/pdf')
                        <iframe src="data:application/pdf;base64,{{ $imagen->imagen_base64 }}"
                        class="mb-3 rounded"></iframe>
                    @else
                        <img src="data:image/png;base64,{{ $imagen->imagen_base64 }}" alt="Imagen del evento"
                        class="img-fluid mb-3 w-100 rounded ">
                    @endif                
                @endif
                @endforeach
            </div>
            <div class="plates-chooise" id="platosBox">
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
                                <div onclick="selectPlato(event)" style="cursor: pointer"
                                    class="d-flex flex-wrap gap-3 align-items-center py-2 px-1 rounded {{ $alternating == 1 ? 'alternating_1' : 'alternating_2' }}">
                                    <input type="radio" name="{{ $pregunta }}" class="form-check-input opcion_plato"
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

                @php
                    $menuImages = $invitacion->imagenes->filter(function ($imagen) {
                        return $imagen->pivot->tipo_imagen == 'menu';
                    });
                @endphp
                @if ($menuImages->count() > 0)  
                    <h2>Menu a servir dentro del Evento</h2>
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

            </div>
            <div class="datos-chooise" id="datosBox">
                <h1>Datos de la invitación</h1>
                <h4 class="text-muted">A continuación complete los datos personales requeridos para confirmar su
                    asistencia.</h4>
                <form class="formulario d-flex flex-column gap-2 mt-3 py-3" id="datosFormulario" method="POST">
                    @csrf
                    <input type="hidden" name="invitacion_id" value="{{ $invitacion->id }}">
                    <input type="hidden" name="evento_id" value="{{ $invitacion->evento->id }}">
                    <div class=" my-2">
                        <label class="form-label font-w600 text-black">Nombre</label>
                        <input type="text" class="form-control borde-negro" autocomplete="off" id="nombre" name="nombre"
                            placeholder="Introduzca su nombre">
                    </div>
                    <div class=" my-2">
                        <label class="form-label font-w600 text-black">
                            Correo electrónico
                        </label>
                        <input type="email" class="form-control borde-negro" autocomplete="off" id="email" name="email"
                            placeholder="Introduzca su correo electrónico">
                    </div>
                    <div class=" my-2">
                        <label class="form-label font-w600 text-black">
                            Teléfono
                        </label>
                        <input type="text" class="form-control borde-negro" autocomplete="off" id="telefono"
                            name="telefono" pattern="[0-9]{9}" placeholder="Introduzca su teléfono">
                    </div>
                    <div class="d-none">
                        <label for="" class="form-label font-w600 text-black">
                            Número de invitados
                        </label>
                        <input type="number" class="form-control borde-negro" id="invitados" value="1" name="invitados"
                            min="1" step="1" placeholder="Introduzca el número de invitados">
                    </div>
                    <div class=" my-2">
                        <label for="" class="form-label font-w600 text-black">
                            Observaciones / Alergias / Intolerancias
                        </label>
                        <textarea class="form-control borde-negro" id="observaciones" name="observaciones" rows="4"
                            style="min-height: 120px"
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