<?php
include('./header.php');
include('../connect.php');


if (isset($_POST['submit'])) {
    $name = $_POST['floor_name'];
    $price =  $_POST['floor_price'];
    $bankfees  = $_POST['floor_bookingfees'];
    $total  = $_POST['floor_total'];
    $slp_count = $_POST['slp_count'];
    $slp_day_share = $_POST['slp_day_share'];
    $floor_vaility = $_POST['floor_vaility'];
    

   


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

    // if (isset($_FILES["image$i"])) {
    //     $image_name = $_FILES["image$i"]['name'];
    //     $image_type = $_FILES["image$i"]['type'];
    //     $image_size = $_FILES["image$i"]['size'];
    //     $image_tmp_name = $_FILES["image$i"]['tmp_name'];
    //     $imagepath = "../user_panel/images/$image_name";
    //     $image_path1 = "./images/$image_name";
    //     $image_path2 = "../images/$image_name";

    //     // Move uploaded image to local storage
    //     move_uploaded_file($image_tmp_name, $imagepath);
    //     copy($imagepath, $image_path1);
    //     copy($image_path1, $image_path2);
    // }

    $query = "INSERT INTO `floor_master`(`floor_id`, `floor_name`, `floor_price`, `floor_booking_fees`, `total`, `slp_count`, `slp_day_share`, `validity_days`) VALUES ('$user_id','$name','$price','$bankfees','$total','$slp_count','$slp_day_share','$floor_vaility')";
    $result = mysqli_query($con, $query);
    if ($result) {
        echo "<script>alert('Floor Added Successfully');</script>";
    }else{
        echo "<script>alert('Error Occured');</script>";
    }
}
?>
<style>
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

    .h1_line {
        text-align: center;
    }

    .image-preview {
        width: 250px;
        height: 250px;
        border: solid 2px white;
        border-radius: 0%;
    }
</style>
<section>
    <center>
        <div class="page-container">

            <div>
                <center>
                    <h1 class="prof_label h1_line">Floor Master</h1>
                </center>
            </div>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data"><br><br>

                <!-- <div class="check-details"><br>


                    <div class="image-preview">
                        <img id="image-preview" class="image-preview" src="" readonly>
                    </div><br>
                    <input type="file" id="image-input" class="prof_file" name="image" required><br>

                </div><br> -->
                <div class="check-details">
                    <label for="name" class="prof_label">Floor Name</label><BR>
                    <input type="text" class="prof_text" name="floor_name" placeholder="Enter Floor Name" required>
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Floor Price</label><BR>
                    <input type="text" class="prof_text" name="floor_price" placeholder="Enter Floor Price" required>
                </div>

                <div class="check-items">

                    <label for="name" class="prof_label">Floor Booking Fees</label><BR>
                    <input type="text" class="prof_text" name="floor_bookingfees" placeholder="Enter Floor Booking Fees" required>
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Floor Total</label><BR>
                    <input type="text" class="prof_text" name="floor_total" placeholder="Enter Floor Total" required>
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">SLP Count</label><BR>
                    <input type="text" class="prof_text" name="slp_count" placeholder="Enter SLP Count" required>
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">SLP Day Share</label><BR>
                    <input type="text" class="prof_text" name="slp_day_share" placeholder="Enter SLP Day Share" required>
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Floor Vaility</label><BR>
                    <input type="text" class="prof_text" name="floor_vaility" placeholder="Enter Floor Vaility" required>
                </div>
                <br><br>
                <div class="button-check-div">
                    <a href="./masters.php"><button type="button" class="button-check back">BACK</button></a>
                    <input type="submit" class=" button-check green" value="submit" name="submit">
                </div>

            </form><br><br><br><br><br><br>
        </div>
    </center>
</section>
<script>
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
</script>