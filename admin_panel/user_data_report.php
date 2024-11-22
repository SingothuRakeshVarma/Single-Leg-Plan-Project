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
        overflow-x: auto; /* Enable horizontal scrolling */
        max-width: 100%; /* Prevent the table from expanding beyond the container */
        border: 1px solid #ccc; /* Optional: Add border around the table container */
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
        background-color: transparent; /* Background color for the header */
        z-index: 1; /* Ensure the header stays above the table content */
    }
</style>


<CENTER>
    <h2>USER DATA</h2>
</CENTER><br><br>
<form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="text" name="search" placeholder="Search by name or user ID" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <input type="submit" name="Search" value="Search">
</form><br>
<div class="table-container">
<table id="myTable">
    <thead>
        <tr>
            <th>SI NO</th>
            <th>User ID</th>
            <th>User Name</th>
            <th>Mobile Number</th>
            <th>Password</th>
            <th>T-Password</th>
            <th>Referral ID</th>
            <th>Referral Name</th>
            <th>Bank Details</th>
            <th>Addres</th>
            <th>Joining Date</th>

        </tr>
    </thead>
    <tbody>
        <?php
        include('../connect.php');

        $si_no = 1; // Initialize the SI NO counter

        // Determine if a search was performed
        if (isset($_GET['search'])) {
            $search = mysqli_real_escape_string($con, $_GET['search']);

            // Fetch total record count
            $sql = "SELECT COUNT(*) AS total_count FROM user_data WHERE user_name LIKE '%$search%' OR user_id LIKE '%$search%'";
            $result = mysqli_query($con, $sql);
            $count = mysqli_fetch_assoc($result);
            $total_records = $count['total_count'];

            // // Pagination variables
            // $rowsPerPage = 5;
            // // $totalPages = ceil($total_records / $rowsPerPage); // Total number of pages
            // $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            // $offset = ($page - 1) * $rowsPerPage;

            // Pagination variables
            // Pagination variables
            $rowsPerPage = 5; // Number of records per page
            // $totalPages = ceil($total_records / $rowsPerPage); // Total number of pages
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
            // $currentPage = max(1, min($totalPages, $currentPage)); // Ensure current page is within bounds
            $offset = ($currentPage - 1) * $rowsPerPage; // Calculate offset for the query


            // Modify the query to include the search condition
            $query = "SELECT * FROM `user_data` WHERE user_name LIKE '%$search%' OR user_id LIKE '%$search%' LIMIT $offset, $rowsPerPage"; // SQL query with pagination and search

            $result = mysqli_query($con, $query);
            while ($row = $result->fetch_assoc()) {
                $user_id = $row["user_id"];
                $bank_details = $row["bankname"] . "<br>" . $row["account_number"] . "<br>" . $row["ifsc_code"] . "<br>" . $row["holder_name"];
                $address = $row["addres"] . "<br>" . $row["district"] . "<br>" . $row["state"] . "<br>" . $row["pincode"];
    
                echo "<tr>";
                echo "<td class='hedlines green1'>" . $si_no  . "</td>";
                echo "<td class='hedlines green1'>" . $user_id  . "</td>";
                echo "<td class='hedlines green1'>" . $row["user_name"] . "</td>";
                echo "<td class='hedlines green1'>" . $row["phone_number"] . "</td>";
                echo "<td class='hedlines green1'>" . $row["password"] . "</td>";
                echo "<td class='hedlines green1'>" . $row["tpassword"] . " </td>";
                echo "<td class='hedlines green1'>" . $row["referalid"] . "</td>";
                echo "<td class='hedlines green1'>" . $row["referalname"] . "</td>";
                echo "<td class='hedlines green1'>" . $bank_details . "</td>";
                echo "<td class='hedlines green1'>" . $address . " </td>";
                echo "<td class='hedlines green1'>" . $row["joining_date"] . " </td>";
                echo "</tr>";
                $si_no++; // Increment the counter
            }
    
            // Free result set
            mysqli_free_result($result);
    
            // Close connection
            mysqli_close($con);
    
        } else {
            include('../connect.php');
            $si_no = 1; // Initialize the SI NO counter
            // Fetch total record count
            $sql = "SELECT COUNT(*) AS total_count FROM user_data";
            $result = mysqli_query($con, $sql);
            $count = mysqli_fetch_assoc($result);
            $total_records = $count['total_count'];

            // Pagination variables
            $rowsPerPage = 5; // Number of records per page
            $totalPages = ceil($total_records / $rowsPerPage); // Total number of pages
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
            $currentPage = max(1, min($totalPages, $currentPage)); // Ensure current page is within bounds
            $startIndex = ($currentPage - 1) * $rowsPerPage; // Calculate the starting record index

            $query = "SELECT * FROM `user_data` LIMIT $startIndex, $rowsPerPage"; // SQL query with pagination

        

            $result = mysqli_query($con, $query);
            while ($row = $result->fetch_assoc()) {
                $user_id = $row["user_id"];
                $bank_details = $row["bankname"] . "<br>" . $row["account_number"] . "<br>" . $row["ifsc_code"] . "<br>" . $row["holder_name"];
                $address = $row["addres"] . "<br>" . $row["district"] . "<br>" . $row["state"] . "<br>" . $row["pincode"];
    
                echo "<tr>";
                echo "<td class='hedlines green1'>" . $si_no  . "</td>";
                echo "<td class='hedlines green1'>" . $user_id  . "</td>";
                echo "<td class='hedlines green1'>" . $row["user_name"] . "</td>";
                echo "<td class='hedlines green1'>" . $row["phone_number"] . "</td>";
                echo "<td class='hedlines green1'>" . $row["password"] . "</td>";
                echo "<td class='hedlines green1'>" . $row["tpassword"] . " </td>";
                echo "<td class='hedlines green1'>" . $row["referalid"] . "</td>";
                echo "<td class='hedlines green1'>" . $row["referalname"] . "</td>";
                echo "<td class='hedlines green1'>" . $bank_details . "</td>";
                echo "<td class='hedlines green1'>" . $address . " </td>";
                echo "<td class='hedlines green1'>" . $row["joining_date"] . " </td>";
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
   
   echo" <button onclick='nextPage()'>Next</button>
</div><br><br><br>";
        }
?>

<script>
    const rowsPerPage = 5;
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
        fetch(`table.php?page=${page}`) // Adjust the URL to your PHP script
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