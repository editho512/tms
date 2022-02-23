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

    <style>

        .test {
            display: flex;
            justify-content: center;
            align-content: center;
            align-items: center;
        }

    </style>

    <section class="content">
        <div class="container-fluid">
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
                                    <select autocomplete="off" name="province-depart" id="province-depart" class="form-control .test select-destination select-search" data-index=0>
                                        <option value="">Selectionner</option>
                                        @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}" selected='false'>{{ $province->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <label for="region-depart" class="form-label">Région</label>
                                    <select onchange="//updateDepart(this, 1)" autocomplete="off" name="region-depart" id="region-depart" class="form-control select-destination select-search" data-index=1>
                                        <option value="">Selectionner</option>
                                        @foreach ($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <label for="district-depart" class="form-label">District</label>
                                    <select onchange="//updateDepart(this, 2)" autocomplete="off" name="district-depart" id="district-depart" class="form-control select-destination select-search"  data-index=2>
                                        <option value="">Selectionner</option>
                                        @foreach ($districts as $district)
                                        <option value="{{ $district->id }}">{{ $district->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <label for="commune-depart" class="form-label">Commune</label>
                                    <select onchange="//updateDepart(this, 3)" autocomplete="off" name="commune-depart" id="commune-depart" class="form-control select-destination select-search" data-index=3>
                                        <option value="">Selectionner</option>
                                        @foreach ($communes as $commune)
                                        <option value="{{ $commune->id }}">{{ $commune->nom }}</option>
                                        @endforeach
                                    </select>
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
                        <div class="card-header" >
                            <h4 class="text-uppercase text-success">Arrivée</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="province-arrivee" class="form-label">Province</label>
                                    <select name="province-arrivee" id="province-arrivee" class="form-control select-destination">
                                        <option value="">Toamasina</option>
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <label for="region-arrivee" class="form-label">Région</label>
                                    <select name="region-arrivee" id="region-arrivee" class="form-control select-destination">
                                        <option value="">Atsinanana</option>
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <label for="district-arrivee" class="form-label">District</label>
                                    <select name="district-arrivee" id="district-arrivee" class="form-control select-destination">
                                        <option value="">Toamasina 1</option>
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <label for="commune-arrivee" class="form-label">Province</label>
                                    <select name="commune-arrivee" id="commune-arrivee" class="form-control select-destination">
                                        <option value="">Toamasina 1</option>
                                    </select>
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

            </div>

            <div class="card card-outline card-info">
                <div class="card-header">
                    <h5 class="text-uppercase">Liste des transporteurs disponibles</h5>
                </div>
                <div class="card-body">
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem vero aut id delectus nobis sint, a commodi nostrum quis repudiandae voluptates, eligendi, magni maxime eos sequi alias reiciendis voluptatem quos?
                    </p>
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

    let canChange = true

    $(document).on("change", ".select-search", function(e){
        let index = parseInt($(this).attr("data-index"));
        updateDepart(e.currentTarget, index);
    });

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
                districtDepart.value = ""
                communetDepart.value = ""

                updateSelect(data.regions, regionDepart)
            }
            else if(type === 1) // Pour la selection des regions
            {
                districtDepart.innerHTML = null
                communetDepart.value = ""

                updateSelect(data.districts, districtDepart)

                // Remplissage des parents
                provinceDepart.value = data.province.id
                regionDepart.value = data.region.id

            }
            else if(type === 2) // Pour la selection des districts
            {
                communetDepart.innerHTML = null

                updateSelect(data.communes, communetDepart)

                // Remplissage des parents
                provinceDepart.value = data.province.id
                regionDepart.value = data.region.id
                districtDepart.value = data.district.id
            }
            else if(type === 3) // Pour la selection des communes
            {
                updateSelect(data.regions, regionDepart)
                updateSelect(data.districts, districtDepart)
                updateSelect(data.communes, communetDepart)

                provinceDepart.value = data.province.id
                regionDepart.value = data.region.id
                districtDepart.value = data.district.id
                communetDepart.value = data.commune.id

                /*$('#province-depart').val(data.province.id).change()
                $('#region-depart').val(data.region.id).change()
                $('#district-depart').val(data.district.id).change()
                $('#commune-depart').val(data.commune.id).change()*/
            }

        })
        .catch(function(error) {
            console.log(error);
        });
    }

    const updateProvince = function () {

    }

    const updateSelect = (data, select) => {
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

    const updateDistrict = function () {

    }

    const updateCommune = function () {

    }

</script>

<script>
    /* $(document).ready(function() {
        $('.select-destination').select2();
    });*/
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@endsection
