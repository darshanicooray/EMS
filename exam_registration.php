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
                    <h4 class="header-line">Exam Registration</h4>

                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Semester 01 Exam Registration
                            </div>
                            <div class="panel-body">
                                <form role="form">
                                    <div class="form-group">
                                        <label>Reg Number</label>
                                        <input class="form-control" type="text" />

                                    </div>
                                    <div class="form-group">
                                        <label>Index Number</label>
                                        <input class="form-control" type="text" />

                                    </div>
                                    <div class="form-group">
                                        <label>Enter Email</label>
                                        <input class="form-control" type="text" />
                                        <p class="help-block">Help text here.</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Subject 01</label>
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option>Fundamentals of Programing</option>
                                                <option>Foundation of Computer Science</option>
                                                <option>Computer Systems Architecture</option>
                                                <option>Fundamentals of Databases</option>
                                                <option>Fundamentals of Visual Computing </option>
                                                <option>Probability and Statistics</option>
                                                <option>Engineering Mathematics</option>
                                                <option>Basic Study Skills in English for CS/CE/SE</option>
                                                <option>Group Project in Hardware</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Subject 02</label>
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option>Fundamentals of Programing</option>
                                                <option>Foundation of Computer Science</option>
                                                <option>Computer Systems Architecture</option>
                                                <option>Fundamentals of Databases</option>
                                                <option>Fundamentals of Visual Computing </option>
                                                <option>Probability and Statistics</option>
                                                <option>Engineering Mathematics</option>
                                                <option>Basic Study Skills in English for CS/CE/SE</option>
                                                <option>Group Project in Hardware</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Subject 03</label>
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option>Fundamentals of Programing</option>
                                                <option>Foundation of Computer Science</option>
                                                <option>Computer Systems Architecture</option>
                                                <option>Fundamentals of Databases</option>
                                                <option>Fundamentals of Visual Computing </option>
                                                <option>Probability and Statistics</option>
                                                <option>Engineering Mathematics</option>
                                                <option>Basic Study Skills in English for CS/CE/SE</option>
                                                <option>Group Project in Hardware</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Subject 04</label>
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option>Fundamentals of Programing</option>
                                                <option>Foundation of Computer Science</option>
                                                <option>Computer Systems Architecture</option>
                                                <option>Fundamentals of Databases</option>
                                                <option>Fundamentals of Visual Computing </option>
                                                <option>Probability and Statistics</option>
                                                <option>Engineering Mathematics</option>
                                                <option>Basic Study Skills in English for CS/CE/SE</option>
                                                <option>Group Project in Hardware</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Subject 05</label>
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option>Fundamentals of Programing</option>
                                                <option>Foundation of Computer Science</option>
                                                <option>Computer Systems Architecture</option>
                                                <option>Fundamentals of Databases</option>
                                                <option>Fundamentals of Visual Computing </option>
                                                <option>Probability and Statistics</option>
                                                <option>Engineering Mathematics</option>
                                                <option>Basic Study Skills in English for CS/CE/SE</option>
                                                <option>Group Project in Hardware</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Subject 06</label>
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option>Fundamentals of Programing</option>
                                                <option>Foundation of Computer Science</option>
                                                <option>Computer Systems Architecture</option>
                                                <option>Fundamentals of Databases</option>
                                                <option>Fundamentals of Visual Computing </option>
                                                <option>Probability and Statistics</option>
                                                <option>Engineering Mathematics</option>
                                                <option>Basic Study Skills in English for CS/CE/SE</option>
                                                <option>Group Project in Hardware</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Subject 07</label>
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option>Fundamentals of Programing</option>
                                                <option>Foundation of Computer Science</option>
                                                <option>Computer Systems Architecture</option>
                                                <option>Fundamentals of Databases</option>
                                                <option>Fundamentals of Visual Computing </option>
                                                <option>Probability and Statistics</option>
                                                <option>Engineering Mathematics</option>
                                                <option>Basic Study Skills in English for CS/CE/SE</option>
                                                <option>Group Project in Hardware</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Subject 08</label>
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option>Fundamentals of Programing</option>
                                                <option>Foundation of Computer Science</option>
                                                <option>Computer Systems Architecture</option>
                                                <option>Fundamentals of Databases</option>
                                                <option>Fundamentals of Visual Computing </option>
                                                <option>Probability and Statistics</option>
                                                <option>Engineering Mathematics</option>
                                                <option>Basic Study Skills in English for CS/CE/SE</option>
                                                <option>Group Project in Hardware</option>
                                            </select>
                                        </div>
                                    </div>



                                    <button type="submit" class="btn btn-info">Apply</button>

                                </form>
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