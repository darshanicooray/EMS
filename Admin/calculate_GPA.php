<?php
session_start();
if (!(isset($_SESSION['EMP_Number']) && $_SESSION['EMP_Number'] != '')) {
  header("Location: index.php");
  exit; // Added to stop further execution if user is not logged in
}

include('database.php');

function calculateGPA($regNo, $semester, $conn)
{
  // Fetch marks for the specified student and semester
  $query = "SELECT * FROM marks WHERE RegNum = '$regNo' AND Semester = 'Semester" . str_pad($semester, 2, '0', STR_PAD_LEFT) . "'";
  $result = mysqli_query($conn, $query);

  // Initialize variables to calculate GPA
  $totalGradePoints = 0;
  $totalCredits = 0;

  // Debugging: Print the query to check if it's retrieving the correct data
  //echo "Debug: SQL Query - $query<br>";

  // Loop through the marks and calculate grade points
  while ($row = mysqli_fetch_assoc($result)) {
    // Fetch credit value from subjects table
    $subjectCode = $row['SubjectCode'];
    $subjectQuery = "SELECT Credits FROM subjects WHERE Subject_Code = '$subjectCode'";
    $subjectResult = mysqli_query($conn, $subjectQuery);
    $subjectRow = mysqli_fetch_assoc($subjectResult);
    $credits = $subjectRow['Credits'];

    // Debugging: Print the credit value to check if it's retrieved correctly
    // echo "Debug: Credits for Subject $subjectCode - $credits<br>";

    // Calculate grade points based on the marks obtained
    $gradePoints = calculateGradePoints($row['TotalMarks']);

    // Debugging: Print the grade points to check if they are calculated correctly
    // echo "Debug: Grade Points for Subject $subjectCode - $gradePoints<br>";

    // Accumulate total grade points and total credits
    $totalGradePoints += ($gradePoints * $credits);
    $totalCredits += $credits;
  }

  // Debugging: Print the total credits and grade points to check if they are correct
  //echo "Debug: Total Credits - $totalCredits, Total Grade Points - $totalGradePoints<br>";

  // Calculate GPA
  if ($totalCredits > 0) {
    $gpa = $totalGradePoints / $totalCredits;
    // Round GPA to 2 decimal places
    $gpa = round($gpa, 2);
  } else {
    // Handle division by zero if no credits available
    $gpa = 0;
  }

  // Debugging: Print the calculated GPA to check if it's correct
  //echo "Debug: Calculated GPA - $gpa<br>";





  return $gpa;
}


function calculateGradePoints($marks)
{
  // Your logic to assign grade points based on marks
  if ($marks >= 85) {
    return 4.2;
  } elseif ($marks >= 75) {
    return 4.0;
  } elseif ($marks >= 70) {
    return 3.7;
  } elseif ($marks >= 65) {
    return 3.3;
  } elseif ($marks >= 60) {
    return 3.0;
  } elseif ($marks >= 55) {
    return 2.7;
  } elseif ($marks >= 50) {
    return 2.3;
  } elseif ($marks >= 45) {
    return 2.0;
  } elseif ($marks >= 40) {
    return 1.7;
  } elseif ($marks >= 35) {
    return 1.3;
  } elseif ($marks >= 0 && $marks < 35) {
    return 0.0;
  } else {
    return 0.0; // Invalid marks, consider as 0 grade points
  }
}

// Function to determine class based on GPA
function calculateClass($gpa)
{
  if ($gpa >= 3.70) {
    return "First Class";
  } elseif ($gpa >= 3.30 && $gpa < 3.70) {
    return "Second Class (Upper Division)";
  } elseif ($gpa >= 3.00 && $gpa < 3.30) {
    return "Second Class (Lower Division)";
  } elseif ($gpa >= 2.00 && $gpa < 3.00) {
    return "Pass";
  } else {
    return "Fail"; // Handle cases where GPA is below 2.00 (considered as fail)
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
    <?php include('Side_menu_admin.php');
    ?>

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
            <h3 class="card-title">Calculate GPA</h3>
          </div>

          <!-- ... -->

          <!-- form start -->
          <br>
          <form enctype="multipart/form-data" class="form-horizontal" name="myform" method="post" action="">
            <div class="card-body">
              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Academic Year</label>
                <div class="col-sm-2">

                  <select class="form-control" name="Academic_Year">
                    <option value="" selected="selected">-- Please Select --</option>
                    <?php
                    $query = "SELECT * FROM year";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result)) {
                      echo "<option value='" . $row['year'] . "'>" . $row['year'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Degree</label>
                <div class="col-sm-2">
                  <select class="form-control" name="Degree">
                    <option value="" selected="selected">-- Please Select --</option>
                    <?php
                    $query = "SELECT * FROM degree";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result)) {
                      echo "<option value='" . $row['Degree_Code'] . "'>" . $row['Degree_Name'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <button type="submit" name="submit" class="btn btn-block btn-primary btn-sm" style="float:left; width: 15%; margin-left: 20px;">Calculate GPA</button>
              <br>
              <hr>
              <h5>Student Details</h5>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Reg No</th>
                    <th>Name</th>
                    <th>Average GPA</th>
                    <th>Class</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (isset($_POST['submit'])) {
                    // Retrieve form data
                    $academicYear = $_POST['Academic_Year'];
                    $degreeProgram = $_POST['Degree'];

                    // Fetch student details
                    $query = "SELECT RegNo, Name_with_int FROM student_details WHERE Degree_code = '$degreeProgram' AND year = '$academicYear'";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                      // Loop through each student
                      while ($row = mysqli_fetch_assoc($result)) {
                        // Calculate GPA and class for each semester
                        $semesters = 8; // Assuming there are 8 semesters
                        $gpa_total = 0; // Total GPA for all semesters
                        for ($semester = 1; $semester <= $semesters; $semester++) {
                          $gpa = calculateGPA($row['RegNo'], $semester, $conn);
                          $gpa_total += $gpa;
                        }
                        // Calculate average GPA
                        $average_gpa = number_format($gpa_total / $semesters, 2);
                        $class = calculateClass($average_gpa);

                        // Insert GPA details into gpa_marks table
                        $nameQuery = "SELECT Name_with_int FROM student_details WHERE RegNo = '{$row['RegNo']}'";
                        $nameResult = mysqli_query($conn, $nameQuery);
                        $nameRow = mysqli_fetch_assoc($nameResult);
                        $name = $nameRow['Name_with_int'];

                        // Check if the GPA record already exists
                        $checkQuery = "SELECT * FROM gpa_marks WHERE RegNo = '{$row['RegNo']}' ";
                        $checkResult = mysqli_query($conn, $checkQuery);

                        // If no existing record found, insert the new record
                        if (mysqli_num_rows($checkResult) == 0) {
                          $insertQuery = "INSERT INTO gpa_marks (RegNo, Name_with_int, GPA, Class) VALUES ('$row[RegNo]', '$name',  '$average_gpa', '$class')";
                          mysqli_query($conn, $insertQuery);
                        }

                        // Display student details with average GPA
                        echo "<tr>";
                        echo "<td>{$row['RegNo']}</td>";
                        echo "<td>{$row['Name_with_int']}</td>";
                        echo "<td>{$average_gpa}</td>";
                        echo "<td>{$class}</td>";
                        echo "</tr>";
                      }
                    } else {
                      echo "No students found.";
                    }
                  }
                  ?>

                </tbody>
              </table>

            </div>
          </form>
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
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="plugins/jszip/jszip.min.js"></script>
  <script src="plugins/pdfmake/pdfmake.min.js"></script>
  <script src="plugins/pdfmake/vfs_fonts.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- Page specific script -->
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>

</body>

</html>