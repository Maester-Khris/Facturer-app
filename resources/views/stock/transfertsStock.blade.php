<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Facturer-App</title>
    @include('includes/css_assets')
    @include('includes/css_myadditional')
</head>

<body>

    @include('includes/loader')

    <div class="header">
        @include('includes/header')
    </div>

    <div class="left-side-bar">
        @include('includes/sidebar')
    </div>

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Controle des stocks</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Stocks</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Mouvements</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                            <div class="pd-20">
                                @if(Session::has('depot_name'))
                                <h4 class="text-blue h4">Entrepot {{Session::get('depot_name')}}</h4>
                                @else
                                <h4 class="text-blue h4">Entrepot Valtos</h4>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <h4 class="mb-20 h4">Operation Stocks</h4>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-info">
                                    <a href="#" class="btn-block" id="new-transfert" type="button">
                                        Nouveau transfert
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Simple Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Liste des precedents transferts</h4>
                    </div>
                    <div class="pb-20">
                        <table class="table hover multiple-select-row data-table-export nowrap">
                            <thead>
                                <tr>
                                    <th class="table-plus datatable-nosort">Reference Mouv.</th>
                                    <th>Operation</th>
                                    <th>Date ope.</th>
                                    <th>Depot destination</th>
                                    <th>Autres</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($transfertmvts)
                                @foreach($transfertmvts as $mvt)
                                <tr>
                                    <td class="table-plus">{{$mvt->reference_mouvement}}</td>
                                    @if($mvt->type_mouvement == "Entrée")
                                    <td><span class="badge badge-success">{{$mvt->type_mouvement}}</span></td>
                                    @elseif($mvt->type_mouvement == "Sortie")
                                    <td><span class="badge badge-danger">{{$mvt->type_mouvement}}</span></td>
                                    @else
                                    <td><span class="badge badge-dark">{{$mvt->type_mouvement}}</span></td>
                                    @endif
                                    <td>{{ $mvt->date_operation }}</td>
                                    <td>{{ is_null($mvt->destination) ? '/' : $mvt->destination }}</td>
                                    <td>
                                        <a id="detail_operation" href="#" class="btn-block" type="button">
                                            plus de details
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal detail-->
        <div class="modal fade" id="modal-detailoperation" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true" style="">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="transform:translateX(10%);">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Detail du Mouvement</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <table class="data-table table-detail table stripe hover nowrap" style="margin: 15px 0;">
                            <thead>
                                <tr>
                                    <th>Reference March.</th>
                                    <th>Deisgnation</th>
                                    <th>Quantité déplacé</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal mvt transfert -->
        <div class="modal fade" id="modal-transfert" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="transform:translateX(20%);">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Transferer un stock vers</h4>
                        <div class="col-md-4" style="height: 40px;margin-left:20px;">
                            <div class="form-group">
                                <select class="selectpicker form-control depot_transf" data-size="5"
                                    data-style="btn-outline-infmvt_typeo" data-selected-text-format="count"
                                    name="destination">
                                    @foreach($othersdepots as $depot)
                                    <option value="{{$depot->nom_depot}}">{{$depot->nom_depot}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="form-transfer" action="{{url('reajuster-march')}}" method="POST"
                            style="margin-bottom:20px;">
                            @csrf
                            <div class="row">
                                <div class="col-md-7 col-7">
                                    <div class="form-group" style="position: relative">
                                        <label>Rechercher le produit</label>
                                        <input id="march1" class="form-control" type="text" name="produit"
                                            placeholder="rechercher le produit">
                                        <ul id="march_suggest1">
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-5 col-5">
                                    <div class="form-group ">
                                        <label>Quantité</label>
                                        <input id="demo3" type="number" name="demo3">
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <a href="#" class="btn btn-primary" id="btn_add_transf">
                                        Ajouter
                                    </a>
                                </div>
                            </div>
                        </form>
                        <table class="checkbox-datatable table-transfert table nowrap" style="margin: 15px 0;">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="dt-checkbox">
                                            <input type="checkbox" name="select_all" value="1" id="example-select-all">
                                            <span class="dt-checkbox-label"></span>
                                        </div>
                                    </th>
                                    <th>Deisgnation</th>
                                    <th>Quantité</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                        <div class="clearfix" style="margin-top: 20px;margin-right:10px;">
                            <div class="pull-left">
                                <div class="col-md-3 col-sm-12" style="padding-top:35px;">
                                    <a href="#" id="validermvt_transf" class="btn btn-outline-secondary">
                                        Enregistrer
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="footer-wrap pd-20 mb-20 card-box center-foot">
        @include('includes/footer')
    </div>

    @include('includes/js_assets')
    <script src="{{asset('src/scripts/stock_function.js')}}"></script>
    <script src="{{asset('src/scripts/myautocomplete.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#linkTS").addClass("active");
        });
        let _token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript">
        autoCompleteMouvement();
        $('#new-transfert').click(function (e) {
            e.preventDefault();
            ('table.table-transfert').DataTable().clear().draw();
            $("#modal-transfert").modal('toggle');
        });
        $("a#detail_operation").click(function (event) {
            event.preventDefault();
            let mouvement = $("table.multiple-select-row tr.selected").children(".table-plus").text();
            detailMvt(mouvement, _token);
        })
        $("a#btn_add_transf").click(function (event) {
            event.preventDefault();
            let produit = $('#form-transfer #march1').val();
            let quantite = $('#form-transfer #demo3').val();
            let depot_destination = $('select.depot_transf').children("option:selected").val();
            addMarchtoTable(produit, quantite, "transfert");
            $('#march1').val('');
            $('#form-transfer #demo3').val('');
        });
        $("#validermvt_transf").click(function (event) {
            let depot_destination = $('select.depot_transf').children("option:selected").val();
            var table = $('table.checkbox-datatable.table-transfert').DataTable();
            let rows = table.rows({
                selected: true
            }).data();
            marchandises = getMarchs(rows);
            transfertStock(marchandises, depot_destination, "default", "magasin", _token);
        });

    </script>
</body>

</html>
