@extends('layouts.dashboard')
<!-- Datatable -->

@section('css')
    <link href="{{ asset('vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Invitaciones</h4>
                    </div>
                    <div class="card-body px-3">
                        <div class="table-responsive">
                            <table id="invitacionesTable" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th width="40%">Título</th>
                                        <th width="20%">Tipo/Menú</th>
                                        <th width="10%">Fecha</th>
                                        <th width="20%">Organizador</th>
                                        <th width="10%">Fecha Evento</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th width="40%">Título</th>
                                        <th width="20%">Tipo/Menú</th>
                                        <th width="10%">Fecha</th>
                                        <th width="20%">Organizador</th>
                                        <th width="10%">Fecha Evento</th>
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
    <script src="{{ asset('js/dashboard/invitaciones/invitaciones_index.js') }}" type="text/javascript"></script>
@endsection
