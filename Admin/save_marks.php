<?php
session_start();

// Include your database connection file
include('database.php'); // Adjust the filename as needed

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the POST request
    $regNum = $_POST['regNum'];
    $subjectCode = $_POST['subjectCode'];
    $intake = $_POST['intake'];
    $semester = $_POST['semester'];
    $assignmentMarks = $_POST['assignmentMarks'];
    $finalMarks = $_POST['finalMarks'];
    $totalMarks = $_POST['totalMarks'];
    $grade = $_POST['grade'];

    // Check if a record with the given regNum, subjectCode, intake, and semester already exists
    $checkQuery = "SELECT * FROM marks WHERE RegNum='$regNum' AND SubjectCode='$subjectCode' AND Intake='$intake' AND Semester='$semester'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Update the existing record
        $updateQuery = "UPDATE marks SET AssignmentMarks='$assignmentMarks', FinalMarks='$finalMarks', TotalMarks='$totalMarks', Grade='$grade' WHERE RegNum='$regNum' AND SubjectCode='$subjectCode' AND Intake='$intake' AND Semester='$semester'";

        if (mysqli_query($conn, $updateQuery)) {
            // Update successful
            $response = array('status' => 'success', 'message' => 'Marks updated successfully');
        } else {
            // Update failed
            $response = array('status' => 'error', 'message' => 'Error updating marks: ' . mysqli_error($conn));
        }
    } else {
        // Insert a new record
        $insertQuery = "INSERT INTO marks (RegNum, SubjectCode, Intake, Semester, AssignmentMarks, FinalMarks, TotalMarks, Grade) VALUES ('$regNum', '$subjectCode', '$intake', '$semester', '$assignmentMarks', '$finalMarks', '$totalMarks', '$grade')";

        if (mysqli_query($conn, $insertQuery)) {
            // Insertion successful
            $response = array('status' => 'success', 'message' => 'Marks saved successfully');
        } else {
            // Insertion failed
            $response = array('status' => 'error', 'message' => 'Error saving marks: ' . mysqli_error($conn));
        }
    }

    // Close the database connection
    mysqli_close($conn);

    // Return the response as JSON
    echo json_encode($response);
} else {
    // Invalid request method
    $response = array('status' => 'error', 'message' => 'Invalid request method');
    echo json_encode($response);
}
