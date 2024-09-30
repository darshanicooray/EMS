<div class="navbar navbar-inverse set-radius-zero">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html">

                <img src="images/Kotelawala_Defence_University_crest.png" width="148" height="130" />

            </a>
            <div style="font-family: 'Open Sans', sans-serif; font-size: 18px; padding-left: 150px ;font-weight: bold; padding-top: 90px">Kotelawala Defence University</div>
            <div style="font-family: 'Open Sans', sans-serif; font-size: 18px; padding-left: 150px;font-weight: bold">Student Portal</div>

        </div>

        <div class="right-div">



            Welcome <B><?php
                        $REG = $_SESSION['RegNo'];
                        $sql = "SELECT * FROM student_details WHERE RegNo='$REG'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_array($result);
                        echo $row['Name_with_int'];
                        ?></B>
            <br>
            <a href="logout.php" class="btn btn-danger pull-right">LOG OUT</a>


        </div>

    </div>
</div>