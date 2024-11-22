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


$query = "SELECT * FROM `product_delivery`";


// Display data in a table
echo "<table class= 'cantainer ' >";
echo "<center><h1 class= 'hline'>Delivery Report</h1> </center>";
echo "<tr >

<th class='hedlines red1'>User ID</th>
<th class='hedlines red1'>User Name</th>
<th class='hedlines red1'>Product ID</th>
<th class='hedlines red1'>Product Name</th>
<th class='hedlines red1'>Courier Name</th>
<th class='hedlines red1'>Courier ID</th>
<th class='hedlines red1'>Addres</th>
<th class='hedlines red1'><center>Status Edit</center></th></tr>";


// Combine data from both tables and order by date in descending order

$result = mysqli_query($con, $query);
while ($row = $result->fetch_assoc()) {
    $id = $row["product_id"];
    $user_id = $row["user_id"];
    echo "<tr>";

    echo "<td class='hedlines green1'>" . $row["user_id"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["user_name"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["product_id"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["product_name"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["courier_name"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["courier_id"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["addres"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["status"] . "</td>";
    
    

    echo "</tr>";
}

echo "</table>";

?>