function resetLigneFacture(){
	$('#march').val('');
	$('#demo3').val('');
}
function getDataLigneFacture(){
      var depot =  $('select#depot').children("option:selected").val();
      var type_vente = $('select.prix').children("option:selected").val();
      var produit = $('#march').val();
      var quantite = $('.qte_article').val();
      return [depot, produit, quantite, type_vente];
}
function getDataFacture(type_facture){
      var total = $('#totalfacture').val();
      var remise = $("input#remise").val();
      var net = $("input#total_net").val();
      var depot =  $('select#depot').children("option:selected").val();
      if(type_facture == 'vente'){
		var client = $('#client').val();
		var codevente = $('#codevente').val();
            return [depot, client, total, remise, net, codevente];
      }else if(type_facture == 'achat'){
		var fournisseur = $('#fournisseur').val();
		var codefac = $('#codefac').val();
            return [depot, fournisseur, total, remise, net, codefac];
	}
}
function updateFactureNet(){
      $("input#remise").change(function () {
            let newnet = ($("input#totalfacture").val() - $("input#remise").val());
            $("input#total_net").val(newnet);
      });
}

function extractFacItems(datatable, type){
	let marchandises= [];
	let factureinfo = getDataFacture(type);
	let rows = datatable.rows({selected:true}).data();
	for(var i=0; i<rows.length; i++){
		let marchfac;
		if(type== "vente"){
			marchfac = {
				'name': rows[i][2],
				'type_vente': rows[i][3],
				'prix': rows[i][4],
				'quantite': rows[i][5]
			};
		}else if(type== "achat"){
			marchfac = {
				'name': rows[i][2],
				'prix': rows[i][3],
				'quantite': rows[i][4]
			};
		}
		marchandises.push(marchfac);
	}
	var facture = {
		'marchandises': marchandises,
		'depot': factureinfo[0],
		'total': factureinfo[2],
		'remise': factureinfo[3],
		'net': factureinfo[4]
	};
	if(type== "vente"){
		facture['client']= factureinfo[1];
		facture['codevente']= factureinfo[5];
	}else if(type== "achat"){
		facture['fournisseur']= factureinfo[1],
		facture['codefac']= factureinfo[5];
	}
	return facture;
}

function setCodeFacture(){
	actualFactureCode('achat', _token, function (response) {
	    if(response){
		  console.log(response);
		  codedfac.value= response.code
	    }
	});
}

function actualFactureCode(type, _token, successCallbck){
	// type: vente | Achat
	var depot =  $('select#depot').children("option:selected").val();
	$.ajax({
		url: "code-facture",
		type: "POST",
		data: {
			'type' : type,
			'depot' : depot,
			'_token': _token
		},
		success: successCallbck
	});
}
async function addFactureLine(type,data,token,callback){
      // type: vente || achat
      $.ajax({
            url: type== "vente" ? "/ligne-facture-vente" : "ligne-facture",
            type:"POST",
            data:{
                  "depot": data[0],
                  'designation':data[1],
                  'quantite':data[2],
                  '_token': token
            }, 
            success: callback,
		error: function(err){
			let errordiv =  document.getElementById('error_container');
			let errorctn = errordiv.querySelector("span#notif_body");
			errorctn.textContent = 'Désolé article introuvable';
			errordiv.style.display = "block";
			$('#error_message').children('span.notif_body');
		}
      });
}
async function validateFacture(type, facture, token, callback){
      // type: vente || achat
      $.ajax({
            url: type== "vente" ? "enregistrer-facturevente" : "enregistrer-factureachat",
            type:"POST",
            data:{
                  'facture':facture,
                  '_token': token
            }, 
            success: callback,
		error: function(err){
			console.log(err.responseJSON.error)
			let errordiv =  document.getElementById('error_container');
			let errorctn = errordiv.querySelector("span#notif_body");
			errorctn.textContent = err.responseJSON.error;
			errordiv.style.display = "block";
			$('#error_message').children('span.notif_body');
		}
      });
}
async function detailFacure(type, reference, depot, token, successCallbck){
	$.ajax({
		url: "/detailfacture",
		type: "POST",
		data: {
		    'code': reference,
		    'type': type,
		    'depot': depot,
		    '_token': token
		},
		success: successCallbck,
		error: function (error) {
			console.log(error);
		}
      });
}

function showErrorOnAdd(text){
	$('.alert-warning span#notif_body').text(error.responseJSON.error)
	$('.alert-warning').show();
	console.log(error);
}