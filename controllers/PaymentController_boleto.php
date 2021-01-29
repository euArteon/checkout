<?php
require('../config/config.php');
require_once '../lib/vendor/autoload.php';
session_start();

    MercadoPago\SDK::setAccessToken(PROD_TOKEN);
    #Costumer
    $email = filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
    $docType = filter_input(INPUT_POST,'docType');
    $docNumber = filter_input(INPUT_POST,'docNumber');
    $phone = filter_input(INPUT_POST,'phone');
    $name = filter_input(INPUT_POST,'name');
        $explode_name = explode(' ',$name);
        $first_name = $explode_name[0];
        $last_name = end($explode_name);
    $zip = filter_input(INPUT_POST,'zip');
    $number = filter_input(INPUT_POST,'number');
    $area = filter_input(INPUT_POST,'area');
    $clear_number = filter_input(INPUT_POST,'clear_number');
    $complement = filter_input(INPUT_POST,'complement');
    $street = filter_input(INPUT_POST,'street');
    $neighborhood = filter_input(INPUT_POST,'neighborhood');
    $city = filter_input(INPUT_POST,'city');
    $state = filter_input(INPUT_POST,'state');
    $transactionAmount = filter_input(INPUT_POST,'transactionAmount');
    $description = filter_input(INPUT_POST,'description');
    $installments = filter_input(INPUT_POST,'installments');
    $pdt_id = filter_input(INPUT_POST,'pdt_id');
    $v1 = filter_input(INPUT_POST,'v1v');
    $v2 = filter_input(INPUT_POST,'v2v');
    $v3 = filter_input(INPUT_POST,'v3v');
    $v4 = filter_input(INPUT_POST,'v4v');
    $v5 = filter_input(INPUT_POST,'v5v');
    $v1n = filter_input(INPUT_POST,'v1n');
    $v2n = filter_input(INPUT_POST,'v2n');
    $v3n = filter_input(INPUT_POST,'v3n');
    $v4n = filter_input(INPUT_POST,'v4n');
    $v5n = filter_input(INPUT_POST,'v5n');

    #Session
    date_default_timezone_set('UTC');
    $pmt_ss = array(
        'transaction_amount' => $transactionAmount,
        'token' => $token,
        'product_id' => $pdt_id,
        'v1' => $v1,
        'v2' => $v2,
        'v3' => $v3,
        'v4' => $v4,
        'v5' => $v5,
        'v1n' => $v1n,
        'v2n' => $v2n,
        'v3n' => $v3n,
        'v4n' => $v4n,
        'v5n' => $v5n,
        'description' => $description,
        'installments' => $installments,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'identification' => $docNumber,
        'email' => $email,
        'neighborhood' => $neighborhood,
        'complement' => $complement,
        'area_code' => $area,
        'phone' => $clear_number,
        'zip_code' => $zip,
        'street_name' => $street,
        'street_number' => $number,
        'city_name' => $city,
        'state_name' => $state,
        'fullname' => $name,
        'date' => date('d/m/Y H:i:s e')
    );
    $_SESSION['pmt_ss'] = $pmt_ss;


    $payment = new MercadoPago\Payment();
    $payment->transaction_amount = $transactionAmount;
    $payment->description = $description;
    $payment->payment_method_id = "bolbradesco";
    $payment->payer = array(
        "email" => $email,
        "first_name" => $pmt_ss['first_name'],
        "last_name" => $pmt_ss['last_name'],
        "identification" => array(
            "type" => "CPF",
            "number" => $pmt_ss['identification']
        ),
        "address"=>  array(
            "zip_code" => $pmt_ss['zip_code'],
            "street_name" => $pmt_ss['street_name'],
            "street_number" => $pmt_ss['street_number'],
            "neighborhood" => $pmt_ss['neighborhood'],
            "city" => $pmt_ss['city_name'],
            "federal_unit" => $pmt_ss['state_name']
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


