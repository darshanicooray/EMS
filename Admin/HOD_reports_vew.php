<?php
session_start();
if (!(isset($_SESSION['EMP_Number']) && $_SESSION['EMP_Number'] != '')) {
    header("Location: index.php");
}
include('database.php');

// Get values from the URL parameters
$subjectCode = $_GET['Subject_Code'];
$Intake = $_GET['Intake'];
$Semester = $_GET['Semester'];

// Function to fetch subject details
function getSubjectDetails($subjectCode)
{
    global $conn;

    $query = "SELECT subjects.*, degree.Degree_Name
    FROM subjects
    JOIN degree ON subjects.Degree_Code = degree.Degree_Code
    WHERE subjects.Subject_Code = '$subjectCode'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    return $row;
}

// Function to fetch student marks data from the database
function getStudentMarksData($subjectCode, $Intake, $Semester)
{
    global $conn;

    $query = "SELECT RegNum, AssignmentMarks, FinalMarks, TotalMarks, Grade FROM marks WHERE SubjectCode = '$subjectCode' AND Intake = '$Intake' AND Semester = '$Semester'";
    $result = mysqli_query($conn, $query);

    $marksData = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $marksData[] = $row;
    }

    return $marksData;
}

// Function to count the number of students
function getNumberOfStudents($subjectCode, $Intake, $Semester)
{
    global $conn;

    $query = "SELECT COUNT(*) AS num_students FROM marks WHERE SubjectCode = '$subjectCode' AND Intake = '$Intake' AND Semester = '$Semester'";
    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);

    return $row['num_students'];
}

// Fetch subject details
$subjectDetails = getSubjectDetails($subjectCode);

// Fetch student marks data
$marksData = getStudentMarksData($subjectCode, $Intake, $Semester);

// Get the number of students
$numStudents = getNumberOfStudents($subjectCode, $Intake, $Semester);

// Count number of 'A' grades
$gradeCounts = array(
    'A+' => 0,
    'A' => 0,
    'A-' => 0,
    'B+' => 0,
    'B' => 0,
    'B-' => 0,
    'C+' => 0,
    'C' => 0,
    'C-' => 0,
    'D' => 0,
    'F' => 0
);

foreach ($marksData as $row) {
    if (isset($gradeCounts[$row['Grade']])) {
        $gradeCounts[$row['Grade']]++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="images/Kdu.ico">
    <title>KDU-Examination Management System</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        .details strong {
            width: 200px;
            display: inline-block;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <?php include('top_manu.php'); ?>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <?php include('Side_menu_admin.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- Display Subject Details -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Reports </h3>
                        </div>
                        <br>

                        <div class="card-body" style="text-align: left; font-family: 'Times New Roman', Times, serif; text-align: center; font-size: 14px; line-height: 1.0;">
                            <img src="images/Kotelawala_Defence_University_crest.png" alt="University Logo" width="100">
                            <h3>General Sir John Kotelawala Defence University</h3>
                            <h3>Detailed Marked Sheet</h3>

                            <div class="details" style="text-align: left;">
                                <p><strong>Subject:</strong> <?php echo $subjectDetails['Subject_Code'] . ' - ' . $subjectDetails['Subject_Name']; ?></p>
                                <p><strong>Degree:</strong> <?php echo $subjectDetails['Degree_Name']; ?></p>
                                <p><strong>Intake:</strong> <?php echo $Intake; ?></p>
                                <p><strong>Assignment Allocation:</strong> <?php echo $subjectDetails['Assignment_allo']; ?>%</p>
                                <p><strong>Final Allocation:</strong> <?php echo $subjectDetails['Final_allo']; ?>%</p>
                                <p><strong>Number of Students:</strong> <?php echo $numStudents; ?></p>
                            </div>

                            <!-- Bar Chart -->
                            <canvas id="gradeChart" width="400" height="200"></canvas>

                            <!-- Data Table -->
                            <table>
                                <tr>
                                    <th>Reg No</th>
                                    <th>Assignment Marks</th>
                                    <th>Final Marks</th>
                                    <th>Total Marks</th>
                                    <th>Grade</th>
                                </tr>
                                <?php foreach ($marksData as $row) : ?>
                                    <tr>
                                        <td><?php echo $row['RegNum']; ?></td>
                                        <td><?php echo $row['AssignmentMarks']; ?></td>
                                        <td><?php echo $row['FinalMarks']; ?></td>
                                        <td><?php echo $row['TotalMarks']; ?></td>
                                        <td><?php echo $row['Grade']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>

                        </div>
                    </div>

                </div>
            </section>
        </div>

        <!-- /.content-wrapper -->
        <?php include('main-footer.php'); ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    <!-- ChartJS Script for Bar Chart -->
    <script>
        var ctx = document.getElementById('gradeChart').getContext('2d');
        var gradeChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D', 'F'],
                datasets: [{
                    label: '# of Students',
                    data: [
                        <?php echo $gradeCounts['A+']; ?>,
                        <?php echo $gradeCounts['A']; ?>,
                        <?php echo $gradeCounts['A-']; ?>,
                        <?php echo $gradeCounts['B+']; ?>,
                        <?php echo $gradeCounts['B']; ?>,
                        <?php echo $gradeCounts['B-']; ?>,
                        <?php echo $gradeCounts['C+']; ?>,
                        <?php echo $gradeCounts['C']; ?>,
                        <?php echo $gradeCounts['C-']; ?>,
                        <?php echo $gradeCounts['D']; ?>,
                        <?php echo $gradeCounts['F']; ?>
                    ],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
</body>

</html>