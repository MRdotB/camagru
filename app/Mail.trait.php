<?php
trait Mail {
	private function send_mail($to, $subject, $message) {
		$message = '
		<html>
			<head>
				<title>' .$subject . '</title>
			</head>
			<body>
				<p>' . $message . '</p>
			</body>
		</html>';
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		mail($to, $subject, $message, $headers);
	}
}
