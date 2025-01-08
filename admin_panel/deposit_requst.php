<?php
include('./header.php');
include('../connect.php');




if (isset($_GET['accept']) && isset($_GET['checkbox'])) {
    foreach ($_GET['checkbox'] as $user_id) {

        // Prepare the SQL statement to get the total amount of processing deposits
        $stmt = $con->prepare("SELECT SUM(amount) as total_amount FROM deposit WHERE user_id = ? AND status = 'Processing'");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the total amount
        $total_amount = 0;
        if ($row = $result->fetch_assoc()) {
            $total_amount = $row['total_amount'] ? $row['total_amount'] : 0; // Handle case where no deposits are found
        }

        if ($total_amount > 0) {
            // Fetch user wallet details
            $query = "SELECT * FROM user_wallet WHERE user_id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $wallet_balance = $row['wallet_balance'];
                $wallet = $row['net_wallet'];

                // Calculate new wallet balances
                $new_wallet_balance = $wallet_balance + $total_amount;
                $new_wallet = $wallet + $total_amount;

                // Update wallet balances
                $update_query = "UPDATE user_wallet SET wallet_balance = ?, net_wallet = ? WHERE user_id = ?";
                $update_stmt = $con->prepare($update_query);
                $update_stmt->bind_param("dds", $new_wallet_balance, $new_wallet, $user_id); // d for double

                if ($update_stmt->execute()) {
                    // echo "Wallet balances updated successfully!";
                } else {
                    echo "Failed to update wallet balances: " . $update_stmt->error;
                }

                // Update deposit request status
                $query = "UPDATE deposit SET t_balance = ?, status = 'accepted' WHERE user_id = ? AND status = 'Processing'";
                $stmt = $con->prepare($query);
                $stmt->bind_param("ds", $new_wallet_balance, $user_id);
                $stmt->execute();
echo '             
                 <div class="alert-box">
                     <div class="success-circle active">
                         <div class="checkmark"></div>
                     </div>
                     <p class="new_record">User successfully Deposited.</p>
                     <p>User Id : ' . $user_id . '</p>
                     <p>USDTS : ' . $total_amount . '</p>
                     
                    
                     <button onclick="window.location.href = \'deposit_requst.php\';">OK</button>
                 </div>';
                // echo "<script>alert('Deposit Accepted Successfully');window.location.href='deposit_requst.php';</script>";
            } 
        } 
    }
}

if (isset($_GET['reject']) && isset($_GET['checkbox']) && isset($_GET['reason'])) {
    $reason = $_GET['reason'];
    foreach ($_GET['checkbox'] as $user_id) {
        // Update deposit request status to rejected
        $query = "UPDATE deposit SET status = 'rejected', reson = ? WHERE user_id = ? AND status = 'processing'";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ss", $reason, $user_id);
        $stmt->execute();
        echo "<script>alert('Deposit Rejected Successfully');window.location.href='deposit_requst.php';</script>";
    }
   
}





?>

<style>
.alert-box {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            width: 300px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 100;
            /* Ensure alert box is on top */
        }

        .success-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 5px solid #4CAF50;
            /* Green circle */
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            /* Center the circle */

        }

        .checkmark {
            display: none;
            /* Initially hidden */
            position: relative;
            width: 20px;
            height: 20px;
        }

        .checkmark:before {
            content: "";
            position: absolute;
            width: 15px;
            height: 5px;
            background: #4CAF50;
            top: 12px;
            left: -5px;
            transform: rotate(45deg);
        }

        .checkmark:after {
            content: "";
            position: absolute;
            width: 5px;
            height: 31px;
            background: #4CAF50;
            top: -5px;
            left: 15px;
            transform: rotate(45deg);
        }

        .success-circle.active .checkmark {
            display: block;
            /* Show checkmark when active */
        }

        button {
            background-color: #4CAF50;
            /* Green */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
            /* Darker green on hover */
        }

        .new_record {
            font-weight: bold;
            color: darkgreen;
        }
    table {
        border-collapse: collapse;
        width: 100%;
        text-align: center;
    }

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

    table {
        border-collapse: collapse;
        width: 100%;
        text-align: center;
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
        padding: 0.3vw 2vw;
        margin-left: 0.3vw;
        position: relative;
        left: 10px;
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
    <h2>DEPOSIT REPORT TABLE</h2>
    <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="date" name="start_date" placeholder="Start Date" value="<?php echo isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : ''; ?>">
        <input type="date" name="end_date" placeholder="End Date" value="<?php echo isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : ''; ?>">
        <input type="submit" name="search" value="Search">
    </form><br>
    <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="withdrawForm">
        <div class="table-container">
            <table id="myTable">
                <thead>
                    <tr>
                        <th>SI NO</th>
                        <th>Select</th>
                        <th>DATE</th>
                        <th>User ID</th>
                        <th>Amount</th>
                        <th>Trast Wallet ID</th>


                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../connect.php');

                    $si_no = 1; // Initialize the SI NO counter

                    // Determine if a search was performed
                    if (isset($_GET['search'])) {
                        // Ensure session is started


                        // Get and sanitize input
                        $start_date = $_GET['start_date'];
                        $end_date = $_GET['end_date'];
                        $user_id = $_SESSION['user_id']; // Make sure this is sanitized

                        // Validate dates
                        if ($start_date !== '' && $end_date !== '') {
                            // Database connection (assuming $con is your database connection)
                            // $con = mysqli_connect("host", "username", "password", "database");

                            // Pagination variables
                            $rowsPerPage = 20; // Number of records per page
                            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
                            $offset = ($currentPage - 1) * $rowsPerPage; // Calculate offset for the query

                            // Fetch total record count
                            $countQuery = "SELECT COUNT(*) AS total_count FROM deposit WHERE status = 'Processing' AND ddate BETWEEN ? AND ?";
                            $stmt = $con->prepare($countQuery);
                            $stmt->bind_param("sss", $user_id, $start_date, $end_date);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $count = $result->fetch_assoc();
                            $total_records = $count['total_count'];

                            // Fetch records with pagination
                            $sql = "SELECT * FROM deposit WHERE status = 'Processing' AND  ddate BETWEEN ? AND ? ORDER BY ddate LIMIT ?, ?";
                            $stmt = $con->prepare($sql);
                            $stmt->bind_param("sssii", $user_id, $start_date, $end_date, $offset, $rowsPerPage);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {
                                $user_ids = $row["user_id"];

                                echo "<tr>";
                                echo "<td class='hedlines green1'>" . $si_no  . "</td>";
                                echo "<td class='hedlines green1'><input type='checkbox' name='checkbox[]' value='" . $user_ids . "'></td>";
                                echo "<td class='hedlines green1'>" . $row["ddate"] . "</td>";
                                echo "<td class='hedlines green1'>" . $user_ids  . "</td>";
                                echo "<td class='hedlines green1'>" . $row["amount"] . "</td>";
                                echo "<td class='hedlines green1'>" . $row["utr_number"] . "</td>";


                                echo "</tr>";
                                $si_no++; // Increment the counter
                            }

                            // Free result set
                            mysqli_free_result($result);

                            // Close connection
                            mysqli_close($con);
                        } else {
                            // Fetch total record count
                            include('../connect.php');
                            $si_no = 1; // Initialize the SI NO counter
                            // Fetch total record count
                            $sql = "SELECT COUNT(*) AS total_count FROM deposit WHERE status = 'Processing'";
                            $result = mysqli_query($con, $sql);
                            $count = mysqli_fetch_assoc($result);
                            $total_records = $count['total_count'];

                            // Pagination variables
                            $rowsPerPage = 20; // Number of records per page
                            $totalPages = ceil($total_records / $rowsPerPage); // Total number of pages
                            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
                            $currentPage = max(1, min($totalPages, $currentPage)); // Ensure current page is within bounds
                            $startIndex = ($currentPage - 1) * $rowsPerPage; // Calculate the starting record index

                            $query = "SELECT * FROM `deposit` WHERE status = 'Processing'  LIMIT $startIndex, $rowsPerPage"; // SQL query with pagination



                            $result = mysqli_query($con, $query);
                            while ($row = $result->fetch_assoc()) {
                                $user_ids = $row["user_id"];

                                echo "<tr>";
                                echo "<td class='hedlines green1'>" . $si_no  . "</td>";
                                echo "<td class='hedlines green1'><input type='checkbox' name='checkbox[]' value='" . $user_ids . "'></td>";
                                echo "<td class='hedlines green1'>" . $row["ddate"] . "</td>";
                                echo "<td class='hedlines green1'>" . $user_ids  . "</td>";
                                echo "<td class='hedlines green1'>" . $row["amount"] . "</td>";
                                echo "<td class='hedlines green1'>" . $row["utr_number"] . "</td>";


                                echo "</tr> ";
                                $si_no++; // Increment the counter

                            }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="pagination">
            <button onclick="previousPage()">Previous</button>
        <?php

                            // Ensure $totalPages is at least 1
                            // if ($totalPages <= 0) {
                            //     $totalPages = 1; // Set to 1 if there are no pages
                            // }
                            // Generate pagination buttons
                            for ($i = 1; $i <= $totalPages; $i++) {
                                if ($i == $currentPage) {
                                    echo "<button class='active'>$i</button>"; // Current page button
                                } else {
                                    echo "<button onclick='goToPage($i)'>$i</button>"; // Other page buttons
                                }
                            }

                            echo " <button onclick='nextPage()'>Next</button>
        </div><br><br><br><br><br>";
                        }
                    } else {
                        include('../connect.php');
                        $si_no = 1; // Initialize the SI NO counter
                        // Fetch total record count
                        $sql = "SELECT COUNT(*) AS total_count FROM deposit WHERE status = 'Processing'";
                        $result = mysqli_query($con, $sql);
                        $count = mysqli_fetch_assoc($result);
                        $total_records = $count['total_count'];

                        // Pagination variables
                        $rowsPerPage = 25; // Number of records per page
                        $totalPages = ceil($total_records / $rowsPerPage); // Total number of pages
                        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
                        $currentPage = max(1, min($totalPages, $currentPage)); // Ensure current page is within bounds
                        $startIndex = ($currentPage - 1) * $rowsPerPage; // Calculate the starting record index

                        $query = "SELECT * FROM `deposit` WHERE status = 'Processing'  LIMIT $startIndex, $rowsPerPage"; // SQL query with pagination



                        $result = mysqli_query($con, $query);
                        while ($row = $result->fetch_assoc()) {
                            $user_ids = $row["user_id"];

                            echo "<tr>";
                            echo "<td class='hedlines green1'>" . $si_no  . "</td>";
                            echo "<td class='hedlines green1'><input type='checkbox' name='checkbox[]' value='" . $user_ids . "'></td>";
                            echo "<td class='hedlines green1'>" . $row["ddate"] . "</td>";
                            echo "<td class='hedlines green1'>" . $user_ids  . "</td>";
                            echo "<td class='hedlines green1'>" . $row["amount"] . "</td>";
                            echo "<td class='hedlines green1'>" . $row["utr_number"] . "</td>";


                            echo "</tr>";
                            $si_no++; // Increment the counter
                        }



        ?>
        </tbody>
        </table>
        </div>

        <input type='button' class='acclink' name='accept' onclick="acceptIds()" value='Accept'>
        <script>
            function acceptIds() {
                // Get all checkboxes with the name 'checkbox[]'
                var checkboxes = document.querySelectorAll('input[name="checkbox[]"]:checked');
                var selectedIds = [];

                // Loop through the checked checkboxes and get their values
                checkboxes.forEach(function(checkbox) {
                    selectedIds.push(checkbox.value);
                });

                // Create a hidden input to store selected IDs
                if (selectedIds.length > 0) {
                    var form = document.getElementById('withdrawForm');
                    var hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'accept';
                    hiddenInput.value = '1'; // Indicating acceptance
                    form.appendChild(hiddenInput);

                    // Append selected IDs to the form
                    selectedIds.forEach(function(id) {
                        var checkboxInput = document.createElement('input');
                        checkboxInput.type = 'hidden';
                        checkboxInput.name = 'checkbox[]';
                        checkboxInput.value = id;
                        form.appendChild(checkboxInput);
                    });

                    // Submit the form
                    form.submit();
                } else {
                    alert("Please select at least one checkbox.");
                }
            }
        </script>
        <!-- Button to trigger the modal -->
        <button type='button' class='rejlink' data-bs-toggle="modal" data-bs-target="#exampleModal8">
            Reject
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal8" tabindex="-1" aria-labelledby="exampleModalLabel8" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel8">Rejected Reason</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="reason" class="prof_label">Reason</label><br>
                        <input type="text" class="prof_text" name="reason" placeholder="Enter Reason" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-danger" name='reject' value="Reject">
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="pagination">
        <button onclick="previousPage()">Previous</button>
    <?php

                        // Ensure $totalPages is at least 1
                        // if ($totalPages <= 0) {
                        //     $totalPages = 1; // Set to 1 if there are no pages
                        // }
                        // Generate pagination buttons
                        for ($i = 1; $i <= $totalPages; $i++) {
                            if ($i == $currentPage) {
                                echo "<button class='active'>$i</button>"; // Current page button
                            } else {
                                echo "<button onclick='goToPage($i)'>$i</button>"; // Other page buttons
                            }
                        }

                        echo " <button onclick='nextPage()'>Next</button>
</div><br><br><br><br><br><br>";
                    }
    ?>

    <script>
        const rowsPerPage = 25;
        let currentPage = 1;
        let totalPages = <?php echo $totalPages; ?>; // Get total pages from PHP

        // Function to handle pagination button clicks
        function goToPage(page) {
            if (page < 1 || page > totalPages) return; // Ensure page is within bounds
            currentPage = page;
            fetchData(currentPage); // Fetch data for the current page
        }

        // Function to fetch data from the server
        function fetchData(page) {
            fetch(`deposit_request_table.php?page=${page}`) // Adjust the URL to your PHP script
                .then(response => response.text())
                .then(data => {
                    document.querySelector('#myTable tbody').innerHTML = data; // Update table body
                    updatePaginationButtons(); // Update pagination buttons
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        // Function to update the pagination buttons
        function updatePaginationButtons() {
            const paginationContainer = document.querySelector('.pagination');
            paginationContainer.innerHTML = ''; // Clear existing buttons

            // Add previous button
            const previousButton = document.createElement('button');
            previousButton.textContent = 'Previous';
            previousButton.onclick = () => goToPage(currentPage - 1);
            paginationContainer.appendChild(previousButton);

            // Add page buttons
            for (let i = 1; i <= totalPages; i++) {
                const button = document.createElement('button');
                button.textContent = i;
                button.onclick = () => goToPage(i);
                if (i === currentPage) {
                    button.classList.add('active'); // Highlight current page
                }
                paginationContainer.appendChild(button);
            }

            // Add next button
            const nextButton = document.createElement('button');
            nextButton.textContent = 'Next';
            nextButton.onclick = () => goToPage(currentPage + 1);
            paginationContainer.appendChild(nextButton);
        }

        // Initial fetch for the first page
        fetchData(currentPage);
    </script>