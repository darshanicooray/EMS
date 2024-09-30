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
            <h3 class="card-title">Update Student Details</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->

          <br>
          <?php

          $RegNo = isset($_GET['id']) ? $_GET['id'] : '';

          if (isset($_POST['submit'])) {

            $Name_with_int = $_POST['Name_with_int'];
            $full_Name = $_POST['full_Name'];
            $Degree_code = $_POST['Degree_code'];
            $year = $_POST['year'];
            $Gender = $_POST['Gender'];
            $DOB = $_POST['DOB'];
            $NIC = $_POST['NIC'];
            $Address = $_POST['Address'];
            $Land_Phone = $_POST['Land_Phone'];
            $Hand_Phone = $_POST['Hand_Phone'];
            $email = $_POST['email'];
            $password = $_POST['password'];



            $qryUpdate = "UPDATE student_details  SET Name_with_int='$Name_with_int', full_Name='$full_Name' ,Degree_code='$Degree_code',year='$year' ,Gender='$Gender',DOB='$DOB',NIC='$NIC',Address='$Address',Land_Phone='$Land_Phone', Hand_Phone='$Hand_Phone',email='$email',password='$password' WHERE RegNo ='$RegNo'";
            if (mysqli_query($conn, $qryUpdate)) {
              echo "<div class='alert alert-success alert-dismissible'>
							 Successfully Data Updated!
							 </div>";
            } else {
              echo mysqli_error($conn);
            }
          }

          ?>
          <?php


          $qty = mysqli_query($conn, "SELECT * FROM student_details WHERE RegNo='$RegNo'");
          $row_qry = mysqli_fetch_array($qty);
          $r_RegNo = $row_qry['RegNo'];
          $r_Name_with_int = $row_qry['Name_with_int'];
          $r_full_Name = $row_qry['full_Name'];
          $r_Degree_code = $row_qry['Degree_code'];
          $r_year = $row_qry['year'];
          $r_Gender = $row_qry['Gender'];
          $r_DOB = $row_qry['DOB'];
          $r_NIC = $row_qry['NIC'];
          $r_Address = $row_qry['Address'];
          $r_Land_Phone = $row_qry['Land_Phone'];
          $r_Hand_Phone = $row_qry['Hand_Phone'];
          $r_email = $row_qry['email'];
          $r_password = $row_qry['password'];

          ?>

          <form class="form-horizontal" enctype="multipart/form-data" method="post">



            <div class="card-body">
              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">RegNo</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputEmail3" value="<?php echo $RegNo ?>" readonly="readonly">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Name with initials </label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="Name_with_int" id="inputEmail3" value="<?php echo $r_Name_with_int; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Full Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="full_Name" id="inputPassword3" value="<?php echo $r_full_Name; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Degree code</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="Degree_code" id="inputPassword3" value="<?php echo $r_Degree_code; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Year</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="year" id="inputPassword3" value="<?php echo $r_year; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Gender</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="Gender" id="inputPassword3" value="<?php echo $r_Gender; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">DOB</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="DOB" id="inputPassword3" value="<?php echo $r_DOB; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">NIC</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="NIC" id="inputPassword3" value="<?php echo $r_NIC; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="Address" id="inputPassword3" value="<?php echo $r_Address; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Land_Phone</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="Land_Phone" id="inputPassword3" value="<?php echo $r_Land_Phone; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Hand_Phone</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="Hand_Phone" id="inputPassword3" value="<?php echo $r_Hand_Phone; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="email" id="inputPassword3" value="<?php echo $r_email; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="password" id="inputPassword3" value="<?php echo $r_password; ?>">
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