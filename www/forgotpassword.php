<?php
	include('siteInit.php');

	//If a user is logged in they shouldn't be here, kick them out
	if($loggedIn && !(isset($_POST['fromuser'])))
	{
//		echo "<script> location.href='index.php'; </script>";
	}
	/**
	* Generate a random string, using a cryptographically secure 
	* pseudorandom number generator (random_int)
	* 
	* For PHP 7, random_int is a PHP core function
	* For PHP 5.x, depends on https://github.com/paragonie/random_compat
	* 
	* @param int $length      How many characters do we want?
	* @param string $keyspace A string of all possible characters
	*                         to select from
	* @return string
	*/
	function random_str($length, $keyspace = '0123456789!@#$%&abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')	
	{
		require_once "/random_compat-master/lib/random.php";
		$str = '';
		$max = mb_strlen($keyspace, '8bit') - 1;
		for ($i = 0; $i < $length; ++$i) {
			$str .= $keyspace[random_int(0, $max)];
		}	
		return $str;
	}
	
	$msg = "Please enter your email address to recover your password";	
		
	// Get Form Input
	if (isset($_POST['message'])) 			$msg = $_POST['message'];
	if (isset($_POST['resetpassword']))
	{
		
		if (isset($_POST['email'])) 		$email = $_POST['email']; 	else	$email = NULL;
		if (isset($_POST['fromuser'])) $userID = $_POST['fromuser'];
		
		include("sqlConnect.php");
		$result = $mysqli->query("SELECT UserID FROM user WHERE Email='$email'");
		if($result)
		{
			list($userID) = $result->fetch_row();
			$password = random_str(12);
			
			$query = "UPDATE user SET
					Password		= '$password'
					WHERE UserID 	= '$userID'";
									  
			$result = $mysqli->query($query);
			if ($result) {
				$msg = "Password Updated";
			}
			else
			{
				$msg = "Password NOT Updated " . mysqli_error($mysqli); 
			}
			
			if($msg === "Password Updated")
			{				
				require_once "/Mail-1.4.1/Mail/Mail.php";

				$from = "accounts@itamg.tk";
				$to = "$email";
				$subject = "ITAMG Reset Request";
				$body = "Your password has been reset to $password" . " Please login immediatly and change it. \n Thank You, \n ITAMG Staff.";

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
			
		if(isset($_POST['fromuser']))
		{
			echo "<form id='passwordhasbeenreset' action='employeemanageaccount.php' method='post'>
					  <input type='hidden' name='userUserID' value='$userID'>
					  <input type='hidden' name='message' value='$msg'>
					  <input type='hidden' name='fromuser' value='I Dont Care'>
  				  </form>
					  
					  <script type='text/javascript'>
						document.getElementById('passwordhasbeenreset').submit();
					  </script>";
		}
			
		}
		else $msg = mysqli_error($mysqli);
		
	}
?>
<html>
<head>
<link rel="stylesheet" href="css/main.css" />

<title></title>
</head>
<body class="   hs-content-id-4908310180 hs-site-page page hs-content-path- hs-content-name-home  " style="">
  <div class="header-container-wrapper">
  <div class="header-container container-fluid">

<?php include('menu.php'); ?>

  <div>
  <h1 style="text-align: center">Forgot Password</h1>
	<div class="formbox">
  <form class="container" action="forgotpassword.php" method="post">
    <div class="names">
    <label>Email Address:</label>
    <input type="email" name="email" id="email" placeholder="Email">
    </div>
    <div class="reg_submit">
    <input type="submit" name="resetpassword" value="Reset Password" style="cursor: pointer">
    </div>
    </div>
  <?php echo $msg; ?>
  </form>
</div>
</div>


</body>

</html>