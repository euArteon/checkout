<?php
    require ('../../lib/vendor/autoload.php');
    require ('../../lib/php/ClassException.php');
    require ('../../lib/php/connect.php');

    $exception = new \Classes\ClassException();
    session_start();
    $exception->setPayment($_SESSION['payment']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-sclace=1.0">
    <title>Deatly Pagamentos - Erro</title>
    <link rel="stylesheet" href="style.css">
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-T6BVNJX');</script>
    <!-- End Google Tag Manager -->
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T6BVNJX"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->   
<div class="header">
    <div class="container">
        <div class="header-grid-img">
            <div class="header-content">
                <img src="images/icons/exclamation.svg" alt="">
            </div>
        </div>
        <div class="header-grid-text">
            <div class="header-content">
                <h4>Ops, algo deu errado:</h4>
                <p><?php echo $exception->getErrors(); ?></p>
                <input type="button" value="Tentar novamente" onclick="window.open(`https://deatly.com/checkout/?id=<?php echo $_SESSION['pmt_ss']['product_id']?>&v1=<?php echo $_SESSION['pmt_ss']['v1']?>&v2=<?php echo $_SESSION['pmt_ss']['v2']?>&v3=<?php echo $_SESSION['pmt_ss']['v3']?>&v4=<?php echo $_SESSION['pmt_ss']['v4']?>&v5=<?php echo $_SESSION['pmt_ss']['v5']?>`)">
                <input type="button" value="Pagar por boleto" onclick="window.open(`https://deatly.com/checkout/controllers/PaymentController_conv.php`)">
                <input type="button" value="Falar com um atendente" onclick="window.open(`https://api.whatsapp.com/send?phone=556581758763&text=Ol%C3%A1,%20estou%20tendo%20problemas%20para%20fazer%20o%20meu%20pagamento,%20pode%20me%20ajudar?
`)">
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-content">
                <p>Deatly</p>
                <p>Todos os direitos reservados</p>
            </div>
        </div>
    </div>
</div>
<div class="print">
        <div class="container">
            <?php
   /*              echo '<pre>',print_r($exception->getPayment()),'</pre>'; */
            ?>
        </div>
    </div>
</div>
<script src="deatly.js"></script>
</body>
</html>