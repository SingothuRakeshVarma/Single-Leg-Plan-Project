<?php
include('../connect.php');

   // Query to get active users
$query = "SELECT userid FROM users WHERE activation_status = 'Active'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    $active_user_ids = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $active_user_ids[] = $row['userid'];
    }

    // Get admin charges (SPV percentage)
    $query = "SELECT spv_parsentage FROM admin_charges WHERE id = 'admin'";
   $result = mysqli_query($con, $query);
   $row = mysqli_fetch_assoc($result);
    $spv_percentage = $row["spv_parsentage"];


    // Process each active user
// Get the count of active user IDs
$count = count($active_user_ids);

// Loop through each active user ID
// Initialize arrays to store values
$user_ids = array();
$team_pvs = array();
$totals = array();
$ewallet_balances = array();

// Loop through active user IDs
for ($i = 0; $i < $count; $i++) {
    $user_id = $active_user_ids[$i];

    // Get team PV for the user
    $query = "SELECT team_pv FROM transaction WHERE userids = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $team_pv = $row["team_pv"];

    // Store values in arrays
    $user_ids[] = $user_id;
    $team_pvs[] = $team_pv;
    $totals[] = $team_pv * ($spv_percentage / 100);
    echo "UserID: $user_id, Team PV: $team_pv<br>";
}

// Update transaction table in bulk
$query = "UPDATE transaction SET ewallet = ewallet + ?, ewallet_balance = ewallet_balance + ? WHERE userids = ?";
$stmt = mysqli_prepare($con, $query);
for ($i = 0; $i < $count; $i++) {
    mysqli_stmt_bind_param($stmt, "iis", $totals[$i], $totals[$i], $user_ids[$i]);
    mysqli_stmt_execute($stmt);
    echo "UserID: $user_ids[$i], TODAY INCOME: $totals[$i]<br>";
}



for ($i = 0; $i < $count; $i++) {
    $user_id = $active_user_ids[$i];
    
    $query = "SELECT ewallet_balance FROM transaction WHERE userids = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $ewallet_balance = $row["ewallet_balance"];
    
     $user_ids[] = $user_id;
    $ewallet_balances[] = $ewallet_balance;
    
    
     echo "UserID: $user_id, BALANCE: '$ewallet_balance'<br>";
}

$query = "INSERT INTO transaction_requst (user_id, camount, status, status2, cbalance) VALUES ";
$values = array();
$types = '';
$params = array();

for ($i = 0; $i < $count; $i++) {
    $values[] = "(?, ?, ?, ?, ?)";
    $types .= 'sssss';
    $params[] = $user_ids[$i];
    $params[] = $totals[$i];
    $params[] = 'accepted';
    $params[] = 'ROB Daily Income';
    $params[] = $ewallet_balances[$i];
}

$query .= implode(',', $values);
$stmt = mysqli_prepare($con, $query);
$stmt->bind_param($types, ...$params);
$stmt->execute();

} else {
    echo "No active users found.";
}


?>
