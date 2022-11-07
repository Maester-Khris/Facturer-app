<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Facturer-App</title>
    @include('includes/css_assets')
    @include('includes/css_myadditional')
</head>

<body>

    @include('includes/loader')

    <div class="header">
        @include('includes/header')
    </div>

    <div class="left-side-bar">
        @include('includes/sidebar')
    </div>

    <div class="main-container" style="position: relative;">
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
				    <h4 class="text-blue h4">Lister les operations d'inventaires d'un depot</h4>
				</div>
    
				<div class="pd-20" style="padding-top: 0;">
					<form action="{{url('listInventaire')}}" method="POST">
					    @csrf
					    <div class="row">
						  <div class="col-md-3">
							<div class="form-group">
							    <label>Selectionner le depot</label>
							    <select id="depot" class="form-control" data-style="btn-outline-primary" name="depot"
								  data-size="5" required>
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
							    Afficher l'inventaire
							</button>
						  </div>
					    </div>
					</form>
				</div>
			</div>

			<!-- Table etat inventaire -->
			<div class="pd-20 card-box mb-30" style="position: relative;">
				<div class="clearfix mb-20">
					<div class="pull-left">
						<h4 class="text-blue h4">Consulter les saisies inventaires</h4>
						<p>Liste des references <code>inventaires</code> effectué</p>
					</div>
				</div>
				<table class="table hover multiple-select-row data-table-export nowrap">
				<thead>
					<tr>
						<th class="table-plus datatable-nosort">Reference Inv.</th>
						<th>Date Inv.</th>
						{{-- <th>Nb. produit Inventorié</th> --}}
						<th>Autres</th>
					</tr>
				</thead>
				<tbody>
					@if (isset($lignes))
						@foreach($lignes as $ligne)
							<tr>
								<td class="table-plus">{{$ligne->reference_inventaire}}</td>
								<td>{{$ligne->date_reajustement}}</td>
								<td>
									<a href="#" id="detail_ivt" class="btn-block" 
										type="button">
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
	</div>

	<!-- modal detail inventaire -->
	<div class="modal fade" id="modal-inventaire" tabindex="-1" role="dialog"
		aria-labelledby="myLargeModalLabel" aria-hidden="true" style="">
		<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content" style="transform:translateX(10%);width:910px;">
			<div class="modal-header">
				<h4 class="modal-title" id="myLargeModalLabel">Detail de l'inventaire</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<table class="data-table table table-detail stripe hover nowrap" style="margin: 10px 0;">
				<thead>
					<tr>
						<th style="width: 10%;">Ref March.</th>
						<th style="width: 10%;">Designation</th>
						<th style="width: 10%;">Q.Theorique</th>
						<th style="width: 10%;">Q.Réelle</th>
						<th style="width: 10%;">Ecart</th>
						<th style="width: 10%;">Cmup</th>
						<th style="width: 10%;">Difference</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				</table>
			</div>
		</div>
		</div>
	</div>

	@if(Session::has('error'))
	<div class="alert alert-warning alert-dismissible fade show" role="alert" style="position:absolute;top:160px;left:39%;z-index:900;">
		<strong>Alerte !</strong>
		<span id="notif_body">{{Session::get('error') }}</span>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	@endif

    </div>

    <div class="footer-wrap pd-20 mb-20 card-box center-foot">
        @include('includes/footer')
    </div>

    @include('includes/js_assets')
    <script src="{{asset('src/scripts/stock_function.js')}}"></script>
    
    <script type="text/javascript">
	$(document).ready(function () {
		$("#linkLI").addClass("active");
		$("#linkLI").closest(".dropdown").addClass("show");
		$("#linkLI").closest(".submenu").css("display", 'block');
		$('table.checkbox-datatable').DataTable().page.len(4);
	});
	let _token = $('meta[name="csrf-token"]').attr('content');
    </script>

    <script type="text/javascript">
	$("a#detail_ivt").click(function (event) {
	    event.preventDefault();
	    let code_inv = $("table.multiple-select-row tr.selected").children(".table-plus").text();
	    let depot = $('select#depot').children("option:selected").val();
	    detailsInv(code_inv, depot, _token);
	})
  </script>

</body>
</html>
