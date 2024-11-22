<?php
include('header.php');
include('../connect.php');






?>
<style>
    .avatar-img {
        width: 200px;
        height: 200px;
    }
</style>
<script>
    
    function showType(str1) {
  if (str1 === "") {
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
    xhr.open("GET", `get_categories.php?q=${str1}`, true);
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
    xmlhttp.open("GET",`get_subcategories.php?q=${str}`, true);
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
        xmlhttp.open("GET",`get_package_names.php?q=${str}`,true);
        xmlhttp.send();
      }
    }

   
</script>

<section>
    <center>
        <h1 style="font-size: 250%; position: relative; top:3vw;">Package Master</h1>
    </center>

    <form class="page-container" action="register.php" method="post" enctype="multipart/form-data">


        <div>
            <input type="file" id="image-input" name="image"></br>
            <img class="avatar-img" id="image-preview" src="" alt="Image Preview" value="<?php echo $image; ?>" readonly>
        </div>
        <div class="check-details">

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
                <select name="category" class="user-id" onchange="showCategory(this.value)" id="categoryHint" >
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
                <select name="packagename" class="user-id"  id="productHint">
                    <option value="">Select Package Name</option>
                </select>
            </div>

            <div class="check-items">
                <label for="name" class="active-id">MRP</label><BR>
                <input type="text" class="txt-user-id" placeholder="Enter MRP" name="mrp" id="mrp">
            </div>
            <div class="check-items">
                <label for="name" class="active-id">DP</label><BR>
                <input type="text" class="txt-user-id" placeholder="Enter DP" name="dp" id="dp">
            </div>
            <div class="check-items">
                <label for="name" class="active-id">SPV</label><BR>
                <input type="text" class="txt-user-id" placeholder="Enter SPV" name="spv" id="spv">
            </div>
            <div class="check-items">
                <label for="name" class="active-id">Referral Value</label><BR>
                <input type="text" class="txt-user-id" placeholder="Enter Referral Value" name="referralvalue" id="referralvalue">
            </div>
            <div class="check-items">
                <label for="name" class="active-id"> S-Wallet Discount %</label><BR>
                <input type="text" class="txt-user-id" placeholder="Enter S-Wallet Discount %" name="swalletdiscount" id="swalletdiscount">
            </div>
            <div class="check-items">
                <label for="name" class="active-id"> Add S-Wallet Fund</label><BR>
                <input type="text" class="txt-user-id" placeholder="Enter Add S-Wallet Fund" name="addswalletfund" id="addswalletfund">
            </div>
            <div class="check-items">
                <h2 class="head-lines">Package Algibulity Type</h2>

                <select name="packagealgibulitytype" class="user-id" id="packagealgibulitytype">
                    <option value="Select Package Algibulity Type">Select Package Algibulity Type</option>
                    <option value="Add Amount">
                        Add Amount</option>
                    <option value="Number Of Days">
                        Number Of Days</option>


                </select>

            </div>
            <div class="check-items">
                <label for="name" class="active-id"> Package Algibulity</label><BR>
                <input type="text" class="txt-user-id" placeholder="Enter Package Algibulity" name="packagealgibulity" id="packagealgibulity">
            </div>
            <div class="check-items">
                <label for="name" class="active-id"> Cash Back Amount</label><BR>
                <input type="text" class="txt-user-id" placeholder="Enter Cash Back Amount" name="cashbackamount" id="cashbackamount">
            </div>
            <div class="check-items">
                <label for="name" class="active-id">Share Fond</label><BR>
                <input type="text" class="txt-user-id" placeholder="Enter Share Fond" name="sharefond" id="sharefond">
            </div>
            <div class="check-items">
                <label for="name" class="active-id"> No.Of Share Points</label><BR>
                <input type="text" class="txt-user-id" placeholder="Enter Share Points" name="noofsharepoints" id="noofsharepoints">
            </div>
            <div class="check-items">
                <label for="name" class="active-id"> Product Description</label><BR>
                <textarea rows="5" cols="40" placeholder="Enter Product Description" name="productdescription" id="productdescription"></textarea>
            </div>

            <div class="button-check-div">
                <a href="./masters.php"><button type="button" class="button-check red">BACK</button></a>
                <button type="submit" value="submit" class=" button-check green">
                    Sudmit
                </button>
            </div><br><br><br><br><br><br>
        </div>
    </form>
</section>
<script>
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');

    imageInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        const reader = new FileReader();

        reader.onload = (event) => {
            imagePreview.src = event.target.result;
        };

        reader.readAsDataURL(file);

        const formData = new FormData();
        formData.append('image', file);

        fetch('images.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then((data) => {
                console.log(data);
                // Store the image in local storage
                localStorage.setItem('image', data.image);
            })
            .catch((error) => {
                console.error(error);
            });
    });

</script>