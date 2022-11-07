<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Facturer-App</title>
        @include('includes/css_assets')
	  <meta name="csrf-token" content="{{ csrf_token() }}" />
	  <style>
	      .center-foot {
	          display: flex;
	          flex-direction: row;
	          justify-content: center;
	          align-items: center;
	      }
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

    <div class="main-container" style="position: relative;">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Relation Client</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Ventes</a></li>
									<li class="breadcrumb-item active" aria-current="page">Nouvelle Facture</li>
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
						<h4 class="text-blue h4" >Nouveau Facture vente</h4>
					</div>
					<div class="pd-20">
						<form action="">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Selectionner le depot</label>
										<select id="depot" class="form-control" data-style="btn-outline-primary" name="depot" data-size="5">
											@foreach ($depots as $depot)
											<option value="{{$depot->id}}">{{$depot->nom_depot}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label>Client</label>
										<input id="client" type="text" class="form-control" placeholder="nom du client">
										<ul id="suggest" class="autosuggest" style="width: 80%;">
										</ul>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>type de vente</label>
										<select class="form-control prix" data-style="btn-outline-primary" name="prix_vente">
											<option selected value="detail">Detail</option>
										</select>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label>Code Vente</label>
										<input id="codevente" type="text" class="form-control" value="" readonly>
									</div>
								</div>
								{{-- <div class="col-md-3 col-sm-12">
								</div> --}}
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label>Le produit</label>
										<input id="march" class="form-control" type="text" placeholder="rechercher le produit">
										<ul id="march_suggest" class="autosuggest">
										</ul>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group" style="position: relative;">
									    <label>Qte <code>stock</code></label>
									    <input id="march_stock" class="form-control" type="number" value=""
										  readonly>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group ">
										<label>nombre d'articles</label>
										<input class="qte_article" id="demo3" type="number" value="" name="demo3">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Prix de vente</label>
										<input class="num_prix_vente" id="demo3" type="number" value="" name="demo3">
										
									</div>
								</div>
								
								<div class="col-md-3 col-sm-12" style="padding-top:35px;">
									<a href="#" class="btn btn-primary" id="addMarch">
										Ajouter
									</a>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="card-box mb-30" style="padding-top: 20px;">
					<table class="checkbox-datatable table nowrap" style="margin: 15px 0;">
						<thead>
							<tr>
								<th>
									<div class="dt-checkbox">
										<input type="checkbox" name="select_all" value="1" id="example-select-all">
										<span class="dt-checkbox-label"></span>
									</div>
								</th>
								<th>Reference</th>
								<th>Deisgnation</th>
								<th>Vente</th>
								<th>Prix Vente</th>
								<th>Quantité</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					<div class="clearfix" style="margin-top: 20px;margin-right:10px;">
						<div class="pull-right">
							<form action="" >
								<div class="row">
									<div class="offset-md-3 col-md-3 col-sm-12">
										<div class="form-group">
											<label>Montant facture</label>
											<input id="totalfacture" type="number" class="form-control" value="0" readonly>
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label>Remise</label>
											<input id="remise" type="number" class="form-control" value="0">
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label>Total facture <code>net</code></label>
											<input id="total_net" type="number" class="form-control" value="0" readonly>
										</div>
									</div>
								</div>
							</form>
						</div>
						<div class="pull-left">
							<div class="col-md-3 col-sm-12" style="padding-top:35px;">
								<a href="#" id="validerfac" class="btn btn-outline-secondary">
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
				
			</div>
		</div>

    </div>

    <div class="footer-wrap pd-20 mb-20 card-box center-foot">
        @include('includes/footer')
    </div>

	@include('includes/js_assets')
    
    <script src="{{asset('src/scripts/facture_functions.js')}}"></script>
    <script src="{{asset('src/scripts/myautocomplete.js')}}"></script>
    <script type="text/javascript">
      function setCodeFacture(){
		actualFactureCode('vente', _token, function (response) {
			if (response) {
				console.log(response);
				codevente.value= response.code
			}
		});
	}
      $( document ).ready(function() {
            $("#linkNewFactureClient").addClass("active");
            $("#linkNewFactureClient").closest(".dropdown").addClass("show");
            $("#linkNewFactureClient").closest(".submenu").css("display", 'block');
		$('.alert-warning').hide();
      });
	var _token = $('meta[name="csrf-token"]').attr('content');
	var codevente = document.querySelector("#codevente");
	setCodeFacture()
    </script>

    <script type="text/javascript">
    	autocompleteFactureVente();
	updateFactureNet();
	$("select#depot").change(function () {
            setCodeFacture();
      });
	$("#addMarch").click(function(e){
		e.preventDefault();
		let newLigneInfo = getDataLigneFacture();
		let prixv = $('.num_prix_vente').val();
		let quantite = newLigneInfo[2];
		let type_vente = newLigneInfo[3];
		let checkbx = '<input type="checkbox"></input>';
		addFactureLine("vente",newLigneInfo,_token, function(response){
			if(response) {
				let march = response.success;
				let vente ="";							 
				if(type_vente == "detail"){
					vente = 'Detail' ;
					prixv = prixv == "" ? march.prix_vente_detail: prixv;
				}else if(type_vente == "gros"){
					vente =  'Gros' ;
					prixv = prixv == "" ? march.prix_vente_gros: prixv;
				}else{
					vente = 'Super Gros';
					prixv = prixv == "" ? march.prix_vente_super_gros: prixv;
				} 
				let total = quantite * prixv;
				let table = $('table.checkbox-datatable').DataTable();
				table.row.add([checkbx,march.reference,march.designation,vente,prixv,quantite,total]).draw();
				$('#march').val('');
				$('.qte_article').val('');
				let newtotal = parseInt($('#totalfacture').val()) + total;
				$('#totalfacture').val(newtotal);
				$("input#remise").val(0)
				$('input#total_net').val(newtotal);
				$('.prix_vente').val(0)
			}
		});
	});
	$("#validerfac").click(function(e){
		e.preventDefault();
            let table = $('table.checkbox-datatable').DataTable();
            let facture = extractFacItems(table, "vente");
            console.log(facture);
		validateFacture("vente", facture, _token, function(response){
			console.log(response);
			window.location.replace("/nouvelleFactureVente");
		});
	});
    </script>
</body>
</html>
