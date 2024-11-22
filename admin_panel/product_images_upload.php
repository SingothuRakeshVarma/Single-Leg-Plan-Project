<?php
include('header.php');
include('../connect.php');

if (isset($_POST["submit"])) {
    $product_code = $_POST["product_code"];
    $images = array();

    // Check if product code already exists in the database
    $query = "SELECT * FROM `product_images` WHERE `product_code`= '$product_code'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // Product code exists, update images
        $existing_images = mysqli_fetch_assoc($result);
        $query = "UPDATE `product_images` SET ";
        for ($i = 1; $i <= 5; $i++) {
            if (isset($_FILES["image$i"])) {
                $image_name = $_FILES["image$i"]['name'];
                $image_type = $_FILES["image$i"]['type'];
                $image_size = $_FILES["image$i"]['size'];
                $image_tmp_name = $_FILES["image$i"]['tmp_name'];
                $imagepath = "../user_panel/images/$image_name";
                $image_path1 = "./images/$image_name";
                $image_path2 = "../images/$image_name";

                // Move uploaded image to local storage
                move_uploaded_file($image_tmp_name, $imagepath);
                copy($imagepath, $image_path1);
                copy($image_path1, $image_path2);

                // Update image paths in the database
                $query .= "`image_$i`='$image_path1', ";
            } else {
                // If no new image is uploaded, keep the existing image path
                $query .= "`image_$i`='" . $existing_images["image_$i"] . "', ";
            }
        }
        $query = rtrim($query, ', '); // remove trailing comma and space
        $query .= " WHERE `product_code`= '$product_code'";
        $result = mysqli_query($con, $query);
    } else {
        // Product code doesn't exist, insert new images
        $image_paths = array();
        for ($i = 1; $i <= 5; $i++) {
            if (isset($_FILES["image$i"])) {
                $image_name = $_FILES["image$i"]['name'];
                $image_type = $_FILES["image$i"]['type'];
                $image_size = $_FILES["image$i"]['size'];
                $image_tmp_name = $_FILES["image$i"]['tmp_name'];
                $imagepath = "../user_panel/images/$image_name";
                $image_path1 = "./images/$image_name";
                $image_path2 = "../images/$image_name";

                // Move uploaded image to local storage
                move_uploaded_file($image_tmp_name, $imagepath);
                copy($imagepath, $image_path1);
                copy($image_path1, $image_path2);

                // Store image paths in an array
                $image_paths[] = $image_path1;
            } else {
                $image_paths[] = ''; // add empty string if no image is uploaded
            }
        }

        $query = "INSERT INTO `product_images`(`product_code`";
        for ($i = 1; $i <= 5; $i++) {
            $query .= ", `image_$i`";
        }
        $query .= ") VALUES ('$product_code'";
        foreach ($image_paths as $image_path) {
            $query .= ", '$image_path'";
        }
        $query .= ")";
        $result = mysqli_query($con, $query);
    }
}
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
        position: relative;
        right: 15vw;
    }

    .txt-user-id {
        position: relative;
        right: 15vw;
    }

    .image_slid {
        width: 400px;
        height: 100px;
    }

    .img_file {
        position: relative;
        right: 30vw;
    }

    .pro_image {
        position: relative;
        right: 10vw;
    }

    .submit_buton {
        width: 100%;
        position: relative;
        right: 20vw;
        background-color: midnightblue;
        color: white;
        border-color: transparent;

    }

    .submit_buton:hover {
        width: 100%;
        position: relative;
        right: 20vw;
        background-color: green;
        color: white;
        border-color: transparent;
        transition: background-color 0.8s ease;
    }
</style>
<section>
    <center>
        <h style="font-size: 3vw;">Product Images uploaded Page</h>
    </center>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="web-container" method="POST" enctype="multipart/form-data">
        <div class="check-items">
            <label for="name" class="active-id">Product Code</label><BR>
            <input type="text" class="txt-user-id" placeholder="Enter Product Code" name="product_code" require><br><br><br><br>

            <input type="file" id="image-input" name="image1" class="img_file">
            <img id="image-preview" src="<?php echo $image_1; ?>" class="pro_image" alt="Image Preview" value="<?php echo $image; ?>" readonly><br><br><br><br><br>


            <input type="file" id="image-input" name="image2" class="img_file">
            <img id="image-preview" src="<?php echo $image_2; ?>" class="pro_image" alt="Image Preview" value="<?php echo $image; ?>" readonly><br><br><br><br><br>


            <input type="file" id="image-input" name="image3" class="img_file">
            <img id="image-preview" src="<?php echo $image_3; ?>" class="pro_image" alt="Image Preview" value="<?php echo $image; ?>" readonly><br><br><br><br><br>


            <input type="file" id="image-input" name="image4" class="img_file">
            <img id="image-preview" src="<?php echo $image_4; ?>" class="pro_image" alt="Image Preview" value="<?php echo $image; ?>" readonly><br><br><br><br><br>


            <input type="file" id="image-input" name="image5" class="img_file">
            <img id="image-preview" src="<?php echo $image_5; ?>" class="pro_image" alt="Image Preview" value="<?php echo $image; ?>" readonly><br><br><br><br>

            <input type="submit" class="submit_buton" name="submit" value="submit"><br><br><br><br><br><br><br><br>
        </div>
    </form>
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