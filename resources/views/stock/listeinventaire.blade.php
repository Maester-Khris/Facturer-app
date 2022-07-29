<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Facturer-App</title>
    @include('includes/css_assets')
    <style>
	.center-foot {
		display: flex;
		flex-direction: row;
		justify-content: center;
		align-items: center;
	}
	#march_suggest1,
	#march_suggest2 {
		z-index: 10;
		position: absolute;
		width: 100%;
		display: none;
	}
	#march_suggest1 li,
	#march_suggest2 li {
		background: #E9ECEF;
		padding: 10px;
		cursor: pointer;
	}
	#march_suggest1 li:hover,
	#march_suggest2 li:hover {
		background: #CCE4F7;
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
					{{-- <tr>
						<td>PO 12</td>
						<td>PO 12</td>
						<td>PO 12</td>
						<td>
							<a href="#" class="btn-block" data-toggle="modal" data-target="#modal-inventaire"
								type="button">
								plus de details
							</a>
						</td>
					</tr> --}}
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
				</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- modal detail inventaire -->
	<div class="modal fade" id="modal-inventaire" tabindex="-1" role="dialog"
		aria-labelledby="myLargeModalLabel" aria-hidden="true" style="">
		<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content" style="transform:translateX(10%);">
			<div class="modal-header">
				<h4 class="modal-title" id="myLargeModalLabel">Detail de l'inventaire</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<table class="data-table table table-detail stripe hover nowrap" style="margin: 15px 0;">
				<thead>
					<tr>
						<th>Ref March.</th>
						<th>Deisgnation</th>
						<th>Ancienne Qte</th>
						<th>Quantité réelle</th>
						<th>Difference</th>
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

    <script type="text/javascript">
	$(document).ready(function () {
		$("#linkLI").addClass("active");
		$("#linkLI").closest(".dropdown").addClass("show");
		$("#linkLI").closest(".submenu").css("display", 'block');
	});
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('table.checkbox-datatable').DataTable().page.len(4);
            //  table2.page.len(4);
        });
    </script>
    <script type="text/javascript">
        $("button#btn-transfer").click(function (event) {
            event.preventDefault();
            console.log("cliquer!");
            $("form#form-transfer").submit();
        });
        $("button#btn-reajust").click(function (event) {
            event.preventDefault();
            console.log("cliquer!");
            $("form#form-reajust").submit();
        });
    </script>

    {{-- detail d'un mouvement  --}}
    <script type="text/javascript">
	$("a#detail_ivt").click(function (event) {
	    event.preventDefault();
	    let code_inv = $("table.multiple-select-row tr.selected").children(".table-plus").text();
	    console.log(code_inv);
	    let _token = $('meta[name="csrf-token"]').attr('content');
	    $.ajax({
		  url: "/details-ivt",
		  type: "POST",
		  data: {
			'code': code_inv,
			'_token': _token
		  },
		  success: function (response) {
			if (response) {
			    console.log(response);
			    var table = $('table.table-detail').DataTable();
			    for (var i = 0; i < response.length; i++) {
				  table.row.add([
					response[i].marchandise.reference,
					response[i].marchandise.designation,
					response[i].ancienne_quantite,
					response[i].quantite_reajuste,
					response[i].difference
				  ]).draw();
			    }
			    $('#modal-inventaire').modal('show');
			}
		  },
		  error: function (error) {
			console.log(error);
		  }
	    });
	})
  </script>

</body>

</html>
