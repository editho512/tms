@extends('client.template')

@section('title', 'Mes historiques de transport')

@section('styles')

    <style>
        .content {
            width: 90vw!important;
            color: rgb(219, 219, 219);
        }
    </style>

@endsection

@section('content')

<div class="child">
    <div class="content">
        <div class="mb-3 text-white text-uppercase mt-3">
            <h3 class="text-center">Mes hisoriques de transports</h3>
        </div>

        <div style="overflow-x: auto; overflow-y:auto">
            <table id="transports" class="table table-bordered table-striped bg-white">
                <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>Transporteur</th>
                        <th>Départ</th>
                        <th>Arrivée</th>
                        <th>Date & Heure</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reservations as $reservation)
                    <tr>
                        <td @if ($reservation->same(true)->count() > 1) style="background: {{ $reservation->couleurs() }}" @endif><b>{{ $reservation->numero }}</b></td>
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
                            @if ($reservation->indisponible())
                                <div style="opacity: 0.7" class="badge badge-info p-2 text-center">Réservation déja prise</div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Aucune historiques</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th>Numéro</th>
                        <th>Transporteur</th>
                        <th>Départ</th>
                        <th>Arrivée</th>
                        <th>Date & Heure</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
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
