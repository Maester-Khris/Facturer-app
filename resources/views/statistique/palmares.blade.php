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
                                <h4>Suivi des chiffres</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Statistique</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Articles</li>
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

                @if(!isset($data))
                  <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Statistique</h4>
                    </div>
                    <div class="pd-20" style="padding-top: 0;">
                        <form action="{{url('statDepot')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Periode Min: </label>
                                        <input class="form-control" name="periode_min" placeholder="Select Date"
                                            type="date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Periode Max: </label>
                                    <input class="form-control" name="periode_max" placeholder="Select Date"
                                        type="date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input class="btn btn-info" type="submit" value="Consulter">
                            </div>
                        </form>
                    </div>
                  </div>
                  @else
                  <div class="row">
                      <div class="col-md-4">
                          <div class="col-xl-12 mb-15">
                              <div class="card-box height-100-p widget-style1">
                                  <div class="d-flex flex-wrap align-items-center">
                                      <div class="progress-data">
                                          <div id="chart"></div>
                                      </div>
                                      <div class="widget-data">
                                          <div class="h4 mb-0">{{$facture_ventes}}</div>
                                          <div class="weight-600 font-14">Factures Vente <code>reglé</code></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-xl-12 mb-15">
                              <div class="card-box height-100-p widget-style1">
                                  <div class="d-flex flex-wrap align-items-center">
                                      <div class="progress-data">
                                          <div id="chart2"></div>
                                      </div>
                                      <div class="widget-data">
                                          <div class="h4 mb-0">{{$ticket}}</div>
                                          <div class="weight-600 font-14">Tickets Vente <code>archivé</code></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-xl-12 mb-15">
                              <div class="card-box height-100-p widget-style1">
                                  <div class="d-flex flex-wrap align-items-center">
                                      <div class="progress-data">
                                          <div id="chart3"></div>
                                      </div>
                                      <div class="widget-data">
                                          <div class="h4 mb-0">{{$marge}}</div>
                                          <div class="weight-600 font-14">Marge</div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-xl-12 mb-15">
                              <div class="card-box height-100-p widget-style1">
                                  <div class="d-flex flex-wrap align-items-center">
                                      <div class="progress-data">
                                          <div id="chart4"></div>
                                      </div>
                                      <div class="widget-data">
                                          <div class="h4 mb-0">Fcfa {{$chiffre_affaire}}</div>
                                          <div class="weight-600 font-14">Chiffre Affaire</div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-8">
                          <div class="card-box mb-30">
                              <div class="pd-20">
                                  <h4 class="text-blue h4">Statistique des Articles</h4>
                              </div>
                              <div class="pb-20">
                                  <table class="data-table table-stats-articles table stripe hover nowrap">
                                      <thead>
                                          <tr>
                                              <th class="table-plus datatable-nosort">Reference</th>
                                              <th>Designation</th>
                                              <th>Quantité <code>(vendue)</code></th>
                                              <th>Somme <code>(vendue)</code></th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach($data as $article)
                                          <tr>
                                              <td class="table-plus">{{$article->reference}}</td>
                                              <td>{{$article->designation}}</td>
                                              <td>{{$article->nbvente}}</td>
                                              <td>{{$article->nbvente * $article->prix}}</td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
                  @endif
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
        $(document).ready(function () {
            $("#linkLLP").addClass("active");
            $("#linkLLP").closest(".dropdown").addClass("show");
            $("#linkLLP").closest(".submenu").css("display", 'block');
        });

    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('table.table-stats-articles').DataTable().page.len(4);
        });

    </script>

</body>

</html>
