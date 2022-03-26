<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8">
		<title>Facturer-App</title>
        @include('includes/css_assets')
	  <meta name="csrf-token" content="{{ csrf_token() }}" />
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
								<h4 class="text-blue h4">Entrepot Saint José</h4>
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
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label>Client</label>
										<input id="client" type="text" class="form-control" placeholder="nom du client">
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
										<input id="codevente" type="text" class="form-control" value="VN0023" readonly>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label>Le produit</label>
										<input id="march" class="form-control" type="text" placeholder="rechercher le produit">
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group ">
										<label>nombre d'articles</label>
										<input id="demo3" type="text" value="" name="demo3">
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
	</div>

    <div class="footer-wrap pd-20 mb-20 card-box">
        @include('includes/footer')
    </div>

	@include('includes/js_assets')

    <script type="text/javascript">
        $( document ).ready(function() {
            $("#linkNewFactureClient").addClass("active");
            $("#linkNewFactureClient").closest(".dropdown").addClass("show");
            $("#linkNewFactureClient").closest(".submenu").css("display", 'block');
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
		let client = $('#client').val();
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
</body>
</html>
