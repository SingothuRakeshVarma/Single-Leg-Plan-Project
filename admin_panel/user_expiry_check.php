<?php
include('../connect.php');
include('./header.php');



// Button click event handler
if (isset($_POST['inactive_user_check'])) {
    // Query to select users with expiry date less than current date
    $query = "SELECT * FROM users WHERE expiry_date < CURDATE()";

    // Execute the query
    $result = mysqli_query($con, $query);

 

    // Update user activation status to InActive
    while ($row = mysqli_fetch_assoc($result)) {
        $update_query = "UPDATE users SET activation_status = 'InActive', activate_date = '0000-00-00 00:00:00', expiry_date = '0000-00-00 00:00:00', package_vaility_days = '0' WHERE userid = '" . $row['userid'] . "'";
        mysqli_query($con, $update_query);
    }

    $query = "SELECT * FROM product_delivery WHERE user_id ='" . $row['userid'] . "'";
    $result = mysqli_query($con, $query);
    $first_product = mysqli_fetch_assoc($result);
    $product_name = $first_product["product_name"];

    $query = "SELECT * FROM rob_level_income WHERE packagename ='$product_name'";
                    $result = mysqli_query($con, $query);

                    // Fetch the row from the result set
                    $row = mysqli_fetch_assoc($result);

                    
                    $level_1 = $row['level_1'];
                    $level_2 = $row['level_2'];
                    $level_3 = $row['level_3'];
                    $level_4 = $row['level_4'];
                    $level_5 = $row['level_5'];



                    $query = "UPDATE transaction SET self_pv = self_pv * 0 WHERE userids = '$user_id'";
                    $result = mysqli_query($con, $query);



                    $query = "SELECT referalid, referalname, username FROM users WHERE userid ='$user_id'";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_assoc($result);

                    $referalid = $row["referalid"];
                    $referalname = $row["referalname"];
                    $username = $row["username"];

                    $income_levels = array($level_1,  $level_2,  $level_3,  $level_4,  $level_5);
                    $levels_names = array();
                    $levels = array(); // new array to store user IDs

                    // populate $levels array
                    $query = "SELECT referalid, referalname FROM users WHERE userid ='" . $user_id . "'";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_assoc($result);
                    $levels[] = $row["referalid"]; // add first level referral
                    $levels_names[] = $row["referalname"];


                    for ($i = 1; $i <= 5; $i++) {
                        $query = "SELECT referalid, referalname FROM users WHERE userid ='" . $levels[$i - 1] . "'";
                        $result = mysqli_query($con, $query);
                        $row = mysqli_fetch_assoc($result);
                        if ($row["referalid"] != '') { // check if referral exists
                            $levels[] = $row["referalid"]; // add next level referral
                            $levels_names[] = $row["referalname"];
                        } else {
                            break; // stop if no more referrals
                        }
                    }

                    // now you can access user IDs and names using $levels and $levels_names arrays
                    foreach ($levels as $i => $level) {
                        echo "Level " . ($i + 1) . ": User ID = " . $levels[$i] . ", User Name = " . $levels_names[$i] . "\n";
                    }


                    // update database with income for each level
                    $stmt = $con->prepare("UPDATE transaction SET team_pv = team_pv - ? WHERE userids = ?");
                    $stmt->bind_param("ii", $income, $userid);

                    foreach ($levels as $i => $level) {
                        $income = $income_levels[$i];
                        $userid = $level;
                        $stmt->bind_param("is", $income, $userid); // re-bind parameters for each iteration
                        $stmt->execute();
                    }

                    $query = "INSERT INTO `pv_summery` (`user_id`, `user_name`, `pvs`, `levels`, `referral_id`, `form_user_id`,'status') VALUES (?, ?, ?, ?, ?, ?,'Less')";
                    $stmt = $con->prepare($query);

                    $levelsCount = count($levels);
                    for ($i = 0; $i < $levelsCount; $i++) {
                        $userid = $levels[$i];
                        $username = $levels_names[$i];
                        $income = $income_levels[$i];
                        $levelNumber = "Level-" . ($i + 1);
                        $referral_id = $levels[$i + 1] ?? null; // handle the last iteration
                        $form_user_id = $user_id;

                        $stmt->bind_param("ssssss", $userid, $username, $income, $levelNumber, $referral_id, $form_user_id);
                        $stmt->execute();
                    }


$query = "SELECT * FROM users WHERE activation_status = 'Active'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    $active_user_ids = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $active_user_ids[] = $row['userid']; // assuming the column name is 'userid'
    }

    print_r($active_user_ids);

    // Get the team PV for each active user
    foreach ($active_user_ids as $i => $user_id) {
        $query = "SELECT * FROM transaction WHERE userid = '$user_id'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        $team_pv = $row["team_pv"];

        // Get the SPV percentage from the admin charges table
        $query = "SELECT * FROM admin_charges";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        $spv_percentage = $row["spv_percentage"];

        // Calculate the total income
        $total = $team_pv * ($spv_percentage / 100);

        // Update the transaction table
        $query = "UPDATE transaction SET ewallet = ewallet + $total, ewallet_balance = ewallet_balance + $total WHERE userid = '$user_id'";
        $result = mysqli_query($con, $query);

        // Get the updated ewallet balance
        $query = "SELECT * FROM transaction WHERE userid = '$user_id'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        $ewallet_balance = $row["ewallet_balance"];

        // Insert a new transaction request
        $query = "INSERT INTO `transaction_request`(`user_id`, `camount`, `status`, `status2`, `cbalance`) VALUES ('$user_id','$total','accepted','Daily Income','$ewallet_balance')";
        $result = mysqli_query($con, $query);

        echo "UserID: '$user_id', Income: '$total'";
    }
}
    // Print success message
    echo "Inactive users updated successfully!";
}

?>
<style>
    .check_btn{
        width: 15vw;
        
        background-color: orange;
        font-size: 1.5vw;
        margin: 10% 40%;
    }
    .check_container{
        width: 100%;

    }
</style>
<section class="check_container">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
        <div>
            <button class="check_btn" name="inactive_user_check">Inactive User Check</button>
        </div>
    </form>
</section>