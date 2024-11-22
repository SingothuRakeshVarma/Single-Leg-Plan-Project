<?php
include('./user_header.php');
?>
<?php
include('../connect.php');


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



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                <a href="./dash_bord_packages.php"><button type="button" class="button-check red">BACK</button></a>
                <a href="checkout.php?product_code=<?php echo $product_code; ?> " ><button type="submit" class="button-check green">PAY NOW</button>
                </a>
            </div><br><br><br><br><br>



            </div>
        </div>
        
    </section>
    <script>
        

        const smallImages = document.querySelectorAll('.small-image');
        const largeImage = document.querySelector('.large-image');

        smallImages.forEach((image) => {
            image.addEventListener('click', () => {
                largeImage.src = image.src;
            });
        });

       
    </script>
</body>

</html>