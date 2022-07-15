<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8">
		<title>Facturer-App</title>
        @include('includes/css_assets')
	  <style>
		.autosuggest {
			z-index: 10;
			position: absolute;
			width: 100%;
			display: none;
		}
		.autosuggest li {
			background: #E9ECEF;
			padding: 10px;
			cursor: pointer;
		}
		.autosuggest li:hover {
			background: #CCE4F7;
		}
		.center-foot{
		    display:flex; 
		     flex-direction:row;
		     justify-content:center;
		     align-items:center;
		}
		.dataTables_length{
			display: none;
		}
		.dataTables_filter{
			display: none;
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

				<div class="card-box mb-30">
					<div class="pd-20" style="padding-bottom: 10px;">
					    <h4 class="text-blue h4">Nouveau Ticket caisse</h4>
					</div>
	    
					<div class="pd-20" style="padding-top: 10px;">
					    <form action="">
						  <div class="row">
							
							{{-- <div class="col-md-9"></div> --}}
							<div class="col-md-3 col-sm-12">
							    <div class="form-group" style="position: relative;">
								  <label>Le produit</label>
								  <input id="march" class="form-control" type="text"
									placeholder="rechercher le produit">
								  <ul id="march_suggest" class="autosuggest">
								  </ul>
							    </div>
							</div>
							<div class="col-md-3 col-sm-12">
							    <div class="form-group ">
								  <label>nombre d'articles</label>
								  <input id="demo3" type="number" value="" name="demo3">
							    </div>
							</div>
							<div class="col-md-3">
							    <div class="form-group">
								  <label>Prix de vente <code>l'unité</code></label>
								  <input class="prix_vente" id="demo3" type="number" value="" name="demo3">
							    </div>
							</div>
							<div class="col-md-3 col-sm-12" style="padding-top:35px;">
							    <a href="#" class="btn btn-primary" id="addMarch">
								  Ajouter
							    </a>
							</div>
						  </div>
					    </form>
					</div>
				  </div>
				
				<div class="row">
					<div class="col-md-9">
						<div class="card-box mb-30">
							<div class="pd-20" style="padding-bottom: 5px;">
								<h4 class="text-blue h4">Produits ajouté à la facture</h4>
							</div>
							<div class="pb-20">
								<table class="data-table table hover multiple-select-row nowrap">
									<div class="row" style="margin: 10px auto;">
										<div class="col-md-4 col-sm-12">
											<div class="form-group">
											    <input id="client" class="form-control" type="text"
												  placeholder="rechercher le client">
												<ul id="suggest" class="autosuggest" style="width: 80%;">
												</ul>
											</div>
										  </div>
										<div class="col-md-3 offset-md-5" style="margin-bottom:15px;">
											<span>Total:  
												<span id="total_ticket" style="font-weight:bold;font-size:20px;">0</span> FCFA
											</span>
										</div>
										<div class="col-md-3">
											<span>Depot: 
												<span style="font-weight: bold">Sainte Grace</span>
											</span>
										</div>
										<div class="col-md-3">
											<span>Date: 
												<span style="font-weight: bold">{{date('Y-m-d');}}</span>
											</span>
										</div>
										<div class="col-md-3" style="padding-left:10px;padding-right:10px;">
											<span>Client: 
												<span id="client_name" style="font-weight: bold">Client comptoir</span>
											</span>
										</div>
										<div class="col-md-3">
											<span>No Ticket: 
												<span style="font-weight: bold">TKT0001</span>
											</span>
										</div>
									</div>
									<thead>
										<tr>
											<th class="table-plus datatable-nosort" style="width: 20%">Reference</th>
											<th style="width: 30%">Désignation</th>
											<th style="width: 10%">Quantité</th>
											<th style="width: 15%">Prix U.</th>
											<th style="width: 15%">Total</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card-box mb-30">
							<div class="pd-20" style="padding-bottom: 10px;">
								<h5 class="text-blue h5">Operations ticket</h5>
								<div class="btn-list">
									<button type="button" class="btn btn-secondary btn-block" style="margin-bottom: 10px;">Valider</button>
									<button type="button" class="btn btn-secondary btn-block" style="margin-bottom: 10px;">Annuler</button>
									<button type="button" class="btn btn-secondary btn-block" style="margin-bottom: 10px;">Attente</button>
									<button type="button" class="btn btn-secondary btn-block" style="margin-bottom: 10px;">Rappeler</button>
								</div>
							</div>
						</div>
						{{-- <div class="col-lg-3 col-md-6 col-sm-12 mb-15"> --}}
							
						{{-- </div> --}}
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
            $("#linkVenteComptoir").addClass("active")
        });
    </script>

    {{-- autosuggestion produit --}}
  <script type="text/javascript">
	$('ul#march_suggest').on("click", "li", function () {
	    $('#march').val($(this).text());
	    let ul_sugestion = $('ul#march_suggest');
	    ul_sugestion.hide();
	});
  </script>
  <script type="text/javascript">
	$('#march').keyup(_.debounce(function () {
	    var march_name = $(this).val();
	    console.log
	    let _token = $('meta[name="csrf-token"]').attr('content');
	    $.ajax({
		  url: "/autocomplete",
		  type: "POST",
		  data: {
			'produit': march_name,
			'_token': _token
		  },
		  success: function (response) {
			console.log(response);
			let ul_sugestion = $('ul#march_suggest');
			ul_sugestion.empty();
			if (response.length == 0) {
			    ul_sugestion.append("<li>Aucune correspondance</li>");
			} else {
			    for (let i = 0; i < response.length; i++) {
				  ul_sugestion.append("<li>" + response[i].designation + "</li>");
			    }
			}
			ul_sugestion.show();
		  },
		  error: function (error) {}
	    });
	}, 500));
  </script>

    {{-- autosuggestion client --}}
  <script type="text/javascript">
	$('ul#suggest').on("click", "li", function () {
	    $('#client_name').text($(this).text());
	    let ul_sugestion = $('ul#suggest');
	    ul_sugestion.hide();
	});
  </script>
  <script type="text/javascript">
	$('#client').keyup(_.debounce(function () {
	    var client_name = $(this).val();
	    console.log
	    let _token = $('meta[name="csrf-token"]').attr('content');
	    $.ajax({
		  url: "/autocomplete-client",
		  type: "POST",
		  data: {
			'client': client_name,
			'_token': _token
		  },
		  success: function (response) {
			console.log(response);
			let ul_sugestion = $('ul#suggest');
			ul_sugestion.empty();
			if (response.length == 0) {
			    ul_sugestion.append("<li>Aucune correspondance</li>");
			} else {
			    for (let i = 0; i < response.length; i++) {
				  ul_sugestion.append("<li>" + response[i].nom_complet + "</li>");
			    }
			}
			ul_sugestion.show();
		  },
		  error: function (error) {}
	    });
	}, 500));
  </script>

<script type="text/javascript">
	$("#addMarch").click(function (e) {
	let produit = $('#march').val();
	let quantite = $('#demo3').val();
	let prixu = $('.prix_vente').val();
	
	let _token = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		url: "/ligne-facture",
		type: "POST",
		data: {
			'designation': produit,
			'_token': _token
		},
		success: function (response) {
			if (response) {
			let march = response.success;
			let total = quantite * prixu;

			console.log(march);
			var table = $('table.data-table').DataTable();
			table.row.add([
				march.reference,
				march.designation,
				quantite,
				prixu,
				total
			]).draw();
			$('#march').val('');
			$('#demo3').val('');
			let newtotal = parseInt($('#total_ticket').text()) + total;
			$('#total_ticket').text(newtotal);;
			}
		},
		error: function (error) {
			$('.alert-warning span#notif_body').text(error.responseJSON.error)
			$('.alert-warning').show();
			console.log(error);
		}
	});
	});
</script>

</body>
</html>
