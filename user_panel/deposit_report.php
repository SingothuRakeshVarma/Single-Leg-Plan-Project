<?php
include('./header.php');
include('../connect.php');

?>

<style>
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
    <h2>DEPOSIT REPORT TABLE</h2>
    <div>
        <input type="date" name="start_date" placeholder="Start Date" id="startDate" value="<?php echo isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : ''; ?>">
        <input type="date" name="end_date" placeholder="End Date" id="endDate" value="<?php echo isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : ''; ?>">
        <input type="submit" name="search" id="dateSearchButton" value="Search">
    </div><br>
    <div class="table-container">
        <table id="myTable">
            <thead>
                <tr>
                    <th>SI NO</th>
                    <th>DATE</th>
                    <th>User ID</th>
                    <th>Amount</th>
                    <th>Trast Wallet ID</th>
                    <th>Resiver User ID</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Wallet Balance</th>

                </tr>
            </thead>
            <tbody>
                <?php
                include('../connect.php');
                $si_no = 1; // Initialize the SI NO counter
                // Fetch total record count
                $sql = "SELECT COUNT(*) AS total_count FROM deposit WHERE user_id = '$user_id'";
                $result = mysqli_query($con, $sql);
                $count = mysqli_fetch_assoc($result);
                $total_records = $count['total_count'];

                // Pagination variables
                $rowsPerPage = 25; // Number of records per page
                $totalPages = ceil($total_records / $rowsPerPage); // Total number of pages
                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
                $currentPage = max(1, min($totalPages, $currentPage)); // Ensure current page is within bounds
                $startIndex = ($currentPage - 1) * $rowsPerPage; // Calculate the starting record index

                $query = "SELECT * FROM `deposit` WHERE user_id = '$user_id' ORDER BY ddate LIMIT $startIndex, $rowsPerPage"; // SQL query with pagination



                $result = mysqli_query($con, $query);
                while ($row = $result->fetch_assoc()) {
                    $user_id = $row["user_id"];

                    echo "<tr>";
                    echo "<td class='hedlines green1'>" . $si_no  . "</td>";
                    echo "<td class='hedlines green1'>" . $row["ddate"] . "</td>";
                    echo "<td class='hedlines green1'>" . $user_id  . "</td>";
                    echo "<td class='hedlines green1'>" . $row["amount"] . "</td>";
                    echo "<td class='hedlines green1'>" . $row["utr_number"] . "</td>";
                    echo "<td class='hedlines green1'>" . $row["from_user_id"] . "</td>";
                    echo "<td class='hedlines green1'>" . $row["reson"] . "</td>";
                    echo "<td class='hedlines green1'>" . $row["status"] . "</td>";
                    echo "<td class='hedlines green1'>" . $row["t_balance"] . "</td>";
                    echo "</tr>";
                    $si_no++; // Increment the counter
                }



                ?>
            </tbody>
        </table>
    </div>
    <div class="pagination">
        <button onclick="previousPage()">Previous</button>
        <?php

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

        ?>
    </div>
</CENTER>


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

            // Function to handle date search
            function searchByDate() {
                const startDate = document.getElementById('startDate').value; // Get the start date
                const endDate = document.getElementById('endDate').value; // Get the end date

                // Construct the URL with the date parameters
                const url = `deposit_search.php?start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`;

                fetch(url) // Send the date range to the PHP script
                    .then(response => response.text())
                    .then(data => {
                        document.querySelector('#myTable tbody').innerHTML = data; // Update table body with search results
                        // Optionally, you can also update pagination buttons if needed
                    })
                    .catch(error => console.error('Error fetching date search results:', error));
            }

            // Event listener for the date search button
            document.getElementById('dateSearchButton').addEventListener('click', searchByDate);


            // Function to fetch data from the server
            function fetchData(page) {
                fetch(`deposit_table.php?page=${page}`) // Adjust the URL to your PHP script
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


            function updatePaginationButtons() {
                const paginationContainer = document.querySelector('.pagination');
                paginationContainer.innerHTML = ''; // Clear existing buttons

                // Add the "Previous" button
                const previousButton = document.createElement('button');
                previousButton.textContent = 'Previous';
                previousButton.onclick = () => goToPage(currentPage - 1);
                previousButton.disabled = currentPage === 1; // Disable if on the first page
                paginationContainer.appendChild(previousButton);

                const maxVisibleButtons = 5; // Number of buttons to show at a time
                let startPage = Math.max(1, currentPage - Math.floor(maxVisibleButtons / 2));
                let endPage = Math.min(totalPages, startPage + maxVisibleButtons - 1);

                // Adjust the range if near the start or end
                if (endPage - startPage + 1 < maxVisibleButtons) {
                    startPage = Math.max(1, endPage - maxVisibleButtons + 1);
                }

                // Add ellipsis before the first button if needed
                if (startPage > 1) {
                    const firstButton = document.createElement('button');
                    firstButton.textContent = '1';
                    firstButton.onclick = () => goToPage(1);
                    paginationContainer.appendChild(firstButton);

                    const ellipsis = document.createElement('span');
                    ellipsis.textContent = '...';
                    paginationContainer.appendChild(ellipsis);
                }

                // Add the main range of buttons
                for (let i = startPage; i <= endPage; i++) {
                    const button = document.createElement('button');
                    button.textContent = i;
                    button.onclick = () => goToPage(i);
                    if (i === currentPage) {
                        button.classList.add('active'); // Highlight the current page
                    }
                    paginationContainer.appendChild(button);
                }

                // Add ellipsis after the last button if needed
                if (endPage < totalPages) {
                    const ellipsis = document.createElement('span');
                    ellipsis.textContent = '...';
                    paginationContainer.appendChild(ellipsis);

                    const lastButton = document.createElement('button');
                    lastButton.textContent = totalPages;
                    lastButton.onclick = () => goToPage(totalPages);
                    paginationContainer.appendChild(lastButton);
                }

                // Add the "Next" button
                const nextButton = document.createElement('button');
                nextButton.textContent = 'Next';
                nextButton.onclick = () => goToPage(currentPage + 1);
                nextButton.disabled = currentPage === totalPages; // Disable if on the last page
                paginationContainer.appendChild(nextButton);
            }
        </script>