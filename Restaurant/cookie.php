<?php
global $conn;
if (!isset($_COOKIE['visCounter'])) {
    $time = time();
    $currentTime = date("Y-m-d H:i:s", $time);
    $sql = "INSERT INTO visitor(visitDate) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $currentTime);
    $stmt->execute();
    $stmt->close();
    setcookie('visCounter', "is counted",
        time() + (60 * 60 * 24), "/"); // 1 nap

}


