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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realvisine</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $logo; ?>">

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

    .green1 {
        background-color: lightyellow;
    }

  
</style>
</head>

<body>
<div>
    <label>From Date:</label>
    <input type="date" id="from_date" name="from_date"></br>
    <label>To Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>
    <input type="date" id="to_date" name="to_date">
    <input type="button" name="Filter" value="&nbsp;&nbsp;Filter&nbsp;&nbsp;">
</div></br>
</body>

</html>


<?php




// Get the from and to dates from the user
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];

// Validate the dates
if (!empty($from_date) && !empty($to_date)) {
    $query = "SELECT * FROM `pv_summery` WHERE user_id = '$user_id' AND date BETWEEN '$from_date' AND '$to_date' ORDER BY date DESC";
} else {
    $query = "SELECT * FROM `pv_summery` WHERE user_id = '$user_id' ORDER BY date DESC";
}


// Display data in a table
echo "<table class= 'cantainer' >";
echo "<center><h1 class= 'hline'>User PVS Details Table</h1> </center>";
echo "<tr ><center>

<th class='hedlines red1'>Date</th>
<th class='hedlines red1'>User ID</th>
<th class='hedlines red1'>User Name</th>
<th class='hedlines red1'>No.Of PVS</th>
<th class='hedlines red1'>Level</th>
<th class='hedlines red1'>From User Name</th>
<th class='hedlines red1'>From User ID</th>
<th class='hedlines red1'>Status</th></tr>";


// Combine data from both tables and order by date in descending order

$result = mysqli_query($con, $query);
while ($row = $result->fetch_assoc()) {
    $touserid = $row["form_user_id"]; // Get the form_user_id from the current row
    $query = "SELECT username FROM `users` WHERE userid = '$touserid'";
    $innerResult = mysqli_query($con, $query);
    $innerRow = mysqli_fetch_assoc($innerResult);

    $tousername = $innerRow["username"];

    echo "<tr>";
    echo "<td class='hedlines green1'>" . $row["date"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["user_id"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["user_name"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["pvs"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["levels"] . "</td>";
    echo "<td class='hedlines green1'>" . $tousername . "</td>";
    echo "<td class='hedlines green1'>" . $touserid . "</td>";
    echo "<td class='hedlines green1'>" . $row["status"] . "</td>";
    echo "</tr>";
}

echo "</table></br></br></br></br></br>";

?>
