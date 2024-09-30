<?php
include_once 'db.php';
if(isset($_POST["Import"])){
		

		echo $filename=$_FILES["file"]["tmp_name"];
		
		// Allowed mime types
		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

		// Validate whether selected file is a CSV file
		if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
		
		
		 // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
			
			
			// Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
			
			// Skip the first line
            fgetcsv($csvFile);
		
		
		 
	        // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
		
	
		    // Get row data
                $RegNo   = $line[0];
                $Name_with_int  = $line[1];
                $full_Name   = $line[2];
                $Degree_code = $line[3];
				$year = $line[4];
				$Gender  = $line[5];
                $DOB  = $line[6];
                $NIC = $line[7];
				$Address = $line[8];
				$Land_phone  = $line[9];
                $Hand_Phone  = $line[10];
                $email = $line[11];
				$password = $line[12];
				
				
				// Check whether member already exists in the database with the same email
               $prevQuery = "SELECT RegNo FROM student_details WHERE year = '".$line[4]."'  AND Degree_code = '".$line[3]."' AND RegNo = '".$line[0]."' ";
                $prevResult = $conn->query($prevQuery);
				
				if($prevResult->num_rows > 0){
                   
				   echo "record already have";
				   
                }else{
				
				 // Insert member data in the database
                   echo  $conn->query("INSERT INTO student_details (	RegNo, Name_with_int, full_Name, Degree_code,year,Gender,DOB,NIC,Address,Land_Phone,Hand_Phone,email,password) VALUES ('".$RegNo."', '".$Name_with_int."', '".$full_Name."', '".$Degree_code."' , '".$year."', '".$Gender."', '".$DOB."', '".$NIC."', '".$Address."', '".$Land_phone."','".$Hand_Phone."', '".$email."', '".$password."')");
					header("Location: Student_enrollment.php".$qstring);
				}
            }
			// Close opened CSV file
            fclose($csvFile);
            
            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}

// Redirect to the listing page
header("Location: Student_enrollment.php".$qstring);
		
	        
?>		 