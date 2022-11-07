function detectQteTreshold(){
      var table = $('.multiple-select-row').DataTable();
      let rows = table.rows().data();
      for(var i=0; i<rows.length; i++){
          if(parseInt(rows[i][4]) <= parseInt(rows[i][2]) ){
              console.log("inferieur au seuil");
              $('.multiple-select-row tbody tr:nth-child('+(i+1)+')').addClass('linewarning');
          }
      }
}

function getMarchs(rows){
      let marchandises = [];
      for (var i = 0; i < rows.length; i++) {
            let marchrecu = {
                  'name': rows[i][1],
                  'quantite': rows[i][2]
            }
            marchandises.push(marchrecu);
      }
      return marchandises;
}

function addMarchtoTable(produit, quantite, type, token){
      let checkbox = '<input type="checkbox"></input>';
      if(type == "mouvement"){
            var table = $('table.checkbox-datatable_1.table-mouvement').DataTable();
      }else if(type == "transfert"){
            var table = $('table.checkbox-datatable.table-transfert').DataTable();
      }
      $.ajax({
            url: '/verify-march',
            type: "POST",
            data: {
                'produit': produit,
                '_token': token
            },
            success: function (response) {
                console.log(response);
                table.row.add([checkbox, produit, quantite]).draw();
            },
            error: function(error){
                  // console.log(error);
                  let modal = type == "mouvement" ? document.getElementById('modal-mouvment') : document.getElementById('modal-transfert');
                  let errordiv =  modal.querySelector('#error_container');
			let errorctn = errordiv.querySelector("span#notif_body");
			errorctn.textContent = 'Désolé article introuvable';
			errordiv.style.display = "block";
			$('#error_message').children('span.notif_body');
            }
      });
      
}

function voirMachDetails(reference, token){
      $.ajax({
            url: "/fiche-marchandise",
            type:"POST",
            data:{
               'reference':reference,
               '_token':token
            },
            success: function(response){
                if(response) {
                    let march = response.success[0];
                    $("td#des").text(march.designation);
                    $("td#uach").text(march.unite_achat);
                    $("td#p_ach").text(march.prix_achat);
                    $("td#de_ach").text(march.dernier_prix_achat);
                    $("td#p_gro").text(march.prix_vente_gros);
                    $("td#p_det").text(march.prix_vente_detail);
                    $("td#cond").text(march.conditionnement);
                }
                $("table tr.selected").removeClass('selected');
            },
            error: function(error) {
                  console.log(error);
            }
      });
}

function voirMachDetailsStock(reference, depot, token){
      $.ajax({
            url: "/detailstock-marchandise",
            type:"POST",
            data:{
               'reference':reference,
               'depot':depot,
               '_token':token
            },
            success: function(response){
                if(response) {
                  console.log(response);
                  let stock = 0;
                  let mvts = response[0];
                  var table = $('table.table-march-inf').DataTable();
                  table.clear().draw();
                  for (var i = 0; i < mvts.length; i++) {
                        if(mvts[i].type_mouvement == "Entrée"){
                              table.row.add([mvts[i].des_marchandise, mvts[i].depot_operation, mvts[i].reference_mouvement, mvts[i].date_operation, mvts[i].quantite_mouvement, 0, stock + mvts[i].quantite_mouvement]).draw();
                              stock = stock + mvts[i].quantite_mouvement;
                        }else{
                              table.row.add([mvts[i].des_marchandise, mvts[i].depot_operation, mvts[i].reference_mouvement, mvts[i].date_operation, 0, Math.abs(mvts[i].quantite_mouvement), stock - mvts[i].quantite_mouvement]).draw();
                              stock = stock - mvts[i].quantite_mouvement;
                        }
                  }
                  table.order([1, 'asc']).draw();
                  // $('#march-stock').val(response[1]);
                }
                $("table tr.selected").removeClass('selected');
            },
            error: function(error) {
                  console.log(error);
            }
      });
}

function stockInfos(produit, depot, token, successClbck){
      $.ajax({
            url: "/stockinfo",
            type: "POST",
            data: {
                'produit': produit,
                'depot': depot,
                '_token': token
            },
            success: successClbck,
            error: function(error) {
                  let errordiv =  document.getElementById('error_container');
			let errorctn = errordiv.querySelector("span#notif_body");
			errorctn.textContent = 'Désolé article introuvable';
			errordiv.style.display = "block";
			$('#error_message').children('span.notif_body');
            }
      });
}

function newSaisieInv(marchs, depot, token){
      $.ajax({
            url: "/saisie-inv",
            type: "POST",
            data: {
                'marchs': marchs,
                'depot': depot,
                '_token': token
            },
            success: function (response) {
                  console.log(response);
                  window.location.replace("/inventaire");
            },
            error: function(error) {
                  console.log(error);
            }
      });
}

function detailsInv(code, depot, token){
      $.ajax({ 
            url: "/details-ivt",
            type: "POST",
            data: {
                'code': code,
                'depot': depot,
                '_token': token
            },
            success: function (response) {
                  if(response) {
                        var table = $('table.table-detail').DataTable();
                        table.clear().draw();
                        for (var i = 0; i < response.length; i++) {
                        table.row.add([
                              response[i].marchandise.reference,
                              response[i].marchandise.designation,
                              response[i].ancienne_quantite,
                              response[i].quantite_reajuste,
                              response[i].difference,
                              response[i].marchandise.cmup.toFixed(2),
                              (response[i].marchandise.cmup * response[i].difference).toFixed(2)
                        ]).draw();
                        }
                        $('#modal-inventaire').modal('show');
                  }
            },
            error: function (error) {
                console.log(error);
            }
      });
}

function transfertStock(marchs, destination, depart, type, token){
      $.ajax({
            url: "/transfert-stock",
            type: "POST",
            data: {
                'marchs': marchs,
                'depot_destination': destination,
                'depot_depart': depart,
                '_token': token
            },
            success: function (response) {
                console.log(response);
                if(type == 'magasin'){
                  window.location.replace('/transfertStock');
                }else{
                  window.location.replace('/mouvementsStock');
                }
            },
            error: function(error){
                  console.log(error);
            }
      });
}

function newMvtStock(type, marchs, depot, token){
      $.ajax({
            url: (type == "entree" ? "/entree-stock" : "/sortie-stock"),
            type: "POST",
            data: {
                'marchs': marchs,
                'depot': depot,
                '_token': token
            },
            success: function (response) {
                console.log(response);
                window.location.replace('/mouvementsStock');
            },
            error: function(error){
                  console.log(error);
            }
      });
}

function detailMvt(code, token, successClbck){
      $.ajax({
            url: "/details-mvt",
            type: "POST",
            data: {
                'code': code,
                '_token': token
            },
            success: function (response) {
                  if(response) {
                      var table = $('table.table-detail').DataTable();
                      table.clear().draw();
                        for (var i = 0; i < response.length; i++) {
                          table.row.add([response[i].marchandise.reference, response[i].marchandise.designation, response[i].quantite_mouvement]).draw();
                        }
                      $('#modal-detailoperation').modal('show');
                  }
            },
            error: function (error) {
                console.log(error);
            }
      });
}












