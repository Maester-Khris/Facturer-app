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
								<h4>Relation Fournisseur</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Achat</a></li>
									<li class="breadcrumb-item active" aria-current="page">Nouvelle Factures</li>
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
						<h4 class="text-blue h4">Nouvelle Facture achat</h4>
					</div>

					<div class="pd-20">
						<form action="">
							<div class="row">
								{{-- <div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label>Libellé facture</label>
										<input type="text" class="form-control">
									</div>
								</div> --}}
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label>Fournisseur</label>
										<input id="fourni" type="text" class="form-control" placeholder="Nom fournisseur">
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label>Employé</label>
										<input type="text" placeholder="Mr Akenzeng" class="form-control" readonly>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label>Code Facture</label>
										<input id="codefac" type="text" class="form-control" value="FA0023" readonly>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label>Le produit</label>
										<input id="march" class="form-control" type="text"
											placeholder="rechercher le produit">
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group ">
										<label>nombre d'articles</label>
										<input id="demo3" type="number" value="" name="demo3">
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
									<th><div class="dt-checkbox">
											<input type="checkbox" name="select_all" value="1" id="example-select-all">
											<span class="dt-checkbox-label"></span>
										</div>
									</th>
									<th>Reference</th>
									<th>Deisgnation</th>
									<th>Quantité</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								{{-- <tr>
									<td></td>
									<td>Tiger Nixon</td>
									<td>System Architect</td>
									<td>12</td>
									<td>20800</td>
								</tr>
								<tr>
									<td></td>
									<td>Angelica Ramos</td>
									<td>Chief Executive Officer (CEO)</td>
									<td>34</td>
									<td>1,200,000</td>
								</tr>
								<tr>
									<td></td>
									<td>Ashton Cox</td>
									<td>Junior Technical Author</td>
									<td>50</td>
									<td>86,000</td>
								</tr>
								<tr>
									<td></td>
									<td>Bradley Greer</td>
									<td>Software Engineer</td>
									<td>09</td>
									<td>132,000</td>
								</tr>
								<tr>
									<td></td>
									<td>Brenden Wagner</td>
									<td>Software Engineer</td>
									<td>17</td>
									<td>206,850</td>
								</tr> --}}
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
	<template>
		<tr>
			<td></td>
			<td id="newlignref">Tiger Nixon</td>
			<td id="newligndes">System Architect</td>
			<td id="newlignqte">12</td>
			<td id="newligntot">20800</td>
		</tr>
	</template>

    <div class="footer-wrap pd-20 mb-20 card-box">
        @include('includes/footer')
    </div>

	@include('includes/js_assets')

    <script type="text/javascript">
        $( document ).ready(function() {
            $("#linkNFA").addClass("active");
            $("#linkNFA").closest(".dropdown").addClass("show");
            $("#linkNFA").closest(".submenu").css("display", 'block');
        });
    </script>
    <script type="text/javascript">
	$("input#remise").change(function(){
		let newnet = ( $("input#totalfacture").val() - $("input#remise").val() );
		$("input#total_net").val(newnet);
	});
    </script>
    <script type="text/javascript">
	$("#addMarch").click(function(e){
		let produit = $('#march').val();
		let quantite = $('#demo3').val();
		let _token = $('meta[name="csrf-token"]').attr('content');
		$.ajax({
			url: "/ligne-facture",
			type:"POST",
			data:{
				'designation':produit,
				'_token': _token
			},
			success:function(response){
				if(response) {
					let march = response.success;
					let total = quantite * march.prix_achat;
					console.log(march);
					var table = $('table.checkbox-datatable').DataTable();
					
					table.row.add([
						'<input type="checkbox"></input>',
						march.reference,
						march.designation,
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
		var table = $('table.checkbox-datatable').DataTable();
		let fournisseur = $('#fourni').val();
		let codefac = $('#codefac').val();
		let total = $('#totalfacture').val();
		let remise = $("input#remise").val();
		let net = $("input#total_net").val();
		let marchandises= [];

		let rows = table.rows({selected:true}).data();
		for(var i=0; i<rows.length; i++){
			let marchfac = {
				'name': rows[i][2],
				'quantite': rows[i][3]
			}
			marchandises.push(marchfac);
		}

		var facture = {
			'marchandises': marchandises,
			'fournisseur': fournisseur,
			'codefac': codefac,
			'total': total,
			'remise': remise,
			'net': net
		}
		console.log(facture);
		let _token = $('meta[name="csrf-token"]').attr('content');
		
		$.ajax({
			url: "/enregistrer-factureachat",
			type:"POST",
			data:{
				'facture':facture,
				'_token': _token
			},
			success:function(response){
				if(response) {
					window.location.replace("/nouvelleFacture");
				}
			}

		});
	});
    </script>
</body>
</html>
