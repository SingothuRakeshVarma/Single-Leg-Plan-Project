<?php
include('./header.php');
include('../connect.php');
$user_id = $_SESSION['user_id'];

if (isset($_GET['name'])) {
    $slp_tables = $_GET['name'];
} else {
    $slp_tables = "slp_1_table"; // Default value
}



switch ($slp_tables) {
    case 'slp_1_table':

        $slp_type = 'floor - 1';
        $floor_table = 'floor_1_table';


        break;
    case 'slp_2_table':

        $slp_type = 'floor - 2';
        $floor_table = 'floor_2_table';

        break;
    case 'slp_3_table':

        $slp_type = 'floor - 3';
        $floor_table = 'floor_3_table';

        break;
    case 'slp_4_table':

        $slp_type = 'floor - 4';
        $floor_table = 'floor_4_table';

        break;
    case 'slp_5_table':

        $slp_type = 'floor - 5';
        $floor_table = 'floor_5_table';

        break;
    case 'slp_6_table':

        $slp_type = 'floor - 6';
        $floor_table = 'floor_6_table';

        break;
    default:
        echo "Invalid floor selection.";
        exit;
}

$query = "SELECT * FROM slp_master WHERE floor_name = '$slp_type'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$user_limit = $row['add_mumbers'];

$query = "SELECT * FROM $floor_table WHERE user_id = '$user_id' AND active_status = 'Active'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$floor_id = $row['floor_id'];

// echo "$floor_id . </br>";
// echo "$floor_table . </br>";

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

    th {
        color: greenyellow;
    }

    .table-container {
        overflow-x: auto;
        /* Enable horizontal scrolling */
        max-width: 100%;
        /* Prevent the table from expanding beyond the container */
        border: 1px solid #ccc;
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


<CENTER><br>
    <h2>USER SLP DATA TABLE</h2>
</CENTER><br><br>

<h id="floor-heading" style="font-size: 30px; color: white;">SLP</h><samp>
    <select name="floor" id="floor" style="font-size: 20px; color: black; font-weight: bold;" onchange="slpNameTop(this.value)">
        <option value="">Select Floor Name</option>
        <option value="slp_1_table">SLP 1</option>
        <option value="slp_2_table">SLP 2</option>
        <option value="slp_3_table">SLP 3</option>
        <option value="slp_4_table">SLP 4</option>
        <option value="slp_5_table">SLP 5</option>
        <option value="slp_6_table">SLP 6</option>
    </select>
    <script>
        function slpNameTop(value) {
            if (value) {
                window.location.href = 'slp_report.php?name=' + value; // Change 'id' to 'name'
            }
        }
    </script>
</samp>
<div><br>
    <table id="myTable">
        <thead>
            <tr>
                <th>SI NO</th>
                <th>User ID</th>
                <th>User FLOOR ID</th>


            </tr>
        </thead>


</div>

<?php



include('../connect.php');
$si_no = 1; // Initialize the SI NO counter


    // User ID to start fetching from
    // echo "Floor Name: $slp_tables<br>";
    // echo "Floor ID : $floor_id <br>";

    // Prepare the SQL statement
   // Prepare the query using prepared statements to prevent SQL injection
$query = "SELECT * FROM $slp_tables WHERE floor_id > ? ORDER BY si_no ASC LIMIT ?";
$stmt = $con->prepare($query);
$stmt->bind_param("si", $floor_id, $user_limit); // Assuming both floor_id and user_limit are integers
$stmt->execute();
$results = $stmt->get_result();

// Check if results are found
if ($results->num_rows > 0) {
    $si_no = 1; // Initialize the serial number counter
    while ($row = $results->fetch_assoc()) {
        $user_id = $row["user_id"]; // Assuming user_id is a column in your table

        echo "<tr>";
        echo "<td class='hedlines green1'>" . htmlspecialchars($si_no) . "</td>";
        echo "<td class='hedlines green1'>" . htmlspecialchars($user_id) . "</td>";
        echo "<td class='hedlines green1'>" . htmlspecialchars($row["floor_id"]) . "</td>"; // Use htmlspecialchars to prevent XSS
        echo "</tr>";
        $si_no++; // Increment the counter
    }
} else {
    echo "<tr><td colspan='3' class='hedlines green1'>No results found.</td></tr>"; // Handle no results case
}
?>
</tbody>
</table>
</div>
<br><br><br><br><br><br>";