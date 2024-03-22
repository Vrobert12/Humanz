<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="School Project">
    <meta name="keywords" content="HTML, CSS, PHP, SQL">
    <meta name="author" content="Robert Varro">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="kliens.css";>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@100&display=swap" rel="stylesheet">
    <title>Felhasználók adatai</title>
    
</head>
<body>
<h1>Üdvözöljuk a VBob árúházban!</h1>
<div class="pBorder">
    <h2>Információ rólunk!</h2>
<p>Ebben az áruházban számítógépes kellékeket árulunk, alkatrészektől kezdve,<br> komplett gaming PC-ig.
Az oldalon a termék neve, illletve típusa alapján a felhasználó, <br>
 kényelmesen keresheti az oldalunkkon lévő termékeket.<br>
<p>Elérhetőségek: <address>robertvarro12@gmail.com</address></p>
</div>
<div class="searchDiv">
    <form class="search" action="kliens.php" method="post">

    <label for="termek_nev">Termék Neve:</label><br>
    <input type="text" id="termek_nev" name="termek_nev"><br>

    <button type="submit" name="action" value="termek">Keresés</button>
    <button type="submit" name="action" value="clear">Keresés törlése</button>
    
</form>
<form class="search" action="kliens.php" method="post">

    <label for="termek_tipus">Termék Típus:</label><br>
    <input type="text" id="termek_tipus" name="termek_tipus"><br>

    <button type="submit" name="action" value="tipus">Keresés</button>
    <button type="submit" name="action" value="clear">Keresés törlése</button>
    
</form>
</div>
<?php
include 'db_config.php';

function displayUsers() {
    
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

   
    if ($conn->connect_error) {
        die("A kapcsolat sikertelen: " . $conn->connect_error);
    }

    if (isset($_POST['action']) && $_POST['action'] == 'termek') {
       
        $termek_nev = $_POST['termek_nev'];
        $sql = "SELECT * FROM it WHERE termek_nev LIKE '%$termek_nev%'";
    }
    elseif (isset($_POST['action']) && $_POST['action'] == 'tipus') {
        
        $termek_tipus = $_POST['termek_tipus'];
        $sql = "SELECT * FROM it WHERE termek_tipus LIKE '%$termek_tipus%'";
    } 
    else {
       
        $sql = "SELECT * FROM it";
    }
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<h1>A termékeink adatai</h1>";
        echo "<table>";
        echo "<tr><th>Terméknév</th><th>Terméktípus</th><th>Ár</th><th>Gyártó</th><th>Kép</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>"; 
            echo "<td>" . $row['termek_nev'] . "</td>";
            echo "<td>" . $row['termek_tipus'] . "</td>";
            echo "<td>" . $row['termek_ar'] . "</td>";
            echo "<td>" . $row['termek_gyarto'] . "</td>";
            echo "<td><img src='" . $row['kep'] . "." . $row['kep_dir'] . "' alt='Termék'></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Nincs elérhető felhasználó adat.";
    }

    $conn->close();
}


displayUsers();
?>

</body>
</html>