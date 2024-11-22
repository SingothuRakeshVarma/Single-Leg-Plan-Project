<?php
// Query to select data from the database
include('../connect.php');
include('user_header.php');

session_start();
if (isset($_SESSION['userid'])) {
    $user_id = $_SESSION['userid'];
} else {
    // handle the case where the userid is not set
    echo "User ID is not set.";
}



?>
<style>
  .cantainer {


display: flex;

border-collapse: collapse;
padding-bottom: 200px;
}

.hedlines {
width: 100vw;
padding-top: 1vw;
font-size: 90%;
border: solid 1px black;
padding: auto;
text-align: center;

}

.hedline {
width: 20px;


border: solid 1px black;

}

.red1 {
font-size: 100%;
color: midnightblue;
background-color: yellow;

}
table tr:nth-child(even) {
  background-color: lightyellow;
}
table tr:hover {
  background-color: darkkhaki;
}
.green1 {
background-color: lightyellow;

}
.filter-form {
            float: left;
            margin-top: 20px;
            margin-left: 20px;
        }
        .titel{
            font-size: 5vw;
        }
</style>
<?php


// Function to fetch user details up to 5 levels deep
function fetchReferredUsers($con, $user_id, $level = 1) {
    $userDetails = array();
    $query = "SELECT userid, username, referalid, referalname, activation_status FROM users WHERE referalid = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($user = $result->fetch_assoc()) {
            $user['level'] = $level; // Add the level to the user array
            $userDetails[] = $user;
            if ($level < 5) {
                $referredDetails = fetchReferredUsers($con, $user['userid'], $level + 1);
                $userDetails = array_merge($userDetails, $referredDetails);
            }
        }
    }
    return $userDetails;
}

// Function to display user details in a table
function displayUserDetails($userDetails) {
    // Sort users by level
    usort($userDetails, function($a, $b) {
        return $a['level'] - $b['level'];
    });
 echo "<center><h class='titel'>LEVEL REPORT</h></center><br>";
    // Search bar
    echo "<form action='' method='get'>";
    echo "<input type='text' name='search' placeholder='Search by username or ID'>";
    echo "<input type='submit' value='Search'>";
    echo "</form><br>";

    // Display search results
   if (isset($_GET['search'])) {
    $searchQuery = strtoupper($_GET['search']); // Convert search query to uppercase
    
    $searchResults = array();
    foreach ($userDetails as $user) {
        $usernameLowercase = strtolower($user['username']); // Convert username to lowercase
        if (stripos($user['username'], $searchQuery) !== false || stripos($user['userid'] == $searchQuery)) {
    $searchResults[] = $user;
}
        }
        if (count($searchResults) > 0) {
            echo "<table border='1'>";
            echo "<tr class='hedlines red1'><th>Sr. No.</th>
                  <th class='hedlines red1'>User ID</th>
                  <th class='hedlines red1'>Username</th>
                  <th class='hedlines red1'>Referral ID</th>
                 <th class='hedlines red1'>Referral Name</th>
                 <th class='hedlines red1'>Level</th>
                 <th class='hedlines red1'>Status</th></tr>";
            $serialNo = 1; // Initialize serial number
            foreach ($searchResults as $user) {
                echo "<tr>";
                echo "<td class='hedlines green1'>" . $serialNo . "</td>"; // Display serial number
                echo "<td class='hedlines green1'>" . $user['userid'] . "</td>";
                echo "<td class='hedlines green1'>" . $user['username'] . "</td>";
                echo "<td class='hedlines green1'>" . $user['referalid'] . "</td>";
                echo "<td class='hedlines green1'>" . $user['referalname'] . "</td>";
                echo "<td class='hedlines green1'>Level - " . getLevelString($user['level'], $user['referalid']) . "</td>";
                echo "<td class='hedlines green1'>" . $user['activation_status'] . "</td>";
                echo "</tr>";
                $serialNo++; // Increment serial number
            }
            echo "</table>";
        } else {
            echo "No results found for '$searchQuery'";
        }
    } else {
        // Display all users if no search query is provided
        echo "<table border='1'>";
        echo "<tr class='hedlines red1'><th>Sr. No.</th>
              <th class='hedlines red1'>User ID</th>
              <th class='hedlines red1'>Username</th>
              <th class='hedlines red1'>Referral ID</th>
             <th class='hedlines red1'>Referral Name</th>
             <th class='hedlines red1'>Level</th>
             <th class='hedlines red1'>Status</th></tr>";
        $serialNo = 1; // Initialize serial number
        foreach ($userDetails as $user) {
            echo "<tr>";
            echo "<td class='hedlines green1'>" . $serialNo . "</td>"; // Display serial number
            echo "<td class='hedlines green1'>" . $user['userid'] . "</td>";
            echo "<td class='hedlines green1'>" . $user['username'] . "</td>";
            echo "<td class='hedlines green1'>" . $user['referalid'] . "</td>";
            echo "<td class='hedlines green1'>" . $user['referalname'] . "</td>";
            echo "<td class='hedlines green1'>Level - " . getLevelString($user['level'], $user['referalid']) . "</td>";
            echo "<td class='hedlines green1'>" . $user['activation_status'] . "</td>";
            echo "</tr>";
            $serialNo++; // Increment serial number
        }
        echo "</table><br><br><br><br>";
    }
}

// Function to generate the level string
function getLevelString($level, $parentId = 0) {
    $levelString = '';
    $parentLevels = getParentLevels($parentId);
    foreach ($parentLevels as $parentLevel) {
        $levelString .= $parentLevel . '';
    }
    $levelString .= $level;
    return $levelString;
}

// Function to get parent levels
function getParentLevels($parentId, $levels = []) {
    if ($parentId == 0) {
        return $levels;
    }
    $parentUser = getUserById($parentId);
    array_unshift($levels, $parentUser['level']);
    return getParentLevels($parentUser['referalid'], $levels);
}

// Function to get user by ID (assuming you have this function)
function getUserById($id) {
    // Return the user data for the given ID
}
// Example usage:
// $user_id = 1; // Replace with the ID of the user you want to start with
$userDetails = fetchReferredUsers($con, $user_id);
displayUserDetails($userDetails);
$con->close();
?>