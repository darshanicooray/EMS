<?php
session_start();
if (!(isset($_SESSION['RegNo']) && $_SESSION['RegNo'] != '')) {
    header("Location: index.php");
    exit(); // Add exit to stop further execution
}
include('database.php');

$RegNum = $_SESSION['RegNo'];



?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <link rel="shortcut icon" type="image/x-icon" href="images/Kdu.ico">
    <title>KDU-Examination Management System</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>

<body>

    <?php

    include('header.php');
    ?>
    <?php

    include('top_menu.php');
    ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">My Profile</h4>

                </div>

            </div>
            <img class="media-object img-circle img-left-chat" src="images/user.png" style="width:100px;height:100px;" />
            <div class="row">
                <div class="col-md-12">


                    <div class="panel-body">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed">Exam Results</a>
                                    </h4>
                                </div>
                                <div id="collapseOne">
                                    <div class="panel-body">
                                        <!-- Table to display exam results -->
                                        <?php
                                        // Query to fetch exam results for the logged-in student with subject names and semester
                                        $sql = "SELECT marks.*, subjects.Subject_Name, subjects.Semester FROM marks INNER JOIN subjects ON marks.SubjectCode = subjects.Subject_Code WHERE marks.RegNum = '$RegNum'";
                                        $result = mysqli_query($conn, $sql);

                                        // Check for errors in query execution
                                        if (!$result) {
                                            die("Error in SQL query: " . mysqli_error($conn));
                                        }
                                        ?>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Subject Code</th>
                                                    <th>Subject Name</th>
                                                    <th>Semester</th>
                                                    <th>Grade</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Loop through the query result and display each row
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row['SubjectCode'] . "</td>";
                                                    echo "<td>" . $row['Subject_Name'] . "</td>";
                                                    echo "<td>" . $row['Semester'] . "</td>";
                                                    echo "<td>" . $row['Grade'] . "</td>";
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
            <!-- /. ROW  -->
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <section class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    &copy; <?php echo date("Y"); ?> <a href="https://www.kdu.ac.lk/" target="_blank"> KDU </a>| Designed by : KDU IT Team
                </div>

            </div>
        </div>
    </section>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>

</body>

</html>