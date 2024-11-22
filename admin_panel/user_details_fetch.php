<?php
include('../connect.php');

if (isset($_GET['id'])) {
  $userId = $_GET['id'];

  $stmt = $con->prepare("SELECT * FROM users WHERE userid = ?");
  $stmt->bind_param("s", $userId);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
  }
} else {
  echo json_encode(['error' => 'Invalid request']);
}

$con->close();
?>