<?php
include('./header.php');
include('../connect.php');

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$phone_number = $_SESSION['phone_number'];
$referral_id = $_SESSION['referalid'];
$referral_name = $_SESSION['referalname'];
$profile_image = $_SESSION['images'];

$query = "SELECT * FROM user_data WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$trust_wallet = $row['trust_id'];



if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];

    echo $user_id;

    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        // Get image metadata
        $image = $_FILES['image'];
        $imageName = $image['name'];
        $imageType = $image['type'];
        $imageSize = $image['size'];
        $imagePath = './images/' . $imageName;
        $imagePath1 = '../admin_panel/images/' . $imageName;

        // Move uploaded image to local storage
        move_uploaded_file($image['tmp_name'], $imagePath);
        move_uploaded_file($imagePath, $imagePath1);

        // Insert image metadata into database
        $sql = "UPDATE `user_data` SET images = '$imagePath' WHERE user_id = '$user_id' ";
        $result = mysqli_query($con, $sql);
        echo '<script>alert("Image uploaded successfully!");window.location.href = "profile.php";</script>';
        // echo "image uploaded successfully";
    } else {
        echo '<script>alert("Please upload an image!");window.location.href = "profile.php";</script>';
        // echo "Please upload an image";
    } 
}
?>
<style>
    .image-preview {
        width: 150px;
        height: 150px;
        border: solid 2px white;
        border-radius: 50%;
    }

    .button-check {
        width: 30%;
        height: 30%;
        border: solid 2px lightseagreen;
        border-radius: 30px;
        color: white;
        background-color: transparent;
        margin-left: 30px;
    }

    .button-check:hover {
        width: 30%;
        height: 30%;
        border: solid 2px lightseagreen;
        border-radius: 30px;
        color: white;
        background-color: lightseagreen;
    }
</style>
<section>
    <div class="prof_container">
        <form action="profile.php" method="post" enctype="multipart/form-data">
            <div>
                <p class="prof_profh1" style="color: black;">Profile Details</p>
            </div>
            <center>
                <div>
                    <div class="image-preview">
                        <img id="image-preview" class="image-preview" src="<?php echo $profile_image; ?>" alt="" >
                    </div><br>
                    <input type="file" id="image-input" class="prof_file" name="image" accept="image/*" onchange="previewImage(event)"><br>
                </div><br>
                <div>
                    <label class="prof_label">User  ID</label><br>
                    <input type="text" class="prof_text" name="user_id" value="<?php echo $user_id ?>" readonly><br>
                    <label class="prof_label">Profile Name</label><br>
                    <input type="text" class="prof_text" value="<?php echo $user_name ?>" readonly><br>
                    <label class="prof_label">Referral ID</label><br>
                    <input type="text" class="prof_text" value="<?php echo $referral_id ?>" readonly><br>
                    <label class="prof_label">Referral Name</label><br>
                    <input type="text" class="prof_text" value="<?php echo $referral_name ?>" readonly><br>
                   
                    <label class="prof_label">Trust Wallet Address</label><br>
                    <input type="text" class="prof_text" value="<?php echo $trust_wallet ?>" readonly><br>
                </div><br>
                <div class="button-check-div">
                    <a href="./profile_pro.php"><button type="button" class="button-check">BACK</button></a>
                    <input type="submit" class="button-check" name="submit" value="UPDATE">
                </div><br><br><br>
            </center>
        </form>
    </div><br><br><br>
</section>

<script>
    function previewImage(event) {
        const imagePreview = document.getElementById('image-preview');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = '';
            imagePreview.style.display = 'none';
        }
    }
</script>
<!-- <script>
    // Function to preview the image
    function previewImage(input) {
        // Check if files are selected
        if (input.files && input.files[0]) {
            var reader = new FileReader(); // Create a FileReader object

            // Set up the onload event to update the image source
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result; // Set the image source
            }

            // Read the selected file as a data URL
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Add an event listener to the file input
    document.getElementById('image-input').addEventListener('change', function() {
        previewImage(this); // Call the preview function
    });
</script> -->