<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Regisztrálás</title>
    <style>
        body{
            background-color: cornflowerblue;
        }
        .inputs{
            display: flex;
            border-radius: 10px;
            padding: 5px;
            margin: 10px;
            text-align: center;
        }
        .tel{
            border-radius: 10px;

            padding: 5px;
            margin: 10px;
            margin-bottom: 0;
            text-align: center;}
    </style>
</head>
<body>
<form method="post" action="functions.php">
    <input type="text" class="inputs" placeholder="Keresztnév" name="knev">
    <input type="text" class="inputs" placeholder="Vezetéknév" name="vnev">

<select name="tel1" class="tel">
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
    <input type="text"  placeholder="Telefonszám" name="tel2" class="tel">

    <input type="text" class="inputs" placeholder="Emailcím" name="mail">
    <input type="password" class="inputs" placeholder="Jelszó" name="pass">
    <input type="password" class="inputs" placeholder="Jelszóbiztosítása" name="pass2">
    <input type="submit" class="inputs" name="action" value="regisztracio">
    <?php
    $message=isset($_GET['message']) ? $_GET['message']:'';

    echo"<p>".$message."</p>" ?>
</form>
</body>
</html>