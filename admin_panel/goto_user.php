<?php
include('./header.php');
include('../connect.php');

if (isset($_POST['submit'])) {
    // Start output buffering
    ob_start(); // Start output buffering

    // Assuming you have already established a connection to the database in $con
    $user_id = $_POST['user_id'];

    // Use prepared statements to prevent SQL injection
    $stmt = $con->prepare("SELECT * FROM user_data WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $password = $row['password'];
        // URL encode the parameters to ensure they are safe for the URL
        // header("Location: ../loginpage.php?user_id=" . urlencode($row['user_id']) . "&password=" . urlencode($password));
           echo "<script>window.location.href = '../loginpage.php?user_id=" . urlencode($row['user_id']) . "&password=" . urlencode($password) . "';</script>";
        //         $redirect_url = "../loginpage.php?user_id=" . urlencode($row['user_id']) . "&password=" . urlencode($password);
        //         // Use JavaScript to open in Edge
        //         echo "<script>

        // window.open('https://www.google.com/{$redirect_url}', '_blank'); 
        //     </script>";
    }

    // End output buffering
    ob_end_flush();
}
?>
<style>
.button-check {
        width: 70%;
        height: 30%;
        border: solid 2px lightseagreen;
        border-radius: 30px;
        color: white;
        background-color: transparent;
        margin-left: 30px;
        margin-right: 20px;

    }

    .button-check:hover {
        width: 70%;
        height: 30%;
        border: solid 2px lightseagreen;
        border-radius: 30px;
        color: white;
        background-color: lightseagreen;
    }
    .h1_line{
        color: greenyellow;
    }
</style>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="myForm" target="_blank">
    <center>
        <h1 class="h1_line">TAB TO USER</h1>
    <label class="prof_label">Enter User ID</label><br>
    <input type="text" class="prof_text" name="user_id" placeholder="Enter User ID"><br><br>
    <input type="submit" class="button-check green" name="submit" value="Send">
    </center>
</form><br><br>

<script>
    // Set the form to open in a new tab when submitted
    document.getElementById('myForm').onsubmit = function() {
        this.target = '_blank';
    };
</script>