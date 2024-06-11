<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add table</title>
    <link rel="stylesheet" href="SideStyle.css">
    <script>


        function activateSubmit() {
            // Activate the submit button when a file is selected
            document.getElementById('submitButton').click();
        }

        function activateSubmit2() {
            // Activate the submit button when a file is selected
            document.getElementById('submit2').click();
        }

        function logoutAndRedirect() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'functions.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Redirect to MainPage.php after successful logout
                    window.location.href = 'reservation.php';
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

<form method="post" action="reservation.php?table=<?php if(isset($_GET['table']))echo $_GET['table'];else{ header('location:tables.php');
    exit();} ?>" class="mainForm">
    <h2>Reservation for table <?php echo $_GET['table'] ?></h2>

    <?php

    include 'connection.php';
    global $conn;


    if (isset($_POST['action']) && $_POST['action'] == "Reserve" && $_SESSION['reservationTime']  != " " && $_POST['reservationTimeEnd']!="Select Time") {
        $_SESSION['reservation'] = 1;
        $sql = mysqli_prepare($conn, "INSERT INTO `reservation`(`tableId`, `userId`, `reservationDay`, `reservationTime`, `period`) VALUES (?,?,?,?,?)");
        $sql->bind_param("iisss", $_GET['table'], $_SESSION['userID'], $_POST['day'], $_SESSION['reservationTime'], $_POST['reservationTimeEnd']);
        $sql->execute();
        $_SESSION['reservationMessage']="You reserved the table " . $_GET['table'] . "!";
        $_SESSION['reservationTime']=" ";

    }


    if (!isset($_SESSION['email'])) {
        header('location:index.php');
        exit();
    }

    echo '<label for="res">Reservation Date:</label><br><br>';
    if (!isset($_POST['day'])) {
        echo '<input type="date" style="width: 240px" name="day" id="day" onchange="activateSubmit()">';
    } else {
        echo "<input type=\"date\" name=\"day\" id=\"day\" value=\"" . $_POST['day'] . "\" onchange=\"activateSubmit()\">";
    }

    echo "<input type='submit' name='action' id='submitButton' value='day' style='display: none;'><br>";

    if (!isset($_GET['table'])) {
        header('location:tables.php');
        exit();
    }

    if (isset($_POST['action']) && ($_POST['action'] == "TimeStart" ||$_POST['action'] == "day")) {
        $date = " ";
        $hour = " ";
        $period = " ";
        $start = "15:00";
        $end = "23:30";

        if (isset($_POST['reservationTimeStart']))
            $_SESSION['reservationTime'] = $_POST['reservationTimeStart'];

        $tStart = strtotime($start);
        $tEnd = strtotime($end);
        $tNow = $tStart;
        global $conn;

        if (isset($_POST['day']) ) {
            $day = $_POST['day'];
            echo "<h2>" . $_POST['day'] . "</h2>";
        }

        $sql = mysqli_prepare($conn, "SELECT * FROM `reservation` WHERE `tableId` = ? and reservationDay=? order by reservationTime asc ");
        $sql->bind_param("is", $_GET['table'], $day);
        $sql->execute();
        $result = $sql->get_result();

        echo '<label for="res">Reservation time:</label><br><label for="res">From:</label>';
        echo "<form method=\"post\" action=\"reservation.php?table=" . $_GET['table'] . "\" class=\"mainForm\">";
        echo '<select class="inputok" name="reservationTimeStart" onchange="activateSubmit2()"><br>';

        if (!isset($_SESSION['reservationTime']) ||  $_SESSION['reservationTime']==" " )
            echo '<option hidden>Select Time</option>';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $hour = $row['reservationTime'];
                $periodHour = $row['period'];

                if ($hour != " ") {
                    while ($tNow < strtotime($hour) - 45 * 60) {
                        if ($_SESSION['reservationTime'] == date("H:i", $tNow))
                            echo '<option selected value="' . date("H:i", $tNow) . '">' . date("H:i", $tNow) . '</option>';
                        else
                            echo '<option value="' . date("H:i", $tNow) . '">' . date("H:i", $tNow) . '</option>';
                        $tNow = strtotime('+15 minutes', $tNow);
                    }
                    $tNow = strtotime($periodHour);
                }
            }
        }

        while ($tNow < $tEnd - 45 * 60) {
            if ($_SESSION['reservationTime'] == date("H:i", $tNow))
                echo '<option selected value="' . date("H:i", $tNow) . '">' . date("H:i", $tNow) . '</option>';
            else
                echo '<option value="' . date("H:i", $tNow) . '">' . date("H:i", $tNow) . '</option>';
            $tNow = strtotime('+15 minutes', $tNow);
        }

        echo "</select><br><input type='submit' name='action' id='submit2' hidden='hidden' value='TimeStart'><br><br>";

        if (isset($_POST['action']) && $_POST['action'] == "TimeStart") {
            $tNow = strtotime($_SESSION['reservationTime'] ) + 60 * 60; // Adding 30 minutes to $tNow
            $isIncremented = 0;
            $count = 0;

            $sql = mysqli_prepare($conn, "SELECT * FROM `reservation` WHERE `tableId` = ? and reservationDay=? order by reservationTime asc ");
            $sql->bind_param("is", $_GET['table'], $_POST['day']);
            $sql->execute();
            $result = $sql->get_result();

            echo '<label for="res">Reservation time:</label><br><label for="res">To:</label>';
            echo "<form method=\"post\" action=\"reservation.php?table=" . $_GET['table'] . "\" class=\"mainForm\">";
            echo '<select class="inputok" name="reservationTimeEnd"><br>';
            echo '<option hidden>Select Time</option>';

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $hour = $row['reservationTime'];

                    while ($tNow <= strtotime($hour) && $count < 21) {
                        echo '<option value="' . date("H:i", $tNow) . '">' . date("H:i", $tNow) . '</option>';

                        $tNow = strtotime('+15 minutes', $tNow);
                        $count++;
                        $isIncremented = 1;

                    }

                }
            }

            if ($isIncremented == 0) {
                if ($tNow < strtotime($_SESSION['reservationTime'] ) + 60 * 60)
                    $tNow = strtotime($_SESSION['reservationTime'] ) + 60 * 60;
                while ($tNow <= $tEnd && $count < 21) {
                    $count++;
                    echo '<option value="' . date("H:i", $tNow) . '">' . date("H:i", $tNow) . '</option>';

                    $tNow = strtotime('+15 minutes', $tNow);
                }
            }


            echo '</select><br><input class="inputok" type="submit" name="action" value="Reserve"><br>';
        }


}

    if(isset($_SESSION['reservationMessage'])){
        echo $_SESSION['reservationMessage'];
        unset($_SESSION['reservationMessage']);}
    $t=time();
    $currentTime = date("Y-m-d",$t);
    if($_SESSION['privalage']=="admin" || $_SESSION['privalage']=="worker") {
        $sql = mysqli_prepare($conn, "SELECT CONCAT(user.firstName, ' ', user.lastName) AS name, reservation.*
FROM user
INNER JOIN reservation ON user.userId = reservation.userId
WHERE reservation.reservationDay >= ? AND reservation.tableId = ?
ORDER BY reservation.reservationDay ASC;
");
        $sql->bind_param('si',  $currentTime,$_GET['table']);
    }
    else{
        $sql = mysqli_prepare($conn, "SELECT * FROM reservation where userId = ? and reservationDay>= ?");
        $sql->bind_param('is', $_SESSION['userID'], $currentTime);
    }
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {

        echo '<div style="display: flex; justify-content: center; align-items: center;">';
        echo '<table border="1" style="border-collapse: collapse;">';
        while ($row = $result->fetch_assoc()) {

            if($_SESSION['privalage']!="admin" || $_SESSION['privalage']!="worker")
                echo '<tr><th>Reserved by ' . $row['tableId'] . '</th></tr>';
            else
                echo '<tr><th>The Guest is  ' . $row['name'] . '</th></tr>';
            echo '<tr><th>' . $row['reservationDay'] . '</th></tr>';
            echo '<tr><td>' . $row['reservationTime'] . ' - ' . $row['period'] . '</td></tr>';

        }
        echo '</table><br>';

    }


    echo '</div>';
    echo '</form>';

    ?>

</body>
</html>
