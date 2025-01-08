<?php
include('./header.php');
include('../connect.php');
$user_id = $_SESSION['user_id'];


if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $_SESSION['floor_users'] = $name;
    $floor_table  = $_SESSION['floor_users'];
}else{
    $floor_table  = $_SESSION['floor_users'] ?? 'floor_1_table';
}
switch ($floor_table) {
    case 'floor_1_table':
        
        $number = 1;


        break;
    case 'floor_2_table':
        
        $number = 2;

        break;
    case 'floor_3_table':
       
        $number = 3;

        break;
    case 'floor_4_table':
       
        $number = 4;

        break;
    case 'floor_5_table':
        
        $number = 5;

        break;
    case 'floor_6_table':
        
        $number = 6;

        break;
    default:
        echo "Invalid floor selection.";
        exit;
}
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

  

    h2,h3 {
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
    .form_container{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
    }
</style>


<CENTER><br><br>
    <h2>USER FLOORS DATA TABLE</h2>
    <h3>FLOOR NO : <?php echo $number ?></h3>
    </CENTER><br>
<div class="form_container">
<form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<select name="floor" id="floor" style="font-size: 20px; color: black; font-weight: bold;" onchange="floorNameTop(this.value)">
                <option value="">Select Floor</option>
                <option value="floor_1_table">Floor 1</option>
                <option value="floor_2_table">Floor 2</option>
                <option value="floor_3_table">Floor 3</option>
                <option value="floor_4_table">Floor 4</option>
                <option value="floor_5_table">Floor 5</option>
                <option value="floor_6_table">Floor 6</option>
            </select>
</form>
<form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="margin-left: 10px;">
    <input type="search" name="search" placeholder="Search by name or user ID" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <input type="submit" name="Search" value="Search">
</form><br>
</div><br>
<div class="table-container">
    <table id="myTable">
        <thead>
            <tr>
                <th>SI NO</th>
               
                <th>Floor ID</th>
                <th>User ID</th>
                <th>User Name</th>
                <th>Active Date</th>
                <th>Expiry Date</th>
                <th>Income</th>
                <th>Withdrow</th>
                <th>Add Members</th>
                <th>Floor Validity</th>
                <th>Status</th>


            </tr>
        </thead>


</div>

<?php



include('../connect.php');
$si_no = 1; // Initialize the SI NO counter
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM $floor_table WHERE user_name LIKE '%$search%' OR floor_id LIKE '%$search%' OR user_id LIKE '%$search%' ORDER BY active_date DESC";
    $result = mysqli_query($con, $sql);
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td class='hedlines green1'>" . $si_no  . "</td>";
        echo "<td class='hedlines green1'>" . $row['floor_id']  . "</td>";
        echo "<td class='hedlines green1'>" . $row['user_id']  . "</td>";
        echo "<td class='hedlines green1'>" . $row['user_name'] . "</td>";
        echo "<td class='hedlines green1'>" . $row['active_date'] . "</td>";
        echo "<td class='hedlines green1'>" . $row['expariy_date'] . "</td>";
        echo "<td class='hedlines green1'>" . $row['income'] . "</td>";
        echo "<td class='hedlines green1'>" . $row['withdraw'] . "</td>";
        echo "<td class='hedlines green1'>" . $row['floor_users_count'] . "</td>";
        echo "<td class='hedlines green1'>" . $row['floor_vaility'] . "</td>";
        echo "<td class='hedlines green1'>" . $row['active_status'] . "</td>";
        echo "</tr>";
        $si_no++; // Increment the counter
    }
} else {
    

// Assuming you have a PDO connection instance in $pdo
// Prepare the SQL query
// Assuming $user_id is the starting user_id and you want to fetch the next 50 users
$query = "SELECT * FROM $floor_table ORDER BY active_date DESC"; 
$result = mysqli_query($con, $query);
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td class='hedlines green1'>" . $si_no  . "</td>";
    echo "<td class='hedlines green1'>" . $row['floor_id']  . "</td>";
    echo "<td class='hedlines green1'>" . $row['user_id']  . "</td>";
    echo "<td class='hedlines green1'>" . $row['user_name'] . "</td>";
    echo "<td class='hedlines green1'>" . $row['active_date'] . "</td>";
    echo "<td class='hedlines green1'>" . $row['expariy_date'] . "</td>";
    echo "<td class='hedlines green1'>" . $row['income'] . "</td>";
    echo "<td class='hedlines green1'>" . $row['withdraw'] . "</td>";
    echo "<td class='hedlines green1'>" . $row['floor_users_count'] . "</td>";
    echo "<td class='hedlines green1'>" . $row['floor_vaility'] . "</td>";
    echo "<td class='hedlines green1'>" . $row['active_status'] . "</td>";
    echo "</tr>";
    $si_no++; // Increment the counter
}
}
?>
</tbody>
</table>
</div>
<br><br><br><br><br><br>";


<script>
    function floorNameTop(value) {
        if (value) {
            window.location.href = 'floor_report.php?name=' + value; // Change 'id' to 'name'
        }
    }
</script>