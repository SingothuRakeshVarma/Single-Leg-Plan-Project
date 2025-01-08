<?php
include('../connect.php');

if (isset($_GET['user_id']) && isset($_GET['subject'])) {
    $user_id = $_GET['user_id'];
    $subject = $_GET['subject'];

    $query = "DELETE FROM complaint_box WHERE user_id = '$user_id' AND subject = '$subject'";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "<script>alert('Complaint Deleted Successfully!');window.location.href = 'admin_contact_us.php';</script>";
    } else {
        echo "<script>alert('Failed to delete complaint!');window.location.href = 'admin_contact_us.php';</script>";
    }
}
?>