<?php
include('user_header.php');



$query = "SELECT * FROM transaction WHERE userids ='$user_id' ";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);
if ($user > 0) {
    // Store data in the session
    $_SESSION['ewallet_balance'] = $user['ewallet_balance'];
    $_SESSION['ewallet_withdrow'] = $user['ewallet_withdrow'];
    $_SESSION['ewallet'] = $user['ewallet'];
} else {
    $_SESSION['ewallet_balance'] = 0;
    $_SESSION['ewallet_withdrow'] = 0;
    $_SESSION['ewallet'] = 0;
}



$query = mysqli_query($con, "SELECT * FROM admin_charges WHERE id = 'admin'");
$row = mysqli_fetch_array($query);


if ($row) {
    $ftc_1 = $row['fund_transfer_charge'];
}

if (isset($_POST['submit'])) {
    $amount_1 = $_POST['amount'];
    $to_user_id = $_POST['to_user_id'];
    $tpassword = $_POST['tpassword'];

    $status = "accepted";
   
    $with_status = "Send";
    $tran_status = "Resived";
    $amount_1 = floatval($amount_1);
    $ftc_1 = floatval($ftc_1);
    $ftc = $amount_1 * ($ftc_1 / 100);
    $ftc = $amount_1 * ($ftc_1 / 100);
    $amount = $amount_1 - $ftc;

    $query = "SELECT * FROM transaction WHERE userids ='$to_user_id' ";
    $result = mysqli_query($con, $query);
    $user = mysqli_fetch_assoc($result);

    // Store data in the session
    $_SESSION['new_ewallet_balance'] = $user['ewallet_balance'];

    $_SESSION['new_ewallet'] = $user['ewallet'];





    $query = "SELECT * FROM users WHERE userid = '$user_id' AND tpassword = '$tpassword'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {

        $query = "SELECT * FROM admin_charges WHERE id = 'admin'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);

        $Min_withdrows = $row['Min_withdrows'];
        $max_withdrows = $row['max_withdrows'];

        if ($amount_1 >= $Min_withdrows && $amount_1 <= $max_withdrows) { // Check if withdrawal amount is within the range

            $query = "SELECT * FROM transaction WHERE userids = '$user_id'";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                if ($amount <= $_SESSION['ewallet_balance']) {
                    $new_ewallet_balance = $_SESSION['ewallet_balance'] - $amount_1;
                    $new_ewallet_withdrow = $_SESSION['ewallet_withdrow'] + $amount_1;

                    $insertQuery = "INSERT INTO `withdrow_requests`(`userid`, `withdrow_amount`,`status`,`fund_transfer_charge`,`wto_user_id`,`wstatus2` ,`balance`) VALUES  ('$user_id', '$amount_1',  '$status','$ftc', '$to_user_id', '$with_status', '$new_ewallet_balance')";

                    $updateQuery = "UPDATE `transaction` SET `ewallet_withdrow`='$new_ewallet_withdrow',`ewallet_balance`='$new_ewallet_balance' WHERE userids = '$user_id'";

                    if ($con->query($insertQuery) === TRUE &&  $con->query($updateQuery) === TRUE) {
                        echo '<script>alert("User data save successfully!");window.location.href = "wallet_to_wallet.php";</script>';
                    } else {
                        echo "Error: " . $con->error;
                    }


                    // Check if withdrawal request already exists
                    $query = "SELECT * FROM users WHERE userid = '$to_user_id'";
                    $result = mysqli_query($con, $query);

                    if (mysqli_num_rows($result) > 0) {

                        $query = "SELECT * FROM transaction WHERE userids = '$to_user_id'";
                        $result = mysqli_query($con, $query);

                        if (mysqli_num_rows($result) > 0) {

                            
                            // Truncate the decimal value to an integer
                            
                            $new_ewallet = $_SESSION['new_ewallet'] + $amount;
                            $new_ewallet_balance = $_SESSION['new_ewallet_balance'] + $amount;

                            $insertQuery = "INSERT INTO `transaction_requst`(`user_id`, `camount`,`status`,`to_user_id`,`status2` ,`cbalance`) VALUES  ('$to_user_id', '$amount',  '$status', '$user_id', '$tran_status', '$new_ewallet_balance')";
                            $updateQuery = "UPDATE `transaction` SET `ewallet`='$new_ewallet',`ewallet_balance`='$new_ewallet_balance' WHERE userids = '$to_user_id' ";

                            if ($con->query($insertQuery) === TRUE && $con->query($updateQuery) === TRUE) {
                                echo '<script>alert("User data save successfully!");window.location.href = "wallet_to_wallet.php";</script>';
                            } else {
                                echo "Error: " . $con->error;
                            }
                        } else {
                            $value = $amount - ($amount * ($ftc / 100));
                            // Truncate the decimal value to an integer
                            $new_ewallet_balance = (int) $value;



                            $query = "INSERT INTO `transaction`(`userids`, `ewallet`, `ewallet_balance`) VALUES  ('$to_user_id','$new_ewallet_balance','$new_ewallet_balance')";
                            if ($con->query($query) === TRUE) {
                                echo '<script>alert("User data save successfully!");window.location.href = "wallet_to_wallet.php";</script>';
                            } else {
                                echo "Error: " . $con->error;
                            }
                        }
                    }
                } else {
                    echo '<script>alert("You have Insufficient Balance");window.location.href = "wallet_to_wallet.php";</script>';
                }
            } else {
                echo '<script>alert("User Not Exit");window.location.href = "wellat_to_wallet.php";</script>';
            }
        } else {
            // echo "$Min_withdrows,$max_withdrows";
            echo '<script>alert("Minimum(' . $Min_withdrows . ') and Maximum(' . $max_withdrows . ')");window.location.href = "wallet_to_wallet.php";</script>';
        }
    } else {
        echo '<script>alert("Transaction Pin is incorrect.");window.location.href = "wellat_to_wallet.php";</script>';
    }
}
?>
<section>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div>
            <center>
                <h1 class="w-recharge-h1">Wallet To Wallet</h1>
            </center>
        </div>

        <div class="page-container">


            <!--<div class="avatar-img">-->
            <!--    <img class="check-avatar" src="<?php echo $image; ?>" style="align-items: center;">-->
            <!--</div>-->
            <div class="check-details">
                <div class="check-items">
                    <h2 class="head-lines">User ID</h2>
                    <div class="user-id">
                        <p class="user-id-no" name="user_id"><?php echo $user_id; ?></p>
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Wallet Available Balence</h2>
                    <div class="user-id">
                        <p class="user-id-no"><?php echo $_SESSION['ewallet_balance']; ?></p>
                    </div>
                </div>

                <div class="check-items">
                    <label for="name" class="active-id">To User ID</label><BR>
                    <input type="text" class="txt-user-id" name="to_user_id" placeholder="Enter To User ID" id="active_id" onblur="fetchActiveName(this.value)">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">To User Name</label><BR>
                    <input type="text" name="active_id_name" id="active_id_name" class="txt-user-id" placeholder="Enter To User Name" readonly />
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Amount</label><BR>
                    <input type="text" class="txt-user-id" name="amount" placeholder="Enter Amount">
                </div>
                <div class="button-check-div">
                    <a href="./graph_up_arrow.php"><button type="button" class="button-check red">BACK</button></a>
                    <button type="button" class=" button-check green" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Pay Now
                    </button>


                    <!-- Modal -->
                </div><br><br><br><br><br>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Transaction Mathed</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <label for="name" class="active-id">Transaction Pin</label><BR>
                        <input type="text" class="txt-user-id" name="tpassword" placeholder="Enter Transaction Pin">

                    </div>
                    <div class="modal-footer">

                        <input type="submit" class="btn btn-success" name="submit" value="submit">


                    </div>
                </div>
            </div>

        </div>
    </form>
</section>
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