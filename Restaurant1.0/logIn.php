<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bejelentkezés</title>
    <style>
        body{
            background-color: cornflowerblue;
        }
        input{
            display: flex;
            border-radius: 10px;
            border-radius: 10px;
            margin: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<form method="post" action="functions.php">

    <input type="email" placeholder="Emailcím" name="mail">
    <input type="password" placeholder="jelszó" name="pass">

    <input type="submit" name="action" value="bejelentkezes">
    <?php
    $message=isset($_GET['message']) ? $_GET['message']:'';
if(isset($_GET['message'])) {
    echo "<p>" . $message . "</p>";

    echo "<input type=\"submit\" name=\"action\" value=\"kijelentkezes\">";
}?>

</form>
</body>
</html>