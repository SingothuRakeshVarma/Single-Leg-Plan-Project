<?php
include('../connect.php');
include('./header.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_GET['user_id'];
    $product_name = $_GET['product_name'];

    $query = "SELECT * FROM `product_delivery` WHERE product_id = ? AND user_id = ? AND product_name = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("isi", $id, $user_id, $product_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
}

if(isset($_POST["submit"])){
    $product_id = $_POST["product_id"];
    $user_id = $_POST["user_id"];
    $courie_name = $_POST["courie_name"];
    $courie_id = $_POST["courie_id"];
    $status = $_POST["status"];


    $query = "UPDATE `product_delivery` SET `courier_name`=?,`courier_id`=?,`status`=? WHERE product_id = ? AND user_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sssss", $courie_name, $courie_id, $status, $product_id, $user_id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo '<script>alert("Product Dispatch successfully!");window.location.href = "delivery_report_table.php";</script>';
    } else {
        echo "Error updating product_delivery table: " . $con->error;
    }
}

?>

<section>

    <center>
        <h1 style="font-size: 150%;">Delivery Report Update</h1>
    </center>
    <div class="page-container">

        <form class="check-details" id="categoryForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">

            <div class="check-items">
                <label for="name" class="active-id">User ID</label><BR>
                <input type="text" class="txt-user-id" value="<?php echo $row['user_id']; ?>" readonly>

            </div>
            <div class="check-items">
                <label for="name" class="active-id">User Name</label><BR>
                <input type="text" class="txt-user-id" value="<?php echo $row['user_name']; ?>" readonly>
            </div>
            <div id="packageFields" class="check-items">
                <label for="packageName" class="active-id">Product ID</label><BR>
                <input type="text" class="txt-user-id" value="<?php echo $row['product_id']; ?>" readonly>
            </div>
            <div id="productFields" class="check-items">
                <label for="productName" class="active-id">Product Name</label><BR>
                <input type="text" class="txt-user-id" value="<?php echo $row['product_name']; ?>" readonly>
            </div>
            <div id="productFields" class="check-items">
                <label for="productName" class="active-id">Courier Name</label><BR>
                <input type="text" class="txt-user-id" name="courie_name" value="<?php echo $row['courier_name']; ?>" placeholder="Enter Courier Name">
            </div>
            <div id="productFields" class="check-items">
                <label for="productName" class="active-id">Courier ID</label><BR>
                <input type="text" class="txt-user-id" name="courie_id" value="<?php echo $row['courier_id']; ?>" placeholder="Enter Courier ID">
            </div>
            <div id="productFields" class="check-items">
                <label for="productName" class="active-id">Address</label><BR>
                <textarea rows="5" cols="40" readonly><?php echo $row['addres']; ?></textarea>

            </div>
            <div id="productFields" class="check-items">
                <label for="productName" class="active-id">Status</label><BR>
                <input type="text" class="txt-user-id" name="status" value="<?php echo $row['status']; ?>">
            </div>

            <div class="button-check-div">
                <a href="./delivery_report_table.php"><button type="button" class="button-check red">BACK</button></a>
                <input type="submit" class="button-check green" name="submit" value="submit">

            </div><br><br><br>

        </form>
    </div>
</section>