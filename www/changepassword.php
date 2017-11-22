<?php
	include('siteInit.php');

	//If a user is not logged in they shouldn't be here, kick them out
	if(!$loggedIn)
	{
		echo "<script> location.href='index.php'; </script>";
	}

	include('passwordupdate.php');
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
  <h1 style="text-align: center">Change Password</h1>
	<div class="formbox">
  <form class="container" action="changepassword.php" method="post">
    <div class="names">
    <label>Old Password:</label>
    <input type="password" name="oldpassword" value="" placeholder="Old Password">
    </div>
    <div class="names">
    <label>New Password:</label>
    <input type="password" name="newpassword" value="" placeholder="New Password">
    <br>
    <label>Verify Password:</label>
    <input type="password" name="verifypassword" value="" placeholder="Verify Password">
    <br>
    <div class="reg_submit">
    <input type="submit" name="changepassword" value="Change Password" style="cursor: pointer">
    </div>
    </div>
  <?php echo $msg; ?>
  </form>
</div>
</div>


</body>

</html>
