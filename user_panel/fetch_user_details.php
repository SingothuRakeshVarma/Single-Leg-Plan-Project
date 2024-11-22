<?php
include('../connect.php');

if(isset($_GET['id'])){
    $user_id = $_GET['id'];

        
    $query = mysqli_query($conn, "SELECT * FROM users WHERE userid='$user_id'"); 
  
    $row = mysqli_fetch_array($query); 

    if ($row) {
        $data = array(
            'username' => $row['username'],
            'phonenumber' => $row['phonenumber'],
            'referalname' => $row['referalname']
        );
        echo json_encode($data);
    } else {
        
        echo json_encode(array('error' => 'NO REFERRAL NAME FOUND IN ' . $user_id));
    }
}

?>