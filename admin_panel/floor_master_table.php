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

th, td {
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
    .imagview{
        width: 100px;
        height: 100px;
    }
    h2{
        color: darkcyan;
    }
</style>


<CENTER><h2>PACKAGE MASTER</h2></CENTER>

<table id="myTable">
  <thead>
    <tr>
      <th>SI NO</th>
      <th>Floor ID</th>
      <th>Floor Name</th>
      <th>Floor Price</th>
      <th>Floor Booking Fees</th>
      <th>Floor Total</th>
      <th>SLP Count</th>
      <th>SLP Day Share</th>
      <th>Floor Validity Days</th>
      <th>Status</th>
      
    </tr>
  </thead>
  <tbody>
    <?php
    include('../connect.php');
    $si_no = 1; // Initialize the SI NO counter
  // Fetch total record count
  $sql = "SELECT COUNT(*) AS total_count FROM floor_master";
  $result = mysqli_query($con, $sql);
  $count = mysqli_fetch_assoc($result);
  $total_records = $count['total_count'];
  
  // Pagination variables
  $rowsPerPage = 5; // Number of records per page
  $totalPages = ceil($total_records / $rowsPerPage); // Total number of pages
  $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
  $currentPage = max(1, min($totalPages, $currentPage)); // Ensure current page is within bounds
  $startIndex = ($currentPage - 1) * $rowsPerPage; // Calculate the starting record index

$query = "SELECT * FROM `floor_master` WHERE  `floor_name` !=''";

$result = mysqli_query($con, $query);
while ($row = $result->fetch_assoc()) {
    $floor_id = $row["floor_id"];
    
    echo "<tr>";
    echo "<td class='hedlines green1'>" . $si_no  . "</td>";
  echo "<td class='hedlines green1'>" . $floor_id  . "</td>";
    echo "<td class='hedlines green1'>" . $row["floor_name"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["floor_price"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["floor_booking_fees"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["total"] . " </td>";
    echo "<td class='hedlines green1'>" . $row["slp_count"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["slp_day_share"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["validity_days"] . " </td>";
    echo "<td class='hedline green1'><a class='acclink' href='floor_master_update.php?id=" . $floor_id .  "'>Edit</a>  <a class='rejlink' href='floor_master_delect.php?id=" . $floor_id .  "'>Delect</a></td>";
    echo "</tr>";
    $si_no++; // Increment the counter
}

 // Free result set
 mysqli_free_result($result);

 // Close connection
 mysqli_close($con)
?>
  </tbody>
</table>

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
  ?>
  <button onclick="nextPage()">Next</button>
</div><br><br><br>


<script>
const rowsPerPage = 25;
let currentPage = 1;
let totalRows = $total_records;
let totalPages = Math.ceil(totalRows / rowsPerPage);
let paginationContainer = document.querySelector('.pagination');
let tableData = [];
let sortDirection = 'asc';

// Function to generate table data
function generateTableData(page) {
  const tableBody = document.querySelector('#myTable tbody');
  tableBody.innerHTML = ''; // Clear existing data

  const startIndex = (page - 1) * rowsPerPage;
  const endIndex = startIndex + rowsPerPage;

  for (let i = startIndex; i < endIndex && i < tableData.length; i++) {
    const row = document.createElement('tr');
    row.style.background = (i % 2 === 0) ? '#f0f0f0' : '#ffffff'; // Alternate row colors

    for (let j = 0; j < 8; j++) {
      const cell = document.createElement('td');
      cell.textContent = tableData[i][j]; 
      row.appendChild(cell);
    }
    tableBody.appendChild(row);
  }
}

// Function to handle pagination button clicks
function goToPage(page) {
  currentPage = page;
  generateTableData(currentPage);
  updatePaginationButtons();
}

// Function to go to the previous page
function previousPage() {
  if (currentPage > 1) {
    goToPage(currentPage - 1);
  }
}

// Function to go to the next page
function nextPage() {
  if (currentPage * rowsPerPage < tableData.length) {
    goToPage(currentPage + 1);
  }
}

// Function to update the pagination buttons
function updatePaginationButtons() {
  paginationContainer.innerHTML = ''; // Clear existing buttons

  // Add previous button
  const previousButton = document.createElement('button');
  previousButton.textContent = 'Previous';
  previousButton.onclick = previousPage;
  paginationContainer.appendChild(previousButton);

  // Add "1" button
  const firstButton = document.createElement('button');
  firstButton.textContent = '1';
  firstButton.onclick = () => goToPage(1);
  if (currentPage === 1) {
    firstButton.classList.add('active');
  }
  paginationContainer.appendChild(firstButton);

  // Add page buttons
  const startPage = Math.max(2, currentPage - 2);
  const endPage = Math.min(totalPages, currentPage + 2);

  if (startPage > 2) {
    const ellipsisButton = document.createElement('button');
    ellipsisButton.textContent = '...';
    ellipsisButton.disabled = true;
    paginationContainer.appendChild(ellipsisButton);
  }

  for (let i = startPage; i <= endPage; i++) {
    const button = document.createElement('button');
    button.textContent = i;
    button.onclick = () => goToPage(i);
    if (i === currentPage) {
      button.classList.add('active');
    }
    paginationContainer.appendChild(button);
  }

  if (endPage < totalPages) {
    const ellipsisButton = document.createElement('button');
    ellipsisButton.textContent = '...';
    ellipsisButton.disabled = true;
    paginationContainer.appendChild(ellipsisButton);
  }

  // Add last page button
  if (totalPages > 1) {
    const lastButton = document.createElement('button');
    lastButton.textContent = totalPages;
    lastButton.onclick = () => goToPage(totalPages);
    if (currentPage === totalPages) {
      lastButton.classList.add('active');
    }
    paginationContainer.appendChild(lastButton);
  }

  // Add next button
  const nextButton = document.createElement('button');
  nextButton.textContent = 'Next';
  nextButton.onclick = nextPage;
  paginationContainer.appendChild(nextButton);
}


// Add event listeners to table headers
const tableHeaders = document.querySelectorAll('#myTable th');
tableHeaders.forEach((header, index) => {
  header.onclick = () => sortTableData(index);
});

// Initial table generation
generateTableData(currentPage);
updatePaginationButtons();
</script>

