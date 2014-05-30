<?php
	include "database.php";
	include "mysql.php";
	include "fpdf/fpdf.php";

	function generateReport($event_id, $name) {
		$event = get_event($event_id);
		$tasks = get_tasks_for_event($event_id);


		$pdf = new FPDF();
		$pdf->AddPage();
	    //$pdf->Cell(0, 10, "Hello World!", 0, 1, "C");

		foreach($tasks as $task) {
			$signups = get_users_signed_up($task['ID']);
			$pdf->SetFont("Courier", "B", 14);
			$pdf->Cell(0, 10, $task['description'], 0, 1, 'L');

			$pdf->SetFont("Courier", "", 12);
			$pdf->Cell(40, 7, "First Name", 1, 0, 'C');
			$pdf->Cell(40, 7, "Last Name", 1, 0, 'C');
			if($task['comments'])
					$pdf->Cell(40, 7, "Comment", 1, 0, 'C');
			$pdf->Ln();

			$pdf->SetFont("Courier", "", 10);
			foreach($signups as $signup) {
				$account = get_user($signup['accountID']);
				$pdf->Cell(40, 7, $account['fname'], 1, 0, 'L');
				$pdf->Cell(40, 7, $account['lname'], 1, 0, 'L');
				if($task['comments'])
					$pdf->Cell(40, 7, $signup['comment'], 1, 0, 'L');

				$pdf->Ln();
			}
			$pdf->Ln();
		}

		$pdf->Output();

		return $pdf->Output($name, "S");
	}

	generateReport(1, "HI");
?>