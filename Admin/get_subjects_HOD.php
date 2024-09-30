<?php
// Include your database connection file
include('database.php');

// Check if degree code, semester, and year parameters are set
if (isset($_GET['degreeCode'], $_GET['semester'], $_GET['year'])) {
    // Sanitize input to prevent SQL injection
    $degreeCode = mysqli_real_escape_string($conn, $_GET['degreeCode']);
    $semester = mysqli_real_escape_string($conn, $_GET['semester']);
    $year = mysqli_real_escape_string($conn, $_GET['year']);

    // Query to fetch subjects based on degree code, semester, and year
    $query = "SELECT * FROM subjects WHERE Degree_Code = '$degreeCode' AND Semester = '$semester' AND Year = '$year'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $subjects = array();
        // Fetch subjects and store them in an array
        while ($row = mysqli_fetch_assoc($result)) {
            $subjects[] = $row;
        }
        // Convert the array to JSON and echo it (to be received by the AJAX request)
        echo json_encode($subjects);
    } else {
        // Handle query error
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Handle missing parameters error
    echo "Error: Missing parameters";
}
