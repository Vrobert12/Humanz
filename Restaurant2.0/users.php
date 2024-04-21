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
            margin: 10px;
        }

        th {
            background-color: lightblue;
        }

        label {
            color: white;
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
        <?php
        include "connection.php";

        global $conn;
        if (isset($_SESSION['email']) && isset($_SESSION['name'])) {
            echo "<li><a class=\"dropdown-item\" href=\"index.php?\"><i class=\"bi bi-arrow-return-left\"></i> Back to Main</a></li>";;

            echo '<li><form method="post" action="users.php">
            <input type="text" style="width: 250px" placeholder="search" name="searchMail">
            <input type="submit" value="search" name="searchAction">
            <input type="submit" value="delete" name="searchDelete">
        </form></li>';
        }


        ?>

        <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
            <ul class="navbar-nav ">
                <li class="nav-item dropdown ">
                    <div class="dropdown d-flex  ">
                        <nav class="btn btn-secondary me-2 " data-bs-toggle="dropdown" aria-expanded="false">
                            <?php
                            if (isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['profilePic'])) {
                                $eMail = $_SESSION['email'];
                                $name = $_SESSION['name'];

                                $profilePic = $_SESSION['profilePic'];
                                echo '<li class="nav-item">';
                                echo "<img class=\"profilePic\" src=\"http://localhost:/Restaurant2.0/pictures/{$profilePic}\" width=\"50\" height=\"50\" alt=\"profilkep\">";


                                $sql = "SELECT * FROM admin";
                                $stmt = $conn->query($sql);

                                $_SESSION['message'] = "";
                                if ($stmt->num_rows > 0)
                                    while ($row = $stmt->fetch_assoc())
                                        if ($_SESSION['email'] == $row['adminMail']) {

                                            echo "<a>Admin</a>";
                                            echo "<a> <i class=\"bi bi-person\"></i> $name</a>";
                                            echo "</li>";

                                        } else {
                                            echo "<a href='logIn.php' class='nav-link dropdown-item'><i class=\"bi bi-person\"></i>Account</a>";
                                        }
                            } else {
                                echo "<a href='logIn.php' class='nav-link dropdown-item'><i class=\"bi bi-person\"></i>Account</a>";
                            }
                            ?></nav>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                            <li><?php
                                if (isset($_SESSION['email']) && isset($_SESSION['name'])) { //A session segitsegevel megadjuk az adatok ertekeit

                                    echo "<a class=\"dropdown-item\" href=\"functions.php?action=kijelentkezes\">"; // a headeren keresztül megadjuk a kijeletkezés értékét
                                    echo "<i class=\"bi bi-door-open\"></i> Log out</a>";

                                 }
                                else{
                                    header('Location: index.php');
                                    exit();
                                }

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
 //A session segitsegevel megadjuk az adatok ertekeit

    if (isset($_POST['searchAction'])) {
        if ($_POST['searchAction'] == 'search') {
            $data = "SELECT * FROM user where userMail= '" . $_POST['searchMail'] . "'";
            users($data);
        } else {
            users("SELECT * FROM user");
        }
    } else {
        users("SELECT * FROM user");

    }
    function users($command)
    {

        global $conn;
        $sql = $command;
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {

            echo '<div class="container">
  <div class="row justify-content-around" >';
            while ($row = $result->fetch_assoc()) {

                echo ' <div class="col-xl-4 p-4 border bg-dark" style="  
 margin: auto; margin-top:100px; margin-bottom: 50px;left:0; right:0">';
                echo "<div class=\"col-xl-4 \"><img class=\"profilePic\" src=\"http://localhost:/Restaurant2.0/pictures/" . $row['profilePic'] . "
          \" width=\"250\" height=\"250\" alt=\"profilkep\"></div><label>ID: " . $row['registrationId'] . "</label><br>
<label>First name: " . $row['firstName'] . "</label><br>
<label>Last name: " . $row['lastName'] . "</label><br>
<label>Phone number: " . $row['phoneNumber'] . "</label><br>
<label>Email address: " . $row['userMail'] . "</label><br>
<label>Verification: ";


                if ($row['verify'] != 1) {
                    echo "No</label><br><label>Verification code: " . $row['verification_code'] . "</label><br><label>Virefication validity: 
" . $row['verification_time'] . " </label><br>";
                } else {
                    echo "Yes</label><br><label>Verification code: NONE</label><br><label> Virefication validity: NONE</label><br>";
                }
                if ($row['banned'] == 0) {
                    echo "<label>Ban: No</label><br><label> Ban time: NONE</label><br>";
                } else {
                    echo "<label>Ban: Yes</label><br><label> Ban time: " . $row['banned_time'] . "</label><br>";
                }

                echo "<form method='post' action='user.php'>
<input type='hidden' name='id' value='" . $row['registrationId'] . "'>
<input type='submit' class='more' name='userId' value='More info' >
</form></div>";
            }

            echo "</div></div></div>";
        } else {
            echo "<label>No result.</label>";
        }

}

?>

