<?php
// Query to select data from the database
include('../connect.php');
include('user_header.php');


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
        padding: 1vw 4.5vw;

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
            <input type="date" id="from_date" name="from_date"></br></br>
            <label for="to_date">To Date&nbsp;&nbsp;&nbsp;&nbsp; :</label>
            <input type="date" id="to_date" name="to_date">
            <input type="submit" name="filter" value="Filter">
        </form>
    </div></br>
</body>

</html>
<?php
// ... (rest of the code remains the same)

if (isset($_POST['filter'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    $query = "SELECT * FROM `product_delivery` WHERE user_id = ? AND date BETWEEN ? AND ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "sss", $user_id, $from_date, $to_date);
} else {
    $query = "SELECT * FROM `product_delivery` WHERE user_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $user_id);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Display data in a table
echo "<table class='cantainer'>";
echo "<center><h1 class='hline'>Delivery Report</h1></center>";
echo "<tr>";
echo "<th class='hedlines red1'>Product ID</th>";
echo "<th class='hedlines red1'>Product Name</th>";
echo "<th class='hedlines red1'>Courier Name</th>";
echo "<th class='hedlines red1'>Courier ID</th>";
echo "<th class='hedlines red1'>Addres</th>";
echo "<th class='hedlines red1'><center>Status</center></th>";
echo "</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row["product_id"];
    echo "<tr>";
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