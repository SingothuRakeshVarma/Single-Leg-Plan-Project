<?php
// Connect to the database
// $conn = mysqli_connect("localhost", "trcelioe_success_slp", "success_slp", "trcelioe_success_slp");
$conn = mysqli_connect("localhost", "root", "", "success_slp");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get category from GET request
$q = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING);

// Prepare SQL query
$sql = "SELECT total, validity_days, floor_id FROM floor_master WHERE floor_name = ?";

// Prepare statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $q); // bind as string

// Execute query
$stmt->execute();

// Get result
$result = $stmt->get_result();

// Fetch the row
$productDetails = $result->fetch_assoc();

// Close statement and connection
$stmt->close();
$conn->close();

// Return JSON response
if ($productDetails) {
    echo json_encode(array(
        'flooramount' => $productDetails['total'],
        'flooralgibulity' => $productDetails['validity_days'],
        'productcode' => $productDetails['floor_id']
    ));
} else {
    echo json_encode(array(
        'flooramount' => '',
        'flooralgibulity' => '',
        'productcode' => ''
    ));
}
?>