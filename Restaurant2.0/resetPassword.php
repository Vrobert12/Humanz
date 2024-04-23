<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="SideStyle.css">

</head>
<body>
<form method="post" action="functions.php" class="mainForm">
    <label for="mail">E-mail</label><br>
    <input type="email" placeholder="Emailcím" name="mail" class="inputok" id="mail"><br>
    <label for="password">Your new password:</label><br>
    <input type="password" class="inputok" placeholder="********" name="resetPassword"  id="pass"><br>
    <label for="confirmPassword">Confirm your new password:</label><br>
    <input type="password" class="inputok" placeholder="********" name="confirmPassword"  id="pass2"><br>

    <input type="submit" name="action" value="ResetPass" class="inputok"><br><br>

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