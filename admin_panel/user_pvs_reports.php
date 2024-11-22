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



$query = "SELECT * FROM `pv_summery`";


// Display data in a table
echo "<table class= 'cantainer ' >";
echo "<center><h1 class= 'hline'>User PVS Details Table</h1> </center>";
echo "<tr ><center>

<th class='hedlines red1'>Date</th>
<th class='hedlines red1'>User ID</th>
<th class='hedlines red1'>User Name</th>
<th class='hedlines red1'>PVS Amount</th>
<th class='hedlines red1'>Levels</th>
<th class='hedlines red1'>Referral ID</th>
<th class='hedlines red1'>From User ID</th></tr>";


// Combine data from both tables and order by date in descending order

$result = mysqli_query($con, $query);
while ($row = $result->fetch_assoc()) {
   
    echo "<tr>";
    echo "<td class='hedlines green1'>" . $row["date"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["user_id"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["user_name"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["pvs"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["levels"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["referral_id"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["form_user_id"] . "</td>";
   
    echo "</tr>";
}

echo "</table>";

?>