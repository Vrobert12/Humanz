<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add table</title>
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

if (isset($_SESSION['token']) && isset($_GET['token'])) {
    if ($_SESSION['token'] != $_GET['token']) {
        header('location:' . $_SESSION['previousPage']);
        $_SESSION['title'] = "";
        exit();
    } else {
        $_SESSION['token'] = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
    }
}

?>
<form method="post" action="functions.php" class="mainForm" enctype="multipart/form-data">
    <a class="nextPage" href="tables.php">Back</a><br><br>
    <h2>Add Table</h2>
    <input type='file' name='picture' id='pictureInput' hidden="hidden">
    <a style="color: #b3cdb3; font-size: 22px; background-color: #1a6556; border: solid 3px cyan;
     margin: 50px; border-radius:10px; padding: 10px "
       onclick='activateProfilePicture()'>Set Table Picture</a><br><br>
    <label for="book">Table capacity:</label>
    <select type="text" class="inputok"  name="cap" id="cap" >
        <option hidden="hidden" value="Select">None</option>
        <?php
        for($i=2;$i<=10;$i++){
            echo "<option value='$i'>$i</option>";

        }
        ?>

    </select><br>
    <label for="ar">Area:</label><br>
    <input type="text" class="inputok" placeholder="Area" name="ar" id="ar"><br>
    <label for="ar">Is smoking area: </label>
    <input type="checkbox" class="inputok" name="sm" id="sm"><br>
    <input type="submit" class="inputok" name="action" value="AddTable">
    <?php



    if(isset($_SESSION['message']))
        echo "<p class='warning'>" . $_SESSION['message'] . "</p>";
    $_SESSION['message']=" ";
    ?>
</form>
</body>
</html>
