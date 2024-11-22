<?php
include('../connect.php');
include('./user_header.php');

if (isset($_POST["swallet_add"])) {
    // Query to get active users
    $query = "SELECT userid FROM users WHERE activation_status = 'Active'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $active_user_ids = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $active_user_ids[] = $row['userid'];
        }

        // Process each active user
        $amount = 3000; // Define the amount as an integer

        // Update transaction table in bulk
        $query = "UPDATE transaction SET swallet = swallet + ?, swallet_balance = swallet_balance + ? WHERE userids = ?";
        $stmt = mysqli_prepare($con, $query);

        foreach ($active_user_ids as $user_id) {
            mysqli_stmt_bind_param($stmt, "iis", $amount, $amount, $user_id);
            if (!mysqli_stmt_execute($stmt)) {
                echo "Error updating user ID $user_id: " . mysqli_stmt_error($stmt) . "<br>";
            } else {
                echo "UserID: $user_id, TODAY INCOME: $amount<br>";
            }
        }
    } else {
        echo "No active users found.";
    }
}
?>

<div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="submit" name="swallet_add" value="swalletadd">
    </form>
</div>