<?php
include('../connect.php');
include('./header.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM `category_master` WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $category = $_POST['catagory'];
    $sub_category = $_POST['sub_catagory'];
    $package_or_product_name = $_POST[$type . '_Name'];

    $query = "UPDATE `category_master` SET `type`=?, `category`=?, `sub_category`=?, `pkorpd_name`=? WHERE `id` = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssssi", $type, $category, $sub_category, $package_or_product_name, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Category updated successfully!');</script>";
        echo "<script>window.location.href='./category_master_table.php';</script>";
    } else {
        echo "<script>alert('No changes made to category!');</script>";
    }
}
?>

<section>

    <div class="page-container">

        <form class="check-details" id="categoryForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="check-details">
                <center>
                    <h1 style="font-size: 150%;">Category Master</h1>
                </center>
                <div class="check-items">
                

                    <label for="selectType" class="head-lines">Select Package or Product</label>
                    <select id="selectType" name="type" class="user-id">
                        <option value="<?php echo $row['type']; ?>"><?php echo $row['type']; ?></option>
                        <option value="package">
                            Package </option>
                        <option value="product">
                            Product</option>
                    </select>

                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Category Name</label><BR>
                    <input type="text" class="txt-user-id" name="catagory" value="<?php echo $row['category']; ?>" placeholder="Enter Category Name" required>
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Sub-Category Name</label><BR>
                    <input type="text" class="txt-user-id" name="sub_catagory" value="<?php echo $row['sub_category']; ?>" placeholder="Enter Sub-Category Name" required>
                </div>
                <div id="packageFields" class="check-items">
                    <label for="packageName" class="active-id">Package Name</label><BR>
                    <input type="text" id="packageName" class="txt-user-id" value="<?php echo $row['pkorpd_name']; ?>" name="package_Name" placeholder="Enter Package Name">
                </div>
                <div id="productFields" style="display: none;" class="check-items">
                    <label for="productName" class="active-id">Product Name</label><BR>
                    <input type="text" id="productName" class="txt-user-id" value="<?php echo $row['pkorpd_name']; ?>" name="product_Name" placeholder="Enter Product Name">
                </div>

                <div class="button-check-div">
                    <a href="./category_master_table.php"><button type="button" class="button-check red">BACK</button></a>
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