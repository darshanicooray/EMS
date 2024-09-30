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

// Function to fetch student GPA and class data from the database
function getStudentGPAData($academicYear, $degreeProgram)
{
    global $conn;

    // Modify the query based on your database schema
    $query = "SELECT RegNo, Name_with_int, GPA, Class FROM gpa_marks ";
    $result = mysqli_query($conn, $query);

    // Check for errors
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $gpaData = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $gpaData[] = $row;
    }

    return $gpaData;
}

class StudentGPAPDF extends TCPDF
{
    public function generatePDF($gpaData, $university, $academicYear, $degreeProgram)
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

        // Output the university name and report title
        $this->Cell(0, 7, $university, 0, 1, 'C');
        $this->Cell(0, 7, 'GPA and Class Report', 0, 1, 'C');

        $this->Cell(0, 8, '', 0, 1); // Add a line break
        // Output academic year and degree program details
        $this->SetFont('helvetica', '', 10);

        $this->Cell(50, 8, 'Academic Year:', 0, 0);
        $this->Cell(50, 8, $academicYear, 0, 1);

        $this->Cell(50, 8, 'Degree Program:', 0, 0);
        $this->Cell(50, 8, $degreeProgram, 0, 1);

        // Add a line break
        $this->Ln(10);

        // Set font for the table content
        $this->SetFont('helvetica', 'B', 10);

        // Add your PDF content here
        $html = '<table border="1" style="width: 60%;">
                    <tr>
                        <th style="text-align:center;">Reg No</th>
                        <th style="text-align:center;">Name</th>
                        <th style="text-align:center;">GPA</th>
                        <th style="text-align:center;">Class</th>
                    </tr>';

        $this->SetFont('helvetica', '', 10);

        foreach ($gpaData as $row) {
            $html .= '<tr>
                        <td style="text-align:center;">' . $row['RegNo'] . '</td>
                        <td style="text-align:center;">' . $row['Name_with_int'] . '</td>
                        <td style="text-align:center;">' . number_format($row['GPA'], 2) . '</td>
                        <td style="text-align:center;">' . $row['Class'] . '</td>
                    </tr>';
        }

        $html .= '</table>';

        $this->writeHTML($html, true, false, true, false, '');
    }
}

// Get values from the URL parameters
$academicYear = $_GET['Academic_Year'];
$degreeProgram = $_GET['Degree'];

// Fetch student GPA and class data
$gpaData = getStudentGPAData($academicYear, $degreeProgram);

// Create PDF instance
$pdf = new StudentGPAPDF();

// Set your university and subject
$university = 'General Sir John Kotelawala Defence University';

// Generate PDF with student GPA and class data, university, academic year, and degree program
$pdf->generatePDF($gpaData, $university, $academicYear, $degreeProgram);

// Output the PDF to the browser or save it to a file
$pdf->Output('Degree_wise_report.pdf', 'I');
