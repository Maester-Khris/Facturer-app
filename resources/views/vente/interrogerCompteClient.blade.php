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
									<li class="breadcrumb-item active" aria-current="page">Compte Clients</li>
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


				<!-- basic table  Start -->
				<div class="pd-20 card-box mb-30" style="position: relative;">
					<div class="clearfix ">
						<div class="pull-left">
							<h4 class="text-blue h4">Operation Compte client</h4>
							<p>Récentes <code>transactions</code></p>
						</div>

					</div>

					<div  style="position:absolute; right: 20px;transform: translateY(-10px);z-index: 9;">
						<form>
							<div class="row">
								<div class="offset-md-2 col-md-5">
									<div class="form-group">
										<input class="form-control month-picker" placeholder="Select Month" type="text">
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<input class="form-control" type="text" placeholder="rechercher le fournisseur">
									</div>
								</div>
							</div>
						</form>
					</div>

					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th>Reference Fac.</th>
								<th>Libellé Fac.</th>
								<th>Total <code>.net</code></th>
								<th>Modification solde</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Tiger Nixon</td>
								<td>System Architect</td>
								<td>20800</td>
								<td><code>+</code> 12000</td>
							</tr>
							<tr>
								<td>Angelica Ramos</td>
								<td>Chief Executive Officer (CEO)</td>
								<td>1,200,000</td>
								<td><code>+</code> 100000</td>
							</tr>
							<tr>
								<td>Ashton Cox</td>
								<td>Junior Technical Author</td>
								<td>86000</td>
								<td><code>-</code> 5000</td>
							</tr>
							<tr>
								<td>Bradley Greer</td>
								<td>Software Engineer</td>
								<td>13200</td>
								<td><code>+</code> 10000</td>
							</tr>
							<tr>
								<td>Brenden Wagner</td>
								<td>Software Engineer</td>
								<td>206000</td>
								<td><code>-</code> 17000</td>
							</tr>
						</tbody>
					</table>

					<div class="clearfix" style="margin-top: 20px;">
						<div class="pull-right">
							<form action="">
								<div class="row">
									<div class="offset-md-2 col-md-10 col-sm-12">
										<div class="form-group d-flex flex-column" >
											<label class="align-self-end">Total solde Compte</label>
											<input type="number" class="form-control" placeholder="289750" readonly>
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

    <div class="footer-wrap pd-20 mb-20 card-box">
        @include('includes/footer')
    </div>

	@include('includes/js_assets')

    <script type="text/javascript">
        $( document ).ready(function() {
            $("#linkICC").addClass("active");
            $("#linkICC").closest(".dropdown").addClass("show");
            $("#linkICC").closest(".submenu").css("display", 'block');
        });
    </script>

</body>
</html>
