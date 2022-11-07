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
								<h4>Relation Fournisseur</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Achat</a></li>
									<li class="breadcrumb-item active" aria-current="page">Liste factures</li>
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
					    <h4 class="text-blue h4">Lister les factures d'achat d'un depot</h4>
					</div>
	    
					<div class="pd-20" style="padding-top: 0;">
						<form action="{{url('getFacturesFournisseur')}}" method="POST">
							@csrf
					         <div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Selectionner le depot</label>
									<select id="depot" class="form-control" data-style="btn-outline-primary" name="depot" data-size="5" required>
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
					                     Lister les factures
							     </button>
					            </div>
					         </div>
					     </form>
					</div>
				</div>

				<!-- Export Datatable start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-blue h4">Liste des Facture fournisseur</h4>
					</div>
					<div class="pb-20">
						<table class="table hover multiple-select-row table-facture data-table-export nowrap">
							<thead>
								<tr>
									<th class="table-plus datatable-nosort">Reference Fac.</th>
									<th>Fournisseur</th>
									<th>Date Ach.</th>
									<th>Total Fac. <code>net</code></th>
									<th>Statut <code>regelement</code></th>
									<th>Autres</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($factures))
									@foreach ($factures as $fac)
										<tr>
											<td class="table-plus">{{$fac->code_facture}}</td>
											<td>{{$fac->fournisseur->nom_complet}}</td>
											<td>{{$fac->date_facturation}}</td>
											<td>{{$fac->montant_net}}</td>
											<td>
												@if($fac->statut == true)
													<code style="font-size: 15px; color:rgb(100, 214, 119);">terminé</code>
												@else
													<code style="font-size: 15px; color:brown;">non termine</code>
												@endif
											</td>
											<td>
												<a id="detail_operation" href="#" class="btn-block" type="button">
												    plus de details
												</a>
											</td>
										</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>

				<!-- modal detail-->
				<div class="modal fade" id="modal-detail-facture" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
					aria-hidden="true" style="">
					<div class="modal-dialog modal-lg modal-dialog-centered">
					<div class="modal-content" style="transform:translateX(10%);">
						<div class="modal-header">
							<h4 class="modal-title" id="myLargeModalLabel">Detail Facture</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						</div>
						<div class="modal-body">
							<table class="data-table table-detail-facture table stripe hover nowrap" style="margin: 15px 0;">
							<thead>
								<tr>
									<th style="width: 15%;">Ref Facture</th>
									<th>Nom Fourni</th>
									<th>Ref March</th>
									<th>Designation March</th>
									<th>Prix U.</th>
									<th>Quantite</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
							</table>
							<div class="clearfix" style="margin-top: 20px;margin-right:10px;">
								<div class="pull-right">
								    <form action="">
									  <div class="row">
										<div class="col-md-12 col-sm-12">
										    <div class="form-group">
											  <label>Total Facture</label>
											  <input id="total_facture" type="number" class="form-control" readonly>
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
		</div>
	</div>

    <div class="footer-wrap pd-20 mb-20 card-box center-foot">
        @include('includes/footer')
    </div>

	@include('includes/js_assets')
    
    <script type="text/javascript">
	$( document ).ready(function() {
		$("#linkFF").addClass("active");
		$("#linkFF").closest(".dropdown").addClass("show");
		$("#linkFF").closest(".submenu").css("display", 'block');
	});
	var _token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script src="{{asset('src/scripts/facture_functions.js')}}"></script>
	<script type="text/javascript">
		$("a#detail_operation").click(function (event) {
			event.preventDefault();
			let ref_facture = $("table.table-facture tr.selected").children(".table-plus").text();
			let depot =  $('select#depot').children("option:selected").val();
			console.log(ref_facture);
			detailFacure("achat", ref_facture, depot, _token, function(response){
				if(response) {
					let detail = response[0][0];
					let fournisseur = response[1];
					var table = $('table.table-detail-facture').DataTable();
					var totalfac = 0;
					table.clear().draw();
					for (var i = 0; i < detail.length; i++) {
						let march_prix = detail.prix;
						let march_qte = detail.quantite;
						table.row.add([
							detail.reference_transaction, fournisseur, detail.reference_marchandise, detail.designation, march_prix, march_qte, march_qte*march_prix
						]).draw();
						totalfac += march_prix * march_qte;
					}
					$("#total_facture").val(totalfac);
					$('#modal-detail-facture').modal('show');
				}
			});
		});
	</script>
</body>
</html>
