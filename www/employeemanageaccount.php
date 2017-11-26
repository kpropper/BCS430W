<?php
	include('siteInit.php');
	include("employeeaccountmanagement.php");
	//If a user is not logged in they shouldn't be here, kick them out
	if(!$loggedIn || $userType != 'Employee')
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
  <form class="container" action="employeemanageaccount.php" method="post">
	<div class="names">
		<select name='userUserType'>
		<?php
			if($userUserType == "Employee")
			{
			echo"<option value='Client'>Client</option>
				<option value='Employee'selected>Employee</option>";
			}
			else
			{
			echo"<option value='Client' selected>Client</option>
				<option value='Employee'>Employee</option>";
			}
		?>
		</select>
	</div>
    <div class="names">
    <label>Name:</label>
		<?php echo "<input type='text' name='userFirstName' value='$userfirstname'>" ?>
		<?php echo "<input type='text' name='userLastName' value='$userlastname'>" ?>
    </div>
    <div class="names">
    <label>E-Mail:</label>
		<?php echo "<input type='email' name='userEmail' value='$useremail'>" ?>
    <br>
    <label>Company Name:</label>
		<?php echo "<input type='text' name='userCompanyName' value='$usercompanyname'>" ?>
    <br>
    <label>Phone:</label>
	<?php echo "<input type='phone' name='userTelephone' value='$usertelephone'>" ?>
    <br>
	<label>Value Multiplier:</label>
	<?php echo "<input type='phone' name='userUserMult' value='$userValueMult'>" ?>
	<?php echo "<input type='hidden' name='userUserID' value='$useruserID'>" ?>
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
