@extends('main')

@section('title')
<title>{{ config('app.name') }} | rn de travail</title>
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
                    <h1>rn de travail</h1>
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
                    <div class="alert alert-danger">
                        @if ($errors->any())
                            @dump($errors->all())
                        @endif
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste des zones de travail</h3>
                            <button class="btn  btn-success float-right"  data-toggle="modal" id="nouveau-rn" data-backdrop="static" data-keyboard="false" data-target="#modal-ajouter-rn"><span class="fa fa-plus"></span>&nbsp;Ajouter</button>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table  class="table table-bordered table-striped table-principale">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <td>Villes</td>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rns as $rn)
                                    <tr>
                                        <td>{{ ucwords($rn->nom) }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($rn->villes as $ville)
                                                    <li>{{ $ville->nom }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-12" style="text-align: center;">
                                                    <a href="{{route('zone.voir', ['zone' => $rn->id ])}}">
                                                        <button class="btn btn-sm btn-info btn-voir-rn"><span class="fa fa-eye"></span></button>
                                                    </a>
                                                    <button class="btn btn-primary btn-sm btn-modifier-rn" data-show="{{route('zone.modifier', ['zone' => $rn->id ])}}" data-url="{{route('zone.edit', ['zone' => $rn->id ])}}"><span class="fa fa-edit"></span></button>
                                                    <button class="btn btn-sm btn-danger btn-supprimer-rn" data-url="{{route('zone.supprimer', ['zone' => $rn->id ])}}" ><span class="fa fa-trash"></span></button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td style="text-center" colspan="3">
                                            Aucune rn de travail dans la liste
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nom</th>
                                        <td>Villes</td>
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

<!---- modal pour ajouter rn --->
<div class="modal fade" id="modal-ajouter-rn">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <h4 class="modal-title">Ajouter une rn de travail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <form action="{{route('zone.ajouter')}}" method="post" role="form" id="form-ajouter-rn" enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-1">
                        <div class="col-sm-4">
                            <label for="name">Nom :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" placeholder="Nom" required autocomplete="off">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-4">
                            <label for="ville">Villes :</label>
                        </div>
                        <div class="col-sm-8">
                            <select name="ville[]"  class="js-example-basic-multiple js-states form-control select-ville"  multiple="multiple" placeholder="Nom des villes" style="width:100%;" autocomplete="off">
                                @foreach ($villes as $ville)
                                    <option value={{$ville->id}}>{{$ville->nom}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" id="button-ajouter-rn" form="form-ajouter-rn" class="float-right btn btn-success">Ajouter</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour ajouter rn -->


<!---- modal pour modifier rn --->
<div class="modal fade" id="modal-modifier-rn">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Modifier une rn de travail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <form action="#" method="post" role="form" id="form-modifier-rn" enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-1">
                        <div class="col-sm-4">
                            <label for="name">Nom :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" placeholder="Nom" required autocomplete="off">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-4">
                            <label for="villes">villes :</label>
                        </div>
                        <div class="col-sm-8">
                            <select name="ville[]"  class="js-example-basic-multiple js-states form-control select-ville"  multiple="multiple" placeholder="Nom des villes" style="width:100%;" autocomplete="off">
                                @foreach ($villes as $ville)
                                    <option value={{$ville->id}}>{{$ville->nom}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" id="button-modifier-rn" form="form-modifier-rn" class="float-right btn btn-primary">Modifier</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour ajouter rn -->

<!---- modal pour supprimer rn --->
<div class="modal fade" id="modal-supprimer-rn">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h4 class="modal-title">Supprimer une rn de travail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <form action="#" method="post" role="form" id="form-supprimer-rn" enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-1">
                        <div class="col-sm-4">
                            <label for="name">Nom :</label>
                        </div>
                        <div class="col-sm-8">
                            <input disabled type="text" name="name" class="form-control" placeholder="Nom" required autocomplete="off">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-4">
                            <label for="villes">villes :</label>
                        </div>
                        <div class="col-sm-8">
                            <select disabled name="ville[]"  class="js-example-basic-multiple js-states form-control select-ville"  multiple="multiple" placeholder="Nom des villes" style="width:100%;" autocomplete="off">
                                @foreach ($villes as $ville)
                                <option value={{$ville->id}}>{{$ville->nom}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <a href="">
                    <button type="button" id="button-supprimer-rn"  class="float-right btn btn-danger">Supprimer</button>

                </a>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour supprimer rn -->


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
        $(".select-ville").select2({
            placeholder: "Nom des villes"
        });

        $(".table-principale").DataTable({
            "responsive": true,
            "autoWidth": false,
            "searching": true,
            "paging": true,
            "ordering": true,
            "info": false,
        });
        // ------------------ EVENTE ---------------

        $(document).on("click", ".btn-supprimer-rn", function (e) {
            $("#modal-supprimer-rn").modal({
                backdrop: 'static',
                keyboard: false
            });

            let url = $(this).prev().attr("data-show");
            let url_delete = $(this).attr("data-url");

            $("#button-supprimer-rn").parent().attr("href", url_delete);

            $.get(url, {}, dataType="JSON").done(function (data) {
                $("#modal-supprimer-rn ").find('input[name="name"]').val(data.rn.name);
                $("#modal-supprimer-rn ").find('select').val(data.ville).change();
            })
        })

        $(document).on("click", ".btn-modifier-rn", function (e) {

            $("#modal-modifier-rn").modal({
                backdrop: 'static',
                keyboard: false
            });

            let url = $(this).attr("data-show");
            let url_edit = $(this).attr("data-url");

            $("#form-modifier-rn").attr('action', url_edit);

            $.get(url, {}, dataType="JSON").done(function (data) {
                $("#modal-modifier-rn ").find('input[name="name"]').val(data.rn.nom);
                $("#modal-modifier-rn ").find('select').val(data.villes).change();
            })
        })
    })
</script>


@endsection
