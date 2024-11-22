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

$query = "SELECT * FROM web_maneger_img WHERE placetype = 'logo'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$logo = $row["images"];

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
</style>
</head>

<body>
    <div class="filter-form">
        <form action="" method="post">
            <label for="from_date">From Date:</label>
            <input type="date" id="from_date" name="from_date"></br>
            <label for="to_date">To Date&nbsp;&nbsp;&nbsp;&nbsp; :</label>
            <input type="date" id="to_date" name="to_date">
            <input type="submit" name="filter" value="Filter">
        </form>
    </div></br>
</body>

</html>
<?php



// Check if the filter form has been submitted
if (isset($_POST['filter'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    // Prepare the SQL query with the date filter
    $stmt = $con->prepare("SELECT date, 0 as camount, withdrow_amount, wto_user_id, 0 as from_user_id, wstatus2, balance, tds, admin_charges, other, fund_transfer_charge FROM withdrow_requests WHERE userid = ? AND date BETWEEN ? AND ? UNION ALL SELECT cdate, camount, 0 as wto_user_id, to_user_id, from_user_id, status2, cbalance, 0 as tds, 0 as admin_charges, 0 as other, 0 as fund_transfer_charge FROM transaction_requst WHERE status = 'accepted' AND user_id = ? AND cdate BETWEEN ? AND ? ORDER BY date DESC");
    $stmt->bind_param("ssssss", $user_id, $from_date, $to_date, $user_id, $from_date, $to_date);
} else {
    // Prepare the SQL query without the date filter
    $stmt = $con->prepare("SELECT date, 0 as camount, withdrow_amount, wto_user_id, 0 as from_user_id, wstatus2, balance, tds, admin_charges, other, fund_transfer_charge FROM withdrow_requests WHERE userid = ? UNION ALL SELECT cdate, camount, 0 as wto_user_id, to_user_id, from_user_id, status2, cbalance, 0 as tds, 0 as admin_charges, 0 as other, 0 as fund_transfer_charge FROM transaction_requst WHERE status = 'accepted' AND user_id = ? ORDER BY date DESC");
    $stmt->bind_param("ss", $user_id, $user_id);
}

// Execute the query
$stmt->execute();

// Display data in a table
echo "<table class='cantainer'>";
echo "<center><h1 class='hline'>Income Summary</h1> </center>";
echo "<tr >
<th class='hedlines red1'>Date</th>
<th class='hedlines red1'>Income</th>
<th class='hedlines red1'>Withdrow</th>
<th class='hedlines red1'>TDS Charges</th>
<th class='hedlines red1'>Admin Charges</th>
<th class='hedlines red1'>Other</th>
<th class='hedlines red1'>Fund Transfer Charge</th>
<th class='hedlines red1'>Balance</th>
<th class='hedlines red1'>To User</th>
<th class='hedlines red1'>From User</th>
<th class='hedlines red1'>Status</th></tr>";

// Combine data from both tables and order by date in descending order

$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    echo "<tr>";

    echo "<td class='hedlines green1'>" . $row["date"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["camount"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["withdrow_amount"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["tds"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["admin_charges"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["other"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["fund_transfer_charge"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["balance"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["wto_user_id"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["from_user_id"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["wstatus2"] . "</td>";

    
    echo "</tr>";
}

echo "</table>";
?>