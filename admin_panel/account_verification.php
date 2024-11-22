<?php
include('header.php');
include('../connect.php');

if (isset($_POST['submit'])) {
    $username = $_POST['user_id'];

    if (empty($username)) {
        $error = "Please enter user ID.";
    } else {
        $query = "SELECT * FROM users WHERE userid = ? ";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result->num_rows > 0) {
            // User ID exists, set the session variable
            $row = mysqli_fetch_assoc($result);
            $_SESSION['userid'] = $row['userid'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['phonenumber'] = $row['phonenumber'];
            $_SESSION['referalid'] = $row['referalid'];
            $_SESSION['referalname'] = $row['referalname'];
            $_SESSION['images'] = $row['images'];

           echo "<script>window.open('../user_panel/dash_bord.php', '_blank');</script>";
        } else {
            $error = "Invalid user ID.";
        }
    }
}
?>

<section>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="page-container">
        <div class="check-details">
            <center>
                <h1 style="font-size: 150%;">Account Verification</h1>
            </center>

            <div class="check-items">
                <label for="name" class="active-id">User ID</label><BR>
                <input type="text" class="txt-user-id" name="user_id" placeholder="Enter User ID">
            </div>
            <div class="button-check-div">
                <a href="./managers.php"><button type="button" class="button-check red">BACK</button></a>
                <input type="submit" class=" button-check green" value="Login" name="submit" onclick="action='../user_panel/dash_bord.php'; target='_blank';">
            </div></br></br></br>
        </div>
    </form>
</section>

<?php
if (isset($error)) {
    echo "<p style='color: red;'>$error</p>";
}
?>

