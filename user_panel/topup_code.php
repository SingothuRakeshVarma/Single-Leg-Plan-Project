<?php
include('../connect.php');

$query = "SELECT * FROM user_wallet WHERE user_id = 'top'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);


$wallet = $row['net_wallet'];
$withdraw = $row['wallet_withdraw'];
$balance = $row['wallet_balance'];

// You can print the values to verify
echo "Wallet: " . $wallet . "<br>";
echo "Withdraw: " . $withdraw . "<br>";
echo "Balance: " . $balance . "<br>";


if (isset($_POST['topup'])) {
    $user_id = $_POST["user_id"];
    $floor_name = $_POST["floor_name"];
    $Flooramount = $_POST["Flooramount"];
    $Flooralgibulity = $_POST["Flooralgibulity"];
    $product_id = $_POST["product_id"];
    $active_id = $_POST["active_id"];
    $active_id_name = $_POST["active_id_name"];
    $transaction_pin = $_POST['ttpassword'];



    echo "<h2>Form Data Submitted:</h2>";
    echo "User  ID: " . $user_id . "<br>";
    echo "Floor Name: " . $floor_name . "<br>";
    echo "Amount: " . $Flooramount . "<br>";
    echo "Transaction Pin: " . $transaction_pin . "<br>";
    echo "Active ID: " . $active_id . "<br>";
    echo "Active ID Name: " . $active_id_name . "<br>";
    echo "Product ID: " . $product_id . "<br>";
    echo "Floor algibulity: " . $Flooralgibulity . "<br>";


    $status = "accepted";
    $floor_status = "BUY $floor_name";
    $active_status = "Active";
    $active_date = date("Y-m-d H:i:s"); // current date and time


    $query = "SELECT wallet_balance, wallet_withdraw FROM user_wallet WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    $wallet_balance = $row['wallet_balance'];
    $wallet_withdraw = $row['wallet_withdraw'];

    $new_wlt_bln = $wallet_balance - $Flooramount;
    $new_wlt_wth = $wallet_withdraw + $Flooramount;
    // Check if the transaction password is correct
    $query = "SELECT * FROM user_data WHERE tpassword = '$transaction_pin' AND user_id = '$user_id'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        if ($wallet_balance >= $Flooramount) {
            $query = "UPDATE user_wallet SET wallet_balance = $new_wlt_bln, wallet_withdraw = $new_wlt_wth WHERE user_id = '$user_id'";
            $result = mysqli_query($con, $query);
            $query = "INSERT INTO `withdraws`( `user_id`, `w_amount`, `wto_user_id`, `wstatus`, `status`, `w_balance`) VALUES ('$user_id','$Flooramount','$active_id','$floor_status','$status','$new_wlt_bln')";
            $result = mysqli_query($con, $query);


            function generate_floor_id($length = 6)
            {
                $characters = '123456789'; // Only digits 1-9
                $floor_id = '';

                // Ensure the length is valid
                if ($length < 1) {
                    return 'FLR000000'; // Fallback in case of invalid length
                }

                for ($i = 0; $i < $length; $i++) {
                    $floor_id .= $characters[mt_rand(0, strlen($characters) - 1)];
                }

                return 'FLR' . $floor_id;
            }

            $floor_id = generate_floor_id();
            echo "FLOOR ID: $floor_id"; // Output the generated user ID

            $table_name = '';

            switch ($floor_name) {
                case 'floor - 1':
                    $table_name = 'floor_1_table';
                    $slp_table = 'slp_1_table';
                    $floor_users = 'floor_1_users';
                    break;
                case 'floor - 2':
                    $table_name = 'floor_2_table';
                    $slp_table = 'slp_2_table';
                    $floor_users = 'floor_2_users';
                    break;
                case 'floor - 3':
                    $table_name = 'floor_3_table';
                    $slp_table = 'slp_3_table';
                    $floor_users = 'floor_3_users';
                    break;
                case 'floor - 4':
                    $table_name = 'floor_4_table';
                    $slp_table = 'slp_4_table';
                    $floor_users = 'floor_4_users';
                    break;
                case 'floor - 5':
                    $table_name = 'floor_5_table';
                    $slp_table = 'slp_5_table';
                    $floor_users = 'floor_5_users';
                    break;
                case 'floor - 6':
                    $table_name = 'floor_6_table';
                    $slp_table = 'slp_6_table';
                    $floor_users = 'floor_6_users';
                    break;
                default:
                    echo "Invalid floor selection.";
                    exit;
            }

            if ($table_name) {
                // Prepare the SQL statement
                $query = "INSERT INTO `$table_name` (`floor_id`, `user_id`, `user_name`, `active_date`, `floor_vaility`, `active_status`, `expariy_date`) 
                      VALUES (?, ?, ?, ?, ?, ?, DATE_ADD(?, INTERVAL ? DAY))";

                // Initialize a prepared statement
                $stmt = mysqli_prepare($con, $query);

                // Check if the statement was prepared successfully
                if ($stmt) {
                    // Bind parameters to the prepared statement
                    mysqli_stmt_bind_param($stmt, 'ssssssss', $floor_id, $active_id, $active_id_name, $active_date, $Flooralgibulity, $active_status, $active_date, $Flooralgibulity);

                    // Execute the statement
                    if (mysqli_stmt_execute($stmt)) {
                        echo "$floor_name Active Status Successful";
                    } else {
                        echo "Insert Failed: " . mysqli_stmt_error($stmt);
                    }

                    // Close the statement
                    mysqli_stmt_close($stmt);
                } else {
                    echo "Statement preparation failed: " . mysqli_error($con);
                }

                $query = "SELECT * FROM user_data WHERE user_id = '$active_id'";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_assoc($result);

                $referral_id = $row['referalid'];

                $query = "SELECT * FROM user_wallet WHERE user_id = '$referral_id'";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_assoc($result);
                $referral_balance = $row['wallet_balance'];
                $referral_net_wallet = $row['net_wallet'];

                $query = "SELECT drb FROM floor_income_master WHERE floor_name = '$floor_name'";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_assoc($result);
                $floor_drb = $row['drb'];

                $new_referral_balance = $referral_balance + $floor_drb;
                $new_referral_net_wallet = $referral_net_wallet + $floor_drb;


                $referral_status = "Referral Income";

                $query = "SELECT * FROM $table_name WHERE active_status = 'Active' AND user_id = '$referral_id'";
                $result = mysqli_query($con, $query);
                if (mysqli_num_rows($result) > 0) {

                    $query = "UPDATE `user_wallet` SET `net_wallet`='$new_referral_net_wallet',`wallet_balance`='$new_referral_balance' WHERE `user_id`='$referral_id'";
                    $result = mysqli_query($con, $query);

                    if ($result) {
                        echo "Referral Balance Updated Successfully";
                    } else {
                        echo "Referral Balance Update Failed: " . mysqli_error($con);
                    }

                    $query = "INSERT INTO `deposit`( `user_id`, `amount`, `from_user_id`, `tstatus`, `status`, `t_balance`) VALUES ('$referral_id','$floor_drb','$active_id','$referral_status','$status','$new_referral_balance')";
                    $result = mysqli_query($con, $query);
                } else {
                    echo "Referral is InActive";
                }
            }
            if ($slp_table) {
                // Prepare the SQL statement
                // Assuming $slp_table, $user_id, $active_id, and $active_id_name are defined and sanitized

                // Prepare the SQL statement
                $query = "INSERT INTO $slp_table (floor_id, user_id, user_name) VALUES (?, ?, ?)";

                // Initialize a prepared statement
                $stmt = mysqli_prepare($con, $query);

                // Check if the statement was prepared successfully
                if ($stmt) {
                    // Bind parameters to the prepared statement
                    mysqli_stmt_bind_param($stmt, 'sss', $floor_id, $active_id,  $active_id_name);

                    // Execute the statement
                    if (mysqli_stmt_execute($stmt)) {
                        echo "SLP Insert Successful";
                    } else {
                        echo "Insert Failed: " . mysqli_stmt_error($stmt);
                    }

                    // Close the statement
                    mysqli_stmt_close($stmt);
                } else {
                    echo "Statement preparation failed: " . mysqli_error($con);
                }
            }
            if ($floor_users && $table_name) {



                $levels = array(); // new array to store user IDs

                // Query to get the first level referral
                $query = "SELECT referalid FROM user_data WHERE user_id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("s", $active_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $levels[] = $row["referalid"]; // add first level referral


                echo "First Level Referral: " . $row["referalid"] . "<br>"; // Debug output

                // Loop to get subsequent levels
                for ($i = 1; $i <= 10; $i++) {
                    if (isset($levels[$i - 1])) {
                        $query = "SELECT referalid FROM user_data WHERE user_id = ?";
                        $stmt = $con->prepare($query);
                        $stmt->bind_param("s", $levels[$i - 1]);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        if ($row["referalid"] != '') { // check if referral exists
                            $levels[] = $row["referalid"]; // add next level referral
                            echo "Level $i Referral: " . $row["referalid"] . "<br>"; // Debug output
                        } else {
                            break; // stop if no more referrals
                        }
                    } else {
                        break;
                    }
                }
                // Check if the index exists before accessing it
                foreach ($levels as $userId) {
                    // Query to get user information from the last referral level
                    $query = "SELECT user_id, floor_id, user_name, active_status FROM $table_name WHERE user_id = ?";
                    $stmt = $con->prepare($query);

                    $floor_user = null;
                    $user_id = null;
                    $user_name = null;

                    if ($stmt) {
                        $stmt->bind_param("s", $userId);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();

                        // Check if a row was returned and if the user is active
                        if ($row && $row["active_status"] == 'Active') {
                            $floor_user = $row["floor_id"];
                            $user_id = $row["user_id"];
                            $user_name = $row["user_name"];

                            echo "Active User - Floor ID: $floor_user, User ID: $user_id, User Name: $user_name<br>";
                            break; // Exit the loop after finding the first active user
                        }
                    }

                    // Close the statement
                    $stmt->close();
                }

                // Function to check the count of under_ids
                function checkfloor_user($floor_user, $floor_users)
                {
                    global $con;

                    // Prepare SQL query to get the count of under_ids
                    $stmt = $con->prepare("SELECT COUNT(*) as count FROM $floor_users WHERE under_id = ?");
                    $stmt->bind_param("s", $floor_user); // Bind the parameter
                    $stmt->execute();

                    // Fetch the result
                    $result = $stmt->get_result()->fetch_assoc();

                    // Close the statement
                    $stmt->close();

                    // Return the count
                    return $result['count'];
                }

                // Function to fetch floor_ids based on under_ids
                function fetchfloor_users($floor_user, $floor_users)
                {
                    global $con;

                    // Prepare the SQL statement to fetch floor_id where under_id matches the floor_user
                    $stmt = $con->prepare("SELECT floor_id FROM $floor_users WHERE under_id = ?");
                    $stmt->bind_param("s", $floor_user); // Bind the parameter
                    $stmt->execute();

                    // Fetch the results
                    $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

                    // Close the statement
                    $stmt->close();

                    // Return the results
                    return $results; // Return all matching floor_ids
                }

                // Main logic
                $current_floor_user = $floor_user; // Set this to your initial floor_user value

                while (true) {
                    $count = checkfloor_user($current_floor_user, $floor_users);
                    echo "Count of under_ids for user $current_floor_user: $count\n";

                    if ($count >= 2) {
                        $underIds = fetchfloor_users($current_floor_user, $floor_users);

                        if (!empty($underIds)) {
                            // Extract only the floor_ids from the result
                            $floor_ids = array_column($underIds, 'floor_id');
                            echo "Under IDs fetched: " . implode(", ", $floor_ids) . "\n";

                            // Assuming you want to check the first under_id for the next iteration
                            $current_floor_user = $floor_ids[0]; // Use the first fetched floor_id for the next iteration
                        } else {
                            echo "No under IDs found for user $current_floor_user. Exiting loop.\n";
                            break; // Exit the loop if no under IDs are found
                        }
                    } else {
                        echo "Count is less than 2 for user $current_floor_user. Exiting loop.\n";
                        break; // Exit the loop
                    }
                }

                echo "Referral ID: $current_floor_user";
                // Query to select user_id and user_name based on the current_floor_user
                $query = "SELECT user_id, user_name FROM floor_1_table WHERE floor_id = ?";
                $stmt = $con->prepare($query);

                if ($stmt) {
                    // Bind the parameter
                    $stmt->bind_param("s", $current_floor_user); // Assuming floor_id is a string; change to "i" if it's an integer
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Fetch the result
                    if ($row = $result->fetch_assoc()) {
                        $new_under_id = $row['user_id']; // Corrected to match the SELECT statement
                        $new_under_name = $row['user_name']; // Corrected to match the SELECT statement

                        //Prepare the SQL statement
                        $query = "INSERT INTO $floor_users (floor_id, user_id, user_name, under_id, under_user_id, under_name) VALUES (?, ?, ?, ?, ?, ?)";
                        $stmt = mysqli_prepare($con, $query);
                        if ($stmt) {
                            // Bind parameters to the prepared statement
                            mysqli_stmt_bind_param($stmt, 'ssssss', $floor_id, $active_id, $active_id_name, $current_floor_user, $new_under_id, $new_under_name);
                            if (mysqli_stmt_execute($stmt)) {
                                echo "Floor User Insert Successful";
                            } else {
                                echo "Insert Failed: " . mysqli_stmt_error($stmt);
                            }
                        }
                        // Output the retrieved values
                        echo "New Under ID: $new_under_id, New Under Name: $new_under_name<br>";
                    } else {
                        echo "No user found for floor ID: $current_floor_user<br>";
                    }

                    // Close the statement
                    $stmt->close();
                } else {
                    echo "Failed to prepare the SQL statement.<br>";
                }
            }
        }
    } else {
        echo "Incorrect Transaction Password";
    }
}
