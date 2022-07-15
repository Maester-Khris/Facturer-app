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
								<h4>Relation Client</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Ventes</a></li>
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
						<h4 class="text-blue h4">Liste des Facture Client</h4>
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
									<th>Client </th>
									<th>Date Ach.</th>
									<th>Total Fac. <code>net</code></th>
									<th>Statut <code>encaissement</code></th>
								</tr>
							</thead>
							<tbody>
								@foreach ($ventes as $vente)
									<tr>
										<td class="table-plus">{{$vente->code_vente}}</td>
										<td>{{$vente->client->nom_complet}}</td>
										{{-- <td>{{  date('Y/m/d h:m:s',strtotime($vente->date_operation)) }}</td> --}}
										<td>{{$vente->date_operation}}</td>
										<td>{{$vente->montant_net}}</td>
										<td>
											@if($vente->statut == true)
												<code style="font-size: 15px; color:rgb(100, 214, 119);">encaissé</code>
											@else
												<code style="font-size: 15px; color:brown;">non terminé</code>
											@endif
										</td>
									</tr>
								@endforeach
								
								{{-- <tr>
									<td class="table-plus">Andrea J. Cagle</td>
									<td>Gemini</td>
									<td>S. Mayflower</td>
									<td>02/02/2021 </td>
									<td>20800</td>
									<td>29200</td>
								</tr>
								<tr>
									<td class="table-plus">Andrea J. Cagle</td>
									<td>Gemini</td>
									<td>X. Katherina</td>
									<td>13/02/2021 </td>
									<td>1800</td>
									<td>1800</td>
								</tr>
								<tr>
									<td class="table-plus">Andrea J. Cagle</td>
									<td>Sagittarius</td>
									<td>Khris Enter.</td>
									<td>29/09/2021</td>
									<td>300000</td>
									<td>298000</td>
								</tr>
								<tr>
									<td class="table-plus">Andrea J. Cagle</td>
									<td>Gemini</td>
									<td>Frankline R.</td>
									<td>20/12/2021</td>
									<td>298000</td>
									<td>250000</td>
								</tr> --}}
							</tbody>
						</table>
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
            $("#linkLFFC").addClass("active");
            $("#linkLFFC").closest(".dropdown").addClass("show");
            $("#linkLFFC").closest(".submenu").css("display", 'block');
        });
    </script>

</body>
</html>
