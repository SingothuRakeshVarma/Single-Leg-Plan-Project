<?php
include('../connect.php');
session_start();

$user_id = $_SESSION['user_id'];
$si_no = 1; // Initialize the SI NO counter
// Fetch total record count
$sql = "SELECT COUNT(*) AS total_count FROM withdraws ";
$result = mysqli_query($con, $sql);
$count = mysqli_fetch_assoc($result);
$total_records = $count['total_count'];

// Pagination variables
$rowsPerPage = 25;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $rowsPerPage;
 $query = "SELECT * FROM `withdraws` WHERE status = 'Processing' LIMIT $offset, $rowsPerPage"; // SQL query with pagination

                            $result = mysqli_query($con, $query);
                            while ($row = $result->fetch_assoc()) {
                                $user_ids = $row["user_id"];
                            
                                // Fetch trust_id and trust_qr from user_data based on user_id
                                $userDataQuery = "SELECT trust_id, trust_qr FROM user_data WHERE user_id = '$user_ids'";
                                $userDataResult = mysqli_query($con, $userDataQuery);
                                
                                // Initialize variables for trust_id and trust_qr
                                $trust_id = '';
                                $trust_qr = '';
                            
                                if ($userDataRow = $userDataResult->fetch_assoc()) {
                                    $trust_id = $userDataRow["trust_id"];
                                    $trust_qr = $userDataRow["trust_qr"];
                                }
                            
                                echo "<tr>";
                                echo "<td class='hedlines green1'>" . $si_no  . "</td>";
                                echo "<td class='hedlines green1'><input type='checkbox' name='checkbox[]' value='" . $user_ids . "'></td>";
                                echo "<td class='hedlines green1'>" . $row["wdate"] . "</td>";
                                echo "<td class='hedlines green1'>" . $row["user_id"]  . "</td>";
                                echo "<td class='hedlines green1'>" . $row["w_amount"] . "</td>";
                                echo "<td class='hedlines green1'>" . $row["wstatus"] . "</td>";
                                echo "<td class='hedlines green1'>" . $row["status"] . "</td>";
                                
                                // Display trust_id and trust_qr
                                echo "<td class='hedlines green1'>" . $trust_id . "</td>";
                                echo "<td class='hedlines green1'><img src='" . $trust_qr . "' width='100' height='100'></td>";
                            
                                echo "</tr> ";
                                $si_no++; // Increment the counter
                            }

// Free result set
mysqli_free_result($result);

// Close connection
mysqli_close($con)
?>