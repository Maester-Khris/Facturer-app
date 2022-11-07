<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8">
		<title>Facturer-App</title>
        @include('includes/css_assets')
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
                                <h4>Administration</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Administration</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Consulter le plan des comptes</li>
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
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-10">
                        <div class="pd-20 card-box">
                            <h4 class="mb-20 h4">Comptes</h4>
                            <div class="list-group">
                                <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#marchandise" role="tab" aria-selected="true">Liste compte Articles</button>
                                <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#client" role="tab" aria-selected="true">Liste compte Clients</button>
                                <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#fournisseur" role="tab" aria-selected="true">Liste compte Fournisseurs</button>
                                <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#caisse" role="tab" aria-selected="true">Liste compte Caisses</button>
                                <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#compte" role="tab" aria-selected="true">Liste Autre Comptes</button>
                                <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#addcompte" role="tab" aria-selected="true">Ajouter Autre Compte</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-6 col-sm-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="marchandise" role="tabpanel">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 40%;">Num. Compte</th>
                                                <th scope="col" style="width: 60%;">Intitulé</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($comptemarchs))
                                                @foreach($comptemarchs as $compte)
                                                    <tr>
                                                        <td>{{$compte->numero_compte}}</td>
                                                        @php
                                                            $type_compte = str_split($compte->numero_compte, 3);
                                                        @endphp
                                                        @if($type_compte[0] == "601")
                                                            <td>Achat - {{$compte->intitule}}</td>
                                                        @else
                                                            <td>Vente - {{$compte->intitule}}</td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade show" id="client" role="tabpanel">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 40%;">Num. Compte</th>
                                                <th scope="col" style="width: 60%;">Intitulé</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($compteclients))
                                                @foreach ($compteclients as $compte)
                                                    <tr>
                                                        <td>{{$compte->numero_compte}}</td>
                                                        <td>Client - {{$compte->intitule}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade show" id="fournisseur" role="tabpanel">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 40%;">Num. Compte</th>
                                                <th scope="col" style="width: 60%;">Intitulé</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($comptefours))
                                                @foreach ($comptefours as $compte)
                                                    <tr>
                                                        <td>{{$compte->numero_compte}}</td>
                                                        <td>Fournisseur - {{$compte->intitule}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade show" id="caisse" role="tabpanel">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 40%;">Num. Compte</th>
                                                <th scope="col" style="width: 60%;">Intitulé</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($comptecaisses))
                                                @foreach ($comptecaisses as $compte)
                                                    <tr>
                                                        <td>{{$compte->numero_compte}}</td>
                                                        <td>{{$compte->intitule}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade show" id="compte" role="tabpanel">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 40%;">Num. Compte</th>
                                                <th scope="col" style="width: 60%;">Intitulé</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($compteautres))
                                                @foreach ($compteautres as $compte)
                                                    <tr>
                                                        <td>{{$compte->numero_compte}}</td>
                                                        <td>{{$compte->intitule}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade show" id="addcompte" role="tabpanel">
                                    <div class="clearfix">
                                        <div class="pull-left">
                                            <h4 class="text-blue h4">Autre type Compte</h4>
                                            <p class="mb-30">Veuillez remplir toutes les informations</p>
                                        </div>
                                    </div>
                                    <form action="{{url('enregistrer-compte')}}" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Type de compte</label>
                                            <div class="col-sm-12 col-md-8">
                                                <select class="custom-select col-12" name="type_compte">
                                                    <option value="general">General</option>
                                                    <option value="charge">Charge</option>
                                                    <option value="produit">Produit</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Numero Compte: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="numero_compte" type="text" placeholder="entrer un numero ...">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Intitulé: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="intitule" type="text" placeholder="Charger pour ...">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Depot</label>
                                            <div class="col-sm-12 col-md-8">
                                                <select class="custom-select col-12" name="depot_id">
                                                    @foreach($depots as $depot)
                                                    <option value="{{$depot->id}}" >{{$depot->nom_depot}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <input class="btn btn-info" type="submit" value="Submit" >
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-wrap pd-20 mb-20 card-box">
        @include('includes/footer')
    </div>

	@include('includes/js_assets')

    <script type="text/javascript">
        $( document ).ready(function() {
            $("#linkPC").addClass("active");
            $("#linkPC").closest(".dropdown").addClass("show");
            $("#linkPC").closest(".submenu").css("display", 'block');
        });
    </script>
</body>
</html>