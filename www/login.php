<?php
    include('siteInit.php'); 
    include('siteLogon.php');
	//If a user is logged in they shouldn't be here, kick them out
	if($loggedIn)
	{
		echo "<script> location.href='selectLanding.php'; </script>";
	}
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login Page</title>
    <script src="script.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <!--<script src="script.js"></script>-->

  </head>
  <body class="  hs-content-id-4908310180 hs-site-page page hs-content-path- hs-content-name-home  " style="">

  <?php include('menu.php'); ?>
  
   <!-- page content -->

	<div class=loginBox>
		<div class="glass">
		<img src ="images/placeholder.png" class="user">
		<h3>User Login</h3>
		<form action="login.php" method="post" >
			<!--Email Box-->
			<div class="inputBox">
				<input type="email" name="email" id="email" placeholder="Email">
				<br></br>
			</div>

			<div class="inputBox">
				<input type="password" name="password" id="password" placeholder="Password">
				<br></br>
			</div>
				<input type="submit" name="logon" value="Login">
        <?php echo $msg;?>
		</form>
		<br></br>
		<a href="register.php">Don't Have an Account?</a>
		<br></br>
		<a href="recover.php">Forgot Password</a>
		</div>
		</div>
		<br></br>

    <!-- page content -->
  </body>
</html>
