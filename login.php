<?php
session_start();
include('database.php');

$msg = '';
if (isset($_POST['submit']) == 'Login') { //1
	$username = $_POST['username'];
	$password = $_POST['password'];
	$query = "select * from  student_details where RegNo='$username' and password='$password' ";
	$res = mysqli_query($conn, $query);

	if (!$res) {
		die("Query failed: " . mysqli_error($conn)); // Check for query execution errors
	}

	$count = mysqli_num_rows($res);

	if ($count == 1) {
		$row = mysqli_fetch_assoc($res); // Fetch a single row
		$_SESSION['RegNo'] = $row['RegNo']; // Store EMP_Number in session	
		$_SESSION['Name_with_int'] = $row['Name_with_int'];
		header("location: menu.php");
	} else {
		$error = "Your Username or Password is invalid";
		header("location: index.php?msg=" . urlencode($error));
	}
}
