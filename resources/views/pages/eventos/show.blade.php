@extends('layouts.dashboard')
@section('css')
<link href="{{ asset('vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    <input type="text" class="d-none" readonly id="evento_id" value="{{ $evento->id }}">
    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{ url('/') }}">Eventos</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ $evento->nombre }}</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
            <div class="widget-stat card">
                <div class="card-body p-4">
                    <div class="media ai-icon">
                        <span class="me-3 bgl-primary text-primary">
                            <!-- <i class="ti-user"></i> -->
                            <svg id="icon-customers" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </span>
                        <div class="media-body">
                            <p class="mb-1">Invitados</p>
                            <h4 class="mb-0"> {{ $evento->invitadosConfirmados->count() }} / {{
                                $evento->invitados->count() }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
            <div class="widget-stat card">
                <div class="card-body p-4">
                    <div class="media ai-icon">

                        <span class="me-3 bgl-success text-success">
                            <svg id="icon-database-widget" xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-users-group" width="30" height="30"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                            </svg>

                        </span>
                        <div class="media-body">
                            <p class="mb-1">Comensales</p>
                            <h4 class="mb-0">
                                {{ $evento->invitadosConfirmados->sum('numero_personas') }} / {{
                                $evento->invitados->sum('numero_personas') }}
                            </h4>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
            <div class="widget-stat card">
                <div class="card-body  p-4">
                    <div class="media ai-icon">
                        <span class="me-3 bgl-danger text-danger">
                            <svg id="icon-revenue" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </span>
                        <div class="media-body">
                            <p class="mb-1">Ingreso bruto</p>
                            <h4 class="mb-0">{{ $evento->ingreso_bruto }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
            <div class="widget-stat card">
                <div class="card-body p-4">
                    <div class="media ai-icon">
                        <span class="me-3 bgl-warning text-warning">
                            <svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </span>
                        <div class="media-body">
                            <p class="mb-1">Status</p>
                            <h4 class="mb-0">{{ $evento->status === 1 ? 'Abierta' : 'Cerrada' }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <ul class="nav nav-tabs">
                                <li class="nav-item "><a href="#my-posts" data-bs-toggle="tab"
                                        class="nav-link show active">Invitados</a>
                                </li>
                                <li class="nav-item"><a href="#about-me" data-bs-toggle="tab" class="nav-link">Detalles
                                        del evento</a>
                                </li>

                            </ul>
                            <div class="tab-content">
                                <div id="my-posts" class="tab-pane fade active show">
                                    <div class="my-post-content pt-3">
                                        {{-- tabla de invitados --}}
                                        <div class="">
                                            <h4 class="card-title">Todos los eventos</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="invitadosTable" class="display" style="min-width: 845px">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Télefono</th>
                                                            <th>N° Comensales</th>
                                                            <th>Asistencia</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Télefono</th>
                                                            <th>N° Comensales</th>
                                                            <th>Asistencia</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="about-me" class="tab-pane fade">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="post-details">
                                                    <h3 class="mb-2 text-black">{{ $evento->invitacion->texto }}</h3>
                                                    <ul class="mb-4 post-meta d-flex flex-wrap">
                                                        <li class="post-author me-3">Por {{ $evento->nombre }}</li>
                                                        <li class="post-date me-3"><i
                                                                class="fas fa-calendar-check me-2"></i>
                                                            {{
                                                            \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}

                                                        </li>

                                                    </ul>
                                                    <img src="{{ $evento->invitacion->imagen }}" width="908"
                                                        height="359" alt="Imagen del evento"
                                                        class="img-fluid mb-3 w-100 rounded">
                                                    {{-- <p>{{ $evento->invitacion->texto }}</p> --}}
                                                    <div class="profile-skills mt-5 mb-5">
                                                        <h4 class="text-primary mb-2">Tipo de menu</h4>
                                                        <a href="javascript:void();;"
                                                            class="btn btn-primary light btn-xs mb-1">{{
                                                            $evento->invitacion->tipo_menu }}</a>

                                                    </div>
                                                    <div class="comment-respond" id="respond">
                                                        <h4 class="comment-reply-title text-primary mb-3"
                                                            id="reply-title">Datos del Organizador </h4>
                                                        <form class="comment-form" id="commentform" method="post">
                                                            <div class="row">
                                                                <div class=" col-12 col-lg-4">
                                                                    <div class="mb-3">
                                                                        <label for="author"
                                                                            class="text-black font-w600 form-label">Nombre

                                                                        </label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $evento->nombre }}" readonly
                                                                            name="Author" placeholder="Author"
                                                                            id="author">
                                                                    </div>
                                                                </div>
                                                                <div class=" col-12 col-lg-4">
                                                                    <div class="mb-3">
                                                                        <label for="email"
                                                                            class="text-black font-w600 form-label">Email

                                                                        </label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $evento->email_organizador }}"
                                                                            placeholder="Email" readonly name="Email"
                                                                            id="email">
                                                                    </div>
                                                                </div>
                                                                <div class=" col-12 col-lg-4">
                                                                    <div class="mb-3">
                                                                        <label for="email"
                                                                            class="text-black font-w600 form-label">Télefono

                                                                        </label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $evento->telefono_organizador }}"
                                                                            placeholder="telefono" readonly
                                                                            name="telefono" id="telefono">
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </form>
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

    </div>

</div>
@endsection
@section('scripts')

<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/dashboard/eventosDetails.js') }}" type="text/javascript"></script>
@endsection