<?php
$userdb = "root";
$pass = "";
$db = "Exam";
$host = "localhost";

// Create a connection to MySQL using mysqli
$conn = mysqli_connect($host, $userdb, $pass, $db);

// Check if the connection was successful
if (!$conn) {
    die("Could not connect to MySQL database: " . mysqli_connect_error());
}

// Select the database
if (!mysqli_select_db($conn, $db)) {
    die("Could not open $db: " . mysqli_error($conn));
}
