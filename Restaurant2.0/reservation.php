<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add table</title>
    <link rel="stylesheet" href="SideStyle.css">
</head>
<body>

<form method="post" action="reservation.php?table=<?php echo $_GET['table'] ?>" class="mainForm">
    <h2>Reservation for table <?php echo $_GET['table'] ?></h2>
<input type="date" name="day"><br>
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
$day="2024-05-03";
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
