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
        #march_suggest {
            z-index: 10;
            position: absolute;
            width: 100%;
            display: none;
        }
        #march_suggest li {
            background: #E9ECEF;
            padding: 10px;
            cursor: pointer;
        }
        #march_suggest li:hover {
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
                                    <li class="breadcrumb-item active" aria-current="page">Inventaire</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                            <div class="pd-20">
                                <h4 class="text-blue h4">Entrepot Saint José</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Nouvelle Saisie Inventaire</h4>
                    </div>

                    <div class="pd-20" style="padding-top: 0;">
                        <form id="form-inv" action="" method="POST">
                            @csrf
                            <div class="row">
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
                    <table class="data-table table-inventaire table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">Reference</th>
                                <th>Designation</th>
                                <th>Ancienne Qté</th>
                                <th>Qté réelle <code>(réajusté)</code></th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach($lignes as $ligne)
                            <tr>
                                <td class="table-plus">{{$ligne->marchandise->reference}}</td>
                            <td>{{$ligne->marchandise->designation}}</td>
                            <td>{{$ligne->ancienne_quantite}}</td>
                            <td>{{$ligne->quantite_reajuste}}</td>
                            <td>{{$ligne->difference}}</td>
                            <td>
                                {{$ligne->date_reajustement}}
                            </td>
                            </tr>
                            @endforeach --}}

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

            </div>
        </div>
    </div>

    <div class="footer-wrap pd-20 mb-20 card-box center-foot">
        @include('includes/footer')
    </div>

    @include('includes/js_assets')

    <script type="text/javascript">
        $(document).ready(function () {
            $("#linkI").addClass("active");
            $("#linkI").closest(".dropdown").addClass("show");
            $("#linkI").closest(".submenu").css("display", 'block');
        });
    </script>

    {{-- autosuggestion --}}
    <script type="text/javascript">
        $('ul#march_suggest').on("click", "li", function () {
            $('#march').val($(this).text());
            let ul_sugestion = $('#march_suggest');
            ul_sugestion.hide();
        });
    </script>
    <script type="text/javascript">
        $('#march').keyup(_.debounce(function () {
            var march_name = $(this).val();
            console.log
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
                    let ul_sugestion = $('#march_suggest');
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

    {{-- Ajouter produit: stockinfo  --}}
    <script type="text/javascript">
        $("a#btn-form-inv").click(function (event) {
            event.preventDefault();

            var march_name = $('#march').val();
            var march_qte = $('#qte').val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/stockinfo",
                type: "POST",
                data: {
                    'produit': march_name,
                    '_token': _token
                },
                success: function (response) {
                    console.log(response)
                    var table = $('table.data-table').DataTable();
                    table.row.add([
                        response[1],
                        march_name,
                        response[0],
                        march_qte,
                    ]).draw();
                    $('#march').val("");
                    $('#qte').val("");
                },
                error: function (error) {}
            });
            // stockinfo

        });
    </script>

    {{-- enregistrer invenataire  --}}
    <script type="text/javascript">
        $("#validerinv").click(function (event) {
            let _token = $('meta[name="csrf-token"]').attr('content');
            var table = $('table.table-inventaire').DataTable();
            let rows = table.rows({}).data();

            let marchandises = [];
            for (var i = 0; i < rows.length; i++) {
                let marchinv = {
                    'name': rows[i][1],
                    'newquantite': rows[i][3]
                }
                marchandises.push(marchinv);
            }
            console.log(marchandises);

            $.ajax({
                url: "/saisie-inv",
                type: "POST",
                data: {
                    'marchs': marchandises,
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