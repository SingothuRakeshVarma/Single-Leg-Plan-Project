<?php
include('./header.php');



$qurey = "SELECT * FROM user_wallet WHERE user_id = '" . $_SESSION['user_id'] . "'";
$result = mysqli_query($con, $qurey);
$row = mysqli_fetch_assoc($result);

$net_wallet = $row['net_wallet'];
$wallet_withdraw = $row['wallet_withdraw'];
$wallet_balance = $row['wallet_balance'];

// Assuming you have a database connection in $con
$user_id = $_SESSION['user_id']; // Make sure to sanitize this input to prevent SQL injection

$qurey = "
    SELECT COUNT(*) AS active_table_count
    FROM (
        SELECT user_id, active_status FROM floor_1_table WHERE user_id = '$user_id' AND active_status = 'Active'
        UNION ALL
        SELECT user_id, active_status FROM floor_2_table WHERE user_id = '$user_id' AND active_status = 'Active'
        UNION ALL
        SELECT user_id, active_status FROM floor_3_table WHERE user_id = '$user_id' AND active_status = 'Active'
        UNION ALL
        SELECT user_id, active_status FROM floor_4_table WHERE user_id = '$user_id' AND active_status = 'Active'
        UNION ALL
        SELECT user_id, active_status FROM floor_5_table WHERE user_id = '$user_id' AND active_status = 'Active'
        UNION ALL
        SELECT user_id, active_status FROM floor_6_table WHERE user_id = '$user_id' AND active_status = 'Active'
    ) AS combined_tables";

$result = mysqli_query($con, $qurey);
$row = mysqli_fetch_assoc($result);

$table_count = $row['active_table_count'];

$qurey = "SELECT SUM(amount) AS total_income
FROM deposit
WHERE user_id = '" . $_SESSION['user_id'] . "' AND	tstatus LIKE '%income%'";
$result = mysqli_query($con, $qurey);
$row = mysqli_fetch_assoc($result);

$income = $row['total_income'] ?? '0';

$qurey = "SELECT SUM(amount) AS total_income
FROM deposit
WHERE user_id = '" . $_SESSION['user_id'] . "' AND	tstatus = 'Recharge' AND status = 'accepted'";
$result = mysqli_query($con, $qurey);
$row = mysqli_fetch_assoc($result);

$total_recharge = $row['total_income'] ?? '0';
?>

<style>
    .reff_btn {
        
        background-image: url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQcuaC8-s3n5b9wj6autINV-_OnrNgVNHTqDQ&s);
        
        background-size: cover;
    }
</style>
<section>

    <div class="all_items">
        <div class="user_details">
            <div class="income_act">
                <p class="word_inc">Total Fund</p>
                <p><?php echo $total_recharge; ?> USDT</p>
            </div>
            <div class="income_act">
                <p class="word_inc">Total Income</p>
                <p><?php echo $income; ?> USDT</p>
            </div>
            <div class="income_act">
                <p class="word_inc">Wallet</p>
                <p><?php echo $net_wallet; ?> USDT</p>
            </div>
            <div class="income_act">
                <p class="word_inc" style="color: red;">Wallet Withdraw</p>
                <p><?php echo $wallet_withdraw; ?> USDT</p>
            </div>
            <div class="income_act">
                <p class="word_inc">Wallet Balance</p>
                <p><?php echo $wallet_balance; ?> USDT</p>
            </div>
            <div class="income_act">
                <p class="word_inc">Floors Count</p>
                <p><?php echo $table_count; ?></p>
            </div>
        </div>
        <section>
            <a href="#">
                <button class="reff_btn" id="share-button" data-bs-dismiss="modal">INVITE NOW</button>
            </a>
            <br><br>
        </section>
        <div class="hyer_icon">
            <div>
                <a href="./withdraw_report.php" class="hyp_link">
                    <i class="bi bi-arrow-bar-up icon_style"></i>
                    <div class="icon_names"><br>Withdraw</div>
                </a>
            </div>
            <div>
                <a href="./deposit_report.php" class="hyp_link">
                    <i class="bi bi-arrow-bar-down icon_style"></i>
                    <div class="icon_names"><br>Deposit</div>
                </a>
            </div>
            <div>
                <a href="./floor_report.php" class="hyp_link">
                    <i class="bi bi-bezier icon_style"></i>
                    <div class="icon_names"><br>Floor Report</div>
                </a>
            </div>
            <div>
                <a href="./slp_report.php" class="hyp_link">
                    <i class="bi bi-bezier2 icon_style"></i>
                    <div class="icon_names"><br>SLP Report</div>
                </a>
            </div>
            <div>
                <a href="./all_reports.php" class="hyp_link">
                    <i class="bi bi-arrow-down-up icon_style"></i>
                    <div class="icon_names"><br>All In One Report</div>
                </a>
            </div>
            <div>
                <a href="#" class="hyp_link">
                    <i class="bi bi-bootstrap-reboot icon_style"></i>
                    <div class="icon_names"><br>Coming Soon..</div>
                </a>
            </div>
            <div>
                <a href="#" class="hyp_link">
                    <i class="bi bi-bootstrap-reboot icon_style"></i>
                    <div class="icon_names"><br>Coming Soon..</div>
                </a>
            </div>
            <div>
                <a href="#" class="hyp_link">
                    <i class="bi bi-bootstrap-reboot icon_style"></i>
                    <div class="icon_names"><br>Coming Soon..</div>
                </a>
            </div>
        </div><br>

    </div><br><br>
</section>
<script>
    const shareButton = document.getElementById('share-button');

shareButton.addEventListener('click', () => {
    // Check if Web Share API is available
    if (navigator.share) {
        // Fetch PHP session variables for user ID and username
        const userId = '<?php echo $_SESSION["user_id"]; ?>';
        const username = '<?php echo $_SESSION["user_name"]; ?>';

        // Construct the referral URL
        const url = `https://successslp.com/referral_register.php?id=${encodeURIComponent(userId)}&name=${encodeURIComponent(username)}`;

        // Use the Web Share API to share the content
        navigator.share({
            title: 'Referral Link',
            text: 'Join us and be a part of our Company - SUCCESSSLP',
            url: url,
        })
        .then(() => console.log('Shared successfully!'))
        .catch((error) => console.error('Error sharing:', error));
    } else {
        // Fallback for unsupported browsers or platforms
        const userId = '<?php echo $_SESSION["user_id"]; ?>';
        const username = '<?php echo $_SESSION["user_name"]; ?>';
        const fallbackUrl = `https://successslp.com/referral_register.php?id=${encodeURIComponent(userId)}&name=${encodeURIComponent(username)}`;

        // Call Android native sharing mechanism through JavaScript interface
        if (typeof Android != 'undefined' && Android.shareReferralLink) {
            Android.shareReferralLink(fallbackUrl);
        } else {
            alert(`Copy this referral link: ${fallbackUrl}`);
        }
    }
});


</script>