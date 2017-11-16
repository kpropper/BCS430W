<?php
include("sqlConnect.php");
include("siteInit.php");
//include('menu.php');
//If a user is not logged in they shouldn't be here, kick them out
if(!$loggedIn)
{
	echo "<script> location.href='index.php'; </script>";
}
var_dump($_POST);
var_dump($_SESSION);
//Variables
$pgm = 'inventory.php';

if (isset($_POST['task']))
{
	$task = $_POST['task'];

	if($task == "Add Item")
	{
		$modid = $_SESSION['modelid'];
		$hdtype = $_SESSION['hdtype'];
		$hdsize = $_SESSION['hdsize'];
		$hdqty = $_SESSION['hdqty'];
		$proctype = $_SESSION['proctype'];
		$procspeed = $_SESSION['procspeed'];
		$procqty = $_SESSION['procqty'];
		$memtype = $_SESSION['memtype'];
		$memsize = $_SESSION['memsize'];
		$memqty = $_SESSION['memqty'];
		$condition = $_SESSION['condition'];
		$allset = true;

		$query = "SELECT HardDriveID
				 FROM HardDrive
				 WHERE
				 HardDriveType = '$hdtype'
				 AND HardDriveSize = '$hdsize'
				 AND HardDriveQty = '$hdqty'";

		$result = $mysqli->query($query);
		if($result->num_rows == 1)
		{
			list($hdID) = $result->fetch_row();
			echo "Hard Drive ID = $hdID";
		}

//		$query = "SELECT MemoryID
//				FROM Memory
//				 WHERE
//				 MemoryType = '$memtype'
//				 AND MemorySize = '$memsize'
//				 AND MemoryQty = '$memqty'";

//		$result = $mysqli->query($query);
//		if($result->num_rows == 1)
//		{
//			list($memID) = $result->fetch_row();
//		}

	}

}

?>
<!DOCTYPE html>
<html>
<head>
  <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
  <link rel="stylesheet" href="css/main.css" />
  <title>Inventory Page</title>
  <script>
      function getCId(val){
        //alert(val);
        $.ajax({
          type: "POST",
          url: "getdata.php",
          data: "CategoryID="+val,
          success: function(data){
            $("#mList").html(data);
              //alert(data);
          }
        });
      }

      function getManId(val){
        //alert(val);
        $.ajax({
          type: "POST",
          url: "getmoddata.php",
          data: "ManufacturerID="+val,
          success: function(data){
            $("#modList").html(data);
              //alert(data);
          }
        });
      }
      function getModId(val){
        //alert(val);
        $.ajax({
          type: "POST",
          url: "getstagdata.php",
          data: "ModelID="+val,
          success: function(data){

              //alert(data);
          }
        });
      }
       function gethdtypeId(val){
        //alert(val);
        $.ajax({
          type: "POST",
          url: "getstagdata.php",
          data: "HardDriveType="+val,
          success: function(data){

              //alert(data);
          }
        });
      }
      function gethdsizeId(val){
       //alert(val);
       $.ajax({
         type: "POST",
         url: "getstagdata.php",
         data: "HardDriveSize="+val,
         success: function(data){

             //alert(data);
         }
       });
     }
     function gethdqtyId(val){
      //alert(val);
      $.ajax({
        type: "POST",
        url: "getstagdata.php",
        data: "HardDriveQty="+val,
        success: function(data){

            //alert(data);
        }
      });
    }
    function getproctypeId(val){
     //alert(val);
     $.ajax({
       type: "POST",
       url: "getstagdata.php",
       data: "ProcessorType="+val,
       success: function(data){

           //alert(data);
       }
     });
   }
   function getprocspeedId(val){
    //alert(val);
    $.ajax({
      type: "POST",
      url: "getstagdata.php",
      data: "ProcessorSpeed="+val,
      success: function(data){

          //alert(data);
      }
    });
  }
  function getprocqtyId(val){
   //alert(val);
   $.ajax({
     type: "POST",
     url: "getstagdata.php",
     data: "ProcessorQty="+val,
     success: function(data){

         //alert(data);
     }
   });
 }
 function getmemtypeId(val){
  //alert(val);
  $.ajax({
    type: "POST",
    url: "getstagdata.php",
    data: "MemoryType="+val,
    success: function(data){

        //alert(data);
    }
  });
}
function getmemsizeId(val){
 //alert(val);
 $.ajax({
   type: "POST",
   url: "getstagdata.php",
   data: "MemorySize="+val,
   success: function(data){

       //alert(data);
   }
 });
}
function getmemqtyId(val){
 //alert(val);
 $.ajax({
   type: "POST",
   url: "getstagdata.php",
   data: "MemoryQty="+val,
   success: function(data){       //alert(data);
   }
 });
}
function getcondId(val){
 //alert(val);
 $.ajax({
   type: "POST",
   url: "getstagdata.php",
   data: "ConditionID="+val,
   success: function(data){
       //alert(data);
   }
 });
}
    </script>
</head>
<body>
<header>
  <a href="index.php" id="hs-link-logo" style="border-width:0px;border:0px;"><img src="http://www.itamg.com/hubfs/2017%20site%20implementation/i-t-a-m-g-main-logo-1.svg?t=1507222056603" class="hs-image-widget " style="width:122px;border-width:0px;border:0px;" width="122" alt="ITAMG" title="ITAMG"></a>
  <h1>
    Welcome
    <?php echo $fullName;
    echo ", " . $userEmail;
    ?>
  </h1>
</header>

<div class="inv_box content-area group section">
  <div class= "row">

    <div class="category col col-sm-3 col-md-2" style="width:225px;">
      <label>Category</label>
      <select name="category" onchange="getCId(this.value);" >
          <option value="">Select Category</option>
          <!-- populate dropdownlist using php -->
          <?php
            $query = "SELECT * FROM assetcategory";
            $result = mysqli_query($mysqli, $query);
              //loop
            foreach ($result as $category) {
          ?>
           <option value="<?php echo $category["CategoryID"];?>"><?php echo $category['CategoryName']?> </option>
           <?php
              }
           ?>
      </select>

    </div>

    <div class="manufacturer col col-sm-3 col-md-2" style="width:225px;">
      <label>Manufacturer</label>
      <select name="manufacturer" id="mList" onchange="getManId(this.value);" >
          <option value="">Select Manufacturer</option>
      </select>
    </div>

    <div class="model col col-sm-3 col-md-2" style="width:225px;">
      <label>Model</label>
      <select name="model" id="modList" onchange="getModId(this.value);">
          <option value="">Select Model</option>

      </select>

    </div>

    <div class="service_tag col col-sm-3 col-md-2 " style="width:225px;">
      <label>Service Tag</label>
      <input class="service_tag_txt" type="text" style="width:85%; height:35px;	color:white;background-color: black;	opacity: 0.8; 	line-height: 40px;	font-size: 20px;margin-right: .1%;">
     </input>
    </div>


    <div class="hard_drives col col-sm-3 col-md-2 " style="width:225px;">
      <!-- Hard drive Type Select option field-->
      <label>Hard Drive Type</label>
      <select  name="hard_drive_type" id="hdtype" onchange="gethdtypeId(this.value);">
          <option value="">Select HD Type</option>
          <!-- populate dropdownlist using php -->
          <?php
            $query = "SELECT DISTINCT HardDriveType from harddrive where HardDriveType != 'None' and HardDriveType != 'N/A' ORDER BY HardDriveType";
            $result = mysqli_query($mysqli, $query);
              //loop
            foreach ($result as $hd) {
          ?>
           <option value="<?php echo $hd["HardDriveType"];?>"><?php echo $hd['HardDriveType']?> </option>
           <?php
              }
           ?>
      </select>

      <!-- Hard drive size Select option field-->
      <label>Hard drive size</label>
      <select name='hard_drive_size' id='hdsize' onchange='gethdsizeId(this.value);'>
          <option value="">Select HD Size</option>
          <!-- populate dropdownlist using php -->
          <?php
          $query = "SELECT DISTINCT HardDriveSize from harddrive where HardDriveSize != 'None' and HardDriveSize != 'N/A'";
          $result = mysqli_query($mysqli, $query);
              //loop
            foreach ($result as $hd) {
          ?>
           <option value="<?php echo $hd["HardDriveSize"];?>"><?php echo $hd['HardDriveSize']?> </option>
           <?php
              }
           ?>
      </select>

      <!-- Hard drive quantity Select option field-->
      <label>Hard drive quantity</label>
      <select name='hard_drive_quantity' id='hdqty' onchange='gethdqtyId(this.value);'>
          <option value="">Select HD Quantity</option>
          <!-- populate dropdownlist using php -->
          <?php
          $query = "SELECT DISTINCT HardDriveQty from harddrive ORDER BY HardDriveQty;";
          $result = mysqli_query($mysqli, $query);
              //loop
            foreach ($result as $hd) {
          ?>
           <option value="<?php echo $hd["HardDriveQty"];?>"><?php echo $hd['HardDriveQty']?> </option>
           <?php
              }
           ?>
      </select>



    </div>

    <div class="processors col col-sm-3 col-md-2 " style="width:225px;">
      <!-- Processor Type Select option field-->
      <label>Processor Type</label>
      <select name="ProcessorType" id="proctype" onchange='getproctypeId(this.value);'>
          <option value="">Select Processor Type</option>
          <!-- populate dropdownlist using php -->
          <?php
            $query = "SELECT DISTINCT ProcessorType from Processor WHERE ProcessorType != 'None' and ProcessorSpeed != 'N/A'";
            $result = mysqli_query($mysqli, $query);
              //loop
            foreach ($result as $processor) {
          ?>
           <option value="<?php echo $processor["ProcessorType"];?>"><?php echo $processor['ProcessorType']?> </option>
           <?php
              }
           ?>
      </select>

      <!-- Processor Speed Select option field--->
      <label>Processor Speed</label>
      <select name='processor_speed' id='procspeed' onchange='getprocspeedId(this.value);'>
        <option value="">Select Processor Type</option>
        <!-- populate dropdownlist using php -->
        <?php
          $query = "SELECT DISTINCT ProcessorSpeed from Processor where ProcessorSpeed != 0";
          $result = mysqli_query($mysqli, $query);
            //loop
          foreach ($result as $processor) {
        ?>
         <option value="<?php echo $processor["ProcessorSpeed"];?>"><?php echo $processor['ProcessorSpeed']?> </option>
         <?php
            }
         ?>
      </select>

      <!-- Processor Quantity Select option field--->
      <label>Processor Quantity</label>
      <select name='processor_quantity' id='procqty' onchange='getprocqtyId(this.value);'>
        <option value="">Select Processor Quantity</option>
        <!-- populate dropdownlist using php -->
        <?php
          $query = "SELECT DISTINCT ProcessorQty from Processor where ProcessorQty != 0 ORDER BY ProcessorQty";
          $result = mysqli_query($mysqli, $query);
            //loop
          foreach ($result as $processor) {
        ?>
         <option value="<?php echo $processor["ProcessorQty"];?>"><?php echo $processor['ProcessorQty']?> </option>
         <?php
            }
         ?>
      </select>
    </div>

    <div class="memory col col-sm-3 col-md-2 " style="width:225px;">
      <!-- Memory Type Select option field--->
      <label>Memory Type</label>
      <select name="MemoryType" id="memtype" onchange='getmemtypeId(this.value);'>
          <option value="">Select Memory Type</option>
          <!-- populate dropdownlist using php -->
          <?php
            $query = "SELECT DISTINCT MemoryType FROM Memory WHERE MemoryType != 'None' and MemoryType != 'N/A'";
            $result = mysqli_query($mysqli, $query);
              //loop
            foreach ($result as $memory) {
          ?>
           <option value="<?php echo $memory["MemoryType"];?>"><?php echo $memory['MemoryType']?> </option>
           <?php
              }
           ?>
      </select>

      <!-- Memory Size Select option field--->
      <label>Memory Size</label>
      <select name='memory_size' id='memsize' onchange='getmemsizeId(this.value);'>
      <option value=''>Select Memory Size</option>
      <!-- populate dropdownlist using php -->
      <?php
        $query = "SELECT DISTINCT MemorySize from Memory where MemorySize != 'N/A'";
        $result = mysqli_query($mysqli, $query);
          //loop
        foreach ($result as $memory) {
      ?>
       <option value="<?php echo $memory["MemorySize"];?>"><?php echo $memory['MemorySize']?> </option>
       <?php
          }
       ?>
      </select>

      <!-- Memory Quantity Select option field--->
      <label>Memory Quantity</label>
      <select name='memory_quantity' id='memqty' onchange='getmemqtyId(this.value);'>
        <option value=''>Select Memory Quantity</option>
        <!-- populate dropdownlist using php -->
        <?php
          $query = "SELECT DISTINCT MemoryQty from Memory ORDER BY MemoryQty";
          $result = mysqli_query($mysqli, $query);
            //loop
          foreach ($result as $memory) {
        ?>
         <option value="<?php echo $memory["MemoryQty"];?>"><?php echo $memory['MemoryQty']?> </option>
         <?php
            }
         ?>
      </select>
    </div>

    <div class="condition col col-sm-3 col-md-2 " style="width:225px;">
      <label>Condition</label>
      <select name="condition" onchange='getcondId(this.value);' id="condid">
          <option value="">Select Condition</option>
          <option value="Excellent">Excellent</option>
          <option value="Good">Good</option>
          <option value="Fair">Fair</option>

      </select>
    </div>

  </div>
</div>
<!--Php table  -->
<div id="asset_list">

<?php

//$query = "SELECT HardDriveID
//				 FROM HardDrive
//				 WHERE
//				 HardDriveType = '$_SESSION['hdtype']'
//				 AND HardDriveSize = '$_SESSION['hdsize']'
//				 AND HardDriveQty = '$_SESSION['hdqty']'";

//$result = $mysqli->query($query);
//if($result->num_rows == 1)
//{
//	list($hdID) = result->fetch_row();
//}

//$query = "SELECT MemoryID
//				 FROM Memory
//				 WHERE
//				 MemoryType = '$_SESSION['memtype']'
//				 AND MemorySize = '$_SESSION['memsize']'
//				 AND MemoryQty = '$_SESSION['memqty']'";

//$result = $mysqli->query($query);
//if($result->num_rows == 1)
//{
//	list($memID) = result->fetch_row();
//}
//echo "<br /><h1>THE FOLLOWING ARE THE STORED VAR'S </h1>";

//$modid = $_SESSION['modelid'];
//$hdtype = $_SESSION['hdtype'];
//$hdsize = $_SESSION['hdsize'];
//$hdqty = $_SESSION['hdqty'];
//$proctype = $_SESSION['proctype'];
//$procspeed = $_SESSION['procspeed'];
//$procqty = $_SESSION['procqty'];
//$memtype = $_SESSION['memtype'];
//$memsize = $_SESSION['memsize'];
//$memqty = $_SESSION['memqty'];
//echo $modid .$hdtype . $hdsize .$hdqty.$proctype. $procspeed. $procqty. $memtype. $memsize. $memqty. $memqty ;

//Button to add current asset to php table, submit button to submmit current asset to table, and save button to save current assets
echo"<form class='btn_asset content-area group section' action='$pgm' method='post'>
<div class='row'>
	<input class= 'add_asset col col-md-1' type='submit' name='task' value='Add Item' style='width:188px;'></input>
	<input class= 'submit_btn col col-md-2' type='submit' name='task' value='Submit' style='width:188px;'></input>
	</div>
</form>";
?>

</div>


</body>
</html>
