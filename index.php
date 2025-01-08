<?php
include('./connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_POST["register"])) {

    $username = mysqli_real_escape_string($con, $_POST["username"]);
    $phonenumber = mysqli_real_escape_string($con, $_POST["phonenumber"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);
    $referalid = mysqli_real_escape_string($con, $_POST["reffid"]);
    $referalname = mysqli_real_escape_string($con, $_POST["referral_name"]);

    echo "phonenumber: " . $phonenumber;

    function generate_user_id($length = 6)
    {
        $characters = '123456789';
        $user_id = '';
        for ($i = 0; $i < $length; $i++) {
            $user_id .= $characters[rand(0, strlen($characters) - 1)];
        }
        // return 'RV' . $user_id;
        return 'SLP' . $user_id;
    }

    $user_id = generate_user_id();





    if ($referalid !== "") {

        // Get corresponding user name 

        $query = mysqli_query($con, "SELECT user_name FROM user_data WHERE user_id='$referalid'");

        $row = mysqli_fetch_array($query);



        // Get the first name 
        $reffname = $row['user_name'];
    }


    //set the role
    $role = "user";

    ///set default image
    $image = 'images/user_image.png'; // default image path

    // Set the joining date
    $joining_date = date("Y-m-d H:i:s"); // current date and time

    $query = mysqli_query($con, "SELECT max_referrals FROM admin_charges ");
    $row = mysqli_fetch_array($query);
    $max_reff = $row['max_referrals'];

    $sql = "SELECT COUNT(*) AS processing_count FROM user_data WHERE referalid='$referalid'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    $referalCount = $row['processing_count'];

    if ($max_reff <= $referalCount) {
        echo '<script>alert("You Have Reaches Your Maximum Referral Limit");window.location.href = "index.php";</script>';
        exit;
    } else {

        // Validate form data (you may want to add more validation)
        if (empty($user_id) || empty($username) || empty($phonenumber) || empty($password) || empty($referalid) || empty($reffname) || empty($joining_date) || empty($role)) {
            echo "All fields are required.";
        } else {
            // Insert data into the 'user_data' table
            $sql = "INSERT INTO 
                user_data ( user_id, user_name, phone_number, password, referalid, referalname, joining_date, role, tpassword, images, activation_status)
                VALUES ('$user_id','$username', '$phonenumber', '$password', '$referalid', '$reffname', '$joining_date', '$role', '$password', '$image', 'New User')";

            if ($con->query($sql) === TRUE) {
                $query = "INSERT INTO `user_wallet`(`user_id`, `user_name`) VALUES ('$user_id', '$username')";
                $result = mysqli_query($con, $query);

                // Success Notification HTML
                echo '             
                 <div class="alert-box">
                     <div class="success-circle active">
                         <div class="checkmark"></div>
                     </div>
                     <p class="new_record">New record created successfully.</p>
                     <p>User Id: ' . $user_id . '</p>
                     <p>User Name: ' . $username . '</p>
                     <p>Password: ' . $password . '</p>
                     <p>Mobile Number: ' . $phonenumber . '</p>
                     <button onclick="window.location.href = \'index.php\';">OK</button>
                 </div>';
            } else {
                echo '<script>alert("User Already Register");window.location.href = "index.php";</script>';
            }
        }
    }
}





?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Successslp</title>
    <link rel="shortcut icon" type="image/x-icon" href="./images/SLP LOGO- 1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="./user_panel/styles.css">
    

    <style>
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

        .success-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 5px solid #4CAF50;
            /* Green circle */
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            /* Center the circle */

        }

        .checkmark {
            display: none;
            /* Initially hidden */
            position: relative;
            width: 20px;
            height: 20px;
        }

        .checkmark:before {
            content: "";
            position: absolute;
            width: 15px;
            height: 5px;
            background: #4CAF50;
            top: 12px;
            left: -5px;
            transform: rotate(45deg);
        }

        .checkmark:after {
            content: "";
            position: absolute;
            width: 5px;
            height: 31px;
            background: #4CAF50;
            top: -5px;
            left: 15px;
            transform: rotate(45deg);
        }

        .success-circle.active .checkmark {
            display: block;
            /* Show checkmark when active */
        }

        button {
            background-color: #4CAF50;
            /* Green */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
            /* Darker green on hover */
        }

        .new_record {
            font-weight: bold;
            color: darkgreen;
        }

        .button_1 {
            width: 25%;
            height: 50px;
            position: relative;
            top: 20px;

            border: solid 2px darkcyan;
            background-color: darkcyan;
            color: white;
        }

        .button_2 {
            width: 25%;
            height: 50px;
            position: relative;
            top: 20px;

            border: solid 2px darkcyan;
            background-color: transparent;
            color: white;
        }



        .h1_line {
            text-align: center;
        }

        .button-check {
            width: 30%;
            height: 30%;
            border: solid 2px lightseagreen;
            border-radius: 30px;
            color: white;
            background-color: transparent;
            margin-left: 30px;
            margin-right: 20px;
        }

        .button-check:hover {
            width: 30%;
            height: 30%;
            border: solid 2px lightseagreen;
            border-radius: 30px;
            color: white;
            background-color: lightseagreen;
        }

        input[type="password"] {
            text-align: center;
            color: greenyellow;

        }

        input[type="password"]:hover {
            text-align: center;
            color: lightseagreen;
        }

        input[type="mobile"] {
            text-align: center;
            color: greenyellow;

        }

        input[type="mobile"]:hover {
            text-align: center;
            color: lightseagreen;
        }

        .loading-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('./images/SLP\ LOGO-\ 1.png') no-repeat center center;
            background-size: 300px;

            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 2em;
         
            /* Blur effect */
            transition: filter 0.3s ease;
            z-index: 999
            /* High z-index to stay on top */
        }

        #mainContent {
            display: none;
            /* Initially hidden */
        }

        #dots {
            display: inline-block;
        }

        .loading_text {
            font-size: 1.5em;
            position: relative;
            top: 20%;
            font-family: 'Times New Roman', Times, serif;
        }
        .logo_img {
        width: 60%;
        height: 40%;
       
    }
    
/*    .profile_imag {*/
/*    border-radius: 0%;*/
/*    width: 70%;*/
/*    height: 70%;*/

/*    z-index: 1;*/

    /* Key change! */
/*}*/
    </style>
      
</head>

<body>
    <div class="loading-container" id="loadingScreen">
        <div class="loading_text">SuccessSLP<span id="dots">...</span></div>
    </div>
 <script>
         document.addEventListener("DOMContentLoaded", function() {
            // Simulate loading for 3 seconds
            setTimeout(function() {
                // Hide the loading screen
                document.getElementById('loadingScreen').style.display = 'none';
                // Show the main content
                document.getElementById('mainContent').style.display = 'block';
            }, 4000); // Adjust the time as needed
        });
        // Function to update the dots animation
        let dotCount = 0;
        const maxDots = 3;
        const dotElement = document.getElementById('dots');

        function updateDots() {
            dotCount = (dotCount + 1) % (maxDots + 1);
            dotElement.textContent = '.'.repeat(dotCount);
        }

        // Start dots animation every 500ms
        setInterval(updateDots, 500);

        // Call the function to start the delay
        showContentAfterDelay();
    </script>
    <!-- <div id="loadingScreen">
        <video id="myVideo" width="100%" controls>
            <source src="" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div> -->
    <section>
        <div class="container_head">
            <div>

                <p class="username"><img src="./images/SLP LOGO- 1.png" class="logo_img">
            </div>
            <div>
<!--                <video class="profile_video" controls>-->
<!--    <source src="./images/WhatsApp Video 2024-12-01 at 14.20.27_c50f3d02.mp4" type="video/mp4">-->
   
<!--</video>-->
            </div>
        </div>

    </section><br><br>
    <section>
        <div class="login_container">
            <div>
                <center>
                    <div class="">
                        <input type="button" class="button_1" id="signInLink" value="LogIn">
                        <input type="button" class="button_2" id="signUpLink" value="SignUp">


                    </div><br><br>
                    <form action="loginpage.php" id="signInForm" method="post">
                        <div class="form-group">
                            <label for="username" class="prof_label">Username:</label><br>
                            <input type="text" id="username" name="username" class="prof_text" style="width: 62%;" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="prof_label">Password:</label>
                            <div class="pass_eye">
                                <input type="password" id="password" name="password" class="prof_text" style="width: 60%;" required>
                                <span class="eye" onclick="togglePassword()">
                                    <i class="fa fa-eye-slash" id="eye-icon"></i>
                                </span>
                            </div>
                        </div><br><br>
                        <div class="form-group">
                            <input type="submit" class="button-check" name="submit" value="Log In"><br>
                            </br>
                            </br>

                        </div>

                    </form>


                    <form class="Register-details" id="signUpForm" style="display: none;" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="fullName" class="prof_label">Full Name:</label><br>
                            <input type="text" id="username" class="prof_text" name="username" style="width: 60%;" maxlength="15" required>
                        </div>

                        <div class="form-group">
                            <label for="number" class="prof_label">Mobile Number:</label><br>
                            <input type="mobile" name="phonenumber" class="prof_text" style="width: 60%;" maxlength="10" minlength="required(10)" required />
                        </div>
                        <div class="form-group">
                            <label for="password" class="prof_label">Password:</label><br>
                            <input type="password" id="password" class="prof_text" name="password" style="width: 60%;" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="prof_label">Confirm Password:</label><br>
                            <input type="password" id="confirm-password" class="prof_text" name="password" style="width: 60%;" required>
                        </div>
                        <div class="form-group">
                            <label for="number" class="prof_label">Reffral ID:</label><br>
                            <input type="text" name="reffid" id="referral_id" class="prof_text" style="width: 60%;" onblur="fetchReferralName(this.value)" />
                        </div>
                        <div class="form-group">
                            <label for="fullName" class="prof_label">Reffral Name:</label><br>
                            <input type="text" id="referral_name" class="prof_text" name="referral_name" style="width: 60%;" readonly>
                        </div><br>
                        <div class="submit-login">
                            <input type="checkbox" class="check" class="prof_text" required><span class="span_check">Your Agree On Our</span><a href="#"> Privacy Policy for SUCCESSSLP</a>
                        </div><br>
                        <div>
                            <button type="submit" class="button-check green" name="register" value="submit">Register</button>

                        </div>
                    </form><br><br><br>
                </center>

            </div>
        </div>
    </section>
    <script>
       

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
            signUpLink.style.backgroundColor = 'darkcyan';
        });

        signInLink.addEventListener('click', function(event) {
            event.preventDefault();
            signInForm.style.display = 'block';
            signUpForm.style.display = 'none';
            signUpLink.style.backgroundColor = 'transparent';
            signInLink.style.backgroundColor = 'darkcyan';
        });

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
       
    </script>

</body>

</html>