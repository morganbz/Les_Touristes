<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
require_once('./mail/PHP_Mailer/src/PHPMailer.php');
require_once('./mail/PHP_Mailer/src/SMTP.php');
require_once('./mail/PHP_Mailer/src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function send_mail($subject, $body, $receiver) {
	// Instantiation and passing `true` enables exceptions
	$mail = new PHPMailer(false);

	try {
		//Server settings
		$mail->SMTPDebug = SMTP::DEBUG_OFF;              // or SMTP::DEBUG_OFF in production
		$mail->isSMTP();
		$mail->Host       = 'smtp.gmail.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = "info405.l2info10@gmail.com";               // SMTP username
		$mail->Password   = "Info405!";                     // SMTP password
		$mail->SMTPSecure = 'ssl';
		$mail->Port       = 465;
		$mail->CharSet = 'UTF-8';

		//Recipients
		$mail->setFrom("info405.l2info10@gmail.com", $subject);
		$mail->addAddress($receiver);     // Add a recipient
		//$mail->addAddress('ellen@example.com');               // Name is optional
		//$mail->addReplyTo('info@example.com', 'Information');
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		// Attachments
		// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

		// Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $subject;
		$content_body = '<!doctype html><html lang="fr"><head><meta charset="utf-8"></head><body>';
		$content_body = $content_body . $body . '</body></html>';
		$mail->Body    = $content_body;
		$mail->AltBody = "";

		$mail->send();
	} catch (Exception $e) {
	}
}
