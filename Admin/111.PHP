<?php
// Include the TCPDF library
require_once('tcpdf/tcpdf.php');

// Create a new TCPDF instance
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Sample PDF');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, sample');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('times', 'N', 12);

// Add content
$pdf->Cell(0, 10, 'This is a sample page', 0, 1, 'C');

// Save the PDF to a file (you can also use 'I' to output to the browser)
$pdf->Output('111.PDF', 'F');

echo 'PDF file has been generated: sample.pdf';
