<?php
include('../connect.php');

if(isset($_GET['id'])){
    $referral_id = $_GET['id'];

        
    $query = mysqli_query($con, "SELECT * FROM user_data WHERE user_id='$referral_id'");
  
    $row = mysqli_fetch_array($query); 

    if ($row) { // Check if there is at least one row returned
        echo $row ['user_name']; 
       
    } else {
        echo "NO REFERRAL NAME FOUND IN  $referral_id";
    }
  
    // Get the first name 
    
    
   
// else {
//     echo "No referral name found";
    
// }
}

$con->close();
?>