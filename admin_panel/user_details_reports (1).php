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



$query = "SELECT * FROM `users` ORDER BY joining_date DESC";


// Display data in a table
echo "<table class= 'cantainer ' >";
echo "<center><h1 class= 'hline'>User Details Table</h1> </center>";
echo "<tr ><center>

<th class='hedlines red1'>Date</th>
<th class='hedlines red1'>User ID</th>
<th class='hedlines red1'>User Name</th>
<th class='hedlines red1'>Pasword</th>
<th class='hedlines red1'>Tran. Pasword</th>
<th class='hedlines red1'>Referral ID</th>
<th class='hedlines red1'>Referral Name</th>
<th class='hedlines red1'>Mobile Number</th>
<th class='hedlines red1'>Bank Details</th>
<th class='hedlines red1'>Addres</th>
<th class='hedlines red1'>Expiry Data</th>
<th class='hedlines red1'>Active Status</th></th></center></tr>";


// Combine data from both tables and order by date in descending order

$result = mysqli_query($con, $query);
while ($row = $result->fetch_assoc()) {
   
    $full_bank_details = $row["bankname"] . " ," . $row["holder_name"] . " ," . $row["account_number"] . " ," . $row["ifsc_code"];
    $full_addres_details = $row["addres"] . ", " . $row["district"] . " ," . $row["state"] . " ," . $row["country"]. " -" . $row["pincode"];
    echo "<tr>";

    echo "<td class='hedlines green1'>" . $row["joining_date"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["userid"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["username"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["password"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["tpassword"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["referalid"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["referalname"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["phonenumber"] . "</td>";
    echo "<td class='hedlines green1'>" . $full_bank_details . "</td>";
    echo "<td class='hedlines green1'>" . $full_addres_details . "</td>";
    echo "<td class='hedlines green1'>" . $row["expiry_date"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["activation_status"] . "</td>";
   
   


    echo "</tr>";
}

echo "</table>";

?>