@extends('client.template')


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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" >
                            <div class="row">
                                <div class="col-xl-6">
                                    <h4 class="text-uppercase text-primary">Départ</h4>
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <label for="province-depart" class="form-label">Province</label>
                                            <select name="province-depart" id="province-depart" class="form-control">
                                                <option value="">Toamasina</option>
                                            </select>
                                        </div>

                                        <div class="col-xl-3">
                                            <label for="region-depart" class="form-label">Région</label>
                                            <select name="region-depart" id="region-depart" class="form-control">
                                                <option value="">Atsinanana</option>
                                            </select>
                                        </div>

                                        <div class="col-xl-3">
                                            <label for="district-depart" class="form-label">District</label>
                                            <select name="district-depart" id="district-depart" class="form-control">
                                                <option value="">Toamasina 1</option>
                                            </select>
                                        </div>

                                        <div class="col-xl-3">
                                            <label for="commune-depart" class="form-label">Province</label>
                                            <select name="commune-depart" id="commune-depart" class="form-control">
                                                <option value="">Toamasina 1</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <h4 class="text-uppercase text-primary">Arrivée</h4>
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <label for="" class="form-label">Départ</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Toamasina</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-3">
                                            <label for="" class="form-label">Départ</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Toamasina</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-3">
                                            <label for="" class="form-label">Départ</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Toamasina</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-3">
                                            <label for="" class="form-label">Départ</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Toamasina</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            Listes des transporteurs
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
