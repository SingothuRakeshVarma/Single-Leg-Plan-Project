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



$query = "SELECT * FROM `referal_income`";


// Display data in a table
echo "<table class= 'cantainer ' >";
echo "<center><h1 class= 'hline'>Referral Income Master Table</h1> </center>";
echo "<tr >

<th class='hedlines red1'>Type</th>
<th class='hedlines red1'>Category</th>
<th class='hedlines red1'>Sub-Category</th>
<th class='hedlines red1'>Product Name</th>
<th class='hedlines red1'>Referral Value</th>
<th class='hedlines red1'>Referral 1</th>
<th class='hedlines red1'>Referral 2</th>
<th class='hedlines red1'>Referral 3</th>
<th class='hedlines red1'>Referral 4</th>
<th class='hedlines red1'>Referral 5</th>
<th class='hedlines red1'>Referral 6</th>
<th class='hedlines red1'>Referral 7</th>
<th class='hedlines red1'>Referral 8</th>
<th class='hedlines red1'>Referral 9</th>
<th class='hedlines red1'>Referral 10</th>
<th class='hedlines red1'><center>Status</center></th></tr>";


// Combine data from both tables and order by date in descending order

$result = mysqli_query($con, $query);
while ($row = $result->fetch_assoc()) {
    $id = $row["product_id"];
    echo "<tr>";

    echo "<td class='hedlines green1'>" . $row["type"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["category"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["sub_category"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["packagename"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["referral_value"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["referral_1"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["referral_2"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["referral_3"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["referral_4"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["referral_5"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["referral_6"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["referral_7"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["referral_8"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["referral_9"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["referral_10"] . "</td>";
    echo "<td class='hedline green1'><a class='acclink' href='referral_income_update.php?id=" . $id .  "'>Edit</a>  <a class='rejlink' href='referral_income_delect.php?id=" . $id .  "'>Delect</a></td>";


    echo "</tr>";
}

echo "</table>";

?>