<?php
session_start();
include('../connect.php');

$floor_users = "floor_1_users";

$floor_user = "FLR534238";


function fetchUsers($floor_user, $floor_users) {
    include('../connect.php');
    global $con;
    $query = "SELECT floor_id, user_name FROM $floor_users WHERE under_id = $floor_user";
    $result = mysqli_query($con, $query);
    
   
    return $users;
}


$tree = fetchUsers($currentUserId, $floor_users);
?>




// Function to check under_id count and fetch floor_ids
// function checkfloor_user($floor_user, $floor_users) {
//     global $con;

//     // Prepare SQL query to get the count of under_ids
//     $stmt = $con->prepare("SELECT COUNT(*) as count FROM $floor_users WHERE under_id = ?");
    
//     // Execute the statement with the floor_user as a parameter
//     $stmt->execute([$floor_user]);
    
//     // Fetch the result
//     $result = $stmt->get_result()->fetch_assoc();

//     // Return the count
//     return $result['count'];
// }

// // Function to fetch floor_ids based on under_ids
// function fetchfloor_users($floor_user, $floor_users) {
//     global $con;

//     // Prepare the SQL statement to fetch floor_id where under_id matches the floor_user
//     $stmt = $con->prepare("SELECT floor_id FROM $floor_users WHERE under_id = ?");
//     $stmt->execute([$floor_user]);
    
//     // Fetch the results
//     $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

//     // Return the results
//     return $results; // Return all matching floor_ids
// }

// // Main logic
// $current_floor_user = $floor_user; // Set this to your initial floor_user value

// while (true) {
//     $count = checkfloor_user($current_floor_user, $floor_users);
//     echo "Count of under_ids for user $current_floor_user: $count\n";

//     if ($count >= 2) {
//         $underIds = fetchfloor_users($current_floor_user, $floor_users);
        
//         if (!empty($underIds)) {
//             // Extract only the floor_ids from the result
//             $floor_ids = array_column($underIds, 'floor_id');
//             echo "Under IDs fetched: " . implode(", ", $floor_ids) . "\n";
            
//             // Assuming you want to check the first under_id for the next iteration
//             $current_floor_user = $floor_ids[0]; // Use the first fetched floor_id for the next iteration
//         } else {
//             echo "No under IDs found for user $current_floor_user. Exiting loop.\n";
//             break; // Exit the loop if no under IDs are found
//         }
//     } else {
//         echo "Count is less than 2 for user $current_floor_user. Exiting loop.\n";
//         break; // Exit the loop
//     }
// }

?>