<?php
include('../connect.php');

$floor_users = "floor_1_users";

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']); // Sanitize input
    echo $id;
    // Here you would typically fetch users based on the provided id
    // For example, you might fetch from a database
    // This is just a placeholder
    $floor_user = $id; // Example assignment

    $query = "SELECT * FROM $floor_users WHERE floor_id = '$floor_user'";
    $result = mysqli_query($con, $query);

    $row = mysqli_fetch_assoc($result);
    $floor_user = $row['floor_id'];
    $user_name = $row['user_name'];
    $user_id = $row['user_id'];

    $top_user = $user_id;
    $top_name = $user_name;
} else {
    $floor_user = "FLR592609";
    $top_user = "admin";
    $top_name = "rakesh varma";
}
function fetchUsers($floor_user, $floor_users)
{
    include('../connect.php');

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Initialize an array to hold users
    $users = [];


    // Function to fetch users recursively
    function fetchChildUsers($parent_id, $floor_users, $con, $depth = 0, $max_depth = 5)
    {
        if ($depth > $max_depth) {
            return []; // Prevent further recursion if max depth is reached
        }

        $child_users = [];

        // Query to fetch child users
        $query = "SELECT * FROM $floor_users WHERE TRIM(under_id) = '$parent_id'";
        $result = mysqli_query($con, $query);

        if (!$result) {
            echo "Error fetching child users: " . mysqli_error($con) . "<br>";
            return $child_users;
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $child_users[] = [
                'id' => $row['floor_id'],
                'id1' => $row['user_id'],
                'name' => $row['user_name'],
                'children' => fetchChildUsers($row['floor_id'], $floor_users, $con, $depth + 1, $max_depth) // Recursively fetch child users
            ];
        }

        return $child_users;
    }

    // First query: fetch the first user
    $query1 = "SELECT * FROM $floor_users WHERE TRIM(under_id) = '$floor_user' ORDER BY floor_id ASC LIMIT 1";
    $result1 = mysqli_query($con, $query1);

    if (!$result1) {
        echo "Error in Query 1: " . mysqli_error($con) . "<br>";
    } else {
        while ($row = mysqli_fetch_assoc($result1)) {
            $users_id1 = $row['floor_id'];
            $users_id3 = $row['user_id'];
            $users_name1 = $row['user_name'];

            // Fetch child users for the first user
            $first_user_children = fetchChildUsers($users_id1, $floor_users, $con);
            $users[] = [
                'id' => $users_id1,
                'id2' => $users_id3,
                'name' => $users_name1,
                'children' => $first_user_children
            ];
        }
    }

    // Second query: fetch the last user
    $query2 = "SELECT * FROM $floor_users WHERE TRIM(under_id) = '$floor_user' ORDER BY floor_id DESC LIMIT 1";
    $result2 = mysqli_query($con, $query2);

    if (!$result2) {
        echo "Error in Query 2: " . mysqli_error($con) . "<br>";
    } else {
        while ($row = mysqli_fetch_assoc($result2)) {
            $users_id2 = $row['floor_id'];
            $users_id4 = $row['user_id'];
            $users_name2 = $row['user_name'];

            // Fetch child users for the last user
            $last_user_children = fetchChildUsers($users_id2, $floor_users, $con);
            $users[] = [
                'id' => $users_id2,
                'id1' => $users_id4,
                'name' => $users_name2,
                'children' => $last_user_children
            ];
        }
    }

    return $users; // Return the array of users
}

// Call the function
$users = fetchUsers($floor_user, $floor_users);


// Extract top user, first user, and last user
// Top user is the one defined at the start
$first_user = isset($users[0]) ? $users[0] : null; // First user
$last_user = isset($users[1]) ? $users[1] : null; // Last user

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
        position: relative;
        left: 130px;

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
        margin: 0 20px;
        transform: rotate(40deg);
    }

    .line2 {
        width: 60px;
        height: 2px;
        background-color: #333;
        position: relative;
        top: 14px;
        right: -30px;
        margin: 0 20px;
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
        right: -50px;
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
    }

    .tree_images1 {
        display: flex;
        justify-content: center;
        position: relative;
        top: -160px;
        left: -10px;

    }

    .img1 {
        margin: 40px;
    }

    .img2 {
        margin: 40px;
    }
</style>


<section>
    <center>
        <h style="font-size: 30px;">FLOOR - 1</h>
    </center><br>
    <div class="container">
        <div class="top-user">
            <img src="../images/user_image.png" alt="Top User" class="circle">
            <p><?php echo htmlspecialchars($top_user); ?></p> <!-- PHP for dynamic content -->
            <p class="user_names"><?php echo htmlspecialchars($top_name); ?></p> <!-- PHP for dynamic content -->
        </div>

        <div class="lines">
            <div class="line1"></div>
            <div class="line2"></div>
        </div>
        <center>
            <div class="tree_set" style="position: relative; top: 20px;">
                <div class="user111">
                    <div style="margin: 0 50px 0 0px;">
                        <div class="circle">
                            <img onclick="flooridTop('<?php echo $first_user['id']; ?>')" src="../images/user_image.png" alt="First User" class="circle">
                        </div>

                        <p onclick="flooridTop('<?php echo $first_user['id']; ?>')"><?php echo htmlspecialchars($first_user['id2'] ?? 'No user'); ?></p>
                        <p class="user_names" onclick="flooridTop('<?php echo $first_user['id']; ?>')"><?php echo htmlspecialchars($first_user['name'] ?? ''); ?></p> <!-- PHP for dynamic content -->
                    </div>
                    <div class="sub-users">
                        <div class="lines1">
                            <div class="line1" style="margin: 0 50px 0 0px;"></div>
                            <div class="line2" style="margin: 0 140px 0 0px;"></div>
                        </div>

                        <?php if (empty($first_user['children'])): ?>
                            <div class="no_user" style="position: relative;left: -80px;">

                                <p style="position: relative;left: -145px; top: 60px;">No user </p>

                                <p style="position: relative; left: -20px; top: 60px;">No user </p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($first_user['children'] as $child): ?>
                                <div class="sub-user111" style="position: relative; top: 130px; left: -90px;">

                                    <p onclick="flooridTop('<?php echo $child['id']; ?>')"><?php echo htmlspecialchars($child['id1']); ?></p>
                                    <p class="user_names" onclick="flooridTop('<?php echo $child['id']; ?>')"><?php echo htmlspecialchars($child['name']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="user1">
                    <div style="margin: 0 0px 0 170px;">
                        <div class="circle">
                            <img src="../images/user_image.png" onclick="flooridTop('<?php echo $last_user['id']; ?>')" alt="Last User" class="circle">
                        </div>
                        <p onclick="flooridTop('<?php echo $last_user['id']; ?>')"><?php echo htmlspecialchars($last_user['id1'] ?? 'No user'); ?></p>
                        <p class="user_names" onclick="flooridTop('<?php echo $last_user['id']; ?>')"><?php echo htmlspecialchars($last_user['name'] ?? ''); ?></p> <!-- PHP for dynamic content -->
                    </div>
                    <div class="sub-users11">
                        <div class="lines11">
                            <div class="line1"></div>
                            <div class="line2"></div>
                        </div>

                        <?php if (empty($last_user['children'])): ?>
                            <div class="no_user" style="position: relative;left: -80px;">

                                <p style="position: relative;left: -105px;">No user </p>

                                <p style="position: relative; right: 30px;">No user </p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($last_user['children'] as $child): ?>
                                <div class="sub-user1" style="position: relative; top: 130px; left: -90px;">

                                    <p onclick="flooridTop('<?php echo $child['id']; ?>')"><?php echo htmlspecialchars($child['id1']); ?></p>
                                    <p class="user_names" onclick="flooridTop('<?php echo $child['id']; ?>')"><?php echo htmlspecialchars($child['name']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
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
</section>
<script>
    function flooridTop(id) {
        window.location.href = 'check_topup.php?id=' + id;
    }
</script>