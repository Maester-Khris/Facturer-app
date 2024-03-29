<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventaire;
use App\Models\Detailtransactions;
use App\Services\StockService;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;
use Illuminate\Support\Facades\Cookie;

class TestController extends Controller
{
    //
    private $stock;
    public function __construct(StockService $stock){
        $this->stock = $stock;
    }

    public function index(){
        // Cookie::queue('mycook', "cokkie1", 2);
        $countries = array("Mark" => "USA", "Raymond" => "UK", "Jeff" => "JPN", "Mike" => "DE");
        // dd(json_encode($countries));
        Cookie::queue('countries1', json_encode($countries), 2);
        // $data = Cookie::get('countries1');
        // dd(json_decode($data,true));
        // //======================= 
        // $countries = array("Mark" => "USA", "Raymond" => "UK", "Jeff" => "JPN", "Mike" => "DE");
        // $countriesJsoned = json_encode($countries);
        // $countriesBack = json_decode($countriesJsoned, true);
        // dd($countriesJsoned);
        // dd($countriesBack);
        // dd($countriesBack["Mark"]);
        //======================= 
        // echo "<script>window.open('/testprint', '_blank')</script>";
        // echo "<script>window.open('".$url."', '_blank')</script>";
    }

    public function printScreen(){
        $items = [
            [
                'name' => 'French Fries (tera)',
                'qty' => 2,
                'price' => 65000,
            ],
            [
                'name' => 'Roasted Milk Tea (large)',
                'qty' => 1,
                'price' => 24000,
            ],
            [
                'name' => 'Honey Lime (large)',
                'qty' => 3,
                'price' => 10000,
            ],
            [
                'name' => 'Jasmine Tea (grande)',
                'qty' => 3,
                'price' => 8000,
            ],
        ];
        return view("comptoir.ticketComptoir")->with(compact('items'));
    }

    public function indexe(){
        // return $this->stock->sayHello();
        // $transaction = Detailtransactions::where("reference_transaction","TKT0002")
        //           ->where("reference_marchandise", "REF0004")->first();
        //           dd($transaction);
        // use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

        // ...

        // Set params
        $mid = '123123456';
        $store_name = 'YOURMART';
        $store_address = 'Mart Address';
        $store_phone = '1234567890';
        $store_email = 'yourmart@email.com';
        $store_website = 'yourmart.com';
        $tax_percentage = 10;
        $transaction_id = 'TX123ABC456';
        $currency = 'Rp';
        $image_path = 'logo.png';

        // Set items
        $items = [
            [
                'name' => 'French Fries (tera)',
                'qty' => 2,
                'price' => 65000,
            ],
            [
                'name' => 'Roasted Milk Tea (large)',
                'qty' => 1,
                'price' => 24000,
            ],
            [
                'name' => 'Honey Lime (large)',
                'qty' => 3,
                'price' => 10000,
            ],
            [
                'name' => 'Jasmine Tea (grande)',
                'qty' => 3,
                'price' => 8000,
            ],
        ];

        // Init printer
        $printer = new ReceiptPrinter;
        $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );

        // Set store info
        $printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);

        // Set currency
        $printer->setCurrency($currency);

        // Add items
        foreach ($items as $item) {
            $printer->addItem(
                $item['name'],
                $item['qty'],
                $item['price']
            );
        }
        // Set tax
        $printer->setTax($tax_percentage);

        // Calculate total
        $printer->calculateSubTotal();
        $printer->calculateGrandTotal();

        // Set transaction ID
        $printer->setTransactionID($transaction_id);

        // Set logo
        // Uncomment the line below if $image_path is defined
        //$printer->setLogo($image_path);

        // Set QR code
        $printer->setQRcode([
            'tid' => $transaction_id,
        ]);

        // Print receipt
        $printer->printReceipt();
    }
}
