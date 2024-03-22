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

    <input type="submit" name="action" value="Bejelentkezes" class="inputok">
    <?php
    include "connection.php";
    global $conn;

    $message=isset($_SESSION['message']) ? $_SESSION['message']:'';
if(isset($_SESSION['message'])) {
    echo "<p class='warning'>" . $message . "</p>";


}?>

</form>
</body>
</html>