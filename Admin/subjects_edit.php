<?php
session_start();
if (!(isset($_SESSION['EMP_Number']) && $_SESSION['EMP_Number'] != '')) {
  header("Location: index.php");
}
include('database.php');
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
        <?php include('top_manu.php'); ?>





      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include('Side_menu_admin.php'); ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"></h1>
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

        <!-- /.row -->
        <!-- Main row -->
        <!-- Horizontal Form -->
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Subjects</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <?php

          $id = isset($_GET['id']) ? $_GET['id'] : '';
          $qty = mysqli_query($conn, "SELECT * FROM subjects WHERE id='$id'");
          $row_qry = mysqli_fetch_array($qty);
          $r_id = $row_qry['id'];
          $r_Subject_Code = $row_qry['Subject_Code'];
          $r_Subject_Name = $row_qry['Subject_Name'];
          $r_Semester = $row_qry['Semester'];
          $r_Credits = $row_qry['Credits'];
          $r_Degree_Code = $row_qry['Degree_Code'];
          $r_Intake = $row_qry['Intake'];
          $r_Assignment_allo = $row_qry['Assignment_allo'];
          $r_Final_allo = $row_qry['Final_allo'];


          ?>
          <br>
          <?php
          if (isset($_POST['submit'])) {
            $Subject_Code = $_POST['Subject_Code'];
            $Subject_Name = $_POST['Subject_Name'];
            $Semester = $_POST['Semester'];
            $Credits = $_POST['Credits'];
            $Degree_Code = $_POST['Degree_Code'];
            $Intake = $_POST['year'];
            $Assignment_allo = $_POST['Assignment_allo'];
            $Final_allo = $_POST['Final_allo'];



            $qryUpdate = "UPDATE subjects SET Subject_Name='$Subject_Name',Credits='$Credits',Degree_Code='$Degree_Code',Assignment_allo='$Assignment_allo',Final_allo='$Final_allo' WHERE id='$id'";
            if (mysqli_query($conn, $qryUpdate)) {
              echo "<div class='alert alert-success alert-dismissible'>
							 Successfully Data Updated!
							 </div>";
            } else {
              echo mysqli_error($conn);
            }
          }

          ?>


          <form class="form-horizontal" enctype="multipart/form-data" method="post">



            <div class="card-body">
              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Id</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputEmail3" value="<?php echo $r_id ?>" readonly="readonly">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Subject Code</label>
                <div class="col-sm-10">
                  <input type="text" name="Subject_Code" class="form-control" value="<?php echo  $r_Subject_Code; ?>" readonly="readonly" id="inputEmail3">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Subject Name</label>
                <div class="col-sm-10">
                  <input type="text" name="Subject_Name" class="form-control" value="<?php echo $r_Subject_Name; ?>" id="inputPassword3">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">No of Credits</label>
                <div class="col-sm-10">
                  <input type="number" name="Credits" class="form-control" value="<?php echo $r_Credits ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Semester</label>
                <div class="col-sm-10">
                  <input type="text" name="Semester" class="form-control" value="<?php echo $r_Semester; ?>" readonly="readonly" id="inputPassword3">

                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Year</label>
                <div class="col-sm-10">
                  <input type="text" name="year" class="form-control" value="<?php echo $r_Intake; ?>" readonly="readonly" id="inputPassword3">

                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Degree Code</label>
                <div class="col-sm-10">
                  <select class="form-control" name="Degree_Code">

                    <option value="<?php echo $r_Degree_Code; ?>"><?php echo $r_Degree_Code; ?></option>
                    <?php
                    $query = "SELECT * FROM degree";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result)) {
                      $row['Degree_Code'];
                      $row['Degree_Name'];
                    ?>

                      <option value="<?php echo $row['Degree_Code']; ?>"><?php echo $row['Degree_Code']; ?></option>
                    <?php
                    }
                    ?>
                  </select>


                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Assignment marks allocation </label>
                <div class="col-sm-10">
                  <input type="number" name="Assignment_allo" class="form-control" value="<?php echo $r_Assignment_allo ?>"> % (out of 100)
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Final marks allocation</label>
                <div class="col-sm-10">
                  <input type="number" name="Final_allo" class="form-control" value="<?php echo $r_Final_allo ?>"> % (out of 100)
                </div>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" name="submit" class="btn btn-info">Save</button>
            </div>
            <!-- /.card-footer -->
          </form>
        </div>

        <!-- /.card -->
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <?php include('main-footer.php'); ?>

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