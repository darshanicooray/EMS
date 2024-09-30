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

              <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                  <?php
                  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Import"])) {

                    $targetDirectory = "TimeTableUploads/"; // Create a directory to store uploaded files
                    $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);
                    $uploadOk = 1;
                    $pdfFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                    // Check if the file is a PDF
                    if ($pdfFileType != "pdf") {
                      echo "<div class='alert alert-danger alert-dismissible'> Sorry, only PDF files are allowed. </div>";
                      $uploadOk = 0;
                    }

                    // Check if the file already exists
                    if (file_exists($targetFile)) {
                      echo "<div class='alert alert-danger alert-dismissible'> Sorry, the file already exists. </div>";
                      $uploadOk = 0;
                    }

                    // Check file size (adjust the limit as needed)
                    if ($_FILES["file"]["size"] > 5 * 1024 * 1024) {
                      echo "<div class='alert alert-danger alert-dismissible'> Sorry, your file is too large. Max size is 5MB.  </div>";
                      $uploadOk = 0;
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                      echo "<div class='alert alert-danger alert-dismissible'>  Sorry, your file was not uploaded.  </div>";
                    } else {
                      // Move the file to the specified directory
                      if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {

                        $topic = $_POST["topic"];

                        // Prepare and execute SQL query to insert data into the table
                        $sql = "INSERT INTO exam_time_table (topic, file) VALUES ('$topic', '$targetFile')";
                        if ($conn->query($sql) === TRUE) {
                          echo "<div class='alert alert-success alert-dismissible'> The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded and data has been inserted into the database.  </div>";
                        } else {
                          echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                      } else {
                        echo "<div class='alert alert-danger alert-dismissible'> Sorry, there was an error uploading your file.";
                      }
                    }
                  }
                  if (isset($_GET['id'])) {
                    $id = $_GET['id'];

                    // Prepare and execute SQL query to delete record
                    $sql = "DELETE FROM exam_time_table WHERE id = $id";

                    if ($conn->query($sql) === TRUE) {
                      echo "<div class='alert alert-danger alert-dismissible'>
                      Successfully Deleted!
                      </div>";
                    } else {
                      echo "Error deleting record: " . $conn->error;
                    }
                  }
                  ?>
                  <script>
                    function validateForm() {
                      // Check if the file input is empty
                      var fileInput = document.getElementById('file');
                      if (fileInput.files.length === 0) {
                        alert('Please select a file for upload.');
                        return false;
                      }
                      return true;
                    }
                  </script>
                  <form action="" method="post" name="upload_excel" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <fieldset>
                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Topic : </label>
                        <div class="col-sm-8">
                          <input type="text" name="topic" class="form-control" id="inputPassword3">
                        </div>
                      </div>
                      <div class="control-group">

                        <div class="controls">
                          <input type="file" name="file" id="file" class="input-large">
                        </div>
                        <div class="control-label">
                          <h6>Upload only PFD File: (Sample.pdf )</h6>
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
                          <th>Topic</th>
                          <th></th>


                        </tr>
                      </thead>
                      <?php
                      $SQLSELECT = "SELECT * FROM exam_time_table";
                      $result_set = mysqli_query($conn, $SQLSELECT);
                      while ($row = mysqli_fetch_array($result_set)) {


                      ?>

                        <tr>
                          <td><?php echo $row['topic']; ?></td>
                          <td><a href="Upload_exam_timetable.php?id=<?php echo $row['id']; ?>" onclick="return confirmDelete();"><img src="images/remove.png" width="26" height="25" /></a></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </table>
                  </form>
                  <?php
                  // Close connection
                  $conn->close();
                  ?>
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