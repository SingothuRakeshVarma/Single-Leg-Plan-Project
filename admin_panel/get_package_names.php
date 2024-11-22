<?php
// Configuration
$host = "localhost";
$username = "trcelioe_realvisinewebsite";
$password = "Realvisine";
$database = "trcelioe_user_data";

$con = new mysqli($host, $username, $password, $database);


if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Get category from GET request
$q = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING);

// Prepare SQL query
$sql = "SELECT DISTINCT pkorpd_name FROM category_master WHERE sub_category = ?";

// Prepare statement
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $q); // bind as string

// Execute query
$stmt->execute();

// Get result
$result = $stmt->get_result();

// Fetch all rows
$rows = $result->fetch_all(MYSQLI_ASSOC);

// Close statement and connection
$stmt->close();
$con->close();

// Output options
echo '<option value="">Select Product Name</option>';
foreach ($rows as $row) {
    $pkorpd_name = htmlspecialchars($row['pkorpd_name']); // use htmlspecialchars to prevent XSS
    echo '<option value="' . $pkorpd_name . '">' . $pkorpd_name . '</option>';
}
?>