<?php
include('./header.php')
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
    <form style="color: white;">


        <center>

            <div class="wall_btns">
                <input type="button" class="button_1" id="signInLink1" value="UPI">
                <input type="button" class="button_2" id="signUpLink1" value="Account Details">
            </div><br>
        </center>
        <div id="signInForm1" style="display: block;">
            <label class="prof_label">UPI ID</label><br>
            <input type="text" class="prof_text" placeholder="Enter UPI ID"><br><br>
            <label class="prof_label">UPI QR Code</label><br>
            <input type="file" id="image-input" class="prof_file" name="image"><br>
            <img id="image-preview" class="image-preview" src="" alt="Image Preview" value="" readonly>
        </div>
        <div id="signUpForm1" style="display: none;">
            <label class="prof_label">Account Holder Name</label><br>
            <input type="text" class="prof_text" placeholder="Enter Account Holder Name"><br>
            <label class="prof_label">Bank Name</label><br>
            <input type="text" class="prof_text" placeholder="Enter Bank Name"><br>
            <label class="prof_label">Account Number</label><br>
            <input type="text" class="prof_text" placeholder="Enter Account Number"><br>
            <label class="prof_label">IFSC Code</label><br>
            <input type="text" class="prof_text" placeholder="Enter IFSC Code"><br><br>
        </div><br>
        <div class="button-check-div">
            <a href="./profile_pro.php"><button type="button" class="button-check">BACK</button></a>
            <!-- Button trigger modal -->
            <button type="button" class="button-check" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Update
            </button>

            <!-- Modal -->
        </div><br><br><br>
    </form>
</center>
<script>
        const signInForm1 = document.getElementById('signInForm1');
    const signUpForm1 = document.getElementById('signUpForm1');
    const signUpLink1 = document.getElementById('signUpLink1');
    const signInLink1 = document.getElementById('signInLink1');

    signUpLink1.addEventListener('click', function(event) {
        event.preventDefault();
        signInForm1.style.display = 'none';
        signUpForm1.style.display = 'block';
        signInLink1.style.backgroundColor = 'transparent';
        signUpLink1.style.backgroundColor = 'darkcyan';
    });

    signInLink1.addEventListener('click', function(event) {
        event.preventDefault();
        signInForm1.style.display = 'block';
        signUpForm1.style.display = 'none';
        signUpLink1.style.backgroundColor = 'transparent';
        signInLink1.style.backgroundColor = 'darkcyan';
    });


    
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