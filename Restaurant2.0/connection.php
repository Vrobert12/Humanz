<?php

session_start();
$server="127.0.0.1";
$user="root";
$pass="";
$base="restaurant";
$conn=mysqli_connect($server,$user,$pass,$base);

if(!$conn){
    die ("Hiba");
}