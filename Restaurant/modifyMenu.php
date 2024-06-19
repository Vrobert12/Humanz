<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modify Menu</title>
    <link rel="stylesheet" href="SideStyle.css">
</head>
<script>
    function activateProfilePicture() {
        // Trigger click event on the file input element
        document.getElementById('pictureInput').click();
    }



</script>
<body>
<?php
session_start();

if( $_SESSION['privalage'] != "admin" && $_SESSION['privalage'] != "worker"){
    header('Location:tables.php');
    exit();
}
?>
<form method="post" action="functions.php" class="mainForm" enctype="multipart/form-data">
    <a class="nextPage" href="index.php">Back</a><br><br>
    <input type="hidden" class="inputok" name="menuId" id="sm" value="<?php

    if(isset($_GET['menu'])){echo $_GET['menu'];
        $_SESSION['menuId']=$_GET['menu'];
    }
    else {
        header('Location: modifyMenu.php?table='.$_SESSION['menuId']);
        exit();
    }
    ?>">
    <h2>Modify Menu</h2>
    <input type='file' name='picture' id='pictureInput' hidden="hidden">
    <a style="color: #b3cdb3; font-size: 22px; background-color: #1a6556; border: solid 3px cyan;
     margin: 50px; border-radius:10px; padding: 10px "
       onclick='activateProfilePicture()'>Set Foods Picture</a><br><br>
    <label for="dishName">Dish Name:</label><br>
    <input type="text" class="inputok" placeholder="Name" name="dishName" id="dishName"><br>
    <label for="dishType">Dish Type:</label><br>
    <select type="text" class="inputok"  name="dishType" id="dishType" >

        <option hidden="hidden" value="Type">Type</option>
        <option value='Ordinary'>Ordinary</option>
        <option value='Gluten free'>Gluten Free</option>
        <option value='Vegetarian'>Vegetarian</option>

    </select><br>
    <label for="dishPrice">Dish Price:</label><br>
    <input type="text" class="inputok" placeholder="price" name="dishPrice" id="dishPrice"><br>

    <input type="submit" class="inputok" name="action" value="ModifyDish">
    <?php



    if(isset($_SESSION['message']))
        echo "<p class='warning'>" . $_SESSION['message'] . "</p>";
    $_SESSION['message']=" ";
    ?>
</form>
</body>
</html>
