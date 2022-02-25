@extends('main')

@section('title')
    <title>{{ config('app.name') }} Tarifs</title>
@endsection

@section('styles')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper teste" style="min-height: inherit!important;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mes zones de travail</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">

                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content-header -->

        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header" >
                                <h3 class="card-title">Liste de mes zones de travail</h3>
                                <button class="btn  float-right" style="background: #007bff;color:white;" data-toggle="modal" id="nouveau-zone" data-target="#modal-ajouter-zone"><span class="fa fa-plus"></span>&nbsp;Ajouter</button>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table  class="table table-bordered table-striped table-principale">
                                    <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($mes_zones) && $mes_zones->count() > 0)
                                        @foreach($mes_zones as $zone)
                                            <tr  >
                                                <td>
                                                    {{ucwords($zone->zone()->name)}}
                                                   
                                                </td>
                                                <td>
                                                    {{$zone->description()}}
                                               </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-sm-12" style="text-align: center;">
                                                            <button class="btn btn-primary btn-xs btn-voir-zone-transporteur" data-show="{{route('zone.modifier', ['zone' => $zone->id ])}}" data-url="{{route('zone.edit', ['zone' => $zone->id ])}}"><span class="fa fa-eye"></span></button>
                                                            <button class="btn btn-xs btn-danger btn-supprimer-zone-transporteur" data-show="{{route('tarif.modifier', ['ZoneTransporteur' => $zone->id ])}}" data-url="{{route('tarif.supprimer', ['ZoneTransporteur' => $zone->id ])}}"><span class="fa fa-trash"></span></button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                     <tr>
                                         <td style="text-align: center" colspan="3">
                                            Aucune zone de travail dans la liste
                                        </td>
                                     </tr>
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Description</th>
                                        <th>Actions</th>

                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!---- modal pour ajouter zone --->
    <div class="modal fade" id="modal-ajouter-zone">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-success">
                    <h4 class="modal-title">Ajouter une zone</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-ajouter-zone">
                    <form method="POST" action="{{route('tarif.ajouter')}}" name="form-zone-transporteur-ajouter" id="form-zone-transporteur-ajouter" class="row">
                        @csrf
                        <div class="col-sm-4">
                            <label for="zone_transport">Zones :</label>
                        </div>
                        <div class="col-sm-8">
                            <select  name="zone"  class=" js-states form-control select-zone"   placeholder="Nom des zones" style="width:100%;" autocomplete="off">
                                @foreach ($zones as $zone)
                                    <option value={{$zone->id}}>{{$zone->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    <button type="submit" id="button-ajouter-zone" form="form-zone-transporteur-ajouter"  class="float-right btn btn-success">Ajouter</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!---- / modal pour ajouter zone-->

    

    <!---- modal pour suppression d'une zone --->
    <div class="modal fade" id="modal-supprimer-zone-transporteur">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-danger">
                    <h4 class="modal-title">Supprimer une zone de transporteur</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-supprimer-zone-transporteur">
                    <div  class="row">
                        @csrf
                        <div class="col-sm-4">
                            <label for="zone_transporteur">Zones :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" disabled name="zone_transporteur" class="form-control" id="zone_transporteur">
                        </div>
                    </div>
                </div>
                <div class="modal-footer row">
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                        <div class="col-sm-8" style="text-align: right;">
                            <a href="" style="text-align: right !important;" >
                                <button id="btn-supprimer-zone-transporteur" type="button"  class=" btn btn-danger">Supprimer</button>
                            </a>
                        </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal pour suppression d'une zone -->

@endsection
@section('scripts')
    <!-- DataTables -->
    <script src="{{asset('assets/adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <!-- InputMask -->
    <script src="{{asset('assets/adminlte/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('assets/adminlte/plugins/inputmask/min/jquery.inputmask.bundle.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <!-- page script -->
    <script>

        $(document).ready(function(){

            $(".select-zone").select2({
                placeholder: "Nom des zones"
            });

            $(".table-principale").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "searching": true,
                    "paging": false,
                    "ordering": true,
                    "info": false,
                });

            $(document).on("click", ".btn-supprimer-zone-transporteur", function(e){
                let url = $(this).attr("data-show");
                let url_supprimer = $(this).attr("data-url");

                $("#modal-supprimer-zone-transporteur").find("#btn-supprimer-zone-transporteur").parent().attr("href", url_supprimer);
                $("#modal-supprimer-zone-transporteur").modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                $.get(url, {}, dataType="JSON").done(function(data){
                    $("#modal-supprimer-zone-transporteur").find("#zone_transporteur").val(data.name);
                })
            });

        })   

    </script>
@endsection
