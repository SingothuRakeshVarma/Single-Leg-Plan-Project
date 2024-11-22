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
$referal_id = $_SESSION['referalid'];
$referalname =  $_SESSION['referalname'];
$image = $_SESSION['images'];
$phonenumber = $_SESSION['phonenumber'];

$query = "SELECT * FROM web_maneger_img WHERE placetype = 'logo'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$logo = $row["images"];
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realvisine</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $logo; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../admin-panel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../user.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    
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
        .logo{
             height: 20%;
            width: 30%;
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
                                <P class="topup-p"><?php echo $referal_id; ?></P>
                            </div>
                            <div class="customer-id">
                                <center>
                                    <h3 class="topup-hl">DESIGNATION</h3>
                                </center>
                                <P class="topup-p">GOLD</P>
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

    <section class="navigation">
        <div class="nav-bar fixed-bottom ">
            <div>
                <a href="./admin_homepage.php">
                    <i class="bi bi-house-add-fill"></i></a>
            </div>
            <div>
                <a href="./masters.php">
                    <i class="bi bi-graph-up-arrow"></i>
                </a>
            </div>
            <div>
                <a href="./tables_shows.php">
                    <i class="bi bi-cart4"></i>

                </a>
            </div>
            <div>
                <a href="./users_reports.php">
                    <i class="bi bi-journals"></i>
                </a>
            </div>
            <div>
                <a href="./managers.php">
                    <i class="bi bi-people-fill"></i>
                </a>
            </div>
        </div>
    </section>

</body>

</html>