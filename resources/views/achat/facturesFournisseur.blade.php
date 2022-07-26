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
								<h4 class="text-blue h4">Entrepot Saint José</h4>
							</div>
						</div>
					</div>
				</div>

				<!-- Export Datatable start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-blue h4">Liste des Facture fournisseur</h4>
					</div>
					<div class="pb-20">
						<!-- <button
							class="btn btn-secondary" type="submit" style="margin-left: 20px;"
							data-toggle="modal" data-target="#Medium-modal" >
							voir facture
						</button> -->
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr>
									<th class="table-plus datatable-nosort">Reference Fac.</th>
									<th>Fournisseur</th>
									<th>Date Ach.</th>
									<th>Total Fac. <code>net</code></th>
									<th>Statut <code>regelement</code></th>
								</tr>
							</thead>
							<tbody>
								@foreach ($factures as $fac)
									<tr>
										<td class="table-plus">{{$fac->code_facture}}</td>
										<td>{{$fac->fournisseur->nom_complet}}</td>
										{{-- <td>{{  date('Y/m/d h:m:s',strtotime($fac->date_facturation)) }}</td> --}}
										<td>{{$fac->date_facturation}}</td>
										<td>{{$fac->montant_net}}</td>
										<td>
											@if($fac->statut == true)
												<code style="font-size: 15px; color:rgb(100, 214, 119);">terminé</code>
											@else
												<code style="font-size: 15px; color:brown;">non termine</code>
											@endif
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
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
    </script>

</body>
</html>
