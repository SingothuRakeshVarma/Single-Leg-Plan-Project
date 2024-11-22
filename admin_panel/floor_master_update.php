<?php
include('./header.php');
include('../connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM `floor_master` WHERE floor_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $id = $row['floor_id'];
    $name = $row['floor_name'];
    $price =  $row['floor_price'];
    $booking_fees  = $row['floor_booking_fees'];
    $total = $row['total'];
    $slp_count = $row['slp_count'];
    $slp_day_share = $row['slp_day_share'];
    $floor_vaility = $row['validity_days'];
    
}
if (isset($_POST['submit'])) {
    $floor_id = $_POST['floor_id'];
    $name = $_POST['floor_name'];
    $price = $_POST['floor_price'];
    $bookingfees = $_POST['floor_bookingfees'];
    $floor_total = $_POST['floor_total']; // This should hold the old image path
    $slp_count = $_POST['slp_count'];
    $slp_day_share = $_POST['slp_day_share'];
    $floor_vaility = $_POST['floor_vaility'];
    



    // Update the database
    $query = "UPDATE `floor_master` SET 
                `floor_name`='$name',
                `floor_price`='$price',
                `floor_booking_fees`='$bookingfees',
                `total`='$floor_total',
                `slp_count`='$slp_count',
                `slp_day_share`='$slp_day_share',
                `validity_days`='$floor_vaility' 
              WHERE `floor_id`='$floor_id'";

    $result = mysqli_query($con, $query);

    if ($result) {
        echo "Floor Master updated successfully.";
    } else {
        echo "Error updating Floor: " . mysqli_error($con);
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
                <!-- 
                <div class="check-details"><br>


                    <div class="image-preview">
                        <img id="image-preview" class="image-preview" src="<?php echo $package_image ?>" readonly>
                    </div><br>
                    <input type="file" id="image-input" class="prof_file" value="<?php echo $package_image ?>" name="image"><br>
                    <input type="hidden" class="prof_text" name="image_preview" value="<?php echo $package_image ?>">
                </div><br> -->
                <div class="check-details">
                    <label for="name" class="prof_label">Floor Name</label><BR>
                    <input type="text" class="prof_text" name="floor_name" value="<?php echo $name ?>" required>
                    <input type="hidden" class="prof_text" name="floor_id" value="<?php echo $id ?>">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Floor Price</label><BR>
                    <input type="text" class="prof_text" name="floor_price" value="<?php echo $price ?>" required>
                </div>

                <div class="check-items">

                    <label for="name" class="prof_label">Booking Fees</label><BR>
                    <input type="text" class="prof_text" name="floor_bookingfees" value="<?php echo $booking_fees ?>" required>
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Total</label><BR>
                    <input type="text" class="prof_text" name="floor_total" value="<?php echo $total ?>" required>
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">SLP Count</label><BR>
                    <input type="text" class="prof_text" name="slp_count" value="<?php echo $slp_count ?>" required>
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">SLP Day Share</label><BR>
                    <input type="text" class="prof_text" name="slp_day_share" value="<?php echo $slp_day_share ?>" required>
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Floor Vaility</label><BR>
                    <input type="text" class="prof_text" name="floor_vaility" value="<?php echo $floor_vaility ?>" required>
                </div>

                <br><br>
                <div class="button-check-div">
                    <a href="./Floor_master_table.php"><button type="button" class="button-check back">BACK</button></a>
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