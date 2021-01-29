<?php
    require ('../../lib/vendor/autoload.php');
    require ('../../lib/php/ClassException.php');
    require ('../../lib/php/connect.php');

    $exception = new \Classes\ClassException();
    session_start();
    $exception->setPayment($_SESSION['payment']);
    $pmt = $_SESSION['pmt_ss'];
        $pmt_ta = $pmt['transaction_amount'];
        $pmt_tk = $pmt['token'];
        $pmt_dc = $pmt['description'];
        $pmt_it = $pmt['installments'];
        $pmt_fln = $pmt['fullname'];
        $pmt_fn = $pmt['first_name'];
        $pmt_ln = $pmt['last_name'];
        $pmt_dn = $pmt['identification'];
        $pmt_em = $pmt['email'];
        $pmt_nh = $pmt['neighborhood'];
        $pmt_cnp = $pmt['complement'];
        $pmt_ac = $pmt['area_code'];
        $pmt_ph = $pmt['phone'];
        $pmt_zp = $pmt['zip_code'];
        $pmt_snm = $pmt['street_name'];
        $pmt_snb = $pmt['street_number'];
        $pmt_cn = $pmt['city_name'];
        $pmt_st = $pmt['state_name'];
        $pmt_dt = $pmt['date'];
        $pmt_pi = $pmt['product_id'];
        $pmt_v1 = $pmt['v1'];
        $pmt_v2 = $pmt['v2'];
        $pmt_v3 = $pmt['v3'];
        $pmt_v4 = $pmt['v4'];
        $pmt_v5 = $pmt['v5'];
        $pmt_units = $pmt['v1'] + $pmt['v2'] + $pmt['v3'] + $pmt['v4'] + $pmt['v5'];
    try{
        $order_pdo = new PDO('mysql:host='.HOST.';dbname='.DB,USER,PASS);
        $order_pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(Exception $e){
        echo 'Não foi possível realizar a conexão com o banco de dados';
    }
    $set_order = $order_pdo->prepare("INSERT INTO `orders` (`order`, `payment_id`, `token`, `product_id`, `v1`, `v2`, `v3`, `v4`, `v5`, `tq`, `method`, `installments`, `value`, `payment_status`, `name`, `email`, `phone`, `document`, `number`, `complement`, `neighborhood`, `city`, `state`, `zip`, `fullname`, `date`, `area`, `street`, `shipping_code`,`shipping_status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
    $set_order->execute(array(NULL,$_SESSION['payment']->id,$pmt_tk,$pmt_pi,$pmt_v1,$pmt_v2,$pmt_v3,$pmt_v4,$pmt_v5,'$tq',$_SESSION['payment']->payment_type_id,$pmt_it,$pmt_ta,$_SESSION['payment']->status_detail,$pmt_fn.' '.$pmt_ln,$pmt_em,$pmt_ph,$pmt_dn,$pmt_snb,$pmt_cnp,$pmt_nh,$pmt_cn,$pmt_st,$pmt_zp,$pmt_fln,$pmt_dt,$pmt_ac,$pmt_snm, ,'Indisponível','Aguardando Envio'));
   
   
   #Items
   function getResultado(){
                    $pmt_v1 = $_SESSION['pmt_ss']['v1'];
                    $pmt_v2 = $_SESSION['pmt_ss']['v2'];
                    $pmt_v3 = $_SESSION['pmt_ss']['v3'];
                    $pmt_v4 = $_SESSION['pmt_ss']['v4'];
                    $pmt_v5 = $_SESSION['pmt_ss']['v5'];
                    $pmt_v1n = $_SESSION['pmt_ss']['v1n'];
                    $pmt_v2n = $_SESSION['pmt_ss']['v2n'];
                    $pmt_v3n = $_SESSION['pmt_ss']['v3n'];
                    $pmt_v4n = $_SESSION['pmt_ss']['v4n'];
                    $pmt_v5n = $_SESSION['pmt_ss']['v5n'];
                    if ($pmt_v1n != '') {
                        $teste1 = $pmt_v1.'x '.ucfirst($pmt_v1n).' | ';
                    }else{
                        $teste1 = '';
                    }
                    if ($pmt_v2n != '') {
                        $teste2 = $pmt_v2.'x '.ucfirst($pmt_v2n).' | ';
                    }else{
                        $teste2 = '';
                    }
                    if ($pmt_v3n != '') {
                        $teste3 = $pmt_v3.'x '.ucfirst($pmt_v3n).' | ';
                    }else{
                        $teste3 = '';
                    }
                    if ($pmt_v4n != '') {
                        $teste4 = $pmt_v4.'x '.ucfirst($pmt_v4n).' | ';
                    }else{
                        $teste4 = '';
                    }
                    if ($pmt_v5n != '') {
                        $teste5 = $pmt_v5.'x '.ucfirst($pmt_v5n).' | ';
                    }else{
                        $teste5 = '';
                    }
                    $result = $teste1.$teste2.$teste3.$teste4.$teste5;
                    return $result;
                }    
   
    #Send Email;
    $email_file = file_get_contents('./email.html');


    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Load Composer's autoloader

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        /* $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output */
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'deatly.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->Username   = 'contato@deatly.com';                     // SMTP username
        $mail->Password   = 'WQpx,t8*Z7(e';                               // SMTP password
        $mail->SMTPSecure = 'ssl'; 
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => true,
                'verify_peer_name' => true,
                'allow_self_signed' => true
            )
        );         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('contato@deatly.com', 'Deatly - Pagamentos');
        $mail->addAddress($pmt_em, $pmt_fn);     // Add a recipient
    
        $email_file = str_replace('#user', $pmt_fn, $email_file);
        $email_file = str_replace('%snm%', $pmt_snm, $email_file);
        $email_file = str_replace('%snb%', $pmt_snb, $email_file);
        $email_file = str_replace('%nh%', $pmt_nh, $email_file);
        $email_file = str_replace('%cnp%', $pmt_cnp, $email_file);
        $email_file = str_replace('%cn%', $pmt_cn, $email_file);
        $email_file = str_replace('%st%', $pmt_st, $email_file);
        $email_file = str_replace('%zp%', $pmt_zp, $email_file);
        $email_file = str_replace('%dt%', $pmt_dt, $email_file);
        $email_file = str_replace('%id%', $_SESSION['payment']->id, $email_file);
        $email_file = str_replace('%dc%', $pmt_dc, $email_file);
        $email_file = str_replace('%v1%', getResultado(), $email_file);
        $email_file = str_replace('%v2%', $pmt_v2, $email_file);
        $email_file = str_replace('%v3%', $pmt_v3, $email_file);
        $email_file = str_replace('%v4%', $pmt_v4, $email_file);
        $email_file = str_replace('%v5%', $pmt_v5, $email_file);
        $email_file = str_replace('%ta%', $pmt_ta, $email_file);
        
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Compra aprovada!';
        $mail->Body    = $email_file;
        $mail->AltBody = 'Obrigado';

        $mail->send();
       /*  echo 'Message has been sent'; */
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-sclace=1.0">
    <title>Deatly Pagamentos - Registrado</title>
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
                <img src="images/white-logomarca.jpg" alt="">
            </div>
        </div>
        <div class="header-grid-text">
            <div class="header-content">
            <h4><?php print_r(ucfirst($_SESSION['pmt_ss']['first_name'])); ?>, seu pedido foi registrado.</h4>
                <p>O Mercado Pago solicitou um pequeno prazo para processar o seu pagamento.</p>
                <p><?php echo $exception->verifyTransaction()['message']; ?></p>
                <input type="button" value="Copiar dados da transação" class="copy-payment-infos">
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
<textarea style="display:none; visibility: 0;" class="payment-infos" id="" cols="30" rows="11">
Endereço de Entrega
    <?php echo $pmt_snm ?>, n. <?php echo $pmt_snb ?>

    <?php echo $pmt_nh ?>

    <?php echo $pmt_cn ?>-<?php echo $pmt_st ?>, <?php echo $pmt_zp ?>

    Brazil
Dados da transação
    Data <?php echo $pmt_dt ?>

    Transação n. <?php print_r($exception->getPayment()->id); ?>

    <?php echo $pmt_dc ?>

    <?php echo $pmt_v1 ?>x Preta, <?php echo $pmt_v2 ?>x Vinho, <?php echo $pmt_v3 ?>x Rosa, <?php echo $pmt_v4 ?>x Azul, <?php echo $pmt_v5 ?>x Floral
    R$ <?php echo $pmt_ta ?>: Aguardando análise.

    <?php echo ucfirst($pmt_fn) ?>, obrigado pela sua compra. Você receberá um email contendo as mesmas informações mencionadas acima.
</textarea>
<div class="getInfo" style="display: none;">
    <span id="valor"><?php echo $pmt_ta ?></span>
    <span id="product_id"><?php echo $pmt_pi ?></span>
    <span id="units"><?php echo $pmt_units ?></span>
    <span id="itens"><?php if ($pmt_v1n != '') {echo $pmt_v1.'x '.ucfirst($pmt_v1n).' | ';}else{echo '';} ?><?php if ($pmt_v2n != '') {echo $pmt_v2.'x '.ucfirst($pmt_v2n).' | ';}else{echo '';} ?><?php if ($pmt_v3n != '') {echo $pmt_v3.'x '.ucfirst($pmt_v3n).' | ';}else{echo '';} ?><?php if ($pmt_v4n != '') {echo $pmt_v4.'x '.ucfirst($pmt_v4n).' | ';}else{echo '';} ?><?php if ($pmt_v5n != '') {echo $pmt_v5.'x '.ucfirst($pmt_v5n).' | ';}else{echo '';} ?></span>
</div>
<div class="print">
        <div class="container">
            <?php
              /*  echo '<pre>',print_r($exception->getPayment()),'</pre>'; */
            ?>
        </div>
    </div>
</div>
<script src="deatly.js"></script>
<script>
    let purchase = document.querySelector('#valor').innerHTML;
    let content_id = document.querySelector('#product_id').innerHTML;
    let units = document.querySelector('#units').innerHTML;
    window.onload = () => fbq('track', 'Purchase', {content_type: 'product', content_ids: content_id, currency: "BRL", num_items: units, value: purchase});
</script>
</body>
</html>