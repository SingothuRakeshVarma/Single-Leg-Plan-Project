<?php

include('../connect.php');


session_start();

if (!isset($_SESSION['user_id'])) {
    // If not, redirect to the login page
    header('Location: ../index.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$referral_id = $_SESSION['referalid'];
$referral_name = $_SESSION['referalname'];
$user_image = $_SESSION['images'];
$activation_status = $_SESSION['activation_status'];



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"> -->
    <title>SuccessSLP</title>
    <link rel="shortcut icon" type="image/x-icon" href="../images/SLP LOGO- 1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="./styles.css">
    <script src="./java.js"></script>
    <style>
        .bicnt {
            border-radius: 50%;
            background-image: url(../images/purple-color-burst-hd-wallpaper-wallpaper-preview.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            padding: 20px 25px;
            font-size: 30px;
        }

        .logo_img {
            height: 60px;
            width: 130px;
        }

        .name {
            position: relative;
            left: -10px;

        }

        @media only screen and (min-width: 768px) {
            .logo_img {
                height: 90px;
                width: 60%;
            }

            .name {
                position: relative;
                top: -10px;

            }
        }

        .logout_style {
            position: relative;
            top: -40px;
            left: 12px;
            color: greenyellow;
            font-size: 15px;
            font-weight: bold;
        }

        .fixed-bottom-left {
            width: 80px;
            height: 80px;
            position: fixed;
            bottom: 80px;
            /* Distance from the bottom */
            left: 75%;
            /* Distance from the left */

            color: white;
            /* Text color */
            padding: 10px 15px;
            /* Padding */
            border-radius: 5px;
            /* Rounded corners */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            /* Shadow effect */
            z-index: 1000;
        }

        .bi-wechat {
            font-size: 50px;
            color: whitesmoke;

        }

        .profile_imag {
            border-radius: 50%;
            width: 95px;
            height: 95px;
            z-index: 1;
            padding: 0;
            /* Key change! */
        }

        .icon-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* Center the icon vertically */
        }

        .blinking-icon {

            animation: blink 5s infinite;
            /* Apply the blinking animation */
        }

        @keyframes blink {
            0% {
                color: darkkhaki;
                /* Start color */
            }

            25% {
                color: darksalmon;
                /* Second color */
            }

            50% {
                color: greenyellow;
                /* Third color */
            }

            75% {
                color: yellow;
                /* Fourth color */
            }

            100% {
                color: darkcyan;
                /* Back to start color */
            }
        }

        .mgcount {
            width: 24px;
            height: 25px;
            border-radius: 50%;
            background-color: red;
            text-align: center;
            color: white;
            position: relative;
            top: -105px;
            left: -15px;
        }
    </style>
</head>

<body>
    <section>
        <div class="container_head">
            <div>

                <p class="username"><img src="../images/SLP LOGO- 1.png" class="logo_img"><br><samp class="name"><?php echo $user_name; ?>(<?php echo $user_id; ?>)</samp></p>
            </div>
            <div>
                <a href="./log_out.php"> <img class="profile_imag " src="<?php echo $user_image; ?>"
                        alt="profil_img">
                    <p class="logout_style"><i class="bi bi-box-arrow-right"></i>LOG OUT</p>
                </a>
            </div>
        </div></a>

    </section>
    <section>
        <div class="fixed-bottom-left">
            <a href="./contact_us.php">
                <i class="bi bi-wechat blinking-icon"></i>
            </a>
            <p style="position: relative; left: -15px; top: -12px;" class="blinking-icon">Contact&nbsp;Us</p>
            <?php
            $qurey = "SELECT COUNT(user_id) as mgcount FROM `complaint_box` WHERE watching_status = 'send' AND user_id = '$user_id'";
            $result = mysqli_query($con, $qurey);
            $row = mysqli_fetch_assoc($result);
            $mgcount = $row['mgcount'];
            ?>
            <?php if ($mgcount > 0): ?>
                <p class="mgcount"><?php echo $mgcount; ?></p>
            <?php endif; ?>
        </div>
    </section>
    <section>
        <div class="bot_nav fixed-bottom">
            <div>
                <a href="./home_page.php" onclick="changeIconAndNameColor(event)">
                    <i class="bi bi-house bis" style="color: white;"></i>
                    <div class="icone_name">Home</div>
                </a>
            </div>
            <div>
                <a href="./pramotion.php" onclick="changeIconAndNameColor(event)">
                    <i class="bi bi-person-fill-up bis" style="color: white;"></i>
                    <div class="icone_name">Promotion</div>
                </a>
            </div>
            <div>
                <a href="./packages.php" onclick="changeIconAndNameColor(event)">
                    <i class="bi bi-airplane bis bicnt" style="color: white;"></i>
                    <div class="icone_name" style="position: relative; left:28px;">Floors</div>
                </a>
            </div>
            <div>
                <a href="./wallet.php" onclick="changeIconAndNameColor(event)">
                    <i class="bi bi-wallet2 bis" style="color: white;"></i>
                    <div class="icone_name">Wallet</div>
                </a>
            </div>
            <div>
                <a href="./profile_pro.php" onclick="changeIconAndNameColor(event)">
                    <i class="bi bi-person bis" style="color: white;"></i>
                    <div class="icone_name">Profile</div>
                </a>
            </div>
        </div>
    </section>
    <script>
        // Function to change the color of the icon and icon name
        function changeIconAndNameColor(event) {
            // Reset color of all icons and icon names to white
            document.querySelectorAll('.bis').forEach(icon => {
                icon.style.color = "white";
            });
            document.querySelectorAll('.icone_name').forEach(div => {
                div.style.color = "white";
            });

            // Get the parent element of the clicked element (the hyperlink)
            var parent = event.target.parentNode;

            // Get the icon and icon name elements within the parent
            var icon = parent.querySelector('.bi');
            var iconName = parent.querySelector('.icone_name');

            // Toggle color of the icon and icon name
            icon.style.color = icon.style.color === "greenyellow" ? "white" : "greenyellow";
            iconName.style.color = iconName.style.color === "greenyellow" ? "white" : "greenyellow";

        }
    </script>
</body>

</html>