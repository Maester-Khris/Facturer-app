<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Facturer-App</title>
    @include('includes/css_assets')
    <style>
        .autosuggest {
            z-index: 10;
            position: absolute;
            width: 100%;
            display: none;
        }

        .autosuggest li {
            background: #E9ECEF;
            padding: 10px;
            cursor: pointer;
        }

        .autosuggest li:hover {
            background: #CCE4F7;
        }

        .center-foot {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }

        .dataTables_length {
            display: none;
        }

        .dataTables_filter {
            display: none;
        }

        span.march-qte-stock,
        span.client-tarif {
            visibility: hidden;
        }

        .table-actions i{
            color: red;
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
                                <h4>Vente en Ligne</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Ventes</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Caisse</li>
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

                @if(Auth::user()->hasAnyRole(["vendeur","chef_equipe"]))

                    @if($statut_caisse == false)
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="card-box mb-30">
                                    <div class="pd-20" style="padding-bottom: 5px;">
                                        <h4 class="text-blue h4">Attendez l'ouverture de la caisse</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else 
                        <div class="row">
                            <div class="col-md-9">
                                <div class="card-box mb-30">
                                    <div class="pd-20" style="padding-bottom: 5px;">
                                        <h4 class="text-blue h4">Produits ajouté à la facture</h4>
                                    </div>
                                    <div class="pb-20">
                                        <table class="data-table table-ticket table hover multiple-select-row nowrap">
                                            <div class="row" style="margin: 10px auto;">
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <input id="client" class="form-control" type="text"
                                                            placeholder="rechercher le client">
                                                        <ul id="suggest" class="autosuggest" style="width: 80%;">
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 offset-md-5" style="margin-bottom:15px;">
                                                    <span>Total:
                                                        <span id="total_ticket"
                                                            style="font-weight:bold;font-size:20px;">0</span> FCFA
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row" style="margin: 10px auto;">
                                                <div class="col-md-3 col-sm-12">
                                                    <div class="form-group" style="position: relative;">
                                                        <label>Produit</label>
                                                        <input id="march" class="form-control" type="text"
                                                            placeholder="rechercher le produit">
                                                        <ul id="march_suggest" class="autosuggest">
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-sm-12">
                                                    <div class="form-group" style="position: relative;">
                                                        <label>Qte <code>stock</code></label>
                                                        <input id="march_stock" class="form-control" type="number" value=""
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-12">
                                                    <div class="form-group" style="position: relative;">
                                                        <label>Qte articles</label>
                                                        <input class="form-control qte_article" type="number" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-sm-12">
                                                    <div class="form-group" style="position: relative;">
                                                        <label>Prix vente</label>
                                                        <input class="form-control prix_vente" type="number" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-sm-12" style="padding-top:35px;">
                                                    <a href="#" class="btn btn-primary" id="addMarch">
                                                        Ajouter
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row" style="margin: 10px auto;margin-top:25px;">
                                                <div class="col-md-3">
                                                    <span>Depot:
                                                        <span style="font-weight: bold">Sainte Grace</span>
                                                    </span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span>Date:
                                                        <span style="font-weight: bold">{{date('Y-m-d');}}</span>
                                                    </span>
                                                </div>
                                                <div class="col-md-3" style="padding-left:10px;padding-right:10px;">
                                                    <span>Client:
                                                        <span id="client_name" style="font-weight: bold">{{$client_comptoir}}</span>
                                                    </span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span>No Ticket:
                                                        <span id="code_ticket" style="font-weight: bold">{{$nouveau_code}}</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <thead>
                                                <tr>
                                                    <th class="table-plus datatable-nosort" style="width: 20%">Reference</th>
                                                    <th style="width: 20%">Désignation</th>
                                                    <th style="width: 10%">Quantité</th>
                                                    <th style="width: 15%">Prix U.</th>
                                                    <th style="width: 15%">Total</th>
                                                    <th style="width: 10%">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card-box mb-30">
                                    <div class="pd-20" style="padding-bottom: 10px;">
                                        <h5 class="text-blue h5">Operations ticket</h5>
                                        <div class="btn-list">
                                            <button type="button" id="valider-ticket" class="btn btn-secondary btn-block"
                                                style="margin-bottom: 10px;">Valider</button>
                                            <button type="button" id="annuler-ticket" class="btn btn-secondary btn-block"
                                                style="margin-bottom: 10px;">Annuler</button>
                                            <button type="button" class="btn btn-secondary btn-block ticket-attente"
                                                style="margin-bottom: 10px;">Attente</button>
                                            <button type="button" id="rappeler-ticket" class="btn btn-secondary btn-block"
                                                style="margin-bottom: 10px;" >Rappeler</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- modal detail-->
                        <div class="modal fade" id="modal-rappel" tabindex="-1" role="dialog"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true" style="">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content" style="transform:translateX(10%);">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myLargeModalLabel">Rappel ticket</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="data-table table-detail table stripe hover nowrap"
                                            style="margin: 15px 0;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 15%;">Ordre d'attente</th>
                                                    <th>Identifiant</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <template id="client-default">
                            <span>{{$client_comptoir}}</span>
                        </template>
                    @endif
 
                @endif

            </div>
        </div>
    </div>

    <div class="footer-wrap pd-20 mb-20 card-box center-foot">
        @include('includes/footer')
    </div>

    @include('includes/js_assets')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#linkLVC").addClass("active");
            $("#linkLVC").closest(".dropdown").addClass("show");
            $("#linkLVC").closest(".submenu").css("display", 'block');
        });
        var _token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script src="{{asset('src/scripts/ticket_functions.js')}}"></script>
    <script src="{{asset('src/scripts/myautocomplete.js')}}"></script>
    
    <script  type="text/javascript">
        autocompleteTicket();
        $("#addMarch").click(function (e) {
            let button = '<div class="table-actions"><a href="#" data-color="#e95959"><i class="icon-copy dw dw-delete-3"></i></a></div>';
            let data = getDaTaLigneTicket();
            quantite = data[1];
            prixu = data[2];
            addTicketLine(data[0], _token)
        });
        $('#annuler-ticket').click(function (e) {
            resetTicket();
        });
        $('#rappeler-ticket').click(function (e) {
            rappelTicket();
        });
        $("#valider-ticket").click(function (e) {
            e.preventDefault();
            postTicket("/enregistrer-ticketencours").then();
            // then( console.log('saved ticket') );
        });
        $('.ticket-attente').click(function (e) {
            e.preventDefault();
            postTicket("/enregistrer-ticketenattente").then( console.log('saved ticket') );
        });
    </script>

</body>

</html>