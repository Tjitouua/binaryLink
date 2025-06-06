<?php

$dbServerName = "localhost";
$dbuserName = "root";
$dbpassword = "";
$dbname = "binary_link";

if(!$conn = mysqli_connect($dbServerName, $dbuserName, $dbpassword, $dbname)) {
    die("Failed to connect to database!");
}