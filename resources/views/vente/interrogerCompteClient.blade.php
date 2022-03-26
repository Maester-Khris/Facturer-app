<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8">
		<title>Facturer-App</title>
		@include('includes/css_assets')
		<meta name="csrf-token" content="{{ csrf_token() }}" />
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

				<div class="card-box mb-30">
					<div class="pd-20">
					    <h4 class="text-blue h4">Consulter les activités d'un client</h4>
					</div>
	    
					<div class="pd-20" style="padding-top: 0;">
						{{-- {{url('client-activities')}} --}}
					     <div>
					         <div class="row">
					             <div class="col-md-3 col-sm-12">
					                 <div class="form-group">
					                     <label>Client</label>
					                     <input id="client" type="text" name="client" class="form-control"
					                         placeholder="rechercher le client">
					                 </div>
					             </div>
					             <div class="col-md-3 col-sm-12" style="padding-top:35px;">
					                 <a href="#" class="activities btn btn-primary">
					                     Consulter transactions
					                 </a>
					             </div>
					         </div>
					     </div>
					</div>
				</div>

				<!-- basic table  Start -->
				<div class="pd-20 card-box mb-30" style="position: relative;">

					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th>Nom Client</th>
								<th>Refer. Vente</th>
								<th>Total Facture<code>.net</code></th>
								<th>Date transaction</th>
								<th>Credit</th>
								<th>Debit</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>

					<div class="clearfix" style="margin-top: 20px;">
						<div class="pull-right">
							<form action="">
								<div class="row">
									<div class="offset-md-2 col-md-10 col-sm-12">
										<div class="form-group d-flex flex-column" >
											<label class="align-self-end">Total solde Compte</label>
											<input id="soldeclient" type="number" class="form-control"
											placeholder="0000" readonly style="font-size:15px;font-weight:bold;">
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

	<script>
		function mydate(date){
			const str = (new Date(date)).toISOString().slice(0, 19).replace(/-/g, "/").replace("T", " ");
			return str;
		}
	</script>
	<script type="text/javascript">
		$('.activities').click(function(e){
			let client = $('input#client').val();
			let _token = $('meta[name="csrf-token"]').attr('content');
			
			$.ajax({
				url: "/client-activities",
				type:"POST",
				data:{
					'client': client,
					'_token': _token
				},
				success:function(response){
					if(response) {
						let activities = response.success[0];
						let solde = response.success[1];
						console.log(response.success);

						var table = $('table.data-table').DataTable();
						for( var i=0; i<activities.length; i++){
							let date_vente = mydate(activities[i].date_operation);
							table.row.add([
								'' + activities[i].client ,
								activities[i].codevente,
								activities[i].total,
								date_vente,
								activities[i].credit,
								activities[i].debit
							]).draw();
							console.log("each time")
						}
						$('#soldeclient').val(solde);
					}
				},
				error: function(error) {
					console.log(error);
				}
			});
		});
	</script>

</body>
</html>
