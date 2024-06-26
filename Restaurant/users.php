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
    <script src="LogOut.js"></script>
    <script src="Users.js"></script>
    <style>
        label, a {
            font-size: 24px;
        }

        @media (max-width: 1000px) {
            label, a {
                font-size: 48px;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-black navbar-nav ml-auto">
    <div class="container-fluid">

        <a href="#" class="bar d-none d-lg-block"><h2>R&D</h2><?php /*if (isset($_COOKIE['count']))
             echo $_COOKIE['count'] */ ?></a>
        <a href="#" class="bar d-block d-lg-none"><h4>R&D</h4><?php /*if (isset($_COOKIE['count']))
             echo $_COOKIE['count'] */ ?></a>

        <?php
        include 'connection.php';
        global $conn;
        if ($conn) {
            if( $_SESSION['privalage'] != "admin" && $_SESSION['privalage'] != "worker"){
                header('Location: index.php');
                exit();
            }
            if (isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['profilePic'])) {
                $sql = "SELECT * FROM user";
                $stmt = $conn->query($sql);


                if ($stmt->num_rows > 0)
                    while ($row = $stmt->fetch_assoc()) {
                        if ($_SESSION['email'] == $row['userMail'] && $row['privilage'] == "Admin") {
                            echo "<li><a class=\"d-block d-lg-none\" href=\"index.php\"><i class=\"fa-2x bi bi-arrow-return-left\"></i></a></li>";;
                            echo "<li><a class=\"d-none d-lg-block\" href=\"index.php\"><i class=\"fa-2x bi bi-arrow-return-left\"></i> Back to Main</a></li>";;

                            echo '<li><form method="post" action="users.php"></li>
            <input type="text" style="width: 200px; height: 30px; " placeholder="search" name="searchMail">
              
            <li> <a class="justify-content-end" onclick="activateSearch()"><i class="fa-2x bi bi-search"></i></a></li>
         <li><a class="justify-content-end" onclick="deleteSearch()"><i class="fa-2x bi bi-x-lg"></i></a></li>
            <input type="submit" value="search" id="searchAction" name="searchAction" style="display: none">
            <input type="submit" value="delete" id="searchDelete" name="searchDelete" style="display: none">
            
        </form>
           <a href="#" class="bar d-block d-lg-none"><h2><i class="fa-3x bi bi-person-video"></i></i>  </h2></a>
            <a href="#" class="bar d-none d-lg-block"> <h2>  Users</h2></a>';
                        } elseif ($_SESSION['email'] == $row['userMail'] && $row['privilage'] == "Worker") {
                            echo "<li><a class=\"d-block d-lg-none\" href=\"index.php\"><i class=\"fa-2x bi bi-arrow-return-left\"></i></a></li>";;
                            echo "<li><a class=\"d-none d-lg-block\" href=\"index.php\"><i class=\"fa-2x bi bi-arrow-return-left\"></i> Back to Main</a></li>";;

                            echo '<li><form method="post" action="users.php"></li>
            <input type="text" style="width: 300px; font-size: 30px; height: 50px;" placeholder="search" name="searchMail">
              
            <li> <a class="justify-content-end" onclick="activateSearch()"><i class="fa-2x bi bi-search"></i></a></li>
         <li><a class="justify-content-end" onclick="deleteSearch()"><i class="fa-2x bi bi-x-lg"></i></a></li>
            <input type="submit" value="search" id="searchAction" name="searchAction" style="display: none">
            <input type="submit" value="delete" id="searchDelete" name="searchDelete" style="display: none">
            
        </form>
           <a href="#" class="bar d-block d-lg-none"><h2><i class="fa-3x bi bi-person-video"></i></i>  </h2></a>
            <a href="#" class="bar d-none d-lg-block"> <h2>  Users</h2></a>';

                        }} else {

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
        }
        ?> <button style="border: none;" class=" fa-1x navbar-toggler ml-auto hidden-sm-up float-xs-right float: right" type="button"
                   data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar" >
            <?php
            if(isset($_SESSION['profilePic']))
                echo'  <img class="rounded-circle " width="100" height="100" alt="profilkep" src="https://humanz.stud.vts.su.ac.rs/Restaurant/pictures/'. $_SESSION['profilePic'];
            ?>">

        </button>

        <div class=" collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
            <ul class="navbar-nav ">
                <li class="nav-item dropdown ">



    <?php
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
        $_SESSION['backPic'] = "users.php";
        echo "<input class=\" dropdown-item\"  type='file' name='picture' id='pictureInput' value='pictureUpload' style='display: none;' onchange=\"activateSubmit()\">";
        //láthatatlan, viszont kell a profilkép feltöltéshez
        //Miután a képet feltöltöttük, az aktivája a fügvényt ami automatikusan megnyomja a sumbit gombot
        echo "<input type='submit' name='action' id='submitButton' value='picture' style='display: none;'>";
        //láthatatlan, a kép feltöltésének a végrehajtására szükség
        echo "</form></li>";
        echo "<li><a class=\"  d-block d-lg-none\" href=\"modify.php\">"; // a headeren keresztül megadjuk a kijeletkezés értékét
        echo "<i class='fa-2x  bi bi-person-fill-gear'></i></i> Modify User</a></li>";
        $_SESSION['action'] = "kijelentkezes";
        echo "<li><a  class=\" d-block d-lg-none \" href=\"functions.php\" onclick=\"confirmLogout(event)\">";
        echo "<i class=\"bi bi-door-open fa-2x justify-content-end\"></i> Log out</a></li>";


        echo "<li><a class=\" d-none d-lg-block \"  onclick=' activateProfilePicture()'>
<img  class=\"profilePic\" src=\"https://humanz.stud.vts.su.ac.rs/Restaurant/pictures/{$profilePic}\" width=\"45\" height=\"45\" alt=\"profilkep\">";


        echo "</a><form method='post' action='functions.php' enctype='multipart/form-data'>";
        $_SESSION['backPic'] = "users.php";
        echo "<input class=\" dropdown-item\"  type='file' name='picture' id='pictureInput' value='pictureUpload' style='display: none;' onchange=\"activateSubmit()\">";
        //láthatatlan, viszont kell a profilkép feltöltéshez
        //Miután a képet feltöltöttük, az aktivája a fügvényt ami automatikusan megnyomja a sumbit gombot
        echo "<input type='submit' name='action' id='submitButton' value='picture' style='display: none;'>";
        //láthatatlan, a kép feltöltésének a végrehajtására szükség
        echo "</form></li>";
        echo "<li><a  class=\" d-none d-lg-block \" href=\"modify.php\">"; // a headeren keresztül megadjuk a kijeletkezés értékét
        echo "<i class='fa-2x  bi bi-person-fill-gear'></i></i> </a></li>";
        $_SESSION['action'] = "kijelentkezes";
        echo "<li><a  class=\" d-none d-lg-block \" href=\"functions.php\" onclick=\"confirmLogout(event)\">";
        echo "<i class=\"bi bi-door-open fa-2x\"></i></a></li>";

        echo "</div>";

    } else {
        echo "<a href='logIn.php' class='nav-link dropdown-item'><i class=\"bi bi-person\"></i>Account</a>";
    }
    ?></nav>

<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
    <li><?php
        if (isset($_SESSION['email']) && isset($_SESSION['name'])) { //A session segitsegevel megadjuk az adatok ertekeit

            echo "<a class=\"dropdown-item\"  onclick=' activateProfilePicture()'>";
            //ahelyet hogy két gom kattintással kiválasztjuk majd elküldjük a képet, ez a két
            // fügvény egy gombnyomással és fájl kiválasztással elintézi nekünk
            //a link kattitntásával elvezett minket pictureInput hoz ahova a profilképet feltöltjük
            //ami azért szükséges, mert a file gombnak a stilusat nem tudjuk változtani, ezért láthatatlan
            // és ezért aktivájuk egy linken keresztül
            echo "<i class=\"bi bi-person-square\"></i> Change picture</a>";
            echo "<form method='post' action='functions.php' enctype='multipart/form-data'>";

            echo "<input class=\"dropdown-item\"  type='file' name='picture' id='pictureInput' value='pictureUpload' style='display: none;' onchange=\"activateSubmit()\">";
            //láthatatlan, viszont kell a profilkép feltöltéshez
            //Miután a képet feltöltöttük, az aktivája a fügvényt ami automatikusan megnyomja a sumbit gombot
            echo "<input type='submit' name='action' id='submitButton' value='picture' style='display: none;'>";
            //láthatatlan, a kép feltöltésének a végrehajtására szükség
            echo "</form>";
            echo "<a class=\"dropdown-item\" href=\"modify.php\">"; // a headeren keresztül megadjuk a kijeletkezés értékét
            echo "<i class='bi bi-person-fill-gear'></i></i> Modify user</a>";
            $_SESSION['action'] = "kijelentkezes";
            echo "<a class=\"dropdown-item\" href=\"functions.php\">"; // a headeren keresztül megadjuk a kijeletkezés értékét
            echo "<i class=\"bi bi-door-open\"></i> Log out</a>";

        } else {
            header('Location: index.php');
            exit();
        }

        ?>

</ul> </nav> </div> </li> </ul> </div> </div> </nav>
<?php
if(isset($_SESSION['message']) && $_SESSION['message'] != "")
    echo "<div class='mainBlock rounded bg-dark text-white' style='text-align: center; margin-top: 100px;'>
          <h1 style='margin: auto;'>
              " . $_SESSION['message'] . "
          </h1>
          <a class='inputok' onclick='refreshPage()' style='display: inline-block; padding: 10px 20px; 
             background-color: #19451e; color: white; text-decoration: none; border-radius: 5px; 
             cursor: pointer; transition: background-color 0.3s ease; margin-top: 20px;'>
              Okay
          </a>
      </div>";
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

            $usersData = new User("Guest",$_POST['searchMail'],"users.php");
            $usersData->userString();

        } else {

            $usersData = new User("Guest",0);
            $usersData->userString();
        }
    } else {
        $usersData = new User("Guest",0,"users.php");
        $usersData->userString();
    }


} else {
    header('Location: index.php',"users.php");
    exit();
}

?>

