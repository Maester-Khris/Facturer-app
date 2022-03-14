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
								<h4>Vente en Ligne</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Ventes</a></li>
									<li class="breadcrumb-item active" aria-current="page">Caisse</li>
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

				<div class="product-wrap">
					<div class="product-detail-wrap mb-30">
						<div class="row">
							<div class="col-lg-6 col-md-12 col-sm-12">
								<div class="product-detail-desc pd-20 card-box height-100-p">
									<h4 class="mb-20 pt-20">Details de la Facture</h4>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,
										sed do eiusmod tempor incididunt ut labore et dolore magna
										aliqua.
									</p>
									<form>
										<div class="form-group">
											<label>Vendeur au comptoir</label>
											<input class="form-control" type="text"
												placeholder="Mr Zekeng" readonly>
										</div>
										<div class="form-group">
											<label>Identifiant de la caisse</label>
											<input class="form-control" type="text"
												placeholder="CA001903" readonly>
										</div>
										<div class="form-group">
											<label>Chercher le Client</label>
											<input type="text" class="form-control search-input"
												placeholder="Mr/Mme xxxx">
										</div>
									</form>
								</div>
							</div>
							<div class="col-lg-6 col-md-12 col-sm-12">
								<div class="product-detail-desc pd-20 card-box height-100-p">
									<h4 class="mb-20 pt-20">Ajouter les produits</h4>
									<div class="row">
										<div class="col-md-6 col-6">
											<div class="form-group">
												<select class="selectpicker form-control"
													data-size="5"
													data-style="btn-outline-success"
													data-selected-text-format="count">
													<option>Prix de gros</option>
													<option>Prix au détail</option>*
												</select>
											</div>
										</div>
										<div class="col-md-6 col-6">
											<div class="price" style="padding-top:10px;">
												<del>$55.5</del><ins>$49.5</ins>
											</div>
										</div>
									</div>

									<form>
										<div class="form-group">
											<label>Le produit</label>
											<input class="form-control" type="text"
												placeholder="rechercher le produit">
										</div>

										<div class="form-group ">
											<label>nombre d'articles</label>
											<input id="demo3" type="text" value="" name="demo3">
										</div>

										<div class="row" style="margin-top: 50px;">
											<div class="col-md-6 col-6">
												<a href="#"
													class="btn btn-primary btn-block">Ajouter
													au panier</a>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- multiple select row Datatable start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-blue h4">Produits ajouté à la facture</h4>
					</div>
					<div class="pb-20">
						<table class="data-table table hover multiple-select-row nowrap">
							<thead>
								<tr>
									<th class="table-plus datatable-nosort" style="width: 20%">
										Reference</th>
									<th style="width: 30%">Désignation</th>
									<th style="width: 15%">Prix U.</th>
									<th style="width: 10%">Quantité</th>
									<th style="width: 10%">Gros/Détail</th>
									<th style="width: 15%">Total</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="table-plus">Gloria F. Mead</td>
									<td>2829 Trainer Avenue Peoria, IL 61602 </td>
									<td>Sagittarius</td>
									<td>25</td>
									<td>29-03-2018</td>
									<td>$162,700</td>
								</tr>
								<tr>
									<td class="table-plus">Andrea J. Cagle</td>
									<td>1280 Prospect Valley Road Long Beach, CA 90802 </td>
									<td>Gemini</td>
									<td>30</td>
									<td>29-03-2018</td>
									<td>$162,700</td>
								</tr>
								<tr>
									<td class="table-plus">Andrea J. Cagle</td>
									<td>2829 Trainer Avenue Peoria, IL 61602 </td>
									<td>Gemini</td>
									<td>20</td>
									<td>29-03-2018</td>
									<td>$162,700</td>
								</tr>
								<tr>
									<td class="table-plus">Andrea J. Cagle</td>
									<td>1280 Prospect Valley Road Long Beach, CA 90802 </td>
									<td>Sagittarius</td>
									<td>30</td>
									<td>29-03-2018</td>
									<td>$162,700</td>
								</tr>
								<tr>
									<td class="table-plus">Andrea J. Cagle</td>
									<td>2829 Trainer Avenue Peoria, IL 61602 </td>
									<td>Gemini</td>
									<td>25</td>
									<td>29-03-2018</td>
									<td>$162,700</td>
								</tr>
								<tr>
									<td class="table-plus">Andrea J. Cagle</td>
									<td>1280 Prospect Valley Road Long Beach, CA 90802 </td>
									<td>Sagittarius</td>
									<td>20</td>
									<td>29-03-2018</td>
									<td>$162,700</td>
								</tr>
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
            $("#linkVenteComptoir").addClass("active")
        });
    </script>
</body>
</html>
