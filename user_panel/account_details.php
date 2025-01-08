<?php
include('./header.php');
include('../connect.php');

$user_id = $_SESSION['user_id'];

if (isset($_POST['submit1'])) {
    $trust_id = $_POST['trust_id'];

    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        // Get image metadata
        $image = $_FILES['image'];
        $imageName = $image['name'];
        $imageType = $image['type'];
        $imageSize = $image['size'];
        $imagePath = './images/' . $imageName;
        $imagePath1 = '../admin_panel/images/' . $imageName;
        // Check if image is uploaded successfully
        move_uploaded_file($image['tmp_name'], $imagePath);
        copy($imagePath, $imagePath1);
    
        $query = "UPDATE `user_data` SET `trust_qr` = '$imagePath', trust_id = '$trust_id' WHERE `user_id` = '$user_id'";
        $result = mysqli_query($con, $query);
        if ($result) {
            echo '<script>alert("Image Updated Successfully");window.location.href = "account_details.php";</script>';
        }else{
            echo '<script>alert("Error Occured");window.location.href = "account_details.php";</script>';
        }
    }
}


if (isset($_POST['submit2'])) {
   $account_name = $_POST['accountname'];
   $bank_name = $_POST['bankname'];
   $account_number = $_POST['accountnumber'];
   $ifsccode = $_POST['ifsccode'];
   $transaction_pin = $_POST['tpassword'];

   $qurey = "SELECT * FROM user_data WHERE user_id = ? AND tpassword = ?";
   $stmt = $con->prepare($qurey);
   $stmt->bind_param('ss', $user_id, $transaction_pin);
   $stmt->execute();
   $result = $stmt->get_result();

   if ($result->num_rows > 0) {
    $sql = "UPDATE `user_data` SET holder_name = ?, bankname = ?, account_number = ?, ifsc_code = ? WHERE user_id = ?";                                                               
    $stmtUpdate = $con->prepare($sql);
    $stmtUpdate->bind_param('sssss', $account_name, $bank_name, $account_number, $ifsccode, $user_id);

    if ($stmtUpdate->execute()) {
        echo '<script>alert("Account Details Updated");window.location.href = "account_details.php";</script>';
    } else {
        echo "Error updating record: " . $stmtUpdate->error;
    }   
   } else {
    echo '<script>alert("Invalid Transaction Pin");window.location.href = "account_details.php";</script>';
   }

   $stmt->close();
   $stmtUpdate->close();
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
<div>
    <p class="prof_profh1">Account Details</p>
</div>
<center>
   


        <center>

            <div class="wall_btns">
                <input type="button" class="button_1" id="signInLink1" value="Trust Wallet">
                
            </div><br>
        </center>

        <form action="account_details.php" method="post" enctype="multipart/form-data">
            <div id="signInForm1" style="display: block;">
                <label class="prof_label">Trust Wallet ID</label><br>
                <input type="text" class="prof_text" name="trust_id" placeholder="Enter Trust Wallet ID"><br><br>
                <label class="prof_label">Trust Wallet QR Code</label><br>
                <input type="file" id="image-input" class="prof_file" name="image"><br><br>
                <img id="image-preview" class="image-preview" src="" alt="Image Preview" value="" readonly><br><br>

                <a href="./profile_pro.php"><button type="button" class="button-check">BACK</button></a>

                <button type="button" class="button-check" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Update
                </button>
            </div><br><br><br>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" style="color: black;" id="exampleModalLabel">Transaction Mathed</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>



                                    <div class="modal-body">
                                        <label for="name"  class="prof_label">Transaction Pin</label><BR>
                                        <input type="text" class="prof_text" name="tpassword" placeholder="Enter Transaction Pin">


                                    </div>
                                    <div class="modal-footer">

                                        <input type="submit" class="btn btn-success" name="submit1" value="submit">


                                    </div>

                                </div>
                            </div>

                        </div>
        </form>
        <!-- Modal -->



    
</center>
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