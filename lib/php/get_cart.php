<?php
    
    header('Content-type: application/json');

    require('./connect.php');
    try{
        $pdo = new PDO('mysql:host='.HOST.';dbname='.DB,USER,PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch(Exception $e){
        echo 'Não foi possível realizar a conexão com o banco de dados';
    }
    $getProducts = $pdo->prepare("SELECT * FROM `products`");
    $getProducts->execute();
    $showProducts = $getProducts->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($showProducts);


    