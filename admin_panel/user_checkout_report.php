<?php
// Query to select data from the database
include('../connect.php');
include('./header.php');

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


$query = "SELECT * FROM `withdrow_report` WHERE date BETWEEN $from_date AND $to_date";
}else{
    $query = "SELECT * FROM `withdrow_report`";
}


// Display data in a table
echo "<table class= 'cantainer ' >";
echo "<center><h1 class= 'hline'>User CheckOut Table</h1> </center>";
echo "<tr ><center>

<th class='hedlines red1'>Date</th>
<th class='hedlines red1'>User ID</th>
<th class='hedlines red1'>Bank Holder Name</th>
<th class='hedlines red1'>Bank Name</th>
<th class='hedlines red1'>Account Number</th>
<th class='hedlines red1'>IFSC Code</th>
<th class='hedlines red1'>Amount</th></tr>";


// Combine data from both tables and order by date in descending order

$result = mysqli_query($con, $query);
while ($row = $result->fetch_assoc()) {
   
    echo "<tr>";

    echo "<td class='hedlines green1'>" . $row["date"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["user_id"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["holder_name"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["bankname"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["account_number"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["ifsc_code"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["amount"] . "</td>";

    echo "</tr>";
}

echo "</table>";

?>