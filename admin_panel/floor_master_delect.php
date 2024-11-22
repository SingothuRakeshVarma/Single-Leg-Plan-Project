<?php
include('../connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Assuming you have a MySQLi connection set up as $mysqli
    $deleteQuery = "DELETE FROM `floor_master` WHERE floor_id = ?";
    
    $stmt = $con->prepare($deleteQuery);
    $stmt->bind_param('s', $id); // 's' indicates the type is string
    
    if ($stmt->execute()) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record.";
    }
}

?>