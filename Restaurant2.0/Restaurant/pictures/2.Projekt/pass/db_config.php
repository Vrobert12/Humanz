<?php
$servername = "localhost";
$username = "VRobert12"; 
$password = "Vr13csVr13Vr"; 
$dbname = "it projekt"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("A kapcsolat sikertelen: " . $conn->connect_error);
}


?>