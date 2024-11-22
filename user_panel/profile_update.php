<?php
include('./user_header.php');

$query = "SELECT * FROM users WHERE userid = '$user_id'";
    $result = mysqli_query($con, $query);
     $row = mysqli_fetch_assoc($result);
    
    $addres = $row["addres"];
    $district = $row["district"];
    $state = $row["state"];
    $pincode = $row["pincode"];
    

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tpassword = $_POST['tpassword'];
    $addres = $_POST['addres'];
    $district = $_POST['district'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $pincode = $_POST['pincode'];
    $user_id = $_POST['user_id'];

   
    // Verify Transaction Pin
    $query = "SELECT * FROM users WHERE tpassword = '$tpassword' AND userid = '$user_id'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        // Update data in database
        $query = "UPDATE users SET addres = '$addres', district = '$district', state = '$state', country = '$country', pincode = '$pincode' WHERE userid = '$user_id'";
        mysqli_query($con, $query);

        echo '<script>alert("Data updated and saved successfully!");window.location.href = "profile_update.php";</script>';
       



        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            // Get image metadata
            $image = $_FILES['image'];
            $imageName = $image['name'];
            $imageType = $image['type'];
            $imageSize = $image['size'];
            $imagePath = 'images/' . $imageName;

            // Move uploaded image to local storage
            move_uploaded_file($image['tmp_name'], $imagePath);

            // Insert image metadata into database
            $sql = "UPDATE `users` SET images = '$imagePath' WHERE userid = '$user_id' ";
            $result = mysqli_query($con, $sql);
            echo '<script>alert("Image uploaded successfully!");window.location.href = "profile_update.php";</script>';
        } else {
            echo '<script>alert("Please upload an image!");window.location.href = "profile_update.php";</script>';
        }
    } else {
        echo '<script>alert("Invalid Transaction Pin");window.location.href = "profile_update.php";</script>';
        
    }
}
?>

<style>
   
</style>

<section>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">

        <div class="page-container" style="width: 105vw;">


           <center> <div class="avatar-">


                <input type="file" id="image-input" name="image">
                <img id="image-preview" src="" alt="Image Preview" value="<?php echo $image; ?>" readonly>




            </div></center>
            <div class="check-details">
                <div class="check-items">
                    <h2 class="head-lines">User ID</h2>
                    <div>
                        <input type="text" class="txt-user-id" name="user_id" value="<?php echo $user_id; ?>" readonly>
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Profile Name</h2>
                    <div>
                        <input type="text" class="txt-user-id" value="<?php echo $user_name; ?>" readonly>
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Phone Number</h2>
                    <div>
                        <input type="text" class="txt-user-id" value="<?php echo $phonenumber; ?>" readonly>
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Reference</h2>
                    <div>
                        <input type="text" class="txt-user-id" value="<?php echo $referalname; ?>" readonly>
                    </div>
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Addres</label><BR>
                    <input type="text" class="txt-user-id" name="addres" placeholder="Enter Amount" value="<?php echo $addres; ?>">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">District</label><BR>
                    <input type="text" class="txt-user-id" name="district" placeholder="Enter District" value="<?php echo $district; ?>">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">State</label><BR>
                    <input type="text" class="txt-user-id" name="state" placeholder="Enter State" value="<?php echo $state; ?>">
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Nation</h2>

                  <select name="country" class="user-id">
                        
                        <option value="india">
                            India</option>
                        <option value="Australia">
                            Australia</option>
                        <option value="Canada">
                            Canada</option>
                        <option value="Malaysia">
                            Malaysia</option>
                        <option value="Nepal">
                            Nepal</option>
                        <option value="New Zealand">
                            New Zealand</option>

                    </select>

                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Pin Code</label><BR>
                    <input type="text" class="txt-user-id" name="pincode" maxlength="6" placeholder="Enter PinCode" value="<?php echo $pincode; ?>">
                </div>
                <div class="button-check-div">
                    <a href="./bi_people_fill.php"><button type="button" class="button-check red">BACK</button></a>
                    <button type="button" class=" button-check green" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Save
                    </button>
                </div><br><br><br><br>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Transaction Mathed</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <label for="name" class="active-id">Transaction Pin</label><BR>
                        <input type="text" class="txt-user-id" name="tpassword" placeholder="Enter Transaction Pin">

                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" name="submit" value="submit">


                    </div>
                </div>
            </div>
        </div><br><br><br>
    </form>
</section>
<script>
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');

    imageInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        const reader = new FileReader();

        reader.onload = (event) => {
            imagePreview.src = event.target.result;
        };

        reader.readAsDataURL(file);

        const formData = new FormData();
        formData.append('image', file);

        fetch('images.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then((data) => {
                console.log(data);
                // Store the image in local storage
                localStorage.setItem('image', data.image);
            })
            .catch((error) => {
                console.error(error);
            });
    });
</script>