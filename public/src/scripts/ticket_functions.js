var ticketenAttente = [];
let button = '<div class="table-actions"><a href="#" data-color="#e95959"><i class="icon-copy dw dw-delete-3"></i></a></div>';

function getDaTaLigneTicket() {
      let produit = $('#march').val();
      let quantite = $('.qte_article').val();
      let prixu = $('.prix_vente').val();
      return [produit, quantite, prixu]
}

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

function newTicketNumb() {
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

function newTicket() {
      resetTicketInput();
      resetTicket();
      newTicketNumb();
}

async function postTicket(url_destination) {
      var table = $('table.table-ticket').DataTable();
      let rows = table.rows({
            selected: true
      }).data();
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
                        newTicket();
                        window.open(`/print-ticket/${response.ref}`,'_blank');
                  }
            }
      });
}


async function addTicketLine(designation, token) {
      $.ajax({
            url: "/ligne-facture",
            type: "POST",
            data: {
                  'designation': designation,
                  '_token': token
            },
            success: function(response){
                  if (response) {
                      let march = response.success;
                      let total = quantite * prixu;
                      let table = $('table.data-table').DataTable();
                      table.row.add([march.reference, march.designation, quantite, prixu, total, button]).draw();
                      let newtotal = parseInt($('#total_ticket').text()) + total;
                      $('#total_ticket').text(newtotal);
                      resetTicketInput();
                      $('#march').focus();
                  }
            },
            error: function(error){
                  $('.alert-warning span#notif_body').text(error.responseJSON.error)
                  $('.alert-warning').show();
                  console.log(error);
            }
      });
}

async function rappelTicket() {
      $.ajax({
            url: "/rappel-ticketenattente",
            type: "GET",
            success: function (response) {
                  if (response) {
                        ticketenAttente = [];
                        var table = $('table.table-detail').DataTable();
                        table.clear().draw();
                        response.map(item => ticketenAttente.push(item));
                        console.log(ticketenAttente);
                        let ticketrappel = ticketenAttente.map(item => ({
                              code: item.code_ticket,
                              date: item.date_operation
                        }));
                        let ticketrappel_unique = [...new Map(ticketrappel.map((element) => [element["code"], element])).values()];
                        console.log(ticketrappel_unique);
                        ticketrappel_unique.forEach((element, index) => {
                              table.row.add([index + 1, element.code, element.date]).draw();
                        });
                        $('#modal-rappel').modal('toggle');
                        var tr = document.querySelectorAll('table.table-detail tr');
                        tr.forEach(element => {
                              element.classList.add("ligne-rappel");
                        })
                  }
            },
      });
}



$('.table-ticket tbody').on('click', 'tr.selected div.table-actions', function (e) {
      var table = $('.table-ticket').DataTable();
      table.row($(this).parents('tr')).remove().draw();
      let newtotal = table.rows().data().reduce((newtotal, element) => newtotal + element[4], 0)
      $('#total_ticket').text(newtotal); // update total facture
});
$('table.table-detail tbody').on("click", ".ligne-rappel", function () {
      let table = $('table.table-ticket').DataTable();
      let td = $(this).children("td");
      table.clear().draw();
      ticket_selectionne = ticketenAttente.filter(item => item.code_ticket == td[1].innerText)
      ticket_selectionne.forEach(element => {
            table.row.add([element.reference_marchandise, element.designation, element.quantite, element.prix, element.quantite * element.prix, button]).draw();
      })
      $('#code_ticket').text(ticket_selectionne[0].code_ticket);
      $('#total_ticket').text(ticketenAttente.filter(item => item.code_ticket == td[1].innerText)[0].total);
      $('#modal-rappel').modal('toggle');
});
