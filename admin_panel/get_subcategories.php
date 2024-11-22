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
$sql = "SELECT DISTINCT sub_category FROM category_master WHERE category = ?";

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
echo '<option value="">Select sub_category</option>';
foreach ($rows as $row) {
    $sub_category = htmlspecialchars($row['sub_category']);
    echo '<option value="' . $sub_category . '">' . $sub_category . '</option>';
}
?>