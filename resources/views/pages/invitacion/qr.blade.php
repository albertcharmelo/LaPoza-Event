@extends('layouts.invitaciones')
@section('css')

<style>
    .borde-negro {
        border: 1px solid #b5b5cde3;
        width: 100%;
        min-width: 100%;
        height: auto;

    }
</style>

@endsection
@section('content')
<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="qr-chooise px-5 py-3" id="QrCodeBox">
                <div class="d-flex flex-column items-center justify-center w-100">
                    <h1 class="text-center">Invitacion de {{ $invitado->nombre }}
                    </h1>
                    <h6 class="text-muted text-center">Con el siguiente codigoQr podra
                        confirmar su asistencia el día evento. Además de con este poder consumir en el evento.</h6>
                    <h1 class="mb-2 text-black text-center" style="font-size: 3rem !important">{{
                        $invitado->invitacion->titulo }}
                    </h1>
                    <ul class="mb-0 w-100 justify-content-center post-meta d-flex flex-wrap">
                        <li class="post-author me-3">
                            <h4>Por {{ $invitado->evento->nombre }}</h4>
                        </li>
                        <li class="post-date me-3">
                            <h4>
                                <i class="fas fa-calendar-check me-2"></i>
                                {{\Carbon\Carbon::parse($invitado->evento->fecha)->format('d/m/Y') }}
                            </h4>
                        </li>

                    </ul>
                    <div class="d-flex justify-content-center w-100 align-items-center h-auto my-5">
                        <img src="data:image/png;base64,{{ $invitado->codigoQr->path }}" alt="Qr del evento"
                            id="qrImageBase64" class="img-fluid mb-3 rounded" style="max-height: 300px;width:auto">
                    </div>
                    @if ($invitado->invitacion->tipo_menu != 'Menu Fijo con Precio' && $invitado->invitacion->tipo_menu
                    != 'Menu Fijo sin Precio')
                    <div class="my-3 d-flex flex-column gap-3">
                        @foreach ($invitado->platos_elegidos as $plato)
                        @foreach ($plato as $pregunta => $opcion_elegida)
                        <div>
                            <h2 class="text-center">{{ $pregunta }} </h2>
                            <h3 class="borde-negro w-100 h-auto py-2 rounded text-center">
                                {{ $opcion_elegida }}
                            </h3>
                            {{-- <input type="text" name="plato" readonly value="{{ $opcion_elegida }}"
                                class="form-control text-center" style="font-size: 18px"> --}}
                        </div>
                        @endforeach

                        @endforeach
                        @if ($invitado->observaciones != null || $invitado->observaciones != '')
                        <div>
                            <h3 class="text-center"> Observaciones / Alergias / Intolerancias</h3>
                            <textarea name="observaciones" readonly id="" cols="30" rows="10" class="form-control"
                                style="font-size: 18px">{{ $invitado->observaciones }}</textarea>
                        </div>
                        @endif

                    </div>
                    @endif



                </div>
            </div>
        </div>

    </div>
</div>

@endsection
@section('scripts')
@endsection