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

<title></title>
</head>
<body class="   hs-content-id-4908310180 hs-site-page page hs-content-path- hs-content-name-home  " style="">
  <div class="header-container-wrapper">
  <div class="header-container container-fluid">

<?php include('menu.php'); ?>


  <h1 style="text-align: center">Update Your Information</h1>
	<div class="formbox">
  <form class="container" action="manageaccount.php" method="post">
    <div class="names">
    <label>Name:</label>
		<?php echo "<input type='text' name='firstname' value='$firstname'>" ?>
		<?php echo "<input type='text' name='lastname' value='$lastname'>" ?>
    </div>
    <div class="names">
    <label>E-Mail:</label>
		<?php echo "<input type='email' name='email' value='$email'>" ?>
    <br>
    <label>Company Name:</label>
		<?php echo "<input type='text' name='companyname' value='$companyname'>" ?>
    <br>
    <label>Phone:</label>
	<?php echo "<input type='phone' name='phone' value='$telephone'>" ?>
    <br>
    <div class="reg_submit">
    <input type="submit" name="update" value="Update" style="cursor: pointer">
    </div>
    </div>
	<a href="changepassword.php">Reset Password</a>
	<br>
  <?php echo $msg; ?>
  </form>
</div>


</body>

</html>
