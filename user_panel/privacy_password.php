<?php
include('./header.php')
?>
<style>
    .password-types{
        text-align: center;
    }
    .button-check{
    width: 30%;
    height: 30%;
    border: solid 2px lightseagreen;
    border-radius: 30px;
    color: white;
    background-color: transparent;
    margin-left: 30px;
}
.button-check:hover{
    width: 30%;
    height: 30%;
    border: solid 2px lightseagreen;
    border-radius: 30px;
    color: white;
    background-color: lightseagreen;
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
    <p class="prof_profh1">Change Password</p>
</div>
<center>

<div class="wall_btns">
    <input type="button" class="button_1" id="signInLink1" value="PROFILE PIN">
    <input type="button" class="button_2" id="signUpLink1" value="TRANSACTION PIN">
</div><br>
</center>
<center>
<div id="signInForm1" style="display: block;">
        <label class="prof_label">User ID</label><br>
        <input type="text" class="prof_text" readonly><br>
        <label class="prof_label">Old Profile Password</label><br>
        <input type="text" class="prof_text" placeholder="Enter Old Password"><br>
        <label class="prof_label">New Profile Passwor</label><br>
        <input type="text" class="prof_text" placeholder="Enter New Password"><br>
        <label class="prof_label">Confome Profile Passwor</label><br>
        <input type="text" class="prof_text" placeholder="Enter Confome Password"><br>
    </div>
</center>
<center>
<div id="signUpForm1" style="display: none;">
        <label class="prof_label">User ID</label><br>
        <input type="text" class="prof_text" readonly><br>
        <label class="prof_label">Old Transaction Password</label><br>
        <input type="text" class="prof_text" placeholder="Enter Old Password"><br>
        <label class="prof_label">New Transaction Passwor</label><br>
        <input type="text" class="prof_text" placeholder="Enter New Password"><br>
        <label class="prof_label">Confome Transaction Passwor</label><br>
        <input type="text" class="prof_text" placeholder="Enter Confome Password"><br>
    </div><br><br>

<div>
<div class="button-check-div">
                        <a href="./profile_pro.php"><button type="button" class="button-check">BACK</button></a>
                        <!-- Button trigger modal -->
                        <button type="button" class="button-check">
                            Update
                        </button>
        </div><br><br><br><br></center>
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
</script>