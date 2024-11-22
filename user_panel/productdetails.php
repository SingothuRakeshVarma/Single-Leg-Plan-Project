<?php
// Connect to the database
$conn = new mysqli("localhost", "trcelioe_realvisinewebsite", "Realvisine", "trcelioe_user_data");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get category from GET request
$q = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING);

// Prepare SQL query
$sql = "SELECT DISTINCT * FROM cartdata WHERE packagename = ? AND packageorproduct = 'package'";

// Prepare statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $q); // bind as string

// Execute query
$stmt->execute();

// Get result
$result = $stmt->get_result();

// Fetch all rows
$rows = $result->fetch_all(MYSQLI_ASSOC);

$productDetails = array();

// Loop through the rows and display the data
foreach ($rows as $row) {
    $productDetails[] = array(
        'packageamount' => $row['dp'],
        'cashbackamount' => $row['cashbackamount'],
        'packagealgibulity' => $row['packagealgibulity'],
        'productcode' => $row['productcode'],
        'type' => $row['packageorproduct'],
        'product_cashback_amount' => $row['cashbackamount'],
        'product_amount' => $row['dp'],
        'product_name' => $row['packagename']
    );
}

// Close statement and connection
$stmt->close();
$conn->close();

echo json_encode($productDetails[0]); // Return the first row as JSON
?>