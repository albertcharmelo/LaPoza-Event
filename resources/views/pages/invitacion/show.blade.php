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
                <img src="data:image/png;base64,{{ $imagen->imagen_base64 }}" alt="Imagen del evento"
                    class="img-fluid mb-3 w-100 rounded ">
                @endforeach
            </div>
            <div class="plates-chooise" id="platosBox">
                @if ($invitacion->tipo_menu == 'Menu a Elegir con Precio' || $invitacion->tipo_menu == 'Menu a Elegir
                sin Precio')
                <h2>Selecciona los platos del menú</h2>
                <p class="text-muted">Agrega las opciones para los {{ count($invitacion->platos_opciones) }} platos
                    pulsando en el <span class="color-global">Seleccionador
                    </span> para cada platillo.</p>
                @for ($i = 0; $i < count($invitacion->platos_opciones); $i++)
                    <div class="my-2">
                        <label class="form-label">Seleccione el {{ $i + 1 }}º plato</label>
                        <select class="form-control platos_select">
                            <option selected disabled hidden value="">
                                Seleccione una opción
                            </option>
                            @foreach ($invitacion->platos_opciones[$i] as $plato)
                            <option value="{{ $plato }}">{{ $plato }}</option>
                            @endforeach
                        </select>
                    </div>

                    @endfor
                    @else
                    <h2>Menu a servir dentro del Evento</h2>
                    <p class="text-muted">El siguiente menú fijo no estará sujeto a modificaciones </p>
                    <img src="data:image/png;base64,{{ $invitacion->imagen }}" alt="Imagen del menu"
                        class="img-fluid mb-3 w-100 rounded ">
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
                        <label class="form-label">Nombre *</label>
                        <input type="text" class="form-control" autocomplete="off" id="nombre" name="nombre"
                            placeholder="Introduzca su nombre">
                    </div>
                    <div class="">
                        <label class="form-label">
                            Correo electrónico *
                        </label>
                        <input type="email" class="form-control" autocomplete="off" id="email" name="email"
                            placeholder="Introduzca su correo electrónico">
                    </div>
                    <div class="">
                        <label class="form-label">
                            Teléfono
                        </label>
                        <input type="text" class="form-control" autocomplete="off" id="telefono" name="telefono"
                            pattern="[0-9]{9}" placeholder="Introduzca su teléfono">
                    </div>
                    <div class="">
                        <label for="" class="form-label">
                            Número de invitados *
                        </label>
                        <input type="number" class="form-control" id="invitados" name="invitados" min="1" step="1"
                            placeholder="Introduzca el número de invitados">
                    </div>
                    <div class="">
                        <label for="" class="form-label">
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('js/invitaciones/invitaciones.js') }}" type="text/javascript"></script>
@endsection