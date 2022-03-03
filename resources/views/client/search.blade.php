@extends('client.template')

@section('title', 'Rechercher un transporteur')

@section('styles')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>


    /*        color: hsl(210, 32%, 93%);*/
    /*        color: hsl(210, 38%, 97%);*/
    /*1fafca*/

</style>

@endsection

@section('content')

<div class="content-wrapper" style="min-height: inherit!important;">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="mb-3">
                <h1 style="color: #1fafca;" class="text-center text-uppercase">Rechercher un transporteur</h1>
                <hr>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <form onsubmit="search()" action="{{ route('client.post.search') }}" method="post">

                @csrf

                <div class="row">

                    {{-- Informations du départ --}}

                    <div class="col-md-6">
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h4 class="text-uppercase title">Départ</h4>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 mb-4">
                                        <select autocomplete="off" name="province-depart" id="province-depart" class="form-control select-destination select-search-depart" data-index=0>
                                            <option value="0">Ville de départ</option>
                                            @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}">{{ strtoupper($province->nom) }}</option>
                                            @endforeach
                                        </select>
                                        @error('province-depart')
                                        <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="d-flex justify-content-between">
                                    <p>Decrivez ci-dessus votre endroit de départ</p>
                                    <button type="button" onclick="resetFields(this)" class="button button--secondary">Réinitialiser les champs</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Informations d'arrivee --}}

                    <div class="col-md-6">
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h4 class="text-uppercase title">Arrivée</h4>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 mb-4">
                                        <select onchange="//updatearrivee(this, 1)" autocomplete="off" name="region-arrivee" id="region-arrivee" class="form-control select-destination select-search-arrivee" data-index=1>
                                            <option value="0">Région</option>
                                            @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ strtoupper($region->nom) }}</option>
                                            @endforeach
                                        </select>
                                        @error('region-arrivee')
                                        <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-6">
                                        <select onchange="//updatearrivee(this, 2)" autocomplete="off" name="ville-arrivee" id="ville-arrivee" class="form-control select-destination select-search-arrivee"  data-index=2>
                                            <option value="0">Ville d'arrivée</option>
                                            @foreach ($villes as $ville)
                                                <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('ville-arrivee')
                                        <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="d-flex justify-content-between">
                                    <p>Decrivez ci-dessus votre endroit d'arrivée</p>
                                    <button type="button" onclick="resetFields(this)" class="button button--secondary">Réinitialiser les champs</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card card-outline card-secondary">
                            <div class="card-header">
                                <h4 class="text-uppercase">
                                    Date et heure
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 d-flex">
                                        <div class="mr-2 w-100">
                                            <label for="" class="form-label">Date</label>
                                            <input onchange="removeRedBorder(this)" type="date" name="date_depart" id="" class="form-control">
                                            @error('date_depart')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="w-100">
                                            <label for="" class="form-label">Heure</label>
                                            <input onchange="removeRedBorder(this)" type="time" name="heure_depart" id="" class="form-control">
                                            @error('heure_depart')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12 d-flex justify-content-end mt-4">
                                        <label for="" class="form-la">&nbsp;</label>
                                        <button id="search-btn" type="submit" class="button button--secondary w-25 d-flex justify-content-center align-item-center">
                                            <div id="icon" class="mr-3">
                                                <i class="fa fa-search"></i>
                                            </div>
                                            <span>Rechercher mon transporteur</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

            <div class="alert alert-danger d-none" id="errors">

            </div>

            <div class="card card-outline card-info">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="text-uppercase title">Liste des transporteurs disponibles</h4>
                </div>
                <div class="card-body">
                    <table id="camions" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Numéro</th>
                                <th>Nom du transporteur</th>
                                <th>Prix</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="transporteur">
                            <tr>
                                <td colspan="4" class="text-center">Aucun transporteur pour l'instant</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
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

<script type="text/javascript">

    const resetFields = (button) => {
        let parent = button.parentElement.parentElement.parentElement
        let selects = parent.querySelectorAll('select')

        selects.forEach(select => {
            if (parseInt(select.value) > 0) {
                $(select).prop('selectedIndex', 0).select2()
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
        let form = window.event.target;
        let url = form.getAttribute('action')
        let method = form.getAttribute('method')
        let data = new FormData(form)

        let loading = document.getElementById('icon')
        let btn = document.getElementById('search-btn')
        loading.innerHTML = '<div class="spinner-grow spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>'
        btn.disabled = true

        fetch(url, {
            method: method,
            body: data
        })
        .then(response => {
            loading.innerHTML = '<i class="fa fa-search"></i>'
            btn.disabled = false
            return response.json()
        })
        .then(data => {
            if (data.errors) {
                Object.keys(data.errors).forEach(key => {
                    let field = document.getElementsByName(key).item(0)

                    if (key == 'date_depart' || key == 'heure_depart') field.classList.add('error')
                    else field.parentElement.children.item(1).classList.add('error')
                })
            } else {
                let tbody = document.getElementById('transporteur')

                if (data.length > 0)
                {
                    if (data.error)
                    {
                        tbody.innerHTML = '<tr><td colspan="4" class="text-center">' + data.error + '</td></tr>'
                        return
                    }

                    tbody.innerHTML = ''

                    data.forEach(element => {
                        let transporteur = element.transporteur

                        let tr = document.createElement('tr')
                        let id = document.createElement('td')
                        let nom = document.createElement('td')
                        let prix = document.createElement('td')
                        let action = document.createElement('td')

                        id.innerHTML = transporteur.id
                        nom.innerHTML = transporteur.name.toUpperCase()
                        prix.innerHTML = element.prix
                        action.innerHTML = "<button class='button button--secondary w-100' onclick='reserver(" + JSON.stringify(element) + ")'>Reserver</button>"
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

    /*$(document).on("change", ".select-search-depart", function(e){
        let index = parseInt($(this).attr("data-index"));
        e.currentTarget.classList.remove('error')
        updateDepart(e.currentTarget, index);
    });*/

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
                debugger
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

</script>

<script>
    $(document).ready(function() {
        $('.select-destination').select2();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@endsection
