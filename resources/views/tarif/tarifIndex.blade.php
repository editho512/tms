@extends('main')

@section('title')
<title>{{ config('app.name') }} Tarifs</title>
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
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#zone-travail" data-toggle="tab">Mes zones de travail</a></li>
                            <li class="nav-item"><a class="nav-link " href="#categorie" data-toggle="tab">Mes prix</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="zone-travail">
                                <!-- About Me Box -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Liste de mes zones de travail</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-12 text-right">
                                                <button class="btn  float-right" style="background: #007bff;color:white;" data-toggle="modal" id="nouveau-zone" data-target="#modal-ajouter-zone"><span class="fa fa-plus"></span>&nbsp;Ajouter</button>
                                            </div>
                                        </div>
                                        <table id="itineraire-categorie" class="mt-2 table-principale table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nom</th>
                                                    <th>Description</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($zones as $zone)
                                                <tr>
                                                    <td>{{ ucwords($zone->nom) }}</td>
                                                    <td>{{ $zone->description() }}</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-sm-12" style="text-align: center;">
                                                                <button class="btn btn-primary btn-md btn-voir-zone-transporteur" data-show="{{route('zone.modifier', ['zone' => $zone->id ])}}" data-url="{{route('zone.edit', ['zone' => $zone->id ])}}"><span class="fa fa-edit"></span></button>
                                                                <button class="btn btn-md btn-danger btn-supprimer-zone-transporteur" data-show="{{route('tarif.modifier', ['ZoneTransporteur' => $zone->id ])}}" data-url="{{route('tarif.supprimer', ['ZoneTransporteur' => $zone->id ])}}"><span class="fa fa-trash"></span></button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td style="text-align: center" colspan="3">
                                                        Aucune zone de travail dans la liste
                                                    </td>
                                                </tr>
                                                @endforelse
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
                            <!-- /.tab-pane -->
                            <div class=" tab-pane" id="categorie">
                                <div class="card card-primary">
                                    <div class="card-header ">
                                        <h3 class="card-title">Mes prix</h3>
                                    </div>

                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="d-flex justify-content-end mb-3">
                                            <button data-toggle="modal" id="nouveau-prix" data-backdrop="static" data-keyboard="false" data-target="#modal-ajouter-prix" class="btn btn-primary"><i class="fa fa-plus"></i>Ajouter</button>
                                        </div>

                                        <table class="mt-2 table-principale table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Catégorie</th>
                                                    <th>Prix</th>
                                                    <td>Trajets</td>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($mixte as $key => $data)
                                                    <tr>
                                                        <td colspan="5" class="bg-secondary">{{ $key }}</td>
                                                    </tr>
                                                    @foreach ($data as $name => $d)
                                                        <tr>
                                                            <td>{{ explode('-', $name)[0] }}</td>
                                                            <td>{{ explode('-', $name)[1] }}</td>
                                                            <td>
                                                            @foreach ($d as $details)
                                                                <ul>
                                                                    <li>{{ $details['libelle'] }}</li>
                                                                </ul>
                                                            @endforeach
                                                            </td>
                                                            <td>Aucune action</td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach

                                                @forelse($datas as $rn => $categorieRnTrans)
                                                    <tr>
                                                        <td colspan="5" class="bg-secondary">{{ $rn }}</td>
                                                    </tr>
                                                    @foreach ($categorieRnTrans as $categorie)
                                                        <tr>
                                                            <td>{{ $categorie['nom'] }}</td>
                                                            <td>{{ $categorie['prix'] }}</td>
                                                            <td>
                                                                <ul>
                                                                    @foreach ($categorie['data'] as $c)
                                                                        <li>{{ $c->depart->nom }} - {{ $c->arrivee->nom }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </td>
                                                            <td>Aucune action pour le moment</td>
                                                        </tr>
                                                    @endforeach
                                                @empty
                                                <tr>
                                                    <td style="text-align: center" colspan="4">
                                                        Aucun catégorie dans la liste
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Catégorie</th>
                                                    <th>Prix</th>
                                                    <th>Trajets</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->


<div class="modal fade" id="modal-ajouter-prix">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Ajouter une prix</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-ajouter-prix">
                <form method="POST" action="{{ route('transporteur.tarif.save') }}" name="ajouter-prix" id="ajouter-prix" class="row">
                    @csrf
                    <div class="col-sm-4 mb-3">
                        <label for="zone_transport">Zone :</label>
                    </div>
                    <div class="col-sm-8 mb-3">
                        <select id="zone" name="zone"  class="js-states form-control select-zone w-100" style="width:100%!important" autocomplete="off">
                            <option value="0">Selectionner la zone</option>
                            @foreach ($zones as $zone)
                                <option value={{ $zone->id }}>{{ $zone->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label for="zone_transport">Catégorie :</label>
                    </div>
                    <div class="col-sm-8 mb-3">
                        <select onchange="updateTrajets(this, '{{ route('trajet.search') }}')" name="categorie"  class="js-states form-control select-zone w-100" style="width:100%!important" autocomplete="off">
                            <option value="0">Selectionner la catégorie</option>
                            @foreach ($categories as $categorie)
                                <option value={{ $categorie->id }}>{{ $categorie->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- <div class="col-sm-4 mb-3">
                        <label for="zone_transport">Trajets :</label>
                    </div>
                    <div class="col-sm-8 mb-3">
                        <select name="trajet" id="trajets" class="js-states form-control select-trajet w-100" style="width:100%!important" autocomplete="off">
                            <option value="0">Selectionner le trajet</option>

                        </select>
                    </div> --}}

                    <div class="mb-2 p-3 d-none" style="border: 1px solid rgb(187, 187, 187); border-radius:2px; width:100%">
                        <p>Listes des trajets qui appartient a cette catégorie</p>
                        <div id="list-trajets">

                        </div>
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label for="zone_transport">Prix (Ar) :</label>
                    </div>
                    <div class="col-sm-8 mb-3">
                        <input type="number" name="prix" value="50000" id="prix" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" id="button-ajouter-prix" form="ajouter-prix"  class="float-right btn btn-primary">Ajouter</button>
            </div>
        </div>
    </div>
</div>


<!---- modal pour ajouter zone --->
<div class="modal fade" id="modal-ajouter-zone">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
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
                            @foreach ($allZones as $zone)
                            <option value={{ $zone->id }}>{{ $zone->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" id="button-ajouter-zone" form="form-zone-transporteur-ajouter"  class="float-right btn btn-primary">Ajouter</button>
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

<!---- modal pour ajouter categorie --->
<div class="modal fade" id="modal-ajouter-categorie">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Ajouter un categorie</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-ajouter-categorie">
                <form method="POST" action="#" name="form-categorie-ajouter" id="form-categorie-ajouter" >
                    @csrf
                    <div class="row mt-2">
                        <div class="col-sm-4">
                            <label for="categorie">Categorie :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" name="categorie" disabled class="form-control">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-4">
                            <label for="montant">Montant :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="montant">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" id="button-ajouter-categorie" form="form-categorie-ajouter"  class="float-right btn btn-primary">Ajouter</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour ajouter categorie-->

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

        $(".table-principale").DataTable({
            "responsive": true,
            "autoWidth": false,
            "searching": true,
            "paging": false,
            "ordering": true,
            "info": false,
        });

        $(".select-zone").select2({
            placeholder: "Nom des zones"
        });

        $(".select-trajet").select2({
            placeholder: "Nom des trajets"
        });


        $(document).on("click", ".btn-modifier-categorie", function(e){
            let url = $(this).attr("data-show");
            let url_modifier = $(this).attr("data-url");

            $("#modal-ajouter-categorie").modal({
                backdrop: 'static',
                keyboard: false
            });

            $("#form-categorie-ajouter").attr("action", url_modifier);

            $.get(url, {}, dataType="JSON").done(function(data){
                $("#modal-ajouter-categorie").find("input[name='categorie']").val(data.categorie.nom).end().find("input[name='montant']").val(data.montant);
            })
        })

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

<script>
    function updateTrajets(select, url) {
        window.event.preventDefault();
        let zone = document.getElementById('zone')
        if (parseInt(zone.value) === 0)
        {
            alert ('Veillez choisir d\'abord le RN')
            select.value = 0
            return
        }

        url = encodeURI(url + '?zone=' + zone.value + "&categorie=" + select.value)
        fetch(url, {
            method: 'GET',
            headers: {
                "Content-Type": "application/json", "Accept": "application/json, text-plain, */*",
            },
            credentials: "same-origin",
        })
        .then((response) => response.json())
        .then((data) => {
            let trajet = document.getElementById('list-trajets')
            trajet.parentElement.classList.remove('d-none')
            trajet.innerHTML = data.lists
        })
        .catch((err) => {
            console.log(err)
        });
    }

    function updateTrajetsBackup(select, url) {
        window.event.preventDefault();
        url = url + '?id=' + select.value
        fetch(url, {
            method: 'GET',
            headers: {
                "Content-Type": "application/json", "Accept": "application/json, text-plain, */*",
            },
            credentials: "same-origin",
        })
        .then((response) => response.json())
        .then((data) => {
            let trajet = document.getElementById('trajets')
            debugger
            trajet.innerHTML = data.options

        })
        .catch((err) => {
            alert('Une erreur s\'est produite')
        });
    }
</script>

@endsection
