<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add table</title>
    <link rel="stylesheet" href="SideStyle.css">
    <script>
        function activateDatePicker() {
            // Trigger click event on the file input element
            document.getElementById('day').click();
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
<form method="post" action="reservation.php?table=<?php echo $_GET['table'] ?>" class="mainForm">
    <h2>Reservation for table <?php echo $_GET['table'] ?></h2>
    <input type="date" name="day" id="day" onchange="activateSubmit()">
    <input type='submit' name='action' id='submitButton' value='day' style='display: none;'><br>
        <?php
        include 'connection.php';
        if(!isset($_GET['table']))
        {
            header('location:tables.php');
            exit();
        }
        $date = " ";
        $hour = " ";
        $period = " ";
        $start = "15:00";
        $end = "23:30";

        $tStart = strtotime($start);
        $tEnd = strtotime($end);
        $tNow = $tStart;
        global $conn;
    $day=$_POST['day'];
    $sql = mysqli_prepare($conn, "SELECT * FROM `reservation` WHERE `tableId` = ?
                            and reservationDay=? order by reservationTime asc ");
    $sql->bind_param("is", $_GET['table'], $day);
    $sql->execute();
    $result = $sql->get_result();

    echo '<label for="res">Reservation time:</label><br><label for="res">From:</label>';
    echo "<form method=\"post\" action=\"reservation.php?table=". $_GET['table'] ."\" class=\"mainForm\">";

    echo '<select name="timeStart"><br>';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $hour = $row['reservationTime'];
            $periodHour = $row['period'];


            if ($hour != " ") {
                while ($tNow < strtotime($hour) - 15 * 60) {
                    echo '<option value="' . date("H:i", $tNow) . '">' . date("H:i", $tNow) . '</option>';
                    $tNow = strtotime('+15 minutes', $tNow);
                }
                $tNow = strtotime($periodHour);

            } else {
                while ($tNow < $tEnd - 15 * 60) {
                    echo '<option value="' . date("H:i", $tNow) . '">' . date("H:i", $tNow) . '</option>';
                    $tNow = strtotime('+15 minutes', $tNow);
                }
            }
        }
    }

    while ($tNow < $tEnd - 15 * 60) {
        echo '<option value="' . date("H:i", $tNow) . '">' . date("H:i", $tNow) . '</option>';
        $tNow = strtotime('+15 minutes', $tNow);
    }


    echo '</select><br><input type="submit"><br>';

    $sql = mysqli_prepare($conn, "SELECT * FROM `reservation` WHERE `tableId` = ?
                            and reservationDay=? order by reservationTime asc ");
    $sql->bind_param("is", $_GET['table'], $_POST['day']);
    $sql->execute();
    $result = $sql->get_result();

    echo '<label for="res">Reservation time:</label><br><label for="res">From:</label>';
    echo "<form method=\"post\" action=\"reservation.php?table=". $_GET['table'] ."\" class=\"mainForm\">";
    echo '<select name="timeStart"><br>';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $hour = $row['reservationTime'];
            $periodHour = $row['period'];
$tNow=strtotime($_POST['timeStart'])+30*60;

            if ($hour != " ") {
                while ($tNow+15*60 <= strtotime($hour)+15*60) {
                    echo '<option value="' . date("H:i", $tNow) . '">' . date("H:i", $tNow) . '</option>';
                    $tNow = strtotime('+15 minutes', $tNow);
                }
                $tNow = strtotime($periodHour);

            }

        }
    }


    echo '</select><br><input type="submit"><br>';


echo '</form>';

       $_POST['day']=0;
       $_POST['timeStart']=0;
       ?>

</body>
</html>
