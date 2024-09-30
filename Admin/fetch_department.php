<?php
session_start();
include('database.php');


if (isset($_POST['faculty'])) {
    $faculty = $_POST['faculty'];


    $query = "SELECT * FROM department WHERE faculty_code = '$faculty'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $options = '<option value="">Select Department</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            // Concatenate subject code and subject name
            $option_text = $row['department_code'] . ' - ' . $row['department_name'];
            $options .= '<option value="' . $row['department_code'] . '">' . $option_text . '</option>';
        }
        echo $options;
    } else {
        echo '<option value="">No department Found</option>';
    }
} else {
    echo '<option value="">Error: Incomplete Data</option>';
}
