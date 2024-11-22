<?php
include('user_header.php');
include('../connect.php');

 $query = "SELECT * FROM users WHERE userid = '$user_id'";
    $result = mysqli_query($con, $query);
     $row = mysqli_fetch_assoc($result);
    
    $account_number = $row["account_number"];
    $ifsc_code = $row["ifsc_code"];
    $holder_name = $row["holder_name"];
    $bankname = $row["bankname"];
    

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user_id = $_POST['user_id'];
    $account_holder_name = $_POST['account_holder_name'];
    $account_number = $_POST['account_number'];
    $conf_account_number = $_POST['conf_account_number'];
    $bank_name = $_POST['bank_name'];
    $ifsc_code = $_POST['ifsc_code'];
    $tpassword = $_POST['tpassword'];

    // Verify Transaction Pin
    $query = "SELECT * FROM users WHERE tpassword = '$tpassword'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        // Update data in database
        $query = "UPDATE users SET holder_name = '$account_holder_name', account_number = '$account_number', bankname = '$bank_name', ifsc_code = '$ifsc_code' WHERE userid = '$user_id'";
        mysqli_query($con, $query);

        echo '<script>alert("Data updated and saved successfully!");window.location.href = "account_detailes.php";</script>';
        
    } else {
        echo '<script>alert("Invalid Transaction Pin");window.location.href = "account_detailes.php";</script>';
        
    }
}




?>
<section>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="page-container">



            <div class="check-details">
                <center>
                    <h1 style="font-size: 150%;">Account Details</h1>
                </center>
                <div class="check-items">
                    <h2 class="head-lines">User ID</h2>
                    <div>
                        <input type="text" class="txt-user-id" name="user_id" value="<?php echo $user_id; ?>">
                        
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Account Holder Name</h2>
                    <div>
                        <input type="text" class="txt-user-id" name="account_holder_name" value="<?php echo $holder_name; ?>" placeholder="Enter Account Holder Name ">
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Account Number</h2>
                    <div>
                        <input type="text" class="txt-user-id" name="account_number" value="<?php echo $account_number; ?>" placeholder="Enter Account Number ">
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Confirm Account Number</h2>
                    <div>
                        <input type="text" class="txt-user-id" name="conf_account_number" value="<?php echo $account_number; ?>" placeholder="Enter Confirm Account Number ">
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Bank Name</h2>
                    <div>
                        <input type="text" class="txt-user-id" name="bank_name" value="<?php echo $bankname; ?>" placeholder="Enter Bank Name ">
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">IFSC Code</h2>
                    <div>
                        <input type="text" class="txt-user-id" name="ifsc_code" value="<?php echo $ifsc_code; ?>" placeholder="Enter IFSC Code ">
                    </div>
                </div>

                <div class="button-check-div">
                    <a href="./bi_people_fill.php"><button type="button" class="button-check red">BACK</button></a>
                    <button type="button" class=" button-check green" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Save
                    </button>

                    <!-- Modal -->

                </div><br><br><br>
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
                        <input type="password" class="txt-user-id" name="tpassword" placeholder="Enter Transaction Pin">

                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" name="submit" value="submit">

                    </div>
                </div>
            </div>
        </div><br><br><br>
        </from>
</section>