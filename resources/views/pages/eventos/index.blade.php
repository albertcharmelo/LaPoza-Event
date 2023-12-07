@extends('layouts.dashboard')
<!-- Datatable -->

@section('css')
<link href="{{ asset('vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/dashboard/eventos.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Todos los eventos</h4>
                </div>
                <div class="card-body px-3">
                    <div class="table-responsive">
                        <table id="eventosTable" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th with="45%">Nombre del organizador</th>
                                    <th with="10%">Teléfono</th>
                                    <th with="30%">Título de la invitación</th>
                                    <th with="5%" class="text-center">Comensales</th>
                                    <th with="5%" class="text-center">Fecha</th>
                                    <th with="5%" class="text-center">Activo</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th with="45%">Nombre del Organizador</th>
                                    <th with="10%">Teléfono</th>
                                    <th with="30%">Título de la Invitación</th>
                                    <th with="5%" class="text-center">Comensales</th>
                                    <th with="5%" class="text-center">Fecha</th>
                                    <th with="5%" class="text-center">Activo</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<!-- Datatable -->
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/dashboard/eventos.js') }}" type="text/javascript"></script>
@endsection