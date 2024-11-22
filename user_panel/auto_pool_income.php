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
<style>
    .cantainer1 {


        display: flex;
        text-align: center;
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

    .green1 {
        background-color: lightyellow;
    }


</style>
</head>

<body>
    
</body>

</html>
<?php
// Prepare the SQL query without the date filter
$stmt = $con->prepare("SELECT cdate, camount, from_user_id, status2, cbalance FROM transaction_requst WHERE status = 'accepted' AND user_id = ? AND status2 LIKE 'Auto Pool Income%' ORDER BY cdate DESC");
$stmt->bind_param("s", $user_id);

// Execute the query
$stmt->execute();

// Display data in a table
echo "<table class='container1'>";
echo "<center><h1 class='hline'>AUTO POOL INCOME</h1> </center>";
echo "<center><tr>
<th class='hedlines red1'>Date</th>
<th class='hedlines red1'>Income</th>

<th class='hedlines red1'>From User</th>
<th class='hedlines red1'>Status</th>
<th class='hedlines red1'>Balance</th></center></tr>";

// Combine data from both tables and order by date in descending order

$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    echo "<tr>";

    echo "<td class='hedlines green1'>" . $row["cdate"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["camount"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["from_user_id"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["status2"] . "</td>";
echo "<td class='hedlines green1'>" . $row["cbalance"] . "</td>";
    
    echo "</tr>";
}

echo "</table><br><br><br><br>";
?>