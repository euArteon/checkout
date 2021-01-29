<?php
    
    header('Content-type: application/json');

    require ('../../lib/vendor/autoload.php');
    require('./connect.php');
    session_start();
    try{
        $pdo = new PDO('mysql:host='.HOST.';dbname='.DB,USER,PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch(Exception $e){
        echo 'Não foi possível realizar a conexão com o banco de dados';
    }
    $order_number = $_SESSION['payment']->id; 
    $getProducts = $pdo->prepare("SELECT * FROM `orders` WHERE `payment_id` = $order_number");
    $getProducts->execute();
    $showProducts = $getProducts->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($showProducts);



    