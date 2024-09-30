<?php
$conn=mysqli_connect("localhost","root","") or die("Could not connect");
mysqli_select_db($conn,"exam") or die("could not connect database");

// Database configuration
/*$dbHost     = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName     = "exam";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}*/

?>