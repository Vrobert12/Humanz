<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add table</title>
    <link rel="stylesheet" href="SideStyle.css">
</head>
<body>
<form method="post" action="functions.php" class="mainForm">
    <h2>Add Table</h2>
    <label for="book">Table capacity:</label><br>
    <input type="number" class="inputok" placeholder="Capacity" name="cap" id="cap"><br>
    <label for="ar">Area:</label><br>
    <input type="text" class="inputok" placeholder="Area" name="ar" id="ar"><br>
    <label for="ar">Is smoking area: </label>
    <input type="checkbox" class="inputok" name="sm" id="sm"><br>
    <input type="submit" class="inputok" name="action" value="AddTable">
</form>
</body>
</html>
