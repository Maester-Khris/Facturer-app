<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8">
		<title>Facturer-App</title>
		@include('includes/css_assets')
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<style>
			.center-foot{
			    display:flex; 
			     flex-direction:row;
			     justify-content:center;
			     align-items:center;
			}
			tr td:nth-child(5){
				text-align: right;
			}
			tr td:nth-child(6){
				text-align: right;
			}
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
								<h4>Relation Fournisseur</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Achat</a></li>
									<li class="breadcrumb-item active" aria-current="page">Compte Fournisseur</li>
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
					    <h4 class="text-blue h4">Consulter les activites d'un fournisseur</h4>
					</div>
	    
					<div class="pd-20" style="padding-top: 0;">
						{{-- {{url('fourni-activities')}} --}}
						<form action="{{url('fourni-activities')}}" method="POST">
							@csrf
					         <div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Selectionner le depot</label>
									<select id="depot" class="form-control" data-style="btn-outline-primary" name="depot" data-size="5">
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
							 <div class="col-md-3">
								<div class="form-group">
									<label>Selectionner le Fournisseur</label>
									@if (isset($selectedfourni))
										<input id="founisseur" name="fournisseur" type="text" class="form-control" value="{{$selectedfourni}}">
									@else
										<input id="fournisseur" name="fournisseur" type="text" class="form-control" placeholder="nom du fournisseur">
									@endif
									<ul id="suggest" class="autosuggest" style="width: 80%;">
									</ul>
								</div>
							</div>
					             <div class="col-md-3 col-sm-12" style="padding-top:35px;">
					                 <button type="submit" class="activities btn btn-primary">
					                     Consulter transactions
							     </button>
					             </div>
					         </div>
						</form>
					</div>
				</div>

				<!-- basic table  Start -->
				<div class="pd-20 card-box mb-30" style="position: relative;">
					
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th>Nom Fourni.</th>
								<th>Reference Fac.</th>
								<th>Total Facture<code>.net</code></th>
								<th>Date transaction</th>
								<th>Credit</th>
								<th>Debit</th>
								<th>Solde progressif</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($activities))
								@php
									$solde = 0;
								@endphp
								@foreach ($activities as $activity)
								@php
									$solde = $solde + ($activity['debit'] - $activity['credit']);
								@endphp
								<tr>
									<td class="table-plus">{{$activity['fournisseur']}}</td>
									<td>{{$activity['codefac']}}</td>
									<td>{{$activity['total']}}</td>
									<td>{{$activity['date_operation']}}</td>
									<td>{{$activity['credit']}}</td>
									<td>{{$activity['debit']}}</td>
									<td>{{$solde}}</td>
								</tr>
								@endforeach
							@endif
						</tbody>
					</table>

					<div class="clearfix" style="margin-top: 20px;">
						<div class="pull-right">
							<form action="">
								<div class="row">
									<div class="offset-md-2 col-md-10 col-sm-12">
										<div class="form-group d-flex flex-column" >
											<label class="align-self-end">Total solde Compte</label>
											@if(!isset($solde))
											<input id="solde_fourni" type="number" class="form-control" placeholder="0000" readonly
											style="font-size:15px;font-weight:bold;text-align:right;">
											@else
											<input id="solde_fourni" type="number" class="form-control" value="{{$solde}}" readonly
											style="font-size:15px;font-weight:bold;text-align:right;">
											@endif
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

    <div class="footer-wrap pd-20 mb-20 card-box center-foot">
        @include('includes/footer')
    </div>

	@include('includes/js_assets')

	<script type="text/javascript">
		$( document ).ready(function() {
		    $("#linkICF").addClass("active");
		    $("#linkICF").closest(".dropdown").addClass("show");
		    $("#linkICF").closest(".submenu").css("display", 'block');
		});
		var _token = $('meta[name="csrf-token"]').attr('content');
	</script>
	<script src="{{asset('src/scripts/myautocomplete.js')}}"></script>
	<script type="text/javascript">
		autocompleteFournisseur();
	</script>
</body>
</html>
