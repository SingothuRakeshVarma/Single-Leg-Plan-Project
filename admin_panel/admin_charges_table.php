<style>
    .cantainer {


        display: flex;
        margin:0 120px 120px 0px;
        border-collapse: collapse;
        padding-bottom: 200px;
    }

    .hedlines {
        width: 100vw;
        padding-top: 1vw;
        font-size: 90%;
        border: solid 1px black;
        padding: 1vw 4.5vw;

    }

    .hedline {
        width: 100vw;


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
// Query to select data from the database
include('../connect.php');


$query = "SELECT * FROM `admin_charges`";


// Display data in a table
echo "<table class= 'cantainer ' >";
echo "<center><h1 class= 'hline'>Admin Charges</h1> </center>";
echo "<tr >
<th class='hedlines red1'>Minimum Withdrawals</th>
<th class='hedlines red1'>Maximum Withdrawals</th>
<th class='hedlines red1'>Minimum Referrals</th>
<th class='hedlines red1'>Maximum Referrals</th>
<th class='hedlines red1'>SPV Cost</th>
<th class='hedlines red1'>TDS %</th>
<th class='hedlines red1'>Admin Charge %</th>
<th class='hedlines red1'>Fund Transfer charge %</th>
<th class='hedlines red1'>Share Cutting %</th>
<th class='hedlines red1'>Others %</th>
<th class='hedlines red1'>Status</th></tr>";


// Combine data from both tables and order by date in descending order

$result = mysqli_query($con, $query);
while ($row = $result->fetch_assoc()) {
    echo "<tr>";

    echo "<td class='hedlines green1'>" . $row["Min_withdrows"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["max_withdrows"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["min_referrals"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["max_referrals"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["spv_cost"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["tds"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["admin_charges"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["fund_transfer_charge"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["share_cutting"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["others"] . "</td>";
    echo "<td class='hedline green1'><center><a class='acclink' href='business_manager.php?id=" . $row["id"] .  "'>Edit</a></center> </td>";


    echo "</tr>";
}

echo "</table>";
?>