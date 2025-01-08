<?php
include('../connect.php');
session_start();

$si_no = 1; // Initialize the SI NO counter

// Determine if a search was performed
if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    // Ensure session is started


    // Get and sanitize input
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $user_id = $_SESSION['user_id']; // Make sure this is sanitized





    // Database connection (assuming $con is your database connection)
    // $con = mysqli_connect("host", "username", "password", "database");

    // Pagination variables
    $rowsPerPage = 300; // Number of records per page


    // Fetch total record count
    $countQuery = "
                        SELECT 
                            (SELECT COUNT(*) 
                             FROM `withdraws` 
                             WHERE user_id = ? AND wdate BETWEEN ? AND ?) +
                            (SELECT COUNT(*) 
                             FROM `deposit` 
                             WHERE user_id = ? AND ddate BETWEEN ? AND ?) AS total_count;";

    $stmt = $con->prepare($countQuery);
    $stmt->bind_param("ssssss", $user_id, $start_date, $end_date, $user_id, $start_date, $end_date);
    $stmt->execute();
    $countResult = $stmt->get_result();
    $count = $countResult->fetch_assoc();
    $total_records = $count['total_count'];

    $totalPages = ceil($total_records / $rowsPerPage); // Total number of pages
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
    $currentPage = max(1, min($totalPages, $currentPage)); // Ensure current page is within bounds
    $offset = ($currentPage - 1) * $rowsPerPage; // Calculate offset for the query

    // Fetch records with pagination
    // Fetch records with pagination
    $query = "
SELECT 
    wdate AS date,
    user_id, 
    w_amount AS amount, 
    admin_charges, 
    wto_user_id, 
    0 AS from_user_id, 
    wstatus AS reson, 
    
    status,
    w_balance AS balance 
FROM `withdraws` 
WHERE user_id = ? AND wdate BETWEEN ? AND ?

UNION ALL 

SELECT 
    ddate AS date,
    user_id,
    amount, 
    0 AS admin_charges, 
    0 AS wto_user_id, 
    from_user_id, 
    tstatus AS statu, 
   
    status,
    t_balance AS balance 
FROM `deposit` 
WHERE user_id = ? AND ddate BETWEEN ? AND ?

ORDER BY date DESC 
LIMIT ?, ?;"; // SQL query with pagination and ordering

    $stmt = $con->prepare($query);

    // Bind parameters
    $stmt->bind_param("ssssssii", $user_id, $start_date, $end_date, $user_id, $start_date, $end_date, $offset, $rowsPerPage);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            // Use the correct column names from the query
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
        echo "Error executing query: " . mysqli_error($con);
    }

    // Free result set
    mysqli_free_result($result);

    // Close connection
    mysqli_close($con);
}
