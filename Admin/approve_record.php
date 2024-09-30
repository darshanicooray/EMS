<?php
session_start();
include('database.php');

if (isset($_POST['approve'])) {
    // Retrieve the row ID from the form submission
    $row_id = $_POST['row_id'];

    // Prepare and execute SQL query to update the lecturer_subjects table
    $update_query = "UPDATE lecturer_subjects SET AR_approval='1' WHERE id='$row_id'";
    $update_result = mysqli_query($conn, $update_query);

    // Check if the query was successful
    if ($update_result) {
        // Approval successful
        echo "Approval successful.";
    } else {
        // Approval failed
        echo "Approval failed: " . mysqli_error($conn);
    }
}
