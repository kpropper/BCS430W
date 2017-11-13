<?php
include("sqlConnect.php");
include("siteInit.php");

if(!empty($_POST["CategoryID"])) {
$cid = $_POST["CategoryID"];
$_SESSION["cid"] = $cid;

  $query = "SELECT DISTINCT  ManufacturerName, a.ManufacturerID FROM manufacturer m JOIN assetmodel a ON m.ManufacturerID = a.ManufacturerID WHERE a.CategoryID = $cid";

  $results = mysqli_query($mysqli, $query);
  ?><option value="">Select Manufacturer</option><?php
    foreach ($results as $manufacturer) {
      ?>
    <option value="<?php echo $manufacturer["ManufacturerID"];?>"><?php echo $manufacturer["ManufacturerName"]?> </option>
    <?php
       }
  }
?>
