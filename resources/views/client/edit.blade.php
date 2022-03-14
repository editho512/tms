@extends('client.template')

@section('title', 'Rechercher un transporteur')

@section('styles')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection

@section('content')

<div class="child">

    @php
        $url = route('client.reservation.update', ['reservation' => $reservation])
    @endphp

    <div class="content mt-5" id="result">
        <div class="d-flex justify-content-between res">
            <h5 class="text-uppercase text-white w-100 mt-3">Lists des transporteurs</h5>
            <button id="reserver-btn" onclick="reserverTest('{{ $url }}')" class="btn btn-danger d-flex justify-content-center align-items-center">
                <span id="number">{{ $count }}</span>
                <span id="text" class="ml-3">Valider</span>
            </button>
        </div>

        <div style="overflow-x: auto;">
            <table id="transporteurs-lists" class="table table-bordered table-striped mt-5 text-white">
                <thead class="text-uppercase">
                    <tr class="text-center">
                        <th>Numéro</th>
                        <th>Nom du transporteur</th>
                        <th>Prix</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="transporteur">
                    @foreach ($datas['results'] as $data)
                    <tr>
                        <td>{{ $data['transporteur']['id'] }}</td>
                        <td>{{ $data['transporteur']['name'] }}</td>
                        <td>{{ $data['prix'] }}</td>
                        <td class="text-center">
                            @if (key_exists('selected', $data['transporteur']) AND $data['transporteur']['selected'] === true)
                                <button onclick='removeToList(this, {{ json_encode(["transporteur" => ["id" => $data["transporteur"]["id"], "name" => $data["transporteur"]["name"], "prix" => $data["prix"]]]) }})' class="btn btn-danger"><i class="fa fa-minus"></i></button>
                            @else
                                <button onclick='addToList(this, {{ json_encode(["transporteur" => ["id" => $data["transporteur"]["id"], "name" => $data["transporteur"]["name"], "prix" => $data["prix"]]]) }})' class="btn btn-primary"><i class="fa fa-plus"></i></button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="text-uppercase">
                    <tr class="text-center">
                        <th>Numéro</th>
                        <th>Nom du transporteur</th>
                        <th>Prix</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endsection


@section('scripts')

<script type="text/javascript">

    let searchData = null // Les donées des recherches
    let transporterIds = JSON.parse('<?= $activeIds ?>')
    let number = document.getElementById('number')
    let count = parseInt(number.innerText)

    const addToList = (button, data) => {
        count = count + 1
        if (count > 0) document.getElementById('text').classList.remove('d-none')
        number.innerText = count
        transporterIds[data.transporteur.id] = {
            prix: data.prix,
            name: data.transporteur.name
        }
        // Changer le texte du bouton
        button.innerHTML = '<i class="fa fa-minus"></i>'
        button.classList.remove('btn-primary')
        button.classList.add('btn-danger')
        button.setAttribute('onclick', 'removeToList(this, ' + JSON.stringify(data) + ')')
    }

    const removeToList = (button, data) => {
        count = count - 1
        if (parseInt(count) === 0) document.getElementById('text').classList.add('d-none')
        number.innerText = count
        delete transporterIds[data.transporteur.id]
        // Changer le texte du bouton
        button.innerHTML = '<i class="fa fa-plus"></i>'
        button.classList.remove('btn-danger')
        button.classList.add('btn-primary')
        button.setAttribute('onclick', 'addToList(this, ' + JSON.stringify(data) + ')')
    }

    const reserverTest = (url) => {
        window.event.preventDefault
        if (Object.keys(transporterIds).length === 0) {
            alert('Veuiller selectionner au moins un transporteur')
            return false
        }
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch(url, {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-CSRF-TOKEN": token
            },
            method: 'post',
            credentials: "same-origin",
            body: JSON.stringify({
                transporters: transporterIds,
                reservationDetaisl: searchData,
            })
        })
        .then((response) => {
            return response.json()
        })
        .then(data => {
            if (data.redirect === true) window.location.href = data.url
        })
        .catch(function(error) {
            console.log(error);
        });
    }

</script>

<script>
    $(document).ready(function() {
        $('.select-destination').select2({
            width: 'style'
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@endsection
