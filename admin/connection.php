<?php
$hostname = "localhost";
$username = "root";
$password = "";
$db = "nature";
$conn = mysqli_connect($hostname, $username, $password, $db);

if (!$conn) 
{
    echo("Database not connected");
}

?>