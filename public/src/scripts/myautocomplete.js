
async function autocompleteMarchandiseMethod(qtestock_march){
      $('#march').keyup(_.debounce(function () {
            var march_name = $(this).val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            depot =  $('select#depot').children("option:selected").val();
           
            $.ajax({
                  url: "/autocomplete",
                  type: "POST",
                  data: {
                  'produit': march_name,
                  'depot': depot,
                  '_token': _token
                  },
                  success: function (response) {
                  console.log(response);
                  let ul_sugestion = $('#march_suggest');
                  ul_sugestion.empty();
                  if (response.length == 0) {
                        ul_sugestion.append("<li>Aucune correspondance</li>");
                  } else {
                        //  qtestock_march = [];
                        for (let i = 0; i < response.length; i++) {
                              qtestock_march.push({
                                    marchandise: response[i].designation,
                                    qte_stock: response[i].quantite_stock
                              });
                              ul_sugestion.append("<li>" + response[i].designation + "</li>");
                        }
                  }
                  ul_sugestion.show();
                  },
                  error: function (error) {
                        console.log('hey');
                        $('#error_container').show();
                  }
            });
      }, 500));
}

async function autocompleteclientMethod(type, tarification_client){
      $('#client').keyup(_.debounce(function () {
            var client_name = $(this).val();
            var depot ="";
            if(type=="vente"){
                  depot =  $('select#depot').children("option:selected").val();
            }else if(type=="ticket"){
                  depot = "default"; // use default value and correct in the controller
            }
            $.ajax({
                  url: "/autocomplete-client",
                  type: "POST",
                  data: {
                        'client': client_name,
                        'depot': depot,
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
                                    "<li><span class='client-name'>"+ response[i].nom_complet +"</li>"
                              );
                        }
                        }
                        ul_sugestion.show();
                  },
                  error: function (error) {}
            });
      }, 500));
}

async function autocompleteClient(){
      autocompleteclientMethod("vente", []);
      $('ul#suggest').on("click", "li", function () {
            $('#client').val($(this).children('span.client-name').text());
            let ul_sugestion = $('ul#suggest');
            ul_sugestion.hide();
      });
}

async function autocompleteFournisseur(){
      $('#fournisseur').keyup(_.debounce(function () {
            var founi_name = $(this).val();
            depot =  $('select#depot').children("option:selected").val();
            $.ajax({
                  url: "/autocomplete-fournisseur",
                  type: "POST",
                  data: {
                        'fournisseur': founi_name,
                        'depot': depot,
                        '_token': _token
                  },
                  success: function (response) {
                        let ul_sugestion = $('ul#suggest');
                        ul_sugestion.empty();
                        if (response.length == 0) {
                              ul_sugestion.append("<li>Aucune correspondance</li>");
                        } else {
                              for (let i = 0; i < response.length; i++) {
                                    ul_sugestion.append("<li><span class='fournisseur-name'>"+ response[i].nom_complet +"</li>");
                              }
                        }
                        ul_sugestion.show();
                  },
                  error: function (error) {}
            });
      }, 500));
      $('ul#suggest').on( "click", "li",function () {
            $('#fournisseur').val($(this).children('span.fournisseur-name').text());
            let ul_sugestion = $('#march_suggest');
            $(this).hide();
      });
}

function autocompletemarchandiseWeb(){
      autocompleteMarchandiseMethod([]);
      $('ul#march_suggest').on( "click", "li",function () {
            $('#march').val($(this).text());  
            let ul_sugestion = $('#march_suggest');
            ul_sugestion.hide();
      });
}

function autocompleteFactureAchat(){
      var qtestock_march = [];
      autocompleteFournisseur();
      autocompleteMarchandiseMethod(qtestock_march);
      $('ul#march_suggest').on( "click", "li",function () {
            $('#march').val($(this).text());  
            let march_name = $(this).text()
            let tag_qte_ctock = $('#march_stock');
            selectedmarchandise = qtestock_march.filter(item => item.marchandise == march_name );
            console.log(selectedmarchandise);
            tag_qte_ctock.val(selectedmarchandise[selectedmarchandise.length -1].qte_stock);

            let ul_sugestion = $('#march_suggest');
            ul_sugestion.hide();
      });
}

function autocompleteFactureVente(){
      var tarification_client = [];
      var qtestock_march = [];

      autocompleteclientMethod("vente", tarification_client);
      $('ul#suggest').on("click", "li", function () {
            let client_name = $(this).children('span.client-name').text();
            let option_tarification = $('select.prix').children("option:selected");
            selectedclient = tarification_client.filter(item => item.client == client_name );
            option_tarification.val(selectedclient[0].tarification);
            option_tarification.text(selectedclient[0].tarification);
            $('#client').val(client_name);

            let ul_sugestion = $('ul#suggest');
            ul_sugestion.hide();
      });

      autocompleteMarchandiseMethod(qtestock_march);
      $('ul#march_suggest').on( "click", "li",function () {
            $('#march').val($(this).text());  
            let march_name = $(this).text()
            let tag_qte_ctock = $('#march_stock');
            selectedmarchandise = qtestock_march.filter(item => item.marchandise == march_name );
            console.log(selectedmarchandise);
            tag_qte_ctock.val(selectedmarchandise[selectedmarchandise.length -1].qte_stock);

            let ul_sugestion = $('#march_suggest');
            ul_sugestion.hide();
      });
      
}

function autocompleteTicket(){
      var marchs = [];
      var tarification_client = [];
      autocompleteclientMethod("ticket", tarification_client);
      $('ul#suggest').on("click", "li", function () {
            $('#client_name').text($(this).children('span.client-name').text());
            $('#client').val('');
            let ul_sugestion = $('ul#suggest');
            ul_sugestion.hide();
      });

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

      $('ul#march_suggest').on("click", "li", function () {
      let prix = '';
      let selected_article_des = $(this).children('span.march-des').text();
      let selected_client = $('#client_name').text();
      let tarif = tarification_client.filter(item => item.client == selected_client).map(item => item.tarification);
      let march = marchs.filter(item => item.designation == selected_article_des);
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
}

function autocompleteStock(march, callback){
      $.ajax({
            url: "/autocomplete-mvt",
            type: "POST",
            data: {
                'produit': march,
                '_token': _token
            },
            success: callback,
            error: function(error){
                  console.log(error);
            }
      });
}

function autoCompleteMouvement(){
      $('ul#march_suggest1').on("click", "li", function () {
            $('#march1').val($(this).text());
            let ul_sugestion = $('#march_suggest1');
            ul_sugestion.hide();
      });
      $('ul#march_suggest2').on("click", "li", function () {
            $('#march2').val($(this).text());
            let ul_sugestion = $('#march_suggest2');
            ul_sugestion.hide();
      });     

      $('#march1').keyup(_.debounce(function () {
            var march_name = $(this).val();
            autocompleteStock(march_name, function(response){
                  prepareAutoCompleteResponse(response, "transfert");
            });
      }, 500));
      $('#march2').keyup(_.debounce(function () {
            var march_name = $(this).val();
            autocompleteStock(march_name, function(response){
                  prepareAutoCompleteResponse(response, "entree/sortie")
            });
      }, 500));
}
function prepareAutoCompleteResponse(response, type){
      let ul_sugestion;
      if(type == "transfert"){
            ul_sugestion = $('#march_suggest1');
      }else{
            ul_sugestion = $('#march_suggest2');
      }

      ul_sugestion.empty();
      if (response.length == 0) {
            ul_sugestion.append("<li>Aucune correspondance</li>");
      } else {
            for (let i = 0; i < response.length; i++) {
                  ul_sugestion.append("<li>" + response[i].designation + "</li>");
            }
      }
      ul_sugestion.show();
}
