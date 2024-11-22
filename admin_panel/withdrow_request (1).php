<?php
// Query to select data from the database
include('../connect.php');
include('./header.php');

?>
<style>
    .cantainer {
        display: flex;

        border-collapse: collapse;
        padding-bottom: 200px;
    }

    .hedlines {
        width: 100vw;
        height: auto;
        padding-top: 1vw;
        font-size: 90%;
        border: solid 1px black;
        padding: 1vw 1vw;
        text-align: center;
    }

    .hedline {
        width: 100vw;
        border: solid 1px black;


    }

    .red1 {
        font-size: 120%;

        color: midnightblue;
        background-color: yellow;

    }

    .green1 {
        background-color: lightyellow;
        font-size: 100%;
        color: black;
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

    .acclink {

        text-decoration: none;
        font-size: 100%;
        text-align: center;
        border-radius: 0.5vw;
        color: white;
        background-color: green;
        padding: 0.3vw 0.5vw;
        position: relative;
        left: 83%;
    }

    .rejlink {
        text-decoration: none;
        font-size: 100%;
        text-align: center;
        border-radius: 0.5vw;
        color: white;
        background-color: orangered;
        padding: 0.3vw 1.5vw;
        position: relative;
        left: 83%;
    }

    input[type="checkbox"] {
        /* style the checkbox itself */
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background-color: #fff;
        border: 1px solid #ccc;
    }
    
</style>


<?php



/// Handle form submission
if (isset($_GET['accept'])) {
    if (isset($_GET['checkbox'])) {
        foreach ($_GET['checkbox'] as $user_id) {
            // Update transaction table
            $query = mysqli_query($con, "SELECT * FROM transaction WHERE userids = '$user_id'");
            $row = mysqli_fetch_array($query);

            $ewallet_balance_amount = $row['ewallet_balance'];

           $query = mysqli_query($con, "SELECT * FROM users WHERE userid = '$user_id'");
            $row = mysqli_fetch_array($query);

               $bankname = $row["bankname"];
             $account_number = $row["account_number"];
            $ifsc_code = $row["ifsc_code"];
             $holder_name = $row["holder_name"];
             
             $query = mysqli_query($con, "SELECT * FROM withdrow_requests WHERE userid = '$user_id' AND status = 'processing'");
            $row = mysqli_fetch_array($query);
            
            $amount = $row['withdrow_amount'];
    
             $query = "INSERT INTO `withdrow_report`( `user_id`, `holder_name`, `bankname`, `account_number`, `ifsc_code`, `amount`) VALUES ('$user_id','$holder_name','$bankname','$account_number','$ifsc_code','$amount')";
              $row = mysqli_query($con, $query);
             
             $sql = "UPDATE withdrow_requests SET balance = '$ewallet_balance_amount', status = 'accepted' WHERE userid = '$user_id' AND status = 'processing'";
            $con->query($sql);
     echo '<script>window.location.href = "withdrow_request.php"</script>';
        }
       
    }
} elseif (isset($_GET['reject'])) {
    if (isset($_GET['checkbox'])) {
        foreach ($_GET['checkbox'] as $user_id) {
            // Update transaction table
            $query = "SELECT * FROM withdrow_requests WHERE userid = '$user_id' AND status = 'processing'";
             $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);

            $net_amount = $row['net_amount'];

            $query ="SELECT * FROM transaction WHERE userids = '$user_id'";
             $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);

            $ewallet_balance_amount = $row['ewallet_balance'];
            $ewallet_withdrow_amount = $row['ewallet_withdrow'];
            $ewallet_balance_new_amount = $ewallet_balance_amount + $net_amount;
            $ewallet_withdrow_new_amount = $ewallet_withdrow_amount - $net_amount;


            $query = "UPDATE transaction SET ewallet_balance = '$ewallet_balance_new_amount', ewallet_withdrow = '$ewallet_withdrow_new_amount' WHERE userids = '$user_id'";
            if (mysqli_query($con, $query)) {
                // Save rejected status in database
                $sql = "UPDATE withdrow_requests SET balance = '$ewallet_balance_new_amount', status = 'rejected' WHERE userid = '$user_id' AND status = 'processing'";
                if ($con->query($sql) === TRUE) {
                    echo '<script>window.location.href = "withdrow_request.php"</script>';
                } else {
                    echo "Error updating status: " . $con->error;
                }
            }
        }
    }
}

   




// Display data in a table
echo "<form action='' method='get'>";
echo "<table class='cantainer'>";
echo "<center><h1 class='hline'>Withdrawal Requests</h1></center>";

echo "<tr>
    <th class='hedlines red1'>Check Box</th>
    <th class='hedlines red1'>Date</th>
    <th class='hedlines red1'>User ID</th>
    <th class='hedlines red1'>Holder Name</th>
    <th class='hedlines red1'>Bank Name</th>
    <th class='hedlines red1'>Account Number</th>
    <th class='hedlines red1'>IFSC Code</th>
    <th class='hedlines red1'>Withdrawal Amount</th>
</tr>";


// Combine data from both tables and order by date in descending order
$query = "SELECT * FROM withdrow_requests 
          WHERE status = 'processing' ORDER BY date DESC";
$result = mysqli_query($con, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $user_id = $row["userid"];
    $withdrow_amount = $row["withdrow_amount"];
    $date = $row["date"];
    $net_amount = $row["net_amount"];

    $query = "SELECT * FROM users  WHERE userid = '$user_id' ";
    $user_result = mysqli_query($con, $query);
    $user_row = mysqli_fetch_assoc($user_result);

    $bankname = $user_row["bankname"];
    $account_number = $user_row["account_number"];
    $ifsc_code = $user_row["ifsc_code"];
    $holder_name = $user_row["holder_name"];

    echo "<tr>";

    echo "<td class='hedlines green1'><input type='checkbox' name='checkbox[]' value='" . $user_id . "'></td>";
    echo "<td class='hedlines green1'>" . $date . "</td>";
    echo "<td class='hedlines green1'>" . $user_id . "</td>";
    echo "<td class='hedlines green1'>" . $holder_name . "</td>";
    echo "<td class='hedlines green1'>" . $bankname . "</td>";
    echo "<td class='hedlines green1'>" . $account_number . "</td>";
    echo "<td class='hedlines green1'>" . $ifsc_code . "</td>";
    echo "<td class='hedlines green1'>" . $withdrow_amount . "</td>";

    echo "</tr>";
}
echo "</table>";

// Add hidden inputs for the links
echo "<input type='submit' class='acclink' name='accept' value='Accept'>";
echo "<input type='submit' class='rejlink' name='reject' value='Reject'>";
echo "</form>";

// </script>";
?>