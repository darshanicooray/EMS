<?php

include('database.php');

//echo $Semester= $_REQUEST['Semester'];
//echo $Intake= $_REQUEST['Intake'];

$Semester = $_REQUEST['Semester'];
$Intake = $_REQUEST['Intake'];
$Degree = $_REQUEST['Degree']

?>

<select id="sub" name="sub" class="form-control form-control-sm" style="width: 220px;
    color: #333333;
    padding: 1px;
    margin-right: 4px;
    margin-bottom: 8px;
    font-family: Times New Roman, Times, serif;
    font-size:14px;
    height: 22px; " onChange="loadlecturer(Lecturer);">
  <option value='0'>-- Please Select --</option>
  <?php
  $query = "SELECT * FROM subjects where Semester='$Semester' AND Intake='$Intake' AND Degree_Code='$Degree'";
  $result = mysqli_query($conn, $query);
  while ($row = mysqli_fetch_array($result)) {
  ?>
    <option value='<?php echo $row['Subject_Code']; ?>'><?php echo $row['Subject_Code'] . '-' . $row['Subject_Name']; ?></option>

  <?php
  }
  ?>
  <select>