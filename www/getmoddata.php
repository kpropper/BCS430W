<?php
 include("getdata.php");
 include("siteInit.php");
if(!empty($_POST["ManufacturerID"])) {

  $cid = $_SESSION["cid"];
  $mid = $_POST["ManufacturerID"];
  $_SESSION["manufacturerid"] = $mid;
  // Just filling the Fields with data
  //$query = "SELECT * from assetmodel";
  //This is the query that will cascade the dropdownlist
  $query = "SELECT DISTINCT ModelName FROM assetmodel am WHERE am.CategoryID = $cid AND am.ManufacturerID = $mid";

   $results = mysqli_query($mysqli, $query);
  ?><option value="">Select Model</option><?php
    foreach ($results as $model) {
      ?>
    <option value="<?php echo $model["ModelName"];?>"><?php echo $model["ModelName"]?> </option>
    <?php
       }

}
?>
