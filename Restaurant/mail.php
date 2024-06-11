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

    //Server settings
    $_SESSION['message']="";
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'mail.humanz.stud.vts.su.ac.rs';
    $mail->SMTPAuth = true;
    $mail->Username = 'humanz';
    $mail->Password = 'HCT07uCCFhP01lr';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('humanz@humanz.stud.vts.su.ac.rs', 'Mailer');

if(isset($_SESSION['email'])&& !empty($_SESSION['email']) && isset($_SESSION['verification_code']) && !isset($_SESSION["workerEmail"])) {

    $mail->addAddress($_SESSION['email'], 'Varró Róbert');
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');
    $mail->Subject = "R&D";
    $mail->Body = "<h2>Validate</h2> Your code:<br><h3>" . $_SESSION['verification_code'] . "</h3>";
    $mail->AltBody = "Your code:<br><h3>" . $_SESSION['verification_code'] . "</h3>";
    $_SESSION['message']="<b>Check your mail for account verification</b>";
    header('Location:email-verification.php');
}


    if(isset($_SESSION['mailReset']) && isset($_SESSION['resetCode'])){
        $mail->addAddress($_SESSION['mailReset'], 'Varró Róbert');
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');
        $mail->Subject = "R&D";
$_SESSION['email']=$_SESSION['mailReset'];
        $_SESSION['message']="<b>Check your mail for password verification</b>";
        $mail->Body = "<h2>Reset password</h2> Your code:<br><h3>".$_SESSION['resetCode']."</h3>";
        $mail->AltBody = "Your code:<br><h3>".$_SESSION['resetCode']."</h3>";
        header('Location:email-verification.php');
    }
    if( isset($_SESSION["workerEmail"])){

        $mail->addAddress($_SESSION["workerEmail"], 'Varró Róbert');
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');
        $mail->Subject = "R&D";

        $_SESSION['message']="<b>Worker is added</b>";
        $mail->Body = "<h2>You are hired :)</h2> Set up your profile <a href=".$_SESSION['workerLink'].">here</a>";
        $mail->AltBody = "<h2>You are hired :)</h2> Set up your profile <a href=".$_SESSION['workerLink'].">here</a>";
        header('Location:workers.php');
    }

    $mail->send();
    if(isset($_POST['mail']))
    $_POST['mail']=$_SESSION['email'];
    exit();

} catch (Exception $e) {

    $_SESSION['message'] =  "Message could not be sent. Mailer Error: ".$e->getMessage();
}