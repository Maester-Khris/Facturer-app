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
                                    <li class="breadcrumb-item active" aria-current="page">Interrogation Article</li>
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
					    <h4 class="text-blue h4">Lister les marchandises d'un depot</h4>
					</div>
	    
					<div class="pd-20" style="padding-top: 0;">
						<form action="{{url('listArticles')}}" method="POST">
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
						                Lister les Marchandises
						            </button>
						        </div>
						    </div>
						</form>
					</div>
				</div>

                <!-- Export Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Liste des Marchandises</h4>
                    </div>
                    <div class="pb-20">
                        <button id="detailstock"
                            class="btn btn-secondary" type="submit" style="margin-left: 20px;"
                            data-toggle="modal" data-target="#Medium-modal" >
                            Details stock produit
                        </button>
                        <table class="table hover multiple-select-row data-table-export nowrap">
                            <thead>
                                <tr>
                                    <th class="table-plus datatable-nosort">Reference</th>
                                    <th>Designation</th>
                                    <th>Limite <code>(seuil)</code></th>
                                    <th>Qté optimal</th>
                                    <th>Qté Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($articles))
                                    @foreach($articles as $article)
                                    <tr>
                                        <td class="table-plus">{{$article->reference}}</td>
                                        <td>{{$article->designation}}</td>
                                        <td>{{$article->limite}}</td>
                                        <td>{{$article->quantite_optimal}}</td>
                                        <td>{{$article->quantite_stock}}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- fiche detail stock --}}
                <div class="modal fade" id="Medium-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" >
                        <div class="modal-content" style="transform:translateX(20%);">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Fiche de detail stock</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <table class="data-table table-march-inf table stripe hover nowrap">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%;">Designation March.</th>
                                            <th style="width: 15%;">Depot Oper.</th>
                                            <th style="width: 10%;">Ref Mvt.</th>
                                            <th style="width: 15%;">Date operation</th>
                                            <th style="width: 10%;">Qte E</th>
                                            <th style="width: 10%;">Qte S</th>
                                            <th style="width: 10%;">Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-wrap pd-20 mb-20 card-box center-foot center-foot">
        @include('includes/footer')
    </div>

	@include('includes/js_assets')

    <script src="{{asset('src/scripts/stock_function.js')}}"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $("#linkIA").addClass("active");
            $("#linkIA").closest(".dropdown").addClass("show");
            $("#linkIA").closest(".submenu").css("display", 'block');
            detectQteTreshold();
        });
        let _token = $('meta[name="csrf-token"]').attr('content');
    </script> 
	<script type="text/javascript">
		$("button#detailstock").click(function(event){
			let ref= $("table tr.selected").children(".table-plus").text();
            let depot= $("select#depot").children("option:selected").val();
            let td = document.querySelectorAll(".table-march-inf td");
            td.forEach(element => {  element.innerText=''; });
            voirMachDetailsStock(ref, depot, _token);
		});
	</script>
</body>
</html>
