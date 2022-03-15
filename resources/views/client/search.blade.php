@extends('client.template')

@section('title', 'Rechercher un transporteur')

@section('styles')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection

@section('content')

<div class="child">
    <div class="content">
        <h5 class="text-uppercase text-white text-center w-100 mt-4">Rechercher un transporteur</h5>

        <form onsubmit="search()" action="{{ route('client.post.search') }}" method="post" class="mt-5">

            @csrf

            <div class="row">

                {{-- Informations du départ --}}

                <div class="col-md-11 col-sm-12 col-xs-12 col-xl-11 input">
                    <select autocomplete="off" style="width: 100%!important" name="province-depart" id="province-depart" class="form-control select-destination select-search-depart" data-index=0>
                        <option value="0">Ville de départ</option>
                        @foreach ($provinces as $province)
                        <option value="{{ $province->id }}">{{ strtoupper($province->nom) }}</option>
                        @endforeach
                    </select>
                    @error('province-depart')
                    <span class="text-danger mt-2">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-1 col-sm-12 col-xs-12 col-xl-1 btn-reset">
                    <button type="button" onclick="resetFields(this)" class="btn btn-danger shadow w-100"><i class="fa fa-refresh"></i></button>
                </div>
            </div>

            {{-- Informations d'arrivee --}}

            <div class="row mt-3">
                <div class="col-md-6 col-sm-12 col-xs-12 col-xl-6 input">
                    <select onchange="//updatearrivee(this, 1)" style="width: 100%!important" autocomplete="off" name="region-arrivee" id="region-arrivee" class="form-control select-destination select-search-arrivee" data-index=1>
                        <option value="0">Région destination</option>
                        @foreach ($regions as $region)
                        <option value="{{ $region->id }}">{{ strtoupper($region->nom) }}</option>
                        @endforeach
                    </select>
                    @error('region-arrivee')
                    <span class="text-danger mt-2">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-5 col-sm-12 col-xs-12 col-xl-5 input">
                    <select onchange="//updatearrivee(this, 2)" style="width: 100%!important" autocomplete="off" name="ville-arrivee" id="ville-arrivee" class="form-control select-destination select-search-arrivee"  data-index=2>
                        <option value="0">Ville destination</option>
                        @foreach ($villes as $ville)
                        <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
                        @endforeach
                    </select>
                    @error('ville-arrivee')
                    <span class="text-danger mt-2">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-1 col-sm-12 col-xs-12 col-xl-1 btn-reset">
                    <button type="button" onclick="resetFields(this)" class="btn btn-danger shadow w-100"><i class="fa fa-refresh"></i></button>
                </div>

            </div>

            <div class="row mt-3">
                <div class="col-md-6 input">
                    <div class="mr-2 w-100">
                        <input onchange="removeRedBorder(this)" placeholder="Date de départ" type="text" name="date_depart" id="" class="form-control">
                        @error('date_depart')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-5 input">
                    <div class="w-100">
                        <input onchange="removeRedBorder(this)" placeholder="Heure de départ" type="time" name="heure_depart" id="" class="form-control">
                        @error('heure_depart')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-1 col-sm-12 col-xs-12 col-xl-1 btn-reset">
                    <button type="button" onclick="resetFields(this)" class="btn btn-danger shadow w-100"><i class="fa fa-refresh"></i></button>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-9 col-xs-6 col-sm-6 col-xl-9" id="message">

                </div>
                <div class="col-md-3 col-xs-6 col-sm-6 col-xl-3">
                    <button id="search-btn" type="submit" class="button button--secondary w-100 d-flex justify-content-center align-items-center">
                        <div id="icon" class="mr-3">
                            <i class="fa fa-search"></i>
                        </div>
                        <span>Rechercher</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    @php
        $url = route('client.reserver')
    @endphp

    <div class="content mt-5 d-none" id="result">
        <div class="d-flex justify-content-between res">
            <h5 class="text-uppercase text-white w-100 mt-3">Lists des transporteurs</h5>
            <button id="reserver-btn" onclick="reserverTest('{{ $url }}')" class="btn btn-danger d-flex justify-content-center align-items-center">
                <span id="number">0</span>
                <span id="text" class="d-none ml-3">Valider</span>
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
                    <td>1</td>
                    <td>RAKOTO</td>
                    <td>2500000</td>
                    <td>Delete</td>

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
    let transporterIds = new Object()
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
        number.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>'

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
            number.innerText = count.toString()
            return response.json()
        })
        .then(data => {
            if (data.redirect === true) window.location.href = data.url
        })
        .catch(function(error) {
            console.log(error);
        });
    }

    const resetFields = (button) => {

        //button.parentElement.parentElement.children

        let parent = button.parentElement.parentElement
        let selects = parent.querySelectorAll('select')
        let inputs = parent.querySelectorAll('input')

        selects.forEach(select => {
            if (parseInt(select.value) > 0) {
                $(select).prop('selectedIndex', 0).select2()
            }
        })

        inputs.forEach(input => {
            if (input.value != "") {
                input.value = null
            }
        })
    }

    const removeRedBorder = (input) => {
        input.classList.remove('error')
    }

    const reserver = (data) => {
        window.event.preventDefault()
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let url = '{{ route("client.reserver") }}'
        fetch(url, {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-CSRF-TOKEN": token
            },
            method: 'post',
            credentials: "same-origin",
            body: JSON.stringify({
                data: data
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

    const search = () => {
        window.event.preventDefault()

        if (Object.keys(transporterIds).length > 0) {
            alert ('Vous devez retirer d\'abord les transporteurs que vous avez selectionné')
            return false;
        }

        let form = window.event.target;
        let loading = document.getElementById('icon')
        let btn = document.getElementById('search-btn')

        loading.innerHTML = '<div class="spinner-grow spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>'
        btn.disabled = true

        fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            body: new FormData(form)
        })
        .then(response => {
            loading.innerHTML = '<i class="fa fa-search"></i>'
            btn.disabled = false
            return response.json()
        })
        .then(data => {
            let tbody = document.getElementById('transporteur')
            if (data.errors)
            {
                Object.keys(data.errors).forEach(key => {
                    let field = document.getElementsByName(key).item(0)
                    if (key == 'date_depart' || key == 'heure_depart') field.classList.add('error')
                    else field.parentElement.children.item(1).classList.add('error')
                })
            }
            else if (data.error) {
                alert('Aucune transporteur trouvé')
                tbody.innerHTML = '<tr><td colspan="4" class="text-center">Aucune transporteur trouvé</td></tr>'
            }
            else if (data.length === 0)
            {
                document.getElementById('message').innerHTML = '<div style="padding-top: 8px;padding-bottom:8px; box-shadow:1px 1px black" class="alert alert-danger text-center rounded">Aucun transporteur trouvé</div>'
                return false
                //tbody.classList.remove('d-none')
                //tbody.innerHTML = '<tr><td colspan="4" class="text-center">Aucun transporteur trouvé</td></tr>'
            }
            else
            {
                if (data.results.length > 0)
                {
                    if (data.error)
                    {
                        tbody.innerHTML = '<tr><td colspan="4" class="text-center">' + data.error + '</td></tr>'
                        return
                    }
                    searchData = data.details

                    let result = document.getElementById('result')
                    result.classList.remove('d-none')

                    window.scrollTo({
                        top: result.getBoundingClientRect().top,
                        behavior: 'smooth',
                    })

                    tbody.innerHTML = ''
                    data.results.forEach(element => {
                        let transporteur = element.transporteur
                        let tr = document.createElement('tr')
                        let id = document.createElement('td')
                        let nom = document.createElement('td')
                        let prix = document.createElement('td')
                        let action = document.createElement('td')
                        id.innerHTML = transporteur.id
                        nom.innerHTML = transporteur.name.toUpperCase()
                        prix.innerHTML = element.prix
                        c = ['d-flex', 'justify-content-center']
                        action.classList.add(...c)
                        action.innerHTML = "<button class='btn btn-primary' onclick='addToList(this," + JSON.stringify(element) + ")'><i class='fa fa-plus'></i></button>"
                        tr.appendChild(id)
                        tr.appendChild(nom)
                        tr.appendChild(prix)
                        tr.appendChild(action)
                        tbody.appendChild(tr)
                    })
                }
                else
                {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center">Aucune transporteur trouvé</td></tr>'
                }
            }
        })
    }

    $(document).on("change", ".select-search-arrivee", function(e){
        let index = parseInt($(this).attr("data-index"));
        e.currentTarget.classList.remove('error')
        updateArrivee(e.currentTarget, index);
    });

    /**
    * Mettre a jour la listes des villes et des regions de départ
    */
    const updateDepart = function(select, type = 0) {
        if (select.value === '') return false
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let url = '{{ route("client.do-search") }}'
        let value = select.value
        fetch(url, {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-CSRF-TOKEN": token
            },
            method: 'post',
            credentials: "same-origin",
            body: JSON.stringify({
                type: type,
                id: parseInt(value),
            })
        })
        .then((response) => {
            return response.json()
        })
        .then(data => {
            let provinceDepart = document.getElementById('province-depart')
            if (type === 0) // Pour la selection des provinces
            {
                regionDepart.innerHTML = null
                $('#district-depart').prop('selectedIndex', 0).select2()
                $('#commune-depart').prop('selectedIndex', 0).select2()
                updateSelect(data.regions, regionDepart, 'Région')
            }
            else if(type === 1) // Pour la selection des regions
            {
                districtDepart.innerHTML = null
                $('#commune-depart').prop('selectedIndex', 0).select2()
                updateSelect(data.districts, districtDepart, 'District')
                $('#province-depart').val(data.province.id).select2()
                $('#region-depart').val(data.region.id).select2()
            }
            else if(type === 2) // Pour la selection des districts
            {
                communetDepart.innerHTML = null
                updateSelect(data.regions, regionDepart, 'Région')
                updateSelect(data.communes, communetDepart, 'Commune')
                $('#province-depart').val(data.province.id).select2()
                $('#region-depart').val(data.region.id).select2()
                $('#district-depart').val(data.district.id).select2()
            }
            else if(type === 3) // Pour la selection des communes
            {
                updateSelect(data.regions, regionDepart, 'Région')
                updateSelect(data.districts, districtDepart, 'District')
                updateSelect(data.communes, communetDepart, 'Commune')
                $('#province-depart').val(data.province.id).select2()
                $('#region-depart').val(data.region.id).select2()
                $('#district-depart').val(data.district.id).select2()
                $('#commune-depart').val(data.commune.id).select2()
            }
        })
        .catch(function(error) {
            console.log(error);
        });
    }

    /**
    * Mettre a jour la listes des villes et des regions de départ
    */
    const updateArrivee = function(select, type = 0) {
        if (select.value === '') return false
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let url = '{{ route("client.do-search") }}'
        let value = select.value
        fetch(url, {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-CSRF-TOKEN": token
            },
            method: 'post',
            credentials: "same-origin",
            body: JSON.stringify({
                type: type,
                id: parseInt(value),
            })
        })
        .then((response) => {
            return response.json()
        })
        .then(data => {
            let regionArrivee = document.getElementById('region-arrivee')
            let villeArrivee = document.getElementById('ville-arrivee')
            if(type === 1) // Pour la selection des regions
            {
                villeArrivee.innerHTML = null
                $('#ville-arrivee').prop('selectedIndex', 0).select2()
                updateSelect(data.villes, villeArrivee, 'Ville d\'arrivée')
                $('#region-arrivee').val(data.region.id).select2()
            }
            else if(type === 2) // Pour la selection des districts
            {
                updateSelect(data.regions, regionArrivee, 'Région')
                $('#region-arrivee').val(data.region.id).select2()
                $('#ville-arrivee').val(data.ville.id).select2()
            }
        })
        .catch(function(error) {
            console.log(error);
        });
    }

    const updateSelect = (data, select, defaultSelection) => {
        select.innerHTML = null
        let defaultOption = document.createElement('option')
        defaultOption.innerHTML = defaultSelection
        select.appendChild(defaultOption)
        data.forEach(region => {
            let option = document.createElement('option')
            option.value = region.id
            option.innerHTML = region.nom.toUpperCase()
            select.appendChild(option)
        });
    }

    const elem = document.querySelector('input[name="date_depart"]');
    const datepicker = new Datepicker(elem, {
        autohide: false,
        title: 'Selectionner la date de départ',
        clearBtn: true,
        language: 'fr',
    });
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
