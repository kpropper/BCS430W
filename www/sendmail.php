<?php   

		require_once "/Mail-1.4.1/Mail/Mail.php";

		function sendmail($to,$subject,$body)
		{
				$from = "accounts@itamg.tk";

				$host = "mail.itamg.tk";
				$username = "accounts";
				$password = "PLeas3R3SetMe";

				$headers = array ('From' => $from,
				'To' => $to,
				'Subject' => $subject);
				$smtp = Mail::factory('smtp',
						array ('host' => $host,
						'auth' => true,
						'username' => $username,
						'password' => $password));

						$mail = $smtp->send($to, $headers, $body);

				if (PEAR::isError($mail)) 
				{
				 //do something here to indicate an error echo("<p>" . $mail->getMessage() . "</p>");
				} 
				else 
				{
				  //do something here (maybe) echo("<p>Message successfully sent!</p>");
				}
		}
?>