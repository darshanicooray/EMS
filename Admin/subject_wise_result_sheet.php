<?php
session_start();
if (!(isset($_SESSION['EMP_Number']) && $_SESSION['EMP_Number'] != '')) {
  header("Location: index.php");
  exit(); // Add exit to prevent further execution
}
include('database.php');

// Check if degree code, semester, and year parameters are set
if (isset($_GET['degreeCode'], $_GET['semester'], $_GET['year'])) {
  // Sanitize input to prevent SQL injection
  $degreeCode = mysqli_real_escape_string($conn, $_GET['degreeCode']);
  $semester = mysqli_real_escape_string($conn, $_GET['semester']);
  $year = mysqli_real_escape_string($conn, $_GET['year']);

  // Query to fetch subjects based on degree code, semester, and year
  $query = "SELECT * FROM subjects WHERE Degree_Code = '$degreeCode' AND Semester = '$semester' AND Year = '$year'";
  $result = mysqli_query($conn, $query);

  if ($result) {
    $subjects = array();
    // Fetch subjects and store them in an array
    while ($row = mysqli_fetch_assoc($result)) {
      $subjects[] = $row;
    }
    // Convert the array to JSON and echo it (to be received by the AJAX request)
    echo json_encode($subjects);
    exit(); // Add exit after echoing JSON response
  } else {
    // Handle query error
    echo "Error: " . mysqli_error($conn);
    exit(); // Add exit after error message
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

          <!-- ... -->

          <!-- form start -->
          <br>
          <form enctype="multipart/form-data" class="form-horizontal" name="myform" method="get" action="">
            <div class="card-body">



              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Faculty </label>
                <div class="col-sm-2">
                  <select class="form-control" name="faculty" onchange="loadDepartment()">
                    <option value="" selected="selected">-- Please Select --</option>
                    <?php

                    $query = "SELECT * FROM  faculty";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result)) {
                      $faculty_code = $row['faculty_code'];
                    ?>
                      <option value="<?php echo $row['faculty_code']; ?>"><?php echo $row['faculty_code']; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Department </label>
                <div class="col-sm-2">
                  <select id="Department_list" class="form-control" name="department" onchange="loaddegree()">
                    <!-- Degrees will be loaded dynamically via AJAX -->
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Degree</label>
                <div class="col-sm-2">
                  <select id="degree_list" class="form-control" name="degree">
                    <!-- Degrees will be loaded dynamically via AJAX -->
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Academic_Year</label>
                <div class="col-sm-2">

                  <select class="form-control" name="Academic_Year">

                    <option value="" selected="selected">-- Please Select --</option>
                    <?php
                    $query = "SELECT * FROM year";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result)) {
                      $row['year'];

                    ?>
                      <option value="<?php echo $row['year']; ?>"><?php echo $row['year']; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Semester</label>
                <div class="col-sm-2">
                  <select class="form-control" name="Semester" onchange="loadSubjects()">
                    <option value="" selected="selected">-- Please Select --</option>
                    <?php
                    $query = "SELECT * FROM semester";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result)) {
                      $row['Semester'];

                    ?>
                      <option value="<?php echo $row['Semester']; ?>"><?php echo $row['Semester']; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>


              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Subject Code</label>
                <div class="col-sm-2">
                  <select id="subject_list" class="form-control" name="Subject_Code">
                    <!-- Subjects will be loaded dynamically via AJAX -->
                  </select>
                </div>
              </div>




              <button type="submit" name="submit" class="btn btn-block btn-primary btn-sm" style="float:left; width: 15%; margin-left: 20px;">Search</button>
              <br>
              <hr>
              <h5>Subject Details </h5>
              <table id="example2" class="table table-bordered ">
                <thead>
                  <tr>
                    <td>Intake</td>
                    <td>Semester</td>
                    <td>Subject Code</td>
                    <td></td>
                    <td></td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Check if the indexes are set before using them in the query degree
                  if (isset($_GET['Subject_Code'], $_GET['Academic_Year'], $_GET['Semester'], $_GET['degree'])) {
                    $query = "SELECT * FROM subjects WHERE 
                      Subject_Code = '{$_GET['Subject_Code']}' AND
                      Intake = '{$_GET['Academic_Year']}' AND
                      Degree_Code = '{$_GET['degree']}' AND
                      Semester = '{$_GET['Semester']}'";

                    $result = mysqli_query($conn, $query);

                    // Check if the query was successful before fetching the results
                    if ($result) {
                      while ($row = mysqli_fetch_array($result)) {
                        $Subject_Code =  $row['Subject_Code'];
                        $Intake =  $row['Intake'];
                        $degree =  $row['Degree_Code'];
                        $Semester =  $row['Semester'];

                        // Display your table rows
                  ?>
                        <tr class="selectable-row">
                          <td><?php echo $row['Intake']; ?></td>
                          <td><?php echo $row['Semester']; ?></td>
                          <td><?php echo $row['Subject_Code']; ?></td>
                          <td>
                            <a href="subject_wise_reports.php?Subject_Code=<?php echo $Subject_Code ?>&Intake=<?php echo $Intake ?>&Semester=<?php echo $Semester ?>" class="btn btn-block btn-primary btn-sm">Full Detail Report </a>
                          </td>
                          <td>
                            <a href="student_marks_report.php?Subject_Code=<?php echo $Subject_Code ?>&Intake=<?php echo $Intake ?>&Semester=<?php echo $Semester ?>" target="_blank" class="btn btn-block btn-primary btn-sm">Detail Report in pdf</a>
                          </td>
                          <td>
                            <a href="Grade_counting_report.php?Subject_Code=<?php echo $Subject_Code ?>&Intake=<?php echo $Intake ?>&Semester=<?php echo $Semester ?>" target="_blank" class="btn btn-block btn-primary btn-sm">Grade counting Report in pdf</a>
                          </td>
                        </tr>
                  <?php
                      }
                    } else {
                      // Handle the case where the query fails
                      echo "Query failed: " . mysqli_error($conn);
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

  <script>
    function loadSubjects() {
      var semester = $('select[name="Semester"]').val();
      var academic_year = $('select[name="Academic_Year"]').val();
      var degree = $('select[name="degree"]').val();

      //alert("Selected degree: " + degree);

      $.ajax({
        url: 'fetch_subjects_HOD.php',
        type: 'POST',
        data: {
          semester: semester,
          academic_year: academic_year,
          degree: degree

        },
        success: function(response) {
          $('#subject_list').html(response);
        }
      });
    }

    function loaddegree() {
      var department = $('select[name="department"]').val();
      // Debugging: Alert the selected department
      // alert("Selected department: " + department);
      $.ajax({
        url: 'fetch_degree_Dean.php',
        type: 'POST',
        data: {
          department: department,
        },
        success: function(response) {
          $('#degree_list').html(response);
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    }

    function loadDepartment() {
      var faculty = $('select[name="faculty"]').val();
      // Debugging: Alert the selected department
      // alert("Selected faculty: " + faculty);
      $.ajax({
        url: 'fetch_department.php',
        type: 'POST',
        data: {
          faculty: faculty,
        },
        success: function(response) {
          $('#Department_list').html(response);
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    }
  </script>
</body>

</html>