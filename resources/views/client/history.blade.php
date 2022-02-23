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
                            <h3 class="card-title">Rechercher un transporteur</h3>
                            <button class="btn  float-right" style="background: #007bff;color:white;" data-toggle="modal" id="nouveau-camion" data-target="#modal-ajouter-camion"><span class="fa fa-plus"></span>&nbsp;Ajouter</button>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="camions" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Désignation</th>
                                        <th>Numéro châssis</th>
                                        <th>Modèle</th>
                                        <th>Marque</th>
                                        <th>Année</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($camions) && $camions->count() > 0)
                                    @foreach($camions as $camion)
                                    <tr style='{{$camion->blocked == true ? "color:gray;" : ""}}' >
                                        <td>
                                            {{ucwords($camion->name)}}
                                            @if ($camion->aUnTrajetEncours()) -<span class="badge badge-info">A un trajet en cours</span> @endif
                                            &nbsp; @if ($camion->nombreTrajetEnAttente() > 0)<div class="badge badge-info">({{ $camion->nombreTrajetEnAttente() }} Trajet(s) en attente)</div>@endif
                                        </td>
                                        <td>{{$camion->numero_chassis}}</td>
                                        <td>{{$camion->model}}</td>
                                        <td>{{$camion->marque}}</td>
                                        <td>{{$camion->annee}}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-12" style="text-align: center;">
                                                    @if ($camion->blocked == false)
                                                    <a href="{{route('camion.voir', ['camion' => $camion->id])}}">
                                                        <button class="btn btn-sm btn-info" ><span class="fa fa-eye"></span></button>
                                                    </a>
                                                    @else
                                                    <button class="btn btn-sm btn-info" disabled><span class="fa fa-eye"></span></button>
                                                    @endif

                                                    @can('update', $camion)
                                                    <button class="btn btn-sm btn-primary modifier-camion" data-update-url="{{route('camion.update', ['camion' => $camion->id])}}" data-show-url="{{route('camion.modifier', ['camion' => $camion->id])}}" data-update-url=""><span class="fa fa-edit"></span></button>
                                                    @endcan

                                                    @can('delete', $camion)
                                                    <button class="btn btn-sm btn-danger supprimer-camion" data-url="{{route('camion.supprimer', ['camion' => $camion->id])}}" data-delete-url="{{route('camion.delete', ['camion' => $camion->id])}}"><span class="fa fa-trash"></span></button>
                                                    @endcan

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td style="text-align: center" colspan="6">
                                            Aucun camion dans la liste
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Désignation</th>
                                        <th>Numéro châssis</th>
                                        <th>Modèle</th>
                                        <th>Marque</th>
                                        <th>Année</th>
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
