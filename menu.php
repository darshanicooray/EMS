<?php
session_start();
if (!(isset($_SESSION['RegNo']) && $_SESSION['RegNo'] != '')) {
    header("Location: index.php");
    exit(); // Add exit to stop further execution
}
include('database.php');

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


            <div class="row">



                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="panel panel-primary ">
                        <div class="panel-heading">
                            My Profile
                        </div>

                        <div class="panel-body chat-widget-main">

                            <div class="chat-widget-name-left">
                                <img class="media-object img-circle img-left-chat" src="images/user.png" style="width:64px;height:64px;" />
                                <h4> <?php echo $row['Name_with_int']; ?></h4>
                                <h5> <b> Student Reg: Num : </b><?php echo $row['RegNo']; ?></h5>
                                <br>
                                <h5><a href="profile.php">View</a></h5>
                                <hr />

                            </div>



                        </div>

                    </div>
                </div>

                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            KDU Announcements
                        </div>
                        <div class="panel-body">
                            <ul class="media-list">

                                <li class="media">
                                    <!-- <a class="pull-left" href="#">
          <img class="media-object img-circle img-comments" src="assets/img/user.gif" />
        </a> -->
                                    <div class="media-body">
                                        <h4 class="media-heading">SPECIAL NOTICE</h4>
                                        <p>
                                            This is to inform that the Lectures of the Degree programmes WILL NOT be conducted on 25th November and 26th November, 2023.<br>
                                            Deputy Registrar
                                            22/11/2023
                                        </p>
                                        <h4 class="media-heading">IRC 2024 </h4>
                                        <p>
                                            IRC 2024 will be held on 6th September
                                        </p>
                                        <h4 class="media-heading">Lectures Timetable</h4>
                                        <p>
                                            Download Lectures Timetable for more details
                                        </p>


                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>

                </div>
            </div>



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