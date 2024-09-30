<?php
session_start();
include('database.php');

if (!(isset($_SESSION['EMP_Number']) && $_SESSION['EMP_Number'] != '')) {
  header("Location: index.php");
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
            <h3 class="card-title">Verify Student and subject mapping</h3>
          </div>

          <!-- ... -->

          <!-- form start -->
          <br>
          <form enctype="multipart/form-data" class="form-horizontal" name="myform" method="GET" action="">
            <div class="card-body">

              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Degree</label>
                <div class="col-sm-2">

                  <select class="form-control" name="degree">
                    <option value="" selected="selected">-- Please Select --</option>
                    <?php
                    $query = "SELECT * FROM degree";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result)) {
                      $row['year'];

                    ?>
                      <option value="<?php echo $row['Degree_Code']; ?>"><?php echo $row['Degree_Name']; ?></option>
                    <?php
                    }
                    ?>
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
                <label for="inputEmail3" class="col-sm-2 col-form-label">Subject</label>
                <div class="col-sm-2">
                  <select id="subject_list" class="form-control" name="subject">
                    <!-- Subjects will be loaded dynamically via AJAX -->
                  </select>
                </div>
              </div>
              <button type="submit" name="submit" class="btn btn-block btn-primary btn-sm" style="float:left; width: 15%; margin-left: 20px;">Search</button>
              <br>
              <hr>
              <div class="data-table">
                <table id="example2" class="table table-bordered ">
                  <thead>
                    <tr>
                      <td>Intake</td>
                      <td>Semester</td>
                      <td>Subject Code</td>
                      <td>RegNum</td>


                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (isset($_GET['degree'], $_GET['Academic_Year'], $_GET['Semester'], $_GET['subject'])) {
                      $query = "SELECT SS.*
                      FROM subjectstudent SS
                      JOIN subjects S ON SS.Subject_Code = S.Subject_Code
                      WHERE 
                          S.Degree_Code = '{$_GET['degree']}' AND
                          SS.Intake = '{$_GET['Academic_Year']}' AND
                          SS.Semester = '{$_GET['Semester']}' AND 
                          SS.Subject_Code = '{$_GET['subject']}'";

                      $result = mysqli_query($conn, $query);

                      if ($result) {
                        while ($row = mysqli_fetch_array($result)) {
                          $id = $row['id'];
                    ?>
                          <tr class="selectable-row">
                            <td><?php echo $row['intake']; ?></td>
                            <td><?php echo $row['Semester']; ?></td>
                            <td><?php echo $row['Subject_Code']; ?></td>
                            <td><?php echo $row['RegNum']; ?></td>
                            <td>
                              <form class="approve-form">
                                <input type="hidden" name="row_id" value="<?php echo $id; ?>">
                                <?php if ($row['AR_approval'] == '0') : ?>
                                  <!-- Change button text -->
                                  <button type="button" class="btn btn-danger approve-btn">Not Approved</button>
                                <?php else : ?>
                                  <!-- Change button text -->
                                  <button type="button" class="btn btn-success approve-btn" disabled>Approved</button>
                                <?php endif; ?>
                              </form>
                            </td>
                          </tr>
                    <?php
                        }
                      } else {
                        echo "Query failed: " . mysqli_error($conn);
                      }
                    }
                    ?>

                  </tbody>
                </table>
              </div>
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
  <script>
    function loadSubjects() {
      var degree = $('select[name="degree"]').val();
      var semester = $('select[name="Semester"]').val();
      var academic_year = $('select[name="Academic_Year"]').val();

      $.ajax({
        url: 'get_subjects.php',
        type: 'POST',
        data: {
          degree: degree,
          semester: semester,
          academic_year: academic_year
        },
        success: function(response) {
          $('#subject_list').html(response);
        }
      });
    }
  </script>
  <script>
    $(document).ready(function() {
      $('.approve-btn').click(function() {
        var rowId = $(this).closest('.selectable-row').find('input[name="row_id"]').val();

        $.ajax({
          type: 'POST',
          url: 'AR_lecturer_approval_student.php',
          data: {
            row_id: rowId
          },
          dataType: 'json', // Expect JSON response
          success: function(response) {
            // Check if response contains error
            if (response.hasOwnProperty('error')) {
              // alert('Error: ' + response.error);
            } else {
              // alert('Record updated successfully.');
              // Reload the page to reflect updated data
              location.reload();
            }
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      });
    });
  </script>
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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