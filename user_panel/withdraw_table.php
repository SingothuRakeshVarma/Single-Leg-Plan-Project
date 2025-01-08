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
$query = "SELECT * FROM `withdraws` WHERE user_id = '$user_id' order by wdate desc LIMIT $offset, $rowsPerPage"; // SQL query with pagination

$result = mysqli_query($con, $query);
while ($row = $result->fetch_assoc()) {
    $user_id = $row["user_id"];

    echo "<tr>";
    echo "<td class='hedlines green1'>" . $si_no  . "</td>";
    echo "<td class='hedlines green1'>" . $row["wdate"] . "</td>";
    echo "<td class='hedlines green1'>" . $user_id  . "</td>";
    echo "<td class='hedlines green1'>" . $row["w_amount"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["tds"] . " </td>";
    echo "<td class='hedlines green1'>" . $row["admin_charges"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["fund_transfer_charge"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["other"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["wto_user_id"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["wstatus"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["status"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["w_balance"] . "</td>";
    echo "</tr>";
    $si_no++; // Increment the counter
}

// Free result set
mysqli_free_result($result);

// Close connection
mysqli_close($con)
?>