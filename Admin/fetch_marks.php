

<?php
include('database.php');

$subjectCode = $_GET['subjectCode'];
$intake = $_GET['intake'];
$semester = $_GET['semester'];

$query = "SELECT * FROM marks WHERE SubjectCode='$subjectCode' AND Intake='$intake' AND Semester='$semester'";
$result = mysqli_query($conn, $query);

$marksData = array();

while ($row = mysqli_fetch_assoc($result)) {
    $marksData[] = $row;
}

$response = array('status' => 'success', 'data' => $marksData);
echo json_encode($response);

mysqli_close($conn);
?>
