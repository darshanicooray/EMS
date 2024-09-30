   <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="menu_admin.php" class="brand-link">
       <img src="images/Kotelawala_Defence_University_crest.png" class="brand-image img-circle elevation-3" style="opacity: .8">
       <span class="brand-text font-weight-light">
         <h6>Examination Management <br> System </h6>
       </span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
       <!-- Sidebar user panel (optional) -->
       <div class="user-panel mt-3 pb-3 mb-3 d-flex">
         <div class="image">
           <img src="images/person-icon.png" class="img-circle elevation-2" alt="User Image">
         </div>
         <div class="info">
           <a href="#" class="d-block"><?php echo $_SESSION['Name_With_Initials'] ?></a>

         </div>
       </div>


       <div class="info">


       </div>


       <!-- Sidebar Menu -->
       <nav class="mt-2">
         <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

           <?php

            if ($_SESSION['user_type'] == 'Admin') {

            ?>
             <li class="nav-item">
               <a href="#" class="nav-link">
                 <i class="nav-icon fas fa-copy"></i>
                 <p>
                   Master Details
                   <i class="right fas fa-angle-down"></i>
                 </p>
               </a>
             </li>
             <li class="nav-item">
               <a href="year.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Academic Year</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="faculty.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Faculty</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="department.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Department</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="semester.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Semester</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="degree.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Degree Programs</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="subject.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Subjects</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="Student_enrollment.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Student Enrollment</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="subject_letcher.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Map Subject and Lecturer </p>
               </a>
             </li>
             <li class="nav-item">
               <a href="subject_student.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Map Subject and Student</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="User_Details.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Users</p>
               </a>
             </li>
           <?php
            } elseif ($_SESSION['user_type'] == 'Lecturer') {
            ?>

             <li class="nav-item">
               <a href="#" class="nav-link">
                 <i class="nav-icon fas fa-copy"></i>
                 <p>
                   Marks Details
                   <i class="right fas fa-angle-down"></i>
                 </p>
               </a>
             </li>
             <li class="nav-item">
               <a href="add_marks.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Upload Marks</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="lecturer_reports.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Reports</p>
               </a>
             </li>

           <?PHP
            } elseif ($_SESSION['user_type'] == 'AR') {
            ?>
             <li class="nav-item">
               <a href="#" class="nav-link">
                 <i class="nav-icon fas fa-copy"></i>
                 <p>
                   Marks Details
                   <i class="right fas fa-angle-down"></i>
                 </p>
               </a>
             </li>
             <li class="nav-item">
               <a href="AR_verify_subject_lecturer.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Verify lecturer and subject mapping </Details>
                 </p>
               </a>
             </li>
             <li class="nav-item">
               <a href="AR_verify_subject_Student.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Verify Student and subject mapping </Details>
                 </p>
               </a>
             </li>
           <?PHP
            } elseif ($_SESSION['user_type'] == 'HOD') {

            ?>
             <li class="nav-item">
               <a href="#" class="nav-link">
                 <i class="nav-icon fas fa-copy"></i>
                 <p>
                   Marks Details
                   <i class="right fas fa-angle-down"></i>
                 </p>
               </a>
             </li>
             <li class="nav-item">
               <a href="HOD_reports.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Verify Marks details </Details>
                 </p>
               </a>
             </li>

           <?PHP
            } elseif ($_SESSION['user_type'] == 'DEAN') {
            ?>
             <li class="nav-item">
               <a href="#" class="nav-link">
                 <i class="nav-icon fas fa-copy"></i>
                 <p>
                   Marks Details
                   <i class="right fas fa-angle-down"></i>
                 </p>
               </a>
             </li>
             <li class="nav-item">
               <a href="Dean_reports.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Verify Marks details </Details>
                 </p>
               </a>
             </li>

           <?PHP
            } elseif ($_SESSION['user_type'] == 'Exam_Branch') {
            ?>
             <li class="nav-item">
               <a href="#" class="nav-link">
                 <i class="nav-icon fas fa-copy"></i>
                 <p>
                   Marks Drtails
                   <i class="right fas fa-angle-down"></i>
                 </p>
               </a>
             </li>
             <li class="nav-item">
               <a href="calculate_GPA.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p> Calculate GPA </Details>
                 </p>
               </a>
             </li>

             <li class="nav-item">
               <a href="subject_wise_result_sheet.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p> Generate subject-wise result sheets.</Details>
                 </p>
               </a>
             </li>
             <li class="nav-item">
               <a href="degree_form.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p> Generate Degree-wise Result Sheets</Details>
                 </p>
               </a>
             </li>
             <li class="nav-item">
               <a href="transcript_form.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p> Generate Final Result Sheets</Details>
                 </p>
               </a>
             </li>
             <li class="nav-item">
               <a href="Upload_exam_timetable.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p> Upload Exam Time table </Details>
                 </p>
               </a>
             </li>
             <li class="nav-item">
               <a href="Upload_exam_timetable.php" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p> Generate Admission Cards </Details>
                 </p>
               </a>
             </li>


           <?PHP
            }
            ?>

         </ul>
       </nav>
       <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
   </aside>