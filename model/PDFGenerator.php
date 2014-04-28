<?php
	include "../model/fpdf/fpdf.php";
	function generate($name) {
		
		$pdf = new FPDF();

		$pdf->AddPage();
	    $pdf->SetFont("Courier", "B", 18);
	    $pdf->Cell(0, 10, "Hello World!", 0, 1, "C");

		return $pdf->Output($name, "S");
	}
?>