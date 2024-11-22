<?php

include("./connect.php");

// Login form submission
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];


// Start the session
session_start();

// Query to select user data
$query = "SELECT * FROM user_data WHERE user_id='$username' AND password='$password'";
$result = mysqli_query($con, $query);

// Check if user exists
if (mysqli_num_rows($result) > 0) {
    // Get user data
    $user = mysqli_fetch_assoc($result);

    // Store data in the session
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['user_name'] = $user['user_name'];
    $_SESSION['phone_number'] = $user['phone_number'];
    $_SESSION['referalid'] = $user['referalid'];
    $_SESSION['referalname'] = $user['referalname'];
    $_SESSION['images'] = $user['images'];
    $_SESSION['addres'] = $user["addres"];
    $_SESSION['district'] = $user["district"];
    $_SESSION['state'] = $user["state"];
    $_SESSION['country'] = $user["country"];
    $_SESSION['pincode'] = $user["pincode"];
    $_SESSION['activation_status'] = $user['activation_status'];
    

    // Check user role
    if ($user["role"] == "admin") {
        header('Location: admin_panel/admin_homepage.php');
    } else {
        header('Location: user_panel/dash_bord.php');
    }
} else {
   
    echo '<script>alert("Invalid username or password");window.location.href = "index.php";</script>';
}
}

// Close connection
$con->close();
?>

