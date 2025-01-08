<?php
include('./header.php');
include('../connect.php');

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $subject = $_POST['subject'];
    $admin_answer = $_POST['admin_answer'];
    $status = 'Answered';

    $query = "UPDATE complaint_box SET admin_answer = '$admin_answer', status = '$status', watching_status = 'send' WHERE user_id = '$user_id' AND subject = '$subject'";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo '             
                 <div class="alert-box">
                     <div class="success-circle active">
                         <div class="checkmark"></div>
                     </div>
                     <p class="new_record">Message Successfully Sent To User.</p>
                    
                     <button onclick="window.location.href = \'admin_contact_us.php\';">OK</button>
                 </div>';
    }else{
        echo "<script>alert('Message Not Sent!');window.location.href = 'contact_us.php';</script>";
    }
}
?>
<style>
    .alert-box {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            width: 300px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 100;
            /* Ensure alert box is on top */
        }

        .success-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 5px solid #4CAF50;
            /* Green circle */
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            /* Center the circle */

        }

        .checkmark {
            display: none;
            /* Initially hidden */
            position: relative;
            width: 20px;
            height: 20px;
        }

        .checkmark:before {
            content: "";
            position: absolute;
            width: 15px;
            height: 5px;
            background: #4CAF50;
            top: 12px;
            left: -5px;
            transform: rotate(45deg);
        }

        .checkmark:after {
            content: "";
            position: absolute;
            width: 5px;
            height: 31px;
            background: #4CAF50;
            top: -5px;
            left: 15px;
            transform: rotate(45deg);
        }

        .success-circle.active .checkmark {
            display: block;
            /* Show checkmark when active */
        }

        button {
            background-color: #4CAF50;
            /* Green */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
            /* Darker green on hover */
        }

        .new_record {
            font-weight: bold;
            color: darkgreen;
        }
    .h1_line {
        text-align: center;
        color: lightseagreen;
    }

    .complaint_box {
        border: solid 2px lightseagreen;
        border-radius: 10px;
        color: white;
        width: 80%;
        padding: 20px;
        margin-top: 50px;
    }

    .complaint_name {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        margin-left: 10px;
        color: greenyellow;
        justify-content: center;
        position: relative;
        left: 45%;
    }
    .complaint_types{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-between;
    }
    .bi-trash{
        color: white;
        font-size: 25px;
    }
    .bi-trash:hover{
        color: red;
        font-size: 25px;
    }
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
</style>


<?php
include('../connect.php');

// Assuming $user_id is defined somewhere before this query
$query = "SELECT * FROM complaint_box WHERE status = 'Pending'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $user_id = $row['user_id'];
        $user_name = $row['user_name'];
        $subject = $row['subject'];
        $message = $row['message'];
        $row = [
            // Uncomment the line below to test with a value
            // 'admin_answer' => 'Your answer here'
        ];
        $admin_answer = isset($row['admin_answer']) ? $row['admin_answer'] : 'Message Sent Successfully So Please Wait For Response';

        // Display each complaint
        ?>
        <center>
            <div class="complaint_box">
                <div class="complaint_types">
                    <div class="complaint_name">
                    <p><?php echo htmlspecialchars($user_name); ?></p>&nbsp;&nbsp;<p>( <?php echo htmlspecialchars($user_id); ?> )</p>
                    </div>
                    <div>
                        <a href="delete_complaint.php?user_id=<?php echo $user_id; ?>&subject=<?php echo $subject; ?>"><i class="bi bi-trash"></i></a>
                    </div>
                </div><br>
                <div>
                    <p><?php echo htmlspecialchars($subject); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($message)); ?></p>
                </div>
                <hr><br>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <input type="hidden" name="subject" value="<?php echo $subject; ?>">
                    <textarea class="prof_text" name="admin_answer" placeholder="Enter Your Answer" rows="4" cols="50"></textarea><br><br>
                <input type="submit" class="button-check green" name="submit" value="Send">
                </form><br><br>
            </div><br><br><br><br><br>
        </center>
        <?php
    }
} else {
    echo "<center><p style='color: greenyellow; font-size: 20px; font-weight: bold; margin-top: 20px;'>No Massages found.</p></center><br><br><br><br><br><br><br><br><br><br>";
}
?>