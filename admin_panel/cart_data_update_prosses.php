<?php
$host = "localhost";
$username = "trcelioe_realvisinewebsite";
$password = "Realvisine";
$database = "trcelioe_user_data";


$con = new mysqli($host, $username, $password, $database);


if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $packageorproduct = $_POST["packageorproduct"];
    $category = $_POST["category"];
    $subcategory = $_POST["sub_category"];
    $packagename = $_POST["packagename"];
    $mrp = $_POST["mrp"];
    $dp = $_POST["dp"];
    $spv = $_POST["spv"];
    $referralvalue = $_POST["referralvalue"];
    $swalletdiscount = $_POST["swalletdiscount"];
    $addswalletfund = $_POST["addswalletfund"];
    $packagealgibulitytype = $_POST["packagealgibulitytype"];
    $packagealgibulity = $_POST["packagealgibulity"];
    $cashbackamount = $_POST["cashbackamount"];
    $sharefond = $_POST["sharefond"];
    $noofsharepoints = $_POST["noofsharepoints"];
    $productdescription = $_POST["productdescription"];
    $image_path = '';

  // Validate and sanitize user input data
    $id = mysqli_real_escape_string($con, $id);
    $packageorproduct = mysqli_real_escape_string($con, $packageorproduct);
    $category = mysqli_real_escape_string($con, $category);
    $subcategory = mysqli_real_escape_string($con, $subcategory);
    $packagename = mysqli_real_escape_string($con, $packagename);
    $mrp = mysqli_real_escape_string($con, $mrp);
    $dp = mysqli_real_escape_string($con, $dp);
    $spv = mysqli_real_escape_string($con, $spv);
    $referralvalue = mysqli_real_escape_string($con, $referralvalue);
    $swalletdiscount = mysqli_real_escape_string($con, $swalletdiscount);
    $addswalletfund = mysqli_real_escape_string($con, $addswalletfund);
    $packagealgibulitytype = mysqli_real_escape_string($con, $packagealgibulitytype);
    $packagealgibulity = mysqli_real_escape_string($con, $packagealgibulity);
    $cashbackamount = mysqli_real_escape_string($con, $cashbackamount);
    $sharefond = mysqli_real_escape_string($con, $sharefond);
    $noofsharepoints = mysqli_real_escape_string($con, $noofsharepoints);
    $productdescription = mysqli_real_escape_string($con, $productdescription);


    // Check if image is uploaded
    if (isset($_FILES['image'])) {
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image'];
            $imageName = $image['name'];
            $imageType = $image['type'];
            $imageSize = $image['size'];
            $imagePath = '../user_panel/images/' . $imageName;
            $image_path = './images/' . $imageName;
            $image_path1 = '../images/' . $imageName;
            if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                // Copy file to another location (not sure why you need this, but I'll leave it)
                move_uploaded_file($image['tmp_name'], $imagePath);
                copy($imagePath, $image_path1);
                copy($image_path1, $image_path);
            } else {
                // Handle upload error
                echo 'Error uploading image';
            }
        } elseif (isset($_POST['image_data'])) {
            // If no image is uploaded, use the existing image path
            $image_path = $_POST['image_data'];
        } else {
            // If no image is uploaded and no existing image path is provided, use a default value
            $image_path = 'default_image_path';
        }
    }
    // Insert image metadata into database
    $sql = "UPDATE `cartdata` SET  
        `images` = '$image_path', 
        `images_web` = '$image_path',
        `packageorproduct` = '$packageorproduct',
        `category` = '$category',
        `sub_category` = '$subcategory',
        `mrp` = '$mrp',
    `dp` = '$dp',
    `spv` = '$spv',
    `referralvalue` = '$referralvalue',
    `swalletdiscount` =  '$swalletdiscount',
    `addswalletfund` = '$addswalletfund',
    `packagealgibulitytype` = '$packagealgibulitytype',
    `packagealgibulity` = '$packagealgibulity',
    `cashbackamount` = '$cashbackamount',
    `sharefond` = '$sharefond',
    `noofsharepoints` = '$noofsharepoints',
    `productdescription` = '$productdescription',
        `packagename` = '$packagename' WHERE `productcode` = '$id' ";
    $result = mysqli_query($con, $sql);
   
    echo '<script>alert("Image and Data uploaded successfully!");window.location.href = "cart_data_table.php";</script>';
}


?>