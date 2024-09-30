<?php
require_once('tcpdf/tcpdf.php');

class AdmissionCardPDF extends TCPDF
{
    public function generatePDF($studentData, $universityName)
    {
        $this->AddPage();

        // Add your logo at the top and center it
        $logoPath = 'images/university_logo.png'; // Replace with the actual path to your university logo file
        $logoWidth = 30; // Adjust the logo width
        $this->Image($logoPath, ($this->w - $logoWidth) / 2, 10, $logoWidth, 0, 'PNG');

        // Set font for the university name
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 8, '', 0, 1); // Add a line break
        $this->Cell(0, 8, '', 0, 1); // Add a line break
        $this->Cell(0, 8, '', 0, 1); // Add a line break

        // Output the university name
        $this->Cell(0, 7, '' . $universityName, 0, 1, 'C');

        // Set font for the admission card heading
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 10, 'Admission Card', 0, 1, 'C');

        // Add a line break
        $this->Ln(10);

        // Display student information
        $this->SetFont('helvetica', '', 12);
        $this->Cell(0, 7, 'Name: ' . $studentData['Name'], 0, 1, 'L');
        $this->Cell(0, 7, 'Registration Number: ' . $studentData['RegNumber'], 0, 1, 'L');
        $this->Cell(0, 7, 'Program: ' . $studentData['Program'], 0, 1, 'L');
        $this->Cell(0, 7, 'Admission Date: ' . $studentData['AdmissionDate'], 0, 1, 'L');

        // Add a line break
        $this->Ln(10);

        // Display additional information or instructions as needed
        $this->SetFont('helvetica', '', 12);
        $this->MultiCell(0, 10, 'Please bring this admission card along with valid identification on the day of admission.', 0, 'L');

        // Add a line break
        $this->Ln(10);

        // Display a barcode or QR code for easy identification (optional)
        $barcodeValue = '123456789'; // Replace with a unique identifier for the student
        $this->write1DBarcode($barcodeValue, 'C39', '', '', '', 18, 0.4, $style = array('position' => 'C'));

        // Output additional content or customization based on your requirements

    }
}

// Dummy data for Admission Card
$studentData = array(
    'Name' => 'John Doe',
    'RegNumber' => '2023001',
    'Program' => 'Computer Science',
    'AdmissionDate' => '2023-01-15',
);

// Create PDF instance
$pdf = new AdmissionCardPDF();
