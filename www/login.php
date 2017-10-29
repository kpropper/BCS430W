<?php include("siteLogon.php");
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
     <div class="header-container-wrapper">
     <div class="header-container container-fluid">

   <div class="row-fluid-wrapper row-depth-1 row-number-1 ">
   <div class="row-fluid ">
   <div class="span12 widget-span widget-type-global_group " style="" data-widget-type="global_group" data-x="0" data-w="12">
   <!-- start coded_template: id:4905847840 path:generated_global_groups/4905847835.html -->
   <div class="" data-global-widget-path="generated_global_groups/4905847835.html"><div class="row-fluid-wrapper row-depth-1 row-number-1 ">
   <div class="row-fluid ">
   <div class="span12 widget-span widget-type-cell header" style="" data-widget-type="cell" data-x="0" data-w="12">

   <div class="row-fluid-wrapper row-depth-1 row-number-2 ">
   <div class="row-fluid ">
   <div class="span12 widget-span widget-type-cell wrapper" style="" data-widget-type="cell" data-x="0" data-w="12">

   <div class="row-fluid-wrapper row-depth-1 row-number-3 ">
   <div class="row-fluid ">
   <div class="span2 widget-span widget-type-logo logo" style="" data-widget-type="logo" data-x="0" data-w="2">
   <div class="cell-wrapper layout-widget-wrapper">
   <span id="hs_cos_wrapper_logo" class="hs_cos_wrapper hs_cos_wrapper_widget hs_cos_wrapper_type_logo" style="" data-hs-cos-general-type="widget" data-hs-cos-type="logo"><a href="index.html" id="hs-link-logo" style="border-width:0px;border:0px;"><img src="http://www.itamg.com/hubfs/2017%20site%20implementation/i-t-a-m-g-main-logo-1.svg?t=1507222056603" class="hs-image-widget " style="width:122px;border-width:0px;border:0px;" width="122" alt="ITAMG" title="ITAMG"></a></span></div><!--end layout-widget-wrapper -->
   </div><!--end widget-span -->
   <div class="span10 widget-span widget-type-menu nav-menu new-menu-primary" style="" data-widget-type="menu" data-x="2" data-w="10">
   <div class="cell-wrapper layout-widget-wrapper">
   <span id="hs_cos_wrapper_module_1488549292250447" class="hs_cos_wrapper hs_cos_wrapper_widget hs_cos_wrapper_type_menu" style="" data-hs-cos-general-type="widget" data-hs-cos-type="menu"><div id="hs_menu_wrapper_module_1488549292250447" class="hs-menu-wrapper active-branch flyouts hs-menu-flow-horizontal" role="navigation" data-sitemap-name="Header Nav">
   <!--<button onclick="document.getElementById('id01').style.display='block'">Login</button>
   -->
   <ul >
   <li class="hs-menu-item hs-menu-depth-1"><a href="login.html" >LOGIN/SIGN UP</a></li>
   <li class="hs-menu-item hs-menu-depth-1 "><a href="#">SOLUTIONS</a></li>
   <li class="hs-menu-item hs-menu-depth-1"><a href="#">CREDENTIALS</a></li>
   <li class="hs-menu-item hs-menu-depth-1"><a href="#">RESOURCES</a></li>
   <li class="hs-menu-item hs-menu-depth-1"><a href="#">CONTACT</a></li>
   <li class="hs-menu-item hs-menu-depth-1"><a href="inventory.php">GET A QUOTE</a></li>
   </ul>
   </div></span></div><!--end layout-widget-wrapper -->
   </div><!--end widget-span -->
   </div><!--end row-->
   </div><!--end row-wrapper -->

   </div><!--end widget-span -->
   </div><!--end row-->
   </div><!--end row-wrapper -->

   </div><!--end widget-span -->
   </div><!--end row-->
   </div><!--end row-wrapper -->
 </div>
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
        <?php echo $msg;
        if($msg == "Why am I here?"){
          //Temporary redirect to inventory page.
          echo "<script> location.href='inventory.php'; </script>";
          exit;
        }?>
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
