<?php

include("./connect.php");

// Login form submission
if (isset($_POST['submit'])) {
    // Check if POST data is set
    $username = isset($_POST['username']) ? htmlspecialchars(trim($_POST['username'])) : '';
    $password = isset($_POST['password']) ? htmlspecialchars(trim($_POST['password'])) : '';
} elseif (isset($_GET['user_id']) && isset($_GET['password'])) {
    // If POST data is not set, check GET data
    $username = htmlspecialchars(trim($_GET['user_id']));
    $password = htmlspecialchars(trim($_GET['password']));
} else {
    // Handle the case where both POST and GET data are empty
    $username = '';
    $password = '';
    // You can set an error message or handle it as needed
}

// Now you can use $username and $password for further processing
// echo "User ID: " . $username . "<br>";
// echo "Password: " . $password . "<br>";
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
    $_SESSION['activation_status'] = $user['activation_status'];


    // Check user role
    if ($user["role"] == "admin") {
        header('Location: admin_panel/admin_home.php');
    } else {
        header('Location: user_panel/home_page.php');
    }
} else {

    echo '<script>alert("Invalid username or password");window.location.href = "index.php";</script>';
}


// Close connection
$con->close();
