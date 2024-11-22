<?php
// Query to select data from the database
include('../connect.php');
include('./header.php');

?>
<style>
  .cantainer {


        display: flex;
        margin:0 120px 120px 0px;
        border-collapse: collapse;
        padding-bottom: 200px;  
    }

    .hedlines {
        width: 100vw;
        padding-top: 1vw;
        font-size: 90%;
        border: solid 1px black;
        padding: 1vw 4.5vw;

    }

    .hedline {
        width: 100vw;


        border: solid 1px black;

    }

    .red1 {
        font-size: 100%;
        color: midnightblue;
        background-color: yellow;

    }

    .green1 {
        background-color: lightyellow;
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
    .greendes{
        width: 100vw;
    }
    .imagview{
        width: 100px;
        height: 80px;
    }
</style>


<?php



$query = "SELECT * FROM `cartdata`";


// Display data in a table
echo "<table class= 'cantainer ' >";
echo "<center><h1 class= 'hline'>CART DETAILES</h1> </center>";
echo "<tr >

<th class='hedlines red1'>Package or Product</th>
<th class='hedlines red1'>Category</th>
<th class='hedlines red1'>Sub-Category</th>
<th class='hedlines red1'>Product Name</th>
<th class='hedlines red1'>MRP</th>
<th class='hedlines red1'>DP</th>
<th class='hedlines red1'>SPV</th>
<th class='hedlines red1'>Referral Value</th>
<th class='hedlines red1'>S-Wallet Discount %</th>
<th class='hedlines red1'>Add S-Wallet Fund</th>
<th class='hedlines red1'>Package Algibulity Type</th>
<th class='hedlines red1'>Package Algibulity</th>
<th class='hedlines red1'>Cash Back Amount</th>
<th class='hedlines red1'>Share Fond</th>
<th class='hedlines red1'>No.Of Share Points</th>
<th class='hedlines red1'>Product Description</th>
<th class='hedlines red1'>Image</th>
<th class='hedlines red1'>Status</th></tr>";


// Combine data from both tables and order by date in descending order

$result = mysqli_query($con, $query);
while ($row = $result->fetch_assoc()) {
    $id = $row["productcode"];
    $image = $row["images_web"];
    echo "<tr>";
   
    echo "<td class='hedlines green1'>" . $row["packageorproduct"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["category"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["sub_category"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["packagename"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["mrp"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["dp"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["spv"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["referralvalue"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["swalletdiscount"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["addswalletfund"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["packagealgibulitytype"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["packagealgibulity"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["cashbackamount"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["sharefond"] . "</td>";
    echo "<td class='hedlines green1'>" . $row["noofsharepoints"] . "</td>";
    echo "<td class='hedline green1 '>" . $row["productdescription"] . "</td>";
    echo "<td class='hedlines green1'><img src='$image' class='imagview' alt='Image Preview'></td>";

    echo "<td class='hedline green1'><a class='acclink' href='cart_data_update.php?id=" . $id .  "'>Edit</a>  <a class='rejlink' href='cart_data_delect.php?id=" . $id .  "'>Delect</a></td>";


    echo "</tr>";
}

echo "</table>";
?>
<script>
 const images = document.querySelectorAll('.image_slid');

images.forEach((image) => {
    image.addEventListener('click', (e) => {
        // Do something when the image is clicked, such as displaying a lightbox
        console.log('Image clicked!');
    });
});
</script>