<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
session_start();
$mail = new PHPMailer(true);

try {
    header('Location:email-verification.php');
    //Server settings
    if(isset($_SESSION['mail'])){
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'mail.humanz.stud.vts.su.ac.rs';
    $mail->SMTPAuth = true;
    $mail->Username = 'humanz';
    $mail->Password = 'HCT07uCCFhP01lr';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;}
else{
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'f96cd0b03680d3';
        $mail->Password = 'e5afda4b929822';

    }
    $mail->setFrom('humanz@humanz.stud.vts.su.ac.rs', 'Mailer');
    $mail->addAddress($_SESSION['mail'], 'Varró Róbert');
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');
    $mail->Subject = "Restaurant Verification";
    $mail->Body = "Your code:<br><h3>".$_SESSION['verification_code']."</h3>";
    $mail->AltBody = "Your code:<br><h3>".$_SESSION['verification_code']."</h3>";
    $mail->send();
    if(isset($_POST['mail']))
    $_POST['mail']=$_SESSION['mail'];
    exit();

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}