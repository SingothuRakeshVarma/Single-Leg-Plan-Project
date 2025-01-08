<?php
include('../connect.php');

function process_floor($floor_number, $con) {
    // Dynamically generate table names
    $floor_table = "floor_{$floor_number}_table";
    $floor_name = "floor - {$floor_number}";

    // Start a transaction
    mysqli_begin_transaction($con);

    try {
        // Fetch active users for the floor
        $query = "SELECT user_id, floor_id FROM $floor_table WHERE active_status = 'Active' AND expariy_date >= CURDATE()";
        $result = mysqli_query($con, $query);

        if (!$result) {
            throw new Exception("Error fetching active users: " . mysqli_error($con));
        }

        if (mysqli_num_rows($result) > 0) {
            $active_user_ids = [];
            $active_user_floor_ids = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $active_user_ids[] = $row['user_id'];
                $active_user_floor_ids[] = $row['floor_id'];
            }

            // Fetch SLP day share for the floor
            $query = "SELECT slp_day_share FROM floor_master WHERE floor_name = ?";
            $stmt = mysqli_prepare($con, $query);
            if (!$stmt) {
                throw new Exception("Error preparing statement for SLP day share: " . mysqli_error($con));
            }

            mysqli_stmt_bind_param($stmt, "s", $floor_name);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (!$result) {
                throw new Exception("Error executing statement for SLP day share: " . mysqli_error($con));
            }

            $row = mysqli_fetch_assoc($result);
            $slp_day_income = $row['slp_day_share'];

            echo "SLP Day Income for $floor_name: $slp_day_income<br>";

            // Update floor table
            $query = "UPDATE $floor_table SET income = income + ? WHERE floor_id = ?";
            $stmt = mysqli_prepare($con, $query);
            if (!$stmt) {
                throw new Exception("Error preparing update statement: " . mysqli_error($con));
            }

            foreach ($active_user_floor_ids as $floor_id) {
                mysqli_stmt_bind_param($stmt, "ds", $slp_day_income, $floor_id);
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Error executing update statement: " . mysqli_stmt_error($stmt));
                }
            }

            // Insert into deposit table
            $query = "INSERT INTO deposit (user_id, amount, status, tstatus) VALUES ";
            $values = array_fill(0, count($active_user_ids), "(?, ?, ?, ?)");
            $query .= implode(',', $values);

            $stmt = mysqli_prepare($con, $query);
            if (!$stmt) {
                throw new Exception("Error preparing insert statement: " . mysqli_error($con));
            }

            $types = str_repeat('sdss', count($active_user_ids));
            $params = [];
            foreach ($active_user_ids as $user_id) {
                $params[] = $user_id;
                $params[] = $slp_day_income;
                $params[] = 'accepted';
                $params[] = "SLP $floor_name Income";
            }

            mysqli_stmt_bind_param($stmt, $types, ...$params);
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Error executing insert statement: " . mysqli_stmt_error($stmt));
            }

            // Commit transaction
            mysqli_commit($con);
            echo "Data successfully updated and recorded for $floor_name.<br>";
        } else {
            echo "No active users found for $floor_name.<br>";
        }
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
