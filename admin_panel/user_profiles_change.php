<?php
include('./header.php');
include('../connect.php');



if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];

    $query = "SELECT * FROM user_data WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);


        $user_names = $row['user_name'];
        $phone_numbers = $row['phone_number'];
        $referral_ids = $row['referalid'];
        $referral_names = $row['referalname'];
        $passwords = $row['password'];
        $tpasswords = $row['tpassword'];
        $user_ids = $row['user_id'];
    } else {
        echo "<script>alert('User ID not found!');window.location.href = 'user_profiles_change.php';</script>";
    }
    //     // Insert image metadata into database
    //     $sql = "UPDATE `user_data` SET images = '$imagePath' WHERE user_id = '$user_id' ";
    //     $result = mysqli_query($con, $sql);
    //     // echo '<script>alert("Image uploaded successfully!");window.location.href = "profile.php";</script>';
    //     echo "image uploaded successfully";
}

if (isset($_POST['update'])) {
    $user_name = $_POST['user_name'];
    $phone_number = $_POST['phone_number'];
    $referral_id = $_POST['referral_id'];
    $referral_name = $_POST['referral_name'];
    $password = $_POST['password'];
    $tpassword = $_POST['tpassword'];
    $user_id = $_POST['user_id'];

         $sql = "UPDATE `user_data` SET user_name = '$user_name', phone_number = '$phone_number', referalid = '$referral_id', referalname = '$referral_name', password = '$password', tpassword = '$tpassword' WHERE user_id = '$user_id' ";
        $result = mysqli_query($con, $sql);
        echo '<script>alert("Image uploaded successfully!");window.location.href = "user_profiles_change.php";</script>';

        $query = "UPDATE `user_wallet` SET user_name = '$user_name' WHERE user_id = '$user_id' ";
        $result = mysqli_query($con, $query);
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

        <div>
            <p class="prof_profh1" style="color: black;">Profile Details Change</p>
        </div>
        <center>
            <form action="user_profiles_change.php" method="post" enctype="multipart/form-data">
                <label class="prof_label">Enter Change User ID</label><br>
                <input type="text" class="prof_text" name="user_id" placeholder="Enter User ID"><br><br>
                <input type="submit" class="button-check" name="submit" value="Check">
            </form>
            <form action="user_profiles_change.php" method="post" enctype="multipart/form-data">
                <div><br><br>

                    <label class="prof_label">Profile Name</label><br>
                    <input type="hidden" class="prof_text" name="user_id" value="<?php echo $user_ids ?? '' ?>">
                    <input type="text" class="prof_text" name="user_name" value="<?php echo $user_names ?? '' ?>"><br>
                    <label class="prof_label">Referral ID</label><br>
                    <input type="text" class="prof_text" name="referral_id" value="<?php echo $referral_ids ?? '' ?>"><br>
                    <label class="prof_label">Referral Name</label><br>
                    <input type="text" class="prof_text" name="referral_name" value="<?php echo $referral_names ?? '' ?>"><br>
                    <label class="prof_label">Phone Number</label><br>
                    <input type="text" class="prof_text" name="phone_number" value="<?php echo $phone_numbers ?? '' ?>"><br>
                    <label class="prof_label">Password</label><br>
                    <input type="text" class="prof_text" name="password" value="<?php echo $passwords ?? '' ?>"><br>
                    <label class="prof_label">Transaction Password</label><br>
                    <input type="text" class="prof_text" name="tpassword" value="<?php echo $tpasswords ?? '' ?>"><br>

                </div><br>
                <div class="button-check-div">
                    <a href="./user_profiles.php"><button type="button" class="button-check">BACK</button></a>
                    <input type="submit" class="button-check" name="update" value="UPDATE">
                </div><br><br><br>

            </form>
        </center>
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