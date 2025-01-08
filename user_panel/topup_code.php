<?php
include('../connect.php');

$query = "SELECT * FROM user_wallet WHERE user_id = 'top'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);


$wallet = $row['net_wallet'];
$withdraw = $row['wallet_withdraw'];
$balance = $row['wallet_balance'];

// // You can print the values to verify
// echo "Wallet: " . $wallet . "<br>";
// echo "Withdraw: " . $withdraw . "<br>";
// echo "Balance: " . $balance . "<br>";


if (isset($_POST['topup'])) {
    $user_id = $_POST["user_id"];
    $floor_name = $_POST["floor_name"];
    $Flooramount = $_POST["Flooramount"];
    $Flooralgibulity = $_POST["Flooralgibulity"];
    $product_id = $_POST["product_id"];
    $active_id = $_POST["active_id"];
    $active_id_name = $_POST["active_id_name"];
    $transaction_pin = $_POST['ttpassword'];



    // echo "<h2>Form Data Submitted:</h2>";
    // echo "User  ID: " . $user_id . "<br>";
    // echo "Floor Name: " . $floor_name . "<br>";
    // echo "Amount: " . $Flooramount . "<br>";
    // echo "Transaction Pin: " . $transaction_pin . "<br>";
    // echo "Active ID: " . $active_id . "<br>";
    // echo "Active ID Name: " . $active_id_name . "<br>";
    // echo "Product ID: " . $product_id . "<br>";
    // echo "Floor algibulity: " . $Flooralgibulity . "<br>";


    $status = "accepted";
    $floor_status = "BUY $floor_name";
    $active_status = "Active";
    $active_date = date("Y-m-d H:i:s"); // current date and time

    switch ($floor_name) {
        case 'floor - 1':
            $table_name = 'floor_1_table';
            $slp_table = 'slp_1_table';
            $floor_users = 'floor_1_users';
            $check_floor = 'user_data';
            $floor_level_income = 'Floor-1 income';
            $floor_details = 'floor - 1';
            break;
        case 'floor - 2':
            $table_name = 'floor_2_table';
            $slp_table = 'slp_2_table';
            $floor_users = 'floor_2_users';
            $check_floor = 'floor_1_table';
            $floor_level_income = 'Floor-2 income';
            $floor_details = 'floor - 2';
            break;
        case 'floor - 3':
            $table_name = 'floor_3_table';
            $slp_table = 'slp_3_table';
            $floor_users = 'floor_3_users';
            $check_floor = 'floor_2_table';
            $floor_level_income = 'Floor-3 income';
            $floor_details = 'floor - 3';
            break;
        case 'floor - 4':
            $table_name = 'floor_4_table';
            $slp_table = 'slp_4_table';
            $floor_users = 'floor_4_users';
            $check_floor = 'floor_3_table';
            $floor_level_income = 'Floor-4 income';
            $floor_details = 'floor - 4';
            break;
        case 'floor - 5':
            $table_name = 'floor_5_table';
            $slp_table = 'slp_5_table';
            $floor_users = 'floor_5_users';
            $check_floor = 'floor_4_table';
            $floor_level_income = 'Floor-5 income';
            $floor_details = 'floor - 5';
            break;
        case 'floor - 6':
            $table_name = 'floor_6_table';
            $slp_table = 'slp_6_table';
            $floor_users = 'floor_6_users';
            $check_floor = 'floor_5_table';
            $floor_level_income = 'Floor-6 income';
            $floor_details = 'floor - 6';
            break;
        default:
            echo "Invalid floor selection.";
            exit;
    }

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

        $query = "SELECT * FROM $table_name WHERE user_id = '$active_id' AND active_status = 'Active'";
        $result = mysqli_query($con, $query);
        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Already Activeted In This Floor'); window.location.href = 'wallet.php';</script>";
            exit;
        } else {



            $query = "SELECT * FROM $check_floor WHERE user_id = '$active_id'";
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
                    // echo "FLOOR ID: $floor_id"; // Output the generated user ID





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
                                // echo "$floor_name Active Status Successful";
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

                            // if ($result) {
                            //     echo "Referral Balance Updated Successfully";
                            // } else {
                            //     echo "Referral Balance Update Failed: " . mysqli_error($con);
                            // }

                            $query = "INSERT INTO `deposit`( `user_id`, `amount`, `from_user_id`, `tstatus`, `status`, `t_balance`) VALUES ('$referral_id','$floor_drb','$active_id','$referral_status','$status','$new_referral_balance')";
                            $result = mysqli_query($con, $query);
                        } else {
                            // echo "Referral is InActive";
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
                                // echo "SLP Insert Successful";
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


                        // echo "First Level Referral: " . $row["referalid"] . "<br>"; // Debug output

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
                                    // echo "Level $i Referral: " . $row["referalid"] . "<br>"; // Debug output
                                } else {
                                    break; // stop if no more referrals
                                }
                            } else {
                                break;
                            }
                        }
                        // Check if the index exists before accessing it
                        foreach ($levels as $userId) {
                            echo "User_id: $userId </br>";
                            // Query to get user information from the last referral level
                            $query = "SELECT user_id, floor_id, user_name, active_status FROM $table_name WHERE user_id = ? AND active_status = 'Active'";
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
                                if ($row && ($row["active_status"] == 'Active') ){
                                    $floor_user = $row["floor_id"];
                                    $user_id = $row["user_id"];
                                    $user_name = $row["user_name"];
                                    echo "FLOOR_ID : $floor_user <br>";
                                    echo "USER_ID : $user_id <br>";
                                    // echo "Active User - Floor ID: $floor_user, User ID: $user_id, User Name: $user_name<br>";
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

                        // Main logic to navigate the referral structure
                        $current_floor_user = $floor_user; // Starting with the initial floor user

                        while (true) {
                            $count = checkfloor_user($current_floor_user, $floor_users);

                            if ($count >= 2) {
                                // Fetch all under_ids
                                $underIds = fetchfloor_users($current_floor_user, $floor_users);

                                if (!empty($underIds)) {
                                    // Extract only the floor_ids from the result
                                    $floor_ids = array_column($underIds, 'floor_id');

                                    // Check counts for the left and right nodes
                                    $left_count = checkfloor_user($floor_ids[0], $floor_users);
                                    $right_count = isset($floor_ids[1]) ? checkfloor_user($floor_ids[1], $floor_users) : 0;

                                    if ($right_count < 2) {
                                        // If right count < 2, set the current node to the right child
                                        $current_floor_user = $floor_ids[1] ?? $floor_ids[0]; // Use the left child if no right child exists
                                    } else {
                                        // Otherwise, continue with the left child
                                        $current_floor_user = $floor_ids[0];
                                    }
                                } else {
                                    break; // Exit if no under IDs are found
                                }
                            } else {
                                break; // Exit if count is less than 2
                            }
                        }

                        $query = "SELECT * FROM floor_income_master WHERE floor_name = '$floor_name'";
                        $result = mysqli_query($con, $query);
                        $row = mysqli_fetch_assoc($result);

                        $floor_level_1_income = $row['level_1_income'];
                        $floor_level_2_income = $row['level_2_income'];

                        // echo "Referral ID: $current_floor_user";
                        // Query to select user_id and user_name based on the current_floor_user
                        $query = "SELECT * FROM $floor_users WHERE floor_id = '$current_floor_user'"; // Use quotes for string

                        // echo "FLOOR USER TABLE: $floor_users<br>";
                        // echo "floor_id: $current_floor_user<br>";

                        // Execute the query
                        $result = mysqli_query($con, $query);

                        if ($result) {
                            // Fetch the result
                            $row = mysqli_fetch_assoc($result);

                            if ($row) {
                                $new_under_id = $row['user_id']; // Corrected to match the SELECT statement
                                $new_under_name = $row['user_name']; // Corrected to match the SELECT statement
                                $new_under_floor_id = $row['floor_id'];

                                // Output the results
                                // echo "User  ID: $new_under_id<br>";
                                // echo "User  Name: $new_under_name<br>";
                            } else {
                                // echo "No user found for floor_id: $current_floor_user<br>";
                            }
                        } else {
                            // Handle query error
                            // echo "Query Error: " . mysqli_error($con);
                        }

                        // echo "new_under_id: $new_under_id";
                        // echo "new_under_name: $new_under_name";
                        $query = "SELECT * FROM user_wallet WHERE user_id = '$new_under_id'";
                        $result = mysqli_query($con, $query);
                        $row = mysqli_fetch_assoc($result);
                        $level1_wallet = $row['net_wallet'];
                        $level1_balance = $row['wallet_balance'];

                        $new_level1_wallet =  $floor_level_1_income + $level1_wallet;
                        $new_lvel1_balance =  $floor_level_1_income + $level1_balance;

                        $query = "UPDATE user_wallet SET net_wallet = '$new_level1_wallet', wallet_balance = '$new_lvel1_balance' WHERE user_id = '$new_under_id'";
                        $result = mysqli_query($con, $query);
                        // echo "new_level1_wallet: $new_level1_wallet";
                        // echo "new_lvel1_balance: $new_lvel1_balance";

                        $query = "UPDATE $table_name SET floor_income = floor_income + $floor_level_1_income WHERE floor_id = '$new_under_floor_id'";
                        $result = mysqli_query($con, $query);


                        $query = "INSERT INTO `deposit`( `user_id`, `amount`, `from_user_id`, `tstatus`, `status`, `t_balance`, `floor_id`) VALUES ('$new_under_id','$floor_level_1_income','$active_id','$floor_level_income Level-1','accepted','$new_lvel1_balance', '$new_under_floor_id')";
                        $result = mysqli_query($con, $query);
                        // echo "level1_wallet: $level1_wallet";
                        // echo "level1_balance: $level1_balance";

                        $query = "SELECT * FROM $floor_users WHERE floor_id = '$current_floor_user'";
                        $result = mysqli_query($con, $query);
                        $row = mysqli_fetch_assoc($result);
                        $new_under_id1 = $row['under_user_id'];
                        $new_under_name1 = $row['under_name'];
                        $new_under_floor_id1 = $row['under_id'];


                        $query = "SELECT * FROM user_wallet WHERE user_id = '$new_under_id1'";
                        $result = mysqli_query($con, $query);
                        $row = mysqli_fetch_assoc($result);
                        $level2_wallet = $row['net_wallet'];
                        $level2_balance = $row['wallet_balance'];

                        $new_level2_wallet =  $floor_level_2_income + $level2_wallet;
                        $new_lvel2_balance =  $floor_level_2_income + $level2_balance;

                        $query = "UPDATE user_wallet SET net_wallet = '$new_level2_wallet', wallet_balance = '$new_lvel2_balance' WHERE user_id = '$new_under_id1'";
                        $result = mysqli_query($con, $query);

                        // echo "new_level2_wallet: $new_level2_wallet";
                        // echo "new_lvel2_balance: $new_lvel2_balance";

                        $query = "UPDATE $table_name SET floor_income = floor_income + $floor_level_2_income WHERE floor_id = '$new_under_floor_id1'";
                        $result = mysqli_query($con, $query);

                        $query = "INSERT INTO `deposit`( `user_id`, `amount`, `from_user_id`, `tstatus`, `status`, `t_balance`, `floor_id`) VALUES ('$new_under_id1','$floor_level_2_income','$active_id','$floor_level_income Level-2','accepted','$new_lvel2_balance', '$new_under_floor_id1')";
                        $result = mysqli_query($con, $query);


                        //Prepare the SQL statement
                        $query = "INSERT INTO $floor_users (floor_id, user_id, user_name, under_id, under_user_id, under_name) VALUES (?, ?, ?, ?, ?, ?)";
                        $stmt = mysqli_prepare($con, $query);
                        // echo "floor Name : $floor_users<br>";
                        if ($stmt) {
                            // echo "Refferal ID: $new_under_id1<br>";
                            // Bind parameters to the prepared statement
                            mysqli_stmt_bind_param($stmt, 'ssssss', $floor_id, $active_id, $active_id_name, $current_floor_user, $new_under_id, $new_under_name);
                            if (mysqli_stmt_execute($stmt)) {

                                echo '             
                 <div class="alert-box">
                     <div class="success-circle active">
                         <div class="checkmark"></div>
                     </div>
                     <p class="new_record">User successfully Activated.</p>
                     <p>User Id : ' . $active_id . '</p>
                     <p>User Name : ' . $active_id_name . '</p>
                     <p>Floor : ' . $floor_details . '</p>
                    
                     <button onclick="window.location.href = \'wallet.php\';">OK</button>
                 </div>';

                                // echo "<script>alert('$active_id_name In $floor_details Successfully Activated'); window.location.href = 'wallet.php';</script>";
                            } else {
                                echo "Insert Failed: " . mysqli_stmt_error($stmt);
                            }
                        }
                        // Output the retrieved values






                        // Close the statement
                        $stmt->close();
                    }
                } else {
                    echo "<script>alert('Insufficient Balance in Your Wallet '); window.location.href = 'wallet.php';</script>";
                }
            } else {
                echo "<script>alert('Plese Active Previous Floor'); window.location.href = 'wallet.php';</script>";
            }
        }
    } else {
        echo "<script>alert('Incorrect Transaction Password '); window.location.href = 'wallet.php';</script>";
    }
}
?>
<style>
    body {
        background-color: black;
        width: 100%;
    }

    .alert-box {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        border: 1px solid #ddd;
        padding: 20px;
        font-size: 35px;
        width: 500px;
        height: 500px;
        text-align: center;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        z-index: 100;
        /* Ensure alert box is on top */
    }

    .success-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 5px solid #4CAF50;
        /* Green circle */
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        /* Center the circle */

    }

    .checkmark {
        display: none; 
        /* Initially hidden */
        position: relative;
        width: 20px;
        height: 20px;
    }

    .checkmark:before {
        content: "";
        position: absolute;
        width: 15px;
        height: 5px;
        background: #4CAF50;
        top: 12px;
        left: -5px;
        transform: rotate(45deg);
    }

    .checkmark:after {
        content: "";
        position: absolute;
        width: 5px;
        height: 31px;
        background: #4CAF50;
        top: -5px;
        left: 15px;
        transform: rotate(45deg);
    }

    .success-circle.active .checkmark {
        display: block;
        /* Show checkmark when active */
    }

    button {
        background-color: #4CAF50;
        /* Green */
        color: white;
        border: none;
        padding: 15px 55px;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
        /* Darker green on hover */
    }

    .new_record {
        font-weight: bold;
        color: darkgreen;

    }
</style>