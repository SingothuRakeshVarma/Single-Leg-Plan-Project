<?php
// Query to select data from the database
include('../connect.php');
include('./header.php');

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

    .green1 {
        background-color: lightyellow;
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
</style>


<?php



$query = "SELECT * FROM `transaction_requst` WHERE status = 'accepted' ORDER BY cdate DESC";


// Display data in a table
echo "<table class= 'cantainer ' >";
echo "<center><h1 class= 'hline'>User Details Table</h1> </center>";
echo "<tr ><center>

<th class='hedlines red1'>Date</th>
<th class='hedlines red1'>User ID</th>
<th class='hedlines red1'>Transaction ID</th>
<th class='hedlines red1'>Amount</th>
<th class='hedlines red1'>Pross. Status</th>
<th class='hedlines red1'>To User ID</th>
<th class='hedlines red1'>From User ID</th>
<th class='hedlines red1'>EW Balance</th></tr>";


// Combine data from both tables and order by date in descending order

$result = mysqli_query($con, $query);
while ($row = $result->fetch_assoc()) {
   
    echo "<tr>";

    echo "<td class='hedlines green1'>" . $row["cdate"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["user_id"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["transaction_id"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["camount"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["status2"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["to_user_id"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["from_user_id"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["cbalance"] . "</td>";
   
    echo "</tr>";
}

echo "</table>";

?>