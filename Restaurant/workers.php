<html>
<head>
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
        function activateSearch() {
            // Activate the submit button when a file is selected
            document.getElementById('searchAction').click();
        }
        function deleteSearch() {
            // Activate the submit button when a file is selected
            document.getElementById('searchDelete').click();
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
<body>
<nav class="navbar navbar-expand-lg bg-black navbar-nav ml-auto">
    <div class="container-fluid ">

        <a href="#" class="bar d-none d-lg-block"><h2>R&D</h2><?php /*if (isset($_COOKIE['count']))
             echo $_COOKIE['count'] */ ?></a>
        <a href="#" class="bar d-block d-lg-none"><h4>R&D</h4><?php /*if (isset($_COOKIE['count']))
             echo $_COOKIE['count'] */ ?></a>

     <?php
include 'connection.php';
global $conn;
        if ($conn) {

            if (isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['profilePic'])) {
                $sql = "SELECT * FROM user";
                $stmt = $conn->query($sql);


                if ($stmt->num_rows > 0)
                    while ($row = $stmt->fetch_assoc())
                        if ($_SESSION['email'] == $row['userMail'] && $row['privilage'] == "Admin") {
            echo "<li><a class=\"d-block d-lg-none\" href=\"index.php\"><i class=\"fa-2x bi bi-arrow-return-left\"></i></a></li>";;
            echo "<li><a class=\"d-none d-lg-block\" href=\"index.php\"><i class=\"fa-2x bi bi-arrow-return-left\"></i> Back to Main</a></li>";;

            echo '<li><form method="post" action="workers.php"></li>
            <input type="text" style="width: 200px; height: 30px; " placeholder="search" name="searchMail">
              
            <li> <a class="justify-content-end" onclick="activateSearch()"><i class="fa-2x bi bi-search"></i></a></li>
         <li><a class="justify-content-end" onclick="deleteSearch()"><i class="fa-2x bi bi-x-lg"></i></a></li>
            <input type="submit" value="search" id="searchAction" name="searchAction" style="display: none">
            <input type="submit" value="delete" id="searchDelete" name="searchDelete" style="display: none">
            
        </form>
           <a href="#" class="bar d-block d-lg-none"><h2><i class=" fa-3x bi bi-pc-display-horizontal"></i>  </h2></a>
            <a href="#" class="bar d-none d-lg-block"> <h2>  Workers</h2></a>';
            $_SESSION['token'] =  substr(number_format(time() * rand(), 0, '', ''), 0, 6);
$_SESSION['previousPage']="workers.php";
            echo "<li><a class=\"justify-content-end\" href=\"registration.php?token=" . $_SESSION['token']. "\" style='font-size: 40px'><i class=\"bi bi-plus\"></i></a></li>";
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
                echo'  <img class="rounded-circle " width="90" height="90" alt="profilkep" src="http://localhost:/Restaurant/pictures/'. $_SESSION['profilePic'];
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

                           echo'<div class=" collapse navbar-collapse justify-content-end" id="collapsibleNavbar">';
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
<img  class=\"profilePic\" src=\"http://localhost:/Restaurant/pictures/{$profilePic}\" width=\"45\" height=\"45\" alt=\"profilkep\">";


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


                    <ul class="dropdown-menu dropdown-menu-end justify-content-end" aria-labelledby="dropdownMenuLink">
                        <li><a class="ml-auto hidden-sm-up" href="reservation.php"><i class="bi bi-list-task"></i> </a></li>
                        <li><a class="ml-auto hidden-sm-up" href="users.php"><i class="bi bi-people"></i></a></li>
                        <li><a class="ml-auto hidden-sm-up" href="workers.php"><i class="bi bi-person-workspace"></i> </a></li>


                    </ul> </nav> </div> </li> </ul> </div> </div> </nav>
<?php
if(isset($_SESSION['message']) && $_SESSION['message'] != "")
echo "<div class='mainBlock rounded bg-dark text-white'><h1 style=' text-align: center; top:100px; margin: auto; left: 0; right: 0'>
" . $_SESSION['message'] . "</h1></div>";

$_SESSION['message'] = "";
?>

</body>
</html>
<?php
include "classUser.php";
//A session segitsegevel megadjuk az adatok ertekeit
if (isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['profilePic'])) {
    if (isset($_POST['searchAction'])) {
        if ($_POST['searchAction'] == 'search') {

            $usersData = new User("Worker",$_POST['searchMail'],"workers.php");
            $usersData->userString();

        } else {

            $usersData = new User("Worker",0,"workers.php");
            $usersData->userString();
        }
    } else {
        $usersData = new User("Worker",0,"workers.php");
        $usersData->userString();
    }


} else {
    header('Location: index.php');
    exit();
}


?>