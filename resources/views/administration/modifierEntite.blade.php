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
                                    <li class="breadcrumb-item active" aria-current="page">Modification des entités</li>
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
                          <h4 class="mb-20 h4">Modifier une entité</h4>
                          <div class="list-group">
                            @if($type_entite == "depot")
                              <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#depot" role="tab" aria-selected="true">Modifier Depot</button>
                            @endif
                            @if($type_entite == "marchandise")
                              <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#article" role="tab" aria-selected="true">Modifier Article</button>
                            @endif
                            @if($type_entite == "client")
                              <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#client" role="tab" aria-selected="true">Modifier Client</button>
                            @endif
                            @if($type_entite == "fournisseur")
                              <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#fournisseur" role="tab" aria-selected="true">Modifier Fournisseur</button>
                            @endif
                            @if($type_entite == "personnel")
                              <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#personnel" role="tab" aria-selected="true">Modifier Personnel</button>
                            @endif
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
                            @if($type_entite == "depot")
                              <div class="tab-pane fade show active" id="depot" role="tabpanel">
                                  <div class="clearfix">
                                      <div class="pull-left">
                                          <h4 class="text-blue h4">Nouveau depot</h4>
                                          <p class="mb-30">Veuillez remplir toutes les informations</p>
                                      </div>
                                  </div>
                                  <form action="{{url('update-depot')}}" method="POST">
                                      @csrf
                                      <input type="text" name="id" value="{{$object->id}}" style="display: none;">
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Nom Depot: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="nom_depot" type="text" value="{{$object->nom_depot}}" required>
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Num Telephone: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="telephone" value="{{$object->telephone}}" type="tel" required>
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Délai reglement: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="delai_reglement" value="{{$object->delai_reglement}}" type="number" required>
                                          </div>
                                      </div>
                                      <input class="btn btn-info" type="submit" value="Submit" >
                                  </form>
                              </div>
                            @endif

                            @if($type_entite == "marchandise")
                              <div class="tab-pane fade show active" id="article" role="tabpanel">
                                  <div class="clearfix">
                                      <div class="pull-left">
                                          <h4 class="text-blue h4">Modifier marchandise</h4>
                                          <p class="mb-30">Veuillez remplir toutes les informations</p>
                                      </div>
                                  </div>
                                  
                                  <form action="{{url('update-marchandise')}}" method="POST">
                                      @csrf
                                      <input type="text" name="id" value="{{$object->id}}" style="display: none;">
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Reference March: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="reference" type="text" value="{{$object->reference}}" required readonly>
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Designation March: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="designation" type="text" value="{{$object->designation}}">
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Prix Achat: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="prix_achat" value="{{$object->prix_achat}}" type="number">
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Prix Vente detali: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="prix_vente_detail" value="{{$object->prix_vente_detail}}" type="number">
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Prix Vente gros: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="prix_vente_gros" value="{{$object->prix_vente_gros}}" type="number">
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Prix Vente super gros: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="prix_vente_super_gros" value="{{$object->prix_vente_super_gros}}" type="number">
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
                                              <input class="form-control" name="quantité_conditionement" value={{$object->prix_vente_super_gros}} type="number">
                                          </div>
                                      </div>
                                      <input class="btn btn-info" type="submit" value="Submit" >
                                  </form>
                              </div>
                            @endif
                            
                            @if($type_entite == "client")
                              <div class="tab-pane fade show active" id="client" role="tabpanel">
                                  <div class="clearfix">
                                      <div class="pull-left">
                                          <h4 class="text-blue h4">Nouveau Client</h4>
                                          <p class="mb-30">Veuillez remplir toutes les informations</p>
                                      </div>
                                  </div>
                                  <form action="{{url('update-client')}}" method="POST">
                                      @csrf
                                      <input type="text" name="id" value="{{$object->id}}" style="display: none;">
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Nom & prenoms: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="nom" type="text" value="{{$object->nom_complet}}">
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Num Telephone: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="telephone" value="{{$object->telephone}}" type="tel">
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
                                      {{-- <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Selectionner le depot: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <select class="custom-select col-12" name="depot_id">
                                                  @foreach($depots as $depot)
                                                  <option value="{{$depot->id}}" >{{$depot->nom_depot}}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div> --}}
                                      <input class="btn btn-info" type="submit" value="Submit" >
                                  </form>
                              </div>
                            @endif

                            @if($type_entite == "fournisseur")
                              <div class="tab-pane fade show active" id="fournisseur" role="tabpanel">
                                  <div class="clearfix">
                                      <div class="pull-left">
                                          <h4 class="text-blue h4">Nouveau Fournisseur</h4>
                                          <p class="mb-30">Veuillez remplir toutes les informations</p>
                                      </div>
                                  </div>
                                  <form action="{{url('update-fournisseur')}}" method="POST">
                                      @csrf
                                      <input type="text" name="id" value="{{$object->id}}" style="display: none;">
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Nom & prenoms: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="nom" type="text" value="{{$object->nom_complet}}">
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Num Telephone: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="telephone" value="{{$object->telephone}}" type="tel">
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
                                      {{-- <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Selectionner le depot: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <select class="custom-select col-12" name="depot_id">
                                                  @foreach($depots as $depot)
                                                  <option value="{{$depot->id}}">{{$depot->nom_depot}}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div> --}}
                                      <input class="btn btn-info" type="submit" value="Submit" >
                                  </form>
                              </div>
                            @endif

                            @if($type_entite == "personnel")
                              <div class="tab-pane fade show active" id="personnel" role="tabpanel">
                                  <div class="clearfix">
                                      <div class="pull-left">
                                          <h4 class="text-blue h4">Nouvel employé</h4>
                                          <p class="mb-30">Veuillez remplir toutes les informations</p>
                                      </div>
                                  </div>
                                  <form action="{{url('update-personnel')}}" method="POST">
                                      @csrf
                                      <input type="text" name="id" value="{{$object->id}}" style="display: none;">
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Noms et prenom: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="nom_complet" type="text" value="{{$object->nom_complet}}">
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Num Telephone: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="telephone" value="{{$object->telephone}}" type="tel">
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
                                              <input class="form-control" name="email" value="{{$object->email}}" type="email">
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Numero CNI: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="cni" type="text" value="{{$object->cni}}">
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Date d'embauche</label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="date_embauche" value="{{$object->date_embauche}}" type="date">
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Matricule: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="matricule" type="text" value="{{$object->matricule}}" required readonly>
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Matricule Cnps: </label>
                                          <div class="col-sm-12 col-md-8">
                                              <input class="form-control" name="matricule_cnps" type="text" value="{{$object->matricule_cnps}}" readonly>
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Poste</label>
                                          <div class="col-sm-12 col-md-8">
                                              <select class="custom-select col-12" name="poste">
                                                  <option value="vendeur" selected="{{$object->poste == "vendeur" ? 'true': 'false'}}">Vendeur</option>
                                                  <option value="magasinier" selected="{{$object->poste == "magasinier" ? 'true': 'false'}}">Magasinier</option>
                                                  <option value="chef_equipe" selected="{{$object->poste == "chef_equipe" ? 'true': 'false'}}">Chef d'équipe</option>
                                                  <option value="comptable" selected="{{$object->poste == "comptable" ? 'true': 'false'}}">Comptable</option>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Type contrat</label>
                                          <div class="col-sm-12 col-md-8">
                                              <select class="custom-select col-12" name="type_contrat">
                                                  <option value="CDI" selected="{{$object->type_contrat == "CDI" ? 'true': 'false'}}">CDI</option>
                                                  <option value="CDD" selected="{{$object->type_contrat == "CDD" ? 'true': 'false'}}">CDD</option>
                                              </select>
                                          </div>
                                      </div>
                                      {{-- <div class="form-group row">
                                          <label class="col-sm-12 col-md-4 col-form-label">Depot</label>
                                          <div class="col-sm-12 col-md-8">
                                              <select class="custom-select col-12" name="depot_id">
                                                  @foreach($depots as $depot)
                                                  <option value="{{$depot->id}}" >{{$depot->nom_depot}}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div> --}}
                                      <input class="btn btn-info" type="submit" value="Submit" >
                                  </form>
                              </div>
                            @endif

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
            $("#linkBC").addClass("active");
            $("#linkPC").closest(".dropdown").addClass("show");
            $("#linkPC").closest(".submenu").css("display", 'block');
        });
    </script>
</body>
</html>
