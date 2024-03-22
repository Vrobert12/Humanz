<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Regisztrálás</title>
    <link rel="stylesheet" href="SideStyle.css">
</head>
<body>
<form method="post" action="functions.php" class="mainForm">
    <label for="knev">Keresztnev:</label><br>
    <input type="text" class="inputok" placeholder="Keresztnév" name="knev" id="knev"><br>
    <label for="vnev">Vezeteknev:</label><br>
    <input type="text" class="inputok" placeholder="Vezetéknév" name="vnev" id="vnev"><br>

    <label for="tel2">Telefonszám:</label><br>
<select name="tel1" class="inputok">
    <?php
    for ($i=10; $i<=39; $i++){

        echo "<option value=\"0".$i."\">0".$i."</option>";

        if($i==23 || $i==28 ||$i==29 || $i==39){
            echo "<option value=\"0".$i."\"0>0".$i."0</option>";
        }

    }
    for ($i=60; $i<=69; $i++){

        echo "<option value=\"0".$i."\">0".$i."</option>";


    }
    ?>

</select>
    <input type="text"  placeholder="Telefonszám" name="tel2" class="inputok"  id="tel2"><br>
    <label for="mail">E-mail:</label><br>
    <input type="text" class="inputok" placeholder="Emailcím" name="mail" id="mail"><br>
    <label for="pass">Jelszó:</label><br>
    <input type="password" class="inputok" placeholder="********" name="pass"  id="pass"><br>
    <label for="pass2">Jelszó megerősítése:</label><br>
    <input type="password" class="inputok" placeholder="********" name="pass2"  id="pass2"><br>
    <input type="submit" class="inputok" name="action" value="regisztracio">
    <?php
    include "connection.php";
    global $conn;
    $message=isset($_SESSION['message']) ? $_SESSION['message']:'';

    echo"<p class='warning'>".$message."</p>" ?>
</form>
</body>
</html>