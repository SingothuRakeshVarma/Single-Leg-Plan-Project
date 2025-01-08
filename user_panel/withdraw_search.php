<?php
                include('../connect.php');
                session_start();

                $si_no = 1; // Initialize the SI NO counter

                // Determine if a search was performed
                if (isset($_GET['start_date'] ) && isset($_GET['end_date'])) {
                    // Ensure session is started


                    // Get and sanitize input
                    $start_date = $_GET['start_date'];
                    $end_date = $_GET['end_date'];
                    $user_id = $_SESSION['user_id']; // Make sure this is sanitized

                    // Validate dates

                    // Database connection (assuming $con is your database connection)
                    // $con = mysqli_connect("host", "username", "password", "database");

                    // Pagination variables
                    $rowsPerPage = 300; // Number of records per page
                    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
                    $currentPage = max(1, $currentPage); // Ensure current page is at least 1
                    $offset = ($currentPage - 1) * $rowsPerPage; // Calculate offset for the query

                    // Fetch total record count
                    $countQuery = "SELECT COUNT(*) AS total_count FROM withdraws WHERE user_id = ? AND wdate BETWEEN ? AND ?";
                    $stmt = $con->prepare($countQuery);
                    $stmt->bind_param("sii", $user_id, $start_date, $end_date);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $count = $result->fetch_assoc();
                    $total_records = $count['total_count'];

                    $totalPages = ceil($total_records / $rowsPerPage); // Total number of pages
                    $currentPage = min($totalPages, max(1, $currentPage)); // Ensure current page is within bounds


                    // Fetch records with pagination
                    $sql = "SELECT * FROM withdraws WHERE user_id = ? AND wdate BETWEEN ? AND ? ORDER BY wdate desc LIMIT ?, ?";
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param("sssii", $user_id, $start_date, $end_date, $offset, $rowsPerPage);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $user_id = $row["user_id"];

                        echo "<tr>";
                        echo "<td class='hedlines green1'>" . $si_no  . "</td>";
                        echo "<td class='hedlines green1'>" . $row["wdate"] . "</td>";
                        echo "<td class='hedlines green1'>" . $user_id  . "</td>";
                        echo "<td class='hedlines green1'>" . $row["w_amount"] . "</td>";
                        echo "<td class='hedlines green1'>" . $row["tds"] . " </td>";
                        echo "<td class='hedlines green1'>" . $row["admin_charges"] . "</td>";
                        echo "<td class='hedlines green1'>" . $row["fund_transfer_charge"] . "</td>";
                        echo "<td class='hedlines green1'>" . $row["other"] . "</td>";
                        echo "<td class='hedlines green1'>" . $row["wto_user_id"] . "</td>";
                        echo "<td class='hedlines green1'>" . $row["wstatus"] . "</td>";
                        echo "<td class='hedlines green1'>" . $row["status"] . "</td>";
                        echo "<td class='hedlines green1'>" . $row["w_balance"] . "</td>";
                        echo "</tr>";
                        $si_no++; // Increment the counter
                    }

                    // Free result set
                    mysqli_free_result($result);

                    // Close connection
                    mysqli_close($con);
                }
                ?>