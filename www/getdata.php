<?php
include("sqlConnect.php");

if(!empty($_POST["CategoryID"])) {

  $cid = $_POST["CategoryID"];
  $query = "SELECT DISTINCT  ManufacturerName FROM manufacturer m JOIN assetmodel a ON m.ManufacturerID = a.ManufacturerID WHERE a.CategoryID = $cid";

  $results = mysqli_query($mysqli, $query);
    foreach ($results as $manufacturer) {
      ?>
    <option value="<?php echo $manufacturer["ManufacturerName"];?>"><?php echo $manufacturer["ManufacturerName"]?> </option>
    <?php
       }
  }

?>
