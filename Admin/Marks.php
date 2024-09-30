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
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
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
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Add Marks </h1>
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

              <?php
              $subjectCode = $_GET['Subject_Code'];
              $Intake = $_GET['Intake'];
              $Semester = $_GET['Semester'];




              $query = "SELECT Assignment_allo, Final_allo FROM subjects WHERE Subject_Code = '$subjectCode'";
              $result = mysqli_query($conn, $query);
              $row = mysqli_fetch_assoc($result);
              $assignmentAllocation = (float)$row['Assignment_allo'];
              $finalAllocation = (float)$row['Final_allo'];


              // Fetch existing marks from the database
              $existingMarksQuery = "SELECT RegNum, AssignmentMarks, FinalMarks, TotalMarks, Grade FROM marks WHERE Intake = '$Intake' AND Semester = '$Semester' AND SubjectCode = '$subjectCode'";
              $existingMarksResult = mysqli_query($conn, $existingMarksQuery);

              // Check if the query was successful
              if (!$existingMarksResult) {
                die('Error: ' . mysqli_error($conn));
              }

              // Create an associative array to store existing marks
              $existingMarks = array();
              while ($marksRow = mysqli_fetch_assoc($existingMarksResult)) {
                $existingMarks[$marksRow['RegNum']] = array(
                  'AssignmentMarks' => $marksRow['AssignmentMarks'],
                  'FinalMarks' => $marksRow['FinalMarks'],
                  'TotalMarks' => $marksRow['TotalMarks'],
                  'Grade' => $marksRow['Grade']
                );
              }

              ?>






              <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                  <form name="myform" method="post" action="">

                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <!--<a href="#"> <button type="button" class="btn btn-secondary btn-sm">Add New</button> </a>-->

                        <tr>
                          <th>RegNum</th>
                          <th>Assignment makers</th>
                          <th>Final Marks</th>
                          <th></th>
                          <th></th>
                          <th>Total</th>
                          <th>Grade</th>

                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        $query = "SELECT * FROM subjectstudent where intake='$Intake' AND Semester='$Semester' AND Subject_Code='$subjectCode' AND  AR_approval='1'";
                        $result = mysqli_query($conn, $query);

                        // Check if the query was successful
                        if (!$result) {
                          die('Error: ' . mysqli_error($conn));
                        }

                        while ($row = mysqli_fetch_array($result)) {
                          // Fetch existing marks for the current student
                          $assignmentMarks = isset($existingMarks[$row['RegNum']]['AssignmentMarks']) ? $existingMarks[$row['RegNum']]['AssignmentMarks'] : '';
                          $finalMarks = isset($existingMarks[$row['RegNum']]['FinalMarks']) ? $existingMarks[$row['RegNum']]['FinalMarks'] : '';
                          $totalMarks = isset($existingMarks[$row['RegNum']]['TotalMarks']) ? $existingMarks[$row['RegNum']]['TotalMarks'] : '';
                          $grade = isset($existingMarks[$row['RegNum']]['Grade']) ? $existingMarks[$row['RegNum']]['Grade'] : '';
                        ?>

                          <tr>
                            <td><?php echo $row['RegNum']; ?></td>


                            <td><input type="text" name="assignment_marks[]" id="assignment_<?php echo $row['RegNum']; ?>" value="<?php echo $assignmentMarks; ?>"></td>
                            <td><input type="text" name="final_marks[]" id="final_<?php echo $row['RegNum']; ?>" value="<?php echo $finalMarks; ?>"></td>


                            <th><a href="javascript:void(0);" onclick="saveStudentMarks('<?php echo $row['RegNum']; ?>', <?php echo $assignmentAllocation; ?>, <?php echo $finalAllocation; ?>, '<?php echo $subjectCode; ?>', '<?php echo $Intake; ?>', '<?php echo $Semester; ?>')" class="btn btn-block btn-primary btn-sm">Save</a></th>
                            <th><a href="javascript:void(0);" onclick="clearMarks('<?php echo $row['RegNum']; ?>')" class="btn btn-block btn-primary btn-sm">Clear</a></th>
                            <th id="total_<?php echo $row['RegNum']; ?>"><?php echo $totalMarks; ?></th>
                            <th id="grade_<?php echo $row['RegNum']; ?>"><?php echo $grade; ?></th>
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>

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
    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.1.0
      </div>
      <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>

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

    });




    function saveStudentMarks(regNum, assignmentWeight, finalWeight, subjectCode, intake, semester) {
      var assignmentMarks = parseFloat(document.getElementById('assignment_' + regNum).value) || 0;
      var finalMarks = parseFloat(document.getElementById('final_' + regNum).value) || 0;


      console.log("saveStudentMarks function called");

      // Calculate total marks based on assignment and final weights
      var totalMarks = ((assignmentMarks * (assignmentWeight / 100)) + (finalMarks * (finalWeight / 100)));

      // Calculate and display grades based on the provided scale
      var grade = '';
      if (totalMarks >= 90) {
        grade = 'A+';
      } else if (totalMarks >= 80) {
        grade = 'A';
      } else if (totalMarks >= 75) {
        grade = 'A-';
      } else if (totalMarks >= 70) {
        grade = 'B+';
      } else if (totalMarks >= 65) {
        grade = 'B';
      } else if (totalMarks >= 60) {
        grade = 'B-';
      } else if (totalMarks >= 55) {
        grade = 'C+';
      } else if (totalMarks >= 50) {
        grade = 'C';
      } else if (totalMarks >= 45) {
        grade = 'C-';
      } else if (totalMarks >= 40) {
        grade = 'D+';
      } else if (totalMarks >= 30) {
        grade = 'D';
      } else if (totalMarks >= 20) {
        grade = 'D-';
      } else if (totalMarks > 0) {
        grade = 'E';
      } else {
        grade = '0 NC';
      }


      // Display total marks and grade
      document.getElementById('total_' + regNum).innerHTML = totalMarks.toFixed(2);
      document.getElementById('grade_' + regNum).innerHTML = grade;

      //alert("Intake value is: " + intake);

      // Save the marks using AJAX
      $.ajax({
        type: 'POST',
        url: 'save_marks.php',
        data: {
          regNum: regNum,
          subjectCode: subjectCode,
          intake: intake,
          semester: semester,
          assignmentMarks: assignmentMarks,
          finalMarks: finalMarks,
          totalMarks: totalMarks,
          grade: grade
        },


        success: function(response) {
          // Handle the server response
          console.log(response);

          var result = JSON.parse(response);
          if (result.status === 'success') {
            //  alert('Marks saved successfully!');
          } else if (result.status === 'error') {
            // alert('Error saving marks: ' + result.message);
          }
        },
        error: function(error) {
          // Handle errors if any
          console.error('Error saving marks:', error);
        }
      });
    }

    function clearMarks(regNum) {
      // Clear the input fields
      document.getElementById('assignment_' + regNum).value = '';
      document.getElementById('final_' + regNum).value = '';

      // Clear the total marks and grade display
      document.getElementById('total_' + regNum).innerHTML = '';
      document.getElementById('grade_' + regNum).innerHTML = '';
    }
  </script>

</body>

</html>