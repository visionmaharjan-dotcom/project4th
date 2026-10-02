<?php
$hostname = "localhost";
$username = "root";
$password = "";
$db = "nature";

$conn = mysqli_connect($hostname, $username, $password, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

echo "Database connected successfully";
?>