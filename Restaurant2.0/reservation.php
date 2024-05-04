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

<form method="post" action="reservation.php?table=<?php echo $_GET['table'] ?>" class="mainForm">
    <h2>Reservation for table <?php echo $_GET['table'] ?></h2>
    <?php
    if (!isset($_POST['day']))
        echo '<input type="date" name="day" id="day" onchange="activateSubmit()">';

    else
        echo "<input type=\"date\" name=\"day\" id=\"day\" value=\"" . $_POST['day'] . "\" onchange=\"activateSubmit()\">";
    ?>
    <input type='submit' name='action' id='submitButton' value='day' style='display: none;'><br>
    <?php
    include 'connection.php';
    if (!isset($_GET['table'])) {
        header('location:tables.php');
        exit();
    }
    if (isset($_POST['action'])) {


        $date = " ";
        $hour = " ";
        $period = " ";
        $start = "15:00";
        $end = "23:30";

        $tStart = strtotime($start);
        $tEnd = strtotime($end);
        $tNow = $tStart;
        global $conn;
        if (isset($_POST['day'])) {

            $day = $_POST['day'];
            echo "<h2>" . $_POST['day'] . "</h2>";
        }
        $sql = mysqli_prepare($conn, "SELECT * FROM `reservation` WHERE `tableId` = ?
                            and reservationDay=? order by reservationTime asc ");
        $sql->bind_param("is", $_GET['table'], $day);
        $sql->execute();
        $result = $sql->get_result();

        echo '<label for="res">Reservation time:</label><br><label for="res">From:</label>';
        echo "<form method=\"post\" action=\"reservation.php?table=" . $_GET['table'] . "\" class=\"mainForm\">";
        echo '<select name="reservationTimeStart"  onchange="activateSubmit2()"><br>';
        if (isset($_POST['reservationTimeStart']))
           echo '<option selected="selected" value="' . date("H:i", $tNow) . '">' . date("H:i", $tNow) . '</option>';

        else {

            echo '<option hidden>Select Time</option>';
        }
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

                }
            }
        }

        while ($tNow < $tEnd - 15 * 60) {
            echo '<option value="' . date("H:i", $tNow) . '">' . date("H:i", $tNow) . '</option>';
            $tNow = strtotime('+15 minutes', $tNow);
        }


        echo "</select><br><input type='submit' name='action' id='submit2'  hidden='hidden' value='TimeStart'><br><br>";


        if (isset($_POST['action']) && $_POST['action'] == "TimeStart") {


                // Increment $tNow by half an hour only once
                $tNow = strtotime($_POST['reservationTimeStart'])+30*60 ; // Adding 30 minutes to $tNow
                $isIncremented = 1; // Set the flag to true to indicate the increment has been done




            $sql = mysqli_prepare($conn, "SELECT * FROM `reservation` WHERE `tableId` = ?
                            and reservationDay=? order by reservationTime asc ");
            $sql->bind_param("is", $_GET['table'], $_POST['day']);
            $sql->execute();
            $result = $sql->get_result();

            echo '<label for="res">Reservation time:</label><br><label for="res">From:</label>';
            echo "<form method=\"post\" action=\"reservation.php?table=" . $_GET['table'] . "\" class=\"mainForm\">";
            echo '<select name="reservationTimeEnd"><br>';
            echo'<option hidden>Select Time</option>';

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $hour = $row['reservationTime'];


                        while ($tNow <= strtotime($hour)) {
                            if($data=0) {
                                echo '<option value="' . date("H:i", $tNow + 30 * 60) . '">' . date("H:i", $tNow + 30 * 60) . '</option>';
                                $tNow = strtotime('+15 minutes', $tNow + 30 * 60);
                                $data = 1;
                            }
                            else{
                                echo '<option value="' . date("H:i", $tNow) . '">' . date("H:i", $tNow ) . '</option>';
                                $tNow = strtotime('+15 minutes', $tNow );
                            }
                        }

                }
            }
            else{


                while ($tNow < $tEnd + 15 * 60) {

                    echo '<option value="' . date("H:i", $tNow) . '">' . date("H:i", $tNow) . '</option>';
                    $tNow = strtotime('+15 minutes', $tNow);

                }
            }


            echo '</select><br><input type="submit" name="action" value="Reserve"><br>';
        }
    }

    echo '</form>';

    if(isset($_POST['action']) && $_POST['action'] == "Reserve") {

        global $conn;

        $sql=mysqli_prepare($conn,"INSERT INTO `reservation`(`tableId`, `registrationId`, 
                          `reservationDay`, `reservationTime`, `period`) 
VALUES (?,?,?,?,?)");
        $sql->bind_param("iisss",$_GET['table'],$_SESSION['userID'],$_POST['day'],$_POST['reservationTimeStart'],$_POST['reservationTimeEnd']);
        $sql->execute();
    }
    ?>

</body>
</html>
