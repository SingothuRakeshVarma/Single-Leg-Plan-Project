<?php
include("../connect.php");

if (isset($_GET['name'])) {
    $floor_users = $_GET['name'];
} else {
    $floor_users = "floor_1_users";
}


if (isset($_GET['id'])) {
    // Sanitize input
    $id = mysqli_real_escape_string($con, $_GET['id']);

    echo $id;
    // Determine floor_user based on the ID
    if ($id == 'No User') {
        $user_id = "top";
 // Prepare the query
 $query = "SELECT * FROM $floor_users WHERE user_id = '$user_id'";
 $result = mysqli_query($con, $query);
 $row = mysqli_fetch_assoc($result);
 


    
     $floor_user = $row['floor_id'];
     echo $floor_user;

    } else {
        $floor_user = $id; // Use the provided ID
    }

    // Prepare the query
    $query = "SELECT * FROM $floor_users WHERE floor_id = '$floor_user'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    
    echo $floor_user;

       
        $user_name = $row['user_name'];
        $user_id = $row['user_id'];

        $top_user = $user_id;
        $top_name = $user_name;
   
} else {

    $top_user = 'admin';
    $top_name = 'rakesh varma';

    class DatabaseException extends Exception {}

    try {
        $query = "SELECT * FROM $floor_users WHERE user_id = '$top_user'";
        $result = mysqli_query($con, $query);

        if (!$result) {
            throw new DatabaseException("Query failed: " . mysqli_error($con));
        }

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (isset($row['floor_id'])) {
                $floor_user = $row['floor_id'];
            } else {
                throw new DatabaseException("floor_id not found in the result.");
            }
        } else {
            $floor_user = "User InActive";
            $floor_user; // or handle as you wish
            $no_active_user = $top_user; // Store user ID for "no active" table
        }
    } catch (DatabaseException $e) {
        echo "Error: " . $e->getMessage();
        $floor_user = $_SESSION['floor_id']; // Fallback
    }

    // Now you can use $floor_user or handle the case for no active users
    // if (isset($no_active_user)) {
    //     echo "User  $no_active_user is not active.";
    // } else {
    //     echo "User 's floor ID is: $floor_user";
    // }
}

    include('../connect.php');

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Helper function to fetch user details
    function getUserDetails($con, $floor_users, $under_id)
    {
        $query = "SELECT * FROM $floor_users WHERE TRIM(under_id) = '$under_id' ORDER BY floor_id ASC LIMIT 1";
        $result = mysqli_query($con, $query);
        return mysqli_fetch_assoc($result);
    }

    // Fetch the first user
    $row = getUserDetails($con, $floor_users, $floor_user);
    $first_user = $row['floor_id'] ?? 'No User';
    $first_user_id = $row['user_id'] ?? 'No User';
    $first_user_name = $row['user_name'] ?? 'No Name';

  

    // Fetch first user child
    $row_child1 = getUserDetails($con, $floor_users, $first_user);
    $first_user_child = $row_child1['floor_id'] ?? 'No User';
    $first_user_id_child = $row_child1['user_id'] ?? 'No User';
    $first_user_name_child = $row_child1['user_name'] ?? 'No Name';


    // Fetch second user child
    $row_child2 = getUserDetails($con, $floor_users, $first_user);
    $first_user_child2 = $row_child2['floor_id'] ?? 'No User';
    $first_user_id_child2 = $row_child2['user_id'] ?? 'No User';
    $first_user_name_child2 = $row_child2['user_name'] ?? 'No Name';

  

    // Fetch the last user
    $query2 = "SELECT * FROM $floor_users WHERE TRIM(under_id) = '$floor_user' ORDER BY floor_id DESC LIMIT 1";
    $result2 = mysqli_query($con, $query2);
    $row2 = mysqli_fetch_assoc($result2);

    $second_user = $row2['floor_id'] ?? 'No User';
    $second_user_id = $row2['user_id'] ?? 'No User';
    $second_user_name = $row2['user_name'] ?? 'No Name';



    // Fetch second user child
    $row_second_child1 = getUserDetails($con, $floor_users, $second_user);
    $second_user_child = $row_second_child1['floor_id'] ?? 'No User';
    $second_user_id_child = $row_second_child1['user_id'] ?? 'No User';
    $second_user_name_child = $row_second_child1['user_name'] ?? 'No Name';


    // Fetch second user child2
    $row_second_child2 = getUserDetails($con, $floor_users, $second_user);
    $second_user_child2 = $row_second_child2['floor_id'] ?? 'No User';
    $second_user_id_child2 = $row_second_child2['user_id'] ?? 'No User';
    $second_user_name_child2 = $row_second_child2['user_name'] ?? 'No Name';

    


?>

<style>
    .container {
        text-align: center;

        color: black;

    }


    .circle {
        width: 60px;
        height: 60px;
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
        top: -50px;
    }

    .sub-users1 {
        display: flex;
        justify-content: center;
        padding: px;
        position: relative;
        right: 8px;

    }

    .sub-users11 {
        display: flex;
        justify-content: center;
        position: relative;
        right: -220px;
        top: -240px;
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
        border: 2px solid white;
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

    @media only screen and (min-width: 768px) {
        .tree_set {
            right: 270px;
            padding: 0 110px;
            /* You can keep other properties as they are, if they don't need to change */
        }
    }

    @media only screen and (min-width: 768px) {
        table {
            border-collapse: collapse;
            width: 80%;
            border: 2px solid white;
            /* Set border color to white */
            align-items: center;
            margin: 10px 130px;
        }


    }

    th,
    td {
        border: 1px solid white;
        /* Set border color to white for cells */
        padding: 8px;
        text-align: center;
        color: white;
        /* Optional: change text color to white for better visibility */
    }

    .floor_with {
        border: 2px solid white;
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

    .tree_images1 {
        display: flex;
        justify-content: center;
        position: relative;
        top: -360px;


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
</style>

<section>
    <center>
        <h style="font-size: 30px;">FLOOR - 1</h>
    </center><br>
    <div class="container">
        <div class="top-user">
            <img src="../images/user_image.png" alt="Top User" class="circle">
            <p><?php echo $top_user; ?></p> <!-- PHP for dynamic content -->
            <p class="user_names"><?php echo $top_name; ?></p> <!-- PHP for dynamic content -->
        </div>

        <div class="lines">
            <div class="line1"></div>
            <div class="line2"></div>
        </div>
        <center>
            <div class="level_1">
                <img onclick="flooridTop('<?php echo $first_user ; ?>')" src="../images/user_image.png" alt="First User" class="circle img3">
                <img onclick="flooridTop('<?php echo $second_user ; ?>')" src="../images/user_image.png" alt="Last User" class="circle img4">
            </div>

            <div class="level_2">
                <div style="position: relative; left: -50px; ">


                    <p onclick="flooridTop('<?php echo $first_user; ?>')"><?php echo $first_user_id ; ?></p>
                    <p style="position: relative; top: -20px;" onclick="flooridTop('<?php echo $first_user; ?>')"><?php echo $first_user_name; ?></p> <!-- PHP for dynamic content -->
                </div>
                <div style="position: relative; left: 70px;">

                    <p onclick="flooridTop('<?php echo $second_user ; ?>')"><?php echo $second_user_id ; ?></p>
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

                <div class="no_user" style="position: relative;left: -80px;">

                    <p onclick="flooridTop('<?php echo $first_user_child; ?>')" style="position: relative;left: -35px; top: 50px;"><?php echo $first_user_id_child ; ?> </p>
                    <p onclick="flooridTop('<?php echo $first_user_child; ?>')" style="position: relative;left: -90px; top: 70px;"><?php echo $first_user_name_child; ?> </p>

                    <p onclick="flooridTop('<?php echo $first_user_child2; ?>')" style="position: relative;left: -35px; top: 50px;"><?php echo $first_user_id_child2 ; ?> </p>
                    <p onclick="flooridTop('<?php echo $first_user_child2; ?>')" style="position: relative;left: -90px; top: 70px;"><?php echo $first_user_name_child2; ?> </p>
                </div>

            </div>


            <div class="user1">

            </div>



            <div class="sub-users11">
                <div class="no_user">

                    <p onclick="flooridTop('<?php echo $second_user_child; ?>')" style="position: relative;left: -75px; top: 49px;"><?php echo $second_user_id_child ; ?> </p>
                    <p onclick="flooridTop('<?php echo $second_user_child; ?>')" style="position: relative;left: -135px; top: 70px;"><?php echo $second_user_name_child; ?> </p>

                    <p onclick="flooridTop('<?php echo $second_user_child2; ?>')" style="position: relative;left: -75px; top: 49px;"><?php echo $second_user_id_child2 ; ?> </p>
                    <p onclick="flooridTop('<?php echo $second_user_child2; ?>')" style="position: relative;left: -135px; top: 70px;"><?php echo $second_user_name_child2; ?> </p>
                </div>


            </div>
    </div>
    </div>
    </center>
    </div>
    <div class="tree_images1">
        <img onclick="flooridTop('<?php echo $child['id']; ?>')" src="../images/user_image.png" alt="Sub User" class="circle img1">
        <img onclick="flooridTop('<?php echo $child['id']; ?>')" src="../images/user_image.png" alt="Sub User" class="circle img2">

        <img onclick="flooridTop('<?php echo $child['id']; ?>')" src="../images/user_image.png" alt="Sub User" class="circle img1">
        <img onclick="flooridTop('<?php echo $child['id']; ?>')" src="../images/user_image.png" alt="Sub User" class="circle img2">
    </div>
    </div>

</section>
<script>
    function flooridTop(id) {
        window.location.href = 'code_checking.php?id=' + id;
    }

</script>