<?php
include('../connect.php');
include('./header.php');
?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Luckiest+Guy&display=swap');



        .withdrow-table {
            border: 2;
         
        }

        .cantainer {


        display: flex;

        border-collapse: collapse;
        padding-bottom: 200px;
    }

    .hedlines {
        width: 100vw;
        height: auto;
        padding-top: 1vw;
        font-size: 90%;
        border: solid 1px black;
        padding: 1vw 1vw;
        text-align: center;
    }

    .hedline {
        width: 100vw;
        border: solid 1px black;


    }

    .red1 {
        font-size: 120%;

        color: midnightblue;
        background-color: yellow;

    }

    .green1 {
        background-color: lightyellow;
        font-size: 100%;
        color: black;
        background-color: lightyellow;
    }

    .acclink {
        text-decoration: none;
        font-size: 100%;
        text-align: center;
        border-radius: 0.5vw;
        color: white;
        background-color: green;
        padding: 0.3vw 1.5vw;
        margin-left: 0.5vw;
    }

    .rejlink {
        text-decoration: none;
        font-size: 100%;
        text-align: center;
        border-radius: 0.5vw;
        color: white;
        background-color: red;
        padding: 0.3vw 1vw;
        margin-left: 0.3vw;

    }
    </style>
<?php


$query = "SELECT * FROM web_maneger_img WHERE placetype = 'logo'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$logo = $row["images"];

// Update status when a row is clicked
if (isset($_GET["id"]) && isset($_GET["status"]) && isset($_GET["amount"]) && isset($_GET["transaction_id"])) {
    $id = $_GET["id"];
    $status = $_GET["status"];
    $amount = $_GET["amount"];
    $transaction_id = $_GET["transaction_id"];

    $query="SELECT ewallet_balance, ewallet FROM transaction WHERE userids = '$id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $ewallet_balance = $row['ewallet_balance'];
    $ewallet = $row['ewallet'];
    $new_ewallet_balance = $ewallet_balance + $amount;
    $new_ewallet = $ewallet + $amount;

    // Check if transaction ID and user ID exist in the database
    $query = "SELECT * FROM transaction_requst WHERE user_id = ? AND transaction_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ss", $id, $transaction_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        if ($status == 'accepted') {

    // Update transaction record
    $query = "UPDATE transaction SET ewallet_balance = ?, ewallet = ? WHERE userids = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sss", $new_ewallet_balance, $new_ewallet, $id);
    $stmt->execute();
    
    // Update transaction request status
    $query = "UPDATE transaction_requst SET cbalance = ?,status = 'accepted' WHERE user_id = ? AND  status = 'processing'";
    $stmt = $con->prepare($query);
    $stmt->bind_param("is", $new_ewallet_balance, $id);
    $stmt->execute();
    echo '<script>window.location.href = "recharge_request.php"</script>';


            
            
        } elseif ($status == 'rejected') {
            // Update transaction request status
            $query = "UPDATE transaction_requst SET status = 'rejected' WHERE user_id = ? AND status = 'processing'";
            $stmt = $con->prepare($query);
            $stmt->bind_param("s", $id);
            $stmt->execute();
echo '<script>alert("Found Is Adding On Wallet.");window.location.href ="recharge_request.php";</script>';
            
        }
    } else {
        echo "Error: Transaction ID and user ID do not exist in the database.";
    }
}
    
    


// Query to select data from the database
$sql = "SELECT * FROM transaction_requst  WHERE status = 'accepted' AND status2 = 'Self Recharge' ";
$result = $con->query($sql);

// Display data in a table
echo "<table class= 'cantainer' >";
echo "<center><h1 class= 'hline'>Credit Requests</h1> </center>";
   
echo "<tr class='head_row'>
<th class='hedlines red1'>User Id</th>
<th class='hedlines red1'>Credit Amount</th>
<th class='hedlines red1'>date</th>
<th class='hedlines red1'>Transaction ID</th>
<th class='hedlines red1'>Status</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";

    echo "<td class='hedlines green1'>" . $row["user_id"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["camount"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["cdate"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["transaction_id"] . "</td>";

    echo "<td class='hedlines green1'>" . $row["status"] . "</td>";
}

echo "</table>";

?>

