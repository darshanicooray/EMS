<?php
session_start();

// Check if the user is logged in
if (!(isset($_SESSION['EMP_Number']) && $_SESSION['EMP_Number'] != '')) {
    header("Location: index.php");
    exit();
}

// Include necessary files
require_once('tcpdf/tcpdf.php');
include('database.php'); // Replace this with your actual database connection code

// Function to fetch student marks data from the database and group by semester
function getStudentMarksData($regNum)
{
    global $conn;

    // Modify the query based on your database schema
    $query = "SELECT * FROM marks WHERE RegNum = '$regNum' ORDER BY Semester";
    $result = mysqli_query($conn, $query);

    // Check for errors
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $marksData = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $semester = $row['Semester'];
        $marksData[$semester][] = $row;
    }

    return $marksData;
}

function getStudentData($regNum)
{
    global $conn;

    // Modify the query based on your database schema
    $query = "SELECT marks.*, student_details.Name_with_int, student_details.Degree_code, degree.Degree_Name, gpa_marks.GPA, gpa_marks.Class
    FROM marks 
    INNER JOIN student_details ON marks.RegNum = student_details.RegNo
    LEFT JOIN degree ON student_details.Degree_code = degree.Degree_code
    LEFT JOIN gpa_marks ON marks.RegNum = gpa_marks.RegNo
    WHERE marks.RegNum = '$regNum' 
    ORDER BY marks.Semester";
    $result = mysqli_query($conn, $query);

    // Check for errors
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $studentData = array(
        'marks' => array(),
        'nameWithInitials' => '',
        'degreeName' => '',
        'GPA' => '',
        'Class' => ''
    );

    while ($row = mysqli_fetch_assoc($result)) {
        if (empty($studentData['nameWithInitials'])) {
            $studentData['nameWithInitials'] = $row['Name_with_int'];
            $studentData['degreeName'] = $row['Degree_Name'];
            $studentData['GPA'] = $row['GPA'];
            $studentData['Class'] = $row['Class'];
        }
        $semester = $row['Semester'];
        $studentData['marks'][$semester][] = $row;
    }

    return $studentData;
}

class StudentTranscriptPDF extends TCPDF
{

    public function generatePDF($studentData, $university, $regNum)
    {
        // Add a new page
        $this->AddPage();

        // Add your logo at the top and center it
        $logoPath = 'images/Kotelawala_Defence_University_crest.png'; // Replace with the actual path to your logo file
        $logoWidth = 20; // Adjust the logo width
        $this->Image($logoPath, ($this->w - $logoWidth) / 2, 10, $logoWidth, 0, 'PNG');

        // Set font for the university name
        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(0, 8, '', 0, 1); // Add a line break
        $this->Cell(0, 8, '', 0, 1); // Add a line break

        // Output the university name and report title
        $this->Cell(0, 7, $university, 0, 1, 'C');

        // Output the university address with smaller font size
        $this->SetFont('helvetica', '', 8);
        $this->Cell(0, 5, 'Address: Kandawala Road, Dehiwala-Mount Lavinia 10390', 0, 1, 'C');
        $this->Cell(0, 5, 'Tel: 0112 635 268 ', 0, 1, 'C');
        $this->Cell(0, 5, 'Web: www.kdu.ac.lk ', 0, 1, 'C');

        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(0, 7, 'ACADEMIC TRANSCRIPT', 0, 1, 'C');

        $this->SetFont('helvetica', '', 8);
        $this->Cell(50, 5, 'Registration Number:', 0, 0);
        $this->Cell(50, 5, $regNum, 0, 1);

        $this->Cell(50, 5, 'Name with Initials:', 0, 0);
        $this->Cell(50, 5, $studentData['nameWithInitials'], 0, 1);

        $this->Cell(50, 5, 'Degree:', 0, 0);
        $this->Cell(50, 5, $studentData['degreeName'], 0, 1);

        $this->Cell(50, 5, 'GPA:', 0, 0);
        $this->Cell(50, 5, $studentData['GPA'] . ' out of 4.00 ', 0, 1);

        $this->Cell(50, 5, 'Class:', 0, 0);
        $this->Cell(50, 5, $studentData['Class'], 0, 1);

        // Add a line break
        $this->Ln(4);

        // Set font for the table content
        $this->SetFont('helvetica', 'B', 8);

        // Loop through each semester
        foreach ($studentData['marks'] as $semester => $semesterData) {
            // Add semester heading
            $this->Cell(0, 8, $semester, 0, 1, 'L');

            // Add table header
            $this->SetFont('helvetica', 'B', 7); // Reduced font size
            $this->Cell(40, 5, 'Subject Code', 1, 0, 'C'); // Reduced cell height
            $this->Cell(30, 5, 'Final Marks', 1, 0, 'C'); // Reduced cell height
            $this->Cell(20, 5, 'Grade', 1, 1, 'C'); // Reduced cell height

            // Set font for table content
            $this->SetFont('helvetica', '', 7); // Reduced font size

            // Loop through marks data for the current semester
            foreach ($semesterData as $row) {
                $this->Cell(40, 5, $row['SubjectCode'], 1, 0, 'C'); // Reduced cell height
                $this->Cell(30, 5, $row['FinalMarks'], 1, 0, 'C'); // Reduced cell height
                $this->Cell(20, 5, $row['Grade'], 1, 1, 'C'); // Reduced cell height
            }

            // Add a line break after each semester
            $this->Ln(5); // Reduce space between semesters
        }
    }
}

// Get registration number from the URL parameter
$regNum = $_GET['Reg_Number'];

// Fetch student data
$studentData = getStudentData($regNum);

// Create PDF instance
$pdf = new StudentTranscriptPDF();

// Set your university
$university = 'General Sir John Kotelawala Defence University';

// Generate PDF with student data and student details
$pdf->generatePDF($studentData, $university, $regNum);

// Output the PDF to the browser or save it to a file
$pdf->Output('transcript_' . $regNum . '.pdf', 'I');
