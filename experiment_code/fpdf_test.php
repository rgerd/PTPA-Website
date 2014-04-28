<?php
	include "../model/phpmailer/PHPMailerAutoload.php";
	include "../model/fpdf/fpdf.php";

	$pdf = new FPDF();

	$pdf->AddPage();
    $pdf->SetFont("Courier", "B", 18);
    $pdf->Cell(0, 10, "Hello World!", 0, 1, "C");


	$attachment = $pdf->Output("attachment.pdf", "S");
?>