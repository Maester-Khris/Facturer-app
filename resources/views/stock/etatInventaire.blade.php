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

    <div class="main-container" style="position: relative;">
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
                                    <li class="breadcrumb-item active" aria-current="page">Etat d'inventaire</li>
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

                <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Valorisation de l'état d'inventaire</h4>
                    </div>

                    <div class="pd-20" style="padding-top: 0;">
                        <form id="form-etat-inv" action="{{url('/newetat-inv')}}" method="POST">
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
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Selectionnez l'option de valorisation de l'inventaire</label>
                                        <select class="selectpicker form-control prix" data-style="btn-outline-primary"
                                            name="option_valorisation" data-size="5">
                                            <option value="normal">Prix achat Normal</option>
                                            <option value="dernier" >Dernier prix achat</option>
                                            <option value="cmup" >Prix unitaire moyen (cmup)</option>
                                            <option value="standart" >Cout Standart</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-12" style="padding-top:35px;">
                                    <button id="btn-form-inv" type="submit" class="btn btn-primary">Generer l'etat</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-box mb-30" style="padding: 20px 0;">
                        <div class="pd-20">
                           <h4 class="text-blue h4">Etat d'inventaire</h4>
                        </div>
                        <div class="pb-20">
                              <button id="voir" class="btn btn-secondary" type="submit" style="margin-left:20px;margin-bottom:25px;" data-toggle="modal" data-target="#Medium-modal" >
                                    Telecharger la fiche d'etat
                              </button>
                              <table class="data-table table stripe hover nowrap">
                                    <thead>
                                    <tr>
                                        <th class="table-plus datatable-nosort">Reference</th>
                                        <th>Designation</th>
                                        <th>Qté en Stock</th>

                                        @if(isset($valorisation))
                                            @if ($valorisation == "type1")
                                                <th>Prix Achat <code>(normal)</code></th>
                                            @elseif ($valorisation == "type2")
                                                <th>Dernier Prix Achat</th>
                                            @elseif ($valorisation == "type3")
                                                <th>Prix unitaire moyen <code>(cmup)</code></th>
                                            @endif
                                        @else
                                            <th>Prix Achat <code>(normal)</code></th>
                                        @endif
                                       
                                        <th>Prix total en valeur</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($etats))
                                            @foreach($etats as $ligne)
                                                <tr>
                                                    <td class="table-plus">{{$ligne->reference}}</td>
                                                    <td>{{$ligne->designation}}</td>
                                                    <td>{{$ligne->quantite_stock}}</td>
                                                    @if ($valorisation == "type1")
                                                        <td>{{$ligne->prix_achat}}</td>
                                                        <td>{{$ligne->quantite_stock * $ligne->prix_achat}}</td>
                                                    @elseif ($valorisation == "type2")
                                                        <td>{{$ligne->dernier_prix_achat}}</td>
                                                        <td>{{$ligne->quantite_stock * $ligne->dernier_prix_achat}}</td>
                                                    @elseif ($valorisation == "type3")
                                                        <td>{{$ligne->cmup}}</td>
                                                        <td>{{$ligne->quantite_stock * $ligne->cmup}}</td>
                                                    @else
                                                        <td>0</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif 
                                    </tbody>
                              </table>
                              <div class="clearfix" style="margin-top: 20px;margin-right:10px;">
                                    <div class="pull-right">
                                        <form action="">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group" style="text-align: right;">
                                                        <label>Valeur Totale <code>net</code> du Stock</label>
                                                        @if(isset($total))
                                                        <input id="total_net" type="text" class="form-control" value="{{$total}}" readonly style="text-align: right;font-weight:bold;">
                                                        @else
                                                        <input id="total_net" type="text" class="form-control" value="0" readonly style="text-align: right;font-weight:bold;">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
            $("#linkEI").addClass("active");
            $("#linkEI").closest(".dropdown").addClass("show");
            $("#linkEI").closest(".submenu").css("display", 'block');
        });
    </script>

</body>

</html>
