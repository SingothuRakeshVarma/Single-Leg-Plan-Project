<?php
include('user_header.php');


$user_id = $_SESSION['userid'];
$user_name = $_SESSION['username'];
$referalid = $_SESSION['referalid'];
$referalname =  $_SESSION['referalname'];
$image = $_SESSION['images'];

$query = "SELECT * FROM users WHERE userid = '$user_id'";
$result = mysqli_query($con, $query);

while ($row = $result->fetch_assoc()) {
    $expiry_date = $row["expiry_date"];

    if ($expiry_date == '0000-00-00') {
        $days = "InActive";
    } else {
        $current_date = date("Y-m-d"); // Get the current date
        $diff = abs(strtotime($expiry_date) - strtotime($current_date)); // Calculate the difference in seconds
        $days = floor($diff / (60 * 60 * 24)); // Convert seconds to days

        
    }
}

$sql = "SELECT COUNT(*) AS processing_count FROM product_delivery WHERE user_id = '$user_id'";
$result = $con->query($sql);

//  Retrieve the Count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $wprocessingCount = $row['processing_count'];
} else {
    $wprocessingCount = 0;
}

$query = "SELECT * FROM transaction WHERE userids ='$user_id' ";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

// Store data in the session
if ($user > 0) {



    $_SESSION['ewallet'] = $user['ewallet'];
    $_SESSION['swallet'] = $user['swallet'];
    $_SESSION['ewallet_withdrow'] = $user['ewallet_withdrow'];
    $_SESSION['ewallet_balance'] = $user['ewallet_balance'];
    $_SESSION['swallet_balance'] = $user['swallet_balance'];
    $_SESSION['team_pv'] = $user['team_pv'];

    $_SESSION['auto_pool_amount'] = $user['auto_pool_amount'];
} else {
    $_SESSION['ewallet'] = 0;
    $_SESSION['swallet'] = 0;
    $_SESSION['ewallet_withdrow'] = 0;
    $_SESSION['ewallet_balance'] = 0;
    $_SESSION['swallet_balance'] = 0;
    $_SESSION['team_wallet'] = 0;
    $_SESSION['points'] = 0;
    $_SESSION['points_withdrow'] = 0;
    $_SESSION['points_balance'] = 0;
    $_SESSION['auto_pool_amount'] = 0;
    $_SESSION['team_pv'] = 0;
}

// Query to find current day's income
$query = "SELECT COALESCE(SUM(camount), 0) AS current_day_income 
          FROM transaction_requst 
          WHERE user_id = '$user_id' AND status2 != 'Self Recharge'AND status2 != 'admin' AND DATE(cdate) = CURDATE()";

$result = $con->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    $current_day_income = $row["current_day_income"];
} else {
    // Handle query error
    $current_day_income = 0;
    $error = $con->error;
    echo "Error: " . $error;
}

$query = "SELECT COALESCE(SUM(camount), 0) AS recharge_income 
          FROM transaction_requst 
          WHERE user_id = '$user_id' AND status2 = 'Self Recharge' AND status = 'accepted'";

$result = $con->query($query);
if ($result) {
    $row = $result->fetch_assoc();
    $recharge_income = $row["recharge_income"];
} else {
    // Handle query error
    $recharge_income = 0;
}

// Close the result and connection
$result->close();
$con->close();
?>
<style>
    .profile_id {
        position: relative;
        top: -2vw;
        font-size: 110%;
    }

    .dash-bord-details {

        width: 20.1vw;
        height: 13vw;
        box-shadow: 5px 15px 35px 0 rgb(0, 0, 0.1);
        background: transparent;
        animation: color 12s ease-in-out infinite;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;

    }

    .icon-styles {
        color: #fff;
        border: solid 0.00200vw #fff;
        box-shadow: 0 25px 32px 0 rgb(0, 0, 0.1);
        border-radius: 50%;
        background: transparent;
        padding: 0 0.8vw;
        z-index: 1;
        position: relative;
        top: -0.5vw;

        font-size: 5vw;

    }


    .db-buttons {
        text-align: center;
        width: 65%;
        height: 20%;
        position: relative;
        bottom: 2.1vw;
        background: transparent;
        color: #fff;
        border-color: transparent;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
        font-size: 1.2vw;
        box-shadow: 5px 15px 35px 0 rgb(0, 0, 0.1);
        z-index: 100;
    }
    .dash-bord-icon{
        text-align: center;
        width: 65%;
        height: 25%;
        position: relative;
        top: 10%;
    }
    .dash-bord-details{
         width: 65%;
    }

    .pink1 {
        background-image: url('https://c4.wallpaperflare.com/wallpaper/552/454/447/background-color-brightness-colors-wallpaper-preview.jpg');
        background-size: cover;
        /* cover the entire element */
        background-repeat: no-repeat;
        /* don't repeat the image */
        background-position: center;
        /* center the image horizontally and vertically */
    }

    .pink2 {
        background-image: url('https://c4.wallpaperflare.com/wallpaper/947/644/4/blue-background-color-wallpaper-preview.jpg');
        background-size: cover;
        /* cover the entire element */
        background-repeat: no-repeat;
        /* don't repeat the image */
        background-position: center;
        /* center the image horizontally and vertically */
    }

    .pink3 {
        background-image: url('https://c4.wallpaperflare.com/wallpaper/834/812/932/circles-spirals-color-shade-wallpaper-preview.jpg');
        background-size: cover;
        /* cover the entire element */
        background-repeat: no-repeat;
        /* don't repeat the image */
        background-position: center;
        /* center the image horizontally and vertically */
    }

    .pink4 {
        background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSP-oDiwQS0TFx42wgz5uGrGcCaXqLdU4SxAA&s');
        background-size: cover;
        /* cover the entire element */
        background-repeat: no-repeat;
        /* don't repeat the image */
        background-position: center;
        /* center the image horizontally and vertically */
    }

    .pink5 {
        background-image: url('https://www.ultraimagehub.com/wallpapers/tr:flp-false,gx-0.3,gy-0.5,q-75,rh-3264,rw-5824,th-1080,tw-1920/1242066824229687306.jpeg');
        background-size: cover;
        /* cover the entire element */
        background-repeat: no-repeat;
        /* don't repeat the image */
        background-position: center;
        /* center the image horizontally and vertically */
    }

    .pink6 {
        background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSLu69MF0gQTa2646f4L5YiFzSb8kgeGwCwNPoWcQbwng28mNftKDKtLTQVVeNJyF1UwLc&usqp=CAU');
        background-size: cover;
        /* cover the entire element */
        background-repeat: no-repeat;
        /* don't repeat the image */
        background-position: center;
        /* center the image horizontally and vertically */
    }

    .pink7 {
        background-image: url('https://e0.pxfuel.com/wallpapers/532/356/desktop-wallpaper-maroon-and-gold-burgundy-and-gold-thumbnail.jpg');
        background-size: cover;
        /* cover the entire element */
        background-repeat: no-repeat;
        /* don't repeat the image */
        background-position: center;
        /* center the image horizontally and vertically */
    }

    .pink8 {
        background-image: url('https://png.pngtree.com/thumb_back/fh260/background/20230706/pngtree-d-gold-and-dark-green-wall-perfect-for-backdrops-backgrounds-or-image_3787668.jpg');
        background-size: cover;
        /* cover the entire element */
        background-repeat: no-repeat;
        /* don't repeat the image */
        background-position: center;
        /* center the image horizontally and vertically */
    }

    .pink9 {
        background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT9QZzarAQUY9fyCwODLbd6Vwew1Xl0kwi0JAesFL3GeaISaBS_CKkpaLIAduqCAkWSm9M&usqp=CAU');
        background-size: cover;
        /* cover the entire element */
        background-repeat: no-repeat;
        /* don't repeat the image */
        background-position: center;
        /* center the image horizontally and vertically */
    }

    .pink10 {
        background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ-Usl8BmApGe_fwGMJhYzqW6_W7RjIMQTXiCOgEKemFxVtx9O9KxPVEndBGNEYIoEwPOo&usqp=CAU');
        background-size: cover;
        /* cover the entire element */
        background-repeat: no-repeat;
        /* don't repeat the image */
        background-position: center;
        /* center the image horizontally and vertically */
    }

    .main_container {
        width: 95%;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-around;
        
        
    }
    .dash-bord-cuntinar{
        width: 40%;
        
        margin-top: 1%;
    }
    .profile-details{
        margin: 2% 10% 2% 2%;
    }
    .profile-name{
        font-size: 140%;
        
    }
    .btn{
        width: 75vw;
    }
</style>

<section style="position: relative; top:2vw; left: 6vw;">
    <div class="profile-details">
        <img class="profile-img" src="<?php echo $image; ?>" alt="">
        <p class="profile-name"><?php echo $user_name; ?></p>
        <p class="profile_id">ID Number&nbsp;&nbsp;&nbsp;&nbsp;:<span style="color: red;">&nbsp;&nbsp;<?php echo $user_id; ?></span></p>
    </div>
</section>

<section><center>
    <div class="main_container">
        <div class="dash-bord-cuntinar">


            <div class="dash-bord-icon">
                <i class="bi bi-coin icon-styles pink2" style="font-size: 6vw; position: relative; top: -1vw;"></i>
            </div>
            <div class="dash-bord-details pink2">
                <h2 class="db-headline">E-Wallet</h2>
                <p class="db-para"><?php echo $_SESSION['ewallet']; ?></p>
            </div>

            <a href="./repots_tran.php"><button class="db-buttons pink2">More Details</button></a>

        </div>
        <div class="dash-bord-cuntinar ">

            <div class="dash-bord-icon ">
                <i class="bi bi-currency-rupee icon-styles pink1 " style="font-size: 6vw; position: relative; top: -1vw;"></i>
            </div>
            <div class="dash-bord-details pink1">
                <h2 class="db-headline">S-Wallet</h2>
                <p class="db-para"><?php echo $_SESSION['swallet']; ?></p>
            </div>

            <button class="db-buttons pink1">More Details</button>

        </div>
        <div class="dash-bord-cuntinar ">

            <div class="dash-bord-icon">
                <i class="bi bi-currency-exchange icon-styles pink4" style="font-size: 6vw; position: relative; top: -1vw;"></i>
            </div>
            <div class="dash-bord-details pink4">
                <h2 class="db-headline">EW-Balance</h2>
                <p class="db-para"><?php echo $_SESSION['ewallet_balance']; ?></p>
            </div>

            <a href="./repots_tran.php"><button class="db-buttons pink4">More Details</button></a>

        </div>
        <div class="dash-bord-cuntinar ">

            <div class="dash-bord-icon">
                <i class="bi bi-people-fill icon-styles pink3" style="font-size: 6vw; position: relative; top: -1vw;"></i>
            </div>
            <div class="dash-bord-details pink3">
                <h2 class="db-headline">Team-PV</h2>
                <p class="db-para"><?php echo $_SESSION['team_pv']; ?></p>
            </div>

            <a href="./pvs_report.php"><button class="db-buttons pink3">More Details</button></a>

        </div>
        <div class="dash-bord-cuntinar ">

            <div class="dash-bord-icon">
                <i class="bi bi-currency-rupee icon-styles pink5" style="font-size: 6vw; position: relative; top: -1vw;"></i>
            </div>
            <div class="dash-bord-details pink5">
                <h2 class="db-headline">Withdrow</h2>
                <p class="db-para"><?php echo $_SESSION['ewallet_withdrow']; ?></p>
            </div>

            <a href="./repots_tran.php"> <button class="db-buttons pink5">More Details</button></a>

        </div>
        <div class="dash-bord-cuntinar ">

            <div class="dash-bord-icon ">
                <i class="bi bi-currency-rupee icon-styles pink6" style="font-size: 6vw; position: relative; top: -1vw;"></i>
            </div>
            <div class="dash-bord-details pink6">
                <h2 class="db-headline">Total Recharge</h2>
                <p class="db-para"><?php echo $recharge_income; ?></p>
            </div>

            <button class="db-buttons pink6">More Details</button>

        </div>
        <div class="dash-bord-cuntinar ">

            <div class="dash-bord-icon">
                <i class="bi bi-cart4 icon-styles pink7" style="font-size: 6vw; position: relative; top: -1vw;"></i>
            </div>
            <div class="dash-bord-details pink7">
                <h2 class="db-headline">Auto Pool Income</h2>
                <p class="db-para"><?php echo $_SESSION['auto_pool_amount']; ?></p>
            </div>

            <button class="db-buttons pink7">More Details</button>

        </div>
        <div class="dash-bord-cuntinar ">

            <div class="dash-bord-icon">
                <i class="bi bi-currency-rupee icon-styles pink8" style="font-size: 6vw; position: relative; top: -1vw;"></i>
            </div>
            <div class="dash-bord-details pink8">
                <h2 class="db-headline">User Validity</h2>
                <p class="db-para"><?php echo $days; ?></p>
            </div>

            <button class="db-buttons pink8">More Details</button>

        </div>
        <div class="dash-bord-cuntinar ">

            <div class="dash-bord-icon">
                <i class="bi bi-currency-rupee icon-styles pink9" style="font-size: 6vw; position: relative; top: -1vw;"></i>
            </div>
            <div class="dash-bord-details pink9">
                <h2 class="db-headline">Today Income</h2>
                <p class="db-para"><?php echo $current_day_income; ?></p>
            </div>

            <button class="db-buttons pink9">More Details</button>

        </div>
        <div class="dash-bord-cuntinar ">

            <div class="dash-bord-icon">
                <i class="bi bi-currency-rupee icon-styles pink10" style="font-size: 6vw; position: relative; top: -1vw;"></i>
            </div>
            <div class="dash-bord-details pink10">
                <h2 class="db-headline">Product Deliverys</h2>
                <p class="db-para"><?php echo $wprocessingCount; ?></p>
            </div>

            <a href="./delivey_report.php"><button class="db-buttons pink10">More Details</button></a>

        </div>



    </div>

    </center>
</section></br>
<section>
    <center><a href="#"><button type="button" class="btn btn-secondary" id="share-button" data-bs-dismiss="modal">Referral Link</button></a></center>
</section><br><br><br>
<script>
  const shareButton = document.getElementById('share-button');

  shareButton.addEventListener('click', () => {
    if (navigator.share) {
        const userId = '<?php echo $_SESSION['userid']; ?>';
        const username = '<?php echo $_SESSION['username']; ?>';
  const url = `https://realvisine.com/user.php?id=${encodeURIComponent(userId)}&name=${encodeURIComponent(username)}`;

  navigator.share({
    title: 'Referral Link',
    text: 'Join us and be a part of our Companey - REALVISINE',
    url: url,
  })

        .then(() => console.log('Shared successfully!'))
        .catch((error) => console.error('Error sharing:', error));
    } else {
      console.log('Web Share API is not supported');
    }
  });
</script>