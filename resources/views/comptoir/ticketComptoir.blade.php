@php
      $sum = $details->reduce(function($carry, $item){
            return $carry + $item->prix*$item->quantite;
      }, 0);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Ticket Comptoir</title>
      <style>
            * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
            letter-spacing: 0.5px;
            }
            body {
            background-color: var(--primary-color);
            }
            .invoice-card {
            display: flex;
            flex-direction: column;
            position: absolute;
            padding: 10px 2em;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            min-height: 25em;
            width: 22em;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 10px 30px 5px rgba(0, 0, 0, 0.15);
            }
            .invoice-card > div {
            margin: 5px 0;
            }
            .invoice-title {
            /* flex: 1; */
            height: 100px;
            }
            .invoice-title #date {
            display: block;
            margin: 8px 0;
            font-size: 12px;
            }
            .invoice-title #main-title {
            display: flex;
            justify-content: space-between;
            margin-top: 2em;
            }
            .invoice-title #main-title h4 {
            letter-spacing: 2.5px;
            }
            .invoice-title span {
            color: rgba(0, 0, 0, 0.4);
            }
            .invoice-details {
            flex: 1;
            border-top: 0.5px dashed grey;
            /* border-bottom: 0.5px dashed grey; */
            display: flex;
            align-items: center;
            display: flex;
            flex-direction: column;
            }
            .invoice-table {
            width: 100%;
            border-collapse: collapse;
            }
            .invoice-table thead tr td {
            font-size: 12px;
            letter-spacing: 1px;
            color: grey;
            padding: 8px 0;
            }
            .invoice-table thead tr td:nth-last-child(1),
            .row-data td:nth-last-child(1),
            .calc-row td:nth-last-child(1)
            {
            text-align: right;
            }
            .calc-row{
                  margin-top: 60px!important;
            }
            .invoice-table tbody tr td {
            padding: 8px 0;
            letter-spacing: 0;
            }
            .invoice-table .row-data #unit {
            text-align: center;
            }
            .invoice-table .row-data span {
            font-size: 13px;
            color: rgba(0, 0, 0, 0.6);
            }
            .invoice-footer {
            flex: 1;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            }
            .invoice-footer #later {
            margin-right: 5px;
            }
            .btn {
            border: none;
            padding: 5px 0px;
            background: none;
            cursor: pointer;
            letter-spacing: 1px;
            outline: none;
            }
            .btn.btn-secondary {
            color: rgba(0, 0, 0, 0.3);
            }
            .btn.btn-primary {
            color: var(--primary-color);
            }
            .btn#later {
            margin-right: 2em;
            }
            thead tr td{
                  padding: 8px 5px!important;
            }
      </style>
</head>
<body>
      <div class="invoice-card">
            <div class="invoice-title">
            <div id="main-title">
            <h4>BOUTIQUE VALTOS</h4>
            <span>#{{$details[0]->reference_transaction}}</span>
            </div>
            
            <span id="date">{{\Carbon\Carbon::now()->toDateString()}}</span>
            </div>
            
            <div class="invoice-details">
            <table class="invoice-table">
            <thead>
                  <tr>
                  <td style="width:45%;">Produit</td>
                  <td style="width:10%;">Quantité</td>
                  <td style="width:20%;">Unité</td>
                  <td style="width:25%;">Total</td>
                  </tr>
            </thead>
            <tbody>
                  @foreach ($details as $detail)
                        <tr class="row-data">
                              <td>{{$detail->designation}}</td>
                              <td id="unit">{{$detail->quantite}}</td>
                              <td>{{$detail->prix}}</td>
                              <td>{{$detail->prix * $detail->quantite}}</td>
                        </tr>
                  @endforeach
            </tbody>
            </table>
            <p style="width: 100%;text-align: right;margin-top:10px;">
                  Total Ticket: <strong>{{$sum}} Fcfa</strong>
            </p>
            </div>
      </div>

      <script>
            window.addEventListener('load', function() {
                  window.print();
                  setTimeout(function () { window.close(); }, 500);
            });
      </script>
</body>
</html>