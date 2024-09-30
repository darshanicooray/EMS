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
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>
    .table-container {
      display: flex;
    }

    .data-table {
      flex: 1;
      margin-right: 10px;
      margin-left: 10px;
      /* Add spacing between tables */
    }

    .vl {
      border-left: 2px solid #DCDCDC;
      height: auto;
    }

    .selected {
      background-color: #cce5ff;
    }

    input.right {
      float: right;
    }
  </style>
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

    <!-- Main Sidebar Container -->
    <?php include('Side_menu_admin.php'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Map Subjects and Student</h1>
            </div>
            <div class="col-sm-6">
              <!-- <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol> -->
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->


      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <br>
            <div class="col-12">
              <!-- /.card -->

              <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                  <form action="" method="post" name="upload_excel" enctype="multipart/form-data">

                    <div id="successMessage"></div>

                    <div class="table-container">
                      <div class="data-table">
                        <h5>Subjects Details</h5>
                        <table id="example1" class="table table-bordered ">
                          <thead>
                            <tr>
                              <td>Subject_Code</td>
                              <td>Subject_Name</td>
                              <td>Semester</td>
                              <td>Intake</td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $query = "SELECT * FROM subjects";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_array($result)) {

                            ?>
                              <tr class="selectable-row">
                                <td><?php echo $row['Subject_Code']; ?></td>
                                <td><?php echo $row['Subject_Name']; ?></td>
                                <td><?php echo $row['Semester']; ?></td>
                                <td><?php echo $row['Intake']; ?></td>
                              </tr>

                            <?Php
                            }
                            ?>

                          </tbody>

                        </table>

                  </form>

                </div>

                <div class="vl"></div>
                <div class="data-table">
                  <h5>Student Details</h5>
                  <table id="example3" class="table table-bordered ">
                    <thead>
                      <tr>
                        <td>Reg Number</td>
                        <td>Name With Initials</td>

                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $query = "SELECT * FROM student_details ";
                      $result = mysqli_query($conn, $query);
                      while ($row = mysqli_fetch_array($result)) {

                      ?>
                        <tr class="selectable-row">
                          <td><?php echo $row['RegNo']; ?></td>
                          <td><?php echo $row['Name_with_int']; ?></td>

                        </tr>

                      <?Php
                      }
                      ?>

                    </tbody>

                  </table>
                </div>

              </div>
              <br>
              <button id="submitBtn" type="button" class="btn btn-block btn-primary btn-sm" style="float:right; width: 20%; ">Save</button>
              <br>
              <hr>

              <h5>Student and Subjects Mapping Details </h5>
              <table id="example2" class="table table-bordered ">
                <thead>
                  <tr>
                    <td>Intake</td>
                    <td>Semester</td>
                    <td>Subject Code</td>
                    <td>Reg Number</td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = "SELECT * FROM subjectstudent";
                  $result = mysqli_query($conn, $query);
                  while ($row = mysqli_fetch_array($result)) {

                  ?>
                    <tr class="selectable-row">
                      <td><?php echo $row['intake']; ?></td>
                      <td><?php echo $row['Semester']; ?></td>
                      <td><?php echo $row['Subject_Code']; ?></td>
                      <td><?php echo $row['RegNum']; ?></td>
                    </tr>

                  <?Php
                  }
                  ?>

                </tbody>

              </table>
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
    $(document).ready(function() {
      // Check for the 'success' parameter in the URL
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('success')) {
        const successMessage = urlParams.get('success');
        const successAlert = `<div class="alert alert-success alert-dismissible">${decodeURIComponent(successMessage)}</div>`;
        $('#successMessage').html(successAlert);
      }
    });
  </script>

  <script>
    $(function() {
      var selectedSubjectsIDs = []; // Array to store selected subject data
      var selectedLecturerIDs = []; // Array to store selected lecturer data

      var table1 = $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
      });

      var table3 = $('#example3').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });

      var table2 = $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
      $('#example1 tbody').on('click', 'tr', function() {
        $(this).toggleClass('selected');
        var rowData = table1.row(this).data();
        if (rowData) {
          var selectedSubjectID = rowData[0]; // Assuming the ID is in the first column
          var selectedSubjectName = rowData[1];
          var selectedSemester = rowData[2];
          var selectedIntake = rowData[3];
          selectedSubjectsIDs.push({
            id: selectedSubjectID,
            name: selectedSubjectName,
            semester: selectedSemester,
            intake: selectedIntake
          });
        }
      });

      $('#example3 tbody').on('click', 'tr', function() {
        $(this).toggleClass('selected');
        var rowData = table3.row(this).data();
        if (rowData) {
          var selectedLecturerID = rowData[0]; // Assuming the ID is in the first column
          var selectedNameWithInitials = rowData[1]; // Make sure the index is correct

          selectedLecturerIDs.push({
            id: selectedLecturerID,
            initials: selectedNameWithInitials
          });
        }
      });

      $('#submitBtn').click(function(e) {
        e.preventDefault();

        if (selectedSubjectsIDs.length > 0 && selectedLecturerIDs.length > 0) {
          $.ajax({
            type: 'POST',
            url: 'insert_data_student.php',
            data: {
              subjects: selectedSubjectsIDs,
              lecturers: selectedLecturerIDs
            },
            success: function(response) {

              console.log(response);
              // Check if the response is JSON
              if (response.status === 'success') {

                // Display the success message on the main page
                $('#successMessage').html('<div class="alert alert-success alert-dismissible">' + response.message + '</div>');

                // Scroll to the top of the page where the success message is displayed
                $('html, body').animate({
                  scrollTop: 0
                }, 'slow');

                // Delay the page refresh for 2 seconds (adjust the time as needed)
                setTimeout(function() {
                  location.reload();
                }, 2000);

              } else if (response.status === 'error') {
                // Display the error message on the main page
                $('#successMessage').html('<div class="alert alert-danger alert-dismissible">' + response.message + '</div>');

                // Delay the page refresh for 2 seconds (adjust the time as needed)
                setTimeout(function() {
                  location.reload();
                }, 2000);

                // Scroll to the top of the page where the success message is displayed
                $('html, body').animate({
                  scrollTop: 0
                }, 'slow');

              }
            },
            error: function() {
              alert('Error occurred while inserting data.');
            }
          });
        } else {
          alert('No rows selected.');
        }
      });
    });
  </script>



</body>

</html>