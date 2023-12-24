@extends('layouts.dashboard')
@section('css')
<link href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/dashboard/eventos.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">

    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{ url('/') }}">Plantillas</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ $plantilla->name }}</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <ul class="nav nav-tabs">
                                <li class="nav-item "><a id="invitados-tab" href="#my-posts" data-bs-toggle="tab"
                                        class="nav-link show">Detalles de la plantilla</a>
                                </li>



                            </ul>
                            <div class="tab-content">
                                <div class="w-100 d-flex justify-content-end">
                                    <button class="btn btn-primary btn-sm mt-2">Editar Plantilla</button>

                                </div>
                                <div id="my-posts" class="tab-pane fade active show">
                                    <div class="my-post-content pt-3">
                                        {{-- tabla de invitados --}}
                                        <div class="card-body  p-0 row">
                                            <div class="col-12 col-md-8">
                                                <h3>Nombre plantilla</h3>
                                                <input class="form-control" type="text" readonly
                                                    value='{{ $plantilla->name }}' />
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <h3>Tipo de Menu</h3>
                                                <input class="form-control" type="text" readonly
                                                    value='{{ $plantilla->tipo_menu }}' />
                                            </div>

                                            <div class="col-12 my-lg-2">
                                                <h3>Descripción</h3>
                                                <input class="form-control" type="text" readonly
                                                    value='{{ $plantilla->description }}' />
                                            </div>

                                            <div class="col-12 mt-3">
                                                <h3>Menu</h3>
                                                @if ($plantilla->tipo_menu == 'Menu a Elegir con Precio' ||
                                                $plantilla->tipo_menu == 'Menu a Elegir sin Precio')

                                                <div class="row" style="background-color: white;">
                                                    @php
                                                    $alternating = 1;
                                                    $platos_opciones = json_decode($plantilla->platos);

                                                    @endphp
                                                    @foreach ($platos_opciones as $key => $opciones)
                                                    <div class="my-2 col-12  p-2 platos_select">
                                                        @foreach ($opciones as $pregunta => $plato)
                                                        <div class="border border-primary p-4 rounded ">
                                                            <h2 class="form-label my-3 plato_question">{{ $pregunta }}
                                                            </h2>
                                                            <div class="d-flex flex-column gap-3 mb-3 opcion_plato_box">
                                                                @foreach ($plato as $plato_opcion)
                                                                @php
                                                                if ($plantilla->tipo_menu == 'Menu a Elegir con
                                                                Precio') {
                                                                $plato_opcion_array = explode('-', $plato_opcion);
                                                                $plato_opcion_show = $plato_opcion_array[1]. " - " .
                                                                $plato_opcion_array[0];
                                                                }else{
                                                                $plato_opcion_show = $plato_opcion;
                                                                }

                                                                @endphp
                                                                <div onclick="selectPlato(event)"
                                                                    style="cursor: pointer"
                                                                    class="d-flex flex-wrap gap-3 align-items-center py-2 px-1 rounded {{ $alternating == 1 ? 'alternating_1' : 'alternating_2' }}">

                                                                    <h4 onclick="selectPlatoH4(event)"
                                                                        class="text-center mb-0">{{ $plato_opcion_show
                                                                        }}
                                                                    </h4>
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

                                        </div>

                                    </div>




                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
@section('scripts')
<script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>


@endsection