<?php
include("../connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

    function generate_user_id($length = 6)
    {
        $characters = '123456789';
        $user_id = '';
        for ($i = 0; $i < $length; $i++) {
            $user_id .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $user_id;
    }

    $user_id = generate_user_id();

    // Check if image is uploaded
    if (isset($_FILES['image'])) {
        // Get image metadata
        $image = $_FILES['image'];
        $imageName = $image['name'];
        $imageType = $image['type'];
        $imageSize = $image['size'];
        $imagePath = '../user_panel/images/' . $imageName;
        $image_path = './images/' . $imageName;
        $image_path1 = '../images/' . $imageName;

        // Move uploaded image to local storage
        move_uploaded_file($image['tmp_name'], $imagePath);
        copy($imagePath, $image_path);
        copy($image_path, $image_path1);


       
            // Prepare the SQL query with parameterized values
            $stmt = $con->prepare("INSERT INTO `cartdata` (`images_web`, `productcode`, `images`, `category`, `packageorproduct`, `sub_category`, `packagename`, `mrp`, `dp`, `spv`, `referralvalue`, `swalletdiscount`, `addswalletfund`, `packagealgibulitytype`, `packagealgibulity`, `cashbackamount`, `sharefond`, `noofsharepoints`, `productdescription`) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "sssssssssssssssssss",
                $image_path,
                $user_id,
                $imagePath,
                $category,
                $packageorproduct,
                $subcategory,
                $packagename,
                $mrp,
                $dp,
                $spv,
                $referralvalue,
                $swalletdiscount,
                $addswalletfund,
                $packagealgibulitytype,
                $packagealgibulity,
                $cashbackamount,
                $sharefond,
                $noofsharepoints,
                $productdescription
            );

            if ($stmt->execute()) {
                echo '<script>alert("Product data saved successfully!");window.location.href = "package_master.php";</script>';
            } else {
                echo "Error: " . $stmt->error;
            }
        
    }
} else {
    header("Location: package_master.php");
    exit();
}

$con->close();
