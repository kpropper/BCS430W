<?php
include("getmoddata.php");
if(!empty($_POST["ModelName"])) {

  //$cid = $_POST["CategoryID"];
  $modname = $_POST["ModelName"];
  // Just filling the Fields with data
  $query = "SELECT * FROM assetmodel where PartNumber != ''";
  //This is the query that will cascade the dropdownlist
//  $query = "" ;
if($query)
{
   $results = mysqli_query($mysqli, $query);
  ?><option value="">Select Part Number</option><?php
    foreach ($results as $service_tag) {
      ?>
    <option value="<?php echo $service_tag["PartNumber"];?>"><?php echo $service_tag["PartNumber"]?> </option>
    <?php
       }
  }
}
   ?>
