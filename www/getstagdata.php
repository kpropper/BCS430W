<?php
include("getmoddata.php");
include("siteInit.php");


  //$cid = $_POST["CategoryID"];
  if(isset($_POST["ModelID"])) 			$_SESSION['modelid'] = $_POST["ModelID"];
  if(isset($_POST["HardDriveType"]))  	$_SESSION['hdtype'] = $_POST["HardDriveType"];
  if(isset($_POST["HardDriveSize"]))  	$_SESSION['hdsize'] = $_POST["HardDriveSize"];
  if(isset($_POST["HardDriveQty"]))  	$_SESSION['hdqty'] = $_POST["HardDriveQty"];
  if(isset($_POST["ProcessorType"]))  	$_SESSION['proctype'] = $_POST["ProcessorType"];
  if(isset($_POST["ProcessorSpeed"])) 	$_SESSION['procspeed'] = $_POST["ProcessorSpeed"];
  if(isset($_POST["ProcessorQty"]))  	$_SESSION['procqty'] = $_POST["ProcessorQty"];
  if(isset($_POST["MemoryType"]))  		$_SESSION['memtype'] = $_POST["MemoryType"];
  if(isset($_POST["MemorySize"]))  		$_SESSION['memsize'] = $_POST["MemorySize"];
  if(isset($_POST["MemoryQty"]))  		$_SESSION['memqty'] = $_POST["MemoryQty"];
  if(isset($_POST["ConditionID"]))  	$_SESSION['condition'] = $_POST["ConditionID"];
  if(isset($_POST["AssetQty"]))  	    $_SESSION['assetqty'] = $_POST["AssetQty"];
  if(isset($_POST["UniqueId"]))  	    $_SESSION['uniqueid'] = $_POST["UniqueId"];

//if($_POST['HardDriveType'] != NULL){
//  echo
//}
?>
