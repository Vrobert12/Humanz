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
                    window.location.href = 'MainPage.php';
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

<nav class="navbar navbar-expand-lg bg-black">
    <div class="container-fluid">

        <a href="#" id="logo" ><h2>R&D</h2></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon right"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
            <ul class="navbar-nav ">
                <li class="nav-item dropdown ">
                    <div class="dropdown d-flex  ">
                        <nav class="btn btn-secondary me-2 "  data-bs-toggle="dropdown" aria-expanded="false">
                            <?php include "connection.php";  
                            global $conn;
                            if (isset($_SESSION['email'])) {
                                $eMail = $_SESSION['email'];
                                $name = $_SESSION['name'];
                                $privilege = $_SESSION['privilege'];
                                $profilePic = $_SESSION['profilePic'];
                                echo '<li class="nav-item">';
                                echo "<img class=\"profilePic\" src=\"http://localhost:8080/Restaurant2.0/Restaurant/pictures/{$profilePic}\" width=\"50\" height=\"50\" alt=\"profilkep\">";


                                        $sql = "SELECT * FROM rendszergazda";
                                        $stmt = $conn->query($sql);

                                        $_SESSION['message'] = "";
                                        if ($stmt->num_rows > 0)
                                            while ($row = $stmt->fetch_assoc())
                                                if ($_SESSION['email'] == $row['rendszerGazdaEmail']) {

                                                    echo "<a>Admin</a>";
                                                    echo "<a> <i class=\"bi bi-person\"></i> $name</a>";
                                                    echo "</li>";



                                                    }


                                            // If no match found for the email address


                                        $sql = "SELECT * FROM dolgozo";
                                        $stmt = $conn->query($sql);

                                        $_SESSION['message'] = "";
                                        if ($stmt->num_rows > 0)
                                            while ($row = $stmt->fetch_assoc())
                                                if ($_SESSION['email'] == $row['dolgozoEmail']) {

                                                    echo "<a>Dolgozó</a>";
                                                    echo "<a> <i class=\"bi bi-person\"></i> $name</a>";
                                                    echo "</li>";

                                            // If no match found for the email address

                                        }
                                        $sql = "SELECT * FROM regisztralo";
                                        $stmt = $conn->query($sql);

                                        $_SESSION['message'] = "";
                                        if ($stmt->num_rows > 0)
                                            while ($row = $stmt->fetch_assoc())
                                                if ($_SESSION['email'] == $row['regisztraloEmail']) {

                                                    echo "<a>Vendég</a>";
                                                    echo "<a> <i class=\"bi bi-person\"></i> $name</a>";
                                                    echo "</li>";
                                                }


                                // Display user's name and logout link


                            }
                             else {
                                echo "<a href='logIn.php' class='nav-link dropdown-item'><i class=\"bi bi-person\"></i>Account</a>";
                            }
                            ?>
                        </nav>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                            <li><?php
                                if (isset($_SESSION['email'])) { //A session segitsegevel megadjuk az adatok ertekeit
                                    $eMail = $_SESSION['email'];
                                    $name = $_SESSION['name'];
                                    $profilePic = $_SESSION['profilePic'];


                                    echo "<a class=\"dropdown-item\" href=\"functions.php?action=kijelentkezes\">"; // a headeren keresztül megadjuk a kijeletkezés értékét
                                    echo "<i class=\"bi bi-door-open\"></i> Log out</a>";

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


                                } else {
                                    echo "<a href='logIn.php' class='dropdown-item'><i class=\"bi bi-person\"></i> Log in</a>";
                                    echo "<a href='registration.php' class='dropdown-item'><i class=\"bi bi-person-plus\"></i> Registration</a>";
                                }
                                ?></li>

                                    <?php
                                    if(isset($_SESSION['email'])){
                                    $sql = "SELECT * FROM rendszergazda";
                                    $stmt = $conn->query($sql);

                                    $_SESSION['message'] = "";
                                    if ($stmt->num_rows > 0)
                                    while ($row = $stmt->fetch_assoc())
                                    if ($_SESSION['email'] == $row['rendszerGazdaEmail']) {
                                        echo "<li><a class=\"dropdown-item\" href=\"admin.php\">Asztalok módosítása</a></li>";
                                    }}
                                    ?>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>



                </li>


            </ul>
        </div>
    </div>
</nav>

</body>
</html>
