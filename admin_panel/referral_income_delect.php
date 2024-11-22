<?php
include('../connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $deleteQuery = "DELETE FROM `referal_income` WHERE product_id = $id";

    if (mysqli_query($con, $deleteQuery)) {
        echo '<script>alert("Referral Income Master data Delected successfully!");window.location.href = "referral_income_table.php";</script>';
        
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}

?>