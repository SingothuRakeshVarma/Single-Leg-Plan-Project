<?php
include('user_header.php');
include('../connect.php');




/// Function to validate and save data
function save_data($userid, $old_password, $new_password, $confirm_password, $password_type) {
    global $con;

    // Validate data
    if (empty($userid) || empty($old_password) || empty($new_password) || empty($confirm_password)) {
        return "All fields are required.";
    }

    if ($new_password !== $confirm_password) {
        return "New password and confirm password do not match.";
    }

    // Check if user exists
    $query = "SELECT * FROM users WHERE userid = '$userid'";
    $result = $con->query($query);
    if ($result->num_rows === 0) {
        return "User ID does not exist.";
    }

    // Update password
    if ($password_type === 'profile_pass') {
        $query = "UPDATE users SET password = '$new_password' WHERE userid = '$userid'";
    } elseif ($password_type === 'tra_password') {
        $query = "UPDATE users SET tpassword = '$new_password' WHERE userid = '$userid'";
    }

    if ($con->query($query) === TRUE) {
        return "Password updated successfully.";
    } else {
        return "Error updating password: " . $con->error;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_POST["userid"];
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    $password_type = $_POST["password-types"];

    $message = save_data($userid, $old_password, $new_password, $confirm_password, $password_type);
    echo $message;
}

?>
<section>
<div>
        <center>
            <h1 class="w-recharge-h1">Password Change</h1>
        </center>
    </div>
    <div class="page-container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="check-details"  method="post">
            <div class="password-types">
                <input name="password-types" type="radio" value="profile_pass" class="types-pas"> Profile password
                <input name="password-types" type="radio" class="types-pas" value="tra_password">Transaction password
            </div>
            <div class="check-items">
                <h2 class="head-lines">User ID</h2>
                <div>
                    <input type="text" name="userid" class="txt-user-id" value="<?php echo $user_id; ?>" readonly />
                </div>
            </div>

            <div class="check-items">
                <h2 class="head-lines">Old Password</h2>
                <div>
                    <input type="text" class="txt-user-id" name="old_password" placeholder="Enter Old Password" required>
                </div>
            </div>
            <div class="check-items">
                <h2 class="head-lines">New Password</h2>
                <div>
                    <input type="text" class="txt-user-id" name="new_password" placeholder="Enter New Password" required>
                </div>
            </div>
            <div class="check-items">
                <h2 class="head-lines">Confirm Password</h2>
                <div>
                    <input type="text" class="txt-user-id" name="confirm_password" placeholder="Enter Confirm Password" required>
                </div>
            </div>

            <div class="button-check-div">
                <a href="./bi_people_fill.php"><button type="button" class="button-check red">BACK</button></a>

                <input type="submit" class="button-check green" value="submit">


            </div><br><br><br>
        </form>
    </div><br><br><br>




</section>