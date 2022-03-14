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
								<h4>Controle des stocks</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Stocks</a></li>
									<li class="breadcrumb-item active" aria-current="page">Mouvements</li>
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

				<!-- Simple Datatable start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-blue h4">Liste mouvement des stocks</h4>
					</div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr>
									<th class="table-plus datatable-nosort">Reference Mouv.</th>
									<th>Designation</th>
									<th>Operation</th>
									<th>Date ope.</th>
									<th>Depot destination</th>
									<th>Quantité deplacée</th>
								</tr>
							</thead>
							<tbody>
								@if($mvts)
									@foreach($mvts as $mvt)
									<tr>
										<td class="table-plus">{{$mvt->reference_mouvement}}</td>
										<td>{{$mvt->marchandise->designation}}</td>

										@if($mvt->type_mouvement == "Entrée")
											<td><span class="badge badge-success">{{$mvt->type_mouvement}}</span></td>
										@elseif($mvt->type_mouvement == "Sortie")
											<td><span class="badge badge-danger">{{$mvt->type_mouvement}}</span></td>
										@else
											<td><span class="badge badge-dark">{{$mvt->type_mouvement}}</span></td>
										@endif

										<td>{{ date('Y/m/d',strtotime($mvt->date_operation))}}</td>

										<td>{{ is_null($mvt->destination) ? '/' : $mvt->destination }}</td>

										<td>{{$mvt->quantite_mouvement}}</td>
									</tr>
									@endforeach
								@endif
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
            $("#linkMS").addClass("active");
            $("#linkMS").closest(".dropdown").addClass("show");
            $("#linkMS").closest(".submenu").css("display", 'block');
        });
    </script>

</body>
</html>
