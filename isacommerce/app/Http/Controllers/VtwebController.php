<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Veritrans\Veritrans;
use DB;

class VtwebController extends Controller
{
    public function __construct()
    {   
        Veritrans::$serverKey = 'VT-server-jT2o5iakbPQtNPT6FntqZqZS';

        //set Veritrans::$isProduction  value to true for production mode
        Veritrans::$isProduction = false;
    }

    public function test($data) 
    {
        var_dump($data);
    }

    public function vtweb($invoice_no, $gross_amount) 
    {
        $vt = new Veritrans;

        $transaction_details = array(
            'order_id'      => $invoice_no,
            'gross_amount'  => $gross_amount
        );

        $base_url = url('/');

        // Data yang akan dikirim untuk request redirect_url.
        // Uncomment 'credit_card_3d_secure' => true jika transaksi ingin diproses dengan 3DSecure.
        $transaction_data = array(
            'payment_type'          => 'vtweb', 
            'vtweb'                         => array(
                //'enabled_payments'    => [],
                'credit_card_3d_secure' => true,

                //Set Redirection URL Manually
                "finish_redirect_url"   => $base_url."/payment/success/".$invoice_no,
                "unfinish_redirect_url" => "http://www.example.co.id/payment/unfinish",
                "error_redirect_url"    => "http://www.example.co.id/payment/error"
            ),
            'transaction_details'=> $transaction_details
        );
    
        try
        {
            $vtweb_url = $vt->vtweb_charge($transaction_data);
            return redirect($vtweb_url);
        } 
        catch (Exception $e) 
        {   
            return $e->getMessage;
        }
    }

    public function notification()
    {
        $vt = new Veritrans;
        $order_id = $_GET['order_id'];
        $notif = $vt->status($order_id);
        
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        if ($transaction == 'capture') {
          // For credit card transaction, we need to check whether transaction is challenge by FDS or not
          if ($type == 'credit_card'){
            if($fraud == 'challenge'){
              // TODO set payment status in merchant's database to 'Challenge by FDS'
              // TODO merchant should decide whether this transaction is authorized or not in MAP
              $message = "Transaction order_id: " . $order_id ." is challenged by FDS";
              } 
              else {
              // TODO set payment status in merchant's database to 'Success'
              DB::table('order')->where('invoice_no', $order_id)->update([
                  'order_status_id' => 2
              ]);
              $message = "Your transaction successfully captured using " . $type . ". Order_id: " . $order_id ;
              }
            }
          }
        else if ($transaction == 'settlement'){
          // TODO set payment status in merchant's database to 'Settlement'
          $message = "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
          } 
          else if($transaction == 'pending'){
          // TODO set payment status in merchant's database to 'Pending'
          $message = "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
          } 
          else if ($transaction == 'deny') {
          // TODO set payment status in merchant's database to 'Denied'
          $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        }

        return $message;
   
    }
}    