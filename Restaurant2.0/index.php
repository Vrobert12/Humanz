<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MainPage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="main.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    <script>
        function activateProfilePicture() {
            // Trigger click event on the file input element
            document.getElementById('pictureInput').click();
        }


        function activateSubmit() {
            // Activate the submit button when a file is selected
            document.getElementById('submitButton').click();
        }

        function logoutAndRedirect() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'functions.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Redirect to MainPage.php after successful logout
                    window.location.href = 'index.php';
                } else {
                    // Handle logout error
                    console.error('Logout failed with status ' + xhr.status);
                }
            };
            xhr.send();
        }
    </script>
</head>
<?php
include 'connection.php';
global $conn;
$cookie = 1;

if (isset($_COOKIE['count'])) {
    if ($_COOKIE['count'] < 2) {
        $cookie = ++$_COOKIE['count'];
        setcookie("count", $cookie);
    }
} else {
    setcookie("count", $cookie, time() + 5 * 60);
}
?>
<body>
<nav class="navbar navbar-expand-lg bg-black navbar-nav ml-auto">
    <div class="container-fluid ">

        <a href="#" class="bar d-none d-lg-block"><h2>R&D</h2><?php /*if (isset($_COOKIE['count']))
             echo $_COOKIE['count'] */ ?></a>
        <a href="#" class="bar d-block d-lg-none"><h4>R&D</h4><?php /*if (isset($_COOKIE['count']))
             echo $_COOKIE['count'] */ ?></a>

        <?php

        if ($conn) {

            if (isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['profilePic'])) {
                $sql = "SELECT * FROM user";
                $stmt = $conn->query($sql);

                $_SESSION['message'] = "";
                if ($stmt->num_rows > 0)
                    while ($row = $stmt->fetch_assoc())
                        if ($_SESSION['email'] == $row['userMail'] && $row['privilage'] == "Admin") {
                            echo "<li><a class=\"d-block d-lg-none dropdown-item\" href=\"reservation.php\"><i class=\"fa-2x bi bi-list-task\"></i></a></li>";
                            echo "<li><a class=\"d-block d-lg-none dropdown-item\" href=\"users.php\"><i class=\"fa-2x bi bi-people\"></i></a></li>";
                            echo "<li><a class=\"d-block d-lg-none dropdown-item\" href=\"workers.php\"><i class=\"fa-2x bi bi-person-workspace\"></i></a></li>";

                            echo "<li><a class=\"d-none d-lg-block dropdown-item\" href=\"reservation.php\"><i class=\"fa-2x bi bi-list-task\"></i> Tables</a></li>";
                            echo "<li><a class=\"d-none d-lg-block dropdown-item\" href=\"users.php\"><i class=\"fa-2x bi bi-people\"></i> Users</a></li>";
                            echo "<li><a class=\"d-none d-lg-block dropdown-item\" href=\"workers.php\"><i class=\"fa-2x bi bi-person-workspace\"></i> Workers</a></li>";
                        }

            } else {

                echo '<div class=" justify-content-end" id="collapsibleNavbar">
          <ul class="navbar-nav ">
                <li class=" ">
                   <a href="logIn.php" class="d-block d-lg-none"><i class="fa-2x bi bi-person"></i></a>
          <a href="logIn.php" class="d-none d-lg-block"><i class="fa-2x bi bi-person"></i> Log in</a>
      </li>';


            }
        } else {
            echo "<a href='login.php'  class='nav-link dropdown-item'><i class=\"bi bi-person\"></i>Connection Error!</a>";
        }
        ?> <button style="border: none;" class=" fa-1x navbar-toggler ml-auto hidden-sm-up float-xs-right float: right" type="button"
                   data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar" >
          <?php
            if(isset($_SESSION['profilePic']))
            echo'  <img class="rounded-circle " width="40" height="40" alt="profilkep" src="http://localhost:/Restaurant2.0/pictures/'. $_SESSION['profilePic'];
            ?>">

        </button>
        <div class=" collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
            <ul class="navbar-nav ">
                <li class="nav-item dropdown ">


                        <?php
                        global $conn;
                        if ($conn) {
                            if (isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['profilePic'])) {
                                $eMail = $_SESSION['email'];
                                $name = $_SESSION['name'];

                                $profilePic = $_SESSION['profilePic'];
                                $eMail = $_SESSION['email'];
                                $name = $_SESSION['name'];
                                $profilePic = $_SESSION['profilePic'];
                                $sql = "SELECT * FROM user";
                                $stmt = $conn->query($sql);

                                $_SESSION['message'] = "";echo'<div class=" collapse navbar-collapse justify-content-end" id="collapsibleNavbar">';
                                if ($stmt->num_rows > 0)

                                while ($row = $stmt->fetch_assoc())
                                    if ($_SESSION['email'] == $row['userMail']) {


                                        echo "<li><a class='bar d-none d-lg-block'> <i class=\"fa-2x bi bi-person\"></i> $name</a></li>";

                                    }

                                echo "<li><a class=\" d-block d-lg-none \"  onclick=' activateProfilePicture()'>
                                <i class=\"fa-2x bi bi-person\"></i> Set Profile Picture";


                                echo "</a><form method='post' action='functions.php' enctype='multipart/form-data'>";
                                $_SESSION['backPic'] = "index.php";
                                echo "<input class=\" dropdown-item\"  type='file' name='picture' id='pictureInput' value='pictureUpload' style='display: none;' onchange=\"activateSubmit()\">";
                                //láthatatlan, viszont kell a profilkép feltöltéshez
                                //Miután a képet feltöltöttük, az aktivája a fügvényt ami automatikusan megnyomja a sumbit gombot
                                echo "<input type='submit' name='action' id='submitButton' value='picture' style='display: none;'>";
                                //láthatatlan, a kép feltöltésének a végrehajtására szükség
                                echo "</form></li>";
                                echo "<li><a class=\"  d-block d-lg-none\" href=\"modify.php\">"; // a headeren keresztül megadjuk a kijeletkezés értékét
                                echo "<i class='fa-2x  bi bi-person-fill-gear'></i></i> Modify User</a></li>";
                                $_SESSION['action'] = "kijelentkezes";
                                echo "<li><a class=\"  d-block d-lg-none \" href=\"functions.php\">"; // a headeren keresztül megadjuk a kijeletkezés értékét
                                echo "<i class=\"bi bi-door-open fa-2x justify-content-end\"></i> Log out</a></li>";


                                echo "<li><a class=\" d-none d-lg-block \"  onclick=' activateProfilePicture()'>
<img  class=\"profilePic\" src=\"http://localhost:/Restaurant2.0/pictures/{$profilePic}\" width=\"45\" height=\"45\" alt=\"profilkep\">";


                                echo "</a><form method='post' action='functions.php' enctype='multipart/form-data'>";
                                $_SESSION['backPic'] = "index.php";
                                echo "<input class=\" dropdown-item\"  type='file' name='picture' id='pictureInput' value='pictureUpload' style='display: none;' onchange=\"activateSubmit()\">";
                                //láthatatlan, viszont kell a profilkép feltöltéshez
                                //Miután a képet feltöltöttük, az aktivája a fügvényt ami automatikusan megnyomja a sumbit gombot
                                echo "<input type='submit' name='action' id='submitButton' value='picture' style='display: none;'>";
                                //láthatatlan, a kép feltöltésének a végrehajtására szükség
                                echo "</form></li>";
                                echo "<li><a  class=\" d-none d-lg-block \" href=\"modify.php\">"; // a headeren keresztül megadjuk a kijeletkezés értékét
                                echo "<i class='fa-2x  bi bi-person-fill-gear'></i></i> </a></li>";
                                $_SESSION['action'] = "kijelentkezes";
                                echo "<li><a  class=\" d-none d-lg-block \" href=\"functions.php\">"; // a headeren keresztül megadjuk a kijeletkezés értékét
                                echo "<i class=\"bi bi-door-open fa-2x\"></i></a></li>";

                                echo "</div>";


                                // Display user's name and logout link
                            }
                        } else {
                            echo "<a href='' class='nav-link dropdown-item'><i class=\"bi bi-person\"></i>Connection Error!</a>";
                        }
                        ?>

</nav> </div> </li> </ul> </div> </div> </nav>
<?php
if (isset($_SESSION['message']) && $_SESSION['message'] != "")
    echo "<div class='mainBlock rounded bg-dark text-white'>
<h1 style=' text-align: center; top:100px; margin: auto; left: 0; right: 0'>
" . $_SESSION['message'] . "</h1></div>";
$_SESSION['message'] = "";
?>
</body>
</html>
