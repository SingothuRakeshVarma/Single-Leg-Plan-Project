<?php
include('header.php');
include("../connect.php");

if (isset($_POST['submit'])) {
    $user_id = $_POST['userid'];
    $Fundtype = $_POST['Fundtype'];
    $amount = $_POST['amount'];
    $Status = $_POST['Status'];


    $date = date("Y-m-d");
    $status2 = "accepted";
    $admin = "admin";



    $query = mysqli_query($con, "SELECT * FROM transaction WHERE userids = '$user_id'");
    $row = mysqli_fetch_array($query);

    if ($row) { // Check if the user exists in the transaction table
        $ewallet_amount = $row['ewallet'];
        $ewallet_withdrow_amount = $row['ewallet_withdrow'];
        $ewallet_balance_amount = $row['ewallet_balance'];
        $swallet_amount = $row['swallet'];
        $swallet_withdrow_amount = $row['swallet_withdrow'];
        $swallet_balance_amount = $row['swallet_balance'];
        $points_amount = $row['points'];
        $points_withdrow_amount = $row['points_withdrow'];
        $points_balance_amount = $row['points_balance'];

        // Perform calculation based on fund type and status
        if ($Fundtype == 'ewallet') {
            if ($Status == 'Credit') {
                $ewallet_balance_new_amount = $ewallet_balance_amount + $amount; // Credit operation
                $ewallet_new_amount = $ewallet_amount + $amount;
                $ewallet_new_withdrow_amount = $ewallet_withdrow_amount + 0;
                $insertQuery = "INSERT INTO `transaction_requst`(`user_id`, `camount`, `cdate`,`status`,`to_user_id`,`status2` ,`cbalance`) VALUES  (?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $insertQuery);
                mysqli_stmt_bind_param($stmt, 'sssssss', $user_id, $amount, $date, $status2, $admin, $admin, $ewallet_balance_new_amount);
                mysqli_stmt_execute($stmt);
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    echo '<script>alert("Transaction request inserted successfully!");</script>';
                } else {
                    echo "Error inserting transaction request: " . mysqli_stmt_error($stmt);
                }
            } elseif ($amount <= $ewallet_balance_amount) {
                $ewallet_new_withdrow_amount = $amount +  $ewallet_withdrow_amount;
                $ewallet_balance_new_amount = $ewallet_balance_amount - $amount; // Debit operation
                $ewallet_new_amount = $ewallet_amount + 0;
                $insertQuery = "INSERT INTO `withdrow_requests`(`userid`, `withdrow_amount`, `date`,`status`,`wto_user_id`,`wstatus2` ,`balance`) VALUES  (?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $insertQuery);
                mysqli_stmt_bind_param($stmt, 'sssssss', $user_id, $amount, $date, $status2, $admin, $admin, $ewallet_balance_new_amount);
                mysqli_stmt_execute($stmt);
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    echo '<script>alert("Withdrawal request inserted successfully!");</script>';
                } else {
                    echo "Error inserting withdrawal request: " . mysqli_stmt_error($stmt);
                }
            } else {
                echo '<script>alert("Insufficient Balance");window.location.href = "fund_transfer.php";</script>';

                exit;
            }


            $query = "UPDATE transaction SET ewallet = ?, ewallet_balance = ?, ewallet_withdrow = ? WHERE userids = ?";
            $stmt = mysqli_prepare($con, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'iiis', $ewallet_new_amount, $ewallet_balance_new_amount, $ewallet_new_withdrow_amount, $user_id);
                mysqli_stmt_execute($stmt);

                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    echo '<script>alert("Amount updated successfully!");window.location.href = "fund_transfer.php";</script>';
                } else {
                    echo "Error updating amount: " . mysqli_stmt_error($stmt);
                }
            } else {
                echo "Error preparing statement: " . mysqli_error($con);
            }
        } elseif ($Fundtype == 'swallet') {
            if ($Status == 'Credit') {
                $swallet_balance_new_amount = $swallet_balance_amount + $amount; // Credit operation
                $swallet_new_amount = $swallet_amount + $amount;
                $swallet_new_withdrow_amount = $swallet_withdrow_amount + 0;
            } elseif ($amount <= $swallet_balance_amount) {
                $swallet_balance_new_amount = $swallet_balance_amount - $amount; // Debit operation
                $swallet_new_withdrow_amount = $swallet_withdrow_amount + $amount;
                $swallet_new_amount = $swallet_amount + 0;
            } else {
                echo '<script>alert("Insufficient Balance");window.location.href = "fund_transfer.php";</script>';
                exit;
            }
            $query = "UPDATE transaction SET swallet = ?, swallet_balance = ?, swallet_withdrow = ? WHERE userids = ?";
            $stmt = mysqli_prepare($con, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'iiis', $swallet_new_amount, $swallet_balance_new_amount, $swallet_new_withdrow_amount, $user_id);
                mysqli_stmt_execute($stmt);

                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    echo '<script>alert("Amount updated successfully!");window.location.href = "fund_transfer.php";</script>';
                } else {
                    echo "Error updating amount: " . mysqli_stmt_error($stmt);
                }
            } else {
                echo "Error preparing statement: " . mysqli_error($con);
            }
        } 
         
    }else {
            echo '<script>alert("User not found");window.location.href = "fund_transfer.php";</script>';
        }
}
?>


<section>



    <div class="page-container">





        <form class="check-details" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

            <center>
                <h1 style="font-size: 150%;">Fund Transfer</h1>
            </center>
            <div class="check-items">
                <label for="name" class="active-id">User ID</label><BR>
                <input type="text" class="txt-user-id" name="userid" id="userid" onblur="fetchReferralName(this.value)" placeholder="Enter User ID" >
            </div>
            <div class="check-items">
                <label for="name" class="active-id">User Name</label><BR>
                <input type="text" class="txt-user-id" name="referral_name" id="referral_name" placeholder="Enter User Name" readonly>
            </div>
            <div class="check-items">
                <h2 class="head-lines">Type Of Fund</h2>

                <select name="Fundtype" class="user-id">
                    <option value="Select Fundtype">Select Add Fund Type</option>
                    <option value="ewallet">
                        E-Wallet</option>
                    <option value="swallet">
                        S-Wallet</option>
                    
                </select>

            </div>
            <div class="check-items">
                <label for="name" class="active-id">Amount</label><BR>
                <input type="number" class="txt-user-id" name="amount" placeholder="Enter Amount">
            </div>
            <div class="check-items">
                <h2 class="head-lines">Status</h2>

                <select name="Status" class="user-id">
                    <option value="Select Status">Select Status</option>
                    <option value="Credit">
                        Credit</option>
                    <option value="Debit">
                        Debite</option>
                </select>

            </div>


            <div class="button-check-div">
                <a href="./managers.php"><button type="button" class="button-check red">BACK</button></a>
                <input type="submit" class="button-check green" name="submit" value="submit">
            </div><br><br><br><br><br><br>


        </form>

    </div>

</section>
<script>
     function fetchReferralName(userid) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_referral_name.php?id=' + userid, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('referral_name').value = xhr.responseText;
                }
            };
            xhr.send();
        }
</script>