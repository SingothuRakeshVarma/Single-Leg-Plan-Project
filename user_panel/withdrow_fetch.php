<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "user_data";

$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['id'])){
    $user_id = $_GET['id'];

        
    $query = mysqli_query($conn, "SELECT * FROM transaction WHERE userids='$user_id'"); 
  
    $row = mysqli_fetch_array($query); 

    if ($row) {
        $ewallet_balance = $row['ewallet_balance'];
        $cashback_amount = $row['cashback_amount'];
        $total_balance = $ewallet_balance + $cashback_amount;
    
        $data = array(
            'total_balance' => $total_balance,
            'cashback_amount' => $cashback_amount,
            'ewallet_balance' => $ewallet_balance
        );
        echo json_encode($data);
    } else {
        echo json_encode(array('error' => 'NO REFERRAL NAME FOUND IN ' . $user_id));
    }
}
?>