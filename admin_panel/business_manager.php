<?php
include('header.php');
include('../connect.php');



if (isset($_POST['submit'])){

    $min_withdrow = $_POST['min_withdrow'];
    $max_withdrow = $_POST['max_withdrow'];
    $min_referrals = $_POST['min_referrals'];
    $max_referrals = $_POST['max_referrals'];
    $spv_cost = $_POST['spv_cost'];
    $tds = $_POST['tds'];
    $admin_charges = $_POST['admin_charges'];
    $fund_trn_charge = $_POST['fund_trn_charge'];
    $share_cut = $_POST['share_cut'];
    $other = $_POST['other'];

 
    $admin_id = 'admin';

    // Prepare update query
    $query = "UPDATE admin_charges SET 
    min_withdrows = ?, 
    max_withdrows = ?, 
    min_referrals = ?, 
    max_referrals = ?, 
    spv_parsentage = ?, 
    tds = ?, 
    admin_charges = ?, 
    fund_transfer_charge = ?, 
    share_cutting = ?, 
    others = ? 
    WHERE id = ?";

    // Prepare statement
    $stmt = mysqli_prepare($con, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "iiiiiiiiiii", 
    $min_withdrow, 
    $max_withdrow, 
    $min_referrals, 
    $max_referrals, 
    $spv_cost, 
    $tds, 
    $admin_charges, 
    $fund_trn_charge, 
    $share_cut, 
    $other, 
    $admin_id);

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        echo '<script>alert("Admin Charges Updated Successfully");window.location.href = "business_manager.php";</script>';
        
    } else {
        echo '<script>alert("data not update");window.location.href = "business_manager.php";</script>';
 
    }
}

    $query = mysqli_query($con, "SELECT * FROM admin_charges WHERE id='admin'"); 
  
    $row = mysqli_fetch_assoc($query); 

?>
<section>
    <section>

        <center>
            <div class="check-details" style="position: relative; top:2.5vw;">

                <h1 style="font-size: 250%;">Business Manager</h1>

            </div>
        </center>

        <div class="page-container">

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="check-details" method="post">

                <div class="check-items">
                    <label for="name" class="active-id">Minimum Withdrawals</label><BR>
                    <input type="text" class="txt-user-id" name="min_withdrow" value="<?php echo $row['Min_withdrows']; ?>" placeholder="Enter Minimum Withdrawals">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Maximum Withdrawals</label><BR>
                    <input type="text" class="txt-user-id" name="max_withdrow" value="<?php echo $row['max_withdrows']; ?>" placeholder="Enter Maximum Withdrawals">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Minimum Referrals</label><BR>
                    <input type="text" class="txt-user-id" name="min_referrals " value="<?php echo $row['min_referrals']; ?>" placeholder="Enter Minimum Referrals">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Maximum Referrals</label><BR>
                    <input type="text" class="txt-user-id" name="max_referrals" value="<?php echo $row['max_referrals']; ?>" placeholder="Enter Maximum Referrals">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">SPV %</label><BR>
                    <input type="text" class="txt-user-id" name="spv_cost" value="<?php echo $row['spv_parsentage']; ?>" placeholder="Enter Add Cost">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">TDS %</label><BR>
                    <input type="text" class="txt-user-id" name="tds" value="<?php echo $row['tds']; ?>" placeholder="Enter Add %">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Admin Charge %</label><BR>
                    <input type="text" class="txt-user-id" name="admin_charges" value="<?php echo $row['admin_charges']; ?>" placeholder="Enter Add %">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Fund Transfer charge %</label><BR>
                    <input type="text" class="txt-user-id" name="fund_trn_charge" value="<?php echo $row['fund_transfer_charge']; ?>" placeholder="Enter Add %">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Share Cutting %</label><BR>
                    <input type="text" class="txt-user-id" name="share_cut" value="<?php echo $row['share_cutting']; ?>" placeholder="Enter Add %">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Others %</label><BR>
                    <input type="text" class="txt-user-id" name="other" value="<?php echo $row['others']; ?>" placeholder="Enter Add %">
                </div>


                <div class="button-check-div">
                    <a href="./managers.php"><button type="button" class="button-check red">BACK</button></a>
                      <input type="submit" class="button-check green" value="submit" name="submit">
                </div><br><br><br>
            </form>
        </div><br><br><br><br><br><br>
    </section>
    