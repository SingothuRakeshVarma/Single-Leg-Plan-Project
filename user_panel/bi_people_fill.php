<?php
include('../connect.php');
session_start();

if (!isset($_SESSION['userid'])) {
    // If not, redirect to the login page
    header('Location: ../index.php');
    exit;
}

$user_id = $_SESSION['userid'];
$user_name = $_SESSION['username'];
$referalid = $_SESSION['referalid'];
$referalname =  $_SESSION['referalname'];
$image = $_SESSION['images'];
$phonenumber = $_SESSION['phonenumber'];

$status = $_SESSION['activation_status'];

$query = "SELECT * FROM web_maneger_img WHERE placetype = 'logo'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$logo = $row["images"];

$sql = "SELECT COUNT(*) AS processing_count FROM designation WHERE user_id = '$user_id'";
$result = $con->query($sql);

//  Retrieve the Count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $count = $row['processing_count'];
    if ($count > 0) {
        $dprocessingCount = "DIAMOND : $count";
    } else {
        $dprocessingCount = "NEW JOINED";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realvisine</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $logo; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../user.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap');
    </style>
    <style>
        .topup-hl {
            height: 100%;
            width: 100%;
            color: white;
            font-size: 120%;
            background-color: midnightblue;
            border-top-left-radius: 17px;
            border-top-right-radius: 17px;
            font-family: Crimson;

        }

        .topup-p {
            color: midnightblue;

        }

        .red {
            position: relative;
            left: 0.5vw;
        }
        .footer {
            width: 100vw;
            height: 5vh;
            background-color: lightgoldenrodyellow;
            text-align: center;
            margin: auto;
            padding: 0.5vw 0 0 0;
        }
        .footer_p{
            color: black;
            font-size: 1vw;
        }
        .logo{
            width: 25%;
            height: 25%;
        }
         .profile_id {
        position: relative;
        top: -2vw;
        font-size: 110%;
    }
  .profile-name{
        font-size: 140%;
        
    }
    .report-lists{
        
         font-size: 8vh;
    }
    .reports{
        padding: 2vw 0;
    }
    </style>

</head>

<body>
    <section>

        <div class="top-bar-icons fixed-top" style="background-color: rgb(40, 121, 142);">

            <div>
                <img class="logo" src="<?php echo $logo; ?>" alt="logo-img" />
            </div>
            <div>
                <img class="profile-avatar" src="<?php echo $image; ?>" alt="profile" data-bs-toggle="modal" data-bs-target="#staticBackdrop" />
            </div>

        </div>
        <div class="modal fade " id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-20px black" id="staticBackdropLabel">Profile</h1>
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <center> <img src="<?php echo $image; ?>" class="customer-avatar" alt="customer-img" /></center>
                        </div>
                        <center>
                            <div class="customer-name">
                                <h1 class="c-name"><?php echo $user_name; ?></h1>
                            </div>
                        </center>
                        <div class="customer-details">
                            <div class="customer-id">
                                <center>
                                    <h3 class="topup-hl">USER ID</h3>
                                </center>
                                <P class="topup-p"><?php echo $user_id; ?></P>
                            </div>
                            <div class="customer-id">
                                <center>
                                    <h3 class="topup-hl">SPONSER ID</h3>
                                </center>
                                <P class="topup-p"><?php echo $referalid; ?></P>
                            </div>
                            <div class="customer-id">
                                <center>
                                    <h3 class="topup-hl">STATUS</h3>
                                </center>
                                <P class="topup-p"><?php echo $status; ?></P>
                            </div>
                            <div class="customer-id">
                                <center>
                                    <h3 class="topup-hl">DESIGNATION</h3>
                                </center>
                                <P class="topup-p"><?php echo $dprocessingCount; ?></P>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="./logout.php"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Log Out</button></a>


                    </div>
                </div>
            </div>
        </div></br></br></br>

    </section>
    <section class="navigation" id="nav-bar">
        
        <div class="nav-bar fixed-bottom " id="nav-bar" style="background-color: rgb(29, 8, 76);">
            <div>
                <a href="./dash_bord.php">
                    <i class="bi bi-house-add-fill"></i></a>
            </div>
            <div>
                <a href="./graph_up_arrow.php">
                    <i class="bi bi-graph-up-arrow"></i>
                </a>
            </div>
            <div>
                <a href="./bi_cart4.php">
                    <i class="bi bi-cart4"></i>

                </a>
            </div>
            <div>
                <a href="./bi_journals.php">
                    <i class="bi bi-journals"></i>
                </a>
            </div>
            <div>
                <a href="./bi_people_fill.php">
                    <i class="bi bi-people-fill"></i>
                </a>
            </div>
        </div>
        
    </section>
    

<section>
        <div class="profile-details">
        <img class="profile-img" src="<?php echo $image; ?>" alt="">
            <p class="profile-name"><?php echo $user_name; ?></p>
            <p class="profile_id">User ID : <span style="color: red;"> <?php echo $user_id; ?></span></p>
        </div>
    </section>
    <section>

        <div class="report-container row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-5">
            <div class="reports">
                <a href="./profile_update.php" style="text-decoration: none;"><i class="bi bi-person-lines-fill report-lists"></i><samp class="r-name">
            Profile Update</samp></a>
            </div>
            <div class="reports">
                <a href="./account_detailes.php" style="text-decoration: none;"><i class="bi bi-bank report-lists"></i><samp class="r-name">
            Account Detailes </samp></a>
            </div>
            <div class="reports">
                <a href="./change_password.php" style="text-decoration: none;"><i class="bi bi-house-lock-fill report-lists"></i><samp class="r-name">
                Change password </samp></a>
            </div>
            <!-- <div class="reports">
                <a href="#" style="text-decoration: none;"><i class="bi bi-cart4 report-lists"></i><samp class="r-name">
             </samp></a>
            </div>
            <div class="reports">
                <a href="#" style="text-decoration: none;"><i class="bi bi-cart4 report-lists"></i><samp class="r-name">
            profile </samp></a>
            </div>
            <div class="reports">
                <a href="#" style="text-decoration: none;"><i class="bi bi-cart4 report-lists"></i><samp class="r-name">
            profile </samp></a>
            </div> -->
        </div><br><br><br>
    </section>
    </body>
    </html>