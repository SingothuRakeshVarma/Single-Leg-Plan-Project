<?php
include('./header.php');
include('../connect.php');
$user_id = $_SESSION['user_id'];



// echo "SLP Tables: $slp_tables";
// echo "User ID: $user_id";
?>

<style>
    th,
    td {
        border: 1px solid white;
        padding: 8px;
        text-align: left;
        color: darkcyan;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }

    .pagination button {
        margin: 0 5px;
        padding: 5px 10px;
        border: 1px solid #ccc;
        background-color: #fff;
        cursor: pointer;
    }

    .pagination button.active {
        background-color: #ddd;
    }



    .imagview {
        width: 100px;
        height: 100px;
    }

    h2 {
        color: darkcyan;
    }

    table {
        border-collapse: collapse;
        width: 80%;
        text-align: center;
        margin: auto;
    }

    th,
    td {
        border: 1px solid white;
        padding: 8px;
        text-align: left;
        color: darkcyan;
    }

    .table-container {
        overflow-x: auto;
        /* Enable horizontal scrolling */
        max-width: 100%;
        /* Prevent the table from expanding beyond the container */
        border: 1px solid transparent;
        /* Optional: Add border around the table container */
    }


    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }

    .pagination button {
        margin: 0 5px;
        padding: 5px 10px;
        border: 1px solid #ccc;
        background-color: #fff;
        cursor: pointer;
    }

    .pagination button.active {
        background-color: #ddd;
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

    .imagview {
        width: 100px;
        height: 100px;
    }

    h2 {
        color: darkcyan;
    }

    /* Fixed header styles */
    thead tr {
        position: sticky;
        top: 0;
        background-color: transparent;
        /* Background color for the header */
        z-index: 1;
        /* Ensure the header stays above the table content */
    }
</style>


<CENTER><br><br>
    <h2>USER FLOOR DATA TABLE</h2>
</CENTER><br><br>

<div class="table-container">
    <table id="myTable">
        <thead>
            <tr>
                <th>SI NO</th>
                <th>Floor Name</th>
                <th>Floor ID</th>
                <th>User Name</th>
                <th>Active Date</th>
                <th>Expiry Date</th>
                <th>SLP Income</th>
                <th>Floor Income</th>
                <th>Floor Validity</th>
                <th>Status</th>


            </tr>
        </thead>


</div>

<?php



include('../connect.php');
$si_no = 1; // Initialize the SI NO counter

// Assuming you have a PDO connection instance in $pdo
// Prepare the SQL query
// Assuming $user_id is the starting user_id and you want to fetch the next 50 users
$query = "
                SELECT 'Floor 1' AS floor_name, floor_id, user_id, user_name, active_status, active_date, floor_vaility, expariy_date, income, floor_income, floor_users_count 
FROM floor_1_table WHERE user_id = ? 
UNION ALL
SELECT 'Floor 2' AS floor_name, floor_id, user_id, user_name, active_status, active_date, floor_vaility, expariy_date, income, floor_income,floor_users_count 
FROM floor_2_table WHERE user_id = ? 
UNION ALL
SELECT 'Floor 3' AS floor_name, floor_id, user_id, user_name, active_status, active_date, floor_vaility, expariy_date, income, floor_income,floor_users_count 
FROM floor_3_table WHERE user_id = ? 
UNION ALL
SELECT 'Floor 4' AS floor_name, floor_id, user_id, user_name, active_status, active_date, floor_vaility, expariy_date, income, floor_income,floor_users_count 
FROM floor_4_table WHERE user_id = ? 
UNION ALL
SELECT 'Floor 5' AS floor_name, floor_id, user_id, user_name, active_status, active_date, floor_vaility, expariy_date, income, floor_income,floor_users_count 
FROM floor_5_table WHERE user_id = ? 
UNION ALL
SELECT 'Floor 6' AS floor_name, floor_id, user_id, user_name, active_status, active_date, floor_vaility, expariy_date, income, floor_income,floor_users_count 
FROM floor_6_table WHERE user_id = ? ORDER BY active_date";


$stmt = $con->prepare($query);

// Check if the statement was prepared successfully
if ($stmt === false) {
    die("Error preparing statement: " . $con->error);
}

// Bind the parameter for all six subqueries
$stmt->bind_param('ssssss', $user_id, $user_id, $user_id, $user_id, $user_id, $user_id);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch the results as an associative array
$results = $result->fetch_all(MYSQLI_ASSOC);

// Now you can work with the $results array
$si_no = 1; // Initialize the serial number counter
foreach ($results as $row) {
    echo "<tr>";
    echo "<td class='hedlines green1'>" . $si_no  . "</td>";
    echo "<td class='hedlines green1'>" . $row['floor_name'] . "</td>";
    echo "<td class='hedlines green1'>" . $row["floor_id"]  . "</td>";
    echo "<td class='hedlines green1'>" . $row["user_name"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["active_date"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["expariy_date"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["income"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["floor_income"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["floor_vaility"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["active_status"] . "</td>";
    echo "</tr>";
    $si_no++; // Increment the counter
}

?>
</tbody>
</table>
</div>
<br><br><br><br><br><br>";


<script>
    function slpNameTop(value) {
        if (value) {
            window.location.href = 'slp_report.php?name=' + value; // Change 'id' to 'name'
        }
    }
</script>