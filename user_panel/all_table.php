<?php
include('../connect.php');
session_start();

$user_id = $_SESSION['user_id'];
$si_no = 1; // Initialize the SI NO counter
// Fetch total record count
$sql = "SELECT COUNT(*) AS total_count FROM withdraws WHERE user_id = '$user_id'";
$result = mysqli_query($con, $sql);
$count = mysqli_fetch_assoc($result);
$total_records = $count['total_count'];

// Pagination variables
$rowsPerPage = 25;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $rowsPerPage;
$query = "           SELECT 
               wdate AS date,
               
               w_amount AS amount, 
              
               admin_charges, 
               
               wto_user_id, 
               0 AS from_user_id, 
               wstatus AS reson, 
               status,
               w_balance AS balance 
           FROM `withdraws` 
           WHERE user_id = '$user_id'
           
           UNION ALL 
           
           SELECT 
               ddate AS date,
               
               amount, 
              
               0 AS admin_charges, 
               
               0 AS wto_user_id, 
               from_user_id, 
               tstatus AS reson, 
               status,
               t_balance AS balance 
           FROM `deposit` 
           WHERE user_id = '$user_id' 
           
           ORDER BY date DESC 
           LIMIT $offset, $rowsPerPage"; // SQL query with pagination and ordering


         $result = mysqli_query($con, $query);

         if ($result) {
             $si_no = 1; // Initialize the serial number
             while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                            echo "<td class='hedlines green1'>" . $si_no . "</td>";
                            echo "<td class='hedlines green1'>" . htmlspecialchars($row["date"]) . "</td>"; // Use the aliased date, escaping for safety

                            echo "<td class='hedlines green1'>" . htmlspecialchars($row["w_amount"] ?? $row["amount"]) . "</td>"; // Use amount from either withdraws or deposits

                            echo "<td class='hedlines green1'>" . htmlspecialchars($row["admin_charges"] ?? 0) . "</td>"; // Default to 0 if not present
                            echo "<td class='hedlines green1'>" . htmlspecialchars($row["wto_user_id"] ?? 0) . "</td>"; // Use user ID from either withdraws or deposits
                            echo "<td class='hedlines green1'>" . htmlspecialchars($row["from_user_id"] ?? 0) . "</td>"; // Default to 0 if not present

                            echo "<td class='hedlines green1'>" . htmlspecialchars($row["reson"]) . "</td>"; // Status should always be present
                            echo "<td class='hedlines green1'>" . htmlspecialchars($row["status"]) . "</td>";
                            echo "<td class='hedlines green1'>" . htmlspecialchars($row["balance"] ?? $row["t_balance"]) . "</td>"; // Use balance from either withdraws or deposits
                            echo "</tr>";
                            $si_no++; // Increment the counter
             }
         } else {
             echo "Error executing query: " . htmlspecialchars(mysqli_error($con)); // Display error safely
         }

// Free result set
mysqli_free_result($result);

// Close connection
mysqli_close($con)
?>