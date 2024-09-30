<?php
session_start();
include('database.php');

if (isset($_POST['semester'], $_POST['academic_year'],  $_POST['degree'])) {
    $semester = $_POST['semester'];
    $academic_year = $_POST['academic_year'];
    $degree = $_POST['degree'];

    echo $query = "SELECT * FROM lecturer_subjects WHERE Degree_Code	='$degree' AND Intake='$academic_year' AND Semester='$semester' AND AR_approval='1'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $options = '<option value="">Select Subject</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            // Concatenate subject code and subject name
            $option_text = $row['Subject_Code'] . ' - ' . $row['Subject_Name'];
            $options .= '<option value="' . $row['Subject_Code'] . '">' . $option_text . '</option>';
        }
        echo $options;
    } else {
        echo '<option value="">No Subjects Found</option>';
    }
} else {
    echo '<option value="">Error: Incomplete Data</option>';
}
