<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Facturer-App</title>
    @include('includes/css_assets')
    @include('includes/css_myadditional')
    <style>
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


    <div class="main-container" >
        <div class="pd-ltr-20 xs-pd-20-10" >
            <div class="min-height-200px" style="position: relative;">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Controle des stocks</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Stocks</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Inventaire</li>
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

                <div class="card-box mb-30" >
                    <div class="pd-20">
                        <h4 class="text-blue h4">Nouvelle Saisie Inventaire</h4>
                    </div>

                    <div class="pd-20" style="padding-top: 0;">
                        <form id="form-inv" action="" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
						            <div class="form-group">
						                <label>Selectionner le depot</label>
						                <select id="depot" class="form-control" data-style="btn-outline-primary" name="depot"
						                    data-size="5" required>
						                    @foreach ($depots as $depot)
                                                @if(isset($selecteddepot) && $depot->id == $selecteddepot)
                                                <option value="{{$depot->id}}" selected>{{$depot->nom_depot}}</option>
                                                @else
                                                <option value="{{$depot->id}}">{{$depot->nom_depot}}</option>
                                                @endif
						                    @endforeach
						                </select>
						            </div>
						        </div>
                                <div class="col-md-9"></div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group" style="position: relative;">
                                        <label>Design. Marchandise</label>
                                        <input id="march" type="text" name="produit" class="form-control">
                                        <ul id="march_suggest">
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label>Quantité réelle</label>
                                        <input id="qte" type="number" name="newqte" placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12" style="padding-top:35px;">
                                    <a id="btn-form-inv" href="#" class="btn btn-primary">
                                        Ajouter
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-box mb-30" style="padding: 20px 0;">
                    <table class="data-table table-inventaire table hover multiple-select-row nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">Reference</th>
                                <th>Designation</th>
                                <th>Ancienne Qté</th>
                                <th>Qté réelle <code>(réajusté)</code></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <div class="clearfix" style="margin-top: 20px;margin-right:10px;">
                        <div class="pull-left">
                            <div class="col-md-3 col-sm-12" style="padding-top:35px;">
                                <a href="#" id="validerinv" class="btn btn-outline-secondary">
                                    Enregistrer
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="error_container" class="container d-flex flex-row justify-content-end" style="max-width:1270px;margin-top:10px;padding-left:0px;display:none!important;">
					<div id="error_message" class="alert alert-danger alert-dismissible fade show" role="alert" style="width: 400px;">
						<i class="fa fa-exclamation" aria-hidden="true" style="color:#df4759;margin-right:10px;font-size:20px;"></i>
						<strong>Alerte: </strong>
						<span id="notif_body"></span>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</div>

                {{-- <div id="error_container" class="container" style="width:450px;position:absolute;z-index:10;right:15px;top:150px;display:none;">
                    <div id="error_message" class="alert alert-warning alert-dismissible fade show" role="alert" >
                        <i class="fa fa-exclamation" aria-hidden="true" style="color:#e4d50bee;margin-right:10px;font-size:20px;"></i>
                        <strong>Alerte: </strong> 
                        <span id="notif_body"> Produit non trouvé, recommencez ! </span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div> --}}
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
            $("#linkSI").addClass("active");
            $("#linkSI").closest(".dropdown").addClass("show");
            $("#linkSI").closest(".submenu").css("display", 'block');
        });
        let _token = $('meta[name="csrf-token"]').attr('content');
        $('#error_container').hide();
    </script>
    
    <script type="text/javascript">
        let button = '<div class="table-actions"><a href="#" data-color="#e95959"><i class="icon-copy dw dw-delete-3"></i></a></div>';
        autocompletemarchandiseWeb();
        $("a#btn-form-inv").click(function (event) {
            event.preventDefault();
            let depot = $('select#depot').children("option:selected").val();
            var march_name = $('#march').val();
            var march_qte = $('#qte').val();
            stockInfos(march_name, depot, _token, function (response) {
                var table = $('table.data-table').DataTable();
                table.row.add([ response[1], march_name, response[0], march_qte, button]).draw();
                $('#march').val("");
                $('#qte').val("");
            });
        });
        $("#validerinv").click(function (event) {
            let depot = $('select#depot').children("option:selected").val();
            var table = $('table.table-inventaire').DataTable();
            let rows = table.rows({}).data();
            let marchandises = [];
            for (var i = 0; i < rows.length; i++) {
                let marchinv = {'name': rows[i][1], 'newquantite': rows[i][3] }
                marchandises.push(marchinv);
            }
            newSaisieInv(marchandises, depot, _token);
        });
        $('.table-inventaire tbody').on('click', 'tr.selected div.table-actions', function (e) {
            e.preventDefault();
            var table = $('.table-inventaire').DataTable();
            table.row($(this).parents('tr')).remove().draw();
        });
    </script>

</body>
</html>