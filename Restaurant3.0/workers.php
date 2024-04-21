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
    <style>


        .more {
            background-color: #2a7e2a;
            color: white;
            border: 0;
            padding: 10px;
            border-radius: 10px;
            font-size: 16px;
        }

        th {
            background-color: lightblue;
        }

        td, th {
            padding: 15px;
            font-size: 20px;
        }

        .more:hover {
            background-color: #1e425d;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-black">
    <div class="container-fluid">

        <a href="#" id="logo"><h2>R&D</h2></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon right"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
            <ul class="navbar-nav ">
                <li class="nav-item dropdown ">
                    <div class="dropdown d-flex  ">
                        <nav class="btn btn-secondary me-2 " data-bs-toggle="dropdown" aria-expanded="false">
                            <?php include "connection.php";

                            global $conn;
                            if (isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['profilePic'])) {
                                $eMail = $_SESSION['email'];
                                $name = $_SESSION['name'];

                                $profilePic = $_SESSION['profilePic'];
                                echo '<li class="nav-item">';
                                echo "<img class=\"profilePic\" src=\"http://localhost:/Restaurant2.0/pictures/{$profilePic}\" width=\"50\" height=\"50\" alt=\"profilkep\">";


                                $sql = "SELECT * FROM rendszergazda";
                                $stmt = $conn->query($sql);

                                $_SESSION['message'] = "";
                                if ($stmt->num_rows > 0)
                                    while ($row = $stmt->fetch_assoc())
                                        if ($_SESSION['email'] == $row['rendszerGazdaEmail']) {

                                            echo "<a>Admin</a>";
                                            echo "<a> <i class=\"bi bi-person\"></i> $name</a>";
                                            echo "</li>";

                                        } else {
                                            echo "<a href='logIn.php' class='nav-link dropdown-item'><i class=\"bi bi-person\"></i>Account</a>";
                                        }
                            }
                            ?></nav>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                            <li><?php

                                echo "<a class=\"dropdown-item\" href=\"functions.php?action=kijelentkezes\">"; // a headeren keresztül megadjuk a kijeletkezés értékét
                                echo "<i class=\"bi bi-door-open\"></i> Log out</a>";

                                echo "<a class=\"dropdown-item\" href=\"MainPage.php?\"><i class=\"bi bi-arrow-return-left\"></i> Back to Main</a>";;


                                ?>

                        </ul>
</nav>
</div>


</li>


</ul>
</div>
</div>
</nav>
</body>
</html>
<?php


$sql = "SELECT * FROM dolgozo";
$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo "<table class='table table-striped table-dark  ' style='  margin: auto; margin-top: 150px;left:0; right:0'>
<thead>
<th>ID</th>
<th>Keresztnév</th>
<th>Vezetéknév</th>
<th>Telefonszam</th>
<th>Email cím</th>
<th>Verifikáció</th>
<th>Verifikciós kód</th>
<th>Virefikáció érvényessége</th>
<th>Bannolás</th>
<th>Bannolás ideje</th><th></th></thead>";
    while ($row = $result->fetch_assoc()) {
        echo
            "</tr scope='row'><td>" . $row['regisztraloId'] . "</td>
<td>" . $row['keresztnev'] . "</td>
<td>" . $row['vezeteknev'] . "</td>
<td>" . $row['telefonszam'] . "</td>
<td>" . $row['dolgozoEmail'] . "</td>";

        echo "<td><form method='post' action='worker.php'>
<input type='hidden' name='id' value='" . $row['regisztraloId'] . "'>
<input type='submit' class='more' name='userId' value='Bővebben' >
</form></td></tr>";
    }

    echo "</table>";
}
?>