<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8">
		<title>Facturer-App</title>
      @include('includes/css_assets')
		<style>
			/* #DataTables_Table_0_filter{
				display: none;
				z-index: 1;
			} */
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
								<h4>Controle des stocks</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Stocks</a></li>
									<li class="breadcrumb-item active" aria-current="page">Situation depot</li>
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

				<div class="row">
					<div class="col-lg-4 col-md-5 col-sm-12 mb-30">
						<div class="pd-20 card-box height-100-p">
							<h4 class="mb-20 h4">Sorties</h4>
							<ul class="list-group">
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Recentes sorties
									<span class="badge badge-primary badge-pill">14</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Facture ventes
									<span class="badge badge-primary badge-pill">2</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Transfert sorties
									<span class="badge badge-primary badge-pill">1</span>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-lg-4 col-md-5 col-sm-12 mb-30">
						<div class="pd-20 card-box height-100-p">
							<h4 class="mb-20 h4">Entrée</h4>
							<ul class="list-group">
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Nouvelle entrees
									<span class="badge badge-primary badge-pill">14</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Factures Achats
									<span class="badge badge-primary badge-pill">2</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Transfert
									<span class="badge badge-primary badge-pill">1</span>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-12 mb-30">
						<div class="pd-20 card-box height-100-p">
							<h4 class="mb-20 h4">Operation Stocks</h4>
							<ul class="list-group">
								<li class="list-group-item list-group-item-info">
									<a href="#" class="btn-block" data-toggle="modal" data-target="#modal-transfert" type="button">
										Nouveau transfert
									</a>
								</li>
								<li class="list-group-item list-group-item-dark">
									<a href="#" class="btn-block" data-toggle="modal" data-target="#modal-reajust" type="button">
										Reajuster les stocks
									</a>
								</li>
								<li class="list-group-item list-group-item-warning d-flex justify-content-between align-items-center">
									Nombre d'operations
									<span class="badge badge-primary badge-pill">12</span>
								</li>
							</ul>
						</div>
					</div>
					<!-- modals form -->
					<div class="modal fade" id="modal-transfert" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content" style="transform:translateX(20%);">
								<div class="modal-header">
									<h4 class="modal-title" id="myLargeModalLabel">Transferer le stock d'un produit</h4>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								</div>
								<div class="modal-body">
									<form  id="form-transfer" action="{{url('transferer-march')}}" method="POST">
										@csrf
										<div class="form-group">
											<select class="selectpicker form-control"
												data-size="5"
												data-style="btn-outline-info"
												data-selected-text-format="count" name="destination">
												<option>Port-Hou-Boué</option>
												<option>Grand-Bassam</option>
												<option>Bonamoussadi</option>
											</select>
										</div>

										<div class="form-group">
											<label>Le produit</label>
											<input class="form-control" type="text" name="produit"
												placeholder="rechercher le produit">
										</div>

										<div class="form-group ">
											<label>Quantité à transferer</label>
											<input id="demo3" type="text" name="demo3">
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button id="btn-transfer" type="submit" class="btn btn-success">Valider</button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>

					<div class="modal fade" id="modal-reajust" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content" style="transform:translateX(20%);">
								<div class="modal-header">
									<h4 class="modal-title" id="myLargeModalLabel">Reajuster le stock d'un produit</h4>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								</div>
								<div class="modal-body">
									<form id="form-reajust" action="{{url('reajuster-march')}}" method="POST">
										@csrf
										<div class="row">
											<div class="col-md-6 col-6">
												<div class="form-group">
													<input class="form-control" type="text" name="produit"
														placeholder="rechercher le produit">
												</div>
											</div>
											<div class="col-md-6 col-6">
												<div class="price" style="padding-top:10px;">
													<span><em>Quantité en machine:</em></span><ins>49</ins>
												</div>
											</div>
										</div>
										<div class="form-group ">
											<label>Quantité réllé en stock <code>à reajuster</code></label>
											<input id="demo3" type="text" name="demo3">
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button id="btn-reajust" type="submit" class="btn btn-success">Valider</button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- basic table  Start -->
				<div class="pd-20 card-box mb-30" style="position: relative;">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h4 class="text-blue h4">Quelques données</h4>
							<p>Récentes <code>transactions</code></p>
						</div>

					</div>
					{{-- <div style="position:absolute; right: 300px; transform: translateY(0px);z-index: 9;">
						<form>
							<div class="form-group">
								<input class="form-control form-control-sm month-picker" placeholder="Select Month" type="text" style="0.25rem 0.5rem">
							</div>
						</form>
					</div> --}}

					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus datatable-nosort">Reference</th>
								<th>Designation</th>
								<th>Qté en stock</th>
								<th>Der. Qté deplacé</th>
								<th>Date der. Maj.</th>
								<th>Operation</th>
							</tr>
						</thead>
						<tbody>
							@foreach($articles as $article)
							<tr>
								<td class="table-plus">{{$article->reference}}</td>
								<td>{{$article->designation}}</td>
								<td>{{$article->quantite_stock}}</td>
								<td>
									<code>{{ $article->type_mouvement == "Entrée" ? '+' : '-' }}</code>
									{{$article->quantite_mouvement}}
								</td>

									@if(is_null($article->date_derniere_modif_qté))
										<td>/</td>
									@else
										<td>
											{{ date('Y/m/d',strtotime($article->date_derniere_modif_qté))}}
										</td>
									@endif


								@if($article->type_mouvement == "Entrée")
									<td><span class="badge badge-success">{{$article->type_mouvement}}</span></td>
								@elseif($article->type_mouvement == "Sortie")
									<td><span class="badge badge-danger">{{$article->type_mouvement}}</span></td>
								@else
									<td><span class="badge badge-dark">{{$article->type_mouvement}}</span></td>
								@endif

							</tr>
						   @endforeach
						</tbody>
					</table>
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
            $("#linkSD").addClass("active");
            $("#linkSD").closest(".dropdown").addClass("show");
            $("#linkSD").closest(".submenu").css("display", 'block');
        });
    </script>
	<script type="text/javascript">
	$("button#btn-transfer").click(function(event){
		event.preventDefault();
		console.log("cliquer!");
		$("form#form-transfer").submit();
	});
	$("button#btn-reajust").click(function(event){
		event.preventDefault();
		console.log("cliquer!");
		$("form#form-reajust").submit();
	});
	</script>

</body>
</html>
