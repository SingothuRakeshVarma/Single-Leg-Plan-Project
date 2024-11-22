<?php
include('./header.php');
include('../connect.php');

if (isset($_POST['submit'])) {
    $type = $_POST['type'];
    $catagory = $_POST['catagory'];
    $sub_catagory = $_POST['sub_catagory'];
    $package_Name = $_POST['package_Name'];
    $product_Name = $_POST['product_Name'];



    $query = "SELECT * FROM category_master WHERE type = ? AND category = ? AND sub_category = ? AND (pkorpd_name = ? OR pkorpd_name = ?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $type, $catagory, $sub_catagory, $product_Name, $package_Name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo '<script>alert("Already Exists. Try Another One");window.location.href = "category_master.php";</script>';
    } else {

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

        $query = "INSERT INTO category_master (id, type, category, sub_category, pkorpd_name) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        if ($type == 'package') {
            mysqli_stmt_bind_param($stmt, "issss", $user_id, $type, $catagory, $sub_catagory, $package_Name);
        } else {
            mysqli_stmt_bind_param($stmt, "issss", $user_id, $type, $catagory, $sub_catagory, $product_Name);
        }
        if (mysqli_stmt_execute($stmt)) {
            echo '<script>alert("Data Saved On Database");window.location.href = "category_master.php";</script>';
        } else {
            echo "Error updating amount: " . mysqli_error($con);
        }
    }
}


?>


<section>

    <div class="page-container">

        <form class="check-details" id="categoryForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

            <div class="check-details">
                <center>
                    <h1 style="font-size: 150%;">Category Master</h1>
                </center>
                <div class="check-items">

                    <label for="selectType" class="head-lines">Select Package or Product</label>
                    <select id="selectType" name="type" class="user-id">
                        <option value="">Select Package or Product </option>
                        <option value="package">
                            Package </option>
                        <option value="product">
                            Product</option>
                    </select>

                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Category Name</label><BR>
                    <input type="text" class="txt-user-id" name="catagory" placeholder="Enter Category Name" required>
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Sub-Category Name</label><BR>
                    <input type="text" class="txt-user-id" name="sub_catagory" placeholder="Enter Sub-Category Name" required>
                </div>
                <div id="packageFields" class="check-items">
                    <label for="packageName" class="active-id">Package Name</label><BR>
                    <input type="text" id="packageName" class="txt-user-id" name="package_Name" placeholder="Enter Package Name">
                </div>
                <div id="productFields" style="display: none;" class="check-items">
                    <label for="productName" class="active-id">Product Name</label><BR>
                    <input type="text" id="productName" class="txt-user-id" name="product_Name" placeholder="Enter Product Name">
                </div>

                <div class="button-check-div">
                    <a href="./masters.php"><button type="button" class="button-check red">BACK</button></a>
                    <input type="submit" class="button-check green" name="submit" value="submit">

                </div><br><br><br><br><br><br>
            </div>
        </form>
    </div>
</section>
<script>
    // JavaScript to handle form changes
    const selectType = document.getElementById('selectType');
    const packageFields = document.getElementById('packageFields');
    const productFields = document.getElementById('productFields');

    selectType.addEventListener('change', () => {
        if (selectType.value === 'package') {
            packageFields.style.display = 'block';
            productFields.style.display = 'none';
        } else if (selectType.value === 'product') {
            productFields.style.display = 'block';
            packageFields.style.display = 'none';
        }
    });
</script>