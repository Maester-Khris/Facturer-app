<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8">
		<title>Facturer-App</title>
        @include('includes/css_assets')
	  <meta name="csrf-token" content="{{ csrf_token() }}" />
	  <style>
		.center-foot{
		    display:flex; 
		     flex-direction:row;
		     justify-content:center;
		     align-items:center;
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
						<h4 class="text-blue h4">Nouveau Facture vente</h4>
					</div>

					<div class="pd-20">
						<form action="">
							<div class="row">
								{{-- <div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label>Client</label>
										<input id="client" type="text" class="form-control" placeholder="nom du client">
									</div>
								</div> --}}
								<div class="col-md-3">
									<div class="form-group">
										<label>Selectionner le Client</label>
										<select id="client" class="selectpicker form-control" data-style="btn-outline-primary" name="client" data-size="5">
											@foreach ($clients as $client)
											<option value="{{$client->nom_complet}}">{{$client->nom_complet}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label>Comptoir</label>
										<input id="comptoir" type="text" value="Comptoir principal" class="form-control" readonly>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label>Code Vente</label>
										<input id="codevente" type="text" class="form-control" value="{{$code}}" readonly>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label>Le produit</label>
										<input id="march" class="form-control" type="text" placeholder="rechercher le produit">
										<ul id="march_suggest">
										</ul>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group ">
										<label>nombre d'articles</label>
										<input id="demo3" type="number" value="" name="demo3">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Prix de vente</label>
										<select class="selectpicker form-control prix" data-style="btn-outline-primary" name="prix_vente" data-size="5">
											<option value="detail">Detail</option>
											<option value="gros">Gros</option>
										</select>
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
					<!-- <div class="pd-20"> -->
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
					<!-- </div> -->
				</div>
			</div>
		</div>

		<div class="alert alert-warning alert-dismissible fade show" role="alert" style="position:absolute;top:260px;left:41%;z-index:900;display:none;">
			<strong>Alerte !</strong> 
			<span id="notif_body">You should check in on some of those fields below.</span>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	</div>

    <div class="footer-wrap pd-20 mb-20 card-box center-foot">
        @include('includes/footer')
    </div>

	@include('includes/js_assets')

    <script type="text/javascript">
        $( document ).ready(function() {
            $("#linkNewFactureClient").addClass("active");
            $("#linkNewFactureClient").closest(".dropdown").addClass("show");
            $("#linkNewFactureClient").closest(".submenu").css("display", 'block');
		$('.alert-warning').hide();
        });
    </script>

    <script type="text/javascript">
		$("input#remise").change(function () {
			let newnet = ($("input#totalfacture").val() - $("input#remise").val());
			$("input#total_net").val(newnet);
		});
    </script>

    <script type="text/javascript">
	$("#addMarch").click(function(e){
		let produit = $('#march').val();
		let quantite = $('#demo3').val();
		let type_vente = $('select.prix').children("option:selected").val();
		let _token = $('meta[name="csrf-token"]').attr('content');
		console.log(produit,quantite);
		$.ajax({
			url: "/ligne-facture-vente",
			type:"POST",
			data:{
				'designation':produit,
				'quantite':quantite,
				'_token': _token
			},
			success:function(response){
				if(response) {
					let march = response.success;
					let vente = (type_vente == "detail" ? 'Detail' : 'Gros' );
					let prix = (type_vente == "detail" ? march.prix_vente_detail : march.prix_vente_gros );
					let total = quantite * prix;
					console.log(march);
					var table = $('table.checkbox-datatable').DataTable();
					
					table.row.add([
						'<input type="checkbox"></input>',
						march.reference,
						march.designation,
						vente,
						prix,
						quantite,
						total
					]).draw();
					$('#march').val('');
					$('#demo3').val('');
					let newtotal = parseInt($('#totalfacture').val()) + total;
					$('#totalfacture').val(newtotal);
					$("input#remise").val(0)
					$('input#total_net').val(newtotal);
				}
			},
			error: function(error) {
				$('.alert-warning span#notif_body').text(error.responseJSON.error)
				$('.alert-warning').show();
				console.log(error);
			}
		});
	});
    </script>

    <script type="text/javascript">
	$("#validerfac").click(function(e){
		e.preventDefault();
		let _token = $('meta[name="csrf-token"]').attr('content');

		var table = $('table.checkbox-datatable').DataTable();
		// let client = $('#client').val();
		let client = $('select#client').children("option:selected").val()
		let comptoir = $('#comptoir').val();
		let codevente = $('#codevente').val();
		let total = $('#totalfacture').val();
		let remise = $("input#remise").val();
		let net = $("input#total_net").val();
		let marchandises= [];

		let rows = table.rows({selected:true}).data();
		for(var i=0; i<rows.length; i++){
			let marchfac = {
				'name': rows[i][2],
				'type_vente': rows[i][3],
				'prix': rows[i][4],
				'quantite': rows[i][5]
			}
			marchandises.push(marchfac);
		}

		var facture = {
			'marchandises': marchandises,
			'client': client,
			'comptoir': comptoir,
			'codevente': codevente,
			'total': total,
			'remise': remise,
			'net': net
		}
		console.log(facture);
		
		
		$.ajax({
			url: "/enregistrer-facturevente",
			type:"POST",
			data:{
				'facture':facture,
				'_token': _token
			},
			success:function(response){
				if(response) {
					console.log(response);
					window.location.replace("/nouvelleFactureVente");
				}
			}

		});
	});
    </script>

	<script type="text/javascript">
		$('ul#march_suggest').on( "click", "li",function () {
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

</body>
</html>
