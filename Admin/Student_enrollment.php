<?php
session_start();
if (!(isset($_SESSION['EMP_Number']) && $_SESSION['EMP_Number'] != '')) {
  header("Location: index.php");
}
include('database.php');

include('db.php');
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
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <?php include('top_manu.php'); ?>
      </ul>
    </nav>
    <!-- /.navbar -->


    <?php include('Side_menu_admin.php'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Student Details</h1>
            </div>
            <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div> -->
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <script>
        function confirmDelete(W) {
          if (confirm('Are you sure want to delete?')) {
            return true;
          } else {
            return false;
          }
        }
      </script>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <br>
            <div class="col-12">
              <!-- /.card -->
              <?php
              // Get status message
              if (!empty($_GET['status'])) {
                switch ($_GET['status']) {
                  case 'succ':
                    $statusType = 'alert-success';
                    $statusMsg = 'Students data has been imported successfully.';
                    break;
                  case 'err':
                    $statusType = 'alert-danger';
                    $statusMsg = 'Some problem occurred, please try again.';
                    break;
                  case 'invalid_file':
                    $statusType = 'alert-danger';
                    $statusMsg = 'Please upload a valid CSV file.';
                    break;
                  default:
                    $statusType = '';
                    $statusMsg = '';
                }
              }

              ?>
              <div class="card">
                <!-- /.card-header -->
                <div class="card-body">

                  <form action="import.php" method="post" name="upload_excel" enctype="multipart/form-data">
                    <fieldset>
                      <div class="control-group">
                        <?php if (!empty($statusMsg)) { ?>
                          <div class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>
                        <?php } ?>
                        <div class="controls">
                          <input type="file" name="file" id="file" class="input-large">
                        </div>
                        <div class="control-label">
                          <h6>Upload only CSV File: (Sample.CSV )</h6>
                          <a href="Sample.csv">Download Sample Excel </a>

                        </div>
                      </div>
                      <br>
                      <div class="control-group">
                        <div class="controls">
                          <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button>
                        </div>
                      </div>
                    </fieldset>
                    <hr>
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Reg Number</th>
                          <th>Name with Initials</th>
                          <th>Academic Year</th>
                          <th>Degree Code</th>
                          <th>Contact Num</th>
                          <th></th>


                        </tr>
                      </thead>
                      <?php
                      $SQLSELECT = "SELECT * FROM student_details ";
                      $result_set =  mysqli_query($conn, $SQLSELECT);
                      while ($row = mysqli_fetch_array($result_set)) {
                      ?>

                        <tr>
                          <td><?php echo $row['RegNo']; ?></td>
                          <td><?php echo $row['Name_with_int']; ?></td>
                          <td><?php echo $row['year']; ?></td>
                          <td><?php echo $row['Degree_code']; ?></td>
                          <td><?php echo $row['Hand_Phone']; ?></td>
                          <th><a href="student_edit.php?id=<?= $row['RegNo'] ?>"><img src="images/edit.png" width="20" height="18" /></a></th>


                        </tr>
                      <?php
                      }
                      ?>
                    </table>
                  </form>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
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