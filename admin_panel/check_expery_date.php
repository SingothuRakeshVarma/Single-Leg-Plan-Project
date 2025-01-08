<?php
include('../connect.php');

function process_floor($floor_number, $con)
{
    // Dynamically generate table names
    $floor_table = "floor_{$floor_number}_table";
    $floor_name = "floor - {$floor_number}";
    $floor_users = "floor_{$floor_number}_users";

    // Start a transaction
    mysqli_begin_transaction($con);

    try {
        // Fetch active users for the floor with 6 users
        $query = "SELECT user_id, floor_id, income, withdraw 
                  FROM $floor_table 
                  WHERE expariy_date < CURDATE() AND floor_users_count = 6 AND active_status = 'Active'
                  ORDER BY user_id ASC";
        $result = mysqli_query($con, $query);

        if (!$result) {
            throw new Exception("Error fetching active users with 6 users: " . mysqli_error($con));
        }

        if (mysqli_num_rows($result) > 0) {
            $active_user_floor_ids = [];
            $active_users = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $active_user_floor_ids[] = $row['floor_id'];
                $active_users[] = $row;
            }

            foreach ($active_users as $user) {
                $user_id = $user['user_id'];
                $floor_id = $user['floor_id'];
                $income = $user['income'];
                $withdraw = $user['withdraw'];
                $total_withdraw = $withdraw + $income;

                // Update user wallet
                $query = "UPDATE user_wallet 
                          SET net_wallet = net_wallet + ?, wallet_balance = wallet_balance + ? 
                          WHERE user_id = ?";
                $stmt = mysqli_prepare($con, $query);
                if (!$stmt) {
                    throw new Exception("Error preparing user wallet update statement: " . mysqli_error($con));
                }
                mysqli_stmt_bind_param($stmt, "dds", $income, $income, $user_id);
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Error executing user wallet update: " . mysqli_stmt_error($stmt));
                }

                // Fetch wallet data for logging purposes
                $query = "SELECT net_wallet, wallet_balance FROM user_wallet WHERE user_id = ?";
                $stmt = mysqli_prepare($con, $query);
                if (!$stmt) {
                    throw new Exception("Error preparing user wallet select statement: " . mysqli_error($con));
                }
                mysqli_stmt_bind_param($stmt, "s", $user_id);
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Error executing user wallet select: " . mysqli_stmt_error($stmt));
                }
                $result_wallet = mysqli_stmt_get_result($stmt);
                $wallet_data = mysqli_fetch_assoc($result_wallet);

                if ($wallet_data) {
                    $net_wallet = $wallet_data['net_wallet'];
                    $wallet_balance = $wallet_data['wallet_balance'];

                    // Insert deposit record
                    $query = "INSERT INTO deposit (user_id, amount, tstatus, status, t_balance) 
                              VALUES (?, ?, 'SLP $floor_name Share', 'accepted', ?)";
                    $stmt = mysqli_prepare($con, $query);
                    if (!$stmt) {
                        throw new Exception("Error preparing deposit insert statement: " . mysqli_error($con));
                    }
                    mysqli_stmt_bind_param($stmt, "sdd", $user_id, $income, $wallet_balance);
                    if (!mysqli_stmt_execute($stmt)) {
                        throw new Exception("Error executing deposit insert: " . mysqli_stmt_error($stmt));
                    }

                    // Log updated wallet info
                    echo "User ID: $user_id, Net Wallet: $net_wallet, Wallet Balance: $wallet_balance\n";
                } else {
                    throw new Exception("No wallet data found for user ID: $user_id");
                }

                // Update floor table
                $query = "UPDATE $floor_table 
                          SET active_status = 'Completed', income = 0, withdraw = ? 
                          WHERE floor_id = ?";
                $stmt = mysqli_prepare($con, $query);
                if (!$stmt) {
                    throw new Exception("Error preparing floor table update statement: " . mysqli_error($con));
                }
                mysqli_stmt_bind_param($stmt, "ds", $total_withdraw, $floor_id);
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Error executing floor table update: " . mysqli_stmt_error($stmt));
                }
            }

            // // Delete users from floor users table
            // $query = "DELETE FROM $floor_users WHERE floor_id = ?";
            // $stmt = mysqli_prepare($con, $query);
            // if (!$stmt) {
            //     throw new Exception("Error preparing floor users delete statement: " . mysqli_error($con));
            // }
            // foreach ($active_user_floor_ids as $floor_id) {
            //     mysqli_stmt_bind_param($stmt, "s", $floor_id);
            //     if (!mysqli_stmt_execute($stmt)) {
            //         throw new Exception("Error executing floor users delete: " . mysqli_stmt_error($stmt));
            //     }
            // }
        } else {
            echo "No active users found for $floor_name with 6 users.<br>";
        }

        // Fetch active users for the floor with less than 6 users
        // $query = "SELECT floor_id 
        //           FROM $floor_table 
        //           WHERE expariy_date < CURDATE() AND floor_users_count < 6";
        // $result = mysqli_query($con, $query);

        // if (!$result) {
        //     throw new Exception("Error fetching active users with less than 6 users: " . mysqli_error($con));
        // }

        // if (mysqli_num_rows($result) > 0) {
        //     $active_user_floor_ids = [];
        //     while ($row = mysqli_fetch_assoc($result)) {
        //         $active_user_floor_ids[] = $row['floor_id'];
        //     }

        //     // Update floor table to 'Hold'
        //     $query = "UPDATE $floor_table SET active_status = 'Hold' WHERE floor_id = ?";
        //     $stmt = mysqli_prepare($con, $query);
        //     if (!$stmt) {
        //         throw new Exception("Error preparing floor table update statement: " . mysqli_error($con));
        //     }
        //     foreach ($active_user_floor_ids as $floor_id) {
        //         mysqli_stmt_bind_param($stmt, "s", $floor_id);
        //         if (!mysqli_stmt_execute($stmt)) {
        //             throw new Exception("Error executing floor table update: " . mysqli_stmt_error($stmt));
        //         }
        //     }
        // } else {
        //     echo "No active users found for $floor_name with less than 6 users.<br>";
        // }

        // Commit the transaction
        mysqli_commit($con);
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($con);
        echo "Error processing $floor_name: " . $e->getMessage() . "<br>";
    }
}

// Process all floors
for ($i = 1; $i <= 6; $i++) {
    process_floor($i, $con);
}
?>
