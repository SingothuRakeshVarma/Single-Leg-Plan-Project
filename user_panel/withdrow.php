<?php
include('user_header.php');
include('../connect.php');

$query = "SELECT * FROM transaction WHERE userids ='$user_id' ";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

// Store data in the session

if ($user > 0) {
    $_SESSION['ewallet_withdrow'] = $user['ewallet_withdrow'];
    $_SESSION['ewallet_balance'] = $user['ewallet_balance'];
    $_SESSION['cashback_amount'] = $user['cashback_amount'];
    $total_balance = $_SESSION['ewallet_balance'] + $_SESSION['cashback_amount'];
} else {
    $_SESSION['ewallet_withdrow'] = 0;
    $_SESSION['ewallet_balance'] = 0;
    $_SESSION['cashback_amount'] = 0;
    $total_balance = 0;
}
$user_id = $_SESSION['userid'];
$_SESSION['images'];



if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $w_avil_balance = $_POST['wavil_balance'];
    $tpassword = $_POST['tpassword'];
    $amount = $_POST['amount'];
    $net_amount = $_POST['net_amount'];

    $date =  date("Y-m-d");
    $today = date('w'); // 'w' returns the day of the week (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
    $status = "processing";
    $status2 = "Self Withdrow";


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

    // Verify Transaction Pin
    $query = "SELECT * FROM users WHERE userid ='$user_id' AND tpassword = '$tpassword'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {



        if ($today == 1) {
            $query = "SELECT * FROM admin_charges WHERE id = 'admin'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);

            $Min_withdrows = $row['Min_withdrows'];
            $max_withdrows = $row['max_withdrows'];

            if ($amount >= $Min_withdrows && $amount <= $max_withdrows) { // Check if withdrawal amount is within the range
                if ($w_avil_balance >= $amount) {

                    // Check if withdrawal request already exists
                    $query = "SELECT * FROM withdrow_requests WHERE userid = '$user_id' AND status = 'processing'";
                    $row = mysqli_query($con, $query);

                    if (mysqli_num_rows($row) == 0) {
                        $query = "SELECT * FROM users WHERE userid ='$user_id' AND account_number != '' AND ifsc_code != ''";
                        $result = mysqli_query($con, $query);
                        if (mysqli_num_rows($result) > 0) {

                            // Update transaction table
                            $query = mysqli_query($con, "SELECT * FROM transaction WHERE userids = '$user_id'");
                            $row = mysqli_fetch_array($query);

                            if ($row) {
                                $ewallet_balance_amount = $row['ewallet_balance'];
                                $ewallet_withdrow_amount = $row['ewallet_withdrow'];
                                $ewallet_balance_new_amount = $ewallet_balance_amount - $amount;
                                $ewallet_withdrow_new_amount = $ewallet_withdrow_amount + $amount;

                                $query = "UPDATE transaction SET ewallet_balance = '$ewallet_balance_new_amount', ewallet_withdrow = '$ewallet_withdrow_new_amount' WHERE userids = '$user_id'";
                                if (mysqli_query($con, $query)) {
                                    // Insert new withdrawal request
                                    $query = "INSERT INTO `withdrow_requests`(`userid`, `withdrow_amount`, `tds`, `admin_charges`, `other`, `date`,  `status`,  `wstatus2`, `net_amount`, `balance`) VALUES ('$user_id','$net_amount','$tds_deduction','$admin_deduction','$others_deduction','$date','$status','$status2', '$amount', '$ewallet_balance_new_amount')";
                                    if ($con->query($query) === TRUE) {
                                        echo '<script>alert("User data save successfully!");window.location.href = "withdrow.php";</script>';
                                    } else {
                                        echo "Error: " . $con->error;
                                    }
                                }
                            }
                        } else {
                            echo '<script>alert("Fiest You Will Add Your Account Detailes");window.location.href = "account_detailes.php";</script>';
                        }
                    } else {
                        echo '<script>alert("You have already made a withdrawal request");window.location.href = "withdrow.php";</script>';
                    }
                } else {
                    echo '<script>alert("Insuffcient Funds");window.location.href = "withdrow.php";</script>';
                }
            } else {
                // echo "$Min_withdrows,$max_withdrows";
                echo '<script>alert("Minimum(' . $Min_withdrows . ') and Maximum(' . $max_withdrows . ')");window.location.href = "withdrow.php";</script>';
            }
        } else {
            echo '<script>alert("Withdraws Only Mondays.");window.location.href = "withdrow.php";</script>';
        }
    } else {
        echo '<script>alert("Transaction Pin is incorrect.");window.location.href = "withdrow.php";</script>';
    }
}
?>

<section>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="page-container">



            <div class="check-details">
                <div class="check-items">
                    <h2 class="head-lines">User ID</h2>
                    <div>
                        <input type="text" class="txt-user-id" name="user_id" value="<?php echo $user_id; ?>" readonly>
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Wallet Total Balence</h2>
                    <div>
                        <input type="text" class="txt-user-id" value="<?php echo $total_balance; ?>" placeholder="Wallet Total Balance" readonly>
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Minimum Balence</h2>
                    <div>
                        <input type="text" class="txt-user-id" value="<?php echo $_SESSION['cashback_amount']; ?>" placeholder="Minimum Balence" readonly>
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">W-Available Balence</h2>
                    <div>
                        <input type="text" class="txt-user-id" name="wavil_balance" value="<?php echo $_SESSION['ewallet_balance']; ?>" placeholder="W-Available Balence" readonly>
                    </div>
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Amount</label><BR>
                    <input type="text" class="txt-user-id" name="amount" id="amount" onblur="fetchNetAmount(this.value)" placeholder="Enter Amount">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Net Amount</label><BR>
                    <input type="text" class="txt-user-id" name="net_amount" id="net_amount" placeholder="Enter Amount" readonly>
                </div>
                <div class="button-check-div">
                    <a href="./graph_up_arrow.php"><button type="button" class="button-check red">BACK</button></a>
                    <button type="button" class=" button-check green" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Withdrow
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