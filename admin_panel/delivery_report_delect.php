<?php
include('../connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_GET['user_id'];
    $product = $_GET['product_name'];

    $deleteQuery = "DELETE FROM `product_delivery` WHERE product_id = '$id' AND user_id = '$user_id' AND product_name = '$product'";

    if (mysqli_query($con, $deleteQuery)) {
        echo '<script>alert("Product Delivery data Delected successfully!");window.location.href = "delivery_report_table.php";</script>';
        
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}

?>