<?php
include('../connect.php');
if (isset($_GET['rob_id'])) {
    $id = $_GET['rob_id'];

    $deleteQuery = "DELETE FROM `rob_level_income` WHERE rob_id = $id";

    if (mysqli_query($con, $deleteQuery)) {
        echo '<script>alert("ROB Level Income data Delected successfully!");window.location.href = "rob_level_table.php";</script>';
        
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}
?>