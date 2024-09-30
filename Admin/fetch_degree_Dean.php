<?php
session_start();
include('database.php');


if (isset($_POST['department'])) {
    echo   $department = $_POST['department'];


    $query = "SELECT * FROM degree WHERE department_code = '$department'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $options = '<option value="">Select Subject</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            // Concatenate subject code and subject name
            $option_text = $row['Degree_Code'] . ' - ' . $row['Degree_Name'];
            $options .= '<option value="' . $row['Degree_Code'] . '">' . $option_text . '</option>';
        }
        echo $options;
    } else {
        echo '<option value="">No Subjects Found</option>';
    }
} else {
    echo '<option value="">Error: Incomplete Data</option>';
}
