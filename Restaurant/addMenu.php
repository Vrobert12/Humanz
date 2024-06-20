<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add menu</title>
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

if( $_SESSION['privalage'] != "admin"){
    header('Location: index.php');
    exit();
}

if (isset($_SESSION['token']) && isset($_GET['token'])) {
    if ($_SESSION['token'] != $_GET['token']) {
        header('location:' . $_SESSION['previousPage']);
        $_SESSION['title'] = "";
        exit();
    } else {
        $_SESSION['token'] = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
    }
}
$_SESSION['backPic']="addMenu.php";
?>
<form method="post" action="functions.php" class="mainForm" enctype="multipart/form-data">
    <a class="nextPage" href="menu.php">Back</a><br><br>
    <h2>Add Menu</h2>
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

    <input type="submit" class="inputok" name="action" value="AddMenu">
    <?php



    if(isset($_SESSION['message']))
        echo "<p class='warning'>" . $_SESSION['message'] . "</p>";
    $_SESSION['message']="";
    ?>
</form>
</body>
</html>
