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
									<th>Libellé Fac.</th>
									<th>Clients</th>
									<th>Date Ach.</th>
									<th>Total Fac.</th>
									<th>Total Fac. <code>net</code></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="table-plus">Gloria F. Mead</td>
									<td>Sagittarius</td>
									<td>Frank Gather</td>
									<td>12/09/2019</td>
									<td>292000</td>
									<td>292000</td>
								</tr>
								<tr>
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
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="modal fade" id="Medium-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content" style="transform:translateX(20%);">
							<div class="modal-header">
								<h4 class="modal-title" id="myLargeModalLabel">Fiche du produit</h4>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							</div>
							<div class="modal-body">
								<table class="table table-bordered table-striped">
									<tbody>
										<tr>
											<th scope="row">Désignation</th>
											<td>Honor Y L23</td>
										</tr>
										<tr>
											<th scope="row">Unité achat</th>
											<td>Carton</td>
										</tr>
										<tr>
											<th scope="row" style="width: 35%;">Prix de vente</th>
											<td  style="width: 45%;">125000</td>
										</tr>
										<tr>
											<th scope="row">Prix d'achat</th>
											<td>5670</td>
										</tr>
										<tr>
											<th scope="row">Dernier prix d'achat</th>
											<td>6600</td>
										</tr>
										<tr>
											<th scope="row">Prix de gros</th>
											<td>7200</td>
										</tr>
										<tr>
											<th scope="row">Prix au détail</th>
											<td>4500</td>
										</tr>
										<tr>
											<th scope="row">Prix moyen pondéré</th>
											<td>35000</td>
										</tr>
										<tr>
											<th scope="row">Conditionnement</th>
											<td>boite</td>
										</tr>

									</tbody>
								</table>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            $("#linkLFC").addClass("active");
            $("#linkLFC").closest(".dropdown").addClass("show");
            $("#linkLFC").closest(".submenu").css("display", 'block');
        });
    </script>

</body>
</html>
