<?php
	include('siteInit.php');
	include("employeeaccountmanagement.php");
	//If a user is not logged in they shouldn't be here, kick them out
	if(!$loggedIn || $userType != 'Employee')
	{
		echo "<script> location.href='index.php'; </script>";
		echo "<script type='text/javascript'>alert('you got booted from emp management');</script>";
	}
?>
<html>
<head>
<link rel="stylesheet" href="css/main.css" />

<title>Employee Account Management</title>
</head>
<body class="   hs-content-id-4908310180 hs-site-page page hs-content-path- hs-content-name-home  " style="">
  <div class="header-container-wrapper">
  <div class="header-container container-fluid">

<?php include('menu.php'); ?>


  <h1 style="text-align: center">Update <?php echo $userfirstname.' ' . $userlastname; ?>'s Information</h1>
	<div class="formbox" style="margin-top:145px;">
  <form class="container"  action="employeemanageaccount.php" method="post">
	<div class="names">
		<b>User Type:
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
    Name:
		<?php echo "<input type='text' name='userFirstName' value='$userfirstname'>" ?>
		<?php echo "<input type='text' name='userLastName' value='$userlastname'>" ?>
    </div>
    <div class="names">
    E-Mail:
		<?php echo "<input tpe='email' name='userEmail' value='$useremail'>" ?>
    <br>
    Company Name:
		<?php echo "<input type='text' name='userCompanyName' value='$usercompanyname'>" ?>
    <br>
    Phone:
	<?php echo "<input type='phone' name='userTelephone' value='$usertelephone'>" ?>
    <br>
	Value Multiplier:
	<?php echo "<input type='phone' name='userUserMult' value='$userValueMult'>" ?>
	<?php echo "<input type='hidden' name='userUserID' value='$useruserID'>" ?>
    <br>
    <div class="reg_submit">
    <input type="submit" name="update" value="Update" style="cursor: pointer">
    </div>
    </div>
	</form>
	<?php

	echo "<form class='btn_submit_manage' style='text-align:center;'action='forgotpassword.php' method='post'>
		<input type='hidden' name='resetpassword' value='Reset Password'>
		<input type='hidden' name='fromuser' value='$useruserID'>
		<input type='hidden' name='email' value='$useremail'>
		<input type='submit' name='passwordreset' value='Reset Password'>
		<input type='submit' name='deleteuser' value='Delete User'></form>"; ?>

	<br />
  <?php echo $msg; ?>
  </form>
</div>


</body>

</html>
