<?php
include('./header.php');
include('../connect.php');

$user_id = $_SESSION['user_id'];

if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

$query = "SELECT * FROM user_data WHERE user_id = '$user_id' AND password = '$old_password'";
$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) > 0) {
    $qurey = "UPDATE user_data SET password = '$new_password' WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $qurey);
    if ($result) {
        echo '<script>alert("Password changed successfully!");window.location.href = "privacy_password.php";</script>';
    } else {
        echo '<script>alert("Failed to change password!");window.location.href = "privacy_password.php";</script>';
    }
    } else {
        echo '<script>alert("Old password is incorrect!");window.location.href = "privacy_password.php";</script>';
    }
}
if (isset($_POST['tsubmit'])) {
    $user_id = $_POST['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $query = "SELECT * FROM user_data WHERE user_id = '$user_id' AND tpassword = '$old_password'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
       

    $qurey = "UPDATE user_data SET tpassword = '$new_password' WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $qurey);
    if ($result) {
        echo '<script>alert("Password changed successfully!");window.location.href = "privacy_password.php";</script>';
    } else {
        echo '<script>alert("Failed to change password!");window.location.href = "privacy_password.php";</script>';
    }
    } else  {
        echo '<script>alert("Old password is incorrect!");window.location.href = "privacy_password.php";</script>';
    }
}
?>
<style>
    .password-types {
        text-align: center;
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

    input[type="password"] {
        text-align: center;
        color: greenyellow;
    }

    input[type="password"]:hover {
        text-align: center;
        color: lightseagreen;
    }

    /* .types-pas{
    position: relative;
    left: 40px;
   }
   .priv_name{
    padding: 0 40px;
   } */
</style>
<div style="color: white; background-color:black;">
    <div>
        <p class="prof_profh1" style="color: black;">Privacy Password</p>
    </div>
    <center>

        <div class="wall_btns">
            <input type="button" class="button_1" id="signInLink1" value="PROFILE PIN">
            <input type="button" class="button_2" id="signUpLink1" value="TRANSACTION PIN">
        </div><br>
    </center>
    <center>
        <div id="signInForm1" style="display: block;">
            <form action="privacy_password.php" method="post" enctype="multipart/form-data">
                <label class="prof_label">User ID</label><br>
                <input type="text" class="prof_text" name="user_id" value="<?php echo $user_id ?>" readonly><br>
                <label class="prof_label">Old Profile Password</label><br>
                <div class="password-container">
                    <input type="password" id="password" name="old_password" class="prof_text" placeholder="Enter Old Profile Password">
                    <i class="fas fa-eye-slash eye-icon" id="eye-icon" onclick="togglePassword('password', 'eye-icon')"></i>
                </div>
                <label class="prof_label">New Profile Passwor</label><br>
                <div class="password-container">
                    <input type="password" id="password1" name="new_password" class="prof_text" placeholder="Enter New Profile Password">
                    <i class="fas fa-eye-slash eye-icon" id="eye-icon1" onclick="togglePassword('password1', 'eye-icon1')"></i>
                </div>
                <label class="prof_label">Confome Profile Passwor</label><br>
                <div class="password-container">
                    <input type="password" id="password2" name="confirm_password" class="prof_text" placeholder="Enter Confirm Profile Password">
                    <i class="fas fa-eye-slash eye-icon" id="eye-icon2" onclick="togglePassword('password2', 'eye-icon2')"></i>
                </div>

                <br>
                <br>
                <a href="./profile_pro.php"><button type="button" class="button-check">BACK</button></a>
                <!-- Button trigger modal -->
                <input type="submit" class="button-check" name="submit" value="UPDATE">

            </form>
        </div>
    </center>
    <center>
        <div id="signUpForm1" style="display: none;">
            <form action="privacy_password.php" method="post" enctype="multipart/form-data">
                <label class="prof_label">User ID</label><br>
                <input type="text" class="prof_text" name="user_id" value="<?php echo $user_id ?>" readonly><br>
                <label class="prof_label">Old Transaction Password</label><br>

                <div class="password-container">
                    <input type="password" id="password3" name="old_password" class="prof_text" placeholder="Enter Old Transaction Password">
                    <i class="fas fa-eye-slash eye-icon" id="eye-icon3" onclick="togglePassword('password3', 'eye-icon3')"></i>
                </div>
                <label class="prof_label">New Transaction Passwor</label><br>
                <div class="password-container">
                    <input type="password" id="password4" name="new_password" class="prof_text" placeholder="Enter New Transaction Password">
                    <i class="fas fa-eye-slash eye-icon" id="eye-icon4" onclick="togglePassword('password4', 'eye-icon4')"></i>
                </div>
                <label class="prof_label">Confome Transaction Passwor</label><br>
                <div class="password-container">
                    <input type="password" id="password5" name="confirm_password" class="prof_text" placeholder="Enter Confirm Transaction Password">
                    <i class="fas fa-eye-slash eye-icon" id="eye-icon5" onclick="togglePassword('password5', 'eye-icon5')"></i>
                </div>
                <br><br>
                <!-- Button trigger modal -->
                <a href="./profile_pro.php"><button type="button" class="button-check">BACK</button></a>
                <!-- Button trigger modal -->
                <input type="submit" class="button-check" name="tsubmit" value="UPDATE">
            </form>
        </div>


    </center>
</div>
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
    const form = document.getElementById('register-form');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm-password');

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (password !== confirmPassword) {
            alert('Passwords do not match');
            return;
        }

        // If passwords match, submit the form
        form.requestSubmit();
    });

    function togglePassword(passwordId, eyeIconId) {
        var passwordInput = document.getElementById(passwordId);
        var eyeIcon = document.getElementById(eyeIconId);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        }
    }
</script>