<?php
include 'connection.php';
global $conn;

if (isset($_GET['dishType'])) {
    $dishType = $_GET['dishType'];
    $command = "SELECT * FROM menu WHERE dishType = ?";
    $stmt = $conn->prepare($command);
    $stmt->bind_param("s", $dishType);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sum=$row['dishPrice'] * $_SESSION['couponDiscount'];
            echo '<div class="row align-items-start">';
            echo '<div class="col"><img src="https://humanz.stud.vts.su.ac.rs/Restaurant/pictures/' . $row['dishPicture'] . '" alt="img" width="120px" height="120px"/></div>';
            echo "<div class='col'><div class='row align-items-start'><label>Name: " . $row['dishName'] . " (" . $row['dishType'] . ")</label></div>";
            echo "<div class='row align-items-start'><label>Price: " . $sum . "€</label></div>";
            echo '</div></div>';
        }
    } else {
        echo '<div class="row align-items-start"><div class="col"><label>No dishes available for this type.</label></div></div>';
    }
}

