<?php
include('header.php');
include('../connect.php');

$query = "SELECT DISTINCT * FROM web_maneger_img WHERE placetype = 'move_text'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

$move = $user['images'];

$query = mysqli_query($con, "SELECT * FROM web_maneger_img");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

$images = array();
foreach ($rows as $row) {
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
$qr_code = $images[11];




?>
<style>
    .web-container {
        width: 90%;
    }

    .submit_buton {
        width: 10vw;
        height: 2.5vw;
        border-radius: 12px;
    }

    .active-id {
        border-color: transparent;
    }

    .image_slid {
        width: 400px;
        height: 100px;
    }
  
</style>
<section>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="web-container" method="POST" enctype="multipart/form-data">


        <input type="profile" class="active-id" name='logo' value='logo' readonly />
        <input type="file" id="image-input" name="image">
        <img id="image-preview" src="<?php echo $logo; ?>" class="image_slid" alt="Image Preview" value="" readonly>
        <input type="submit" class="submit_buton" name="submit" value="submit"><br><br><br><br><br><br><br><br>

        <?php

        if (isset($_POST['submit'])) {
            $logo = $_POST['logo'];





            // Check if image is uploaded
            if (isset($_FILES['image'])) {
                // Get image metadata
                $image = $_FILES['image'];
                $imageName = $image['name'];
                $imageType = $image['type'];
                $imageSize = $image['size'];
                $imagePath = '../user_panel/images/' . $imageName;
                $image_path = '../images/' . $imageName;
                $image_path1 = './images/' . $imageName;

                // Move uploaded image to local storage
                move_uploaded_file($image['tmp_name'], $imagePath);
                copy($imagePath , $image_path);
                copy($image_path , $image_path1);

                // Insert image metadata into database
                $sql = "UPDATE `web_maneger_img` SET images = '$imagePath', admin_images = '$image_path1' WHERE placetype = '$logo' ";
                $result = mysqli_query($con, $sql);
                echo '<script>alert("Image uploaded successfully!");window.location.href = "web_manager.php";</script>';
                
            }
        }
        ?>
    </form>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="web-container" method="POST" enctype="multipart/form-data">

        <input type="profile" class="active-id" name='I_Slide_1' value='I_Slide_1' readonly />
        <input type="file" id="image-input" name="image1">
        <img id="image-preview" src="<?php echo $I_Slide_1; ?>" class="image_slid" alt="Image Preview" value="" readonly>
        <input type="submit" class="submit_buton" name="submit1" value="submit"><br><br><br><br><br><br><br><br>

        <?php

        if (isset($_POST['submit1'])) {
            $I_Slide_1 = $_POST['I_Slide_1'];




            // Check if image is uploaded
            if (isset($_FILES['image1'])) {
                // Get image metadata
                $image = $_FILES['image1'];
                $imageName = $image['name'];
                $imageType = $image['type'];
                $imageSize = $image['size'];
                $imagePath = '../images/' . $imageName;
                $image_path = './images/' . $imageName;
               

                // Move uploaded image to local storage
            move_uploaded_file($image['tmp_name'], $imagePath);
            copy($imagePath , $image_path);

                // Insert image metadata into database
                $sql = "UPDATE `web_maneger_img` SET images = '$imagePath', admin_images = '$image_path' WHERE placetype = '$I_Slide_1' ";
                $result = mysqli_query($con, $sql);
                echo '<script>alert("Image uploaded successfully!");window.location.href = "web_manager.php";</script>';
               
            }
        }
        ?>
    </form>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="web-container" method="POST" enctype="multipart/form-data">

        <input type="profile" class="active-id" name='I_Slide_2' value='I_Slide_2' readonly />
        <input type="file" id="image-input" name="image2">
        <img id="image-preview" src="<?php echo $I_Slide_2; ?>" class="image_slid" alt="Image Preview" value="<?php echo $image; ?>" readonly>
        <input type="submit" class="submit_buton" name="submit2" value="submit"><br><br><br><br><br><br><br><br>
    </form>
    <?php

    if (isset($_POST['submit2'])) {
        $I_Slide_2 = $_POST['I_Slide_2'];




        // Check if image is uploaded
        if (isset($_FILES['image2'])) {
            // Get image metadata
            $image = $_FILES['image2'];
            $imageName = $image['name'];
            $imageType = $image['type'];
            $imageSize = $image['size'];
            $imagePath = '../images/' . $imageName;
            $image_path = './images/' . $imageName;

            // Move uploaded image to local storage
            move_uploaded_file($image['tmp_name'], $imagePath);
             copy($imagePath , $image_path);

            // Insert image metadata into database
            $sql = "UPDATE `web_maneger_img` SET images = '$imagePath', admin_images = '$image_path' WHERE placetype = '$I_Slide_2' ";
            $result = mysqli_query($con, $sql);

            echo '<script>alert("Image uploaded successfully!");window.location.href = "web_manager.php";</script>';
        }
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="web-container" method="POST" enctype="multipart/form-data">

        <input type="profile" class="active-id" name='I_Slide_3' value='I_Slide_3' readonly />
        <input type="file" id="image-input" name="image3">
        <img id="image-preview" src="<?php echo $I_Slide_3; ?>" class="image_slid" alt="Image Preview" value="<?php echo $image; ?>" readonly>
        <input type="submit" class="submit_buton" name="submit3" value="submit"><br><br><br><br><br><br><br><br>
    </form>
    <?php

    if (isset($_POST['submit3'])) {
        $I_Slide_3 = $_POST['I_Slide_3'];




        // Check if image is uploaded
        if (isset($_FILES['image3'])) {
            // Get image metadata
            $image = $_FILES['image3'];
            $imageName = $image['name'];
            $imageType = $image['type'];
            $imageSize = $image['size'];
            $imagePath = '../images/' . $imageName;
            $image_path = './images/' . $imageName;

            // Move uploaded image to local storage
            move_uploaded_file($image['tmp_name'], $imagePath);
             copy($imagePath , $image_path);

            // Insert image metadata into database
            $sql = "UPDATE `web_maneger_img` SET images = '$imagePath', admin_images = '$image_path' WHERE placetype = '$I_Slide_3' ";
            $result = mysqli_query($con, $sql);

            echo '<script>alert("Image uploaded successfully!");window.location.href = "web_manager.php";</script>';
        }
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="web-container" method="POST" enctype="multipart/form-data">

        <input type="profile" class="active-id" name='I_Slide_4' value='I_Slide_4' readonly />
        <input type="file" id="image-input" name="image4">
        <img id="image-preview" src="<?php echo $I_Slide_4; ?>" class="image_slid" alt="Image Preview" value="<?php echo $image; ?>" readonly>
        <input type="submit" class="submit_buton" name="submit4" value="submit"><br><br><br><br><br><br><br><br>
    </form>
    <?php

    if (isset($_POST['submit4'])) {
        $I_Slide_4 = $_POST['I_Slide_4'];




        // Check if image is uploaded
        if (isset($_FILES['image4'])) {
            // Get image metadata
            $image = $_FILES['image4'];
            $imageName = $image['name'];
            $imageType = $image['type'];
            $imageSize = $image['size'];
            $imagePath = '../images/' . $imageName;
            $image_path = './images/' . $imageName;

            // Move uploaded image to local storage
            move_uploaded_file($image['tmp_name'], $imagePath);
             copy($imagePath , $image_path);

            // Insert image metadata into database
            $sql = "UPDATE `web_maneger_img` SET images = '$imagePath', admin_images = '$image_path' WHERE placetype = '$I_Slide_4' ";
            $result = mysqli_query($con, $sql);

            echo '<script>alert("Image uploaded successfully!");window.location.href = "web_manager.php";</script>';
        }
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="web-container" method="POST" enctype="multipart/form-data">

        <input type="profile" class="active-id" name='I_Slide_5' value='I_Slide_5' readonly />
        <input type="file" id="image-input" name="image5">
        <img id="image-preview" src="<?php echo $I_Slide_5; ?>" class="image_slid" alt="Image Preview" value="<?php echo $image; ?>" readonly>
        <input type="submit" class="submit_buton" name="submit5" value="submit"><br><br><br><br><br><br><br><br>
    </form>
    <?php

    if (isset($_POST['submit5'])) {
        $I_Slide_5 = $_POST['I_Slide_5'];




        // Check if image is uploaded
        if (isset($_FILES['image5'])) {
            // Get image metadata
            $image = $_FILES['image5'];
            $imageName = $image['name'];
            $imageType = $image['type'];
            $imageSize = $image['size'];
            $imagePath = '../images/' . $imageName;
            $image_path = './images/' . $imageName;

            // Move uploaded image to local storage
            move_uploaded_file($image['tmp_name'], $imagePath);
             copy($imagePath , $image_path);

            // Insert image metadata into database
            $sql = "UPDATE `web_maneger_img` SET images = '$imagePath', admin_images = '$image_path' WHERE placetype = '$I_Slide_5' ";
            $result = mysqli_query($con, $sql);

            echo '<script>alert("Image uploaded successfully!");window.location.href = "web_manager.php";</script>';
        }
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="web-container" method="POST" enctype="multipart/form-data">

        <input type="profile" class="active-id" name='II_Slide_1' value='II_Slide_1' readonly />
        <input type="file" id="image-input" name="image6">
        <img id="image-preview" src="<?php echo $II_Slide_1; ?>" class="image_slid" alt="Image Preview" value="<?php echo $image; ?>" readonly>
        <input type="submit" class="submit_buton" name="submit6" value="submit"><br><br><br><br><br><br><br><br>
    </form>
    <?php

    if (isset($_POST['submit6'])) {
        $II_Slide_1 = $_POST['II_Slide_1'];




        // Check if image is uploaded
        if (isset($_FILES['image6'])) {
            // Get image metadata
            $image = $_FILES['image6'];
            $imageName = $image['name'];
            $imageType = $image['type'];
            $imageSize = $image['size'];
            $imagePath = '../images/' . $imageName;
            $image_path = './images/' . $imageName;

            // Move uploaded image to local storage
            move_uploaded_file($image['tmp_name'], $imagePath);
             copy($imagePath , $image_path);

            // Insert image metadata into database
            $sql = "UPDATE `web_maneger_img` SET images = '$imagePath', admin_images = '$image_path' WHERE placetype = '$II_Slide_1' ";
            $result = mysqli_query($con, $sql);

            echo '<script>alert("Image uploaded successfully!");window.location.href = "web_manager.php";</script>';
        }
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="web-container" method="POST" enctype="multipart/form-data">

        <input type="profile" class="active-id" name='II_Slide_2' value='II_Slide_2' readonly />
        <input type="file" id="image-input" name="image7">
        <img id="image-preview" src="<?php echo $II_Slide_2; ?>" class="image_slid" alt="Image Preview" value="<?php echo $image; ?>" readonly>
        <input type="submit" class="submit_buton" name="submit7" value="submit"><br><br><br><br><br><br><br><br>
    </form>
    <?php

    if (isset($_POST['submit7'])) {
        $II_Slide_2 = $_POST['II_Slide_2'];




        // Check if image is uploaded
        if (isset($_FILES['image7'])) {
            // Get image metadata
            $image = $_FILES['image7'];
            $imageName = $image['name'];
            $imageType = $image['type'];
            $imageSize = $image['size'];
            $imagePath = '../images/' . $imageName;
            $image_path = './images/' . $imageName;

            // Move uploaded image to local storage
            move_uploaded_file($image['tmp_name'], $imagePath);
             copy($imagePath , $image_path);

            // Insert image metadata into database
            $sql = "UPDATE `web_maneger_img` SET images = '$imagePath', admin_images = '$image_path' WHERE placetype = '$II_Slide_2' ";
            $result = mysqli_query($con, $sql);

            echo '<script>alert("Image uploaded successfully!");window.location.href = "web_manager.php";</script>';
        }
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="web-container" method="POST" enctype="multipart/form-data">

        <input type="profile" class="active-id" name='II_Slide_3' value='II_Slide_3' readonly />
        <input type="file" id="image-input" name="image8">
        <img id="image-preview" src="<?php echo $II_Slide_3; ?>" class="image_slid" alt="Image Preview" value="<?php echo $image; ?>" readonly>
        <input type="submit" class="submit_buton" name="submit8" value="submit"><br><br><br><br><br><br><br><br>
    </form>
    <?php

    if (isset($_POST['submit8'])) {
        $II_Slide_3 = $_POST['II_Slide_3'];




        // Check if image is uploaded
        if (isset($_FILES['image8'])) {
            // Get image metadata
            $image = $_FILES['image8'];
            $imageName = $image['name'];
            $imageType = $image['type'];
            $imageSize = $image['size'];
            $imagePath = '../images/' . $imageName;
            $image_path = './images/' . $imageName;

            // Move uploaded image to local storage
            move_uploaded_file($image['tmp_name'], $imagePath);
             copy($imagePath , $image_path);

            // Insert image metadata into database
            $sql = "UPDATE `web_maneger_img` SET images = '$imagePath', admin_images = '$image_path' WHERE placetype = '$II_Slide_3' ";
            $result = mysqli_query($con, $sql);

            echo '<script>alert("Image uploaded successfully!");window.location.href = "web_manager.php";</script>';
        }
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="web-container" method="POST" enctype="multipart/form-data">

        <input type="profile" class="active-id" name='II_Slide_4' value='II_Slide_4' readonly />
        <input type="file" id="image-input" name="image9">
        <img id="image-preview" src="<?php echo $II_Slide_4; ?>" class="image_slid" alt="Image Preview" value="<?php echo $image; ?>" readonly>
        <input type="submit" class="submit_buton" name="submit9" value="submit"><br><br><br><br><br><br><br><br>
    </form>
    <?php

    if (isset($_POST['submit9'])) {
        $II_Slide_4 = $_POST['II_Slide_4'];




        // Check if image is uploaded
        if (isset($_FILES['image9'])) {
            // Get image metadata
            $image = $_FILES['image9'];
            $imageName = $image['name'];
            $imageType = $image['type'];
            $imageSize = $image['size'];
            $imagePath = '../images/' . $imageName;
            $image_path = './images/' . $imageName;

            // Move uploaded image to local storage
            move_uploaded_file($image['tmp_name'], $imagePath);
             copy($imagePath , $image_path);

            // Insert image metadata into database
            $sql = "UPDATE `web_maneger_img` SET images = '$imagePath', admin_images = '$image_path' WHERE placetype = '$II_Slide_4' ";
            $result = mysqli_query($con, $sql);

            echo '<script>alert("Image uploaded successfully!");window.location.href = "web_manager.php";</script>';
        }
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="web-container" method="POST" enctype="multipart/form-data">

        <input type="profile" class="active-id" name='II_Slide_5' value='II_Slide_5' readonly />
        <input type="file" id="image-input" name="image10">
        <img id="image-preview" src="<?php echo $II_Slide_5; ?>" class="image_slid" alt="Image Preview" value="<?php echo $image; ?>" readonly>
        <input type="submit" class="submit_buton" name="submit10" value="submit"><br><br><br><br><br><br><br><br>
    </form>
    <?php

    if (isset($_POST['submit10'])) {
        $II_Slide_5 = $_POST['II_Slide_5'];




        // Check if image is uploaded
        if (isset($_FILES['image10'])) {
            // Get image metadata
            $image = $_FILES['image10'];
            $imageName = $image['name'];
            $imageType = $image['type'];
            $imageSize = $image['size'];
            $imagePath = '../images/' . $imageName;
            $image_path = './images/' . $imageName;

            // Move uploaded image to local storage
            move_uploaded_file($image['tmp_name'], $imagePath);
             copy($imagePath , $image_path);

            // Insert image metadata into database
            $sql = "UPDATE `web_maneger_img` SET images = '$imagePath', admin_images = '$image_path' WHERE placetype = '$II_Slide_5' ";
            $result = mysqli_query($con, $sql);

            echo '<script>alert("Image uploaded successfully!");window.location.href = "web_manager.php";</script>';
        }
    }
    ?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="web-container" method="POST" enctype="multipart/form-data">
<input type="profile" class="active-id" name='qr_code' value='qr_code' readonly />
<input type="file" id="image-input" name="image11">
<img id="image-preview" src="<?php echo $qr_code; ?>" class="image_slid" alt="Image Preview" value="<?php echo $image; ?>" readonly>
<input type="submit" class="submit_buton" name="submit11" value="submit"><br><br><br><br><br><br><br><br>
</form>
<?php

if (isset($_POST['submit11'])) {
$qr_code = $_POST['qr_code'];




// Check if image is uploaded
if (isset($_FILES['image11'])) {
    // Get image metadata
    $image = $_FILES['image11'];
    $imageName = $image['name'];
    $imageType = $image['type'];
    $imageSize = $image['size'];
    $imagePath = '../images/' . $imageName;
    $image_path = './images/' . $imageName;

    // Move uploaded image to local storage
    move_uploaded_file($image['tmp_name'], $imagePath);
     copy($imagePath , $image_path);

    // Insert image metadata into database
    $sql = "UPDATE `web_maneger_img` SET images = '$imagePath', admin_images = '$image_path' WHERE placetype = 'qr_code' ";
    $result = mysqli_query($con, $sql);

    echo '<script>alert("Image uploaded successfully!");window.location.href = "web_manager.php";</script>';
}
}
?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="web-container" method="POST" enctype="multipart/form-data">
    <textarea rows="5" cols="80" placeholder="<?php echo $move; ?>"  name="move_text" ></textarea>
        <input type="submit" class="submit_buton" name="submit11" value="submit"><br><br><br><br><br><br><br><br>
    </form>
<?php
    if (isset($_POST['submit11'])) {
        $move_text = $_POST['move_text'];

        $sql = "UPDATE `web_maneger_img` SET images = '$move_text' WHERE  placetype = 'move_text'";
            $result = mysqli_query($con, $sql);

            echo '<script>alert("Moving Para uploaded successfully!");window.location.href = "web_manager.php";</script>';


    }
?>
</section>
<script>
    // Get all input elements with the name starting with 'image'
    const imageInputs = document.querySelectorAll('input[name^="image"]');

    // Loop through each input element
    imageInputs.forEach((input) => {
        // Get the corresponding image preview element
        const imagePreview = input.nextElementSibling;

        // Add an event listener to the input element
        input.addEventListener('change', (e) => {
            const file = e.target.files[0];
            const reader = new FileReader();

            reader.onload = (event) => {
                imagePreview.src = event.target.result;
            };

            reader.readAsDataURL(file);
        });
    });
</script>