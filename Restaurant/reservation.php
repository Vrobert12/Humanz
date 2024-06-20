<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
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

        function fetchDishesByType() {
            var selectedType = document.getElementById("dishTypeSelect").value;
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "fetch_dishes.php?dishType=" + selectedType, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("dishContainer").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        function refreshPage() {
            window.location.reload();
        }
    </script>
<!--    <script src="dishes.js"></script>-->
</head>
<body>
<?php
include 'connection.php';
global $conn;

$today = date("Y-m-d");
$todayHour = date("H:i:s");

if (isset($_POST['delete']) && $_POST['delete'] = 'delete') {
    $sql = mysqli_prepare($conn, "SELECT * FROM `reservation` WHERE reservationId=? order by reservationTime asc ");
    $sql->bind_param('i', $_POST['reservation']);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (strtotime($row['reservationTime']) > strtotime($todayHour) + 4 * 60 * 60) {

                $sqlDelete = mysqli_prepare($conn, "delete  FROM reservation where reservationId = ? ");
                $sqlDelete->bind_param('i', $_POST['reservation']);
                $sqlDelete->execute();
                $resultDelete = $sqlDelete->get_result();

            } else {
                if ($row['reservationDay'] != $today ) {

                    $sqlDelete = mysqli_prepare($conn, "delete  FROM reservation where reservationId = ? ");
                    $sqlDelete->bind_param('i', $_POST['reservation']);
                    $sqlDelete->execute();
                    $resultDelete = $sqlDelete->get_result();
                }
                else{
                    $_SESSION['reservationMessage'] = "You can not resign the table " . $_GET['table'] . ", 4 hours before the reservation!";
                }

            }
        }
    }


}
$sqlTable = $conn->prepare("SELECT max(tableId) AS max_tableId FROM `table`");
$sqlTable->execute();
$result = $sqlTable->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['maxTableId'] = $row['max_tableId'];
}
?>
<form class="menuForm">
    <h2>Menu</h2>
    <label class="bold">Type:
        <select class="inputok" id="dishTypeSelect" onchange="fetchDishesByType()">
            <?php
            include 'connection.php';
            global $conn;

            $sqlType = $conn->prepare("SELECT DISTINCT dishType FROM menu");
            $sqlType->execute();
            $res = $sqlType->get_result();
            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    echo "<option value='" . $row['dishType'] . "'>" . $row['dishType'] . "</option>";
                }
            }
            ?>
        </select>
    </label>
    <div class="container text-center" id="dishContainer">
        <?php
        $command = "SELECT * FROM menu";
        $stmt = $conn->prepare($command);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="row align-items-start">';
                echo '<div class="col"><img src="' . $row['dishPicture'] . '" alt="img" width="140px" height="120px"/></div>';
                echo "<div class='col'><div class='row align-items-start'><label>Name: " . $row['dishName'] . " (" . $row['dishType'] . ")</label></div>";
                echo "<div class='row align-items-start'><label>Price: " . $row['dishPrice'] . "€</label></div>";
                echo '</div></div>';
            }
        }
        ?>
    </div>
</form>
<form method="post"
      action="reservation.php?table=<?php if (isset($_GET['table']) && $_GET['table'] > 0 && $_GET['table'] <= $_SESSION['maxTableId']) echo $_GET['table']; else {
          header('location:tables.php');
          exit();
      } ?>&" class="reservationForm">
    <a class="nextPage" href="tables.php">Back</a>
    <?php if ($_GET['table'] > 1) echo "<a class=\"nextPage\" href=\"reservation.php?table=" . ($_GET['table'] - 1) . "\">Previous table</a>"; ?>
    <?php if ($_GET['table'] < $_SESSION['maxTableId']) echo "<a class=\"nextPage\" href=\"reservation.php?table=" . ($_GET['table'] + 1) . "\">Next table</a>";


    echo "<br><br><h2>Reservation for table " . $_GET['table'] . "</h2>";


    $today = date("Y-m-d");
    $sql = $conn->prepare("SELECT reservation.* FROM user
        INNER JOIN reservation ON user.userId = reservation.userId
        WHERE reservation.reservationDay >= ? AND user.userId = ?
        ORDER BY reservation.reservationDay ASC;");
    $sql->bind_param('si', $today, $_SESSION['userID']);
    $sql->execute();
    $result = $sql->get_result();


    if ($result->num_rows >= 0 && $result->num_rows < 5) {
        if (isset($_POST['action']) && $_POST['action'] == "Reserve" && $_SESSION['reservationTime'] != " " && $_POST['reservationTimeEnd'] != "Select Time") {
            // Prepare and execute the first query

            $_SESSION['reservation'] = 1;

            // Clear the result set
            $result->free();

            // Prepare and execute the insert query
            $insert_sql = $conn->prepare("INSERT INTO reservation (tableId, userId, reservationDay, reservationTime, period) VALUES (?, ?, ?, ?, ?)");
            $insert_sql->bind_param("iisss", $_GET['table'], $_SESSION['userID'], $_POST['day'], $_SESSION['reservationTime'], $_POST['reservationTimeEnd']);
            $insert_sql->execute();

            // Check for successful insertion
            if ($insert_sql->affected_rows > 0) {
                $_SESSION['reservationMessage'] = "You reserved the table " . $_GET['table'] . "!";
                $_SESSION['reservation'] = 1;
                $_SESSION['reservationTable'] = $_GET['table'];
                $_SESSION['reservationTimeEnd'] = $_POST['reservationTimeEnd'];
                $_SESSION['day'] = $_POST['day'];
                header('location:mail.php');
                exit();

            } else {
                $_SESSION['reservationMessage'] = "Error reserving the table. Please try again.";
            }

            $insert_sql->close();
        } elseif (isset($_POST['reservationTimeEnd']) && $_POST['reservationTimeEnd'] == "Select Time") {
            $_SESSION['reservationMessage'] = "You have too select when do you want your reservation to end.";
            unset($_POST['reservationTimeEnd']);
        }
        $_SESSION['reservationTime'] = " ";


        if (!isset($_SESSION['email'])) {
            header('location:index.php');
            exit();
        }

        echo '<label for="res" class="fix">Reservation Date:</label><br><br>';
        if (!isset($_POST['day'])) {
            echo '<input type="date" style="width: 240px" class="inputok" name="day" id="day" onchange="activateSubmit()">';
        } else {
            echo "<input type=\"date\" name=\"day\" class=\"inputok\"id=\"day\" value=\"" . $_POST['day'] . "\" onchange=\"activateSubmit()\">";
        }

        echo "<input type='submit' name='action' id='submitButton' value='day' style='display: none;'><br>";

        if (!isset($_GET['table'])) {
            header('location:tables.php');
            exit();
        }

        if (isset($_POST['action']) && ($_POST['action'] == "TimeStart" || $_POST['action'] == "day")) {
            $today = date("Y-m-d");
            $sqlReservation = $conn->prepare("SELECT * FROM reservation where userId = ? and 
                    reservationDay= ? and tableId= ? ORDER BY reservationDay ASC, reservationTime ASC;");
            $sqlReservation->bind_param('isi', $_SESSION['userID'], $_POST['day'], $_GET['table']);
            $sqlReservation->execute();
            $reservation = $sqlReservation->get_result();
            if ($_POST['day'] >= $today && $reservation->num_rows == 0) {
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

                if (isset($_POST['day'])) {
                    $day = $_POST['day'];
                    echo "<h2>" . $_POST['day'] . "</h2>";
                }

                $sql = mysqli_prepare($conn, "SELECT * FROM `reservation` WHERE `tableId` = ? and reservationDay=? order by reservationTime asc ");
                $sql->bind_param("is", $_GET['table'], $day);
                $sql->execute();
                $result = $sql->get_result();

                echo '<label for="res">Reservation time:</label><br><label for="res">From:</label>';
                echo "<form method=\"post\" action=\"reservation.php?table=" . $_GET['table'] . "\" class=\"reservationForm\">";
                echo '<select class="inputok" name="reservationTimeStart" onchange="activateSubmit2()"><br>';

                if (!isset($_SESSION['reservationTime']) || $_SESSION['reservationTime'] == " ")
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
            } elseif ($reservation->num_rows > 0) {
                $_SESSION['reservationMessage'] = "You have reservation on table " . $_GET['table'] . " for day " . $today .
                    ".You can not have to reservations on same day with the same table.";
            } else {
                $_SESSION['reservationMessage'] = "This day has passed, you can't reserve tables before " . $today . ".";
            }
            if (isset($_POST['action']) && $_POST['action'] == "TimeStart") {
                $todayHour = date("H:i:s");
                if (strtotime($_SESSION['reservationTime']) <= strtotime($todayHour) && $today == $_POST['day']) {
                    $_SESSION['reservationMessage'] = "This hour has passed, you can't reserve tables before " . $todayHour . "";
                } else {
                    $tNow = strtotime($_SESSION['reservationTime']) + 60 * 60; // Adding 30 minutes to $tNow
                    $isIncremented = 0;
                    $count = 0;

                    $sql = mysqli_prepare($conn, "SELECT * FROM `reservation` WHERE `tableId` = ? and reservationDay=? order by reservationTime asc ");
                    $sql->bind_param("is", $_GET['table'], $_POST['day']);
                    $sql->execute();
                    $result = $sql->get_result();

                    echo '<label for="res">Reservation time:</label><br><label for="res">To:</label>';
                    echo "<form method=\"post\" action=\"reservation.php?table=" . $_GET['table'] . "\" class=\"reservationForm\">";
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
                        if ($tNow < strtotime($_SESSION['reservationTime']) + 60 * 60)
                            $tNow = strtotime($_SESSION['reservationTime']) + 60 * 60;
                        while ($tNow <= $tEnd && $count < 21) {
                            $count++;
                            echo '<option value="' . date("H:i", $tNow) . '">' . date("H:i", $tNow) . '</option>';

                            $tNow = strtotime('+15 minutes', $tNow);
                        }
                    }


                    echo '</select><br><input class="inputok" type="submit" name="action" value="Reserve"><br>';
                }


            }
        }
    } else {
        $_SESSION['reservationMessage'] = "You have too many reservations, you can't reserve more tables today.";
    }
    if (isset($_SESSION['reservationMessage'])) {
        echo '<div style="display: flex; justify-content: center; align-items: center; margin: 20px 0;">';
        echo '<div style="background-color: #eaf4fc; color: #31708f; border: 1px solid #bce8f1; padding: 15px; border-radius: 5px; width: 80%; text-align: center; font-size: 24px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">';
        echo $_SESSION['reservationMessage'];
        unset($_SESSION['reservationMessage']);
        echo ' <br><button class="inputok" onclick="refreshPage()">Okay</button><br>';
        echo '</div>';
        echo '</div>';
    }
    $t = time();
    $currentTime = date("Y-m-d", $t);
    if ($_SESSION['privalage'] == "admin" || $_SESSION['privalage'] == "worker") {
        $sql = mysqli_prepare($conn, "SELECT CONCAT(user.firstName, ' ', user.lastName) AS name, reservation.*
        FROM user
        INNER JOIN reservation ON user.userId = reservation.userId
        WHERE reservation.reservationDay >= ? AND reservation.tableId = ?
        ORDER BY reservation.reservationDay ASC;");
        $sql->bind_param('si', $currentTime, $_GET['table']);
    } else {
        $sql = mysqli_prepare($conn, "SELECT * FROM reservation where userId = ? and reservationDay>= ? ORDER BY reservationDay ASC,reservationTime ASC;");
        $sql->bind_param('is', $_SESSION['userID'], $currentTime);
    }
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {

        echo '<div style="display: flex; justify-content: center; align-items: center;">';
        echo '<br><br><table border="1" style="border-collapse: collapse; width: 90%; margin: 20px auto; font-size: 18px; text-align: left; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">';

        // Table header
        echo '<thead style="background-color: #f8f9fa;">';
        echo '<tr>';
        if ($_SESSION['privalage'] != "admin" && $_SESSION['privalage'] != "worker") {
            echo '<th style="padding: 12px; border: 1px solid #ddd;">Table ID</th>';
        } else {
            echo '<th style="padding: 12px; border: 1px solid #ddd;">Name</th>';
        }
        echo '<th style="padding: 12px; border: 1px solid #ddd;">Reservation Day</th>';
        echo '<th style="padding: 12px; border: 1px solid #ddd;">Reservation Time - Period</th>';
        echo '<th style="padding: 12px; border: 1px solid #ddd;">Cancel</th>';
        echo '</tr>';
        echo '</thead>';

        // Table body
        echo '<tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            if ($_SESSION['privalage'] != "admin" && $_SESSION['privalage'] != "worker") {
                echo '<th style="padding: 10px; border: 1px solid #ddd;">' . $row['tableId'] . '</th>';
            } else {
                echo '<th style="padding: 10px; border: 1px solid #ddd;">' . $row['name'] . '</th>';
            }
            echo '<th style="padding: 10px; border: 1px solid #ddd;">' . $row['reservationDay'] . '</th>';
            echo '<th style="padding: 10px; border: 1px solid #ddd;">' . $row['reservationTime'] . ' - ' . $row['period'] . '</th>';
            echo '<th style="padding: 10px; border: 1px solid #ddd;">
    <form method="post" action="reservation.php?table=' . $_GET['table'] . '" >
    <input type="submit" name="delete" value="delete" class="inputok" onclick="confirmDeletion();">
    <input type="hidden" name="reservation" value="' . $row['reservationId'] . '">
    </form>
    <script type="text/javascript">
    function confirmDeletion() {
    return confirm("Are you sure you want to delete this reservation?");
        }
    </script>
    </th>';
            echo '</tr>';
        }
        echo '</tbody>';

        echo '</table><br>';



    } else{
        $_SESSION['noTablesMessage'] = "There are no reservations yet";
        echo '<div style="display: flex; justify-content: center; align-items: center; margin: 20px 0;">';
        echo '<div style="background-color: #eaf4fc; color: #31708f; border: 1px solid #bce8f1; padding: 15px; border-radius: 5px; width: 80%; text-align: center; font-size: 24px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">';
        echo $_SESSION['noTablesMessage'];
        unset($_SESSION['noTablesMessage']);
        echo '</div>';
        echo '</div>';
    }



    $sql->close();
    echo '</div>';
    echo '</form>';

    ?>
    <form class="couponForm" method="post">
        <label for="codeInput">Coupon code:</label>
        <input type="text" name="code" id="codeInput"><br>
        <input class="inputok" type="submit" name="action" value="Submit">
    </form>
</body>
</html>
