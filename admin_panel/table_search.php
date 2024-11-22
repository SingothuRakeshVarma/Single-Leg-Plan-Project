<?php
include('./header.php')
?>

<style>
table {
  border-collapse: collapse;
  width: 100%;
  text-align: center;
}

th, td {
  border: 1px solid white;
  padding: 8px;
  text-align: left;
  color: darkcyan;
}

.pagination {
  display: flex;
  justify-content: center;
  margin-top: 10px;
}

.pagination button {
  margin: 0 5px;
  padding: 5px 10px;
  border: 1px solid #ccc;
  background-color: #fff;
  cursor: pointer;
}

.pagination button.active {
  background-color: #ddd;
}
.acclink {
        text-decoration: none;
        font-size: 100%;
        text-align: center;
        border-radius: 0.5vw;
        color: white;
        background-color: green;
        padding: 0.3vw 1.5vw;
        margin-left: 0.5vw;
    }

    .rejlink {
        text-decoration: none;
        font-size: 100%;
        text-align: center;
        border-radius: 0.5vw;
        color: white;
        background-color: red;
        padding: 0.3vw 1vw;
        margin-left: 0.3vw;

    }
    .imagview{
        width: 100px;
        height: 100px;
    }
    h2{
        color: darkcyan;
    }
</style>
<CENTER><h2>USER DATA</h2></CENTER>
<form method="GET" action="table_search.php">
    <input type="text" name="search" placeholder="Search by name or user ID" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <input type="submit" value="Search">
</form>

<table id="myTable">
  <thead>
    <tr>
      <th>SI NO</th>
      <th>User ID</th>
      <th>User Name</th>
      <th>Mobile Number</th>
      <th>Password</th>
      <th>T-Password</th>
      <th>Referral ID</th>
      <th>Referral Name</th>
      <th>Bank Details</th>
      <th>Addres</th>
      <th>Joining Date</th>
      
    </tr>
  </thead>
  <tbody>
<?php
include('../connect.php');

$si_no = 1; // Initialize the SI NO counter

// Fetch total record count
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$sql = "SELECT COUNT(*) AS total_count FROM user_data WHERE user_name LIKE '%$search%' OR user_id LIKE '%$search%'";
$result = mysqli_query($con, $sql);
$count = mysqli_fetch_assoc($result);
$total_records = $count['total_count'];

// Redirect to user_data_report.php if no records found
if ($total_records === 0) {
    header("Location: user_data_report.php");
    exit(); // Make sure to exit after the header redirect
}

// Pagination variables
$rowsPerPage = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $rowsPerPage;

// Modify the query to include the search condition
$query = "SELECT * FROM `user_data` WHERE user_name LIKE '%$search%' OR user_id LIKE '%$search%' LIMIT $offset, $rowsPerPage"; // SQL query with pagination and search

$result = mysqli_query($con, $query);
while ($row = $result->fetch_assoc()) {
    $user_id = $row["user_id"];
    $bank_details = $row["bankname"] . "<br>" . $row["account_number"] . "<br>" . $row["ifsc_code"] . "<br>" . $row["holder_name"];
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
mysqli_close($con);
?>
</tbody>
</table><br><br><br><br><br><br>