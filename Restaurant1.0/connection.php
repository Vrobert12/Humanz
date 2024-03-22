<?php

session_start();
$server="localhost";
$user="root";
$pass="";
$base="restaurant";
$conn=mysqli_connect($server,$user,$pass,$base);

if(!$conn){
    die ("Hiba");
}