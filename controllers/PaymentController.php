<?php
require('../config/config.php');
require_once '../lib/vendor/autoload.php';
require ('../lib/php/ClassException.php');
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
    

    #Card
    $cardNumber = filter_input(INPUT_POST,'cardNumber');
    $securityCode = filter_input(INPUT_POST,'securityCode');
    $cardExpirationMonth = filter_input(INPUT_POST,'cardExpirationMonth');
    $cardExpirationYear = filter_input(INPUT_POST,'cardExpirationYear');
    $cardholderName = filter_input(INPUT_POST,'cardholderName');
    $installments = filter_input(INPUT_POST,'installments');
    $transactionAmount = filter_input(INPUT_POST,'transactionAmount');
    $description = filter_input(INPUT_POST,'description');
    $paymentMethodId = filter_input(INPUT_POST,'paymentMethodId');
    $token = filter_input(INPUT_POST,'token');
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
    $payment->token = $token;
    $payment->description = $description;
    $payment->installments = $installments;
    $payment->payment_method_id = $paymentMethodId;
    $payment->payer->first_name = $first_name;
    $payment->payer->last_name = $last_name;
    $payment->payer->address = array(
        "zip_code" => $zip,
        "street_name" => $street,
        "street_number" => $number
    );
    $paymentp->payer->phone = array(
        "area_code" => $area,
        "number" => $clear_number
    );
    $payment->shipments->receiver_address = array(
        "street_name" => $street,
        "street_number" => $number,
        "zip_code" => $zip,
        "city_name" => $city,
		"state_name" => $state
    );

    /* $payment->issuer_id = (int)$_POST['issuer']; */

    $payer = new MercadoPago\Payer();
    $payer->email = $email;
    $payer->identification = array( 
        "type" => $docType,
        "number" => $docNumber
    );
    $payer->payer->phone = array( 
        "area_code" => $area,
        "number" => $clear_number,
        "extension" => '+55'
    );
    $payer->first_name = $first_name;
    $payer->last_name = $last_name;    
    $payment->payer = $payer;
    $payment->save();
    $_SESSION['payment']=$payment;
    if ($payment->status_detail == 'accredited'){
        header('location: https://deatly.com/checkout/redir/card/');
    }else if($payment->status_detail == 'pending_contingency' || 'pending_review_manual'){
        header('location: https:///deatly.com/checkout/redir/pending/');
    }
    if($payment->status == 'rejected'){
        header('location: https:///deatly.com/checkout/redir/rejected/');
    }else if($payment->status_detail == ''){
        header('location: https:///deatly.com/checkout/redir/error/');
    } 
    echo '<pre>', var_dump($payment),'</pre>';
?>