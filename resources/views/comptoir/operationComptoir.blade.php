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

    <div class="main-container" style="min-height:90%;">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Comptoirs & Caisse</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Caisse</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Operations Caisses</li>
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
                    @if(Session::has('error_form_caisse'))
                    <div id="error_container" class="container"
                        style="max-width: 1270px;margin-top:10px;padding-left:0px">
                        <div id="error_message" class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fa fa-exclamation" aria-hidden="true"
                                style="color:#df4759;margin-right:10px;font-size:20px;"></i>
                            <strong>Alerte: </strong>
                            <span id="notif_body">
                                {{Session::get('error_form_caisse') }}
                            </span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    @endif
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-10">
                        <div class="pd-20 card-box">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-blue h4">Ouvrir / Fermer Caisse</h4>
                                    <p class="mb-30">Veuillez remplir toutes les informations</p>
                                </div>
                            </div>
                            <form action="{{url('toggleEtatCaisse')}}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label">Selectionner la caisse: </label>
                                    <div class="col-sm-12 col-md-8">
                                        <select id="caisse_id" class="custom-select col-12" name="caisse_id">
                                            @foreach($caisses as $caisse)
                                            <option value="{{$caisse->id}}" selected='true'>{{$caisse->numero_caisse}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label">Etat Actuel: </label>
                                    <div class="col-sm-12 col-md-8">
                                        <select id="etat_caisse" class="custom-select col-12" disabled>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <input class="btn btn-info" type="submit" value="Changer l'etat"
                                    style="margin-top: 50px;">
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6 col-sm-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <div class="tab-pane fade show" role="tabpanel">
                                @if (!isset($data))
                                <div class="clearfix">
                                    <div class="pull-left">
                                        <h4 class="text-blue h4">Interroger Caisse</h4>
                                        <p class="mb-30">Veuillez remplir toutes les informations</p>
                                    </div>
                                </div>
                                <form action="{{url('interrogerCaisse')}}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-4 col-form-label">Selectionner la caisse:
                                        </label>
                                        <div class="col-sm-12 col-md-8">
                                            <select class="custom-select col-12" name="caisse">
                                                @foreach($caisses as $caisse)
                                                <option value="{{$caisse->id}}">{{$caisse->numero_caisse}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-4 col-form-label">Selectionner le type de ticket:
                                        </label>
                                        <div class="col-sm-12 col-md-8">
                                            <select class="custom-select col-12" name="type_ticket">
                                                <option value="archive">Ticket Archivés</option>
                                                <option value="en_cours">Ticket en Cours</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-4 col-form-label">Periode Min: </label>
                                        <div class="col-sm-12 col-md-8">
                                            <input class="form-control" name="periode_min" placeholder="Select Date"
                                                type="date">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-4 col-form-label">Periode Max: </label>
                                        <div class="col-sm-12 col-md-8">
                                            <input class="form-control" name="periode_max" placeholder="Select Date"
                                                type="date">
                                        </div>
                                    </div>
                                    <input class="btn btn-info" type="submit" value="Consulter">
                                </form>
                                @else
                                <h4 class="text-blue h4">Liste Tickets {{$type}} </h4>
                                <h5 class="text-grey h5">Caisse: {{$caisse->libelle}}</h5>
                                <table class="table hover multiple-select-row data-table-export nowrap">
                                    <thead>
                                        <tr>
                                            <th class="table-plus datatable-nosort">Ref. Ticket</th>
                                            <th>Heure</th>
                                            <th>Total</th>
                                            <th>Autre</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $ticket)
                                        <tr>
                                            <td class="table-plus">{{$ticket->code_ticket}}</td>
                                            <td>{{$ticket->date_operation}}</td>
                                            <td>{{$ticket->total}}</td>
                                            <td>
                                                <a id="detail_operation" href="#" class="btn-block" type="button">
                                                    plus de details
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="clearfix" style="margin-top: 20px;margin-right:10px;">
                                    <div class="pull-right">
                                        <form action="">
                                            <div class="row">
                                                <div class="offset-md-4 col-md-8 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Total Caisse des tickets <code>{{$type}}</code></label>
                                                        <input id="total_net" type="number" class="form-control" value="{{$total}}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                                @endif
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
                                <h4 class="modal-title" id="myLargeModalLabel">Detail du Ticket</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <table class="data-table table-detail table stripe hover nowrap"
                                    style="margin: 15px 0;">
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
            </div>
        </div>
    </div>

    <div class="footer-wrap pd-20 mb-20 card-box center-foot center-foot">
        @include('includes/footer')
    </div>

    @include('includes/js_assets')

    <script type="text/javascript">
        $(document).ready(function () {
            let _token = $('meta[name="csrf-token"]').attr('content');
            $("#linkLOC").addClass("active");
            $("#linkLOC").closest(".dropdown").addClass("show");
            $("#linkLOC").closest(".submenu").css("display", 'block');
            setStatutCaisse();
            $("select#caisse_id").change(function () {
                setStatutCaisse();
            });
            $("a#detail_operation").click(function (event) {
                event.preventDefault();
                getDetailTicket();
            });

            function setStatutCaisse() {
                let _token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "caisse-statut",
                    type: "POST",
                    data: {
                        'caisse_id': $("select#caisse_id").children("option:selected").val(),
                        '_token': _token
                    },
                    success: function (response) {
                        if (response) {
                            let option_selected = $("select#etat_caisse").children(
                                "option:selected");
                            option_selected.val(response.res);
                            option_selected.text(response.res);
                        }
                    }
                });
            }

            function getDetailTicket() {
                $.ajax({
                    url: "/details-ticket",
                    type: "POST",
                    data: {
                        'code': $("table.multiple-select-row tr.selected").children(".table-plus")
                        .text(),
                        '_token': _token
                    },
                    success: function (response) {
                        if (response) {
                            var table = $('table.table-detail').DataTable();
                            for (var i = 0; i < response.length; i++) {
                                table.clear().draw();
                                table.row.add([
                                    response[i].reference_marchandise,
                                    response[i].designation,
                                    response[i].quantite,
                                ]).draw();
                            }
                            $('#modal-detailoperation').modal('show');
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        });
    </script>
</body>

</html>
