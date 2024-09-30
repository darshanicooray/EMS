<?php
session_start();

// Check if the user is logged in
if (!(isset($_SESSION['EMP_Number']) && $_SESSION['EMP_Number'] != '')) {
    header("Location: index.php");
    exit();
}

// Get values from the URL parameters
$subjectCode = $_GET['Subject_Code'];
$Intake = $_GET['Intake'];
$Semester = $_GET['Semester'];

// Include necessary files
require_once('tcpdf/tcpdf.php');
include('database.php'); // Replace this with your actual database connection code

// Function to fetch subject details
function getSubjectDetails($subjectCode)
{
    global $conn;

    $query = "SELECT subjects.*, degree.Degree_Name
    FROM subjects
    JOIN degree ON subjects.Degree_Code = degree.Degree_Code
    WHERE subjects.Subject_Code = '$subjectCode'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    return $row;
}

// Function to fetch student marks data from the database
function getStudentMarksData($subjectCode, $Intake, $Semester)
{
    global $conn;

    // Modify the query based on your database schema
    $query = "SELECT RegNum, AssignmentMarks, FinalMarks, TotalMarks, Grade FROM marks WHERE SubjectCode = '$subjectCode' AND Intake = '$Intake' AND Semester = '$Semester'";
    $result = mysqli_query($conn, $query);

    $marksData = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $marksData[] = $row;
    }

    return $marksData;
}

// Function to count the number of students
function getNumberOfStudents($subjectCode, $Intake, $Semester)
{
    global $conn;

    // Modify the query based on your database schema
    $query = "SELECT COUNT(*) AS num_students FROM marks WHERE SubjectCode = '$subjectCode' AND Intake = '$Intake' AND Semester = '$Semester'";
    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);

    return $row['num_students'];
}

class StudentMarksPDF extends TCPDF
{
    public function generatePDF($marksData, $university, $subjectDetails, $numStudents)
    {

        $this->AddPage();

        // Add your logo at the top and center it
        $logoPath = 'images/Kotelawala_Defence_University_crest.png'; // Replace with the actual path to your logo file
        $logoWidth = 30; // Adjust the logo width
        $this->Image($logoPath, ($this->w - $logoWidth) / 2, 10, $logoWidth, 0, 'PNG');

        // Set font for the university name
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 8, '', 0, 1); // Add a line break
        $this->Cell(0, 8, '', 0, 1); // Add a line break
        $this->Cell(0, 8, '', 0, 1); // Add a line break

        // Output the university name
        $this->Cell(0, 7, $university, 0, 1, 'C');
        $this->Cell(0, 7, 'Detailed marked Sheet', 0, 1, 'C');

        $this->Cell(0, 8, '', 0, 1); // Add a line break
        // Output subject details

        // Set font for the university name
        $this->SetFont('helvetica', '', 10);

        // Output subject details with tab-like spacing
        $this->Cell(50, 8, 'Subject:', 0, 0);
        $this->Cell(50, 8, $subjectDetails['Subject_Code'] . ' - ' . $subjectDetails['Subject_Name'], 0, 1);

        // Output degree details with tab-like spacing
        $this->Cell(50, 8, 'Degree:', 0, 0);
        $this->Cell(50, 8,  $subjectDetails['Degree_Name'], 0, 1);

        $this->Cell(50, 8, 'Intake:', 0, 0);
        $this->Cell(50, 8, $subjectDetails['Intake'], 0, 1);

        $this->Cell(50, 8, 'Number of Students:', 0, 0);
        $this->Cell(50, 8, $numStudents, 0, 1);

        // Add a line break
        $this->Ln(10);

        // Set font for the table content
        $this->SetFont('helvetica', 'B', 10);

        // Add your PDF content here
        $html = '<table border="1" style="width: 60%;">
                    <tr>
                        <th style="text-align:center;">Reg No</th>
                        
                        <th style="text-align:center;">Grade</th>
                    </tr>';

        $this->SetFont('helvetica', '', 10);

        foreach ($marksData as $row) {
            $html .= '<tr>
                        <td style="text-align:center;">' . $row['RegNum'] . '</td>
                        
                        <td style="text-align:center;">' . $row['Grade'] . '</td>
                    </tr>';
        }

        $html .= '</table>';

        $this->writeHTML($html, true, false, true, false, '');
    }
}

// Fetch subject details
$subjectDetails = getSubjectDetails($subjectCode);

// Fetch student marks data
$marksData = getStudentMarksData($subjectCode, $Intake, $Semester);

// Get the number of students
$numStudents = getNumberOfStudents($subjectCode, $Intake, $Semester);

// Create PDF instance
$pdf = new StudentMarksPDF();

// Set your university and subject
$university = 'General Sir John Kotelawala Deffence University';

// Generate PDF with student marks data, university, subject, number of students, and subject details
$pdf->generatePDF($marksData, $university, $subjectDetails, $numStudents);

// Output the PDF to the browser or save it to a file
$pdf->Output('student_marks_report.pdf', 'I');
