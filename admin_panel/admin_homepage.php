<?php
include('./header.php');
include('../connect.php');


$user_id = $_SESSION['userid'];
$user_name = $_SESSION['username'];
$referalid = $_SESSION['referalid'];
$referalname =  $_SESSION['referalname'];
$image = $_SESSION['images'];
$phonenumber = $_SESSION['phonenumber'];
 
// ewallet_withdrow , ewallet_balance , swallet_withdrow , swallet_balance , points , cashback_amount

$sql = "SELECT SUM(ewallet) AS ewallet  FROM transaction;";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ewallet = $row['ewallet'];   
  
  } else {
    $ewallet = 0;
  }
  $sql = "SELECT SUM(swallet) AS swallet  FROM transaction;";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $swallet = $row['swallet'];   
  
  } else {
    $swallet = 0;
  }

  $sql = "SELECT SUM(ewallet_balance) AS ewallet_balance  FROM transaction;";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ewallet_balance = $row['ewallet_balance'];   
  
  } else {
    $ewallet_balance = 0;
  }

$sql = "SELECT SUM(ewallet_withdrow) AS ewallet_withdrow  FROM transaction;";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ewallet_withdrow = $row['ewallet_withdrow'];
 
   
  
  } else {
    $ewallet_withdrow = 0;
  }
$sql = "SELECT SUM(ewallet_balance) AS ewallet_balance  FROM transaction;";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ewallet_balance = $row['ewallet_balance'];
   
  
  } else {
    $ewallet_balance = 0;
  }
$sql = "SELECT SUM(swallet_withdrow) AS swallet_withdrow  FROM transaction;";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $swallet_withdrow = $row['swallet_withdrow'];
  
  } else {
    $swallet_withdrow = 0;
  }
$sql = "SELECT SUM(swallet_balance) AS swallet_balance  FROM transaction;";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $swallet_balance = $row['swallet_balance'];
   
   
  
  } else {
    $swallet_balance = 0;
  }

$sql = "SELECT SUM(cashback_amount) AS cashback_amount  FROM transaction;";
$result = $con->query($sql);

//  Retrieve the Count
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $cashback_amount = $row['cashback_amount'];
 

} else {
  $cashback_amount = 0;
}


$sql = "SELECT COUNT(*) AS processing_count FROM users WHERE activation_status = 'Active'";
$result = $con->query($sql);

//  Retrieve the Count
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $Activecount = $row['processing_count'];
} else {
  $Activecount = 0;
}

$sql = "SELECT COUNT(*) AS processing_count 
        FROM users 
        WHERE activation_status = 'InActive' OR activation_status = 'New User'";
$result = $con->query($sql);

//  Retrieve the Count
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $InActivecount = $row['processing_count'];
} else {
  $InActivecount = 0;
}



$sql = "SELECT COUNT(*) AS processing_count FROM withdrow_requests WHERE status = 'processing'";
$result = $con->query($sql);

//  Retrieve the Count
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $wprocessingCount = $row['processing_count'];
} else {
  $wprocessingCount = 0;
}

$sql = "SELECT COUNT(userid) AS processing_count FROM users ";
$result = $con->query($sql);

//  Retrieve the Count
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $usersCount = $row['processing_count'];
} else {
  $usersCount = 0;
}

$sql = "SELECT COUNT(*) AS processing_count FROM transaction_requst WHERE status = 'processing'";
$result = $con->query($sql);

//  Retrieve the Count
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $processingCount = $row['processing_count'];
} else {
  $processingCount = 0;
}

$sql = "SELECT COUNT(*) AS processing_count FROM product_delivery";
$result = $con->query($sql);

//  Retrieve the Count
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $delprocessingCount = $row['processing_count'];
} else {
  $delprocessingCount = 0;
}

$sql = "SELECT COUNT(*) AS processing_count FROM product_delivery WHERE status = 'Dispatch_Pending'";
$result = $con->query($sql);

//  Retrieve the Count
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $deL_pad_processingCount = $row['processing_count'];
} else {
  $deL_pad_processingCount = 0;
}
?>
<style>
    .profile_id{
        position: relative;
        top: -2vw;
        font-size: 110%;
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
    .pink11 {
        background-image: url('https://i.pinimg.com/originals/d7/98/57/d798571efb75d26b0ece1c936bcf6368.jpg');
        background-size: cover;
        /* cover the entire element */
        background-repeat: no-repeat;
        /* don't repeat the image */
        background-position: center;
        /* center the image horizontally and vertically */
    }
    .pink12 {
        background-image: url('https://t3.ftcdn.net/jpg/00/84/59/76/360_F_84597643_d1wRSP6kX2aq3fWgt2FnZUNiokZ5S40v.jpg');
        background-size: cover;
        /* cover the entire element */
        background-repeat: no-repeat;
        /* don't repeat the image */
        background-position: center;
        /* center the image horizontally and vertically */
    }
    .pink13 {
        background-image: url('https://i.pinimg.com/originals/a2/02/76/a20276c4924220e39dd5123218b6cec3.jpg');
        background-size: cover;
        /* cover the entire element */
        background-repeat: no-repeat;
        /* don't repeat the image */
        background-position: center;
        /* center the image horizontally and vertically */
    }
    .db-buttons {
        text-align: center;
        width: 100%;
        height: 25%;
        position: relative;
        bottom: 2.5vw;
        
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
     .dash-bord-cuntinars{
        margin: 2% 0;
    }
        .profile-details{
        margin: 2% 10% 2% 2%;
    }
    .profile-name{
        font-size: 140%;
        
    }
        .profile_id {
        position: relative;
        top: -2vw;
        font-size: 110%;
    }
</style>

<section style="position: relative; top:2vw;">
        <div class="profile-details">
            <img class="profile-img" src="<?php echo $image; ?>" alt="">
            <p class="profile-name"><?php echo $user_name; ?></p>
            <p class="profile_id">ID Number&nbsp;&nbsp;&nbsp;&nbsp;:<span style="color: red;">&nbsp;&nbsp;<?php echo $user_id; ?></span></p>
        </div>
</section>
<section style=" margin:5vw 0 15vw 0;">

        <div style="display: flex; flex-direction: row;
                  flex-wrap: wrap;
                       justify-content: space-around;">
            

                <div class="dash-bord-cuntinars ">


                    <div class="dash-bord-icon">
                        <i class="bi bi-coin icon-styles pink8" style="font-size: 5vw; position: relative; top: -0.5vw;"></i>
                    </div>
                    <div class="dash-bord-details pink8">
                        <h2 class="db-headline">TE-Wallet</h2>
                        <p class="db-para"><?php echo $ewallet; ?></p>
                    </div>

                    <button class="db-buttons pink8">More Details</button>

                </div>
                <div class="dash-bord-cuntinars ">

                    <div class="dash-bord-icon">
                        <i class="bi bi-currency-rupee icon-styles pink1" style="font-size: 5vw; position: relative; top: -0.5vw;"></i>
                    </div>
                    <div class="dash-bord-details pink1">
                        <h2 class="db-headline">TS-Wallet</h2>
                        <p class="db-para"><?php echo $swallet; ?></p>
                    </div>

                    <button class="db-buttons pink1">More Details</button>

                </div>
                <div class="dash-bord-cuntinars ">

                    <div class="dash-bord-icon">
                        <i class="bi bi-currency-exchange icon-styles pink3" style="font-size: 5vw; position: relative; top: -0.5vw;"></i>
                    </div>
                    <div class="dash-bord-details pink3">
                        <h2 class="db-headline">TEW-Balance</h2>
                        <p class="db-para"><?php echo $ewallet_balance; ?></p>
                    </div>

                    <button class="db-buttons pink3">More Details</button>

                </div>
                <div class="dash-bord-cuntinars ">

                    <div class="dash-bord-icon">
                        <i class="bi bi-currency-exchange icon-styles pink2" style="font-size: 5vw; position: relative; top: -0.5vw;"></i>
                    </div>
                    <div class="dash-bord-details pink2">
                        <h2 class="db-headline">Withdrow Requcet</h2>
                        <p class="db-para"><?php echo $wprocessingCount; ?></p>
                    </div>

                    <a href="./withdrow_request.php"><button class="db-buttons pink2">More Details</button></a>

                </div>
                <div class="dash-bord-cuntinars ">

                    <div class="dash-bord-icon">
                        <i class="bi bi-currency-rupee icon-styles pink5" style="font-size: 5vw; position: relative; top: -0.5vw;"></i>
                    </div>
                    <div class="dash-bord-details pink5">
                        <h2 class="db-headline">Add Fond Requcet</h2>
                        <p class="db-para"><?php echo $processingCount; ?></p>
                    </div>

                    <a href="./recharge_request.php"><button class="db-buttons pink5">More Details</button></a>

                </div>
                
               
                <div class="dash-bord-cuntinars">

                    <div class="dash-bord-icon">
                        <i class="bi bi-currency-exchange icon-styles pink6" style="font-size: 5vw; position: relative; top: -0.5vw;"></i>
                    </div>
                    <div class="dash-bord-details pink6">
                        <h2 class="db-headline">Total Withdrows</h2>
                        <p class="db-para"><?php echo $ewallet_withdrow; ?></p>
                    </div>

                    <button class="db-buttons pink6">More Details</button>

                </div>
                <div class="dash-bord-cuntinars ">

                    <div class="dash-bord-icon">
                        <i class="bi bi-people-fill icon-styles pink9" style="font-size: 5vw; position: relative; top: -0.5vw;"></i>
                    </div>
                    <div class="dash-bord-details pink9">
                        <h2 class="db-headline">Total Team</h2>
                        <p class="db-para"><?php echo $usersCount; ?></p>
                    </div>

                    <button class="db-buttons pink9">More Details</button>

                </div>
                <div class="dash-bord-cuntinars ">

                    <div class="dash-bord-icon">
                        <i class="bi bi-currency-rupee icon-styles pink7" style="font-size: 5vw; position: relative; top: -0.5vw;"></i>
                    </div>
                    <div class="dash-bord-details pink7">
                        <h2 class="db-headline">Total Recharge</h2>
                        <p class="db-para"><?php echo $ewallet_withdrow; ?></p>
                    </div>

                    <button class="db-buttons pink7">More Details</button>

                </div>
                <div class="dash-bord-cuntinars ">

                    <div class="dash-bord-icon">
                        <i class="bi bi-people-fill icon-styles pink13" style="font-size: 5vw; position: relative; top: -0.5vw;"></i>
                    </div>
                    <div class="dash-bord-details pink13">
                        <h2 class="db-headline">Vaild Users</h2>
                        <p class="db-para"><?php echo $Activecount; ?></p>
                    </div>

                    <button class="db-buttons pink13">More Details</button>

                </div>
                <div class="dash-bord-cuntinars ">

                    <div class="dash-bord-icon">
                        <i class="bi bi-people-fill icon-styles pink10" style="font-size: 5vw; position: relative; top: -0.5vw;"></i>
                    </div>
                    <div class="dash-bord-details pink10">
                        <h2 class="db-headline">Invaild Users</h2>
                        <p class="db-para"><?php echo $InActivecount; ?></p>
                    </div>

                    <button class="db-buttons pink10">More Details</button>

                </div>
                <div class="dash-bord-cuntinars ">

                    <div class="dash-bord-icon">
                        <i class="bi bi-cart4 icon-styles pink11" style="font-size: 5vw; position: relative; top: -0.5vw;"></i>
                    </div>
                    <div class="dash-bord-details pink11">
                        <h2 class="db-headline">No.Of Product Orders</h2>
                        <p class="db-para"><?php echo $delprocessingCount; ?></p>
                    </div>

                    <a href="./all_delivery_report_table.php"><button class="db-buttons pink11">More Details</button></a>

                </div>
                <div class="dash-bord-cuntinars ">

                    <div class="dash-bord-icon">
                        <i class="bi bi-cart4 icon-styles pink12" style="font-size: 5vw; position: relative; top: -0.5vw;"></i>
                    </div>
                    <div class="dash-bord-details pink12">
                        <h2 class="db-headline">Panding Product</h2>
                        <p class="db-para"><?php echo $deL_pad_processingCount; ?></p>
                    </div>

                    <a href="./delivery_report_table.php"><button class="db-buttons pink12">More Details</button></a>

                </div>

            </div>

</section>