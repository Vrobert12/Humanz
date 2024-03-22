<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="kliens.css">
    <meta name="description" content="School Project">
    <meta name="keywords" content="HTML, CSS, PHP, SQL">
    <meta name="author" content="Robert Varro">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lora&family=Work+Sans:ital,wght@0,100;1,400&display=swap" rel="stylesheet">
    <title>Admminisztratív oldal</title>
</head>
<body>
<?php

include 'db_config.php';

class Functionality {
    public function __construct() {
        $this->run();
    }

    function insert() {
        global $conn;
        $nev = $_POST['termek_nev'];
        $tipus= $_POST['termek_tipus'];
        $ar = $_POST['termek_ar'];
        $gyarto = $_POST['termek_gyarto'];


        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {

            $target_dir = "C:/xampp/xampp/htdocs/pass/pictures/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


            $kep = pathinfo($target_file, PATHINFO_FILENAME);


            $kep_dir = $imageFileType;


        } else {

            $kep = "";
            $kep_dir = "";
            echo "<p>Nincsen kep</p>";
        }


        $sql = "INSERT INTO it (termek_nev, termek_tipus, termek_ar, termek_gyarto, kep, kep_dir) VALUES (?, ?, ?, ?, ?, ?)";


        $stmt = $conn->prepare($sql);


        $stmt->bind_param("ssssss", $nev, $tipus,$ar, $gyarto, $kep, $kep_dir);


        if ($stmt->execute()) {

            echo "Sikeres regisztráció! Köszönjük!";
        } else {
            echo "<p>Hiba történt a regisztráció során: " . $stmt->error."</p>";
            echo "<p>SQL Query: " . $sql."</p>";
        }


        $stmt->close();
    }



    public function update() {
        global $conn;
        $termek_id = $_POST['termek_id'];

        $sql = "SELECT * FROM it WHERE termek_id='$termek_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nev = $row['termek_nev'];
            $tipus = $row['termek_tipus'];
            $ar = $row['termek_ar'];
            $gyarto = $row['termek_gyarto'];
            $kep = $row['kep'];
            $kep_dir = $row['kep_dir'];

            if (!empty($_POST['termek_nev'])) {
                $nev = $_POST['termek_nev'];
            }
            if (!empty($_POST['termek_tipus'])) {
                $tipus = $_POST['termek_tipus'];
            }
            if (!empty($_POST['termek_ar'])) {
                $ar = $_POST['termek_ar'];
            }
            if (!empty($_POST['termek_gyarto'])) {
                $gyarto = $_POST['termek_gyarto'];
            }


            if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
                
                $target_dir = "C:/xampp/xampp/htdocs/pass/pictures/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $kep = pathinfo($target_file, PATHINFO_FILENAME);
                $kep_dir = $imageFileType;

                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

           
                if (!empty($row['kep']) && file_exists($row['kep'])) {
                    unlink($row['kep']);
                }
            }

            $update_sql = "UPDATE it SET termek_nev=?, termek_tipus=? ,termek_ar=?, termek_gyarto=?, kep=?, kep_dir=? WHERE termek_id=?";
            $stmt = $conn->prepare($update_sql);

            if (!$stmt) {
                die("<p>Hiba a felkészülés során: " . $conn->error."</p>");
            }

            
            $stmt->bind_param("ssssssi", $nev, $tipus, $ar, $gyarto, $kep, $kep_dir, $termek_id);

            if ($stmt->execute()) {
                echo "<p>Az adatok sikeresen módosítva lettek.</p>";
            } else {
                echo "<p>Hiba történt az adatok módosítása közben: " . $stmt->error."</p>";
            }

            $stmt->close();
        } else {
            echo "<p>Az alábbbi termék azonosítója nem található, nem tudtuk frissíteni az adatbázist.</p>";
        }
    }

    public function delete() {
        global $conn;
        $termek_id = $_POST['termek_id'];
        $delete_sql = "DELETE FROM it WHERE termek_id='$termek_id'";
        if ($conn->query($delete_sql) === TRUE) {
            if($conn->affected_rows > 0)
            {
            echo "<p>Az adat sikeresen törölve lett!</p>";
        }
            else{
                 echo "<p>Az alábbbi termék azonosítója nem található, nem tudtuk frissíteni az adatbázist.</p>";
                }
        } else {
            echo "<p>Hiba történt az adat törlésekor</p>" . $conn->error;
        }
    }


    
    public function run() {
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
            switch ($action) {
                case 'submit':
                    $this->insert();
                    break;
                case 'delete':
                    $this->delete();
                    break;
                case 'update':
                    $this->update();
                    break;
                
                default:
                    echo "Érvénytelen művelet.";
                    break;
            }
        }
    }
   
}

$functionality = new Functionality();

?>
<br><a href="http://localhost:8080/pass/action.php">Oké</a>
</body>
</html>