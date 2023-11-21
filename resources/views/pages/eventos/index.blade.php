@extends('layouts.dashboard')
<!-- Datatable -->

@section('css')
    <link href="{{ asset('vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/dashboard/eventos.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Eventos</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Eventos</a></li>
            </ol>
        </div>
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

                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Comensales</th>
                                        <th>Fecha</th>
                                        <th>Activo</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Comensales</th>
                                        <th>Fecha</th>
                                        <th>Activo</th>
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
