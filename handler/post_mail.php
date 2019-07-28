<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once 'libs/PHPMailer/src/Exception.php';
include_once 'libs/PHPMailer/src/PHPMailer.php';
include_once 'libs/PHPMailer/src/SMTP.php';


$data = json_decode(file_get_contents("php://input"));

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$mail = new PHPMailer(true);


  try {
        //Server settings
        $mail->SMTPDebug = 0;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'hemoges2017@gmail.com';                     // SMTP username
        $mail->Password   = 'N7tAT10n';                               // SMTP password
        $mail->SMTPSecure = 'auto';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to
    
        //Recipients
        $mail->setFrom('hemoges2017@gmail.com', 'Administrateur');
        $mail->addAddress("".$data->des."");     // Add a recipient
       // $mail->addAddress('ellen@example.com');               // Name is optional
       // $mail->addReplyTo('info@example.com', 'Information');
       // $mail->addCC('cc@example.com');
    //    $mail->addBCC('bcc@example.com');
    
        // Attachments
      //  $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
       // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Abonnement Kalimbe';
        $mail->Body    = "<h1> Bienvenu sur Kalimbe</h1> <b> ".$data->msg." </b>";
       // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    } 

 









?>