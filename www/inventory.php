<?php
include("sqlConnect.php");
include("siteInit.php");
include("menu.php");

//If a user is not logged in they shouldn't be here, kick them out
if(!$loggedIn)
{
	echo "<script> location.href='index.php'; </script>";
}

function getStatus($invID)
{
	include("sqlConnect.php");
	$query = "SELECT Status.StatusName
				      FROM Inventory JOIN Status ON Inventory.StatusID = Status.StatusID
				      WHERE
			          Inventory.InventoryID = '$invID'";
			$result = $mysqli->query($query);
			if($result)
			{
				list($statusName) = $result->fetch_row();
				$thisStatus = $statusName;
			}
			else $thisStatus = NULL;

			return $thisStatus;
}

//Variables
$pgm = 'inventory.php';
$msg = NULL;
$errmsg = NULL;
$company = "ITAMG";

if (isset($_POST['inventoryID']))   $invID = $_POST['inventoryID'];	else $invID = NULL;

if (isset($_POST['task']))
{
	$task = $_POST['task'];


	$modname = $_SESSION['modelid'];
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
		$assetqty = $_SESSION['assetqty'];
		$uniqueid  =$_SESSION['uniqueid'];
		$assetValue = 0;

		if(is_numeric($assetqty)) $assetqty = intval($assetqty);
		
		$allnull = true;

		if($modname != NULL) $allnull = false;
		if($hdtype != NULL) $allnull = false;
		if($hdsize != NULL) $allnull = false;
		if($hdqty != NULL) $allnull = false;
		if($proctype != NULL) $allnull = false;
		if($procspeed != NULL) $allnull = false;
		if($memtype != NULL) $allnull = false;
		if($memsize != NULL) $allnull = false;
		if($memqty  != NULL) $allnull = false;
		if($condition != NULL) $allnull = false;
		if($procqty != NULL) $allnull = false;
		if($assetqty != NULL) $allnull = false;
		if($uniqueid != NULL) $allnull = false;


	if($task == "Add Item" || ($task == "Submit" && !$allnull))
	{

		if($invID != NULL)
		{
			$statusName = getStatus($invID);
			if(!($statusName == 'Started' || $statusName == 'Open'))
			{
				$errmsg = "This inventory is not available to be updated, please contact a $company representative.";
			}

		}
		if($errmsg == NULL)
		{

			//If no inventory exists, create an inventory
			if($invID == NULL)
			{
				$query = "INSERT INTO Inventory SET UserID = '$userID'";
				$result = $mysqli->query($query);

				if($result)
				{
					$invID = $mysqli->insert_id;
					$query = "INSERT INTO Status SET
						  InventoryID = '$invID',
						  StatusName = 'Started',
						  StatusMessage = 'Inventory Created'";

					$result = $mysqli->query($query);
					if($result)
					{
						$statID = $mysqli->insert_id;
						$query = "Update Inventory SET
							 StatusID = '$statID'
							 WHERE
							 InventoryID = '$invID'";
						$result = $mysqli->query($query);
						if(!$result) $errmsg = "Unable to update inventory status " . mysqli_error($mysqli);
					}
					else $errmsg = "Inventory Status NOT created " . mysqli_error($mysqli);
				}
				else $errmsg = "Inventory NOT created " . mysqli_error($mysqli);

			}

			//Get the qty
			if ($errmsg == NULL)
			{
				if(is_int($assetqty))
				{
					if($assetqty >= 1 && $assetqty <= 999)
					{
						//You're good... I thought I may want to do something here but I probably don't
						//I could eliminate this by reversing the condition and just use the else value...
					}
					else $errmsg = "Invalid Quantity";

				}
				else $errmsg = "Invalid Quantity " . $assetqty . " " . gettype($assetqty);
			}

			if ($errmsg == NULL)
			{
				//Find the Hard drive ID
				if($hdtype == NULL || $hdqty == 0)
				{
					$hdID = 1;
				}
				elseif ($hdtype != NULL && ($hdsize == NULL || $hdqty == NULL))
				{
					$errmsg = "Invalid Hard Drive Configuration";
				}
				else
				{
					//Get the hard drive id
					$query = "SELECT HardDriveID, HardDriveValue
					      FROM HardDrive
						  WHERE
						  HardDriveType = '$hdtype'
						  AND HardDriveSize = '$hdsize'
						  AND HardDriveQty = '$hdqty'";

					$result = $mysqli->query($query);
					if($result)
					{
						if($result->num_rows == 1)
						{
							list($hdID, $hdValue) = $result->fetch_row();
							$assetValue += $hdValue;
						}
						else $errmsg = "Hard Drive NOT found, Please consult $company staff for assistance.";
					}
					else $errmsg = "Hard Drive NOT Found " . mysqli_error($mysqli);
				}

				//Find the memory ID
				if ($errmsg == NULL)
				{
					if($memtype == NULL || $memqty == 0)
					{
						$memID = 1;
					}
					elseif ($memtype != NULL && ($memsize == NULL || $memqty == NULL))
					{
						$errmsg = "Invalid Memory Configuration";
					}
					else
					{
						$query = "SELECT MemoryID, MemoryValue
							  FROM Memory
							  WHERE
							  MemoryType = '$memtype'
						      AND MemorySize = '$memsize'
							  AND MemoryQty = '$memqty'";

						$result = $mysqli->query($query);
						if($result)
						{
							if($result->num_rows == 1)
							{
								list($memID, $memValue) = $result->fetch_row();
								$assetValue += $hdValue;
							}
							else $errmsg = "Memory NOT found, Please consult $company staff for assistance.";
						}
						else $errmsg = "Memory NOT Found " . mysqli_error($mysqli);
					}
				}
				//Find the processor ID
				if ($errmsg == NULL)
				{
					if($proctype == NULL || $procqty == 0)
					{
						$procID = 1;
					}
					elseif ($proctype != NULL && ($procspeed == NULL || $procqty == NULL))
					{
						$errmsg = "Invalid Processor Configuration";
					}
					else
					{
						$query = "SELECT ProcessorID, ProcessorValue
							  FROM Processor
							  WHERE
							  ProcessorType = '$proctype'
							  AND ProcessorSpeed = '$procspeed'
							  AND ProcessorQty = '$procqty'";

						$result = $mysqli->query($query);
						if($result)
						{
							if($result->num_rows == 1)
							{
								list($procID, $procValue) = $result->fetch_row();
								$assetValue += $procValue;
							}
							else $errmsg = "Processor NOT found, Please consult $company staff for assistance.";
						}
						else $errmsg = "Processor NOT Found " . mysqli_error($mysqli);
					}
				}
				//Find the Asset ID
				if ($errmsg == NULL)
				{
					if($modname != NULL)
					{
						$query = "SELECT ModelID, AssetModelValue
						FROM AssetModel
						WHERE
						ModelName = '$modname'";

						$result = $mysqli->query($query);
						if($result)
						{
							if($result->num_rows == 1)
							{
								list($modID, $assetModelValue) = $result->fetch_row();
								$assetValue += $assetModelValue;
							}
						}
						else $errmsg = "Model NOT Found " . mysqli_error($mysqli);
					}
					else $errmsg = "Invalid Model, Please consult $company staff for assistance.";
				}
			}

			if ($errmsg == NULL)
			{
				if($_SESSION['condition'] != NULL)
				{
					$condition = $_SESSION['condition'];
					switch($condition)
					{
						case 'Excellent':
							$valuemultiplier = 1;
							break;
						case 'Good':
							$valuemultiplier = .8;
							break;
						case 'Fair':
							$valuemultiplier = .5;
							break;
						default:
							$errmsg = "Item NOT added, invalid item condition.";
					}
				}
				else $errmsg = "Item NOT added, no item condition specified.";

				if($errmsg == NULL)
				{
					if($assetqty > 1) $uniqueid = "Multiple";

					//Create the the asset
					$query = "INSERT INTO Asset SET
						  Quantity = '$assetqty',
						  ModelID = '$modID',
						  InventoryID = '$invID',
						  HardDriveID = '$hdID',
						  ProcessorID = '$procID',
						  MemoryID = '$memID',
						  AssetValue = '$assetValue',
						  SerialNumber = '$uniqueid',
						  CustomerConditionMod = '$valuemultiplier'";
					$result = $mysqli->query($query);
					if ($result)
					{
						$assetID = $mysqli->insert_id;
						$msg = "Asset Added";
					}
					else
					{
						$errmsg = "Asset NOT Added" . mysqli_error($mysqli);
					}
				}
			}
		}
	}

	$statusName = getStatus($invID);
	if(!($statusName == 'Started' || $statusName == 'Open'))
	{
		$errmsg = "This inventory is not available to be updated, please contact a $company representative.";
	}

	if($errmsg == NULL)
	{
		if($task == "Delete")
		{
			$assetID = $_POST['assetID'];
			$query = "DELETE FROM Asset WHERE AssetID = '$assetID'";
			$result = $mysqli->query($query);
			if($result) $msg = "Item $assetID Deleted.";
			else $errmsg = "Item $assetID NOT Deleted" . mysqli_error($mysqli);
		}

		elseif($task == "Submit")
		{
			$query = "SELECT AssetID
					  FROM Asset
					  WHERE InventoryID = '$invID'";
			$result = $mysqli->query($query);
			if($result)
			{
				if($result->num_rows >=1)
				{
					$invValue = 0;
					//Get the value of all of the assets
					$query = "SELECT AssetValue, CustomerConditionMod, Quantity
				      FROM Asset
				      WHERE
			          InventoryID = '$invID'";

					$result = $mysqli->query($query);
					if($result)
					{
						while(list($assetValue, $valuemultiplier, $quantity) = $result->fetch_row())
						{
							$invValue += (($assetValue * $quantity) * $valuemultiplier);
							if($userMult >= .2) $lowMult = $userMult - .2; else $lowMult = 0;
							$initMax = ($invValue * $userMult);
							$initMin = ($invValue * $lowMult);
						}

						$query = "INSERT INTO Status SET
						  InventoryID = '$invID',
						  QuoteValue = '$invValue',
						  StatusName = 'Submitted',
						  StatusMessage = 'Inventory Submitted by $userFName $userLName'";

						$result = $mysqli->query($query);
						if($result) $statID = $mysqli->insert_id;
						else $errmsg = "Inventory Status NOT updated " . mysqli_error($mysqli);

						if($errmsg == NULL)
						{
							$query = "Update Inventory SET
								StatusID = '$statID',
								Inventory_Value = '$invValue',
								InitQuoteMin = '$initMin',
								InitQuoteMax = '$initMax'
								WHERE
								InventoryID = '$invID'";
							$result = $mysqli->query($query);
							if($result) $msg = "Inventory Submitted Sucessfully.";
							else $errmsg = "Unable to submit inventory $invID " . mysqli_error($mysqli);
						}
					}
					else $errmsg = "Unable to submit inventory, asset values not identified " . mysqli_error($mysqli);
				}
				else $errmsg = "Inventory NOT created, not assets in Inventory";
			}
		}
	}
}

	$_SESSION['modelid'] = 		NULL;
    $_SESSION['hdtype'] = 		NULL;
    $_SESSION['hdsize'] =		NULL;
    $_SESSION['hdqty'] = 		NULL;
    $_SESSION['proctype'] = 	NULL;
    $_SESSION['procspeed'] = 	NULL;
    $_SESSION['procqty'] = 		NULL;
    $_SESSION['memtype'] = 		NULL;
    $_SESSION['memsize'] = 		NULL;
    $_SESSION['memqty'] = 		NULL;
    $_SESSION['condition'] = 	NULL;
	$_SESSION['assetqty'] = 	NULL;
	$_SESSION['uniqueid'] =     NULL;

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
				if((val != 1)&&(val != 2)&&(val != 3)&&(val != 5)&&(val != 6)){
					document.getElementById("hdtype").disabled=true;
					document.getElementById("hdsize").disabled=true;
					document.getElementById("hdqty").disabled=true;
					document.getElementById("memqty").disabled=true;
					document.getElementById("memsize").disabled=true;
					document.getElementById("memtype").disabled=true;
					document.getElementById("procqty").disabled=true;
					document.getElementById("proctype").disabled=true;
					document.getElementById("procspeed").disabled=true;
					document.getElementById("hdtype").value('');
					document.getElementById("hdsize").value('');
					document.getElementById("hdqty").value('');
					document.getElementById("memqty").value('');
					document.getElementById("memsize").value('');
					document.getElementById("memtype").value('');
					document.getElementById("procqty").value('');
					document.getElementById("proctype").value('');
					document.getElementById("procspeed").value('');
				}
				else{
					document.getElementById("hdtype").disabled=false;
					document.getElementById("hdsize").disabled=false;
					document.getElementById("hdqty").disabled=false;
					document.getElementById("memqty").disabled=false;
					document.getElementById("memsize").disabled=false;
					document.getElementById("memtype").disabled=false;
					document.getElementById("procqty").disabled=false;
					document.getElementById("proctype").disabled=false;
					document.getElementById("procspeed").disabled=false;
				}
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
				 if(val == ""){
					 document.getElementById("hdsize").style.display = "none";
					 document.getElementById("hdqty").style.display = "none";
				 }
				 else{
					 document.getElementById("hdsize").style.display = "block";
					 document.getElementById("hdqty").style.display = "block";
				 }
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
			if(val == ""){
				document.getElementById("procqty").style.display = "none";
				document.getElementById("procspeed").style.display = "none";
			}
			else{
				document.getElementById("procqty").style.display = "block";
				document.getElementById("procspeed").style.display = "block";
			}
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
	 if(val == ""){
		 document.getElementById("memqty").style.display = "none";
		 document.getElementById("memsize").style.display = "none";
	 }
	 else{
		 document.getElementById("memqty").style.display = "block";
		 document.getElementById("memsize").style.display = "block";
	 }
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

function getassetqty(val){
 //alert(val);
 $.ajax({
   type: "POST",
   url: "getstagdata.php",
   data: "AssetQty="+val,
   success: function(data){
       //alert(data);
   }
 });
}

function getuniqueId(val){
 //alert(val);
 $.ajax({
   type: "POST",
   url: "getstagdata.php",
   data: "UniqueId="+val,
   success: function(data){
       //alert(data);
   }
 });
}
//Function to disable unless category id is set to 1,2,3,5 and 6

    </script>
</head>
<body>
<header>
  <!--<a href="index.php" id="hs-link-logo" style="border-width:0px;border:0px;margin-left:20px;"><img src="http://www.itamg.com/hubfs/2017%20site%20implementation/i-t-a-m-g-main-logo-1.svg?t=1507222056603" class="hs-image-widget " style="width:122px;border-width:0px;border:0px;" width="122" alt="ITAMG" title="ITAMG"></a> -->
  <h1 style="margin-left:20px;">
    Welcome
    <?php echo $fullName;
    echo ", " . $userEmail;
    ?>
  </h1>
</header>

<div class="inv_box content-area group section">
  <div class= "row">

  	<div class="asset_qty col col-sm-2 col-md-1 " style="width:100px;">
		<label>Quantity</label>
		<input onchange='getassetqty(this.value);' name="qty" type="number" min="1" max="999" style="width:85%; height:40px;	color:white;background-color: black;	opacity: 0.8; 	line-height: 40px;	font-size: 20px;margin-right: .1%;"></input>
	 </div>
    <div class="category col col-sm-3 col-md-2" style="width:200px;">
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

    <div class="manufacturer col col-sm-3 col-md-2" style="width:200px;">
      <label>Manufacturer</label>
      <select name="manufacturer" id="mList" onchange="getManId(this.value);" >
          <option value="">Select Manufacturer</option>
      </select>
    </div>

    <div class="model col col-sm-3 col-md-2" style="width:200px;">
      <label>Model</label>
      <select name="model" id="modList" onchange="getModId(this.value);">
         <option value="">Select Model</option>
      </select>
  	</div>

	  <div class="service_tag col col-sm-3 col-md-2 " style="width:200px;">
	     <label>Serial Number</label>
	     <input class="serial_tag_txt" type="text" onchange="getuniqueId(this.value);" style="width:85%; height:40px;	color:white;background-color: black;	opacity: 0.8; 	line-height: 40px;	font-size: 20px;margin-right: .1%;">
	     </input>
	  </div>


    <div class="hard_drives col col-sm-3 col-md-2 " style="width:220px;">
      <!-- Hard drive Type Select option field-->
      <label>Hard Drive Type</label>
      <select  name="hard_drive_type" id="hdtype" onchange="gethdtypeId(this.value);">
          <option value="">Select HDD Type</option>
          <!-- populate dropdownlist using php -->
          <?php
            $query = "SELECT DISTINCT HardDriveType from harddrive ORDER BY HardDriveType";
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

      <select name='hard_drive_size' id='hdsize' onchange='gethdsizeId(this.value);' style="display:none;">
          <option value="">HDD Size</option>
          <!-- populate dropdownlist using php -->
          <?php
          $query = "SELECT DISTINCT HardDriveSize from harddrive";
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

      <select name='hard_drive_quantity' id='hdqty' onchange='gethdqtyId(this.value);' style="display:none;">
          <option value="">HDD Quantity</option>
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

    <div class="processors col col-sm-3 col-md-2 " style="width:200px;">
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

      <select name='processor_speed' id='procspeed' onchange='getprocspeedId(this.value);' style="display:none;">
        <option value="">Processor Speed</option>
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

      <select name='processor_quantity' id='procqty' onchange='getprocqtyId(this.value);' style="display:none;">
        <option value="">Processor Quantity</option>
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

    <div class="memory col col-sm-3 col-md-2 " style="width:200px;">
      <!-- Memory Type Select option field--->
      <label>Memory Type</label>
      <select name="MemoryType" id="memtype" onchange='getmemtypeId(this.value);'>
          <option value="">Select Memory Type</option>
          <!-- populate dropdownlist using php -->
          <?php
            $query = "SELECT DISTINCT MemoryType FROM Memory";
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
      <select name='memory_size' id='memsize' onchange='getmemsizeId(this.value);' style="display:none;">
      <option value=''>Memory Size</option>
      <!-- populate dropdownlist using php -->
      <?php
        $query = "SELECT DISTINCT MemorySize from Memory";
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

      <select name='memory_quantity' id='memqty' onchange='getmemqtyId(this.value);' style="display:none;">
        <option value=''>Memory Quantity</option>
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

    <div class="condition col col-sm-3 col-md-2 " style="width:200px;">
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
echo"<table width='1024' id='assets'>
<tr>
<th>Asset Quantity</th>
<th>Category</th>
<th>Manufacturer</th>
<th>Model</th>
<th>Serial Number</th>
<th>Hard Drive</th>
<th>Processor</th>
<th>Memory</th>
<th>Delete Item</th>
</tr>";
if($invID != NULL)
{
	$query = "SELECT AssetCategory.CategoryName, Manufacturer.ManufacturerName, AssetModel.ModelName, HardDrive.HardDriveType,
                    HardDrive.HardDriveSize, HardDrive.HardDriveQty, Processor.ProcessorType, Processor.ProcessorSpeed, Processor.ProcessorQty,
                    Memory.MemoryType, Memory.MemorySize, Memory.MemoryQty, Asset.Quantity, Asset.SerialNumber, Asset.AssetID
					FROM Asset JOIN AssetModel ON Asset.ModelID = AssetModel.ModelID
					JOIN AssetCategory ON AssetModel.CategoryID = AssetCategory.CategoryID
					JOIN Manufacturer ON AssetModel.ManufacturerID = Manufacturer.ManufacturerID
					JOIN HardDrive ON Asset.HardDriveID = HardDrive.HardDriveID
					JOIN Memory ON Asset.MemoryID = Memory.MemoryID
					JOIN Processor ON Asset.ProcessorID = Processor.ProcessorID
					WHERE Asset.InventoryID = '$invID'
					ORDER BY Asset.AssetID";

	$result = $mysqli->query($query);
	if (!$result) echo mysqli_error($mysqli);
	//echo"<table width='1024' align='center'>";
	while(list($category, $manufacturer, $model, $hdtype, $hdsize, $hdqty, $proctype, $procspeed, $procqty, $memtype, $memsize, $memqty, $assqty, $assserial, $assetid) = $result->fetch_row())
	{
		$harddrive = "$hdqty - $hdtype $hdsize";
		$processor = "$procqty - $proctype $procspeed";
		$memory = "$memqty - $memsize $memtype";

		echo"<tr><td>$assqty</td>
		  <td>$category</td>
		  <td>$manufacturer</td>
		  <td>$model</td>
		  <td>$assserial</td>
		  <td>$harddrive</td>
		  <td>$processor</td>
		  <td>$memory</td>
		  <td><form action='inventory.php' method='post'>
			<input type='hidden' name='inventoryID' value='$invID'></input>
			<input type='hidden' name='assetID' value='$assetid'>
			<input type='submit' class='inventory-button' name='task' value='Delete'>
			</form>
		  </td>

			</tr>";
	}
}

//Button to add current asset to php table, submit button to submmit current asset to table
echo"</table><br><br><form class='btn_asset content-area group section' action='$pgm' method='post'>
<div class='row'>
	<input type='hidden' name='inventoryID' value='$invID'></input>
	<input class= 'add_asset col col-md-1' type='submit' name='task' value='Add Item' style='width:188px;'></input>
	<input class= 'submit_btn col col-md-2' type='submit' name='task' value='Submit' style='width:188px;'></input>
	</div>
	</form>
";

if($errmsg == NULL) echo "<br>$msg<br>";
else echo "<br>$errmsg<br>";

?>

</div>


</body>
</html>
