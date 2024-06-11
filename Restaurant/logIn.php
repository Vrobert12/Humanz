<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="SideStyle.css">

</head>
<body>
<form method="post" action="functions.php" class="mainForm">
<label for="mail">E-mail</label><br>
    <input type="email" placeholder="Emailcím" name="mail" class="inputok" id="mail"><br>
    <label for="pass">Jelszó</label><br>
    <input type="password" placeholder="********" name="pass" class="inputok" id="pass"><br>

    <input type="submit" name="action" value="Bejelentkezes" class="inputok"><br><br>
    <?php
    include "connection.php";
    $_SESSION['token'] = $verification_token = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
    $_SESSION['previousPage']="logIn.php";

    echo'  <a href="resetPassword-mail.php?logToken='. $_SESSION['token'].'">Forgot your password? </a><br><br>';
    ?>

    <label for="mail">Don't have a account?</label><br><br>
    <a href="registration.php">Register here! </a><br>
    <?php

    global $conn;

    $message=isset($_SESSION['message']) ? $_SESSION['message']:'';
if(isset($_SESSION['message'])) {
    if($_SESSION['message'] == "Most már be bír jelentkezni")
    { echo "<p class='success'>" . $message . "</p>";}
    else{echo "<p class='warning'>" . $message . "</p>";}




}?>

</form>
</body>
</html>