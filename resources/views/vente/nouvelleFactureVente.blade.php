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
									<li class="breadcrumb-item active" aria-current="page">Nouveau Ticket</li>
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
						<h4 class="text-blue h4">Nouveau Ticket vente</h4>
					</div>

					<div class="pd-20">
						<form action="">
							<div class="row">
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label>Libellé facture</label>
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label>Client</label>
										<input type="text" class="form-control">
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
										<input type="text" class="form-control" placeholder="FA0023" readonly>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label>Le produit</label>
										<input class="form-control" type="text"
											placeholder="rechercher le produit">
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group ">
										<label>nombre d'articles</label>
										<input id="demo3" type="text" value="" name="demo3">
									</div>
								</div>
								<div class="col-md-3 col-sm-12" style="padding-top:35px;">
									<a href="#" class="btn btn-primary">
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
								<tr>
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
								</tr>
							</tbody>
						</table>

						<div class="clearfix" style="margin-top: 20px;">
							<div class="pull-right">
								<form action="" >
									<div class="row">
										<div class="offset-md-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label>Montant facture</label>
												<input type="number" class="form-control" placeholder="322000" readonly>
											</div>
										</div>
										<div class="col-md-3 col-sm-12">
											<div class="form-group">
												<label>Remise</label>
												<input type="number" class="form-control" placeholder="435000">
											</div>
										</div>
										<div class="col-md-3 col-sm-12">
											<div class="form-group">
												<label>Total facture <code>net</code></label>
												<input type="number" class="form-control" placeholder="289750" readonly>
											</div>
										</div>
									</div>
								</form>
							</div>
							<div class="pull-left">
								<div class="col-md-3 col-sm-12" style="padding-top:35px;">
									<a href="#" class="btn btn-outline-secondary">
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
</body>
</html>
