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
                                    <li class="breadcrumb-item active" aria-current="page">Liste des entités</li>
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
                        <h4 class="text-blue h4">Consulter la liste des entités</h4>
                    </div>
        
                    <div class="pd-20" style="padding-top: 0;">
                        <form action="{{url('getListEntite')}}" method="POST">
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
                              <div class="col-md-3 col-sm-12" style="padding-top:35px;">
                                <button type="submit" class="activities btn btn-primary">
                                    Consulter les entites
                                </button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-10">
                        <div class="pd-20 card-box">
                            <h4 class="mb-20 h4">Liste des entités</h4>
                            <div class="list-group">
                              <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#depot" role="tab" aria-selected="true">Lister Depot</button>
                              <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#article" role="tab" aria-selected="true">Lister Article</button>
                              <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#caisse" role="tab" aria-selected="true">Lister Caisse</button>
                              <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#comptoir" role="tab" aria-selected="true">Lister Comptoir</button>
                              <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#client" role="tab" aria-selected="true">Lister Client</button>
                              <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#fournisseur" role="tab" aria-selected="true">Lister Fournisseur</button>
                              <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#personnel" role="tab" aria-selected="true">Lister Personnel</button>
                              <button type="button" class="list-group-item list-group-item-action list-group-item-info" data-toggle="tab" href="#compte" role="tab" aria-selected="true">Lister Autre Compte</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-6 col-sm-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="depot" role="tabpanel">
                                    <table class="table table-striped">
                                          <thead>
                                              <tr>
                                                  <th scope="col" style="width: 30%;">Nom depot</th>
                                                  <th scope="col" style="width: 60%;">Telephone</th>
                                                  <th scope="col" style="width: 10%;">Action</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                                @if(isset($depots))
                                                      @foreach ($depots as $item)
                                                      <tr>
                                                            <td>{{$item->nom_depot}}</td>
                                                            <td>{{$item->telephone}}</td>
                                                            <td><a class="entite ent-depot" href="#" data-color="#e95959"><i class="icon-copy dw dw-edit2"></i></a></td>
                                                      </tr>
                                                      @endforeach
                                                @endif
                                          </tbody>
                                      </table>
                                </div>
                                <div class="tab-pane fade show " id="article" role="tabpanel">
                                    <table class="table table-striped">
                                          <thead>
                                              <tr>
                                                  <th scope="col" style="width: 30%;">Reference</th>
                                                  <th scope="col" style="width: 60%;">Designation</th>
                                                  <th scope="col" style="width: 10%;">Action</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                                @if(isset($marchs))
                                                      @foreach ($marchs as $item)
                                                      <tr>
                                                            <td>{{$item->reference}}</td>
                                                            <td>{{$item->designation}}</td>
                                                            <td><a class="entite ent-march" href="#" data-color="#e95959"><i class="icon-copy dw dw-edit2"></i></a></td>
                                                      </tr>
                                                      @endforeach
                                                @endif
                                          </tbody>
                                      </table>
                                </div>
                                <div class="tab-pane fade show " id="caisse" role="tabpanel">
                                    <table class="table table-striped">
                                          <thead>
                                              <tr>
                                                  <th scope="col" style="width: 30%;">Num. Caisse</th>
                                                  <th scope="col" style="width: 60%;">Libelle</th>
                                                  <th scope="col" style="width: 10%;">Action</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                                @if(isset($caisses))
                                                      @foreach ($caisses as $item)
                                                      <tr>
                                                            <td>{{$item->numero_caisse}}</td>
                                                            <td>{{$item->libelle}}</td>
                                                            <td><a href="#" data-color="#e95959"><i class="icon-copy dw dw-edit2"></i></a></td>
                                                      </tr>
                                                      @endforeach
                                                @endif
                                          </tbody>
                                      </table>
                                </div>
                                <div class="tab-pane fade show " id="comptoir" role="tabpanel">
                                    <table class="table table-striped">
                                          <thead>
                                              <tr>
                                                  <th scope="col" style="width: 30%;">Libelle</th>
                                                  <th scope="col" style="width: 60%;">Responsable(vendeur)</th>
                                                  <th scope="col" style="width: 10%;">Action</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                                @if(isset($comptoirs))
                                                      @foreach ($comptoirs as $item)
                                                      <tr>
                                                            <td>{{$item->libelle}}</td>
                                                            <td>{{$item->personnel->nom_complet}}</td>
                                                            <td><a href="#" data-color="#e95959"><i class="icon-copy dw dw-edit2"></i></a></td>
                                                      </tr>
                                                      @endforeach
                                                @endif
                                          </tbody>
                                      </table>
                                </div>
                                <div class="tab-pane fade show " id="client" role="tabpanel">
                                    <table class="table table-striped">
                                          <thead>
                                              <tr>
                                                  <th scope="col" style="width: 30%;">Noms & Prenoms</th>
                                                  <th scope="col" style="width: 60%;">Telephone</th>
                                                  <th scope="col" style="width: 10%;">Action</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                                @if(isset($clients))
                                                      @foreach ($clients as $item)
                                                      <tr>
                                                            <td>{{$item->nom_complet}}</td>
                                                            <td>{{$item->telephone}}</td>
                                                            <td><a class="entite ent-client" href="#" data-color="#e95959"><i class="icon-copy dw dw-edit2"></i></a></td>
                                                      </tr>
                                                      @endforeach
                                                @endif
                                          </tbody>
                                      </table>
                                </div>
                                <div class="tab-pane fade show " id="fournisseur" role="tabpanel">
                                    <table class="table table-striped">
                                          <thead>
                                              <tr>
                                                  <th scope="col" style="width: 30%;">Noms & Prenoms</th>
                                                  <th scope="col" style="width: 60%;">Telephone</th>
                                                  <th scope="col" style="width: 10%;">Action</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                                @if(isset($fournis))
                                                      @foreach ($fournis as $item)
                                                      <tr>
                                                            <td>{{$item->nom_complet}}</td>
                                                            <td>{{$item->telephone}}</td>
                                                            <td><a class="entite ent-fourni" href="#" data-color="#e95959"><i class="icon-copy dw dw-edit2"></i></a></td>
                                                      </tr>
                                                      @endforeach
                                                @endif
                                          </tbody>
                                      </table>
                                </div>
                                <div class="tab-pane fade show " id="personnel" role="tabpanel">
                                    <table class="table table-striped">
                                          <thead>
                                              <tr>
                                                  <th scope="col" style="width: 30%;">Matricule</th>
                                                  <th scope="col" style="width: 30%;">Noms & Prenoms</th>
                                                  <th scope="col" style="width: 30%;">Poste</th>
                                                  <th scope="col" style="width: 10%;">Action</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                                @if(isset($employees))
                                                      @foreach ($employees as $item)
                                                      <tr>
                                                            <td>{{$item->matricule}}</td>
                                                            <td>{{$item->nom_complet}}</td>
                                                            <td>{{$item->poste}}</td>
                                                            <td><a class="entite ent-personnel" href="#" data-color="#e95959"><i class="icon-copy dw dw-edit2"></i></a></td>
                                                      </tr>
                                                      @endforeach
                                                @endif
                                          </tbody>
                                      </table>
                                </div>
                                <div class="tab-pane fade show " id="compte" role="tabpanel">
                                    <table class="table table-striped">
                                          <thead>
                                              <tr>
                                                  <th scope="col" style="width: 30%;">Num. Compte</th>
                                                  <th scope="col" style="width: 60%;">Intitulé</th>
                                                  <th scope="col" style="width: 10%;">Action</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                                @if(isset($comptes))
                                                      @foreach ($comptes as $item)
                                                      <tr>
                                                            <td>{{$item->numero_compte}}</td>
                                                            <td>{{$item->intitule}}</td>
                                                            <td><a href="#" data-color="#e95959"><i class="icon-copy dw dw-edit2"></i></a></td>
                                                      </tr>
                                                      @endforeach
                                                @endif
                                          </tbody>
                                      </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form id="modifyElts" method="POST" action="{{url('/modifier-entite')}}" style="display:none;">
                        @csrf
                        <input type="text" name="data" id="ent-data">
                        <input type="text" name="type_model" id="ent-type">
                        <input type="text" name="depotid" id="ent-depot-id" value="0">
                    </form>
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
    <script>
        $('.entite.ent-depot').click(function(e){
            e.preventDefault();
            let depot_name = $(this).parents('tr').children('td:nth-child(1)').text();
            $("#ent-type").val("depot");
            $("#ent-data").val(depot_name);
            $("form#modifyElts").submit();
        });
        $('.entite.ent-march').click(function(e){
            e.preventDefault();
            let march_ref = $(this).parents('tr').children('td:nth-child(1)').text();
            $("#ent-type").val("marchandise");
            $("#ent-data").val(march_ref);
            $("form#modifyElts").submit();
        });
        $('.entite.ent-client').click(function(e){
            e.preventDefault();
            let client_name = $(this).parents('tr').children('td:nth-child(1)').text();
            let depotid = $('select#depot').children("option:selected").val();
            $("#ent-type").val("client");
            $("#ent-data").val(client_name);
            $("#ent-depot-id").val(depotid);
            $("form#modifyElts").submit();
        });
        $('.entite.ent-fourni').click(function(e){
            e.preventDefault();
            let fourni_name = $(this).parents('tr').children('td:nth-child(1)').text();
            let depotid = $('select#depot').children("option:selected").val();
            $("#ent-type").val("fournisseur");
            $("#ent-data").val(fourni_name);
            $("#ent-depot-id").val(depotid);
            $("form#modifyElts").submit();
        });
        $('.entite.ent-personnel').click(function(e){
            e.preventDefault();
            let personel_mat = $(this).parents('tr').children('td:nth-child(1)').text();
            $("#ent-type").val("personnel");
            $("#ent-data").val(personel_mat);
            $("form#modifyElts").submit();
        });
    </script>
</body>
</html>
