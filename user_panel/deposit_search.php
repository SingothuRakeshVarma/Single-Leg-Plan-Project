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

    // Validate dates



    // Fetch total record count
    $countQuery = "SELECT COUNT(*) AS total_count FROM deposit WHERE user_id = ? AND ddate BETWEEN ? AND ?";
    $stmt = $con->prepare($countQuery);
    $stmt->bind_param("sss", $user_id, $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_assoc();
    $total_records = $count['total_count'];

    $rowsPerPage = '300'; // Number of records per page
    $totalPages = ceil($total_records / $rowsPerPage); // Total number of pages
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
    $currentPage = max(1, min($totalPages, $currentPage)); // Ensure current page is within bounds
    $offset = ($currentPage - 1) * $rowsPerPage; // Calculate the starting record index


    // Fetch records with pagination
    $sql = "SELECT * FROM deposit WHERE user_id = ? AND ddate BETWEEN ? AND ? ORDER BY ddate desc LIMIT ?, ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssii", $user_id, $start_date, $end_date, $offset, $rowsPerPage);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $user_id = $row["user_id"];

        echo "<tr>";
        echo "<td class='hedlines green1'>" . $si_no  . "</td>";
        echo "<td class='hedlines green1'>" . $row["ddate"] . "</td>";
        echo "<td class='hedlines green1'>" . $user_id  . "</td>";
        echo "<td class='hedlines green1'>" . $row["amount"] . "</td>";
        echo "<td class='hedlines green1'>" . $row["utr_number"] . "</td>";
        echo "<td class='hedlines green1'>" . $row["from_user_id"] . "</td>";
        echo "<td class='hedlines green1'>" . $row["reson"] . "</td>";
        echo "<td class='hedlines green1'>" . $row["status"] . "</td>";
        echo "<td class='hedlines green1'>" . $row["t_balance"] . "</td>";
        echo "</tr>";
        $si_no++; // Increment the counter
    }

    // Free result set
    mysqli_free_result($result);

    // Close connection
    mysqli_close($con);
}
