<?php
include('../connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $deleteQuery = "DELETE FROM `bob_level_income` WHERE bob_id = $id";

    if (mysqli_query($con, $deleteQuery)) {
        echo '<script>alert("BOB Level Income data Delected successfully!");window.location.href = "bob_level_table.php";</script>';
        
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}

?>