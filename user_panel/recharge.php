<?php
include('user_header.php');
include('../connect.php');

$query = "SELECT * FROM web_maneger_img WHERE placetype = 'qr_code'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$qr_code = $row["images"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $amount = $_POST['amount'];
    $trid = $_POST['trid'];
    $tpassword = $_POST['tpassword'];

    // Set the role
    $status = "processing";
    $status2 = "Self Recharge";
    

    // Verify Transaction Pin
    $stmt = $con->prepare("SELECT * FROM users WHERE tpassword = ? AND userid = ?");
    $stmt->bind_param("ss", $tpassword, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Check if transaction ID already exists with rejected status
        $stmt = $con->prepare("SELECT * FROM transaction_requst WHERE transaction_id = ? AND status = 'rejected'");
        $stmt->bind_param("s", $trid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Insert new transaction request
            $stmt = $con->prepare("INSERT INTO transaction_requst (`user_id`, `transaction_id`, `camount`,  `status`, `status2`) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $user_id, $trid, $amount, $status, $status2);
            if ($stmt->execute()) {
                echo '<script>alert("Data saved in database.");window.location.href = "recharge.php";</script>';
                
            } else {
                echo "Error: " . $con->error;
            }
        } else {
            // Check if transaction ID already exists with accepted or processing status
            $stmt = $con->prepare("SELECT * FROM transaction_requst WHERE transaction_id = ? AND status IN ('accepted', 'processing')");
            $stmt->bind_param("s", $trid);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<script>alert("Transaction ID already exists.");window.location.href = "recharge.php";</script>';
               
            } else {
                // Insert new transaction request
                $stmt = $con->prepare("INSERT INTO transaction_requst (`user_id`, `transaction_id`, `camount`,  `status`, `status2`) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $user_id, $trid, $amount, $status, $status2);
                if ($stmt->execute()) {
                    echo '<script>alert("Data saved in database.");window.location.href = "recharge.php";</script>';
                   
                } else {
                    echo "Error: " . $con->error;
                }
            }
        }
    } else {
        echo '<script>alert("Transaction Pin is incorrect.");window.location.href = "recharge.php";</script>';
        
    }
}



?>
<style>
    .check-avatar{
        width: 300px;
        height: 300px; 
       
        
    }
    @media only screen and (max-width: 768px) {
        .check-avatar{
        width: 280px;
        height: 280px; 
        position: relative;
        left: -37vw;
    }
    .page-container{
         position: relative;
        left: 2vw;
       
       
    }
    .w-recharge-h1{
        position: relative;
        left: 12vw;
    }
    }
</style>
<section>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div>
        <center>
            <h1 class="w-recharge-h1">Wallet Recharge</h1>
        </center>
    </div>
    <div class="page-container">


        <div class="avatar-img">
            <img class="check-avatar" src="<?php echo $qr_code; ?>">
        </div>
        <div class="check-details">
            <div class="check-items">
                <label for="name" class="active-id">USER ID</label><BR>
                <input type="text" class="txt-user-id" name="user_id" value="<?php echo $user_id; ?>" readonly>
            </div>
            <div class="check-items">
                <label for="name" class="active-id">Amount&nbsp;:</label><BR>
                <input type="text" class="txt-user-id" id="amountInput" name="amount" placeholder="Enter Amount" readonly required>
            </div>
            <center>
                <div class="btn-group amount" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                    <label class="btn btn-outline-primary money-btn" onclick="setAmount('500')" for="btnradio1">500</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                    <label class="btn btn-outline-primary money-btn" onclick="setAmount('1000')" for="btnradio2">1000</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                    <label class="btn btn-outline-primary money-btn" onclick="setAmount('2000')" for="btnradio3">2000</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
                    <label class="btn btn-outline-primary money-btn" onclick="setAmount('3000')" for="btnradio4">3000</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio5" autocomplete="off">
                    <label class="btn btn-outline-primary money-btn" onclick="setAmount('4000')" for="btnradio5">4000</label>
                </div>
                <div class="btn-group amount" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio6" autocomplete="off">
                    <label class="btn btn-outline-primary money-btn" onclick="setAmount('5000')" for="btnradio6">5000</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio7" autocomplete="off">
                    <label class="btn btn-outline-primary money-btn" onclick="setAmount('10000')" for="btnradio7">10000</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio8" autocomplete="off">
                    <label class="btn btn-outline-primary money-btn" onclick="setAmount('50000')" for="btnradio8">50000</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio9" autocomplete="off">
                    <label class="btn btn-outline-primary money-btn" onclick="setAmount('100000')" for="btnradio9">100000</label>
                </div>

            </center><br>
            <div class="check-items">
                <label for="name" class="active-id">Transaction ID(UTR)</label><BR>
                <input type="text" class="txt-user-id" name="trid" minlength="12" maxlength="12" placeholder="Enter Transaction ID" required>
            </div>
            <div class="button-check-div">
                <a href="./graph_up_arrow.php"><button type="button" class="button-check red">BACK</button></a>
                <!-- Button trigger modal -->
                <button type="button" class="button-check green" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Prosses
                </button>

                <!-- Modal -->
            </div><br><br><br><br>
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
    </div><br><br><br>
</form>
</section>
<script>
    function setAmount(amount) {
        document.getElementById('amountInput').value = amount;
    }
</script>