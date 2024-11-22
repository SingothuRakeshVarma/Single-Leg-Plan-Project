<?php
include('../connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $deleteQuery = "DELETE FROM `cartdata` WHERE productcode  = $id";

    if (mysqli_query($con, $deleteQuery)) {
        echo '<script>alert("Cart data Delected successfully!");window.location.href = "cart_data_table.php";</script>';
        
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}

?>