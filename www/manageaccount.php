<?php
	include('siteInit.php');
	include("accountmanagement.php");
	//If a user is not logged in they shouldn't be here, kick them out
	if(!$loggedIn)
	{
		echo "<script> location.href='index.php'; </script>";
	}
?>
<html>
<head>
<link rel="stylesheet" href="css/main.css" />

<title>Manage Account</title>
</head>
<body class=" hs-content-id-4908310180 hs-site-page page hs-content-path- hs-content-name-home  " style="">
  <div class="header-container-wrapper">
  <div class="header-container container-fluid">

<?php include('menu.php'); ?>


  <h1 style="text-align: center">Update Your Information</h1>
	<div class="formbox" style="margin-top:55px;">
  <form class="container" action="manageaccount.php" method="post">
    <div class="names">
    <b>Name:
		<?php echo "<input type='text' name='firstname' value='$firstname'>" ?>
		<?php echo "<input type='text' name='lastname' value='$lastname'>" ?>
    </div>
    <div class="names">
    E-Mail:
		<?php echo "<input type='email' name='email' value='$email'>" ?>
    <br />
    <b>Company Name:
		<?php echo "<input type='text' name='companyname' value='$companyname'>" ?>
    <br>
    Phone:
	  <?php echo "<input type='phone' name='phone' value='$telephone'>" ?>
    <br />
    <div class="reg_submit">
    <input type="submit" name="update" value="Update" style="cursor: pointer">
    <a href="changepassword.php">Reset Password</a>
    </div>
    </div>

</b>

	<br />
  <?php echo $msg; ?>
  </form>
</div>


</body>

</html>
