<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add coupon</title>
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
$_SESSION['backPic']="addCoupon.php";
?>
<form method="post" action="functions.php" class="mainForm" enctype="multipart/form-data">
    <a class="nextPage" href="coupon.php">Back</a><br><br>
    <h2>Add Coupon</h2>

    <label for="discount">Coupon discount:</label><br>
    <select type="text" class="inputok"  name="discount" id="discount" >

        <option hidden="hidden" value="Discount">Discount</option>
        <option value='5'>5</option>
        <option value='10'>10</option>
        <option value='15'>15</option>
        <option value='20'>20</option>
        <option value='25'>25</option>
        <option value='30'>30</option>
        <option value='35'>35</option>
        <option value='40'>40</option>
        <option value='50'>50</option>
        <option value='60'>60</option>

    </select><br>

    <input type="submit" class="inputok" name="action" value="AddCoupon">
    <?php



    if(isset($_SESSION['message']))
        echo "<p class='warning'>" . $_SESSION['message'] . "</p>";
    $_SESSION['message']="";
    ?>
</form>
</body>
</html>
