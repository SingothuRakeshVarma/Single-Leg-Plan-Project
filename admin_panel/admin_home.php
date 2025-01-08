<?php
include('./header.php');
include('../connect.php');

$query = "SELECT sum(net_wallet) as total_net_wallet, sum(wallet_withdraw) as total_wallet_withdraw, sum(wallet_balance) as total_wallet_balance FROM user_wallet";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$net_wallet = $row['total_net_wallet'];
$wallet_withdraw = $row['total_wallet_withdraw'];
$wallet_balance = $row['total_wallet_balance'];

$query = "SELECT count(*) as total_count FROM user_data";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$total_user = $row['total_count'];

$query = "SELECT sum(amount) as total_amount FROM deposit WHERE tstatus LIKE'%Income%' AND status = 'accepted'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$net_amount = $row['total_amount'];

$query = "
    SELECT COUNT(DISTINCT user_id) AS active_user_count
    FROM (
        SELECT user_id FROM floor_1_table WHERE active_status = 'Active'
        UNION
        SELECT user_id FROM floor_2_table WHERE active_status = 'Active'
        UNION
        SELECT user_id FROM floor_3_table WHERE active_status = 'Active'
        UNION
        SELECT user_id FROM floor_4_table WHERE active_status = 'Active'
        UNION
        SELECT user_id FROM floor_5_table WHERE active_status = 'Active'
        UNION
        SELECT user_id FROM floor_6_table WHERE active_status = 'Active'
    ) AS combined_tables";

$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$unique_active_user_count = $row['active_user_count'];

$query = "SELECT COUNT(*) as withdraw_count FROM withdraws WHERE status = 'Processing'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$withdraw_count = $row['withdraw_count'];

$query = "SELECT COUNT(*) as diposits_count FROM deposit WHERE status = 'Processing'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$deposit_count = $row['diposits_count'];
?>
<style>
    .ad_amount {
        font-size: 25px;
        position: relative;
        top: -7px;
    }

    @media only screen and (min-width: 768px) {
        .ad_amount {
            font-size: 25px;
            position: relative;
            top: 5px;
        }
    }
</style>

<section>

    <div class="all_items">
        <div class="user_details">
            <div class="income_act">
                <p class="word_inc">Total Fund</p>
                <p class="ad_amount"><?php echo $net_wallet; ?></p>
            </div>
            <!-- <div class="income_act">
                <p class="word_inc">Total Earings</p>
                <p class="ad_amount">100000</p>
            </div> -->
            <div class="income_act">
                <p class="word_inc">Total Income</p>
                <p class="ad_amount"><?php echo $net_amount; ?></p>
            </div>
            <div class="income_act">
                <p class="word_inc">Wallet Balance</p>
                <p class="ad_amount"><?php echo $wallet_balance; ?></p>
            </div>
            <!-- <div class="income_act">
                <p class="word_inc">Balance Earings</p>
                <p class="ad_amount">100000</p>
            </div> -->
            <div class="income_act">
                <p class="word_inc">Total Withdrow</p>
                <p class="ad_amount"><?php echo $wallet_withdraw; ?></p>
            </div>
            <div class="income_act">
                <p class="word_inc">Total Users</p>
                <p class="ad_amount"><?php echo $total_user; ?></p>
            </div>
            <div class="income_act">
                <p class="word_inc">Active</p>
                <p class="ad_amount"><?php echo $unique_active_user_count; ?></p>
            </div>
            <div class="income_act">
                <p class="word_inc" style="color: red;">WithD Requst</p>
                <p class="ad_amount"><?php echo $withdraw_count; ?></p>
            </div>
            <div class="income_act">
                <p class="word_inc">Deposit Requst</p>
                <p class="ad_amount"><?php echo $deposit_count; ?></p>
            </div>
        </div>

        <div class="hyer_icon">
            <div>
                <a href="./withdrow_report.php" class="hyp_link">
                    <i class="bi bi-arrow-bar-up icon_style"></i>
                    <div class="icon_names">Withdrow</div>
                </a>
            </div>
            <div>
                <a href="./deposit_report.php" class="hyp_link">
                    <i class="bi bi-arrow-bar-down icon_style"></i>
                    <div class="icon_names">Deposit</div>
                </a>
            </div>
            <div>
                <a href="./withdraw_request.php" class="hyp_link">
                    <i class="bi bi-arrow-down-up icon_style"></i>
                    <div class="icon_names">Withdraw Requst</div>
                </a>
            </div>
            <div>
                <a href="./deposit_requst.php" class="hyp_link">
                    <i class="bi bi-people-fill icon_style"></i>
                    <div class="icon_names">Deposit Requst</div>
                </a>
            </div>
            <div>
                <a href="./recharge_report.php" class="hyp_link">
                    <i class="bi bi-people-fill icon_style"></i>
                    <div class="icon_names">Recharge Report</div>
                </a>
            </div>
            <div>
                <a href="./floor_report.php" class="hyp_link">
                    <i class="bi bi-house-add-fill icon_style"></i>
                    <div class="icon_names">Floor Report</div>
                </a>
            </div>
            <div>
                <a href=".../check_expery_date.php" class="hyp_link">
                    <i class="bi bi-graph-up-arrow icon_style"></i>
                    <div class="icon_names">Experiy Check</div>
                </a>
            </div>
            <div>
                <a href=".../daily_income.php" class="hyp_link">
                    <i class="bi bi-cart4 icon_style"></i>
                    <div class="icon_names">Daily Income</div>
                </a>
            </div>
        </div><br>

    </div><br><br>
</section>