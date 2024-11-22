<!DOCTYPE html>
<html>
<head>
<style>
table {
  border-collapse: collapse;
  width: 100%;
  text-align: center;
}

th, td {
  border: 1px solid black;
  padding: 8px;
  text-align: left;
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
</style>
</head>
<body>

<h2>Data Table</h2>

<table id="myTable">
  <thead>
    <tr>
      <th>SI NO</th>
      <th>User ID</th>
      <th>User Name</th>
      <th>TH4</th>
      <th>TH5</th>
      <th>TH6</th>
      <th>TH7</th>
      <th>TH8</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<div class="pagination">
  <button onclick="previousPage()">Previous</button>
  <button onclick="goToPage(1)" class="active">1</button>
  <button onclick="goToPage(2)">2</button>
  <button onclick="goToPage(3)">3</button>
  <button onclick="goToPage(4)">4</button>
  <button onclick="goToPage(5)">5</button>
  <span>...</span>
  <button onclick="nextPage()">Next</button>
</div>

<script>
const rowsPerPage = 25;
let currentPage = 1;
let totalRows = 700;
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

// Function to sort table data
// function sortTableData(columnIndex) {
//   if (sortDirection === 'asc') {
//     tableData.sort((a, b) => a[columnIndex].localeCompare(b[columnIndex]));
//     sortDirection = 'desc';
//   } else {
//     tableData.sort((a, b) => b[columnIndex].localeCompare(a[columnIndex]));
//     sortDirection = 'asc';
//   }
//   generateTableData(currentPage);
// }

// Generate initial table data
// for (let i = 0; i < totalRows; i++) {
//   const rowData = [];
//   for (let j = 0; j < 8; j++) {
//     rowData.push(`TR${i + 1}`);
//   }
//   tableData.push(rowData);
// }

// Add event listeners to table headers
const tableHeaders = document.querySelectorAll('#myTable th');
tableHeaders.forEach((header, index) => {
  header.onclick = () => sortTableData(index);
});

// Initial table generation
generateTableData(currentPage);
updatePaginationButtons();
</script>

</body>
</html>