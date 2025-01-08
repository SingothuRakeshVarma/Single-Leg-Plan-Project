<?php
include('./header.php');
include('../connect.php');

$user_id = $_SESSION['user_id'];

$qurey = "SELECT 
            fm.floor_name, 
            fm.floor_price, 
            fm.floor_booking_fees, 
            fm.total, 
            fm.slp_count, 
            fm.slp_day_share, 
            fm.validity_days, 
            fim.total_floor_income 
          FROM 
            floor_master fm 
          JOIN 
            floor_income_master fim ON fm.floor_name = fim.floor_name 
          WHERE 
            fm.floor_name = 'floor - 1'";

$result = mysqli_query($con, $qurey);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    
    // Check if the row is not empty
    if ($row) {

        $floor_1_total = $row['total'];
        $floor_1_validity_days = $row['validity_days'];
        $floor_1_income = $row['total_floor_income'];
    }
}

$qurey = "SELECT 
            fm.floor_name, 
            fm.floor_price, 
            fm.floor_booking_fees, 
            fm.total, 
            fm.slp_count, 
            fm.slp_day_share, 
            fm.validity_days, 
            fim.total_floor_income 
          FROM 
            floor_master fm 
          JOIN 
            floor_income_master fim ON fm.floor_name = fim.floor_name 
          WHERE 
            fm.floor_name = 'floor - 2'";

$result = mysqli_query($con, $qurey);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    
    // Check if the row is not empty
    if ($row) {
        $floor_2_total = $row['total'];
        $floor_2_validity_days = $row['validity_days'];
        $floor_2_income = $row['total_floor_income'];
    }
}
$qurey = "SELECT 
            fm.floor_name, 
            fm.floor_price, 
            fm.floor_booking_fees, 
            fm.total, 
            fm.slp_count, 
            fm.slp_day_share, 
            fm.validity_days, 
            fim.total_floor_income 
          FROM 
            floor_master fm 
          JOIN 
            floor_income_master fim ON fm.floor_name = fim.floor_name 
          WHERE 
            fm.floor_name = 'floor - 3'";

$result = mysqli_query($con, $qurey);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    
    // Check if the row is not empty
    if ($row) {
        $floor_3_total = $row['total'];
        $floor_3_validity_days = $row['validity_days'];
        $floor_3_income = $row['total_floor_income'];
    }
}
$qurey = "SELECT 
            fm.floor_name, 
            fm.floor_price, 
            fm.floor_booking_fees, 
            fm.total, 
            fm.slp_count, 
            fm.slp_day_share, 
            fm.validity_days, 
            fim.total_floor_income 
          FROM 
            floor_master fm 
          JOIN 
            floor_income_master fim ON fm.floor_name = fim.floor_name 
          WHERE 
            fm.floor_name = 'floor - 4'";

$result = mysqli_query($con, $qurey);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    
    // Check if the row is not empty
    if ($row) {
        $floor_4_total = $row['total'];
        $floor_4_validity_days = $row['validity_days'];
        $floor_4_income = $row['total_floor_income'];
    }
}
$qurey = "SELECT 
            fm.floor_name, 
            fm.floor_price, 
            fm.floor_booking_fees, 
            fm.total, 
            fm.slp_count, 
            fm.slp_day_share, 
            fm.validity_days, 
            fim.total_floor_income 
          FROM 
            floor_master fm 
          JOIN 
            floor_income_master fim ON fm.floor_name = fim.floor_name 
          WHERE 
            fm.floor_name = 'floor - 5'";

$result = mysqli_query($con, $qurey);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    
    // Check if the row is not empty
    if ($row) {
        $floor_5_total = $row['total'];
        $floor_5_validity_days = $row['validity_days'];
        $floor_5_income = $row['total_floor_income'];
    }
}
$qurey = "SELECT 
            fm.floor_name, 
            fm.floor_price, 
            fm.floor_booking_fees, 
            fm.total, 
            fm.slp_count, 
            fm.slp_day_share, 
            fm.validity_days, 
            fim.total_floor_income 
          FROM 
            floor_master fm 
          JOIN 
            floor_income_master fim ON fm.floor_name = fim.floor_name 
          WHERE 
            fm.floor_name = 'floor - 6'";

$result = mysqli_query($con, $qurey);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    
    // Check if the row is not empty
    if ($row) {
        $floor_6_total = $row['total'];
        $floor_6_validity_days = $row['validity_days'];
        $floor_6_income = $row['total_floor_income'];
    }
}
?>
<style>
    .pkg_btn {
        border: none;
        border-radius: 20px;
        padding: 5px 100px;
        background-color: silver;

    }

    .promo_container {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        padding: 20px;
    }


    hr {
        border: none;
        height: 2px;
        width: 90%;
        background-color: white;
        margin: 0 20px 10px 20px;
    }

    .promo_rev {
        background-color: rgb(19, 29, 41);
        padding: 5px 25px;
        text-align: center;
        margin: 0 5px;
        border-radius: 10px;
    }

    @media only screen and (min-width: 768px) {
        .promo_rev {
            background-color: rgb(19, 29, 41);
            padding: 25px 120px;
            text-align: center;
            margin: 5px;
            border-radius: 10px;
        }
        .promo_funds {
    background-color: rgb(19, 29, 41);
    margin: 0 170px;
    border-radius: 10px;
    padding: 15px 21px;
    display: flex;
    flex-direction: row;
    justify-content: space-around;
}
    }
    .promo_count {
    font-size: 19px;
    color: green;
    font-weight: bold;
}

</style>
</head>

<body>
    <section><br><br>
        <!-- <div class="container_promo">
            <br>
            <div class="promo_funds">
                <div>
                    <p>Eligible to your Product Amount</p>
                    <p class="promo_amount">0.00<span class="usdt_promo">INR</span></p>
                </div>
                <div>
                    <input type="button" class="promo_viewbtn" value="View Details">
                </div>
            </div>
            <div class="promo_container">
                <div class="promo_rev">

                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Today Income&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                    <p class="promo_usdt">0.00INR</p>
                </div>
                <div class="promo_rev">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Income&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                    <p class="promo_usdt">0.00INR</p>
                </div>
            </div><br>

            <div>
                

            </div>
        </div> -->
        <div class="promo_team" style="background: rgb(7,52,96);
background: linear-gradient(70deg, rgba(7,52,96,1) 0%, rgba(6,39,42,1) 100%); color: white;
">
                    <p>Daily Profit Range:</p>
                    <p style="font-size: 20px; font-weight: bold;">50000 USDT</p>
                </div>
        <div class="promo_container2">


            <center>
                <div style="padding: 20px;">
                    Floor Details
                </div>
            </center>


            <hr>
            <div class="promo_leve1">
                <p>Floor 1</p>

            </div>
            <div>
                <div class="promo_lvldetails">
                    <div class="promo_inerlveldetails">
                        <p class="promo_count"><?php echo $floor_1_total; ?><spam > USDT</spam></p>
                        <p>Floor Value</p>
                    </div>
                    <div class="promo_inerlveldetails">
                        <p class="promo_count"><?php echo $floor_1_validity_days; ?> DAYS</p>
                        <p>Floor Validity</p>
                    </div>
                    <div class="promo_inerlveldetails">
                        <p class="promo_count"><?php echo $floor_1_income; ?><spam > USDT</spam></p>
                        <p>Floor Income</p>
                    </div>
                </div>
                <div>
                    <center> <input type="button" class="pkg_btn" value="View Details"></center>
                </div><br>
            </div>
            <hr>
            <div class="promo_leve1">
                <p>Floor 2</p>

            </div>
            <div>
                <div class="promo_lvldetails">
                    <div class="promo_inerlveldetails">
                        <p class="promo_count"><?php echo $floor_2_total; ?><spam > USDT</spam></p>
                        <p>Floor Value</p>
                    </div>
                    <div class="promo_inerlveldetails">
                        <p class="promo_count"><?php echo $floor_2_validity_days; ?> DAYS</p>
                        <p>Floor Validity</p>
                       
                    </div>
                    <div class="promo_inerlveldetails">
                        <p class="promo_count"><?php echo $floor_2_income; ?><spam > USDT</spam></p>
                        <p>Floor Income</p>
                    </div>
                </div>
                <div>
                    <center> <input type="button" class="pkg_btn" value="View Details"></center>
                </div><br>
            </div>
            <hr>
            <div class="promo_leve1">
                <p>Floor 3</p>

            </div>
            <div>
                <div class="promo_lvldetails">
                    <div class="promo_inerlveldetails">
                        <p class="promo_count"><?php echo $floor_3_total; ?><spam > USDT</spam></p>
                        <p>Floor Value</p>
                    </div>
                    <div class="promo_inerlveldetails">
                        <p class="promo_count"><?php echo $floor_3_validity_days; ?> DAYS</p>
                        <p>Floor Validity</p>
                        
                    </div>
                    <div class="promo_inerlveldetails">
                        <p class="promo_count"><?php echo $floor_3_income; ?><spam > USDT</spam></p>
                        <p>Floor Income</p>
                    </div>
                </div>
                <div>
                    <center> <input type="button" class="pkg_btn" value="View Details"></center>
                </div><br>
            </div>
            <hr>
            <div class="promo_leve1">
                <p>Floor 4</p>

            </div>
            <div>
                <div class="promo_lvldetails">
                    <div class="promo_inerlveldetails">
                        <p class="promo_count"><?php echo $floor_4_total; ?><spam > USDT</spam></p>
                        <p>Floor Value</p>
                    </div>
                    <div class="promo_inerlveldetails">
                        <p class="promo_count"><?php echo $floor_4_validity_days; ?> DAYS</p>
                        <p>Floor Validity</p>
                    </div>
                    <div class="promo_inerlveldetails">
                        <p class="promo_count"><?php echo $floor_4_income; ?><spam > USDT</spam></p>
                        <p>Floor Income</p>
                    </div>
                </div>
                <div>
                    <center> <input type="button" class="pkg_btn" value="View Details"></center>
                </div><br>
            </div>
            <hr>
            <div class="promo_leve1">
                <p>Floor 5</p>

            </div>
            <div>
                <div class="promo_lvldetails">
                    <div class="promo_inerlveldetails">
                        <p class="promo_count"><?php echo $floor_5_total; ?><spam > USDT</spam></p>
                        <p>Floor Value</p>
                    </div>
                    <div class="promo_inerlveldetails">
                        <p class="promo_count"><?php echo $floor_5_validity_days; ?> DAYS</p>
                        <p>Floor Validity</p>
                    </div>
                    <div class="promo_inerlveldetails">
                        <p class="promo_count"><?php echo $floor_5_income; ?><spam > USDT</spam></p>
                        <p>Floor Income</p>
                    </div>
                </div>
                <div>
                    <center> <input type="button" class="pkg_btn" value="View Details"></center>
                </div><br>
            </div>
            <hr>
            <div class="promo_leve1">
                <p>Floor 6</p>

            </div>
            <div>
                <div class="promo_lvldetails">
                    <div class="promo_inerlveldetails">
                        <p class="promo_count"><?php echo $floor_6_total; ?><spam > USDT</spam></p>
                        <p>Floor Value</p>
                    </div>
                    <div class="promo_inerlveldetails">
                        <p class="promo_count"><?php echo $floor_6_validity_days; ?> DAYS</p>
                        <p>Floor Validity</p>
                    </div>
                    <div class="promo_inerlveldetails">
                        <p class="promo_count"><?php echo $floor_6_income; ?><spam > USDT</spam></p>
                        <p>Floor Income</p>
                    </div>
                </div>
                <div>
                    <center> <input type="button" class="pkg_btn" value="View Details"></center>
                </div><br>
            </div>




        </div><br>
    </section>
   
</body>

</html>