<?php
include('../connect.php');

if(isset($_GET['id'])){
    $active_id = $_GET['id'];

        
    $query = mysqli_query($con, "SELECT username FROM users WHERE userid='$active_id'"); 
  
    $row = mysqli_fetch_array($query); 

    if ($row) { // Check if there is at least one row returned
        echo $row ['username']; 
       
    } else {
        echo "NO USER NAME FOUND IN  $active_id";
    }
  
    // Get the first name 
    
    
   
// else {
//     echo "No referral name found";
    
// }
}

$con->close();
?>