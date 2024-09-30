<?php
include('database.php'); // Include your database connection code

// Receive and Process POST Data
$selectedSubjectIDs = isset($_POST['subjects']) ? $_POST['subjects'] : array();
$selectedLecturerIDs = isset($_POST['lecturers']) ? $_POST['lecturers'] : array();

if (empty($selectedSubjectIDs) || empty($selectedLecturerIDs)) {
    $response = array('status' => 'error', 'message' => 'No data to insert.');
} else {
    // Initialize a flag to track if any duplicate combination is found
    $duplicateFound = false;

    // Loop through subject and lecturer combinations and insert them as separate rows
    foreach ($selectedSubjectIDs as $subjectData) {
        $subjectID = $subjectData['id'];
        $subjectName = $subjectData['name'];
        $semester = $subjectData['semester'];
        $intake = $subjectData['intake'];

        foreach ($selectedLecturerIDs as $lecturerData) {
            $lecturerID = $lecturerData['id'];
            $nameWithInitials = $lecturerData['initials'];

            // Check if a row with the same combination already exists
            $sqlCheck = "SELECT * FROM subjectstudent
                         WHERE Subject_Code = '$subjectID' 
                           AND Intake = '$intake' 
                           AND Semester = '$semester' 
                           AND RegNum = '$lecturerID'";

            $result = mysqli_query($conn, $sqlCheck);

            if (mysqli_num_rows($result) > 0) {
                $duplicateFound = true;
            } else {
                $sql = "INSERT INTO subjectstudent (Subject_Code, Intake, Semester, RegNum) 
        VALUES ('$subjectID', '$intake', '$semester', '$lecturerID')";

                $retval = mysqli_query($conn, $sql);

                if (!$retval) {
                    $response = array('status' => 'error', 'message' => 'Could not enter data: ' . mysqli_error($conn));
                    echo json_encode($response);
                    exit;
                }
            }
        }
    }

    // Check if a duplicate combination was found
    if ($duplicateFound) {
        $response = array('status' => 'error', 'message' => 'Record already entered');
    } else {
        $response = array('status' => 'success', 'message' => 'Data inserted successfully.');
    }
}

mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($response);
