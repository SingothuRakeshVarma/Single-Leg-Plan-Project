<?php
include('../connect.php');
$si_no = 1; // Initialize the SI NO counter
// Fetch total record count
$sql = "SELECT COUNT(*) AS total_count FROM user_data";
$result = mysqli_query($con, $sql);
$count = mysqli_fetch_assoc($result);
$total_records = $count['total_count'];

// Pagination variables
$rowsPerPage = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $rowsPerPage;
$query = "SELECT * FROM `user_data` LIMIT $offset, $rowsPerPage"; // SQL query with pagination

$result = mysqli_query($con, $query);
while ($row = $result->fetch_assoc()) {
  $user_id = $row["user_id"];
  $bank_details = $row["trust_id"] . "<br>" . $row["trust_qr"];
  $address = $row["addres"] . "<br>" . $row["district"] . "<br>" . $row["state"] . "<br>" . $row["pincode"];
  
  echo "<tr>";
  echo "<td class='hedlines green1'>" . $si_no  . "</td>";
echo "<td class='hedlines green1'>" . $user_id  . "</td>";
  echo "<td class='hedlines green1'>" . $row["user_name"] . "</td>";
  echo "<td class='hedlines green1'>" . $row["phone_number"] . "</td>";
  echo "<td class='hedlines green1'>" . $row["password"] . "</td>";
  echo "<td class='hedlines green1'>" . $row["tpassword"] . " </td>";
  echo "<td class='hedlines green1'>" . $row["referalid"] . "</td>";
  echo "<td class='hedlines green1'>" . $row["referalname"] . "</td>";
  echo "<td class='hedlines green1'>" . $bank_details . "</td>";
  echo "<td class='hedlines green1'>" . $address . " </td>";
  echo "<td class='hedlines green1'>" . $row["joining_date"] . " </td>";
  echo "</tr>";
  $si_no++; // Increment the counter
}

// Free result set
mysqli_free_result($result);

// Close connection
mysqli_close($con)
?>
