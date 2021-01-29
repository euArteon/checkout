<?php
    require ('../../lib/vendor/autoload.php');
    require ('../../lib/php/ClassException.php');
    require ('../../lib/php/connect.php');

    $exception = new \Classes\ClassException();
    session_start();
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
        $pmt_v1n = $pmt['v1n'];
        $pmt_v2n = $pmt['v2n'];
        $pmt_v3n = $pmt['v3n'];
        $pmt_v4n = $pmt['v4n'];
        $pmt_v5n = $pmt['v5n'];
        $pmt_units = $pmt['v1'] + $pmt['v2'] + $pmt['v3'] + $pmt['v4'] + $pmt['v5'];
 
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
    
    try{
        $order_pdo = new PDO('mysql:host='.HOST.';dbname='.DB,USER,PASS);
        $order_pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(Exception $e){
        echo 'Não foi possível realizar a conexão com o banco de dados';
    }
    $set_order = $order_pdo->prepare("INSERT INTO `orders` (`order`, `payment_id`, `token`, `product_id`, `v1`, `v2`, `v3`, `v4`, `v5`, `tq`, `method`, `installments`, `value`, `payment_status`, `name`, `email`, `phone`, `document`, `number`, `complement`, `neighborhood`, `city`, `state`, `zip`, `fullname`, `date`, `area`, `street`, `shipping_code`,`shipping_status`,`boleto_code`,`link_boleto`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
    $set_order->execute(array(NULL,$_SESSION['payment']->id,'$pmt_tk',$pmt_pi,$pmt_v1,$pmt_v2,$pmt_v3,$pmt_v4,$pmt_v5,'$tq',$_SESSION['payment']->payment_type_id,'1',$pmt_ta,$_SESSION['payment']->status_detail,$pmt_fn.' '.$pmt_ln,$pmt_em,$pmt_ph,$pmt_dn,$pmt_snb,$pmt_cnp,$pmt_nh,$pmt_cn,$pmt_st,$pmt_zp,$pmt_fln,$pmt_dt,$pmt_ac,$pmt_snm,'Indisponível','Aguardando Envio',$_SESSION['payment']->barcode->content,$_SESSION['payment']->transaction_details->external_resource_url));
   
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

        $email_file = str_replace('#user', ucfirst($pmt_fn), $email_file);
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
        $email_file = str_replace('%ta%', $pmt_ta, $email_file);
        $email_file = str_replace('%barcode%', $_SESSION['payment']->barcode->content, $email_file);
        $email_file = str_replace('%link%', $_SESSION['payment']->transaction_details->external_resource_url, $email_file);
        
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Compra aprovada!';
        $mail->Body    = $email_file;
        $mail->AltBody = 'Obrigado';

        $mail->send();
        /* echo 'Message has been sent'; */
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-sclace=1.0">
    <title>Deatly Pagamentos - Boleto</title>
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
                <img src="images/white-logomarca.jpg" alt="" srcset="">
            </div>
        </div>
        <div class="header-grid-text">
            <div class="header-content">
                <h4><?php print_r(ucfirst($_SESSION['pmt_ss']['first_name'])); ?>, seu pedido foi registrado.</h4>
                <span>Pedido n. </span><span id="order"></span><span> realizado em </span><span><?php
                                $cr_dt_fr = substr($_SESSION['payment']->date_created, 0, 10);
                                $cr_dt_ex = explode('-',$cr_dt_fr);
                                echo $cr_dt_ex[2].'/'.$cr_dt_ex[1].'/'.$cr_dt_ex[0];
                ?>.</span><span> Vencimento em </span><span><?php
                $exp_dt_fr = substr($_SESSION['payment']->date_of_expiration, 0, 10);
                $exp_dt_ex = explode('-',$exp_dt_fr);
                echo $exp_dt_ex[2].'/'.$exp_dt_ex[1].'/'.$exp_dt_ex[0];
                ?>.</span>
                <input type="button" value="Copiar Código de Barras" class="copybarcode">
                <input type="button" value="Abrir boleto" onclick="window.open(`<?php echo $_SESSION['payment']->transaction_details->external_resource_url ?>`, '_blank')">
            </div>
        </div>
    </div>
</div>
<div class="status">
    <div class="container">
        <h2>Estamos aguardando o pagamento para confirmação do seu pedido.</h2>
        <div class="status-group">
            <div class="status-grid" style="border-bottom: solid 10px #545358;">      
                <div class="status-content">
                    <div class="ready-circle"></div>
                    <div class="ready-status-icons">
                        <img src="images/icons/edit-regular.svg" alt="">
                        <p>Registrado</p>
                    </div>
                </div>
            </div>
            <div class="status-grid">
                <div class="status-content">
                    <div class="unready-circle"></div>
                </div>
            </div>
        </div>
        <div class="status-group">
            <div class="status-grid">      
                <div class="status-content">
                    <div class="unready-status-icons">
                        <img src="images/icons/barcode-solid.svg" alt="">
                        <p>Aprovado</p>
                    </div>
                </div>
            </div>
            <div class="status-grid">
                <div class="status-content">
                    <div class="unready-circle"></div>
                </div>
            </div>
        </div>
        <div class="status-group">
            <div class="status-grid">      
                <div class="status-content">
                    <div class="unready-status-icons">
                        <img src="images/icons/truck-moving-solid.svg" alt="" style="margin-bottom: 15px;">
                        <p>Transporte</p>
                     </div>
                </div>
            </div>
            <div class="status-grid">
                <div class="status-content">
                    <div class="unready-circle"></div>
                    <div class="last-status-icons">
                        <img src="images/icons/house-user-solid.svg" alt="">
                        <p>Entrega</p>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
<div class="informations">
    <div class="container">
        <div class="informations-grid">
            <div class="informations-content">
                <h2>ATENÇÃO</h2>
                <p>Leva-se de 1 a 3 dias úteis para validação do pagamento por boleto. Não se preocupe, você será informado em seu email.</p>
                <p>Para compras realizadas durante ofertas de queima de estoque, caso as unidades se esgotem, o envio do produto será realizado assim que novas unidades estiverem disponíveis, o que pode levar até 2 (duas) semanas.</p>
                <p>Não se preocupe, caso seu pedido tenha sido registrado durante a oferta de queima de estoque, o esgotamento das unidades não remove o seu desconto.</p>
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
<textarea style="display:none; visibility: 0;" class="barcode" id="" cols="30" rows="11"><?php print_r($_SESSION['payment']->barcode->content) ?></textarea>
<div class="getInfo" style="display: none;">
    <span id="valor"><?php echo $pmt_ta ?></span>
    <span id="product_id"><?php echo $pmt_pi ?></span>
    <span id="units"><?php echo $pmt_units ?></span>
    <span id="itens"><?php if ($pmt_v1n != '') {echo $pmt_v1.'x '.ucfirst($pmt_v1n).' | ';}else{echo '';} ?><?php if ($pmt_v2n != '') {echo $pmt_v2.'x '.ucfirst($pmt_v2n).' | ';}else{echo '';} ?><?php if ($pmt_v3n != '') {echo $pmt_v3.'x '.ucfirst($pmt_v3n).' | ';}else{echo '';} ?><?php if ($pmt_v4n != '') {echo $pmt_v4.'x '.ucfirst($pmt_v4n).' | ';}else{echo '';} ?><?php if ($pmt_v5n != '') {echo $pmt_v5.'x '.ucfirst($pmt_v5n).' | ';}else{echo '';} ?></span>
</div>
<div class="print">
        <div class="container">
            <?php
               /* echo '<pre>',print_r($_SESSION['payment']),'</pre>'; */
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