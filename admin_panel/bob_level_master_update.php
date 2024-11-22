<?php
include('header.php');
include('../connect.php');

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $query = "SELECT * FROM `bob_level_income` WHERE bob_id = ?";
  $stmt = $con->prepare($query);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
}

if (isset($_POST['submit'])) {
  $id = $_POST['bob_id'];
  $type = $_POST['packageorproduct'];
  $category = $_POST['category'];
  $sub_category = $_POST['sub_category'];
  $packagename = $_POST['packagename'];
  $self = $_POST['self'];
  $level_1 = $_POST['level_1'];
  $level_2 = $_POST['level_2'];
  $level_3 = $_POST['level_3'];
  $level_4 = $_POST['level_4'];
  $level_5 = $_POST['level_5'];

  // Update the record in the database
  $updateQuery = "UPDATE `bob_level_income` 
                   SET type = ?, 
                       category = ?, 
                       sub_category = ?, 
                       packagename = ?, 
                       self = ?, 
                       level_1 = ?, 
                       level_2 = ?, 
                       level_3 = ?, 
                       level_4 = ?, 
                       level_5 = ?
                   WHERE bob_id = ?";

  $stmt = $con->prepare($updateQuery);
  $stmt->bind_param("ssssssssssi", $type, $category, $sub_category, $packagename, $self, $level_1, $level_2, $level_3, $level_4, $level_5, $id);
  if ($stmt->execute()) {
    echo '<script>alert("BOB Level Income data Update successfully!");window.location.href = "bob_level_table.php";</script>';
  } else {
    echo "Error updating record: " . $stmt->error;
  }
}


?>

<script>
  function showType(str) {
    if (str === "") {
      document.getElementById("categoryHint").innerHTML = "";
      return;
    } else {
      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            document.getElementById("categoryHint").innerHTML = xhr.responseText;
          } else {
            console.error(`Error: ${xhr.status} - ${xhr.statusText}`);
          }
        }
      };
      xhr.open("GET", `get_categories.php?q=${str}`, true);
      xhr.send();
    }
  }



  function showCategory(str) {
    if (str == "") {
      document.getElementById("subCategoryHint").innerHTML = "";
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("subCategoryHint").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", `get_subcategories.php?q=${str}`, true);
      xmlhttp.send();
    }
  }

  function showSubCategory(str) {
    if (str == "") {
      document.getElementById("productHint").innerHTML = "";
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("productHint").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", `get_package_names.php?q=${str}`, true);
      xmlhttp.send();
    }
  }
</script>
<style>
.red{
  position: relative;
  left: 0.5vw;
}

</style>
<section>

  <div class="page-container">


    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="check-details" method="post">
      <input type="hidden" name="bob_id" value="<?php echo $row['bob_id']; ?>">

      <center>
        <h1 style="font-size: 150%;">BOB Level Income Master </h1><samp style="font-size: 90%;">(Wallet Based)</samp>
      </center>

      <div class="check-items">
        <h2 class="head-lines">Select Package or Product</h2>
        <select name="packageorproduct" id="headline" class="user-id" onchange="showType(this.value)">
        <option value="<?php echo $row['type']; ?>"><?php echo $row['type']; ?></option>
          <option value="product">Product</option>
          <option value="package">Package</option>

        </select>
      </div>
      <div class="check-items">
        <h2 class="head-lines">Category</h2>
        <select name="category" class="user-id" onchange="showCategory(this.value)" id="categoryHint">
          <option value="<?php echo $row['category']; ?>"><?php echo $row['category']; ?></option>
        </select>
      </div>

      <div class="check-items">
        <h2 class="head-lines">Sub-Category</h2>
        <select name="sub_category" class="user-id" onchange="showSubCategory(this.value)" id="subCategoryHint">
          <option value="<?php echo $row['sub_category']; ?>"><?php echo $row['sub_category']; ?></option>
        </select>
      </div>

      <div class="check-items">
        <h2 class="head-lines" id="packageNameHeadline">Product Name</h2>
        <select name="packagename" class="user-id"  id="productHint">
          <option value="<?php echo $row['packagename']; ?>"><?php echo $row['packagename']; ?></option>
        </select>
      </div>
      <div class="check-items">
        <label for="name" class="active-id">Self</label><BR>
        <input type="text" class="txt-user-id" value="<?php echo $row['self']; ?>" name="self" placeholder="Enter Add %">
      </div>

      <div class="check-items">
        <label for="name" class="active-id">Level-1</label><BR>
        <input type="text" class="txt-user-id" value="<?php echo $row['level_1']; ?>" name="level_1" placeholder="Enter Add %">
      </div>
      <div class="check-items">
        <label for="name" class="active-id">Level-2</label><BR>
        <input type="text" class="txt-user-id" value="<?php echo $row['level_2']; ?>" name="level_2" placeholder="Enter Add %">
      </div>
      <div class="check-items">
        <label for="name" class="active-id">Level-3</label><BR>
        <input type="text" class="txt-user-id" value="<?php echo $row['level_3']; ?>" name="level_3" placeholder="Enter Add %">
      </div>
      <div class="check-items">
        <label for="name" class="active-id">Level-4</label><BR>
        <input type="text" class="txt-user-id" value="<?php echo $row['level_4']; ?>" name="level_4" placeholder="Enter Add %">
      </div>
      <div class="check-items">
        <label for="name" class="active-id">Level-5</label><BR>
        <input type="text" class="txt-user-id" value="<?php echo $row['level_5']; ?>" name="level_5" placeholder="Enter Add %">
      </div>



      <div class="button-check-div">
        <a href="./masters.php"><button type="button" class="button-check red">BACK</button></a>
        <input type="submit" class="button-check green" value="Update" name="submit">
      </div><br><br><br><br><br><br>
    </form>
  </div>
</section>