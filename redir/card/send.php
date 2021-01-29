<?php
    require ('../../lib/vendor/autoload.php');
    require ('../../lib/php/ClassException.php');
    require ('../../lib/php/connect.php');
    
    $email_file = file_get_contents('./email.html');

   #Send Email;
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
        $mail->addAddress('%em', '%fn');     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Compra aprovada!';
        $mail->Body    = $email_file;
        $mail->AltBody = 'Obrigado Alt Body';

        $mail->send();
         echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

?>
