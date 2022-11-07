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

    <div class="main-container" style="min-height:90%;">
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
                                    <li class="breadcrumb-item active" aria-current="page">Nouvelles entités</li>
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
                            <h4 class="mb-20 h4">Creation des entités</h4>
                            <div class="list-group">
                                <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#depot" role="tab" aria-selected="true">Nouveau Depot</button>
                                <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#article" role="tab" aria-selected="true">Ajouter Article</button>
                                <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#caisse" role="tab" aria-selected="true">Ajouter Caisse</button>
                                <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#comptoir" role="tab" aria-selected="true">Ajouter Comptoir</button>
                                <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#client" role="tab" aria-selected="true">Ajouter Client</button>
                                <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#fournisseur" role="tab" aria-selected="true">Ajouter Fournisseur</button>
                                <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#personnel" role="tab" aria-selected="true">Ajouter Personnel</button>
                            </div>
                        </div>
                        @if(Session::has('error_form_entite'))
                            <div id="error_container" class="container" style="max-width: 1270px;margin-top:10px;padding-left:0px">
                                <div id="error_message" class="alert alert-danger alert-dismissible fade show" role="alert" >
                                    <i class="fa fa-exclamation" aria-hidden="true" style="color:#df4759;margin-right:10px;font-size:20px;"></i>
                                    <strong>Alerte: </strong> 
                                    <span id="notif_body">
                                        {{Session::get('error_form_entite') }}
                                    </span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-8 col-md-6 col-sm-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="depot" role="tabpanel">
                                    <div class="clearfix">
                                        <div class="pull-left">
                                            <h4 class="text-blue h4">Nouveau depot</h4>
                                            <p class="mb-30">Veuillez remplir toutes les informations</p>
                                        </div>
                                    </div>
                                    <form action="{{url('enregistrer-depot')}}" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Nom Depot: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="nom_depot" type="text" placeholder="Johnny Brown" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Num Telephone: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="telephone" value="1-(111)-111-1111" type="tel" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Délai reglement: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="delai_reglement" value="100" type="number" required>
                                            </div>
                                        </div>
                                        <input class="btn btn-info" type="submit" value="Submit" >
                                    </form>
                                </div>
                                <div class="tab-pane fade show" id="article" role="tabpanel">
                                    <div class="clearfix">
                                        <div class="pull-left">
                                            <h4 class="text-blue h4">Nouvelle marchandise</h4>
                                            <p class="mb-30">Veuillez remplir toutes les informations</p>
                                        </div>
                                    </div>
                                    
                                    <form action="{{url('enregistrer-marchandise')}}" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Reference March: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="reference" type="text" value="{{$ref_march}}" required readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Designation March: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="designation" type="text" placeholder="Marchandise xxxx">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Prix Achat: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="prix_achat" value="100" type="number">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Prix Vente detali: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="prix_vente_detail" value="100" type="number">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Prix Vente gros: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="prix_vente_gros" value="100" type="number">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Prix Vente super gros: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="prix_vente_super_gros" value="100" type="number">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Unite achat: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <select class="custom-select col-12" name="unite_achat">
                                                    <option value="Boite">Boite</option>
                                                    <option value="Carton">Carton</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Conditionnement: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <select class="custom-select col-12" name="conditionement">
                                                    <option value="Boite">Boite</option>
                                                    <option value="Carton">Carton</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Quantité conditionement: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="quantité_conditionement" value="100" type="number">
                                            </div>
                                        </div>
                                        <input class="btn btn-info" type="submit" value="Submit" >
                                    </form>
                                </div>
                                <div class="tab-pane fade show" id="caisse" role="tabpanel">
                                    <div class="clearfix">
                                        <div class="pull-left">
                                            <h4 class="text-blue h4">Nouvelle Caisse</h4>
                                            <p class="mb-30">Veuillez remplir toutes les informations</p>
                                        </div>
                                    </div>
                                    <form action="{{url('enregistrer-caisse')}}" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Libelle Caisse: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="libelle" type="text" placeholder="Johnny Brown" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Num Caisse: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="numero_caisse" value="{{$code_caisse}}" type="tel" required readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Selectionner le depot: </label>
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
                                <div class="tab-pane fade show" id="comptoir" role="tabpanel">
                                    <div class="clearfix">
                                        <div class="pull-left">
                                            <h4 class="text-blue h4">Nouveau Comptoir</h4>
                                            <p class="mb-30">Veuillez remplir toutes les informations</p>
                                        </div>
                                    </div>
                                    <form action="{{url('enregistrer-comptoir')}}" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Libelle Comptoir: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="libelle" type="text" placeholder="Johnny Brown">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Selectionner le depot: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <select class="custom-select col-12" name="depot_id">
                                                    @foreach($depots as $depot)
                                                    <option value="{{$depot->id}}" >{{$depot->nom_depot}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Personnel vendeur: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <select class="custom-select col-12" name="personnel_id">
                                                    @foreach($vendeurs as $vendeur)
                                                    <option value="{{$vendeur->id}}" >{{$vendeur->nom_complet}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Selectionner la caisse: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <select class="custom-select col-12" name="caisse_id">
                                                    @foreach($caisses as $caisse)
                                                    <option value="{{$caisse->id}}" >{{$caisse->numero_caisse}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <input class="btn btn-info" type="submit" value="Submit" >
                                    </form>
                                </div>
                                <div class="tab-pane fade show" id="client" role="tabpanel">
                                    <div class="clearfix">
                                        <div class="pull-left">
                                            <h4 class="text-blue h4">Nouveau Client</h4>
                                            <p class="mb-30">Veuillez remplir toutes les informations</p>
                                        </div>
                                    </div>
                                    <form action="{{url('enregistrer-client')}}" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Nom & prenoms: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="nom" type="text" placeholder="Johnny Brown">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Num Telephone: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="telephone" value="1-(111)-111-1111" type="tel">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Selectionner la tarification: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <select class="custom-select col-12" name="tarification">
                                                    <option value="detail">Detail</option>
                                                    <option value="gros">Gros</option>
                                                    <option value="super gros">Super gors</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Selectionner le depot: </label>
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
                                <div class="tab-pane fade show" id="fournisseur" role="tabpanel">
                                    <div class="clearfix">
                                        <div class="pull-left">
                                            <h4 class="text-blue h4">Nouveau Fournisseur</h4>
                                            <p class="mb-30">Veuillez remplir toutes les informations</p>
                                        </div>
                                    </div>
                                    <form action="{{url('enregistrer-fournisseur')}}" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Nom & prenoms: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="nom" type="text" placeholder="Johnny Brown">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Num Telephone: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="telephone" value="1-(111)-111-1111" type="tel">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Selectionner la categorie fournisseur: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <select class="custom-select col-12" name="type_fournisseur">
                                                    <option value="detail">Detail</option>
                                                    <option value="gros">Gros</option>
                                                    <option value="super_gros">Super gors</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Selectionner le depot: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <select class="custom-select col-12" name="depot_id">
                                                    @foreach($depots as $depot)
                                                    <option value="{{$depot->id}}">{{$depot->nom_depot}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <input class="btn btn-info" type="submit" value="Submit" >
                                    </form>
                                </div>
                                <div class="tab-pane fade show" id="personnel" role="tabpanel">
                                    <div class="clearfix">
                                        <div class="pull-left">
                                            <h4 class="text-blue h4">Nouvel employé</h4>
                                            <p class="mb-30">Veuillez remplir toutes les informations</p>
                                        </div>
                                    </div>
                                    <form action="{{url('enregistrer-personnel')}}" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Noms et prenom: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="nom_complet" type="text" placeholder="Johnny Brown">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Num Telephone: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="telephone" value="1-(111)-111-1111" type="tel">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="weight-600 col-md-4">Sexe: </label>
                                            <div class="custom-control custom-radio col-md-4">
                                                <input type="radio" id="customRadio1" value="H" name="sexe" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio1">Homme</label>
                                            </div>
                                            <div class="custom-control custom-radio col-md-4">
                                                <input type="radio" id="customRadio2" value="F" name="sexe" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio2">Femme</label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Email</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="email" value="bootstrap@example.com" type="email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Numero CNI: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="cni" type="text" placeholder="112233455">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Date d'embauche</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="date_embauche" placeholder="Select Date" type="date">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Matricule: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="matricule" type="text" value="{{$matricule_personnel}}" required readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Matricule Cnps: </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control" name="matricule_cnps" type="text" placeholder="Johnny Brown">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Poste</label>
                                            <div class="col-sm-12 col-md-8">
                                                <select class="custom-select col-12" name="poste">
                                                    <option value="vendeur">Vendeur</option>
                                                    <option value="magasinier">Magasinier</option>
                                                    <option value="chef_equipe">Chef d'équipe</option>
                                                    <option value="comptable">Comptable</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Type contrat</label>
                                            <div class="col-sm-12 col-md-8">
                                                <select class="custom-select col-12" name="type_contrat">
                                                    <option value="CDI">CDI</option>
                                                    <option value="CDD">CDD</option>
                                                </select>
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

    <div class="footer-wrap pd-20 mb-20 card-box center-foot center-foot">
        @include('includes/footer')
    </div>

	@include('includes/js_assets')

    <script type="text/javascript">
        $( document ).ready(function() {
            $("#linkNE").addClass("active");
            $("#linkNE").closest(".dropdown").addClass("show");
            $("#linkNE").closest(".submenu").css("display", 'block');
        });
    </script>
</body>
</html>
