<?php
include('../connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $deleteQuery = "DELETE FROM ` level_income_master` WHERE id = $id";

    if (mysqli_query($con, $deleteQuery)) {
        echo '<script>alert("Level Income Master data Delected successfully!");window.location.href = " level_income_master_table.php";</script>';
        
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}

?>