@extends('layouts.invitaciones')
@section('css')
@endsection
@section('content')
<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="qr-chooise px-5 py-3" id="QrCodeBox">
                <div class="d-flex flex-column items-center justify-center w-100">
                    <h1 class="text-center">Invitacion de {{ $invitado->nombre }}
                    </h1>
                    <p class="text-muted text-center">Con el siguiente codigoQr podra
                        confirmar su asistencia el día evento. Además de con este poder consumir en el evento.</p>
                    <div class="d-flex justify-content-center w-100 align-items-center h-auto my-5">
                        <img src="data:image/png;base64,{{ $invitado->codigoQr->path }}" alt="Qr del evento"
                            id="qrImageBase64" class="img-fluid mb-3 rounded" style="max-height: 300px;width:auto">
                    </div>
                    @if ($invitado->invitacion->tipo_menu != 'Menu Fijo con Precio' && $invitado->invitacion->tipo_menu
                    != 'Menu Fijo sin Precio')
                    <div class="my-3 d-flex flex-column gap-3">
                        @foreach ($invitado->platos_elegidos as $index => $plato)
                        <div>
                            <h3 class="text-center">Plato {{ $index + 1 }}° elegido: </h3>
                            <input type="text" name="plato" value="{{ $plato }}" class="form-control text-center"
                                style="font-size: 18px">
                        </div>
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