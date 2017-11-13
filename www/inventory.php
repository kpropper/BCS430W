<?php
include("sqlConnect.php");
include("siteInit.php");
//include('menu.php');
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
          data: "ModelName="+val,
          success: function(data){
            $("#sTagList").html(data);
              //alert(data);
          }
        });
      }
  /*   \Service tag function
        function getSTagId(val){
        //alert(val);
        $.ajax({
          type: "POST",
          url: "gethddata.php",
          data: "PartNumber="+val,
          success: function(data){
            $("#hdList").html(data);
              //alert(data);
          }
        });
      }
      */

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
<!--
    <div class="service_tag col col-sm-3 col-md-2 col-lg-2">
      <label>Service Tag/Part Number</label>
      <select name="service_tag" id="sTagList" onchange="getSTagId(this.value);">
          <option value="">Select Service Tag/Part Number</option>
      </select>
    </div>
-->
    <div class="service_tag col col-sm-3 col-md-2 " style="width:225px;">
      <label>Service Tag</label>
      <input class="service_tag_txt" type="text" style="width:85%; height:35px;	color:white;background-color: black;	opacity: 0.8; 	line-height: 40px;	font-size: 20px;margin-right: .1%;">
     </input>
    </div>

    <div class="hard_drives col col-sm-3 col-md-2 " style="width:225px;">
      <label>Hard Drives</label>
      <select name="hard_drives" id="hdList">
          <option value="">Select Hard Drives</option>
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

    </div>

    <div class="processors col col-sm-3 col-md-2 " style="width:225px;">
      <label>Processors</label>
      <select name="processors" id="pList">
          <option value="">Select a Processor</option>
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

    </div>

    <div class="memory col col-sm-3 col-md-2 " style="width:225px;">
      <label>Memory</label>
      <select name="memory" id="ramList">
          <option value="">Select Memory</option>
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
    </div>

    <div class="condition col col-sm-3 col-md-2 " style="width:225px;">
      <label>Condition</label>
      <select name="condition">
          <option value="">Select Condition</option>
          <option value="">Excellent</option>
          <option value="">Good</option>
          <option value="">Fair</option>

      </select>
    </div>

  </div>
</div>
<!--Php table  -->
<div id="asset_list">

</div>

<!--Button to add current asset to php table, submit button to submmit current asset to table, and save button to save current assets -->
<div class="btn_asset content-area group section" >
  <div class="row">
    <button class="add_asset col col-md-1" type="button" style="width:188px;" >ADD ITEM</button>
    <button class="save_assets col col-md-2" type="button" style="width:188px;">SAVE</button>
    <button class="submit_btn col col-md-2" type="submit" style="width:188px;">SUBMIT</button>
  </div>
</div>
</body>
</html>
