<?php 
	include "../model/phpmailer/PHPMailerAutoload.php";
	function sendMail($recipient, $recipient_name='', $subject, $body, $has_attachment=false, $attachment='', $attachment_name='') {
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465;
		$mail->IsHTML(true);
		$mail->Username = "ptvolunteer.reminders@gmail.com";
		$mail->Password = ",./;'[][]";
		$mail->SetFrom("ptvolunteer.reminders@gmail.com", "PT Volunteer");
		$mail->addAddress($recipient, $recipient_name);
		$mail->Subject = $subject;
		$mail->Body = $body;
		if($has_attachment) {
			$mail->AddStringAttachment($attachment, $attachment_name);
		}

		//$send_result = $mail->Send();

		if(!$send_result) {
			echo $mail->ErrorInfo;
		}
		return $send_result;
	}
?>