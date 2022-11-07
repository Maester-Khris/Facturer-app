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

        .center-foot {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }

        .dataTables_length {
            display: none;
        }

        .dataTables_filter {
            display: none;
        }

        span.march-qte-stock,
        span.client-tarif {
            visibility: hidden;
        }

        .table-actions i{
            color: red;
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
                                @if(Session::has('depot_name'))
                                    <h4 class="text-blue h4">Entrepot {{Session::get('depot_name')}}</h4>
                                @else
                                    <h4 class="text-blue h4">Entrepot Valtos</h4>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top:100px;">
                  <div class="col-md-6 offset-md-3 card-box mb-30">
                        <div class="pd-20 d-flex flex-row justify-content-space-between">
                              <i class="icon-copy fa fa-external-link" aria-hidden="true" style="color:grey;margin-right:10px;font-size:40px;transform:translateY(27%);"></i>
                              <p style="margin-left:10px;">
                                    vous serez redirigez vers l'interface de connexion dans
                                    <span id="rebours">10</span> secondes, <br>
                                    utilisez les identifiants de vendeurs
                              </p>
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
        $(document).ready(function () {
            $("#linkLVC").addClass("active");
            $("#linkLVC").closest(".dropdown").addClass("show");
            $("#linkLVC").closest(".submenu").css("display", 'block');
            let time = 10;
            function everyTime() {
                $("#rebours").text(time - 1);
                time --;
                console.log(time);
            }
            var myInterval = setInterval(everyTime, 1000);
            setTimeout(function(){
                console.log('RER');
                clearInterval(myInterval) 
                window.open('/connexion', '_blank');
            }, 10000);
        });

    </script>
  
</body>

</html>
