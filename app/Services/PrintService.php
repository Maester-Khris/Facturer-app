<?php
namespace App\Services;

use DateTime;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

class PrintService{
      public static  $mid = '123123456';
      public static  $store_name = 'Boutiques VALTO';
      public static  $store_address = 'Adresse Valto';
      public static  $store_phone = '+(237) 645328956';
      public static  $store_email = 'boutiques.valto@gmail.com';
      public static  $store_website = 'facturer.firesoftware.net';
      public static  $tax_percentage = 10;
      public static  $currency = 'Fcfa';
      public static  $image_path = 'logo.png';
      public  $transaction_id = ''; 

      public static function initPrint(){
            $printer = new ReceiptPrinter;
            $printer->init(
                  config('receiptprinter.connector_type'),
                  config('receiptprinter.connector_descriptor')
            );
            // $
            $printer->setStore(PrintService::$mid, PrintService::$store_name, PrintService::$store_address, PrintService::$store_phone, PrintService::$store_email, PrintService::$store_website);
            $printer->setCurrency(PrintService::$currency);
            $printer->setTax(PrintService::$tax_percentage);
            return $printer;
      }

      public static function Sendprint($ref_transaction, $marchs){
            $printer = PrintService::initPrint();
            if($printer){
                  $printer->setTransactionID($ref_transaction);
                  foreach ($marchs as $item) {
                        $printer->addItem(
                        $item['name'],
                        $item['quantite'],
                        $item['prix']
                        );
                  }
                  $printer->calculateSubTotal();
                  $printer->calculateGrandTotal();
                  $printer->printReceipt();
                  return 1;
            }else{
                  return 0;
            }
      }
}