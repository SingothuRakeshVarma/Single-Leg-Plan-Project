<?php
include('user_header.php');
include('../connect.php');

$query = "SELECT * FROM transaction WHERE userids = '$user_id'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);
if ($user) {
    // Store data in the session
    $_SESSION['ewallet_balance'] = $user['ewallet_balance'];
    $_SESSION['ewallet_withdrow'] = $user['ewallet_withdrow'];
    $_SESSION['ewallet'] = $user['ewallet'];
    $_SESSION['swallet_balance'] = $user['swallet_balance'];

    $swallet_balance = $_SESSION['swallet_balance'];
    $ewallet_balance = $_SESSION['ewallet_balance'];
} else {
    $swallet_balance = 0;
    $ewallet_balance = 0;
}



if (isset($_GET['product_code'])) {
    $id = $_GET['product_code'];

    $query = "SELECT * FROM `cartdata` WHERE productcode = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
}

$image = $row['images'];
// Retrieve user data
// Calculate deduct amount
$deduct_amount = min($swallet_balance, $row['swalletdiscount']);
$new_product_price = $row['dp'] - $deduct_amount;

if (isset($_POST["submit"])) {
    $user_id = $_POST["user_id"];
    $ewallet_balance = $_POST["ewallet_balance"];
    $product_code = $_POST["product_code"];
    $product_name = $_POST["product_name"];
    $product_amount = $_POST["amount"];
    $product_cashback_amount = $_POST["cash_back"];
    $total_pay = $_POST["total_pay"];
    $swallet_balance = $_POST["swallet_balance"];
    $swallet_discount = $_POST["swallet_discount"];
    $tpassword = $_POST["tpassword"];
    $addswalletfund = $_POST["swallet_add"];
    $type = $_POST["type"];
    $referralvalue = $_POST["referralvalue"];
    $packagealgibulity = $_POST["packagealgibulity"];



    // date_default_timezone_set('Asia/Kolkata'); // set time zone to New York
    $buy_date = date("Y-m-d");
    $status = "accepted";
    $status2 = "BUY $product_name";
    $activation_status = "Active";

$query = "SELECT * FROM users WHERE userid ='$active_id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    
    $addres1 = $row["addres"];
    $district1 = $row["district"];
    $state1 = $row["state"];
    $country1 = $row["country"];
    $pincode1 = $row["pincode"];
    $phonenumber1 = $row["phonenumber"];

    $full_address = $addres . ', ' . $district . ', ' . $state . ', ' . $country . ' - ' . $pincode . ', Phone: ' . $phonenumber;
    $product_status = "Dispatch_Pending";

    $deduct_amount1 = min($swallet_balance, $swallet_discount);

    $query = "SELECT * FROM transaction WHERE userids ='$user_id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    $swallet_withdrow = $row['swallet_withdrow'];
    $cashback_amount = $row['cashback_amount'];
    $ewallet_withdrow = $row['ewallet_withdrow'];
    $swallet = $row['swallet'];


    $active_date =  date("Y-m-d");

    $query = "SELECT * FROM users WHERE userid ='$user_id' AND tpassword = '$tpassword'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {

        if ($ewallet_balance >= $total_pay) {
            $new_ewallet_balance = $ewallet_balance - $total_pay;
            $new_ewallet_withdrow = $ewallet_withdrow + $total_pay;
            $new_swallet_withdrow = $swallet_withdrow + $deduct_amount1;
            $pre_swallet_balance = $swallet_balance - $deduct_amount1;
            $new_cashback_amount = $cashback_amount + $product_cashback_amount;
            $new_swallet_balance = $pre_swallet_balance +  $addswalletfund;
            $new_swallet = $swallet + $addswalletfund;

            $query3 = "INSERT INTO `product_delivery`(`user_id`, `user_name`, `product_id`, `product_name`, `addres`, `status`) VALUES ('$user_id','$user_name','$product_code', '$product_name', '$full_address','$product_status')";
            $result = mysqli_query($con, $query3);

            $query = "UPDATE `transaction` SET swallet_withdrow = '$new_swallet_withdrow', cashback_amount = '$new_cashback_amount', swallet_balance = '$new_swallet_balance',
        ewallet_withdrow = '$new_ewallet_withdrow', ewallet_balance = '$new_ewallet_balance', swallet = '$new_swallet' WHERE userids = '$user_id' ";
            $result = mysqli_query($con, $query);
            if ($result) {
                echo '<script>alert("CheckOut Product successfully!");window.location.href = "dash_bord_packages.php";</script>';
                // echo "CheckOut Product successfully!";
            } else {
                echo "Error inserting into withdrow_requests table: " . mysqli_error($con);
            }
            $query1 = "INSERT INTO `withdrow_requests`( `userid`, `withdrow_amount`, `date`, `status`, `wstatus2`, `balance`) 
        VALUES ('$user_id','$total_pay','$buy_date','$status','$status2','$new_ewallet_balance')";
            $result = mysqli_query($con, $query1);
            if ($result) {
                // echo '<script>alert("CheckOut Product successfully!");window.location.href = "checkout.php";</script>';
                // echo "Withdrow data save successfully!";
            } else {
                echo "Error inserting into withdrow_requests table: " . mysqli_error($con);
            }


            if ($type == 'package') {
                $query = "SELECT * FROM users WHERE userid ='$user_id' AND activation_status = 'Active'";
                $result = mysqli_query($con, $query);
                if (mysqli_num_rows($result) > 0) {
                    echo '<script>alert("User Already Activeted");window.location.href = "dash_bord_packages.php";</script>';
                } else {

                    $query2 = "UPDATE users 
                    SET activate_date = '$active_date', 
                    package_vaility_days = '$packagealgibulity', 
                    expiry_date = DATE_ADD('$active_date', INTERVAL '$packagealgibulity' DAY), 
                    activation_status = '$activation_status'WHERE userid = '$user_id'";
                    $result = mysqli_query($con, $query2);


                   $query = "SELECT * FROM referal_income WHERE packagename ='$product_name'";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_assoc($result);

                    $referral_value = $row['referral_value'];
                    $referral_1 = $row['referral_1'];
                    $referral_2 = $row['referral_2'];
                    $referral_3 = $row['referral_3'];
                    $referral_4 = $row['referral_4'];
                    $referral_5 = $row['referral_5'];
                    $referral_6 = $row['referral_6'];
                    $referral_7 = $row['referral_7'];
                    $referral_8 = $row['referral_8'];
                    $referral_9 = $row['referral_9'];
                    $referral_10 = $row['referral_10'];

                    $ref_level_1 = $referral_value * ($referral_1 / 100);
                    $ref_level_2 = $referral_value * ($referral_2 / 100);
                    $ref_level_3 = $referral_value * ($referral_3 / 100);
                    $ref_level_4 = $referral_value * ($referral_4 / 100);
                    $ref_level_5 = $referral_value * ($referral_5 / 100);
                    $ref_level_6 = $referral_value * ($referral_6 / 100);
                    $ref_level_7 = $referral_value * ($referral_7 / 100);
                    $ref_level_8 = $referral_value * ($referral_8 / 100);
                    $ref_level_9 = $referral_value * ($referral_9 / 100);
                    $ref_level_10 = $referral_value * ($referral_10 / 100);


                    $query = "SELECT referalid FROM users WHERE userid ='$user_id'";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_assoc($result);

                    $referalid = $row["referalid"];



                    $query = "SELECT * FROM users WHERE userid ='$referalid' AND activation_status = 'Active'";
                    $result = mysqli_query($con, $query);
                    if (mysqli_num_rows($result) > 0) {
                        $sql = "SELECT COUNT(referalid) AS processing_count FROM users WHERE userid = '$referalid'";
                        $result = $con->query($sql);
                        $row = mysqli_fetch_assoc($result);

                        // Retrieve the referral count
                        $userReferralCount = $row['processing_count'];

                        // Define the referral income levels
                        $referralIncomeLevels = array(
                            1 => $ref_level_1,
                            2 => $ref_level_2,
                            3 => $ref_level_3,
                            4 => $ref_level_4,
                            5 => $ref_level_5,
                            6 => $ref_level_6,
                            7 => $ref_level_7,
                            8 => $ref_level_8,
                            9 => $ref_level_9,
                            10 => $ref_level_10
                        );

                        // Update the referral income in the e-wallet
                        if ($userReferralCount >= 1 && $userReferralCount <= 10) {
                            $referralIncome = $referralIncomeLevels[$userReferralCount];

                            // Update the e-wallet balance
                            $query = "UPDATE transaction SET ewallet = ewallet + '$referralIncome', ewallet_balance = ewallet_balance + '$referralIncome' WHERE userids = '$referalid'";
                            $result = mysqli_query($con, $query);

                            if ($result) {
                                echo "UserID: $referalid, RINCOME: $referralIncome";
                                
                            } else {
                                echo "Error updating referral income: " . mysqli_error($con);
                            }

                            $query = "SELECT * FROM transaction WHERE userids = '$referalid'";
                            $result = mysqli_query($con, $query);
                            $row = mysqli_fetch_assoc($result);

                            $ewallet_balance = $row["ewallet_balance"];

                            $status1 = "accepted";
                            $status2 = "Referral Income";

                            $query = "INSERT INTO `transaction_requst`(`user_id`, `camount`, `status`, `status2`, `cbalance`, `from_user_id`) VALUES ('$referalid','$referralIncome','$status1','$status2','$ewallet_balance','$active_id')";
                            $result = mysqli_query($con, $query);
                        }
                    }


                    $query = "SELECT * FROM rob_level_income WHERE packagename = ?";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("s", $product_name);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();

                    $self = $row['self'];
                    $level_1 = $row['level_1'];
                    $level_2 = $row['level_2'];
                    $level_3 = $row['level_3'];
                    $level_4 = $row['level_4'];
                    $level_5 = $row['level_5'];

                    // Update self PV
                    $query = "UPDATE transaction SET self_pv = self_pv + ? WHERE userids = ?";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("is", $self, $user_id);
                    $stmt->execute();

                    // Fetch referral ID and name
                    $query = "SELECT * FROM users WHERE userid = '$user_id'";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_assoc($result);

                    $referalid = $row["referalid"];
                    $referalname = $row["referalname"];
                    $username = $row["username"];

                   

                    // Populate levels array
                    $income_levels = array($level_1,  $level_2,  $level_3,  $level_4,  $level_5);
                    $levels_names = array();
                    $levels = array(); // new array to store user IDs

                    $query = "SELECT referalid, referalname FROM users WHERE userid = ?";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("s", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $levels[] = $row["referalid"]; // add first level referral
                    $levels_names[] = $row["referalname"];

                    for ($i = 1; $i <= 5; $i++) {
                        if (isset($levels[$i - 1])) {
                            $query = "SELECT referalid, referalname FROM users WHERE userid = ?";
                            $stmt = $con->prepare($query);
                            $stmt->bind_param("s", $levels[$i - 1]);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            if ($row["referalid"] != '') { // check if referral exists
                                $levels[] = $row["referalid"]; // add next level referral
                                $levels_names[] = $row["referalname"];
                            } else {
                                break; // stop if no more referrals
                            }
                        } else {
                            break;
                        }
                    }

                    // Initialize the team PV update query
                    $query = "UPDATE transaction SET team_pv = team_pv + ? WHERE userids = ?";
                    $stmt = $con->prepare($query);

                    // Iterate through the $levels array to update team PV for each level
                    foreach ($levels as $i => $level) {
                        $income = $income_levels[$i]; // Get the income value for the current level
                        $userid1 = $level; // Get the referral ID for the current level

                        // Update team PV for the current level
                        $stmt->bind_param("is", $income, $userid1);
                        $stmt->execute();

                        // Check if we've reached the 5th level
                        if ($i >= 4) {
                            break; // Stop updating team PV if we've reached the 5th level
                        }
                    }

                    $dataToInsert = array();
                    $dataToInsert[] = array(
                        'user_id' => $user_id,
                        'user_name' => $username,
                        'pvs' => $self,
                        'levels' => 'Self',
                        'referral_id' => $referalid,
                        'form_user_id' => $user_id,
                        'status' => 'Add'
                    );

                    foreach ($levels as $i => $level) {
                        $income = $income_levels[$i];
                        $userid = $level;
                        $username = $levels_names[$i];
                        $levelNumber = "Level-" . ($i + 1);
                        $referral_id = $levels[$i + 1] ?? null; // handle the last iteration
                        $form_user_id = $user_id;

                        $dataToInsert[] = array(
                            'user_id' => $userid,
                            'user_name' => $username,
                            'pvs' => $income,
                            'levels' => $levelNumber,
                            'referral_id' => $referral_id,
                            'form_user_id' => $form_user_id,
                            'status' => 'Add'
                        );
                    }

                    // Perform a single insert operation
                    $query = "INSERT INTO `pv_summery` (`user_id`, `user_name`, `pvs`, `levels`, `referral_id`, `form_user_id`, `status`) VALUES ";
                    $values = array();
                    foreach ($dataToInsert as $row) {
                        $values[] = "('{$row['user_id']}', '{$row['user_name']}', '{$row['pvs']}', '{$row['levels']}', '{$row['referral_id']}', '{$row['form_user_id']}', '{$row['status']}')";
                    }
                    $query .= implode(', ', $values);
                    $stmt = $con->prepare($query);
                    $stmt->execute();




                    $stmt->close();

                    // debug output
                    print_r($levels);
                    print_r($income_levels);
                    echo mysqli_error($con);


//AUTO POOL


                    $query = "SELECT referalid FROM users WHERE userid = '$user_id'";
                    $result = mysqli_query($con, $query);
                    if (!$result) {
                        echo "Error: " . mysqli_error($con);
                        exit;
                    }
                    $row = mysqli_fetch_assoc($result);
                    $referal_id = $row['referalid'];

                    $query = "SELECT * FROM users WHERE activation_status = 'Active' AND userid = '$referal_id'";
                    $result = mysqli_query($con, $query);
                    if (!$result) {
                        echo "Error: " . mysqli_error($con);
                        exit;
                    }

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $user_names = $row['username'];
                            $active_date = $row['activate_date'];

                            $expiry_date = date('Y-m-d'); // current date

                            $query = "SELECT COUNT(*) as num_referrals 
              FROM users 
              WHERE referalid = '$referal_id'
              AND activate_date >= '$active_date' 
              AND activate_date <= '$expiry_date'
              AND activation_status = 'active'";

                            $result_referrals = mysqli_query($con, $query);
                            if (!$result_referrals) {
                                echo "Error: " . mysqli_error($con);
                                exit;
                            }
                            $row_referrals = mysqli_fetch_assoc($result_referrals);
                            $num_referrals = $row_referrals['num_referrals'];
                            echo "Number of users referred within period time: $num_referrals";




                            if ($num_referrals == 5 || $num_referrals == 10) {
                               
                                function generate_user_id($length = 8)
                                {
                                    $file = 'generateted_id.txt';
                                    if (file_exists($file)) {
                                        $generate_id = (int) file_get_contents($file);
                                    } else {
                                        $generate_id = 0;
                                    }
                                    $new_id = $generate_id + 1;
                                    file_put_contents($file, $new_id);
                                    return "P" . str_pad($new_id, 8, '0', STR_PAD_LEFT);
                                }

                                $pool_id = generate_user_id();
                                echo $pool_id;
                                
                                
                                 $query = "SELECT pool_id FROM auto_pool";
                                $result_pool = mysqli_query($con, $query);
                                if (!$result_pool) {
                                    echo "Error: " . mysqli_error($con);
                                    exit;
                                }
                                $ids = mysqli_fetch_all($result_pool, MYSQLI_ASSOC);
                                   print_r($ids);
                                   
                                     $query = "SELECT * FROM users WHERE userid = '$referal_id'";
                                     $result = mysqli_query($con, $query);



                                 
                               $row = mysqli_fetch_assoc($result);
                                      
                                    
                                       
                                foreach ($ids as $id) {
                                       $poolid = $id['pool_id'];
                                     $user_names = $row["username"]; // assume $row is still available from previous query

                                        $query_check = "SELECT COUNT(*) as count FROM auto_pool WHERE under_id = '$poolid'";
                                        $result_check = mysqli_query($con, $query_check);
                                        $row_check = mysqli_fetch_assoc($result_check);
                                        $count = $row_check['count'];
                                    
                                        if ($count < 5) {
                                            $query_insert = "INSERT INTO auto_pool (pool_id, user_id, user_name, under_id) VALUES ('$pool_id', '$referal_id', '$user_names', '$poolid')";
                                            $result_insert = mysqli_query($con, $query_insert);
                                            if (!$result_insert) {
                                                echo "Error: " . mysqli_error($con);
                                                exit;
                                            }
                                        } else {
                                            // move on to the next ID in the array
                                            continue;
                                        }
                                      
                                        $query = "INSERT INTO designation (user_id) VALUES ('$referal_id')";
                                        $result_insert = mysqli_query($con, $query);

                                        $query = "SELECT * FROM dimend_pool_master";
                                        $result = mysqli_query($con, $query);

                                        // Fetch the row from the result set
                                        $row = mysqli_fetch_assoc($result);

                                        $level_1_share = $row['level_1_mumbers_share'];
                                        $level_2_share = $row['level_2_mumbers_share'];
                                        $level_3_share = $row['level_3_mumbers_share'];
                                        $level_4_share = $row['level_4_mumbers_share'];
                                        $level_5_share = $row['level_5_mumbers_share'];


                                        $query = "SELECT under_id, user_id FROM auto_pool WHERE pool_id ='$pool_id'";
                                        $result = mysqli_query($con, $query);
                                        $row = mysqli_fetch_assoc($result);

                                        $under_id = $row["under_id"];
                                        $user_id = $row["user_id"];


                                        $pool_income_levels = array($level_1_share,  $level_2_share,  $level_3_share,  $level_4_share,  $level_5_share);
                                        $pool_levels = array(); // new array to store user IDs

                                        // populate $levels array
                                        $query = "SELECT under_id, user_id FROM auto_pool WHERE pool_id ='" . $under_id . "'";
                                        $result = mysqli_query($con, $query);
                                        $row = mysqli_fetch_assoc($result);
                                        $pool_levels[] = $row["under_id"]; // add first level referral
                                        $pool_levels_user_id[] = $row["user_id"];


                                        for ($i = 1; $i <= 5; $i++) {
                                            $query = "SELECT under_id, user_id FROM auto_pool WHERE pool_id ='" . $pool_levels[$i - 1] . "'";
                                            $result = mysqli_query($con, $query);
                                            $row = mysqli_fetch_assoc($result);
                                            if ($row["under_id"] != '') { // check if referral exists
                                                $pool_levels[] = $row["under_id"]; // add next level referral
                                                $pool_levels_user_id[] = $row["user_id"];
                                            } else {
                                                break; // stop if no more referrals
                                            }
                                        }

                                        // now you can access user IDs and names using $pool_levels and $pool_levels_user_id arrays
                                        foreach ($levels as $i => $level) {
                                            echo "Level " . ($i + 1) . ": User ID = " . $pool_levels[$i] . ", User Name = " . $pool_levels_user_id[$i] . "\n";
                                        }


                                         
                                       // update database with income for each level
                                           $stmt = $con->prepare("UPDATE transaction SET ewallet_balance = ?, auto_pool_amount = ?, ewallet = ?  WHERE userids = ?");
                                                $stmt->bind_param("iiis", $new_ewallet_balance, $new_auto_pool_amount, $new_ewallet, $userid);
                                                
                                                foreach ($pool_levels_user_id as $i => $pool_level_user_id) {
                                                    $income = $pool_income_levels[$i];
                                                    $userid = $pool_level_user_id;
                                                
                                                    $query = "SELECT * FROM transaction WHERE userids ='$userid'";
                                                    $result = mysqli_query($con, $query);
                                                    $row = mysqli_fetch_assoc($result);
                                                
                                                    $ewallet_balance = $row["ewallet_balance"];
                                                    $auto_pool_amount = $row["auto_pool_amount"];
                                                    $ewallet = $row["ewallet"];
                                                
                                                    $new_ewallet = $ewallet + $income;
                                                    $new_ewallet_balance = $ewallet_balance + $income;
                                                    $new_auto_pool_amount = $auto_pool_amount + $income;
                                                
                                                    // Re-assign values to bound parameters
                                                    $stmt->bind_param("iiis", $new_ewallet_balance, $new_auto_pool_amount, $new_ewallet, $userid);
                                                    $stmt->execute();
                                                }

                                        for ($i = 1; $i <= 5; $i++) {
                                            $query = "SELECT ewallet_balance FROM transaction WHERE userids ='" . $pool_levels_user_id[$i - 1] . "'";
                                            $result = mysqli_query($con, $query);
                                            $row = mysqli_fetch_assoc($result);
                                            if ($row["ewallet_balance"] != '') { // check if referral exists
                                                $ewallet_balance_levels[] = $row["ewallet_balance"]; // add next level referral
                                            }
                                        }
                                        
                                        $query = "INSERT INTO `transaction_requst`( `user_id`, `camount`,  `status`,  `status2`, `cbalance`, `from_user_id`) VALUES ";
                                        $values = [];
                                        
                                        $levelsCount = count($levels);
                                        $batchSize = 10; // Insert 10 users at a time
                                        $batchCount = ceil($levelsCount / $batchSize);
                                        
                                        for ($batch = 0; $batch < $batchCount; $batch++) {
                                            $start = $batch * $batchSize;
                                            $end = min($start + $batchSize, $levelsCount);
                                        
                                            $batchValues = [];
                                            $params = [];
                                            for ($i = $start; $i < $end; $i++) {
                                                $userid = $pool_levels_user_id[$i];
                                                $income = $pool_income_levels[$i];
                                                $status = "accepted";
                                                $status2 = "Auto Pool Income Level-" . ($i + 1); // handle the last iteration
                                                $balance = $ewallet_balance_levels[$i];
                                                $from_user_id = $user_id;
                                        
                                                $batchValues[] = " (?, ?, ?, ?, ?, ?)";
                                                $params[] = $userid;
                                                $params[] = $income;
                                                $params[] = $status;
                                                $params[] = $status2;
                                                $params[] = $balance;
                                                $params[] = $from_user_id;
                                            }
                                        
                                            $query .= implode(", ", $batchValues);
                                            $stmt = $con->prepare($query);
                                        
                                            $types = str_repeat("ssssss", count($batchValues));
                                            $stmt->bind_param($types, ...$params);
                                            $stmt->execute();
                                            echo "User transactions saved on tran_requst table\n";
                                        
                                            // Reset the query for the next batch
                                            $query = "INSERT INTO `transaction_requst`( `user_id`, `camount`,  `status`,  `status2`, `cbalance`, `from_user_id`) VALUES ";
                                        }
                                        $stmt->close();
                                    
                                }
                            }
                        }
                    }
                }
            }

            $query = "SELECT * FROM level_income_master WHERE packagename = '$product_name'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);


            $level_1_li = $row['level_1'];
            $level_2_li = $row['level_2'];
            $level_3_li = $row['level_3'];
            $level_4_li = $row['level_4'];
            $level_5_li = $row['level_5'];
            $level_6_li = $row['level_6'];
            $level_7_li = $row['level_7'];
            $level_8_li = $row['level_8'];
            $level_9_li = $row['level_9'];
            $level_10_li = $row['level_10'];


            $query = "SELECT referalid, referalname FROM users WHERE userid ='$user_id'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);

            $referalid = $row["referalid"];
            $referalname = $row["referalname"];

            // ...

            // ...

            $levels = array();
            $income_levels = array($level_1_li, $level_2_li, $level_3_li, $level_4_li, $level_5_li, $level_6_li, $level_7_li, $level_8_li, $level_9_li, $level_10_li);

            // populate $levels array
            $query = "SELECT referalid FROM users WHERE userid ='" . $referalid . "'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);
            $levels[] = $row["referalid"]; // add first level referral

            for ($i = 1; $i <= 10; $i++) {
                $query = "SELECT referalid FROM users WHERE userid ='" . $levels[$i - 1] . "'";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_assoc($result);
                $levels[] = $row["referalid"]; // add next level referral

                $income = $income_levels[$i];
                $userid = $levels[$i - 1]; // use the previous level's userid
                // update database with income for each level
                $stmt = $con->prepare("UPDATE transaction SET ewallet_balance = ewallet_balance + ?, ewallet = ewallet + ? WHERE userids = ?");
                $stmt->bind_param("iis", $income, $income, $userid);
                $stmt->execute();

                echo "UserID: $userid, Income: $income<br>";
            }

            for ($i = 1; $i <= 10; $i++) {
                $query = "SELECT ewallet_balance FROM transaction WHERE userids ='" . $levels[$i - 1] . "'";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_assoc($result);

                $current_balance = $row["ewallet_balance"]; // store the current balance
                $ewallet_balance_levels[] = $current_balance; // add next level referral

                $userid = $levels[$i - 1];
                echo "userID: $userid, balance: $current_balance<br>";
            }
            // Define the query with placeholders
            $stmt = $con->prepare("INSERT INTO `transaction_requst` (
`user_id`, 
`camount`,  
`status`,  
`status2`, 
`cbalance`, 
`from_user_id`
) VALUES (?, ?, ?, ?, ?, ?)");

            // Check if the statement was prepared successfully
            if (!$stmt) {
                echo "Failed to prepare statement: " . $con->error;
                exit();
            }

            // Loop through the levels and execute the query
            foreach ($levels as $i => $level) {
                $userid = $level;
                $income = $income_levels[$i];
                $status = "accepted";
                $status2 = "Level Income Level-" . ($i + 1);
                $balance = $ewallet_balance_levels[$i];
                $from_user_id = $user_id;

                // Bind the parameters
                $stmt->bind_param("ssssss", $userid, $income, $status, $status2, $balance, $from_user_id);

                // Execute the query
                if (!$stmt->execute()) {
                    echo "Failed to execute query: " . $stmt->error;
                    exit();
                } else {
                    echo "UserID: $userid, Income: $income, balance: $balance<br>";;
                }
            }
            echo '<script>alert("Check Out Successfully Updated");window.location.href = "dash_bord.php";</script>';
        } else {
            echo '<script>alert("Insufficient balance");window.location.href = "recharge.php";</script>';
        }
    } else {
        echo '<script>alert("Invalid user ID or password");window.location.href = "dash_bord_packages.php";</script>';
    }
}

?>
<section>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">

        <div class="page-container">


            <div class="avatar-img">
                <img class="check-avatar" src="<?php echo $image; ?>">
            </div>
            <div class="check-details">
                <div class="check-items">
                    <h2 class="head-lines">User ID</h2>
                    <div>
                        <input type="text" class="txt-user-id" name="user_id" value="<?php echo $user_id; ?>" readonly>

                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Wallet Available Balence</h2>
                    <div>
                        <input type="text" class="txt-user-id" name="ewallet_balance" value="<?php echo $ewallet_balance; ?>" readonly>

                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Product Name</h2>
                    <div>
                        <input type="text" class="txt-user-id" name="product_name" value="<?php echo $row['packagename']; ?>" readonly>
                        <input type="hidden" name="swallet_add" value="<?php echo $row['addswalletfund']; ?>">
                        <input type="hidden" name="type" value="<?php echo $row['packageorproduct']; ?>">
                        <input type="hidden" name="referralvalue" value="<?php echo $row['referralvalue']; ?>">
                        <input type="hidden" name="packagealgibulity" value="<?php echo $row['packagealgibulity']; ?>">
                        <input type="hidden" name="product_code" value="<?php echo $row['productcode']; ?>">
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Product Amount</h2>
                    <div>
                        <input type="text" class="txt-user-id" name="amount" value="<?php echo $row['dp']; ?>" readonly>

                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Cash Back</h2>
                    <div>

                        <input type="text" class="txt-user-id" name="cash_back" value="<?php echo $row['cashbackamount']; ?>" readonly>
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">S-Wallet Discount</h2>
                    <div>

                        <input type="text" class="txt-user-id" name="swallet_discount" value="<?php echo $row['swalletdiscount']; ?>" readonly>
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">S-Wallet Balance</h2>
                    <div>

                        <input type="text" class="txt-user-id" name="swallet_balance" value="<?php echo $swallet_balance; ?>" readonly>
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Total Pay</h2>
                    <div>

                        <input type="text" class="txt-user-id" name="total_pay" value="<?php echo $new_product_price; ?>" readonly>
                    </div>
                </div>

                <div class="button-check-div">
                    <a href="product_viwe.php?product_code=<?php echo $row["productcode"]; ?> "><button type="button" class="button-check red">BACK</button></a>
                    <button type="button" class=" button-check green" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Pay Now
                    </button>

                    <!-- Modal -->


                </div><br><br><br><br><br>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Transaction Mathed</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <label for="name" class="active-id">Transaction Pin</label><BR>
                        <input type="text" class="txt-user-id" name="tpassword" placeholder="Enter Transaction Pin">

                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" name="submit" value="submit">

                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
<?php

?>