<?php
include('./header.php')
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
            <p class="prof_profh1">Profile</p>
        </div>
        <center>
            <div>
                <div class="image-preview">
                    <img id="image-preview" class="image-preview" src="" readonly>
                </div><br>
                <input type="file" id="image-input" class="prof_file" name="image"><br>
            </div><br>
            <div>
                <label class="prof_label">User ID</label><br>
                <input type="text" class="prof_text" value="User ID" readonly><br>
                <label class="prof_label">Profile Name</label><br>
                <input type="text" class="prof_text" value="User Name" readonly><br>
                <label class="prof_label">Referral ID</label><br>
                <input type="text" class="prof_text" value="Referral ID" readonly><br>
                <label class="prof_label">Referral Name</label><br>
                <input type="text" class="prof_text" value="Referral Name" readonly><br>
                <label class="prof_label">Phone Number</label><br>
                <input type="text" class="prof_text" value="Phone Number" readonly><br>

            </div><br>
            <div class="button-check-div">
                <a href="./profile_pro.php"><button type="button" class="button-check">BACK</button></a>
                <!-- Button trigger modal -->
                <button type="button" class="button-check" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Update
                </button>

                <!-- Modal -->
            </div><br><br><br>
        </center>


    </div><br><br><br>
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