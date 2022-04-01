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
								<h4>Relation Client</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Vente</a></li>
									<li class="breadcrumb-item active" aria-current="page">Reglement Factures</li>
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

                        <!-- Export Datatable start -->
                    <div class="card-box mb-30">
                        <div class="pd-20">
                            <h4 class="text-blue h4">Liste des Factures impayées</h4>
                        </div>
                        <div class="pb-20">
                            <button id="voir"
                                class="btn btn-secondary" type="submit" style="margin-left: 20px;"
                                data-toggle="modal" data-target="#Medium-modal" >
                                Regler
                            </button>
                            <table class="table hover multiple-select-row data-table-export nowrap">
                                <thead>
                                    <tr>
                                          <th>Nom Client</th>
                                          <th>Reference Vente</th>
                                          <th>Date facturation</th>
                                          <th>Total <code>.net</code></th>
                                          <th>Reste <code>à payer</code></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($impayes as $vente)
                                        <tr>
                                            <td class="table-plus">{{$vente->client->nom}}</td>
                                            <td>{{$vente->code_vente}}</td>
                                            {{-- <td>{{  date('Y/m/d h:m:s', strtotime($vente->date_facturation) ) }}</td> --}}
                                            <td>{{$vente->date_operation}}</td>
                                            <td>{{$vente->montant_net}}</td>
                                            <td>{{$vente->reste_vente}}</td>
                                        </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal fade" id="Medium-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="transform:translateX(20%);">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myLargeModalLabel">Regler facture vente</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form id="form-regler" action="{{url('regler-facture-vente')}}" method="POST">
                                          @csrf
                                          <div class="form-group ">
                                            <label>Client</label>
                                            <input id="client" class="form-control" type="text" name="client" readonly>
                                          </div>
                                          <div class="row">
                                                <div class="col-md-6 col-6">
                                                      <div class="form-group">
                                                            <input id="codevente" class="form-control" type="text" name="codevente" readonly>
                                                      </div>
                                                </div>
                                                <div class="col-md-6 col-6">
                                                      <div class="price" style="padding-top:10px;">
                                                            <span><em>Total net à payer:</em></span><ins id="net">3000000</ins>
                                                      </div>
                                                </div>
                                          </div>
                                          
                                          <div class="form-group ">
                                                <label>Somme <code>à regler</code></label>
                                                <input id="" type="number" name="demo3" max="1000000">
                                          </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button id="btn-regler" type="submit" class="btn btn-success">Valider</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
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
            $("#linkLFCC").addClass("active");
            $("#linkLFCC").closest(".dropdown").addClass("show");
            $("#linkLFCC").closest(".submenu").css("display", 'block');
        });
    </script>

    <script>
	    function mydate(date){
		const str = (new Date(date)).toISOString().slice(0, 19).replace(/-/g, "/").replace("T", " ");
		return str;
	    }
    </script>
    <script type="text/javascript">
      $("button#voir").click(function(event){
            var table = $('table.multiple-select-row').DataTable(); 
            let row = table.row('.selected').data();
            console.log(row);
            $('input#client').val(row[0]);
            $('input#codevente').val(row[1]);
            $('ins#net').text(row[3]);
      });
    </script>
    <script type="text/javascript">
	$("button#btn-regler").click(function(event){
		event.preventDefault();
		console.log("cliquer!");
		$("form#form-regler").submit();
	});
    </script>
  
</body>
</html>