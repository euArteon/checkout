<?php
require('../config/config.php');
require_once '../lib/vendor/autoload.php';
session_start();

    MercadoPago\SDK::setAccessToken(PROD_TOKEN);
    $payment = new MercadoPago\Payment();
    $payment->transaction_amount = $_SESSION['pmt_ss']['transaction_amount'];
    $payment->description = $_SESSION['pmt_ss']['description'];
    $payment->payment_method_id = "bolbradesco";
    $payment->payer = array(
        "email" => $_SESSION['pmt_ss']['email'],
        "first_name" => $_SESSION['pmt_ss']['first_name'],
        "last_name" => $_SESSION['pmt_ss']['last_name'],
        "identification" => array(
            "type" => "CPF",
            "number" => $_SESSION['pmt_ss']['identification']
        ),
        "address"=>  array(
            "zip_code" => $_SESSION['pmt_ss']['zip_code'],
            "street_name" => $_SESSION['pmt_ss']['street_name'],
            "street_number" => $_SESSION['pmt_ss']['street_number'],
            "neighborhood" => $_SESSION['pmt_ss']['neighborhood'],
            "city" => $_SESSION['pmt_ss']['city_name'],
            "federal_unit" => $_SESSION['pmt_ss']['state_name']
        )
    );

 $payment->save();
    $_SESSION['payment']=$payment;
    if ($payment->status_detail == 'pending_waiting_payment'){
        header('location: https://deatly.com/checkout/redir/boleto/');
    }else if($payment->status_detail == ''){
        header('location: https://deatly.com/checkout/redir/error/');
    } 
/*     echo '<pre>', var_dump($payment),'</pre>'; */
?>


