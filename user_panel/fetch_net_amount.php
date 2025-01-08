<?php
include('../connect.php');

if (isset($_GET['id'])) {
    $amount = $_GET['id'];

if ($amount > 0) {

    $query = "SELECT * FROM admin_charges WHERE id = 'admin'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    $admin_charges = $row['admin_charges'];
    $tds = $row['tds'];
    $others = $row['others'];

    // Calculate deductions
    $admin_deduction = $amount * ($admin_charges / 100);
    $tds_deduction = $amount * ($tds / 100);
    $others_deduction = $amount * ($others / 100);

    // Calculate net amount
    $total_deductions = $admin_deduction + $tds_deduction + $others_deduction;
    $net_amount = $amount - $total_deductions;

    echo $net_amount;
}else{
    $net_amount = "ABOVE ENTER THE AMOUNT";
}
} else {
    echo "No amount provided";
}
