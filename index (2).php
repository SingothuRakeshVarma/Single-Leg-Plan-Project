<?php
include('./connect.php');



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = mysqli_real_escape_string($con, $_POST["username"]);
    $phonenumber = mysqli_real_escape_string($con, $_POST["phonenumber"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);
    $referalid = mysqli_real_escape_string($con, $_POST["reffid"]);
    $referalname = mysqli_real_escape_string($con, $_POST["referral_name"]);



    function generate_user_id($length = 6)
    {
        $characters = '0123456789';
        $user_id = '';
        for ($i = 0; $i < $length; $i++) {
            $user_id .= $characters[rand(0, strlen($characters) - 1)];
        }
        return 'RV' . $user_id;
    }

    $user_id = generate_user_id();





    if ($referalid !== "") {

        // Get corresponding user name 

        $query = mysqli_query($con, "SELECT username FROM users WHERE userid='$referalid'");

        $row = mysqli_fetch_array($query);



        // Get the first name 
        $reffname = $row['username'];
    }


    //set the role
    $role = "user";

    ///set default image
    $image = 'images/user_image.png'; // default image path

    // Set the joining date
    $joining_date = date("Y-m-d"); // current date

    $query = mysqli_query($con, "SELECT max_referrals FROM admin_charges ");
    $row = mysqli_fetch_array($query);
    $max_reff = $row['max_referrals'];

    $sql = "SELECT COUNT(*) AS processing_count FROM users WHERE referalid='$referalid'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    $referalCount = $row['processing_count'];

    if ($max_reff <= $referalCount) {
        echo '<script>alert("You Have Reaches Your Maximum Referral Limit");window.location.href = "index.php";</script>';
        exit;
    } else {
        $query = mysqli_query($con, "SELECT username FROM users WHERE userid='$referalid'");
        $row = mysqli_fetch_array($query);



        // Validate form data (you may want to add more validation)
        if (empty($user_id) || empty($username) || empty($phonenumber) || empty($password) || empty($referalid) || empty($reffname) || empty($joining_date) || empty($role)) {
            echo "All fields are required.";
        } else {
            // Insert data into the 'users' table
            $sql = "INSERT INTO 
                users ( userid, username, phonenumber, password, referalid, referalname, joining_date, role, tpassword, images, activation_status)
                VALUES ('$user_id','$username', '$phonenumber', '$password', '$referalid', '$reffname', '$joining_date', '$role', '$password', '$image', 'New User')";

            if ($con->query($sql) === TRUE) {
                $query = "INSERT INTO `transaction`(`userids`) VALUES ('$user_id')";
                $result = mysqli_query($con, $query);

                echo '<div class="alert-box">
  <p>New record created successfully.</p>
  <p>User Id: ' . $user_id . '</p>
  <p>Password: ' . $password . '</p>
  <button onclick="window.location.href = \'index.php\';">OK</button>
</div>';
            } else {
                echo '<script>alert("User Already Register");window.location.href = "index.php";</script>';
            }
        }
    }
}



$query = "SELECT * FROM web_maneger_img";
$result = $con->query($query);
$images = array();
while ($row = $result->fetch_assoc()) {
    $images[] = $row['admin_images'];
}

$logo = $images[0];
$I_Slide_1 = $images[1];
$I_Slide_2 = $images[2];
$I_Slide_3 = $images[3];
$I_Slide_4 = $images[4];
$I_Slide_5 = $images[5];
$II_Slide_1 = $images[6];
$II_Slide_2 = $images[7];
$II_Slide_3 = $images[8];
$II_Slide_4 = $images[9];
$II_Slide_5 = $images[10];





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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="./user.css">



    <style>
        /* @import url('https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&display=swap'); */
        /* @import url('https://fonts.googleapis.com/css2?family=Merienda1:wght@300..900&family=Rubik+Dirt&display=swap'); */
        @import url('https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Nosifer&family=Rubik+Dirt&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Jaro:opsz@6..72&family=Quicksand:wght@300..700&display=swap');

        * {
            box-sizing: border-box;
            padding: 0px;
            margin: 0px;
        }

        body {
            margin: 0;
            /* Remove all default margins */
            padding: 0;
            /* Remove all default padding */
        }

        .alert-box {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            width: 300px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 100;
            /* Ensure alert box is on top */
        }

        .alert-box button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .alert-box button:hover {
            background-color: #3e8e41;
        }

        @media only screen and (max-width: 768px) {

            .card_container {
                width: 100%;
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: space-around;
            }

            .card_body {
                width: 35%;
                height: 64vw;
                border-radius: 13px;
                border: solid 1px greenyellow;
                padding: 15px;
                -webkit-box-shadow: 0px 0px 16px 0px rgba(0, 0, 0, 0.75);
                -moz-box-shadow: 0px 0px 16px 0px rgba(0, 0, 0, 0.75);
                box-shadow: 0px 0px 16px 0px rgba(0, 0, 0, 0.75);
                margin: 2vw 0;
            }


            .card_data {
                font-size: 2vw;
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: space-around;

            }

            .card_button {
                border: solid 1px green;
                border-radius: 12px;
                font-size: 2vw;
                width: 10vw;
                padding: 0.6vw 12vw;
                color: white;
                text-decoration: none;
                background-color: greenyellow;
                position: relative;
                top: -6.5vw;
                left: -1.5vw;
            }


            .packages {
                width: 100vw;
                position: relative;
                top: 2vw;
            }

            .image_prod {
                width: 90px;
                height: 90px;
                position: relative;
                top: -2.5vw;
            }

            .h_name {
                font-size: 2.5vw;
            }

            .h_name1 {
                font-size: 2vw;
            }
        }

        @media only screen and (min-width: 1025px) {
            .card_container {
                width: 100%;
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: space-around;
            }

            .card_body {
                width: 18%;
                height: 30.5vw;
                border-radius: 13px;
                border: solid 1px greenyellow;
                padding: 15px;
                -webkit-box-shadow: 0px 0px 16px 0px rgba(0, 0, 0, 0.75);
                -moz-box-shadow: 0px 0px 16px 0px rgba(0, 0, 0, 0.75);
                box-shadow: 0px 0px 16px 0px rgba(0, 0, 0, 0.75);
                margin: 2vw 0;
            }


            .card_data {
                font-size: 1.3vw;
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: space-around;

            }

            .card_button {
                border: solid 2px green;
                border-radius: 12px;
                font-size: 1.5vw;
                width: 5vw;
                padding: 0vw 6.3vw;
                color: white;
                text-decoration: none;
                background-color: greenyellow;

            }


            .packages {
                width: 100vw;
                position: relative;
                top: 2vw;
            }

            .image_prod {
                width: 180px;
                height: 180px;
                position: relative;

                left: 2.4vw;
            }

            .h_name {
                font-size: 1.5vw;
            }

            .h_name1 {
                font-size: 1vw;
            }
        }

        .main-dash-bord {
            position: relative;
            top: 0.0vw;
        }

        .product {
            position: relative;
            top: 5vw;
        }

        .package {
            position: relative;
            top: -50px;
            ;
        }

        .sliders_down {
            position: relative;
            top: 14vw;
        }

        .top_recharge {
            position: relative;
            top: 16vw;
        }



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

        .top-bar-icon {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-between;
            width: 100vw;
            height: 70px;
        }

        .lg_sg {
            display: flex;
            flex-direction: row;
            color: white;
            position: relative;
            top: 1vw;
            right: 4vw;

        }

        .lg_sg_he:hover {
            color: midnightblue;
        }

        .check {
            /* Adjust the padding or margin to remove the distance */
            padding: 0;
            margin-right: 5px;

            /* Style the checkbox */
            width: 15px;
            height: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            background-color: #fff;
            cursor: pointer;
        }

        .check:checked {
            background-color: #4CAF50;
            border: 1px solid #4CAF50;
        }

        .sub_btn {
            width: 23vw;
            background-color: blue;
        }

        .sub_btn:hover {
            width: 23vw;
            background-color: green;
        }

        .profile_icon {
            font-size: 4vh;
            position: relative;
            top: -0.5vw;
        }

        #nav-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .prdname {
            margin-top: 20px;
        }

        .pass_eye {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .fa-eye {
            font-size: 20PX;
            color: lightblue;

        }

        .fa-eye-slash {
            font-size: 20PX;
            color: lightblue;
        }

        .eye {
            position: relative;
            top: 0.5vw;
        }

        .footer {
            width: 100vw;
            height: 5vh;
            background-color: lightgoldenrodyellow;
            text-align: center;
            margin: auto;
            padding: 0 0 0 0;
            position: relative;
            top: 45px;
        }

        .footer_p {
            color: black;
            font-size: 100;
            position: relative;
            top: 7px;
        }

        .logo {
            position: relative;
            left: 10px;
            top: 4px;
            width: 55px;
        }

        .mlines {
            height: 50px;
            font-size: 14vw;
        }

        .modal-content {
            background-color: transparent;
            backdrop-filter: blur(10px);
            color: white;
        }

        .text_in {
            color: white;
        }

        .button_1 {
            background-color: midnightblue;
            /* Initial color for Button 1 */
            color: white;
            padding: 7px 25px;
            border: solid 2px midnightblue;
            cursor: pointer;
            transition: background-color 0.5s ease;
            /* Smooth transition */
        }

        .button_2 {
            background-color: transparent;
            /* Initial color for Button 2 */
            color: white;
            padding: 7px 20px;
            border: solid 2px midnightblue;
            cursor: pointer;
            transition: background-color 0.5s ease;
            /* Smooth transition */
        }

        .real_v {
            font-size: 2.5vw;
        }

        .img_logo {
            width: 60px;
            height: 60px;
            position: relative;
            top: -0.5vw;
        }

        .log_reg {
            font-size: 70%;
            position: relative;
            top: 30px;
            
            height: 20px;

        }

        .real {
            color: orangered;
            font-family: Jaro;
            font-size: 50px;
            position: relative;
            left: 5px;
        }

        .visine {
            color: white;
            font-family: Merienda;
            font-size: 30px;
        }

        @media only screen and (max-width: 768px) {
            .real {
                color: orangered;
                font-family: Jaro;
                font-size: 30px;
                position: relative;
                top: 10px;
                left: 5px;
            }

            .visine {
                color: white;
                font-family: Merienda;
                font-size: 18px;
                
            }
        }
    </style>
    <script>
        const form = document.getElementById('register-form');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm-password');

        form.addEventListener('submit', (e) => {
            e.preventDefault();

            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (password !== confirmPassword) {
                alert('Passwords do not match');
                return;
            }

            // If passwords match, submit the form
            form.requestSubmit();
        });
    </script>
</head>

<body>
    </br>

    <section>

        <div class="top-bar-icon fixed-top" style="background: linear-gradient(0deg, rgba(34,108,195,0.891281512605042) 7%, rgba(45,253,233,1) 68%);">
            <video class="viedoloop" id="nav-video" loop muted autoplay>
                <source src="./images/203987-923133879_medium.mp4" type="video/mp4">
            </video>
            <div class="real_v">
                <p class="real">REAL&nbsp;<span class="visine">VISINE</span></p>
            </div>
            <div class="lg_sg" style="cursor: pointer; " data-bs-toggle="modal" class="lg_sg_he logo" data-bs-target="#staticBackdrop">
                <span class="log_reg">LOGIN||SIGNUP&nbsp;&nbsp;</span><img src="<?php echo $logo; ?>" alt="logo-img" class="img_logo" />
            </div>
        </div>
        <div class="modal fade " id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <input type="button" class="button_1" id="signInLink" value="LOGIN">
                        <input type="button" class="button_2" id="signUpLink" value="REGISTER">
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <form action="loginpage.php" id="signInForm" method="post" class="Register-details">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" id="username" name="username" class="text_in" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <div class="pass_eye">
                                    <input type="password" id="password" name="password" class="text_in" required>
                                    <span class="eye" onclick="togglePassword()">
                                        <i class="fa fa-eye-slash" id="eye-icon"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="sub_btn" name="submit" value="Login">Log In</button>
                                </br>
                                </br>

                            </div>

                        </form>


                        <form class="Register-details" id="signUpForm" style="display: none;" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="fullName">Full Name:</label>
                                <input type="text" id="username" class="text_in" name="username" required>
                            </div>

                            <div class="form-group">
                                <label for="number">Mobile Number:</label>
                                <input type="mobile" name="phonenumber" class="text_in" id="phonenumber" maxlength="10" minlength="required(10)" required />
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" class="text_in" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Confirm Password:</label>
                                <input type="password" id="confirm-password" class="text_in" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="number">Reffral ID:</label>
                                <input type="mobile" name="reffid" id="referral_id" class="text_in" onblur="fetchReferralName(this.value)"/>
                            </div>
                            <div class="form-group">
                                <label for="fullName">Reffral Name:</label>
                                <input type="text" id="referral_name" class="text_in" name="referral_name" readonly>
                            </div>
                            <div class="submit-login">
                                <input type="checkbox" class="check" class="text_in" required><span class="span_check">Your Agree On Our</span><a href="#"> Privacy Policy for REALVISIONE</a>
                            </div>
                            <div>
                                <button type="submit" class="sub_btn" value="submit">Register</button>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div></br></br></br>

    </section>
    <section>
        <div id="container" style="width: 100vw; height: 17vw; position: relative;
      top: 0vh;">
            <!--      <p id="moving-para"><?php echo $move; ?> </p>-->
        </div>
    </section>
    <section class="slides-top" style="position: relative;
       top: -15.5vw;">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?php echo $I_Slide_1; ?>" class="d-block w-100" style="height: 40vw;" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="<?php echo $I_Slide_2; ?>" class="d-block w-100" style="height: 40vw;" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="<?php echo $I_Slide_3; ?>" class="d-block w-100" style="height: 40vw;" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="<?php echo $I_Slide_4; ?>" class="d-block w-100" style="height: 40vw;" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="<?php echo $I_Slide_5; ?>" class="d-block w-100" style="height: 40vw;" alt="...">
                </div>
            </div>
        </div>
    </section>



    <section class="package">
        <h1 style="position: relative; left: 2vw; top: -2vw; width: 350px;">Packages</h1>
        <div class="card_container">
            <?php
            $sql = "SELECT * FROM cartdata WHERE packageorproduct = 'Package'";
            $result = $con->query($sql);
            while ($row = $result->fetch_assoc()) { ?>
                <div class="card_body">


                    <div>
                        <p class="h_name1">ID:<?php echo $row["productcode"]; ?></p>
                        <img class="image_prod" src="<?php echo $row["images_web"]; ?>" alt="" />
                    </div>
                    <center>
                        <h2 class="h_name"><?php echo $row["packagename"]; ?></h2>
                    </center>
                    <div class="card_data">
                        <div>

                            <span>MRP</span></br>
                            <span>Special Price</span></br>
                            <span>SPV</span></br>
                            <span>Pack Vailed</span></br>
                        </div>
                        <div>
                            <span>:</span></br>
                            <span>:</span></br>
                            <span>:</span></br>
                            <span>:</span></br>
                        </div>
                        <div>
                            <span><?php echo $row["mrp"]; ?></span></br>
                            <span><?php echo $row["dp"]; ?></span></br>
                            <span><?php echo $row["spv"]; ?></span></br>
                            <span><?php echo $row["packagealgibulity"]; ?></span></br>
                        </div>
                    </div></br>

                    <div>

                        <a href="./product_viwe.php?product_code=<?php echo $row["productcode"]; ?>" class="card_button" >View</a>




                    </div>

                </div>
            <?php } ?>
        </div>
    </section>
    <section class="product">

        <h1 style="position: relative; left: 2vw; top: -10vw; width: 350px;">Products</h1>
        <div class="card_container">
            <?php
            $sql = "SELECT * FROM cartdata WHERE packageorproduct = 'Product'";
            $result = $con->query($sql);
            while ($row = $result->fetch_assoc()) { ?>
                <div class="card_body">


                    <div>
                        <p>ID:<?php echo $row["productcode"]; ?></p>
                        <img class="image_prod" src="<?php echo $row["images_web"]; ?>" alt="" />
                    </div>
                    <center>
                        <h2 class="prdname"><?php echo $row["packagename"]; ?></h2>
                    </center>
                    <div class="card_data">
                        <div>

                            <span>MRP</span></br>
                            <span>Special Price</span></br>
                            <span>SPV</span></br>
                            <span>Pack Vailed</span></br>
                        </div>
                        <div>
                            <span>:</span></br>
                            <span>:</span></br>
                            <span>:</span></br>
                            <span>:</span></br>
                        </div>
                        <div>
                            <span><?php echo $row["mrp"]; ?></span></br>
                            <span><?php echo $row["dp"]; ?></span></br>
                            <span><?php echo $row["spv"]; ?></span></br>
                            <span><?php echo $row["packagealgibulity"]; ?></span></br>
                        </div>
                    </div></br>

                    <a href="./product_viwe.php?product_code=<?php echo $row["productcode"]; ?>" class="card_button" >View</a>



                </div>
            <?php } ?>
        </div>
    </section>
    <section class="slides-top">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner w-100">
                <div>
                    <h2 class="offers-h1">OFFERS</h2>
                </div>
                <div class="carousel-item active">
                    <img src="<?php echo $II_Slide_1; ?>" class="d-block w-100" style="height: 35vw;" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="<?php echo $II_Slide_2; ?>" class="d-block w-100" style="height: 35vw;" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="<?php echo $II_Slide_3; ?>" class="d-block w-100" style="height: 35vw; " alt="...">
                </div>
                <div class="carousel-item">
                    <img src="<?php echo $II_Slide_4; ?>" class="d-block w-100" style="height: 35vw;" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="<?php echo $II_Slide_5; ?>" class="d-block w-100" style="height: 35vw;" alt="...">
                </div>
            </div>
        </div></br></br>

    </section>
    <footer class="footer">

        <p class="footer_p">© 2024 All Rights Reserved. By Real Visine</p>

    </footer>

    <script>
       

        function fetchReferralName(referral_id) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_referral_name.php?id=' + referral_id, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('referral_name').value = xhr.responseText;
                }
            };
            xhr.send();
        }


        // Add this script to your HTML file or a separate JavaScript file
        const navVideo = document.getElementById('nav-video');

        // Set the video to play in a loop
        navVideo.loop = true;

        // Mute the video to avoid audio conflicts
        navVideo.muted = true;

        // Play the video automatically
        navVideo.play();

        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("eye-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            }
        }
        const signInForm = document.getElementById('signInForm');
        const signUpForm = document.getElementById('signUpForm');
        const signUpLink = document.getElementById('signUpLink');
        const signInLink = document.getElementById('signInLink');

        signUpLink.addEventListener('click', function(event) {
            event.preventDefault();
            signInForm.style.display = 'none';
            signUpForm.style.display = 'block';
            signInLink.style.backgroundColor = 'transparent';
            signUpLink.style.backgroundColor = 'midnightblue';
        });

        signInLink.addEventListener('click', function(event) {
            event.preventDefault();
            signInForm.style.display = 'block';
            signUpForm.style.display = 'none';
            signUpLink.style.backgroundColor = 'transparent';
            signInLink.style.backgroundColor = 'midnightblue';
        });
    </script>
</body>

</html>