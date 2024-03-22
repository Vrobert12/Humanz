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

<h1>Adminisztrációs oldal</h1>
<div class="formDiv">
<form class="formok" action="function.php" method="post" enctype="multipart/form-data">

<h2>Új termék bevitele</h2>

    <label for="termek_nev">Termék Neve:</label>
    <input type="text" id="termek_nev" name="termek_nev" required><br>

    <label for="termek_tipus">Termék Tipus:</label>
    <input type="text" id="termek_tipus" name="termek_tipus" required><br>

    <label for="termek_ar">Ár:</label>
    <input type="number" id="termek_ar" name="termek_ar" required><br>

    <label for="termek_gyarto">Gyártó:</label>
    <input type="text" id="termek_gyarto" name="termek_gyarto" required><br>

    <label for="fileToUpload">Kép:</label>
    <input type="file" name="fileToUpload" id="fileToUpload" accept="image/png, image/jpeg" required><br>

    <button type="submit" name="action" value="submit">Insert</button>

</form>
<br><br>

<form class="formok" action="function.php" method="post" enctype="multipart/form-data">

<h2>Termék adatainak módosítása</h2>

    <label for="termek_id">Termék ID:</label>
    <input type="text" id="termek_id" name="termek_id" required ><br>

    <label for="termek_nev">Termék Neve:</label>
    <input type="text" id="termek_nev" name="termek_nev"><br>

    <label for="termek_tipus">Termék Tipus:</label>
    <input type="text" id="termek_tipus" name="termek_tipus"><br>

    <label for="termek_ar">Ár:</label>
    <input type="number" id="termek_ar" name="termek_ar"><br>

    <label for="termek_gyarto">Gyártó:</label>
    <input type="text" id="termek_gyarto" name="termek_gyarto"><br>

    <label for="kep">Kép:</label>
    <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*"><br>


    <button type="submit" name="action" value="update">Update</button>

</form><br><br>
<form class="formok" action="function.php" method="post">

<h2>Termék törlése az adatbázisból</h2>

    <label for="termek_id">Termék ID:</label>
    <input type="text" id="termek_id" name="termek_id" required ><br>


    <button type="submit" name="action" value="delete">Delete</button>
</form>
</div>
<h1>A termékeink adatai</h1>
<div class="searchDiv">

<form class="search" action="action.php" method="post">

    <label for="termek_nev">Termék Neve:</label>
    <input type="text" id="termek_nev" name="termek_nev"><br>

    <button type="submit" name="action" value="termek">Keresés</button>
    <button type="submit" name="action" value="clear">Keresés törlése</button>
    
</form>
<form class="search" action="action.php" method="post">

    <label for="termek_tipus">Termék Típus:</label>
    <input type="text" id="termek_tipus" name="termek_tipus"><br>

    <button type="submit" name="action" value="tipus">Keresés</button>
    <button type="submit" name="action" value="clear">Keresés törlése</button>
    
</form></div>
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
        echo "<table class=\"table2\">";
        echo "<tr><th>ID</th><th>Terméknév</th><th>Terméktípus</th><th>Ár</th><th>Gyártó</th><th>Kép</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['termek_id'] . "</td>";
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
