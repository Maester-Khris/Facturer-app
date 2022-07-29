@php
date_default_timezone_set("Africa/Douala");
@endphp
<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Facturer-App</title>
    @include('includes/css_assets')
    <style>
        .center-foot {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }

        #march_suggest1,
        #march_suggest2 {
            z-index: 10;
            position: absolute;
            width: 100%;
            display: none;
        }

        #march_suggest1 li,
        #march_suggest2 li {
            background: #E9ECEF;
            padding: 10px;
            cursor: pointer;
        }

        #march_suggest1 li:hover,
        #march_suggest2 li:hover {
            background: #CCE4F7;
        }

    </style>
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
                    <div class="col-lg-4 col-md-5 col-sm-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <h4 class="mb-20 h4">Sorties</h4>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Recentes sorties
                                    <span class="badge badge-primary badge-pill">14</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Facture ventes
                                    <span class="badge badge-primary badge-pill">2</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <h4 class="mb-20 h4">Entrée</h4>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Nouvelle entrees
                                    <span class="badge badge-primary badge-pill">14</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Factures Achats
                                    <span class="badge badge-primary badge-pill">2</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <h4 class="mb-20 h4">Operation Stocks</h4>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-info">
                                    <a href="#" class="btn-block" data-toggle="modal" data-target="#modal-transfert"
                                        type="button">
                                        Nouveau transfert
                                    </a>
                                </li>
                                <li class="list-group-item list-group-item-dark">
                                    <a href="#" class="btn-block" data-toggle="modal" data-target="#modal-mouvment"
                                        type="button">
                                        Nouvelle Entrée/Sortie
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Simple Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Liste mouvement des stocks</h4>
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
                                @if($mvts)
                                @foreach($mvts as $mvt)
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
                                <select class="selectpicker form-control depot_depart" data-size="5"
                                    data-style="btn-outline-infmvt_typeo" data-selected-text-format="count"
                                    name="depart">
                                    @foreach($depots as $depot)
                                     <option value="{{$depot->nom_depot}}" >{{$depot->nom_depot}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" style="height: 40px;margin-left:10px;">
                            <div class="form-group">
                                <select class="selectpicker form-control depot_destination" data-size="5"
                                    data-style="btn-outline-infmvt_typeo" data-selected-text-format="count"
                                    name="destination">
                                    @foreach($depots as $depot)
                                     <option value="{{$depot->nom_depot}}" >{{$depot->nom_depot}}</option>
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
        <!-- modal mvt entree/sortie -->
        <div class="modal fade" id="modal-mouvment" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true" style="">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="transform:translateX(10%);">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Mouvement Stock</h4>
                        <div class="col-md-4" style="height: 40px;margin-left:20px;">
                            <div class="form-group">
                                <select class="selectpicker form-control depot" data-size="5"
                                    data-style="btn-outline-infmvt_typeo" data-selected-text-format="count"
                                    name="depot">
                                    @foreach($depots as $depot)
                                     <option value="{{$depot->nom_depot}}" >{{$depot->nom_depot}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" style="height: 40px;margin-left:10px;">
                            <div class="form-group">
                                <select class="selectpicker form-control mvt_type" data-style="btn-outline-primary"
                                    name="prix_vente" data-size="5">
                                    <option value="entree">Entrée</option>
                                    <option value="sortie">Sortie</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="form-reajust" action="{{url('reajuster-march')}}" method="POST"
                            style="margin-bottom:20px;">
                            @csrf
                            <div class="row">
                                <div class="col-md-7 col-7">
                                    <div class="form-group" style="position: relative">
                                        <label>Rechercher le produit</label>
                                        <input id="march2" class="form-control" type="text" name="produit"
                                            placeholder="rechercher le produit">
                                        <ul id="march_suggest2">
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
                                    <a href="#" class="btn btn-primary" id="btn_add_mvt">
                                        Ajouter
                                    </a>
                                </div>
                            </div>
                        </form>
                        <table class="checkbox-datatable table-mouvement table nowrap" style="margin: 15px 0;">
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
                                    <a href="#" id="validermvt" class="btn btn-outline-secondary">
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

    <script type="text/javascript">
        $(document).ready(function () {
            $("#linkMS").addClass("active");
            $("#linkMS").closest(".dropdown").addClass("show");
            $("#linkMS").closest(".submenu").css("display", 'block');
        });

    </script>

    {{-- detail d'un mouvement  --}}
    <script type="text/javascript">
        $("a#detail_operation").click(function (event) {
            event.preventDefault();
            let mouvement = $("table.multiple-select-row tr.selected").children(".table-plus").text();
            console.log(mouvement);
            let _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/details-mvt",
                type: "POST",
                data: {
                    'code': mouvement,
                    '_token': _token
                },
                success: function (response) {
                    if (response) {
                        console.log(response);
                        var table = $('table.table-detail').DataTable();
                        for (var i = 0; i < response.length; i++) {
                            table.row.add([
                                response[i].marchandise.reference,
                                response[i].marchandise.designation,
                                response[i].quantite_mouvement,
                            ]).draw();
                        }
                        $('#modal-detailoperation').modal('show');
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        })
    </script>

    {{-- auto suggestion modal transf et mouvement  --}}
    <script type="text/javascript">
        $('ul#march_suggest1').on("click", "li", function () {
            $('#march1').val($(this).text());
            let ul_sugestion = $('#march_suggest1');
            ul_sugestion.hide();
        });
        $('ul#march_suggest2').on("click", "li", function () {
            $('#march2').val($(this).text());
            let ul_sugestion = $('#march_suggest2');
            ul_sugestion.hide();
        });

    </script>
    <script type="text/javascript">
        $('#march1').keyup(_.debounce(function () {
            var march_name = $(this).val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/autocomplete",
                type: "POST",
                data: {
                    'produit': march_name,
                    '_token': _token
                },
                success: function (response) {
                    console.log(response);
                    let ul_sugestion = $('#march_suggest1');
                    ul_sugestion.empty();
                    if (response.length == 0) {
                        ul_sugestion.append("<li>Aucune correspondance</li>");
                    } else {
                        for (let i = 0; i < response.length; i++) {
                            ul_sugestion.append("<li>" + response[i].designation + "</li>");
                        }
                    }
                    ul_sugestion.show();
                },
                error: function (error) {}
            });
        }, 500));

    </script>
    <script type="text/javascript">
        $('#march2').keyup(_.debounce(function () {
            var march_name = $(this).val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/autocomplete",
                type: "POST",
                data: {
                    'produit': march_name,
                    '_token': _token
                },
                success: function (response) {
                    console.log(response);
                    let ul_sugestion = $('#march_suggest2');
                    ul_sugestion.empty();
                    if (response.length == 0) {
                        ul_sugestion.append("<li>Aucune correspondance</li>");
                    } else {
                        for (let i = 0; i < response.length; i++) {
                            ul_sugestion.append("<li>" + response[i].designation + "</li>");
                        }
                    }
                    ul_sugestion.show();
                },
                error: function (error) {}
            });
        }, 500));

    </script>

    {{-- TRANSFERT MVT: add and validate  --}}
    <script type="text/javascript">
        $("a#btn_add_transf").click(function (event) {
            event.preventDefault();
            let produit = $('#form-transfer #march1').val();
            let quantite = $('#form-transfer #demo3').val();
            let depot_destination = $('select.depot_transf').children("option:selected").val();
            console.log(produit, quantite, depot_destination);
            var table = $('table.checkbox-datatable.table-transfert').DataTable();
            table.row.add([
                '<input type="checkbox"></input>',
                produit,
                quantite,
            ]).draw();
            $('#march1').val('');
            $('#form-transfer #demo3').val('');
        });

    </script>
    <script type="text/javascript">
        $("#validermvt_transf").click(function (event) {
            let _token = $('meta[name="csrf-token"]').attr('content');
            let depot_depart = $('select.depot_depart').children("option:selected").val();
            let depot_destination = $('select.depot_destination').children("option:selected").val();
            var table = $('table.checkbox-datatable.table-transfert').DataTable();
            let rows = table.rows({
                selected: true
            }).data();

            let marchandises = [];
            for (var i = 0; i < rows.length; i++) {
                let marchrecu = {
                    'name': rows[i][1],
                    'quantite': rows[i][2]
                }
                marchandises.push(marchrecu);
            }
            console.log(marchandises);

            $.ajax({
                url: "/transfert-stock",
                type: "POST",
                data: {
                    'marchs': marchandises,
                    'depot_destination': depot_destination,
                    'depot_depart': depot_depart,
                    '_token': _token
                },
                success: function (response) {
                    console.log(response);
                }
            });
        });

    </script>

    {{-- ENTREE/SORTIE MVT: add and validate  --}}
    <script type="text/javascript">
        $("a#btn_add_mvt").click(function (event) {
            event.preventDefault();
            let produit = $('#form-reajust #march2').val();
            let quantite = $('#form-reajust #demo3').val();
            let type_achat = $('select.mvt_type').children("option:selected").val();
            console.log(produit, quantite, type_achat);
            var table = $('table.checkbox-datatable.table-mouvement').DataTable();
            table.row.add([
                '<input type="checkbox"></input>',
                produit,
                quantite,
            ]).draw();
            $('#march2').val('');
            $('#form-reajust #demo3').val('');
        });

    </script>
    <script type="text/javascript">
        $("#validermvt").click(function (event) {
            let _token = $('meta[name="csrf-token"]').attr('content');
            let depot = $('select.depot').children("option:selected").val();
            let type_achat = $('select.mvt_type').children("option:selected").val();
            var table = $('table.checkbox-datatable.table-mouvement').DataTable();
            let rows = table.rows({
                selected: true
            }).data();

            let marchandises = [];
            for (var i = 0; i < rows.length; i++) {
                let marchrecu = {
                    'name': rows[i][1],
                    'quantite': rows[i][2]
                }
                marchandises.push(marchrecu);
            }
            console.log(marchandises);

            $.ajax({
                url: (type_achat == "entree" ? "/entree-stock" : "/sortie-stock"),
                type: "POST",
                data: {
                    'marchs': marchandises,
                    'depot': depot,
                    '_token': _token
                },
                success: function (response) {
                    console.log(response);
                }
            });
        });

    </script>

</body>

</html>

