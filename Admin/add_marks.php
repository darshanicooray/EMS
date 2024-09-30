<?php
session_start();
if (!(isset($_SESSION['EMP_Number']) && $_SESSION['EMP_Number'] != '')) {
  header("Location: index.php");
}
include('database.php');

// Define default button disabled state
$addMarksButtonDisabled = '';

// Check if all necessary parameters are set
if (isset($_GET['Subject_Code'], $_GET['Academic_Year'], $_GET['Semester'])) {
  // Construct the query to check conditions in the comments table
  $query = "SELECT * FROM comments WHERE year = '{$_GET['Academic_Year']}' AND Subject_Code = '{$_GET['Subject_Code']}' AND Semester = '{$_GET['Semester']}' AND Lecturestatus = '1'";
  $result = mysqli_query($conn, $query);

  // Check if the conditions are met
  if ($result && mysqli_num_rows($result) > 0) {
    // Disable the button if the conditions are met
    $addMarksButtonDisabled = 'disabled';
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
            <h3 class="card-title">Enter Marks</h3>
          </div>

          <!-- ... -->

          <!-- form start -->
          <br>
          <form enctype="multipart/form-data" class="form-horizontal" name="myform" method="get" action="">
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
                <label for="inputEmail3" class="col-sm-2 col-form-label">Semester</label>
                <div class="col-sm-2">
                  <select class="form-control" name="Semester" onchange="loadSubjects()">
                    <option value="" selected="selected">-- Please Select --</option>
                    <?php
                    $query = "SELECT * FROM semester";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result)) {
                      echo "<option value='" . $row['Semester'] . "'>" . $row['Semester'] . "</option>";
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
              <h5>Subject Details</h5>
              <table id="example2" class="table table-bordered">
                <thead>
                  <tr>
                    <th>Intake</th>
                    <th>Semester</th>
                    <th>Subject Code</th>
                    <th>Assignment Allocation</th>
                    <th>Final Allocation</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (isset($_GET['Subject_Code'], $_GET['Academic_Year'], $_GET['Semester'])) {
                    $query = "SELECT * FROM subjects WHERE 
                      Subject_Code = '{$_GET['Subject_Code']}' AND
                      Intake = '{$_GET['Academic_Year']}' AND
                      Semester = '{$_GET['Semester']}'";

                    $result = mysqli_query($conn, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                  ?>
                        <tr class="selectable-row">
                          <td><?php echo $row['Intake']; ?></td>
                          <td><?php echo $row['Semester']; ?></td>
                          <td><?php echo $row['Subject_Code']; ?></td>
                          <td><?php echo $row['Assignment_allo']; ?></td>
                          <td><?php echo $row['Final_allo']; ?></td>
                          <td>
                            <a href="Marks.php?Subject_Code=<?php echo $row['Subject_Code']; ?>&Intake=<?php echo $row['Intake']; ?>&Semester=<?php echo $row['Semester']; ?>" class="btn btn-block btn-primary btn-sm <?php echo $addMarksButtonDisabled ? 'disabled' : ''; ?>">Add Marks</a>

                          </td>
                        </tr>
                  <?php
                      }
                    } else {
                      echo "<tr><td colspan='6'>No records found</td></tr>";
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

  <script>
    function loadSubjects() {
      var semester = $('select[name="Semester"]').val();
      var academic_year = $('select[name="Academic_Year"]').val();

      $.ajax({
        url: 'fetch_subjects.php',
        type: 'POST',
        data: {
          semester: semester,
          academic_year: academic_year
        },
        success: function(response) {
          $('#subject_list').html(response);
        }
      });
    }
  </script>

</body>

</html>