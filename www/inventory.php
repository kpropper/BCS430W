<?php
include("sqlConnect.php");
?>
<!DOCTYPE html>
<html>
<head>
  <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
  <link rel="stylesheet" href="css/main.css" />
  <title>Inventory Page</title>
  <script>
      function getId(val){
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
    </script>
</head>
<body>

<div class="inv_box content-area group section">

  <div class= "row">
    <div class="category col col-sm-3 col-md-2 col-lg-2">
      <label>Category</label>
      <select name="category" onchange="getId(this.value);">
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

    <div class="manufacturer col col-sm-3 col-md-2 col-lg-2">
      <label>Manufacturer</label>
      <select name="manufacturer" id="mList">
          <option value="">Select Manufacturer</option>
      </select>
    </div>

    <div class="model col col-sm-3 col-md-2 col-lg-2">
      <label>Model</label>
      <select name="model" id="modList">
          <option value="">Select Model</option>
      </select>

    </div>

    <div class="service_tag col col-sm-3 col-md-2 col-lg-2">
      <label>Service Tag</label>
      <select name="service_tag" id="sTagList">
          <option value="">Select Service Tag</option>
      </select>

    </div>

    <div class="hard_drives col col-sm-3 col-md-2 col-lg-2">
      <label>Hard Drives</label>
      <select name="hard_drives" id="hdList">
          <option value="">Select Hard Drives</option>
      </select>

    </div>

    <div class="processors col col-sm-3 col-md-2 col-lg-2">
      <label>Processors</label>
      <select name="processors" id="pList">
          <option value="">Select a Processor</option>
      </select>

    </div>

    <div class="ram col col-sm-3 col-md-2 col-lg-2">
      <label>Ram</label>
      <select name="ram" id="ramList">
          <option value="">Select Ram</option>
      </select>

    </div>
  </div>
</div>

</body>
</html>
