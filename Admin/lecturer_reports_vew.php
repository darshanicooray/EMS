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



// Include necessary files
include('database.php'); // Replace this with your actual database connection code

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

    // Modify the query based on your database schema
    $query = "SELECT RegNum, AssignmentMarks, FinalMarks, TotalMarks, Grade, Semester FROM marks WHERE SubjectCode = '$subjectCode' AND Intake = '$Intake' AND Semester = '$Semester' ORDER BY FinalMarks  ASC";
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

    // Modify the query based on your database schema
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
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

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
                <!-- Navbar Search -->
                <?php include('top_manu.php'); ?>
                <!-- ... -->
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <?php include('Side_menu_admin.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"> </h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                </div>

                <!-- ... -->

                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Reports </h3>
                    </div>
                    <br>
                    <form enctype="multipart/form-data" class="form-horizontal" name="myform" method="post" action="">
                        <?php
                        if (isset($_POST['submit_button'])) {
                            // Insert data into the comments table
                            $insertQuery = "INSERT INTO comments (Subject_Code, year, Semester, Lecturestatus) VALUES ('$subjectCode', '$Intake', '$Semester', '1')";
                            $retval = mysqli_query($conn, $insertQuery);

                            if (!$retval) {
                                die('Could not enter data: ' . mysqli_error($conn));
                            }

                            echo "<div class='alert alert-success alert-dismissible'>
             Successfully Marks submitted
             </div>";
                        }

                        // Fetch lecture status from the comments table
                        $query = "SELECT * FROM comments WHERE Subject_Code = '$subjectCode' AND year = '$Intake' AND Semester = '$Semester'";
                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_assoc($result);
                        $lectureStatus = isset($row) ? $row['Lecturestatus'] : '';
                        $HODsStatus = isset($row) ? $row['HODsStatus'] : '';
                        ?>

                        <div class="card-body" style="text-align: left;  font-family: 'Times New Roman', Times, serif;
            text-align: center;
            font-size: 14px;
            line-height: 1.0;">
                            <img src=" images/Kotelawala_Defence_University_crest.png" alt="University Logo" width="100">
                            <h3>General Sir John Kotelawala Defence University</h3>
                            <h3>Detailed Marked Sheet</h3>

                            <div class="details" style="text-align: left; ">
                                <p><strong>Subject:</strong> <?php echo $subjectDetails['Subject_Code'] . ' - ' . $subjectDetails['Subject_Name']; ?></p>
                                <p><strong>Degree:</strong> <?php echo $subjectDetails['Degree_Name']; ?></p>
                                <p><strong>Intake:</strong> <?php echo $subjectDetails['Intake']; ?></p>
                                <p><strong>Semester:</strong> <?php echo $subjectDetails['Semester']; ?></p>
                                <p><strong>Assignment Allocation:</strong> <?php echo $subjectDetails['Assignment_allo']; ?>%</p>
                                <p><strong>Final Allocation:</strong> <?php echo $subjectDetails['Final_allo']; ?>%</p>
                                <p><strong>Number of Students:</strong> <?php echo $numStudents; ?></p>
                            </div>

                            <table>
                                <tr>
                                    <th>Reg No</th>
                                    <th>Semester</th>
                                    <th>Assignment Marks</th>
                                    <th>Final Marks</th>
                                    <th>Total Marks</th>
                                    <th>Grade</th>
                                </tr>
                                <?php foreach ($marksData as $row) : ?>
                                    <tr>
                                        <td><?php echo $row['RegNum']; ?></td>
                                        <td><?php echo $row['Semester']; ?></td>
                                        <td><?php echo $row['AssignmentMarks']; ?></td>
                                        <td><?php echo $row['FinalMarks']; ?></td>
                                        <td><?php echo $row['TotalMarks']; ?></td>
                                        <td><?php echo $row['Grade']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <br>
                            <br>
                            <div style="text-align: center;">
                                <button type="submit" name="submit_button" class="btn btn-<?php echo $lectureStatus == '1' ? 'success' : 'danger'; ?> btn-sm" style="width: 20%;" <?php if ($lectureStatus == '1') echo 'disabled'; ?>><?php echo $lectureStatus == '1' ? 'Submitted' : 'Lecturer Not Submitted'; ?></button>
                                <button type="submit" name="submit_button" class="btn btn-<?php echo $HODsStatus == '1' ? 'success' : 'danger'; ?> btn-sm" style="width: 20%;" <?php if ($HODsStatus == '1' || $lectureStatus !== '1') echo 'disabled'; ?>>
                                    <?php echo $HODsStatus == '1' ? 'HOD Approved' : 'HOD Not Approved'; ?>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm disabled " style="width: 20%;">DEAN Not Approved</button>
                            </div>
                        </div>

                    </form>
                </div>
                <br>

        </div>

        </section>
    </div>


    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include('main-footer.php'); ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard.js"></script>
</body>

</html>