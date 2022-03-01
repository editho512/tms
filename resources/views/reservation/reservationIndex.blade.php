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
                                        <th>Départ</th>
                                        <th>Arrivée</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reservations as $reservation)
                                        <tr>
                                            <td>{{ ucfirst($reservation->client->name) }}</td>
                                            <td>{{ formatDate($reservation->date) }}</td>
                                            <td>{{ $reservation->depart->nom }}</td>
                                            <td>{{ $reservation->arrive->nom }}</td>
                                            <td>{{ $reservation->status }}</td>
                                            <td class="row">
                                                <div class="col-sm-12 text-center">
                                                    @if ($reservation->enAttente())
                                                        <a class="btn btn-primary" href="{{route('reservation.accept', ['reservation' => $reservation->id])}}">
                                                            <i class="fa fa-arrow-right mr-2"></i>
                                                            Accepter
                                                        </a>
                                                        <a href="{{ route('reservation.reject', ['reservation' => $reservation->id]) }}" class="btn btn-danger">
                                                            <i class="mr-2 fa">&#xf00d</i>
                                                            Rejeter
                                                        </a>
                                                    @endif

                                                    @if ($reservation->reserve() AND $reservation->livrable())
                                                        <a class="btn btn-success" href="{{route('reservation.livrer', ['reservation' => $reservation->id])}}">
                                                            <i class="fa fa-truck mr-3"></i>
                                                            Mettre comme livré
                                                        </a>
                                                    @else
                                                        @if (!$reservation->rejete() AND !$reservation->annule())
                                                            <span class="badge badge-warning p-2">En attente de date de livraison</span>
                                                        @endif
                                                    @endif

                                                    @if ($reservation->annule())
                                                        <div style="opacity: 0.7" class="badge badge-danger p-2 text-center">Reservation annulée par le client</div>
                                                    @endif

                                                    @if ($reservation->livre())
                                                        <div style="opacity: 0.7" class="badge badge-success p-2 text-center">Marchandises livré</div>
                                                    @endif

                                                    @if ($reservation->rejete())
                                                        <div style="opacity: 0.7" class="badge badge-danger p-2">Vous avez rejetée la reservation</div>
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
                                        <th>Départ</th>
                                        <th>Arrivée</th>
                                        <th>Statut</th>
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
            "autoWidth": true,
            "searching": true,
            "paging": true,
            "ordering": true,
            "info": false,
        });

    })
</script>


@endsection
