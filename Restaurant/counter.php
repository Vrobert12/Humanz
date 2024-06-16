<?php
global $conn;

$query = mysqli_query($conn,"SELECT count(*) from visitor");
echo '<a style="color: #ffffff">Visit Count: ' . $query->fetch_array(MYSQLI_NUM)[0] . '</a>';

