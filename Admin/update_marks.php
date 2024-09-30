<?php
session_start();

// Check if the user is logged in
if (!(isset($_SESSION['EMP_Number']) && $_SESSION['EMP_Number'] != '')) {
    // You may want to handle unauthorized access here, such as redirecting to a login page
    echo json_encode(array("success" => false, "message" => "Unauthorized access"));
    exit();
}

// Include necessary files
include('database.php'); // Replace this with your actual database connection code

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Decode the JSON data sent in the request body
    $data = json_decode(file_get_contents("php://input"));

    // Validate if the required fields are present in the JSON data
    if (!isset($data->approver)) {
        echo json_encode(array("success" => false, "message" => "Missing data"));
        exit();
    }

    // Get the approver type from the JSON data
    $approver = $data->approver;

    // Perform the update query to mark all student marks as approved by the specified approver
    $query = "UPDATE marks SET {$approver}_approval = 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo json_encode(array("success" => true, "message" => "All student marks updated with $approver Approval"));
    } else {
        echo json_encode(array("success" => false, "message" => "Failed to update student marks"));
    }
} else {
    // If the request method is not POST, return an error message
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}
