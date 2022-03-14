@extends('main')

@section('title')
<title>{{ config('app.name') }} | Zone de travail</title>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-selection__rendered {
        padding: 0!important;
        margin: 0!important;
    }

    .select2-container .select2-selection--single {
        display: flex;
        justify-content: flex-start;
        align-content: center;
        align-items: center;
    }
</style>
@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper teste" style="min-height: inherit!important;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $rn->nom }}</h1>
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
    <div class="row">
        <div class="col-md-12 px-3">
            <div class="card card-info card-outline" style="border-color:#3490c1 !important">
                <div class="card-header">
                    <h4 class="text-center" >Les villes de la zone</h4>
                    <div class="card-tools">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->
                    </div>
                    <!-- /.card-tools -->
                </div>
                <div class="card-body box-profile">
                    <div class="row">
                        <div class="col-sm-12" style="min-width:220px !important;">
                            <p class="text-center mt-3">
                                @forelse ($villes as $key => $ville)
                                {{ $key > 0 ? " - " . $ville->nom : $ville->nom }}
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#Categorisation" data-toggle="tab">Catégorisation</a>
                        </li>
                        <li class="nav-item d-none"><a class="nav-link " href="#production" data-toggle="tab">Production</a></li>

                        <li class="nav-item d-none"><a class="nav-link" href="#livraison" data-toggle="tab">Livraison</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="Categorisation">
                            <!-- About Me Box -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Catégorie selon itinéraire</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-12 text-right">
                                            <button class="btn btn-primary" data-toggle="modal" id="nouveau-itineraire" data-backdrop="static" data-keyboard="false" data-target="#modal-ajouter-itineraire"><span class="fa fa-plus"></span>&nbsp;Ajouter</button>
                                        </div>
                                    </div>
                                    <table id="itineraire-categorie" class="mt-2 table-principale table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-uppercase">
                                                <th>Itinéraire</th>
                                                <th>Délais approximatif</th>
                                                <th>Catégorie</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($itineraires as $itineraire)
                                            <tr>
                                                <td>{{ ucwords($itineraire->depart->nom). "   à   " .ucwords($itineraire->arrivee->nom) }}</td>
                                                <td>{{ $itineraire->delais_approximatif }}&nbsp;heure(s)</td>
                                                <td>{{ strtoupper($itineraire->categorie->nom) }}</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-sm-12" style="text-align: center;">
                                                            <button class="btn btn-success btn-xs btn-modifier-itineraire" data-show="{{route('zone.categorie.trouver', ['departCategorie' => $itineraire->id ])}}" data-url="{{route('zone.categorie.modifier', ['departCategorie' => $itineraire->id ])}}"><span class="fa fa-edit"></span></button>
                                                            <button class="btn btn-xs btn-danger btn-supprimer-zone" data-url="{{route('zone.categorie.supprimer', ['departCategorie' => $itineraire->id ])}}" ><span class="fa fa-trash"></span></button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4">
                                                    Aucun itinéraire dans la liste
                                                </td>
                                            </tr>
                                            @endforelse

                                        </tbody>
                                        <tfoot>
                                            <tr class="text-uppercase">
                                                <th>Itinéraire</th>
                                                <th>Délais approximatif</th>
                                                <th>Catégorie</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.tab-pane -->
                        <div class=" tab-pane" id="production">
                            <div class="card">
                                <div class="card-header card-header-success">
                                    <h3 class="card-title">Commande 001</h3>
                                    <button class="btn btn-default float-right" data-toggle="modal" data-target="#modal-default">Ajouter une production</button>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <!-- /.tab-pane -->

                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="livraison">
                            <div class="card">
                                <div class="card-header card-header-info">
                                    <h3 class="card-title">Commande 001</h3>
                                    <button class="btn btn-default float-right" data-toggle="modal" data-target="#modal-default-livraison">Ajouter une livraison</button>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
        </div>
    </div>

    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!---- modal pour ajouter itineraire --->
<div class="modal fade" id="modal-ajouter-itineraire">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Ajouter un itineraire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <form  method="POST" action="{{route('zone.categorie.ajouter')}}" name="form-itineraire-ajouter" id="form-itineraire-ajouter">
                    @csrf
                    <div class="row mt-2">
                        <div class="col-sm-4">
                            <label  for="depart">Départ :</label>
                        </div>
                        <div class="col-sm-8 ">
                            <select  autocomplete="off" name="depart"  class="form-control select-itineraire"   style="width:100% !important" placeholder="Nom des villes de départ"  autocomplete="off">
                                @foreach ($grandeVilles as $grandeVille)
                                <option value={{ $grandeVille->id }}>{{ $grandeVille->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label  for="arrive">Arrivé:</label>
                        </div>
                        <div class="col-sm-8 mt-2">
                            <select  autocomplete="off" name="arrive"  class="form-control select-itineraire "   style="width:100% !important" placeholder="Nom des villes d'arrivé"  autocomplete="off">
                                @foreach ($villes as $ville)
                                <option value={{ $ville->id }}>{{ $ville->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <label  for="categorie">Catégorie :</label>
                        </div>
                        <div class="col-sm-8 mt-2">
                            <select  autocomplete="off" name="categorie"  class="form-control"   style="width:100% !important" placeholder="Nom des villes d'arrivé"  autocomplete="off">
                                @foreach ($categories as $categorie)
                                <option value={{$categorie->id}}>{{$categorie->nom}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <label  for="categorie">Délais (heure) :</label>
                        </div>
                        <div class="col-sm-8 mt-2">
                            <input type="number" name="delais_approximatif" class="form-control w-100" id="" placeholder="Délais approximatif">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" id="button-ajouter-itineraire" form="form-itineraire-ajouter"  class="float-right btn btn-primary">Ajouter</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour ajouter itineraire-->

<!---- modal pour modifier itineraire --->
<div class="modal fade" id="modal-modifier-itineraire">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <h4 class="modal-title">Modifier un itineraire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <form  method="POST" action="#" name="form-itineraire-modifier" id="form-itineraire-modifier">
                    @csrf
                    <div class="row mt-2">
                        <div class="col-sm-4">
                            <label  for="depart">Départ :</label>
                        </div>
                        <div class="col-sm-8 ">
                            <select  name="depart"  class="form-control select-itineraire"   style="width:100% !important" placeholder="Nom des villes de départ"  autocomplete="off">
                                @foreach ($grandeVilles as $grandeVille)
                                <option value={{ $grandeVille->id }}>{{ $grandeVille->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label  for="arrive">Arrivé:</label>
                        </div>
                        <div class="col-sm-8 mt-2">
                            <select  name="arrive"  class="form-control select-itineraire "   style="width:100% !important" placeholder="Nom des villes d'arrivé"  autocomplete="off">
                                @foreach ($villes as $ville)
                                <option value={{ $ville->id }}>{{ $ville->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <label  for="categorie">Catégorie :</label>
                        </div>
                        <div class="col-sm-8 mt-2">
                            <select  name="categorie"  class="form-control"   style="width:100% !important" placeholder="Nom des villes d'arrivé"  autocomplete="off">
                                @foreach ($categories as $categorie)
                                <option value={{ $categorie->id }}>{{ $categorie->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <label  for="categorie">Délais (heure) :</label>
                        </div>
                        <div class="col-sm-8 mt-2">
                            <input type="number" name="delais_approximatif" class="form-control w-100" id="" placeholder="Délais approximatif">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" id="button-modifier-itineraire" form="form-itineraire-modifier"  class="float-right btn btn-success">Enregistrer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour modifier itineraire-->

<!---- modal pour supprimer itineraire --->
<div class="modal fade" id="modal-supprimer-itineraire">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h4 class="modal-title">Supprimer un itineraire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >

                <div class="row mt-2">
                    <div class="col-sm-4">
                        <label  for="depart">Départ :</label>
                    </div>
                    <div class="col-sm-8 ">
                        <select  disabled name="depart"  class="form-control select-itineraire"   style="width:100% !important" placeholder="Nom des villes de départ"  autocomplete="off">
                            @foreach ($grandeVilles as $grandeVille)
                            <option value={{ $grandeVille->id }}>{{ $grandeVille->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <label  for="arrive">Arrivé:</label>
                    </div>
                    <div class="col-sm-8 mt-2">
                            <select  disabled name="arrive"  class="form-control select-itineraire "   style="width:100% !important" placeholder="Nom des villes d'arrivé"  autocomplete="off">
                                @foreach ($villes as $ville)
                                <option value={{ $ville->id }}>{{ $ville->nom }}</option>
                                @endforeach
                            </select>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <label  for="categorie">Catégorie :</label>
                    </div>
                    <div class="col-sm-8 mt-2">
                        <select disabled  name="categorie"  class="form-control"   style="width:100% !important" placeholder="Nom des villes d'arrivé"  autocomplete="off">
                                    @foreach ($categories as $categorie)
                                        <option value={{ $categorie->id }}>{{ $categorie->nom }}</option>
                                    @endforeach
                        </select>
                    </div>

                </div>
            </div>
            <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    <a href="">
                        <button type="button" id="button-supprimer-itineraire"  class="float-right btn btn-danger">Supprimer</button>

                    </a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour supprimer itineraire-->




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
                $(".select-itineraire").select2();

                $(".table-principale").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "searching": true,
                    "paging": false,
                    "ordering": true,
                    "info": false,
                    language: { url: "{{asset('assets/json/json_fr_fr.json')}}" }
                });

                $(document).on("click", ".btn-supprimer-zone", function(e){
                    let url = $(this).prev().attr("data-show");
                    let url_supprimer = $(this).attr("data-url");

                    $("#modal-supprimer-itineraire").modal({
                        backdrop: 'static',
                        keyboard: false
                    });

                    $("#button-supprimer-itineraire").parent().attr("href", url_supprimer);

                    $.get(url, {}, dataType="JSON").done(function(data){
                        $("#modal-supprimer-itineraire").find("select[name='depart']").val(data.depart).select2();
                        $("#modal-supprimer-itineraire").find("select[name='arrive']").val(data.arrive).select2();
                        $("#modal-supprimer-itineraire").find("select[name='categorie']").val(data.categorie).select2();


                    });
                });

                $(document).on("click", ".btn-modifier-itineraire", function(e){
                    let url = $(this).attr("data-show");
                    let url_modifier = $(this).attr("data-url");

                    $("#modal-modifier-itineraire").modal({
                        backdrop: 'static',
                        keyboard: false
                    });

                    $("#form-itineraire-modifier").attr("action", url_modifier);

                    $.get(url, {}, dataType="JSON").done(function(data){
                        $("#modal-modifier-itineraire").find("select[name='depart']").val(data.depart).select2();
                        $("#modal-modifier-itineraire").find("select[name='arrive']").val(data.arrive).select2();
                        $("#modal-modifier-itineraire").find("select[name='categorie']").val(data.categorie).select2();
                        $("#modal-modifier-itineraire").find("input[name='delais_approximatif']").val(data.delais_approximatif);
                    });
                })
            </script>


            @endsection
