<?php
session_start();
include('database.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the row_id is set in the POST data
    if (isset($_POST['row_id'])) {
        $row_id = $_POST['row_id'];

        // Prepare and execute the update query
        $update_query = "UPDATE lecturer_subjects SET AR_approval='1' WHERE id='$row_id'";
        $update_result = mysqli_query($conn, $update_query);

        // Check if the update was successful
        if ($update_result) {
            // Fetch the updated data from the database
            $select_query = "SELECT * FROM lecturer_subjects WHERE id='$row_id'";
            $select_result = mysqli_query($conn, $select_query);

            // Check if the data was fetched successfully
            if ($select_result && mysqli_num_rows($select_result) > 0) {
                // Fetch the updated row as an associative array
                $updated_row = mysqli_fetch_assoc($select_result);

                // Return the updated row data as JSON
                echo json_encode($updated_row);
            } else {
                // If fetching the updated data fails, return an error message
                echo json_encode(array('error' => 'Failed to fetch updated data.'));
            }
        } else {
            // If the update query fails, return an error message
            echo json_encode(array('error' => 'Error updating record: ' . mysqli_error($conn)));
        }
    } else {
        // If row_id is not provided in the POST data, return an error message
        echo json_encode(array('error' => 'Row ID not provided.'));
    }
} else {
    // If the request method is not POST, return an error message
    echo json_encode(array('error' => 'Invalid request method.'));
}
