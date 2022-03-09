@extends('main')

@section('title')
<title>{{ config('app.name') }} | Réservation</title>
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
                    <h1>Réservations</h1>
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
                            <h3 class="card-title">Liste des réservations</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table  class="table table-bordered table-striped table-principale">
                                <thead>
                                    <tr>
                                        <th>Client</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                        <th>Départ</th>
                                        <th>Arrivée</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reservations as $reservation)
                                        <tr>
                                            <td>{{ ucfirst($reservation->client->name) }}</td>
                                            <td>{{ formatDate($reservation->date) }}</td>
                                            <td class="text-center">
                                                
                                                @php
                                                    $badge = "info";
                                                    if($reservation->rejete() || $reservation->annule()){
                                                        $badge = "danger";

                                                    }else if($reservation->livre() || ($reservation->reserve() && $reservation->livrable())){
                                                        $badge = "success";
                                                        
                                                    }else if(!$reservation->rejete() && !$reservation->annule() && !$reservation->enAttente()){
                                                        $badge = "warning";
                                                    }
                                                @endphp

                                                <div style="opacity: 0.7" class=" badge badge-pill badge-{{$badge}} p-2">
                                                    {{ $reservation->status }}
                                                </div>
                                            </td>
                                            <td>{{ $reservation->depart->nom }}</td>
                                            <td>{{ $reservation->arrive->nom }}</td>
                                            <td class="row">
                                                <div class="col-sm-12 text-center">
                                                    @if ($reservation->enAttente())
                                                        <button class="btn btn-sm btn-primary valider-reservation" data-show="{{route('reservation.voir', ["reservation" => $reservation->id])}}" data-url="{{route('reservation.accept', ['reservation' => $reservation->id])}}">
                                                            <i class="fa fa-arrow-right"></i>
                                                        </button>
                                                        <a href="{{ route('reservation.reject', ['reservation' => $reservation->id]) }}" class="btn btn-sm btn-danger">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                        <!--
                                                    @if ($reservation->reserve() AND $reservation->livrable())
                                                        <a class="btn btn-success" href="{{route('reservation.livrer', ['reservation' => $reservation->id])}}">
                                                            <i class="fa fa-truck mr-3"></i>
                                                            Mettre comme livré
                                                        </a>
                                                    @else
                                                        @if (!$reservation->rejete() AND !$reservation->annule() AND !$reservation->enAttente() AND !$reservation->livre() AND !$reservation->indisponible())
                                                            <span class="badge badge-warning p-2">En attente de date de livraison</span>
                                                        @endif
                                                    @endif

                                                    @if ($reservation->annule())
                                                        <div style="opacity: 0.7" class="badge badge-danger p-2 text-center">Reservation annulée par le client</div>
                                                    @endif

                                                    @if ($reservation->livre())
                                                        <div style="opacity: 0.7" class="badge badge-success p-2 text-center">Marchandises livré</div>
                                                    @endif
                                                    -->

                                                    @else 
                                                    <!--<div style="opacity: 0.7" class="badge badge-danger p-2">Vous avez rejetée la reservation</div>-->
                                                    
                                                    <button  class="btn btn-sm btn-info" >
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                    
                                                    @endif

                                                    @if ($reservation->indisponible())
                                                        <div style="opacity: 0.7" class="badge badge-info p-2 text-center">Réservation déja prise par un autre transporteur</div>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @empty

                                        <td style="text-align: center" colspan="6">
                                            Aucune reservation
                                        </td>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Client</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                        <th>Départ</th>
                                        <th>Arrivée</th>
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

<!---- modal pour valider reservation --->
<div class="modal fade" id="modal-valider-reservation">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Valider une reservation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <form  method="POST" action="#" name="form-valider-reservation" id="form-valider-reservation">
                    @csrf

                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">

                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6 text-center" style="border-bottom: solid 2px rgba(128, 128, 128, 0.3);">
                                    <h4 style="color:#808080"> <span class="badge badge-primary"></span></h4>
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
                            <div class="row mt-2" style="border-bottom: solid 2px rgba(128, 128, 128, 0.3);">
                                <div class="col-sm-12 text-center">
                                    <h5 style="color:#808080"> <span class="badge badge-pill badge-info"></span> - <span class="badge badge-pill badge-success"></span></h5>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-12 text-center">
                                    <p class="date" style="color:#808080"></p>
                                </div>
                            </div>
                            
                        </div>
                        <!-- /.card-body -->
                    </div>

                    <div class="row mt-4">
                        <div class="col-sm-4">
                            <label for="camion">Camion :</label>
                        </div>
                        <div class="col-sm-8">
                            <select name="camion" class="form-control" id="camion-disponible">
                                <option value=0>Camion disponible</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-sm-4">
                            <label for="chauffeur">Chauffeur :</label>
                        </div>
                        <div class="col-sm-8">
                            <select name="chauffeur" class="form-control" id="chauffeur-disponible">
                                <option value=0>Chauffeurs disponibles</option>
                            </select>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" id="button-ajouter-itineraire" form="form-valider-reservation"  class="float-right btn btn-primary">Valider</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour ajouter itineraire-->


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
            "responsive": false,
            "autoWidth": true,
            "searching": true,
            "paging": true,
            "ordering": true,
            "info": false,
        });

        $(document).on("click", ".valider-reservation", function (e) {
            let url = $(this).attr("data-show");
            let url_validate = $(this).attr("data-url");

            $.get(url, {}, datatype="JSON").done(function (data) {

                let option = '<option value=0 >Camions disponibles</option>';
                $.each(data.camions, function(index, value){
                    option += '<option value='+value.id+'>'+value.name+'</option>';
                });

                let optionChauffeur = '<option value=0 >Chauffeurs disponibles</option>';
                $.each(data.chauffeurs, function(index, value){
                    optionChauffeur += '<option value='+value.id+'>'+value.name+'</option>';
                });

                $("#modal-valider-reservation").find("h4 span").html(data.client)
                    .end().find("form").attr("action", url_validate)
                    .end().find("h5 .badge-info").html(data.depart)
                    .end().find("h5 .badge-success").html(data.arrivee)
                    .end().find("#camion-disponible").html(option)
                    .end().find("#chauffeur-disponible").html(optionChauffeur)
                    .end().find(".date").html(data.date)
                    .end().modal("show");
            })
        })

    })
</script>


@endsection
