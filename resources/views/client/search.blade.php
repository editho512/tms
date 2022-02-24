@extends('client.template')

@section('title', 'Rechercher un transporteur')

@section('styles')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection

@section('content')

<div class="content-wrapper teste" style="min-height: inherit!important;">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Rechercher un transporteur</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{route('camion.liste')}}">
                            <button class="btn btn-default" style="color:gray;"><span class="fa fa-arrow-left"></span>&nbsp;Retour</button>
                        </a>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('client.post.search') }}" method="post">

                @csrf

                <div class="row">

                    {{-- Informations du départ --}}

                    <div class="col-md-6">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h4 class="text-uppercase text-primary">Départ</h4>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="province-depart" class="form-label">Province</label>
                                        <select autocomplete="off" name="province-depart" id="province-depart" class="form-control .test select-destination select-search-depart" data-index=0>
                                            <option value="">Selectionner</option>
                                            @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}">{{ $province->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('province-depart')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="region-depart" class="form-label">Région</label>
                                        <select onchange="//updateDepart(this, 1)" autocomplete="off" name="region-depart" id="region-depart" class="form-control select-destination select-search-depart" data-index=1>
                                            <option value="">Selectionner</option>
                                            @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('region-depart')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="district-depart" class="form-label">District</label>
                                        <select onchange="//updateDepart(this, 2)" autocomplete="off" name="district-depart" id="district-depart" class="form-control select-destination select-search-depart"  data-index=2>
                                            <option value="">Selectionner</option>
                                            @foreach ($districts as $district)
                                            <option value="{{ $district->id }}">{{ $district->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('district-depart')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="commune-depart" class="form-label">Commune</label>
                                        <select onchange="//updateDepart(this, 3)" autocomplete="off" name="commune-depart" id="commune-depart" class="form-control select-destination select-search-depart" data-index=3>
                                            <option value="">Selectionner</option>
                                            @foreach ($communes as $commune)
                                            <option value="{{ $commune->id }}">{{ $commune->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('commune-depart')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <p>
                                    Decrivez ci-dessus votre endroit de départ
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Informations d'arrivee --}}

                    <div class="col-md-6">
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <h4 class="text-uppercase text-success">Arrivée</h4>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="province-arrivee" class="form-label">Province</label>
                                        <select autocomplete="off" name="province-arrivee" id="province-arrivee" class="form-control .test select-destination select-search-arrivee" data-index=0>
                                            <option value="">Selectionner</option>
                                            @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}">{{ $province->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('province-arrivee')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="region-arrivee" class="form-label">Région</label>
                                        <select onchange="//updatearrivee(this, 1)" autocomplete="off" name="region-arrivee" id="region-arrivee" class="form-control select-destination select-search-arrivee" data-index=1>
                                            <option value="">Selectionner</option>
                                            @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('region-arrivee')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="district-arrivee" class="form-label">District</label>
                                        <select onchange="//updatearrivee(this, 2)" autocomplete="off" name="district-arrivee" id="district-arrivee" class="form-control select-destination select-search-arrivee"  data-index=2>
                                            <option value="">Selectionner</option>
                                            @foreach ($districts as $district)
                                            <option value="{{ $district->id }}">{{ $district->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('district-arrivee')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="commune-arrivee" class="form-label">Commune</label>
                                        <select onchange="//updatearrivee(this, 3)" autocomplete="off" name="commune-arrivee" id="commune-arrivee" class="form-control select-destination select-search-arrivee" data-index=3>
                                            <option value="">Selectionner</option>
                                            @foreach ($communes as $commune)
                                            <option value="{{ $commune->id }}">{{ $commune->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('commune-arrivee')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <p>
                                    Decrivez ci-dessus votre endroit d'arrivée
                                </p>
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
                                    <div class="col-md-8 d-flex">
                                        <div class="mr-2 w-100">
                                            <label for="" class="form-label">Date</label>
                                            <input type="date" name="date_depart" id="" class="form-control">
                                            @error('date_depart')
                                                <span class="text-danger mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="w-100">
                                            <label for="" class="form-label">Heure</label>
                                            <input type="time" name="heure_depart" id="" class="form-control">
                                            @error('heure_depart')
                                                <span class="text-danger mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="" class="form-la">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fa fa-search me-3"></i>
                                            <span>Rechercher mon transporteur</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

            <div class="card card-outline card-info">
                <div class="card-header">
                    <h5 class="text-uppercase text-info">Liste des transporteurs disponibles</h5>
                </div>
                <div class="card-body">
                    <table id="camions" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Numéro</th>
                                <th>Nom du transporteur</th>
                                <th>Status</th>
                                <th>Prix</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transporteurs as $transporteurs)
                                <tr>
                                    <td>1</td>
                                    <td>Test</td>
                                    <td>Disponible</td>
                                    <td>50 000 Ar</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucun transporteur pour l'instant</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Numéro</th>
                                <th>Nom du transporteur</th>
                                <th>Status</th>
                                <th>Prix</th>
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

    $(document).on("change", ".select-search-depart", function(e){
        let index = parseInt($(this).attr("data-index"));
        updateDepart(e.currentTarget, index);
    });

    $(document).on("change", ".select-search-arrivee", function(e){
        let index = parseInt($(this).attr("data-index"));
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
            let regionDepart = document.getElementById('region-depart')
            let districtDepart = document.getElementById('district-depart')
            let communetDepart = document.getElementById('commune-depart')

            if (type === 0) // Pour la selection des provinces
            {
                regionDepart.innerHTML = null

                $('#district-depart').val('Selectionner').select2()
                $('#commune-depart').val('Selectionner').select2()

                updateSelect(data.regions, regionDepart)
            }
            else if(type === 1) // Pour la selection des regions
            {
                districtDepart.innerHTML = null

                $('#commune-depart').val("Selectionner").select2()

                updateSelect(data.districts, districtDepart)

                $('#province-depart').val(data.province.id).select2()
                $('#region-depart').val(data.region.id).select2()

            }
            else if(type === 2) // Pour la selection des districts
            {
                communetDepart.innerHTML = null

                updateSelect(data.regions, regionDepart)
                updateSelect(data.communes, communetDepart)

                $('#province-depart').val(data.province.id).select2()
                $('#region-depart').val(data.region.id).select2()
                $('#district-depart').val(data.district.id).select2()
            }
            else if(type === 3) // Pour la selection des communes
            {
                updateSelect(data.regions, regionDepart)
                updateSelect(data.districts, districtDepart)
                updateSelect(data.communes, communetDepart)

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

            let provinceArrivee = document.getElementById('province-arrivee')
            let regionArrivee = document.getElementById('region-arrivee')
            let districtArrivee = document.getElementById('district-arrivee')
            let communeArrivee = document.getElementById('commune-arrivee')

            if (type === 0) // Pour la selection des provinces
            {
                regionArrivee.innerHTML = null
                $('#district-arrivee').val('Selectionner').select2()
                $('#commune-arrivee').val('Selectionner').select2()

                updateSelect(data.regions, regionArrivee)
            }
            else if(type === 1) // Pour la selection des regions
            {
                districtArrivee.innerHTML = null

                $('#commune-arrivee').val("Selectionner").select2()

                updateSelect(data.districts, districtArrivee)

                $('#province-arrivee').val(data.province.id).select2()
                $('#region-arrivee').val(data.region.id).select2()

            }
            else if(type === 2) // Pour la selection des districts
            {
                communeArrivee.innerHTML = null

                updateSelect(data.regions, regionArrivee)
                updateSelect(data.communes, communeArrivee)

                $('#province-arrivee').val(data.province.id).select2()
                $('#region-arrivee').val(data.region.id).select2()
                $('#district-arrivee').val(data.district.id).select2()
            }
            else if(type === 3) // Pour la selection des communes
            {
                updateSelect(data.regions, regionArrivee)
                updateSelect(data.districts, districtArrivee)
                updateSelect(data.communes, communeArrivee)

                $('#province-arrivee').val(data.province.id).select2()
                $('#region-arrivee').val(data.region.id).select2()
                $('#district-arrivee').val(data.district.id).select2()
                $('#commune-arrivee').val(data.commune.id).select2()
            }

        })
        .catch(function(error) {
            console.log(error);
        });
    }

    const updateSelect = (data, select) => {
        select.innerHTML = null
        let defaultOption = document.createElement('option')
        defaultOption.innerHTML = 'Selectionner'
        select.appendChild(defaultOption)

        data.forEach(region => {
            let option = document.createElement('option')
            option.value = region.id
            option.innerHTML = region.nom
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