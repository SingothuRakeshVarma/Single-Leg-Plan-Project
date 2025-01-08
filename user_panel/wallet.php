<?php
include('./header.php');
include('../connect.php');

$user_id = $_SESSION['user_id'];

$query = "SELECT SUM(amount) AS total_amount FROM deposit WHERE user_id = '$user_id' AND tstatus = 'Recharge' AND status = 'accepted'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$total_deposit = $row["total_amount"] ?? 0;

$query = "SELECT * FROM user_wallet WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$wallet_total = $row["wallet_balance"];
$wallet_withdraw = $row["wallet_withdraw"];

$query = "SELECT * FROM admin_charges WHERE id = 'admin'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$Min_withdrows = $row["Min_withdrows"];
$max_withdrows = $row["max_withdrows"];
$spv = $row["spv"];
$tds = $row["tds"];
$admin_charges = $row["admin_charges"];
$ftc_1 = $row["ft_charges"];



// DEPOSIT LOGICS
if ($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_POST["deposit"])) {

    // Collecting form data
    $user_id = htmlspecialchars(trim($_POST['duser_id']));
    $damount = htmlspecialchars(trim($_POST['damount']));
    $utr_number = htmlspecialchars(trim($_POST['dtrutr']));
    $transaction_pin = htmlspecialchars(trim($_POST['tpassword']));

    // You can now process the data (e.g., save to database, send email, etc.)
    // For demonstration, let's just print it
    // echo "<h2>Form Data Submitted:</h2>";
    // echo "User  ID: " . $user_id . "<br>";
    // echo "Amount: " . $damount . "<br>";
    // echo "UPI UTR Number: " . $utr_number . "<br>";
    // echo "Transaction Pin: " . $transaction_pin . "<br>";

    $amountString = $damount;
    $amount = preg_replace('/[^0-9]/', '', $amountString);
    // echo $amount;

    // Check if the transaction password is correct
    $query = "SELECT * FROM user_data WHERE tpassword = '$transaction_pin' AND user_id = '$user_id'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        
        $query = "SELECT * FROM deposit WHERE user_id = '$user_id' AND status = 'Processing'";
        $result = mysqli_query($con, $query);
        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Your Previous Deposit Still Processing so please wait after try again')</script>";
            
        }else{
        // Fetch wallet balance
        // $query = "SELECT * FROM user_wallet WHERE user_id ='$user_id'";
        // $result = mysqli_query($con, $query);
        // $row = mysqli_fetch_assoc($result);

        // $new_balance = $row['wallet_balance'] + $amount;
        // $new_net_wallet = $row['net_wallet'] + $amount;

        // // Update wallet balance
        // $update_query = "UPDATE user_wallet SET net_wallet='$new_net_wallet', wallet_balance='$new_balance' WHERE user_id ='$user_id'";
        // mysqli_query($con, $update_query);

        // Insert deposit record
        $insert_query = "INSERT INTO deposit (user_id, amount, utr_number, tstatus, status) VALUES ('$user_id', '$amount', '$utr_number', 'Recharge', 'Processing')";

        if (mysqli_query($con, $insert_query)) {
             echo '             
                 <div class="alert-box">
                     <div class="success-circle active">
                         <div class="checkmark"></div>
                     </div>
                     <p class="new_record">Successfully Submitted Deposited Request .</p>
                     <p>User Id : ' . $user_id . '</p>
                     <p>USDTS : ' . $damount . '</p>
                     <p>Trust Wallet Address : ' . $utr_number . '</p>
                    
                     <button onclick="window.location.href = \'wallet.php\';">OK</button>
                 </div>';

            
            // echo "<script>alert('Deposit Successfully Submitted');window.location.href = 'wallet.php';</script>";
        } else {
            echo "Deposit Failed: " . mysqli_error($con);
        }
        }
    } else {
        echo "<script>alert('Invalid Transaction Password!');window.location.href = 'wallet.php';</script>";
    }
}


// WITHDROW LOGICS
if (isset($_POST['withdrow'])) {

    // Collecting form data
    $user_id = $_POST['wuser_id'];
    $wallet_balance = $_POST['wallet_total'];
    $amount = $_POST['wamount'];
    $net_amount = $_POST['net_amount'];
    $transaction_pin = $_POST['wtpassword'];

    // echo "<h2>Form Data Submitted:</h2>";
    // echo "User  ID: " . $user_id . "<br>";
    // echo "Amount: " . $amount . "<br>";
    // echo "NET Amount: " . $net_amount . "<br>";
    // echo "Transaction Pin: " . $transaction_pin . "<br>";


    // Check if the transaction password is correct
    $query = "SELECT * FROM user_data WHERE tpassword = '$transaction_pin' AND user_id = '$user_id'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {

        if ($wallet_balance <= $amount) {
            echo "<script>alert('Insufficient Balance!');window.location.href = 'wallet.php';</script>";
            exit;
        }

        $query = "SELECT * FROM user_data WHERE user_id = '$user_id'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);

        $trust_id = $row["trust_id"];
        $trust_qr = $row["trust_qr"];

        $wallet = $trust_id . $trust_qr;

        if ($wallet == '') {
            echo "<script>alert('Wallet Address Not Found! Please Add Wallet Address');window.location.href = 'account_details.php';</script>";
            exit;
        }


        $query = "SELECT * FROM admin_charges WHERE id = 'admin'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);

        $Min_withdrows = $row["Min_withdrows"];
        $max_withdrows = $row["max_withdrows"];
        $min_referrals = $row["max_referrals"];

        $query = "SELECT count(*) as total_referrals FROM user_data WHERE referalid = '$user_id'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);

        $total_referrals = $row["total_referrals"];

        if ($total_referrals <= $min_referrals) {

            if ($amount >= $Min_withdrows && $amount <= $max_withdrows) {
                //Fetch wallet balance
                $query = "SELECT * FROM user_wallet WHERE user_id ='$user_id'";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_assoc($result);

                $new_balance = $row['wallet_balance'] - $amount;
                $new_wallet_withdraw = $row['wallet_withdraw'] + $amount;

                // Update wallet balance
                $update_query = "UPDATE user_wallet SET wallet_withdraw='$new_wallet_withdraw', wallet_balance='$new_balance' WHERE user_id ='$user_id'";
                mysqli_query($con, $update_query);

                $query = "SELECT admin_charges, tds, others FROM admin_charges WHERE id = 'admin'";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_assoc($result);

                $admin_charges = $row['admin_charges'];
                $tds = $row['tds'];
                $others = $row['others'];

                // Calculate deductions
                $admin_deduction = $amount * ($admin_charges / 100);
                $tds_deduction = $amount * ($tds / 100);
                $others_deduction = $amount * ($others / 100);

                // Insert withdraws record
                $insert_query = "INSERT INTO withdraws (user_id, w_amount, tds, admin_charges, other, wstatus, status, user_enter_amount, w_balance) VALUES ('$user_id', '$net_amount', '$tds_deduction','$admin_deduction', '$others_deduction', 'Self Withdraw', 'Processing', '$amount', '$new_balance')";

                if (mysqli_query($con, $insert_query)) {
                    
                     echo '             
                 <div class="alert-box">
                     <div class="success-circle active">
                         <div class="checkmark"></div>
                     </div>
                     <p class="new_record">Successfully Submitted withdraw Request.</p>
                     <p>User Id : ' . $user_id . '</p>
                     <p>USDTS : ' . $net_amount . '</p>
                    
                    
                     <button onclick="window.location.href = \'wallet.php\';">OK</button>
                 </div>';
                    // echo "<script>alert('Withdrow Successful');window.location.href = 'wallet.php';</script>";
                    // echo "Withdrow Successful";
                } else {
                    echo "Withdrow Failed: " . mysqli_error($con);
                }
            } else {
                echo "<script>alert('Amount should be between => $Min_withdrows and <=$max_withdrows');window.location.href = 'wallet.php';</script>";
            }
        } else {
            echo "<script>alert('You have not reached the minimum referrals');window.location.href = 'wallet.php';</script>";
        }
    } else {
        echo "<script>alert('Incorrect Transaction Password');window.location.href = 'wallet.php';</script>";
    }
}


//Wallet To Wallet
if (isset($_POST['transfer'])) {
    $user_id = $_POST['wwuser_id'];
    $amount_1 = $_POST['wwamount'];
    $to_user_id = $_POST['wwto_user_id'];
    $transaction_pin = $_POST['tpassword'];
    $wallet_balance = $_POST['wwwallet_total'];


    // echo "<h2>Form Data Submitted:</h2>";
    // echo "User  ID: " . $user_id . "<br>";
    // echo "Amount: " . $amount_1 . "<br>";
    // echo "NET Amount: " . $to_user_id . "<br>";
    // echo "Transaction Pin: " . $transaction_pin . "<br>";


    $amount_1 = floatval($amount_1);
    $ftc_1 = floatval($ftc_1);
    $ftc = $amount_1 * ($ftc_1 / 100);
    $amount = $amount_1 - $ftc;

    $query = "SELECT * FROM user_wallet WHERE user_id ='$to_user_id' ";
    $result = mysqli_query($con, $query);
    $user = mysqli_fetch_assoc($result);

    // Store data in the session
    $to_user_wallet_balance = $user['wallet_balance'];
    $to_user_net_wallet = $user['net_wallet'];

    $to_user_new_wallet_balance = $to_user_wallet_balance + $amount;
    $to_user_new_net_wallet = $to_user_net_wallet + $amount;

    $query = "SELECT * FROM user_wallet WHERE user_id ='$user_id' ";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    // Store data in the session
    $wallet_balance = $row['wallet_balance'];
    $wallet_withdraw = $row['wallet_withdraw'];

    $user_new_wallet_balance = $wallet_balance -  $amount_1;
    $user_new_wallet_withdraw = $wallet_withdraw + $amount_1;


    // Check if the transaction password is correct
    $query = "SELECT * FROM user_data WHERE tpassword = '$transaction_pin' AND user_id = '$user_id'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {




    if ($wallet_balance <= $amount_1) {
        echo "<script>alert('Insufficient Balance!');window.location.href = 'wallet.php';</script>";
        exit;
    }


        $query = "SELECT * FROM admin_charges WHERE id = 'admin'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);

        $Min_withdrows = $row["Min_withdrows"];
        $max_withdrows = $row["max_withdrows"];
        $min_referrals = $row["max_referrals"];

        $query = "SELECT count(*) as total_referrals FROM user_data WHERE referalid = '$user_id'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);

        $total_referrals = $row["total_referrals"];

        if ($total_referrals <= $min_referrals) {
            if ($amount_1 >= $Min_withdrows && $amount_1 <= $max_withdrows) {
                $query1 = "UPDATE user_wallet SET wallet_balance = '$user_new_wallet_balance', wallet_withdraw = '$user_new_wallet_withdraw' WHERE user_id = '$user_id'";
                $result1 = mysqli_query($con, $query1);

                // Prepare the second update query for the recipient's wallet
                $query2 = "UPDATE user_wallet SET wallet_balance = '$to_user_new_wallet_balance', net_wallet = '$to_user_new_net_wallet' WHERE user_id = '$to_user_id'";
                $result2 = mysqli_query($con, $query2);



                // Insert withdraws record
                $insert_query = "INSERT INTO withdraws (user_id, w_amount, fund_transfer_charge, wstatus, status, w_balance, wto_user_id) VALUES ('$user_id', '$amount_1', '$ftc','Send', 'Approved', '$user_new_wallet_balance', '$to_user_id')";
                if (mysqli_query($con, $insert_query)) {
                    // echo "Withdrow Successful";
                    echo "<script>alert('Your Transfer Successfully');window.location.href = 'wallet.php';</script>";
                } else {
                    echo "Withdrow Failed: " . mysqli_error($con);
                }


                // Insert deposit record
                $insert_query = "INSERT INTO deposit (user_id, amount, from_user_id, tstatus, status, t_balance) VALUES ('$to_user_id', '$amount', '$user_id', 'Received', 'Approved', '$to_user_new_wallet_balance')";
                if (mysqli_query($con, $insert_query)) {
                     echo '             
                 <div class="alert-box">
                     <div class="success-circle active">
                         <div class="checkmark"></div>
                     </div>
                     <p class="new_record">User Successfully Transfer.</p>
                     <p>User Id : ' . $user_id . '</p>
                     <p>To User Id : ' . $to_user_id . ' </p>
                     <p>USDTS : ' . $amount_1 . '</p>
                     t
                    
                     <button onclick="window.location.href = \'wallet.php\';">OK</button>
                 </div>';
                } else {
                    echo "Deposit Failed: " . mysqli_error($con);
                }
            } else {
                echo "<script>alert('Amount should be between => $Min_withdrows and <=$max_withdrows');window.location.href = 'wallet.php';</script>";
            }
        } else {
            echo "<script>alert('You have not reached the minimum referrals');window.location.href = 'wallet.php';</script>";
        }
    
    } else {
        echo "<script>alert('Incorrect Transaction Password');window.location.href = 'wallet.php';</script>";
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
            width: 50px;
            height: 50px;
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
    .wall_reprt {
        font-weight: bold;
        width: 100%;
        height: 5%;
        background-color: rgb(19, 29, 41);
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        color: white;
        padding: 10px 30px 0 30px;
    }

    .wall_currncy {
        border: solid 2px white;
        border-radius: 5px;
        padding: 5px 10px;
        background-color: white;
        color: darkturquoise;
        font-weight: bold;
        font-size: 20px;
        margin: 0 5px 0 0;

    }

    .wall_table {
        color: white;
    }

    tr {
        border: solid 1px lightblue;

    }

    tr:hover {
        border: solid 1px lightblue;
        background-color: lightseagreen;
    }

    td {
        padding: 13px 25px;
    }

    @media only screen and (min-width: 768px) {
        td {
            padding: 13px 120px;
        }
    }

    .wall_btn21 {
        border: solid 2px darkcyan;
        background-color: rgb(19, 29, 41);
        color: white;
        width: 85px;
        height: 50px;
        background-color: transparent;
        border-radius: 10px;
    }

    .wall_btn22 {
        border: solid 2px darkcyan;
        background-color: rgb(19, 29, 41);
        color: white;
        width: 85px;
        height: 50px;
        background-color: transparent;
        border-radius: 10px;
    }

    .wall_btn23 {
        border: solid 2px darkcyan;
        background-color: rgb(19, 29, 41);
        color: white;
        width: 85px;
        height: 50px;
        background-color: transparent;
        border-radius: 10px;
    }

    .wall_btn24 {
        border: solid 2px darkcyan;
        background-color: rgb(19, 29, 41);
        color: white;
        width: 85px;
        height: 50px;
        background-color: transparent;
        border-radius: 10px;
    }

    @media only screen and (min-width: 768px) {
        .wall_btn21 {
            border: solid 2px darkcyan;
            background-color: rgb(19, 29, 41);
            color: white;
            width: 195px;
            height: 40px;
            background-color: transparent;
            border-radius: 30px;
            margin-left: 20px;
        }

        .wall_btn22 {
            border: solid 2px darkcyan;
            background-color: rgb(19, 29, 41);
            color: white;
            width: 195px;
            height: 40px;
            background-color: transparent;
            border-radius: 30px;
            margin-left: 20px;
        }

        .wall_btn23 {
            border: solid 2px darkcyan;
            background-color: rgb(19, 29, 41);
            color: white;
            width: 195px;
            height: 40px;
            background-color: transparent;
            border-radius: 30px;
            margin-left: 20px;
        }

        .wall_btn24 {
            border: solid 2px darkcyan;
            background-color: rgb(19, 29, 41);
            color: white;
            width: 195px;
            height: 40px;
            background-color: transparent;
            border-radius: 30px;
            margin-left: 20px;
        }
    }

    .button_1 {
        width: 25%;
        height: 50px;
        position: relative;
        top: 20px;

        border: solid 2px darkcyan;
        background-color: darkcyan;
        color: white;
    }

    .button_2 {
        width: 25%;
        height: 50px;
        position: relative;
        top: 20px;

        border: solid 2px darkcyan;
        background-color: transparent;
        color: white;
    }

    .button_3 {
        width: 25%;
        height: 50px;
        position: relative;
        top: 20px;
        left: -7px;
        border: solid 2px darkcyan;
        background-color: transparent;
        color: white;
    }

    .h1_line {
        text-align: center;
    }

    .button-check {
        width: 30%;
        height: 30%;
        border: solid 2px lightseagreen;
        border-radius: 30px;
        color: white;
        background-color: transparent;
        margin-left: 30px;
        margin-right: 20px;
    }

    .button-check:hover {
        width: 30%;
        height: 30%;
        border: solid 2px lightseagreen;
        border-radius: 30px;
        color: white;
        background-color: lightseagreen;
    }

    .check-avatar {
        width: 300px;
        height: 300px;
    }

    .amount {
        font-size: 10px;
        padding: 5px;
    }

    .money-btn {
        font-size: 10px;

    }

    .btn-outline-primary.money-btn {
        color: #20c997;
        /* this is the default primary color in Bootstrap */
        border-color: #20c997;
    }

    .btn-outline-primary.money-btn:hover {
        color: #fff;
        background-color: lightseagreen;
        border-color: lightseagreen;
    }

    .btn-check:checked+.btn-outline-primary.money-btn {
        color: #fff;
        background-color: lightseagreen;
        border-color: lightseagreen;
    }

    .button-check {
        width: 30%;
        height: 30%;
        border: solid 2px lightseagreen;
        border-radius: 30px;
        color: white;
        background-color: transparent;
        margin-left: 30px;
        margin-right: 20px;
    }

    .button-check:hover {
        width: 30%;
        height: 30%;
        border: solid 2px lightseagreen;
        border-radius: 30px;
        color: white;
        background-color: lightseagreen;
    }

    @media only screen and (max-width: 768px) {
        .check-avatar {
            width: 280px;
            height: 280px;
        }

    }

    .button-check {
        width: 30%;
        height: 30%;
        border: solid 2px lightseagreen;
        border-radius: 30px;
        color: white;
        background-color: transparent;
        margin-left: 30px;
        margin-right: 20px;

    }

    .button-check:hover {
        width: 30%;
        height: 30%;
        border: solid 2px lightseagreen;
        border-radius: 30px;
        color: white;
        background-color: lightseagreen;
    }

    .h1_line {
        text-align: center;
    }

    #signInForm2 {
        display: none;
    }

    #signUpForm2 {
        display: none;
    }

    #signForm2 {
        display: none;
    }

    #signForm21 {
        display: none;
        /* Hide these forms */
    }

    #signUpLink2 {
        background-color: transparent;
    }

    #signInLink2 {
        background-color: transparent;
    }

    #signLink2 {
        background-color: transparent;
    }

    #signLink21 {
        background-color: transparent;
        /* Set background color to transparent */
    }
     .telegram-icon {
            width: 50px; /* Adjust size as needed */
            height: 50px; /* Adjust size as needed */
        }
        
</style>

<section>
    <div style="background-color: black; padding:20px 0; width:100%">
        <div>
            <center>
                <div class="wall_btns">
                    <input type="button" class="button_1" id="signInLink" value="Spot Wallet">
                    <input type="button" class="button_2" id="signUpLink" value="Withdraw">
                    <input type="button" class="button_3" id="signLink" value="Deposit">

                </div>

            </center>
            <div id="signInForm" style="display: block;">
                <!-- Your sign in form here -->
                <center>
                    <div class="wall_balance">
                        <div class="wall_titels">
                            <p>Total Balance</p>
                            <span class="eye" onclick="togglePassword123()">
                                <i class="fa fa-eye-slash" id="eye-icon1"></i>
                            </span>
                        </div>
                        <div>
                            <input type="password" id="password1" class="wall_amount" value="<?php echo $wallet_total; ?> USDT " readonly>
                            <script>
                                function togglePassword123() {
                                    var passwordInput = document.getElementById("password1");
                                    var eyeIcon = document.getElementById("eye-icon1");

                                    if (passwordInput.type === "password") {
                                        passwordInput.type = "text";
                                        eyeIcon.classList.remove("fa-eye-slash");
                                        eyeIcon.classList.add("fa-eye");
                                    } else {
                                        passwordInput.type = "password";
                                        eyeIcon.classList.remove("fa-eye");
                                        eyeIcon.classList.add("fa-eye-slash");
                                    }
                                }
                            </script>
                        </div>
                    </div>
                </center>
            </div>
            <div id="signUpForm" style="display: none;">
                <!-- Your sign up form here -->
                <center>
                    <div class="wall_balance">
                        <div class="wall_titels">
                            <p>Total Withdraws</p>
                            <span class="eye" onclick="togglePassword()">
                                <i class="fa fa-eye-slash" id="eye-icon"></i>
                            </span>
                        </div>
                        <div>
                            <input type="password" id="password" class="wall_amount" value="<?php echo $wallet_withdraw; ?> USDT " readonly>
                            <script>
                                function togglePassword() {
                                    var passwordInput = document.getElementById("password");
                                    var eyeIcon = document.getElementById("eye-icon");

                                    if (passwordInput.type === "password") {
                                        passwordInput.type = "text";
                                        eyeIcon.classList.remove("fa-eye-slash");
                                        eyeIcon.classList.add("fa-eye");
                                    } else {
                                        passwordInput.type = "password";
                                        eyeIcon.classList.remove("fa-eye");
                                        eyeIcon.classList.add("fa-eye-slash");
                                    }
                                }
                            </script>
                        </div>
                    </div>
                </center>

            </div>
            <div id="signForm" style="display: none;">
                <!-- Your sign up form here -->
                <center>
                    <div class="wall_balance">
                        <div class="wall_titels">
                            <p>Total Deposit</p>
                            <span class="eye" onclick="togglePassword1()">
                                <i class="fa fa-eye-slash" id="eye-icon2"></i>
                            </span>
                        </div>
                        <div>
                            <input type="password" id="password2" class="wall_amount" value="<?php echo $total_deposit; ?> USDT " readonly>
                        </div>
                        <script>
                            function togglePassword1() {
                                var passwordInput = document.getElementById("password2");
                                var eyeIcon = document.getElementById("eye-icon2");

                                if (passwordInput.type === "password") {
                                    passwordInput.type = "text";
                                    eyeIcon.classList.remove("fa-eye-slash");
                                    eyeIcon.classList.add("fa-eye");
                                } else {
                                    passwordInput.type = "password";
                                    eyeIcon.classList.remove("fa-eye");
                                    eyeIcon.classList.add("fa-eye-slash");
                                }
                            }
                        </script>
                    </div>
                </center>

            </div><br>
        </div>
        <script>
            const signInForm = document.getElementById('signInForm');
            const signUpForm = document.getElementById('signUpForm');
            const signUpLink = document.getElementById('signUpLink');
            const signInLink = document.getElementById('signInLink');
            const signForm = document.getElementById('signForm');
            const signLink = document.getElementById('signLink');

            signUpLink.addEventListener('click', function(event) {
                event.preventDefault();
                signInForm.style.display = 'none';
                signUpForm.style.display = 'block';
                signForm.style.display = 'none';
                signInLink.style.backgroundColor = 'transparent';
                signLink.style.backgroundColor = 'transparent';
                signUpLink.style.backgroundColor = 'darkcyan';
            });

            signInLink.addEventListener('click', function(event) {
                event.preventDefault();
                signInForm.style.display = 'block';
                signForm.style.display = 'none';
                signUpForm.style.display = 'none';
                signUpLink.style.backgroundColor = 'transparent';
                signLink.style.backgroundColor = 'transparent';
                signInLink.style.backgroundColor = 'darkcyan';
            });

            signLink.addEventListener('click', function(event) {
                event.preventDefault();
                signInForm.style.display = 'none';
                signUpForm.style.display = 'none';
                signForm.style.display = 'block';
                signUpLink.style.backgroundColor = 'transparent';
                signInLink.style.backgroundColor = 'transparent';
                signLink.style.backgroundColor = 'darkcyan';
            });
        </script>
    </div>
</section>

<section>
    <center>
        <div>
            <div>
                <input type="button" class="wall_btn21" id="signUpLink2" value="Deposit">

                <input type="button" class="wall_btn22" id="signInLink2" value="Withdraw"> <!-- Corrected ID -->

                <input type="button" class="wall_btn23" id="signLink2" value="Transfer">

                <input type="button" class="wall_btn24" id="signLink21" value="Top Up">

            </div><br><br>
             <script>
                document.getElementById('signUpLink2').addEventListener('click', function() {
                    hideAllForms();
                    document.getElementById('signUpForm2').style.display = 'block'; // Show Deposit Form
                    hideAllLinks();
                    document.getElementById('signUpLink2').style.backgroundColor = 'darkcyan';
                });

                document.getElementById('signInLink2').addEventListener('click', function() {
                    hideAllForms();
                    document.getElementById('signInForm2').style.display = 'block'; // Show Withdraw Form
                    hideAllLinks();
                    document.getElementById('signInLink2').style.backgroundColor = 'darkcyan';
                });

                document.getElementById('signLink2').addEventListener('click', function() {
                    hideAllForms();
                    document.getElementById('signForm2').style.display = 'block'; // Show Transfer Form
                    hideAllLinks();
                    document.getElementById('signLink2').style.backgroundColor = 'darkcyan';
                });

                document.getElementById('signLink21').addEventListener('click', function() {
                    hideAllForms();
                    document.getElementById('signForm21').style.display = 'block'; // Show Top Up Form
                    hideAllLinks();
                    document.getElementById('signLink21').style.backgroundColor = 'darkcyan';
                });


                function hideAllForms() {
                    document.getElementById('signForm2').style.display = 'none';
                    document.getElementById('signUpForm2').style.display = 'none';
                    document.getElementById('signInForm2').style.display = 'none';
                    document.getElementById('signForm21').style.display = 'none';
                }

                function hideAllLinks() {
                    document.getElementById('signUpLink2').style.backgroundColor = 'transparent';
                    document.getElementById('signInLink2').style.backgroundColor = 'transparent';
                    document.getElementById('signLink2').style.backgroundColor = 'transparent';
                    document.getElementById('signLink21').style.backgroundColor = 'transparent';
                }
            </script>

            <div>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div id="signForm2" style="display: none;">

                        <center>

                            <div>
                                <center>
                                    <h1 class="prof_label h1_line">Wallet To Wallet</h1>
                                </center>
                            </div><br><br>

                            <div class="page-container">


                                <!--<div class="avatar-img">-->
                                <!--    <img class="check-avatar" src="<?php echo $image; ?>" style="align-items: center;">-->
                                <!--</div>-->
                                <div class="check-details">
                                    <div class="check-items">
                                        <label for="name" class="prof_label">User ID</label><BR>
                                        <input type="text" class="prof_text" name="wwuser_id" value="<?php echo $user_id; ?>">

                                    </div>
                                    <div class="check-items">

                                        <label for="name" class="prof_label">Wallet Available USDT</label><BR>
                                        <input type="text" class="prof_text" name="wwwallet_total" value="<?php echo  $wallet_total; ?>" readonly>

                                    </div>

                                    <div class="check-items">
                                        <label for="name" class="prof_label">To User ID</label><BR>
                                        <input type="text" class="prof_text" name="wwto_user_id" placeholder="Enter To User ID" id="active_id" onblur="fetchActiveName(this.value)">

                                    </div>
                                    <div class="check-items">
                                        <label for="name" class="prof_label">To User Name</label><BR>
                                        <input type="text" name="wwactive_id_name" id="active_id_name" class="prof_text" placeholder="Enter To User Name" readonly />
                                    </div>
                                    <script>
                                        function fetchActiveName(active_id) {
                                            var xhr = new XMLHttpRequest();
                                            xhr.open('GET', 'fetch_referral_name.php?id=' + active_id, true);
                                            xhr.onload = function() {
                                                if (xhr.status === 200) {
                                                    document.getElementById('active_id_name').value = xhr.responseText;
                                                }
                                            };
                                            xhr.send();
                                        }
                                    </script>
                                    <div class="check-items">
                                        <label for="name" class="prof_label">Amount</label><BR>
                                        <input type="text" class="prof_text" name="wwamount" placeholder="Enter Amount">
                                    </div><br><br>
                                    <div class="button-check-div">
                                        <input type="hidden" name="action" value="transfer">
                                        <button type="button" class=" button-check green" name="withdrow" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            Process
                                        </button>



                                        <!-- Modal -->
                                    </div><br><br><br><br><br>
                                </div>
                            </div>


                        </center>
                    </div>

                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Transaction Security</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <label for="name" class="prof_label">Transaction Pin</label><BR>
                                    <input type="text" class="prof_text" name="tpassword" placeholder="Enter Transaction Pin">


                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-success" name="transfer" value="submit">


                                </div>

                            </div>
                        </div>

                    </div>

                </form>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div id="signUpForm2" style="display: none;">

                        <center>
                            <h1 style="color: white;">Wallet Deposit</h1>
                            <div class="avatar-img">
                                <img class="check-avatar" src="./images/WhatsApp Image 2024-11-28 at 17.06.00_99a38744.jpg">
                            </div>
                            
                            <div class="check-details">
                                <!--<p class="copyable">0xfa1Ac263e2a5D9599dB714eBaebCeBe7FBd7a71a</p>-->
                                <div class="check-items">
                                    <label for="name" class="prof_label">USER ID</label><BR>
                                    <input type="text" class="prof_text" name="duser_id" value="<?php echo $user_id; ?>" readonly>
                                </div>
                                <div class="check-items">
                                    <label for="name" class="prof_label">USDT&nbsp;:</label><BR>
                                    <input type="text" class="prof_text" id="amountInput" name="damount" placeholder="Enter USDTS" required>
                                </div>

                                <br>
                                <div class="check-items">
                                    <label for="name" class="prof_label">Add Your Trust Wallet Address</label><BR>
                                    <input type="text" class="prof_text" name="dtrutr" placeholder="Enter YourTrust Wallet Address" required>
                                </div> <br>
                                <a href="https://t.me/+rMoK5pbNpAw0YjU1" target="_blank">
        <img src="https://cdn.pixabay.com/photo/2020/10/17/13/21/telegram-5662082_1280.png" alt="Telegram Group" class="telegram-icon">
    </a><p style="color: white;"> Your Payment ScreenShot And Submit Request ScreenShot Send To Our Group</p>
                                <div class="button-check-div">
                                    <!-- Button trigger modal -->

                                    <button type="button" class="button-check green" data-bs-toggle="modal" data-bs-target="#exampleModal0">
                                        Process
                                    </button>

                                    <!-- Modal -->
                                </div><br><br><br><br>
                            </div>


                        </center>

                    </div>


                    <div class="modal fade" id="exampleModal0" tabindex="-1" aria-labelledby="exampleModalLabel0" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel0">Transaction Security</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>



                                <div class="modal-body">
                                    <label for="name" class="prof_label">Transaction Pin</label><BR>
                                    <input type="text" class="prof_text" name="tpassword" placeholder="Enter Transaction Pin">


                                </div>
                                <div class="modal-footer">

                                    <input type="submit" class="btn btn-success" name="deposit" value="submit">


                                </div>

                            </div>
                        </div>

                    </div>

                </form>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="signInForm2" style="display: none;">
                     <div id="withdrawalForm" style="display: none;">


                        <center>
                            <div class="page-container">

                                <div>
                                    <center>
                                        <h1 class="prof_label h1_line">Withdrows</h1>
                                    </center>
                                </div><br>
                                <div class="check-details"><br><br>
                                    <label for="name" class="prof_label">USER ID</label><BR>
                                    <input type="text" class="prof_text" name="wuser_id" value="<?php echo $user_id; ?>" readonly>
                                </div>
                                <div class="check-items">

                                    <label for="name" class="prof_label">Wallet Total USDT</label><BR>
                                    <input type="text" class="prof_text" name="wallet_total" value="<?php echo  $wallet_total; ?>" readonly>

                                </div>

                                <div class="check-items">
                                    <label for="name" class="prof_label">USDT</label><BR>
                                    <input type="text" class="prof_text" name="wamount" id="amount" onblur="fetchNetAmount(this.value)" placeholder="Enter USDT">

                                </div>
                                <div class="check-items">
                                    <label for="name" class="prof_label">Net USDT</label><BR>
                                    <input type="text" class="prof_text" name="net_amount" id="net_amount" value="USDT" readonly>
                                    <script>
                                        function fetchNetAmount(amount) {
                                            var xhr = new XMLHttpRequest();
                                            xhr.open('GET', 'fetch_net_amount.php?id=' + amount, true);
                                            xhr.onload = function() {
                                                if (xhr.status === 200) {
                                                    document.getElementById('net_amount').value = xhr.responseText;
                                                }
                                            };
                                            xhr.send();
                                        }
                                    </script>
                                </div><br>
                                <div class="button-check-div">

                                    <button type="button" class=" button-check green" name="withdrow" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                                        Process
                                    </button>

                                    
                                </div><br><br><br><br><br>
                            </div>

                        </center>



                        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel1">Transaction Security</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>



                                    <div class="modal-body">
                                        <label for="name" class="prof_label">Transaction Pin</label><BR>
                                        <input type="text" class="prof_text" name="wtpassword" placeholder="Enter Transaction Pin">


                                    </div>
                                    <div class="modal-footer">

                                        <input type="submit" class="btn btn-success" name="withdrow" value="submit">


                                    </div>

                                </div>
                            </div>

                        </div>
                    </div> 
                    <div id="weekendMessage" style="display: none;">
                        <p style="color: red; font-size: 25px;">Withdrows are not available in Saturday and Sunday Because of Company Holiday So Please Try Monday to Friday</p>
                    </div>
                    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the current day (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
        var currentDate = new Date();
        var currentDay = currentDate.getDay();

        // Get the withdrawal form and the message div
        var withdrawalForm = document.getElementById("withdrawalForm");
        var weekendMessage = document.getElementById("weekendMessage");

        // Check if the current day is Saturday (6) or Sunday (0)
        if (currentDay === 0 || currentDay === 6) {
            // Hide the withdrawal form and show the weekend message
            withdrawalForm.style.display = "none";
            weekendMessage.style.display = "block";
        } else {
            // Show the withdrawal form and hide the weekend message
            withdrawalForm.style.display = "block";
            weekendMessage.style.display = "none";
        }
    });
</script>
                </form>

                <form action="topup_code.php" method="post">
                    <div id="signForm21" style="display: none;">

                        <center>
                            <div class="page-container">

                                <div>
                                    <center>
                                        <h1 class="prof_label h1_line">Top Up</h1>
                                    </center>
                                </div><br>



                                <div class="check-items">

                                    <label for="name" class="prof_label">User ID</label><BR>
                                    <input type="text" name="user_id" class="prof_text" value="<?php echo $user_id; ?>" readonly>
                                </div>

                                <div class="check-items">

                                    <label for="name" class="prof_label">Wallet Balance</label><BR>
                                    <input type="text" class="prof_text" name="wallet_balance" value="<?php echo  $wallet_total; ?>" readonly>
                                </div>
                                <div>
                                    <label for="name" class="prof_label">Floor Name</label><BR>
                                </div>
                                <div>
                                    <?php
                                    // Connect to the database
                                    // $con = mysqli_connect("localhost", "trcelioe_success_slp", "success_slp", "trcelioe_success_slp");
                                    $con = mysqli_connect("localhost", "root", "", "success_slp");

                                    // Check connection
                                    if (!$con) {
                                        die("Connection failed: " . mysqli_connect_error());
                                    }

                                    // Query to fetch data from the database
                                    $sql = "SELECT floor_name FROM floor_master WHERE floor_name != '' ORDER BY floor_name ASC";
                                    $result = mysqli_query($con, $sql);
                                    ?>
                                    <select class='prof_text options' name="floor_name" onchange="showPackageDetails(this.value)">
                                        <option class="options" value=''>Select Floor Name</option>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $floor_name = $row['floor_name'];
                                            echo "<option class='options' value='" . htmlspecialchars($floor_name, ENT_QUOTES) . "'>" . htmlspecialchars($floor_name, ENT_QUOTES) . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <script>
                                    function showPackageDetails(str) {
                                        if (!str) {
                                            document.getElementById("flooramount").value = "";
                                            document.getElementById("flooralgibulity").value = "";
                                            document.getElementById("product_id").value = "";
                                            return;
                                        }

                                        const xmlhttp = new XMLHttpRequest();
                                        xmlhttp.onreadystatechange = function() {
                                            if (this.readyState === 3 && this.status === 200) {
                                                const productDetails = JSON.parse(this.responseText);
                                                document.getElementById("flooramount").value = productDetails.flooramount;
                                                document.getElementById("flooralgibulity").value = productDetails.flooralgibulity;
                                                document.getElementById("product_id").value = productDetails.productcode;
                                            }
                                        };
                                        xmlhttp.open("GET", `productdetails.php?q=${str}`, true);
                                        xmlhttp.send();
                                    }
                                </script>

                                </div>

                                <div class="check-items">
                                    <label class="prof_label">Floor Amount</label><br>
                                    <input type="text" class="prof_text" id="flooramount" name="Flooramount" placeholder="Enter Amount" readonly>
                                </div>

                                <div class="check-items">
                                    <label class="prof_label">Floor Validity</label><br>
                                    <input type="text" class="prof_text" id="flooralgibulity" name="Flooralgibulity" placeholder="Enter Floor Validity" readonly>
                                    <input type="hidden" class="prof_text" id="product_id" name="product_id">
                                </div>
                                
                                <div class="check-items">
                                    <label for="name" class="prof_label">Active ID</label><BR>
                                    <input type="text" name="active_id" class="prof_text" placeholder="Enter Active ID" id="active_ids" onblur="fetchUserName(this.value)">
                                </div>
                                <div class="check-items">
                                    <label for="name" class="prof_label">Active ID User Name</label><BR>
                                    <input type="text" name="active_id_name" id="active_id_names" class="prof_text" placeholder="Enter Active ID User Name" readonly />
                                </div><BR><BR>
                                <script>
                                    function fetchUserName(active_ids) {
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('GET', 'fetch_referral_name.php?id=' + active_ids, true);
                                        xhr.onload = function() {
                                            if (xhr.status === 200) {
                                                document.getElementById('active_id_names').value = xhr.responseText;
                                            }
                                        };
                                        xhr.send();
                                    }
                                </script>

                                <div class="button-check-div">

                                    <button type="button" class=" button-check green" name="topup" data-bs-toggle="modal" data-bs-target="#exampleModal8">
                                        Process
                                    </button>

                                    <!-- Modal -->
                                </div><br><br><br><br><br>
                            </div>

                        </center>


                    </div>



                    <div class="modal fade" id="exampleModal8" tabindex="-1" aria-labelledby="exampleModalLabel8" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel8">Transaction Security</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>



                                <div class="modal-body">
                                    <label for="name" class="prof_label">Transaction Pin</label><BR>
                                    <input type="text" class="prof_text" name="ttpassword" placeholder="Enter Transaction Pin">


                                </div>
                                <div class="modal-footer">

                                    <input type="submit" class="btn btn-success" name="topup" value="submit">


                                </div>

                            </div>
                        </div>
                        <!--<p style="color:white;" >SUM TECHNICAL ISSUE PLEASE WAIT SUM TIME</p>-->

                    </div>

                </form>

            </div>

        </div>

    </center><br>




    <br><br><br><br>

</section>
<script>
                                    function showPackageDetails(str) {
                                        if (!str) {
                                            document.getElementById("flooramount").value = "";
                                            document.getElementById("flooralgibulity").value = "";
                                            document.getElementById("product_id").value = "";
                                            return;
                                        }

                                        const xmlhttp = new XMLHttpRequest();
                                        xmlhttp.onreadystatechange = function() {
                                            if (this.readyState === 4 && this.status === 200) {
                                                const productDetails = JSON.parse(this.responseText);
                                                document.getElementById("flooramount").value = productDetails.flooramount;
                                                document.getElementById("flooralgibulity").value = productDetails.flooralgibulity;
                                                document.getElementById("product_id").value = productDetails.productcode;
                                            }
                                        };
                                        xmlhttp.open("GET", `productdetails.php?q=${encodeURIComponent(str)}`, true);
                                        xmlhttp.send();
                                    }
                                </script>