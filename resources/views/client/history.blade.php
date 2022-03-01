@extends('client.template')

@section('title', 'Mes historiques de transport')

@section('content')

<div class="content-wrapper" style="min-height: inherit!important;">

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" >
                            <h3 class="card-title text-info text-center">Mes hisoriques de transports</h3>
                            <a href="{{ route('client.search') }}" class="button button--secondary float-right btn-info"><span class="fa fa-search"></span>&nbsp;Faire un recherche</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="transports" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Transporteur</th>
                                        <th>Départ</th>
                                        <th>Arrivée</th>
                                        <th>Date & Heure</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reservations as $reservation)
                                        <tr>
                                            <td>{{ ucfirst($reservation->transporteur->name) }}</td>
                                            <td>{{ $reservation->depart->nom }}</td>
                                            <td>{{ $reservation->arrive->nom }}</td>
                                            <td>{{ formatDate($reservation->date) }}</td>
                                            <td>{{ ucfirst($reservation->status) }}</td>
                                            <td class="text-center">
                                                @if ($reservation->enAttente())
                                                    <a href="{{ route('client.reservation.annuler', [$reservation]) }}" class="btn btn-danger w-100" style="opacity: 0.8" type="button"><i class="mr-2 fa">&#xf00d</i>Annuler</a>
                                                @endif

                                                @if ($reservation->reserve())
                                                    @if ($reservation->livrable())
                                                        <div style="opacity: 0.7" class="badge badge-warning p-2 text-center">En cours de livraison</div>
                                                    @else
                                                        <div style="opacity: 0.7" class="badge badge-warning p-2 text-center">En attente de date de livraison</div>
                                                    @endif
                                                @endif

                                                @if ($reservation->annule())
                                                    <div style="opacity: 0.7" class="badge badge-danger p-2 text-center">Vous avez annulée la reservation</div>
                                                @endif

                                                @if ($reservation->livre())
                                                    <div style="opacity: 0.7" class="badge badge-success p-2 text-center">Marchandises livré</div>
                                                @endif

                                                @if ($reservation->rejete())
                                                    <div style="opacity: 0.7" class="badge badge-danger p-2 text-center">Rejeté par le transporteur</div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Aucune historiques</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Transporteur</th>
                                        <th>Départ</th>
                                        <th>Arrivée</th>
                                        <th>Date & Heure</th>
                                        <th>Status</th>
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


@section('scripts')

<!-- DataTables -->
<script src="{{asset('assets/adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('assets/adminlte/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/adminlte/plugins/inputmask/min/jquery.inputmask.bundle.min.js')}}"></script>

<script>

    $("#transports").DataTable({
        "responsive": false,
        "autoWidth": true,
        "searching": true,
        "paging": true,
        "ordering": true,
        "info": false,
    });

</script>

@endsection

@endsection
