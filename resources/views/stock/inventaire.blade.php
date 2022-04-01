<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Facturer-App</title>
    @include('includes/css_assets')
    <style>
        .center-foot{
            display:flex; 
             flex-direction:row;
             justify-content:center;
             align-items:center;
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
                        <h4 class="text-blue h4">Nouvelle Ligne Inventaire</h4>
                    </div>

                    <div class="pd-20" style="padding-top: 0;">
                        <form id="form-inv" action="{{url('/ligne-inv')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label>Design. Marchandise</label>
                                        <input type="text" name="produit" class="form-control">
                                    </div>
                                </div>
                                {{-- <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label>Quantite machine</label>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                </div> --}}
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label>Quantité réelle</label>
                                        <input type="number" name="newqte" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-12" style="padding-top:35px;">
                                    <a id="btn-form-inv" href="#" class="btn btn-primary">
                                        Enregistrer
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
		    
                <div class="card-box mb-30" style="padding: 20px 0;">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">Reference</th>
                                <th>Designation</th>
                                <th>Ancienne Qté</th>
                                <th>Qté réelle <code>(réajusté)</code></th>
                                <th>Différence</th>
                                <th>Date Réajust.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lignes as $ligne)
                            <tr>
                                <td class="table-plus">{{$ligne->marchandise->reference}}</td>
                                <td>{{$ligne->marchandise->designation}}</td>
                                <td>{{$ligne->ancienne_quantite}}</td>
                                <td>{{$ligne->quantite_reajuste}}</td>
                                <td>{{$ligne->difference}}</td>
                                <td>
                                    {{$ligne->date_reajustement}}
                                    {{-- {{ date('Y/m/d h:m:s',strtotime($ligne->date_reajustement))}} --}}
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
    <script type="text/javascript">
        $("a#btn-form-inv").click(function (event) {
            event.preventDefault();
            console.log("cliquer!");
            $("form#form-inv").submit();
        });
    </script>

</body>

</html>
