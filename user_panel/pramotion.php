<?php
include('../connect.php');
include('./header.php');


if (isset($_GET['name'])) {
    $floor_user_tanle = $_GET['name'];
    $_SESSION['floor_users'] = $floor_user_tanle;
    $floor_users = $_SESSION['floor_users'];
} else {
    $floor_users = $_SESSION['floor_users'] ?? 'floor_1_users';
}
$user_id = $_SESSION['user_id'];




switch ($floor_users) {
    case 'floor_1_users':
        $table_name = 'floor_1_table';
        $slp_table = 'slp_1_table';
        $slp_type = 'floor - 1';
        $number = 1;


        break;
    case 'floor_2_users':
        $table_name = 'floor_2_table';
        $slp_table = 'slp_2_table';
        $slp_type = 'floor - 2';
        $number = 2;

        break;
    case 'floor_3_users':
        $table_name = 'floor_3_table';
        $slp_table = 'slp_3_table';
        $slp_type = 'floor - 3';
        $number = 3;

        break;
    case 'floor_4_users':
        $table_name = 'floor_4_table';
        $slp_table = 'slp_4_table';
        $slp_type = 'floor - 4';
        $number = 4;

        break;
    case 'floor_5_users':
        $table_name = 'floor_5_table';
        $slp_table = 'slp_5_table';
        $slp_type = 'floor - 5';
        $number = 5;

        break;
    case 'floor_6_users':
        $table_name = 'floor_6_table';
        $slp_table = 'slp_6_table';
        $slp_type = 'floor - 6';
        $number = 6;

        break;
    default:
        echo "Invalid floor selection.";
        exit;
}

$query = "SELECT * FROM $table_name WHERE user_id = '$user_id' AND active_status != 'Completed'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
// echo $floor_users;
$user_floor_id = $row['floor_id'] ?? null;

if (isset($_GET['id'])) {
    // Sanitize input
    $id = mysqli_real_escape_string($con, $_GET['id']);


    // Determine floor_user based on the ID
    if ($id == 'NoUser') {

        // Prepare the query
        $query = "SELECT * FROM $table_name WHERE user_id = '$user_id' AND active_status != 'Completed'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);


        $floor_user = $row['floor_id'];
    } else {
        $floor_user = $id;
    }

    // Prepare the query
    $query = "SELECT * FROM $floor_users WHERE floor_id = '$floor_user'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);




    $user_name = $row['user_name'] ?? $_SESSION['user_name'];
    $user_id = $row['user_id'] ?? $_SESSION['user_id'];


    $top_user = $user_id;
    $top_name = $user_name;
} else {

    $top_user = $_SESSION['user_id'];
    $top_name = $_SESSION['user_name'];

    class DatabaseException extends Exception {}

    try {
        $query = "SELECT * FROM $table_name WHERE user_id = '$top_user' AND active_status != 'Completed' ";
        $result = mysqli_query($con, $query);



        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (isset($row['floor_id'])) {
                $floor_user = $row['floor_id'];
            } else {
                throw new DatabaseException("floor_id not found in the result.");
            }
        } else {
            $floor_user = "";
            $floor_user; // or handle as you wish
            $no_active_user = $top_user; // Store user ID for "no active" table
        }
    } catch (DatabaseException $e) {
        echo "Error: " . $e->getMessage();
        $floor_user = $_SESSION['floor_id']; // Fallback
    }

    // // Now you can use $floor_user or handle the case for no active users
    // if (isset($no_active_user)) {
    //     // echo "User  $no_active_user is not active.";
    // } else {
    //     echo "User 's floor ID is: $floor_user";
    // }
}


// Initialize variables to store user details
$first_user = $first_user_id = $first_user_name = null;
$second_user = $second_user_id = $second_user_name = null;

// Loop to fetch the first and last users
for ($i = 0; $i < 2; $i++) {
    if ($i == 0) {
        $query = "SELECT * FROM $floor_users WHERE under_id = '$floor_user' AND under_id != '' ORDER BY floor_id ASC LIMIT 1";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);

        // First user details
        $first_user = $row['floor_id'] ?? 'NoUser ';
        $first_user_id = $row['user_id'] ?? 'NoUser ';
        $first_user_name = $row['user_name'] ?? 'NoName';
    } else {
        // Initialize a variable to keep track of the second user's floor_id
        $second_user = 'NoUser ';
        $second_user_id = 'NoUser ';
        $second_user_name = 'NoName';

        // Loop to find a different user
        while (true) {
            $query = "SELECT * FROM $floor_users WHERE under_id = '$floor_user' AND under_id != '' AND floor_id != '$first_user' ORDER BY floor_id DESC LIMIT 1";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);

            // Check if a user was found
            if ($row) {
                $second_user = $row['floor_id'] ?? 'NoUser ';
                $second_user_id = $row['user_id'] ?? 'NoUser ';
                $second_user_name = $row['user_name'] ?? 'NoName';
                break; // Exit the loop if a different user is found
            } else {
                // If no user is found, break the loop
                break;
            }
        }
    }
}

$query = "SELECT count(*) as count FROM $floor_users WHERE under_id = '$floor_user'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$count = $row['count'] ?? 0;

function fetchUserDetails($con, $floor_users, $under_id, $order = 'ASC', $first_id = '')
{
    $query = "SELECT * FROM $floor_users WHERE under_id = '$under_id' AND floor_id != '$first_id' AND under_id != '' ORDER BY floor_id $order LIMIT 1";
    $result = mysqli_query($con, $query);
    return mysqli_fetch_assoc($result);
}

// Fetch details for the first user
$first_user_row = fetchUserDetails($con, $floor_users, $first_user, 'ASC');
$first_user_child = $first_user_row['floor_id'] ?? 'NoUser ';
$first_user_id_child = $first_user_row['user_id'] ?? 'NoUser ';
$first_user_name_child = $first_user_row['user_name'] ?? 'NoName';


// Fetch details for the second user (last)
$first_user_row = fetchUserDetails($con, $floor_users, $first_user, 'DESC', $first_user_child);
$first_user_child2 = $first_user_row['floor_id'] ?? 'NoUser ';
$first_user_id_child2 = $first_user_row['user_id'] ?? 'NoUser ';
$first_user_name_child2 = $first_user_row['user_name'] ?? 'NoName';



// Fetch details for the second user
$second_user_row = fetchUserDetails($con, $floor_users, $second_user, 'ASC');
$second_user_child = $second_user_row['floor_id'] ?? 'NoUser ';
$second_user_id_child = $second_user_row['user_id'] ?? 'NoUser ';
$second_user_name_child = $second_user_row['user_name'] ?? 'NoName';


// Fetch details for the second user (last)
$second_user_row = fetchUserDetails($con, $floor_users, $second_user, 'DESC', $second_user_child);
$second_user_child2 = $second_user_row['floor_id'] ?? 'NoUser ';
$second_user_id_child2 = $second_user_row['user_id'] ?? 'NoUser ';
$second_user_name_child2 = $second_user_row['user_name'] ?? 'NoName';

if ($user_floor_id == $floor_user) {


    $query = "SELECT count(*) as count FROM $floor_users WHERE under_id = '$floor_user'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'] ?? 0;

    $query = "SELECT count(*) as count FROM $floor_users WHERE under_id = '$first_user'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $count1 = $row['count'] ?? 0;

    $query = "SELECT count(*) as count FROM $floor_users WHERE under_id = '$second_user'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $count2 = $row['count'] ?? 0;

    $total_users = $count + $count1 + $count2;

    // $total_users = 6;

    $query = "UPDATE $table_name SET floor_users_count = $total_users WHERE floor_id = '$user_floor_id'";
    $result = mysqli_query($con, $query);
}



// Prepare the SQL statement to prevent SQL injection
$query = "SELECT * FROM $table_name WHERE floor_id = ? AND active_status != 'Completed'";
$stmt = $con->prepare($query);

// Check if the statement was prepared successfully
if ($stmt === false) {
    die("Error preparing statement: " . $con->error);
}

// Bind the parameter
$stmt->bind_param('s', $user_floor_id);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    // Fetch the associative array
    $row = $result->fetch_assoc();
    $floorincome = $row['income'];
    $floorwithdraw = $row['withdraw'];
    $total_count = $row['floor_users_count'];
} else {
    $floorincome = 0;
    $floorwithdraw = 0;
    $total_count = 0;
}

// Optionally, you can close the statement
$stmt->close();

$query = "SELECT * FROM  slp_master WHERE floor_name = '$slp_type'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$slp_income = $row['total_income'] ?? '0';
$slp_members = $row['add_mumbers'] ?? '0';


$query = "SELECT * FROM  floor_income_master WHERE floor_name = '$slp_type'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$floor_income = $row['total_floor_income'];

if (isset($_GET['amount'])) {
    // Sanitize the input to prevent XSS or other attacks
    $amount = htmlspecialchars($_GET['amount']);


    $query = "SELECT * FROM  user_wallet WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    $net_wallet = $row['net_wallet'];
    $wallet_balance = $row['wallet_balance'];

    $new_net_wallet = $net_wallet + $amount;
    $new_wallet_balance = $wallet_balance + $amount;
    $new_floor_income = $floorincome - $amount;
    $new_floor_withdraw = $floorwithdraw + $amount;

    $query = "UPDATE $table_name SET income = '$new_floor_income', withdraw = '$new_floor_withdraw' WHERE floor_id = '$user_floor_id' AND active_status = 'Active'";
    $result = mysqli_query($con, $query);


    $query = "UPDATE user_wallet SET net_wallet = '$new_net_wallet', wallet_balance = '$new_wallet_balance' WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $query);
    if ($result) {
        echo "<script>alert('Amount added successfully');window.location.href = 'pramotion.php';</script>";
    }

    $query = "INSERT INTO deposit (user_id, amount, tstatus, status, t_balance) VALUES ('$user_id', '$amount', 'SLP Share ', 'accepted', '$new_wallet_balance')";
    $result = mysqli_query($con, $query);
}


$query = "SELECT * FROM $table_name WHERE user_id = '$user_id' AND active_status != 'Completed'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$floor_user = $row['floor_id'] ?? 'User InActive';

?>
<style>
    .container {
        text-align: center;
        max-width: 100%;
        color: white;
        margin: 5%
    }


    .circle {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #333;
    }

    .circle1 {
        position: relative;
        right: -20px;
    }

    .circle2 {
        position: relative;
        right: 20px;
    }



    .top-user {
        margin-bottom: 20px;

    }

    .lines {
        display: flex;
        justify-content: center;
        position: relative;
        left: 10px;


    }

    .lines11 {
        display: flex;
        justify-content: center;
        position: relative;
        left: 110px;

    }

    .lines1 {
        display: flex;
        justify-content: center;
        margin: 0 40px;

    }

    .lines2 {
        display: flex;
        justify-content: center;
        position: relative;
        left: -20px;
    }

    .line1 {
        width: 2px;
        height: 60px;
        background-color: #333;
        position: relative;
        top: -15px;
        margin: 0 0px;
        transform: rotate(40deg);
    }

    .line2 {
        width: 60px;
        height: 2px;
        background-color: #333;
        position: relative;
        top: 14px;
        right: -30px;
        margin: 0 15px;
        transform: rotate(50deg);
    }

    .line3 {
        width: 2px;
        height: 60px;
        background-color: #333;
        position: relative;
        top: -15px;
        left: 25px;
        margin: 0 20px;
        transform: rotate(40deg);
    }

    .line4 {
        width: 60px;
        height: 2px;
        background-color: #333;
        position: relative;
        top: 14px;
        right: 0px;
        margin: 0 20px;
        transform: rotate(50deg);
    }

    .users {
        display: flex;
        justify-content: center;
    }

    .user {
        margin: 0 0px;
        position: relative;
        left: 100px;
    }

    .user111 {
        margin: 0 0px;
        position: relative;
        left: 80px;
    }

    .user1 {
        margin: 0 0px;
        position: relative;
        left: -130px;
    }

    .sub-users {
        display: flex;
        justify-content: center;
        padding: px;
        position: relative;
        right: -8px;
        top: -30px;
    }

    .sub-users1 {
        display: flex;
        justify-content: center;
        padding: px;
        position: relative;
        right: 8px;

    }



    .sub-user {
        margin: 0 8px;
        position: relative;
        top: 70px;
        right: 80px;
        padding: 0 30px;
    }

    .sub-user111 {
        margin: 0 8px;
        position: relative;
        top: 70px;
        right: 90px;
        padding: 0 30px;
    }

    .sub-user1 {
        margin: 0 8px;
        position: relative;
        top: 70px;
        right: 110px;
        padding: 0 30px;
    }

    .subuser1 {
        margin: 0 30px 0 20px;
        position: relative;
        left: 5px;
    }

    table {
        border-collapse: collapse;
        width: 80%;
        border: 2px solid darkcyan;
        /* Set border color to white */
        align-items: center;
        margin: 10px 40px;
    }

    .tree_set {
        width: 20%;
        display: flex;
        justify-content: space-around;
        position: relative;
        right: 350px;
    }

    .tree_images1 {
        display: flex;
        justify-content: center;
        position: relative;
        top: -360px;


    }

    @media only screen and (min-width: 768px) {
        .tree_set {
            right: 270px;
            padding: 0 110px;
            /* You can keep other properties as they are, if they don't need to change */
        }

        .tree_images1 {
            display: flex;
            justify-content: center;
            position: relative;
            top: -360px;


        }
    }

    .sub-users11 {
        display: flex;
        justify-content: center;
        width: 10px;
        position: relative;
        left: 400px;
        top: -210px;
    }

    @media only screen and (min-width: 768px) {
        table {
            border-collapse: collapse;
            width: 80%;
            border: 2px solid darkcyan;
            /* Set border color to white */
            align-items: center;
            margin: 10px 130px;
        }

        .sub-users11 {
            display: flex;
            justify-content: center;
            width: 10px;
            position: relative;
            left: 1000px;
            top: -210px;
        }

    }

    th,
    td {
        border: 1px solid darkcyan;
        /* Set border color to white for cells */
        padding: 8px;
        text-align: center;
        color: white;
        /* Optional: change text color to white for better visibility */
    }

    .floor_with {
        border: 2px solid darkcyan;
        width: 80%;
        text-align: center;
        display: flex;
        justify-content: space-around;
        padding: 15px 10px 1px 10px;
        color: white;
    }

    .user_names {
        font-size: small;
        position: relative;
        top: -20px;
    }

    .no_user {
        display: flex;
        justify-content: center;
        margin: 70px;
        cursor: pointer;
    }



    .img1 {
        margin: 0 30px 0 30px;
    }

    .img2 {
        margin: 0 30px 0 30px;
    }

    .img3 {
        margin: 0 70px;
    }

    .img4 {
        margin: 0 70px;
    }

    .tree_lines1 {
        display: flex;
        justify-content: center;
        position: relative;
        top: 20px;
        left: -70px;

    }

    .circle_111 {
        display: flex;
        justify-content: center;
    }

    .level_1 {
        width: 100%;
        display: flex;
        justify-content: center;

    }

    .level_2 {
        width: 100%;
        display: flex;
        justify-content: center;
        position: relative;
        top: -0px;

    }

    .floor_with {
        border: 2px solid darkcyan;
        width: 80%;
        text-align: center;
        display: flex;
        justify-content: space-around;
        padding: 15px 10px 1px 10px;
        color: white;
    }

    .button_3 {
        width: 25%;
        height: 50px;
        position: relative;
        top: 20px;
        left: -2px;
        border: solid 2px darkcyan;
        color: white;
        background-color: transparent;
    }

    .button_3:hover {
        width: 25%;
        height: 50px;
        position: relative;
        top: 20px;
        left: -2px;
        border: solid 2px darkcyan;
        color: white;
        background-color: darkcyan;
    }

    .report_slp {
        color: white;
        font-size: 30px;
        font-weight: bold;
    }

    .table-container {
        overflow-x: auto;
        /* Enable horizontal scrolling */
        max-width: 100%;
        /* Prevent the table from expanding beyond the container */
        border: 1px solid transparent;
        /* Optional: Add border around the table container */
    }

    .fl_wt_btn {
        border: solid 2px darkcyan;
        color: white;
        background-color: transparent;
        border-radius: 40px;
        position: relative;
        top: -7px;
    }

    .fl_wt_btn:hover {
        border: solid 1px darkcyan;
        color: white;
        background-color: darkcyan;
        border-radius: 40px;
        position: relative;
        top: -7px;
    }

    @media only screen and (min-width: 768px) {
        .no_user1 {
            position: relative;
            left: -150px;
        }
    }
</style>


<section>
    <center>
        <h id="floor-heading" style="font-size: 30px; color: white;">FLOOR - <?php echo $number ?></h><br><samp>
            <select name="floor" id="floor" style="font-size: 20px; color: black; font-weight: bold;" onchange="floorNameTop(this.value)">
                <option value="">Select Floor</option>
                <option value="floor_1_users">Floor 1</option>
                <option value="floor_2_users">Floor 2</option>
                <option value="floor_3_users">Floor 3</option>
                <option value="floor_4_users">Floor 4</option>
                <option value="floor_5_users">Floor 5</option>
                <option value="floor_6_users">Floor 6</option>
            </select>
        </samp>

        <p style="font-size: 20px; color: green; font-weight: bold;"><?php echo htmlspecialchars($floor_user); ?></p>
    </center><br>


    <div class="table-container">
        <div class="container" style="margin-left: 90px;">
            <?php
            include('../connect.php');

            $query = "SELECT * FROM user_data WHERE user_id = '$top_user'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);

            $top_image = $row['images'];
            ?>
            <div class="top-user">
                <img src="<?php echo $top_image ?? '../images/user_image.png'; ?>" alt="Top User" class="circle">
                <p><?php echo $top_user ?? $_SESSION['user_id']; ?></p> <!-- PHP for dynamic content -->
                <p class="user_names"><?php echo $top_name ?? $_SESSION['user_name']; ?></p> <!-- PHP for dynamic content -->
            </div>

            <div class="lines">
                <div class="line1"></div>
                <div class="line2"></div>
            </div>
            <center>
                <?php
 include('../connect.php');
                $query = "SELECT * FROM user_data WHERE user_id = '$first_user_id'";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_assoc($result);

                $first_user_image = $row['images'];
                $query = "SELECT * FROM user_data WHERE user_id = '$second_user_id'";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_assoc($result);

                $second_user_image = $row['images'];
                ?>
                <div class="level_1">
                    <img onclick="flooridTop('<?php echo $first_user; ?>')" src="<?php echo $first_user_image ?? '../images/user_image.png'; ?>" alt="First User" class="circle img3">
                    <img onclick="flooridTop('<?php echo $second_user; ?>')" src="<?php echo $second_user_image ?? '../images/user_image.png'; ?>" alt="Last User" class="circle img4">
                </div>

                <div class="level_2">
                    <div style="position: relative; left: -50px; ">


                        <p onclick="flooridTop('<?php echo $first_user; ?>')"><?php echo $first_user_id; ?></p>
                        <p style="position: relative; top: -20px;" onclick="flooridTop('<?php echo $first_user; ?>')"><?php echo $first_user_name; ?></p> <!-- PHP for dynamic content -->
                    </div>
                    <div style="position: relative; left: 70px;">

                        <p onclick="flooridTop('<?php echo $second_user; ?>')"><?php echo $second_user_id; ?></p>
                        <p style="position: relative; top: -20px;" onclick="flooridTop('<?php echo $second_user; ?>')"><?php echo $second_user_name; ?></p> <!-- PHP for dynamic content -->
                    </div>
                </div>

                <div class="tree_lines1">
                    <div class="lines1">
                        <div class="line1"></div>
                        <div class="line2"></div>
                    </div>
                    <div class="lines11">
                        <div class="line1"></div>
                        <div class="line2"></div>
                    </div>
                </div>
                <div class="sub-users">

                    <div class="no_user" style="position: relative;left: -75px;">

                        <p onclick="flooridTop('<?php echo $first_user_child; ?>')" style="position: relative;left: -35px; top: 50px; margin-left: 20px;"><?php echo $first_user_id_child; ?> </p>
                        <p onclick="flooridTop('<?php echo $first_user_child; ?>')" style="position: relative;left: -115px; top: 70px;"><?php echo $first_user_name_child; ?> </p>

                        <p onclick="flooridTop('<?php echo $first_user_child2; ?>')" style="position: relative;left: -35px; top: 50px;"><?php echo $first_user_id_child2; ?> </p>
                        <p onclick="flooridTop('<?php echo $first_user_child2; ?>')" style="position: relative;left: -115px; top: 70px;"><?php echo $first_user_name_child2; ?> </p>
                    </div>






            </center>
            <div class="sub-users11">

                <div class="no_user no_user1">

                    <p onclick="flooridTop('<?php echo $second_user_child; ?>')" style="position: relative;left: -35px; top: 49px;"><?php echo $second_user_id_child; ?> </p>
                    <p onclick="flooridTop('<?php echo $second_user_child; ?>')" style="position: relative;left: -115px; top: 70px;"><?php echo $second_user_name_child; ?> </p>

                    <p onclick="flooridTop('<?php echo $second_user_child2; ?>')" style="position: relative;left: -75px; top: 49px;"><?php echo $second_user_id_child2; ?> </p>
                    <p onclick="flooridTop('<?php echo $second_user_child2; ?>')" style="position: relative;left: -155px; top: 70px;"><?php echo $second_user_name_child2; ?> </p>
                </div>


            </div>
            <?php

include('../connect.php');
            $query = "SELECT * FROM user_data WHERE user_id = '$first_user_id_child'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);

            $first_user_child1_image = $row['images'];

            $query = "SELECT * FROM user_data WHERE user_id = '$first_user_id_child2'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);

            $first_user_child2_image = $row['images'];

            $query = "SELECT * FROM user_data WHERE user_id = '$second_user_id_child'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);

            $second_user_child1_image = $row['images'];

            $query = "SELECT * FROM user_data WHERE user_id = '$second_user_id_child2'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);

            $second_user_child2_image = $row['images'];
            ?>

            <div class="tree_images1">
                <img onclick="flooridTop('<?php echo $first_user_child; ?>')" src="<?php echo $first_user_child1_image ?? '../images/user_image.png'; ?>" alt="Sub User" class="circle img1">
                <img onclick="flooridTop('<?php echo $first_user_child2; ?>')" src="<?php echo $first_user_child2_image ?? '../images/user_image.png'; ?>" alt="Sub User" class="circle img2">

                <img onclick="flooridTop('<?php echo $second_user_child; ?>')" src="<?php echo $second_user_child1_image ?? '../images/user_image.png'; ?>" alt="Sub User" class="circle img1">
                <img onclick="flooridTop('<?php echo $second_user_child2; ?>')" src="<?php echo $second_user_child2_image ?? '../images/user_image.png'; ?>" alt="Sub User" class="circle img2">
            </div>


        </div>
    </div>

</section><BR><BR><BR><BR>

<section>
    <center>
        <table>
            <tr>

                <th>SLP Members</th>
                <th>SLP Income</th>
                <th>floor Members</th>
                <th>floor Income</th>

            </tr>
            <tr>
                <td><?php echo $slp_members; ?></td>
                <td><?php echo $slp_income; ?></td>

                <td><?php echo $total_count; ?> </td>
                <td><?php echo $floor_income; ?></td>
            </tr>
        </table>

    </center>
</section>

<section>
    <center>
        <div class="floor_with">
            <div>
                <p style="font-weight: bold;">SLP Income</p>
            </div>
            <div>
                <p style="font-weight: bold;"><?php echo $floorincome; ?> / <?php echo $floorwithdraw; ?></p>
            </div>
            <?php
            $threshold_count = 6;
            if ($total_count == $threshold_count): ?>
                <input type="submit" class="fl_wt_btn" onclick="goToWallet(<?php echo $floorincome; ?>)" value="GoTo Wallet">
            <?php endif; ?>
        </div>
    </center>
</section><BR><BR>
<section>
    <center>
        <h class="report_slp">REPORTS</h>
        <div>
            <a href="slp_report.php"><input type="button" class="button_3" value="SLP Report"></a>
            <a href="floor_report.php"> <input type="button" class="button_3" value="Floor Report"></a>
        </div>
    </center>
</section><BR><BR><BR><BR><BR><BR>
<script>
    function floorNameTop(name) {
        window.location.href = 'pramotion.php?name=' + name;
    }

    function flooridTop(id) {
        window.location.href = 'pramotion.php?id=' + id;
    }

    function goToWallet(amount) {
        window.location.href = 'pramotion.php?amount=' + amount;
    }
</script>