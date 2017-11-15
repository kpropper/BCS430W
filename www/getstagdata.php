<?php
include("getmoddata.php");
include("siteInit.php");


  //$cid = $_POST["CategoryID"];
  $_SESSION['modelid'] = $_POST["ModelID"];
  $_SESSION['hdsize'] = $_POST["HardDriveSize"];
  $_SESSION['hdqty'] = $_POST["HardDriveQty"];
  $_SESSION['proctype'] = $_POST["ProcessorType"];
  $_SESSION['procspeed'] = $_POST["ProcessorSpeed"];
  $_SESSION['procqty'] = $_POST["ProcessorQty"];
  $_SESSION['memtype'] = $_POST["MemoryType"];
  $_SESSION['memsize'] = $_POST["MemorySize"];
  $_SESSION['memqty'] = $_POST["MemoryQty"];


   ?>
