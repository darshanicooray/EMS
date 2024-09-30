<?php
// Include database connection
include('database.php');

// Check if degree, semester, and academic_year are set in POST
if (isset($_POST['degree'], $_POST['semester'], $_POST['academic_year'])) {
    $degree = $_POST['degree'];
    $semester = $_POST['semester'];
    $academic_year = $_POST['academic_year'];

    // Prepare SQL statement to fetch subjects based on degree, semester, and academic year
    echo  $query = "SELECT * FROM subjects WHERE Degree_Code = '$degree' AND Semester = '$semester' AND Intake = '$academic_year'";
    $result = mysqli_query($conn, $query);

    // Check if there are subjects found
    if (mysqli_num_rows($result) > 0) {
        // Start generating HTML options for subjects
        $options = '<option value="">Select Subject</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            $option_text = $row['Subject_Code'] . ' - ' . $row['Subject_Name'];
            $options .= '<option value="' . $row['Subject_Code'] . '">' . $option_text . '</option>';
        }
        // Return HTML options
        echo $options;
    } else {
        // If no subjects found, return empty option
        echo '<option value="">No Subjects Found</option>';
    }
} else {
    // If degree, semester, and academic_year are not set in POST, return error message
    echo '<option value="">Error: Incomplete Data</option>';
}
