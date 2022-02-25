@extends('main')

@section('title')
    <title>{{ config('app.name') }} | Zone de travail</title>
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
                        <h1>Zone de travail</h1>
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
                                <h3 class="card-title">Liste des zones de travail</h3>
                                <button class="btn  btn-success float-right"  data-toggle="modal" id="nouveau-zone" data-backdrop="static" data-keyboard="false" data-target="#modal-ajouter-zone"><span class="fa fa-plus"></span>&nbsp;Ajouter</button>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table  class="table table-bordered table-striped table-principale">
                                    <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($zones) && $zones->count() > 0)
                                        @foreach($zones as $zone)
                                            <tr  >
                                                <td>
                                                    {{ucwords($zone->name)}}
                                                   
                                                </td>
                                               
                                                <td>
                                                    <div class="row">
                                                        <div class="col-sm-12" style="text-align: center;">
                                                            <a href="{{route('zone.voir', ['zone' => $zone->id ])}}">
                                                                <button class="btn btn-xs btn-info btn-voir-zone"><span class="fa fa-eye"></span></button>
                                                            </a>
                                                            <button class="btn btn-primary btn-xs btn-modifier-zone" data-show="{{route('zone.modifier', ['zone' => $zone->id ])}}" data-url="{{route('zone.edit', ['zone' => $zone->id ])}}"><span class="fa fa-edit"></span></button>
                                                            <button class="btn btn-xs btn-danger btn-supprimer-zone" data-url="{{route('zone.supprimer', ['zone' => $zone->id ])}}" ><span class="fa fa-trash"></span></button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                     <tr>
                                         <td style="text-align: center" colspan="2">
                                            Aucune zone de travail dans la liste
                                        </td>
                                     </tr>
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Nom</th>
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
                    <h4 class="modal-title">Ajouter une zone de travail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" >
                    <form action="{{route('zone.ajouter')}}" method="post" role="form" id="form-ajouter-zone" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="name">Nom :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control" placeholder="Nom" required autocomplete="off">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <label for="district">Districts :</label>
                            </div>
                            <div class="col-sm-8">
                                <select name="district[]"  class="js-example-basic-multiple js-states form-control select-district"  multiple="multiple" placeholder="Nom des districts" style="width:100%;" autocomplete="off">
                                    @foreach ($districts as $district)
                                        <option value={{$district->id}}>{{$district->nom}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    <button type="submit" id="button-ajouter-zone" form="form-ajouter-zone" class="float-right btn btn-success">Ajouter</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!---- / modal pour ajouter zone -->

    
    <!---- modal pour modifier zone --->
    <div class="modal fade" id="modal-modifier-zone">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 class="modal-title">Modifier une zone de travail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" >
                    <form action="#" method="post" role="form" id="form-modifier-zone" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="name">Nom :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control" placeholder="Nom" required autocomplete="off">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <label for="districts">Districts :</label>
                            </div>
                            <div class="col-sm-8">
                                <select name="district[]"  class="js-example-basic-multiple js-states form-control select-district"  multiple="multiple" placeholder="Nom des districts" style="width:100%;" autocomplete="off">
                                    @foreach ($districts as $district)
                                        <option value={{$district->id}}>{{$district->nom}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    <button type="submit" id="button-modifier-zone" form="form-modifier-zone" class="float-right btn btn-primary">Modifier</button>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!---- / modal pour ajouter zone -->

    <!---- modal pour supprimer zone --->
    <div class="modal fade" id="modal-supprimer-zone">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-danger">
                    <h4 class="modal-title">Supprimer une zone de travail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" >
                    <form action="#" method="post" role="form" id="form-supprimer-zone" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="name">Nom :</label>
                            </div>
                            <div class="col-sm-8">
                                <input disabled type="text" name="name" class="form-control" placeholder="Nom" required autocomplete="off">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <label for="districts">Districts :</label>
                            </div>
                            <div class="col-sm-8">
                                <select disabled name="district[]"  class="js-example-basic-multiple js-states form-control select-district"  multiple="multiple" placeholder="Nom des districts" style="width:100%;" autocomplete="off">
                                    @foreach ($districts as $district)
                                        <option value={{$district->id}}>{{$district->nom}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    <a href="">
                        <button type="button" id="button-supprimer-zone"  class="float-right btn btn-danger">Supprimer</button>

                    </a>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!---- / modal pour supprimer zone -->
    

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

    <script>
        $(document).ready(function(){
            $(".select-district").select2({
                placeholder: "Nom des districts"
            });

            $(".table-principale").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "searching": true,
                    "paging": false,
                    "ordering": true,
                    "info": false,
                });
            // ------------------ EVENTE ---------------

            $(document).on("click", ".btn-supprimer-zone", function (e) {
                $("#modal-supprimer-zone").modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                let url = $(this).prev().attr("data-show");
                let url_delete = $(this).attr("data-url");

                $("#button-supprimer-zone").parent().attr("href", url_delete);

                $.get(url, {}, dataType="JSON").done(function (data) {
                    $("#modal-supprimer-zone ").find('input[name="name"]').val(data.zone.name);
                    $("#modal-supprimer-zone ").find('select').val(data.district).change();


                })
            })

            $(document).on("click", ".btn-modifier-zone", function (e) {

                $("#modal-modifier-zone").modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                
                let url = $(this).attr("data-show");
                let url_edit = $(this).attr("data-url");

                $("#form-modifier-zone").attr('action', url_edit);

                $.get(url, {}, dataType="JSON").done(function (data) {
                    $("#modal-modifier-zone ").find('input[name="name"]').val(data.zone.name);
                    $("#modal-modifier-zone ").find('select').val(data.district).change();


                })
            })
        })
    </script>

   
@endsection
