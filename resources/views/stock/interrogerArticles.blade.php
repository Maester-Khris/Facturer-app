<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8">
		<title></title>
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
                                    <h4>Controle des stocks</h4>
                                </div>
                                <nav aria-label="breadcrumb" role="navigation">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html">Stocks</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Marchandises</li>
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
                            <h4 class="text-blue h4">Liste des Marchandises</h4>
                        </div>
                        <div class="pb-20">
                            <button id="voir"
                                class="btn btn-secondary" type="submit" style="margin-left: 20px;"
                                data-toggle="modal" data-target="#Medium-modal" >
                                voir fiche produit
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
											  @foreach($articles as $article)
                                    <tr>
                                        <td class="table-plus">{{$article->reference}}</td>
                                        <td>{{$article->designation}}</td>
                                        <td>{{$article->limite}}</td>
                                        <td>{{$article->quantite_optimal}}</td>
                                        <td>{{$article->quantite_stock}}</td>
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
                                    <h4 class="modal-title" id="myLargeModalLabel">Fiche du produit</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Désignation</th>
                                                <td id="des">Honor Y L23</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Unité achat</th>
                                                <td id="uach">Carton</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Prix d'achat</th>
                                                <td id="p_ach">5670</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Dernier prix d'achat</th>
                                                <td id="de_ach">6600</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Prix de gros</th>
                                                <td id="p_gro">7200</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Prix au détail</th>
                                                <td id="p_det">4500</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Prix moyen pondéré</th>
                                                <td id="p_moy">35000</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Conditionnement</th>
                                                <td id="cond">boite</td>
                                            </tr>

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

    <div class="footer-wrap pd-20 mb-20 card-box">
        @include('includes/footer')
    </div>

	@include('includes/js_assets')
	<script type="text/javascript">
		$("button#voir").click(function(event){

			let ref= $("table tr.selected").children(".table-plus").text();
			let _token = $('meta[name="csrf-token"]').attr('content');

			$.ajax({
			  url: "/fiche-marchandise",
			  type:"POST",
			  data:{
				  'reference':ref,
			     '_token': _token
			  },
			  success:function(response){
				  if(response) {
					 let march = response.success[0];
					 $("td#des").text(march.designation);
					 $("td#uach").text(march.unite_achat);
					 $("td#p_ach").text(march.prix_achat);
					 $("td#de_ach").text(march.dernier_prix_achat);
					 $("td#p_gro").text(march.prix_vente_gros);
					 $("td#p_det").text(march.prix_vente_detail);
					 $("td#p_moy").text(march.cmup);
					 $("td#cond").text(march.Conditionnement);
				  }
				  $("table tr.selected").removeClass('selected');
			  },
			  error: function(error) {
				console.log(error);
			  }
			});
		});
	</script>

    <script type="text/javascript">
        $( document ).ready(function() {
            $("#linkIA").addClass("active");
            $("#linkIA").closest(".dropdown").addClass("show");
            $("#linkIA").closest(".submenu").css("display", 'block');
        });
    </script> 


</body>
</html>
