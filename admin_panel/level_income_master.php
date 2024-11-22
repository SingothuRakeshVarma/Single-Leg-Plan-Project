<?php
include('header.php');
include('../connect.php');

if (isset($_POST['submit'])) {
  $packageorproduct = $_POST['packageorproduct'];
  $category = $_POST['category'];
  $sub_category = $_POST['sub_category'];
  $packagename = $_POST['packagename'];
  $self = $_POST['self'];
  $level_1 = $_POST['level_1'];
  $level_2 = $_POST['level_2'];
  $level_3 = $_POST['level_3'];
  $level_4 = $_POST['level_4'];
  $level_5 = $_POST['level_5'];
  $level_6 = $_POST['level_6'];
  $level_7 = $_POST['level_7'];
  $level_8 = $_POST['level_8'];
  $level_9 = $_POST['level_9'];
  $level_10 = $_POST['level_10'];


  
  function generate_user_id($length = 6)
  {
    $characters = '123456789';
    $user_id = '';
    for ($i = 0; $i < $length; $i++) {
      $user_id .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $user_id;
  }

  $user_id = generate_user_id();


  $query = "SELECT * FROM level_income_master WHERE type ='$packageorproduct' AND packagename = '$packagename'";
  $result = mysqli_query($con, $query);
  if (mysqli_num_rows($result) > 0) {
    echo '<script>alert("Level Income data Already Exit!");window.location.href = "level_income_master.php";</script>';
  } else {

    if (empty($user_id) || empty($packageorproduct) || empty($category) || empty($sub_category) || empty($packagename) || empty($self) || empty($level_1) || empty($level_2) || empty($level_3) || empty($level_4) || empty($level_5) || empty($level_6) || empty($level_7)|| empty($level_8)|| empty($level_9)|| empty($level_10)) {
      echo "All fields are required.";
    } else {
      // Insert data into the 'cortd' table
      $sql = " INSERT INTO `level_income_master`(`product_id`, `type`, `category`, `sub_category`, `packagename`, `self`, `level_1`, `level_2`, `level_3`, `level_4`, `level_5`, `level_6`, `level_7`, `level_8`, `level_9`, `level_10`) 
    VALUES ('$user_id','$packageorproduct','$category','$sub_category','$packagename','$self','$level_1','$level_2','$level_3','$level_4','$level_5','$level_6','$level_7','$level_8','$level_9','$level_10')";

      if ($con->query($sql) === TRUE) {
        echo '<script>alert("Level Income data saved successfully!");window.location.href = "level_income_master.php";</script>';
      } else {
        echo "Error: " . $sql . "<br>" . $con->error;

        echo "User not found!";
      }
    }
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
<section>

  <div class="page-container">

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="check-details" method="post">

      <div class="check-details">
        <center>
          <h1 style="font-size: 150%;">Level Income Master</h1>
        </center>
        <div class="check-items">
          <h2 class="head-lines">Select Package or Product</h2>
          <select name="packageorproduct" id="headline" class="user-id" onchange="showType(this.value)">
            <option value="">Select Type</option>
            <option value="product">Product</option>
            <option value="package">Package</option>

          </select>
        </div>
        <div class="check-items">
          <h2 class="head-lines">Category</h2>
          <select name="category" class="user-id" onchange="showCategory(this.value)" id="categoryHint">
            <option value="">Select Category</option>
          </select>
        </div>

        <div class="check-items">
          <h2 class="head-lines">Sub-Category</h2>
          <select name="sub_category" class="user-id" onchange="showSubCategory(this.value)" id="subCategoryHint">
            <option value="">Select Sub-Category</option>
          </select>
        </div>

        <div class="check-items">
          <h2 class="head-lines" id="packageNameHeadline">Product Name</h2>
          <select name="packagename" class="user-id" id="productHint">
            <option value="">Select Package Name</option>
          </select>
        </div>
        <div class="check-items">
          <label for="name" class="active-id">Self</label><BR>
          <input type="text" class="txt-user-id" name="self" placeholder="Enter Value">
        </div>
        <div class="check-items">
          <label for="name" class="active-id">Level 1</label><BR>
          <input type="text" class="txt-user-id" name="level_1" placeholder="Enter Value">
        </div>
        <div class="check-items">
          <label for="name" class="active-id">Level 2</label><BR>
          <input type="text" class="txt-user-id" name="level_2" placeholder="Enter Value">
        </div>
        <div class="check-items">
          <label for="name" class="active-id">Level 3</label><BR>
          <input type="text" class="txt-user-id" name="level_3" placeholder="Enter Value">
        </div>
        <div class="check-items">
          <label for="name" class="active-id">Level 4</label><BR>
          <input type="text" class="txt-user-id" name="level_4" placeholder="Enter Value">
        </div>
        <div class="check-items">
          <label for="name" class="active-id">Level 5</label><BR>
          <input type="text" class="txt-user-id" name="level_5" placeholder="Enter Value">
        </div>
        <div class="check-items">
          <label for="name" class="active-id">Level 6</label><BR>
          <input type="text" class="txt-user-id" name="level_6" placeholder="Enter Value">
        </div>
        <div class="check-items">
          <label for="name" class="active-id">Level 7</label><BR>
          <input type="text" class="txt-user-id" name="level_7" placeholder="Enter Value">
        </div>
        <div class="check-items">
          <label for="name" class="active-id">Level 8</label><BR>
          <input type="text" class="txt-user-id" name="level_8" placeholder="Enter Value">
        </div>
        <div class="check-items">
          <label for="name" class="active-id">Level 9</label><BR>
          <input type="text" class="txt-user-id" name="level_9" placeholder="Enter Value">
        </div>
        <div class="check-items">
          <label for="name" class="active-id">Level 10</label><BR>
          <input type="text" class="txt-user-id" name="level_10" placeholder="Enter Value">
        </div>

        <div class="button-check-div">
          <a href="./masters.php"><button type="button" class="button-check red">BACK</button></a>
          <input type="submit" class="button-check green" value="submit" name="submit">
        </div><br><br><br><br><br><br>
      </div>
    </form>
  </div>
</section>