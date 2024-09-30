<?php
session_start();
include('database.php');

$msg = '';
if (isset($_POST['submit']) && $_POST['submit'] == 'Login') {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$query = "SELECT * FROM employee WHERE EMP_Number='$username' AND password='$password'";
	$res = mysqli_query($conn, $query);

	if (!$res) {
		die("Query failed: " . mysqli_error($conn)); // Check for query execution errors
	}

	$count = mysqli_num_rows($res);

	if ($count == 1) {
		$row = mysqli_fetch_assoc($res); // Fetch a single row
		$_SESSION['EMP_Number'] = $row['EMP_Number']; // Store EMP_Number in session
		$_SESSION['Name_With_Initials'] = $row['Name_With_Initials'];
		$_SESSION['user_type'] = $row['user_type'];
		header("location: menu_admin.php");
	} else {
		$error = "Your Login Name or Password is invalid";
		header("location: index.php?msg=" . urlencode($error));
	}
}
