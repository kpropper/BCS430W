<?php
include("getdata.php");
if(!empty($_POST["ManufacturerName"])) {

  //$cid = $_POST["CategoryID"];
  $mname = $_POST["ManufacturerName"];
  // Just filling the Fields with data
  $query = "SELECT * from assetmodel";
  //This is the query that will cascade the dropdownlist
//  $query = "SELECT DISTINCT ModelName, (SELECT ManufacturerID FROM manufacturer WHERE ManufacturerName = $mname ) AS ManufacturerID FROM assetmodel am WHERE am.CategoryID = $cid" ;
if($query)
{
   $results = mysqli_query($mysqli, $query);
  ?><option value="">Select Model</option><?php
    foreach ($results as $model) {
      ?>
    <option value="<?php echo $model["ModelName"];?>"><?php echo $model["ModelName"]?> </option>
    <?php
       }
  }
}
   ?>
