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
                                    <h4 class="text-blue h4">Entrepot Saint José</h4>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if ($statut_caisse == false)
                    <div class="col-md-12 col-sm-12 text-right">
                        <div class="card-box">
                            <div class="pd-20 d-flex flex-row justify-content-center align-items-center">
                                <span>Caisse Fermé</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card-box mb-30">
                                <div class="pd-20" style="padding-bottom: 5px;">
                                    <h4 class="text-blue h4">Produits ajouté à la facture</h4>
                                </div>
                                <div class="pb-20">
                                    <table class="data-table table-ticket table hover multiple-select-row nowrap">
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
                                                    <span id="total_ticket"
                                                        style="font-weight:bold;font-size:20px;">0</span> FCFA
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row" style="margin: 10px auto;">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group" style="position: relative;">
                                                    <label>Produit</label>
                                                    <input id="march" class="form-control" type="text"
                                                        placeholder="rechercher le produit">
                                                    <ul id="march_suggest" class="autosuggest">
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-12">
                                                <div class="form-group" style="position: relative;">
                                                    <label>Qte <code>stock</code></label>
                                                    <input id="march_stock" class="form-control" type="number" value=""
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group" style="position: relative;">
                                                    <label>Qte articles</label>
                                                    <input class="form-control qte_article" type="number" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-12">
                                                <div class="form-group" style="position: relative;">
                                                    <label>Prix vente</label>
                                                    <input class="form-control prix_vente" type="number" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-12" style="padding-top:35px;">
                                                <a href="#" class="btn btn-primary" id="addMarch">
                                                    Ajouter
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row" style="margin: 10px auto;margin-top:25px;">
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
                                                    <span id="client_name" style="font-weight: bold">{{$client_comptoir}}</span>
                                                </span>
                                            </div>
                                            <div class="col-md-3">
                                                <span>No Ticket:
                                                    <span id="code_ticket" style="font-weight: bold">{{$nouveau_code}}</span>
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
                                        <button type="button" id="valider-ticket" class="btn btn-secondary btn-block"
                                            style="margin-bottom: 10px;">Valider</button>
                                        <button type="button" id="annuler-ticket" class="btn btn-secondary btn-block"
                                            style="margin-bottom: 10px;">Annuler</button>
                                        <button type="button" class="btn btn-secondary btn-block ticket-attente"
                                            style="margin-bottom: 10px;">Attente</button>
                                        <button type="button" id="rappeler-ticket" class="btn btn-secondary btn-block"
                                            style="margin-bottom: 10px;" >Rappeler</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- modal detail-->
                <div class="modal fade" id="modal-rappel" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="transform:translateX(10%);">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Rappel ticket</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <table class="data-table table-detail table stripe hover nowrap"
                                    style="margin: 15px 0;">
                                    <thead>
                                        <tr>
                                            <th style="width: 15%;">Ordre d'attente</th>
                                            <th>Identifiant</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- template for table row --}}
                <template id="ticket-row">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <div class="table-actions">
                                <a href="#" data-color="#265ed7"><i class="icon-copy dw dw-edit2"></i></a>
                                <a href="#" data-color="#e95959"><i class="icon-copy dw dw-delete-3"></i></a>
                            </div>
                        </td>
                    </tr>
                </template>
                <template id="client-default">
                    <span>{{$client_comptoir}}</span>
                </template>
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
        });
        
    </script>

    <script>
        function getDefClient() {
            var template = document.querySelector("#client-default");
            var clone = document.importNode(template.content, true);
            var span = clone.querySelector("span");
            return span.textContent;
        }
        function resetTicketInput() {
            $('#march').val('');
            $('#march_stock').val('');
            $('.qte_article').val('');
            $('.prix_vente').val('');
        }
        function resetTicket() {
            var table = $('table.table-ticket').DataTable();
            table.clear().draw();
            resetTicketInput();
            let clientDef = getDefClient();
            $('#client_name').text(clientDef);
            $('#client').val('');
            $('#total_ticket').text(0);
        }
        function newTicketNumb(){
            let _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "nouveau-codeticket",
                type: "POST",
                data: {
                    '_token': _token
                },
                success: function (response) {
                    if (response) {
                        console.log(response);
                        $('#code_ticket').text(response.code);
                    }
                }
            });
        }
        function newTicket(){
            resetTicketInput();
            resetTicket();
            newTicketNumb();
        }
        async function postTicket(url_destination) {
            var table = $('table.table-ticket').DataTable();
            let rows = table.rows({ selected: true }).data();
            let _token = $('meta[name="csrf-token"]').attr('content');
            let client = $('#client_name').text();
            let codeticket = $('#code_ticket').text();
            let total = $('#total_ticket').text();
            let marchandises = [];
            for (var i = 0; i < rows.length; i++) {
                let marchticket = {
                    'name': rows[i][1],
                    'quantite': rows[i][2],
                    'prix': rows[i][3]
                }
                marchandises.push(marchticket);
            }
            var ticket = {
                'marchandises': marchandises,
                'client': client,
                'codeticket': codeticket,
                'total': total
            }
            console.log(ticket);
            $.ajax({
                url: url_destination,
                type: "POST",
                data: {
                    'ticket': ticket,
                    '_token': _token
                },
                success: function (response) {
                    if (response) {
                        console.log(response);
                    }
                }
            });
            return "ok";
        }
    </script>

    {{-- autosuggestion produit: modifié pour renvoyé aussi le qte stocl --}}
    <script type="text/javascript">
        var marchs = [];
        $('#march').keyup(_.debounce(function () {
            var march_name = $(this).val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/autocomplete-comptoir",
                type: "POST",
                data: {
                    'produit': march_name,
                    '_token': _token
                },
                success: function (response) {
                    let ul_sugestion = $('ul#march_suggest');
                    ul_sugestion.empty();
                    if (response.length == 0) {
                        ul_sugestion.append("<li>Aucune correspondance</li>");
                    } else {
                        let data = response[0];
                        let data1 = response[1];
                        
                        for (let i = 0; i < data.length; i++) {
                            marchs.push(data[0]);
                            ul_sugestion.append(
                                "<li><span class='march-des'>" + data[i].designation +
                                "</span><span class='march-qte-stock'>" + data1[i][0] +
                                "</span></li>"
                            );
                        }
                    }
                    ul_sugestion.show();
                },
                error: function (error) {}
            });
        }, 500));

    </script>
    <script type="text/javascript">
        $('ul#march_suggest').on("click", "li", function () {
            let prix = '';
            let selected_article_des = $(this).children('span.march-des').text();
            let selected_client = $('#client_name').text();
            let tarif = tarification_client.filter(item => item.client == selected_client).map(item => item.tarification);
            let march = marchs.filter(item => item.designation == selected_article_des);
            // let test = selected_client.split(" ");
            if (tarif[0] == 'gros') {
                prix = march[0].prix_vente_gros;
            } else if (tarif[0] == 'super_gros') {
                prix = march[0].prix_vente_gros;
            } else if (tarif[0] == 'detail' || selected_client.split(" ")[0] == 'Clt') {
                prix = march[0].prix_vente_detail;
            }

            $('#march').val(selected_article_des);
            $('#march_stock').val($(this).children('span.march-qte-stock').text());
            $('ul#march_suggest').hide();
            $('.qte_article').focus();
            $('.prix_vente').val(prix);
        });
    </script>

    {{-- autosuggestion client --}}
    <script type="text/javascript">
        $('ul#suggest').on("click", "li", function () {
            $('#client_name').text($(this).children('span.client-name').text());
            $('#client').val('');
            let ul_sugestion = $('ul#suggest');
            ul_sugestion.hide();
        });
    </script>
    <script type="text/javascript">
        var tarification_client = [];
        $('#client').keyup(_.debounce(function () {
            var client_name = $(this).val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/autocomplete-client",
                type: "POST",
                data: {
                    'client': client_name,
                    '_token': _token
                },
                success: function (response) {
                    let ul_sugestion = $('ul#suggest');
                    ul_sugestion.empty();
                    if (response.length == 0) {
                        ul_sugestion.append("<li>Aucune correspondance</li>");
                    } else {
                        for (let i = 0; i < response.length; i++) {
                            tarification_client.push({
                                client: response[i].nom_complet,
                                tarification: response[i].tarification_client
                            });
                            ul_sugestion.append(
                                "<li><span class='client-name'>" + response[i].nom_complet +
                                "</span><span class='client-tarif'>" + response[i]
                                .tarification_client + "</span></li>"
                            );
                        }
                    }
                    ul_sugestion.show();
                },
                error: function (error) {}
            });
        }, 500));
    </script>

    {{-- add march --}}
    <script type="text/javascript">
        $("#addMarch").click(function (e) {
            let produit = $('#march').val();
            let quantite = $('.qte_article').val();
            let prixu = $('.prix_vente').val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/ligne-facture",
                type: "POST",
                data: {
                    'designation': produit,
                    'client': produit,
                    '_token': _token
                },
                success: function (response) {
                    if (response) {
                        let march = response.success;
                        let total = quantite * prixu;
                        var table = $('table.data-table').DataTable();
                        table.row.add([march.reference, march.designation, quantite, prixu, total]).draw();
                        let newtotal = parseInt($('#total_ticket').text()) + total;
                        $('#total_ticket').text(newtotal);
                        resetTicketInput();
                        $('#march').focus();
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

    {{-- operation ticket: rappel & attente  --}}
    <script>
        var ticketenAttente=[];
        $('#rappeler-ticket').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: "rappel-ticketenattente",
                type: "GET",
                success: function (response) {
                    if (response) {
                        ticketenAttente = [];
                        var table = $('table.table-detail').DataTable();
                        table.clear().draw();
                        response.map(item => ticketenAttente.push(item) );
                        console.log(ticketenAttente);
                        let ticketrappel = ticketenAttente.map(item => ({code: item.code_ticket, date: item.date_operation}) );
                        let ticketrappel_unique = [... new Map(ticketrappel.map((element)=>[element["code"],element])).values()];
                        console.log(ticketrappel_unique);
                        ticketrappel_unique.forEach((element, index) => {
                            table.row.add([index+1, element.code, element.date]).draw();
                        });
                        $('#modal-rappel').modal('toggle');
                        var tr = document.querySelectorAll('table.table-detail tr');
                        tr.forEach(element =>{
                            element.classList.add("ligne-rappel");
                        })
                    }
                }
            });
            
        });
        $('table.table-detail tbody').on("click", ".ligne-rappel", function () {
            let table = $('table.table-ticket').DataTable();
            let td = $(this).children("td");
            table.clear().draw();
            ticket_selectionne = ticketenAttente.filter(item => item.code_ticket == td[1].innerText)
            ticket_selectionne.forEach(element =>{
                table.row.add([element.reference_marchandise, element.designation, element.quantite, element.prix, element.quantite*element.prix]).draw();
            })
            $('#code_ticket').text(ticket_selectionne[0].code_ticket);
            $('#total_ticket').text(ticketenAttente.filter(item => item.code_ticket == td[1].innerText)[0].total);
            $('#modal-rappel').modal('toggle');
        });
    </script>

    {{-- operation ticket: valider & attente & annulet --}}
    <script type="text/javascript">
        $("#valider-ticket").click(function (e) {
            e.preventDefault();
            postTicket("/enregistrer-ticketencours").then(function(res){
                console.log(res);
                newTicket();
            });
        });
        $('.ticket-attente').click(function (e) {
            e.preventDefault();
            postTicket("/enregistrer-ticketenattente").then(function(res){
                console.log(res);
                newTicket();
            });
        });   
        $('#annuler-ticket').click(function (e) {
            resetTicket();
        });    
    </script>

</body>

</html>





{{-- // $("#valider-ticket").click(function (e) {
    //     e.preventDefault();
    //     var table = $('table.table-ticket').DataTable();
    //     let rows = table.rows({selected: true}).data();
    //     let _token = $('meta[name="csrf-token"]').attr('content');
    //     let client = $('#client_name').text();
    //     let codeticket = $('#code_ticket').text();
    //     let total = $('#total_ticket').text();

    //     let marchandises = [];
    //     for (var i = 0; i < rows.length; i++) {
    //         let marchticket = {
    //             'name': rows[i][1],
    //             'quantite': rows[i][2],
    //             'prix': rows[i][3]
    //         }
    //         marchandises.push(marchticket);
    //     }

    //     var ticket = {
    //         'marchandises': marchandises,
    //         'client': client,
    //         'codeticket': codeticket,
    //         'total': total
    //     }
    //     console.log(ticket);
        

    //     $.ajax({
    //         url: "/enregistrer-ticketencours",
    //         type: "POST",
    //         data: {
    //             'ticket': ticket,
    //             '_token': _token
    //         },
    //         success: function (response) {
    //             if (response) {
    //                 console.log(response);
    //                 // window.location.replace("/nouvelleFacture");
    //             }
    //         }

    //     });
    // }); --}}



{{-- <div class="card-box mb-30">
    <div class="pd-20" style="padding-bottom: 10px;">
        <h4 class="text-blue h4">Nouveau Ticket caisse</h4>
    </div>

    <div class="pd-20" style="padding-top: 10px;">
        <form action="">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="form-group" style="position: relative;">
                        <label>Le produit</label>
                        <input id="march" class="form-control" type="text"
                            placeholder="rechercher le produit">
                        <ul id="march_suggest" class="autosuggest">
                        </ul>
                    </div>
                </div>
                <div class="col-md-2 col-sm-12">
                    <div class="form-group" style="position: relative;">
                        <label>Qte <code>stock</code></label>
                        <input id="march_stock" class="form-control" type="number" value="0" readonly>
                    </div>
                </div>
                <div class="col-md-7"></div>
                <div class="col-md-3 col-sm-12">
                    <div class="form-group ">
                        <label>nombre d'articles</label>
                        <input id="demo3" type="number" value="" name="demo3" required>
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
</div> --}}
