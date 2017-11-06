<?php
	include('siteInit.php');
	include("accountManagement.php");
	//If a user is logged in they shouldn't be here, kick them out
	if($loggedIn)
	{
		echo "<script> location.href='selectLanding.php'; </script>";
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
  <h1 style="text-align: center">Update Your Information</h1>
  <form class="container" action="register.php" method="post">
    <div class="names">
    <label>Name:</label>
      <input type="text" name="firstname" value="" placeholder="First">
      <input type="text" name="lastname" value="" placeholder="Last">
    </div>
    <div class="input_fields">
    <label>E-Mail:</label>
    <?php echo "<input type='email' name='email' value='$firstname'>" ?>
    <br>
    <label>Password:</label>
    <input type="password" name="password" value="" placeholder="Password">
    <br>
    <label>Verify Password:</label>
    <input type="password" name="verifypassword" value="" placeholder="Verify Password">
    <br>
    <label>Company Name:</label>
    <input type="text" name="companyname" placeholder="Company Name">
    <br>
    <label>Phone:</label>
    <input type="text" name="phone" placeholder="Phone">
    <br>
    <div class="reg_submit">
    <input type="submit" name="register" value="Register" style="cursor: pointer">
    </div>
    </div>
  <?php echo $msg; ?>
  </form>
</div>


</body>

</html>
