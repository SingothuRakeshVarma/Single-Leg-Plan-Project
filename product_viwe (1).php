<?php
include('./connect.php');



if (isset($_GET['product_code'])) {
    // Sanitize the input to prevent XSS attacks
    $product_code = filter_var($_GET['product_code'], FILTER_SANITIZE_STRING);
    
    // Store the sanitized product code in the session
    $_SESSION['product_code'] = $product_code;
}
$product_code =  $_SESSION['product_code'];

$query = mysqli_query($con, "SELECT * FROM cartdata WHERE productcode= $product_code");

$row = mysqli_fetch_array($query);


$product_price = $row['dp'];
$product_mrp = $row['mrp'];
$product_name = $row['packagename'];
$cashback_amount = $row['cashbackamount'];
$spv = $row['spv'];
$packagealgibulity = $row['packagealgibulity'];
$images = $row['images'];
$productdescription = $row['productdescription'];

$discount = $product_mrp - $product_price;
$percentage = ($discount / $product_mrp) * 100;
$percentage = number_format($percentage, 0);



// $query = mysqli_query($con, "SELECT * FROM product_images WHERE product_code= $product_code");

// $row = mysqli_fetch_array($query);

// $images1 = $row['image_1'];
// $images2 = $row['image_2'];
// $images3 = $row['image_3'];
// $images4 = $row['image_4'];
// $images5 = $row['image_5'];

$query = "SELECT * FROM web_maneger_img";
$result = $con->query($query);
$images = array();
while ($row = $result->fetch_assoc()) {
    $images[] = $row['admin_images'];
}

$logo = $images[0];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realvisine</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $logo; ?>">
    <link rel="stylesheet" href="./user.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        .pro_details {
            width: 70%;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-around;

        }

        .deta_details {
            font-size: 120%;
        }

        .avatar-img12 {
            padding: 2vw 0 0 0;
        }

        .page-container123 {
            margin: 1vw 3vw;

            backdrop-filter: blur(50px);
            background-color: white;
            align-items: center;

            box-shadow: 0 8px 32px 0 rgb(0, 0, 0.1);
        }

        .d-details {
            padding: 1.5vw 2vw;
        }


        .large-image {
            width: 300px;
            height: 300px;
            object-fit: cover;
        }

        .small-images-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            width: 50%;
        }

        .small-image {
            width: 8vw;
            height: 8vw;

            cursor: pointer;
        }

        .button_1 {
            background-color: blue;
            /* Initial color for Button 1 */
            color: white;
            padding: 7px 25px;
            border: solid 2px blue;
            cursor: pointer;
            transition: background-color 0.5s ease;
            /* Smooth transition */
        }

        .button_2 {
            background-color: transparent;
            /* Initial color for Button 2 */
            color: white;
            padding: 7px 20px;
            border: solid 2px blue;
            cursor: pointer;
            transition: background-color 0.5s ease;
            /* Smooth transition */
        }

        .modal-content {
            background-color: transparent;
            backdrop-filter: blur(10px);
            color: white;
            
        }
    </style>
</head>

<body>


    <section>

        <div class="page-container123">


            <div class="avatar-img12">
                <center>
                    <?php
                    if (isset($_GET['product_code'])) {
                        // Sanitize the input to prevent XSS attacks
                        $product_code = filter_var($_GET['product_code'], FILTER_SANITIZE_STRING);
                        
                        // Store the sanitized product code in the session
                        $_SESSION['product_code'] = $product_code;
                    }
                    $product_code =  $_SESSION['product_code'];
                    $sql = "SELECT * FROM product_images WHERE product_code = '$product_code'";
                    $result = $con->query($sql);
                    while ($row = $result->fetch_assoc()) { ?>
                        <div class="large-image-container">
                            <img src="<?php echo $row['image_1']; ?>" alt="Image 1" class="large-image">
                        </div>

                        <!-- The small images container -->
                        <div class="small-images-container">
                            <?php
                            $imageCount = 1;
                            while ($imageCount <= 5) {
                                if (!empty($row["image_$imageCount"])) {
                                    echo "<img src='" . $row["image_$imageCount"] . "' alt='image_alt' class='small-image'>";
                                }
                                $imageCount++;
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                </center>
            </div>
            <div>

                <div>
                    <center>
                        <div class="p-h-name">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $product_name; ?></div><br>
                    </center>


                </div>
                <center>
                    <div class="pro_details">
                        <div>
                            <span class="deta_details">Price</span></br>
                            <span class="deta_details">Discount</span></br>
                            <span class="deta_details">SPV</span></br>
                            <span class="deta_details">Pack Vailed</span>
                            
                        </div>
                        <div>
                            <span class="deta_details">:</span></br>
                            <span class="deta_details">:</span></br>
                            <span class="deta_details">:</span></br>
                            <span class="deta_details">:</span>
                        </div>
                        <div>
                            <span class="deta_details"><?php echo $product_price; ?></span></br>
                            <span class="deta_details"><?php echo  $cashback_amount; ?></span></br>
                            <span class="deta_details"><?php echo  $spv; ?></span></br>
                            <span class="deta_details"><?php echo $packagealgibulity; ?></span>
                        </div>

                    </div>
                    <div class="deta_details" style="color:green; font-weight: 7vw;"><?php echo $percentage; ?>%<i class="bi bi-arrow-down" style="font-size: 17px;position:relative;top: -2px; text-decoration: line-through; color:red; font-weight: 7vw;"><?php echo $product_mrp; ?></i> &nbsp;<span style="font-size: 20px; color:green; font-weight: 20px;">SAVE&nbsp;<?php echo $discount; ?>/-</span></div>
                </center>

                <div>
                    <div class="c-details">
                        Discription
                    </div>
                    <center>
                        <div class="d-details">
                            <?php echo $productdescription; ?>
                        </div>
                    </center>
                </div>
                </center>
                <div class="button-check-div">
                    <a href="./index.php"><button type="button" class="button-check red">BACK</button></a>
                    <button type="submit" class="button-check green" data-bs-toggle="modal" data-bs-target="#staticBackdrop">PAY NOW</button>
                    </a>
                </div><br><br><br><br><br><br>
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


                        <form class="Register-details" id="signUpForm" style="display: none;" action="./index.php" method="post" enctype="multipart/form-data">
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
                                <input type="mobile" name="reffid" id="referral_id" class="text_in" onblur="fetchReferralName(this.value)" />
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
    <script>
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

        const smallImages = document.querySelectorAll('.small-image');
        const largeImage = document.querySelector('.large-image');

        smallImages.forEach((image) => {
            image.addEventListener('click', () => {
                largeImage.src = image.src;
            });
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
    </script>
</body>

</html>