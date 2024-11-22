<?php
include('../connect.php');
include('./header.php');
?>

<style>
    .container {
        text-align: center;

        color: white;

    }


    .circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #333;
    }

    .circle1 {
        position: relative;
        right: -20px;
    }

    .circle2 {
        position: relative;
        right: 20px;
    }

    .top-user {
        margin-bottom: 20px;

    }

    .lines {
        display: flex;
        justify-content: center;


    }

    .lines1 {
        display: flex;
        justify-content: center;
        position: relative;
        left: 20px;

    }

    .lines2 {
        display: flex;
        justify-content: center;
        position: relative;
        left: -20px;
    }

    .line1 {
        width: 2px;
        height: 60px;
        background-color: #333;
        position: relative;
        top: -15px;
        margin: 0 20px;
        transform: rotate(40deg);
    }

    .line2 {
        width: 60px;
        height: 2px;
        background-color: #333;
        position: relative;
        top: 14px;
        right: -30px;
        margin: 0 20px;
        transform: rotate(50deg);
    }

    .line3 {
        width: 2px;
        height: 60px;
        background-color: #333;
        position: relative;
        top: -15px;
        left: 25px;
        margin: 0 20px;
        transform: rotate(40deg);
    }

    .line4 {
        width: 60px;
        height: 2px;
        background-color: #333;
        position: relative;
        top: 14px;
        right: 0px;
        margin: 0 20px;
        transform: rotate(50deg);
    }

    .users {
        display: flex;
        justify-content: center;
    }

    .user {
        margin: 0 20px;
        position: relative;
    }

    .sub-users {
        display: flex;
        justify-content: center;
        padding: px;
        position: relative;
        right: -8px;
    }

    .sub-users1 {
        display: flex;
        justify-content: center;
        padding: px;
        position: relative;
        right: 8px;
    }

    .sub-user {
        margin: 0 8px;
    }

    .subuser1 {
        margin: 0 30px 0 20px;
        position: relative;
        left: 5px;
    }

    table {
        border-collapse: collapse;
        width: 80%;
        border: 2px solid white;
        /* Set border color to white */
        align-items: center;
        margin: 10px 40px;
    }

    @media only screen and (min-width: 768px) {
        table {
            border-collapse: collapse;
            width: 80%;
            border: 2px solid white;
            /* Set border color to white */
            align-items: center;
            margin: 10px 130px;
        }

    }

    th,
    td {
        border: 1px solid white;
        /* Set border color to white for cells */
        padding: 8px;
        text-align: center;
        color: white;
        /* Optional: change text color to white for better visibility */
    }

    .floor_with {
        border: 2px solid white;
        width: 80%;
        text-align: center;
        display: flex;
        justify-content: space-around;
        padding: 15px 10px 1px 10px;
        color: white;
    }

    .user_names {
        font-size: small;
        position: relative;
        top: -20px;
    }
</style>
<section><BR>
    <CENTER>
        <h style="font-size: 30px; color: white">FLOOR - 1</h>
    </CENTER><BR>
    <div class="container">
        <div class="top-user">
            <img src="../images/user_image.png" alt="Top User" class="circle">
            <p>Top User</p>
            <p class="user_names">Name</p>
        </div>
        <div class="lines">
            <div class="line1"></div>
            <div class="line2"></div>
        </div>
        <div class="users">
            <div class="user">
                <div class="circle1">
                    <img src="../images/user_image.png" alt="User  1" class="circle">
                    <p>User 1</p>
                    <p class="user_names">Name</p>
                </div>
                <div class="lines1">
                    <div class="line3"></div>
                    <div class="line4"></div>
                </div>
                <div class="sub-users">
                    <div class="subuser1">
                        <img src="../images/user_image.png" alt="Sub User 1" class="circle">
                        <p>Sub User 1</p>
                        <p class="user_names">Name</p>
                    </div>
                    <div class="sub-user">
                        <img src="../images/user_image.png" alt="Sub User 2" class="circle">
                        <p>Sub User 2</p>
                        <p class="user_names">Name</p>
                    </div>
                </div>
            </div>
            <div class="user">
                <div class="circle2">
                    <img src="../images/user_image.png" alt="User  2" class="circle">
                    <p>User 2</p>
                    <p class="user_names">Name</p>
                </div>
                <div class="lines2">
                    <div class="line3"></div>
                    <div class="line4"></div>
                </div>
                <div class="sub-users1">
                    <div class="sub-user">
                        <img src="../images/user_image.png" alt="Sub User 3" class="circle">
                        <p>Sub User 3</p>
                        <p class="user_names">Name</p>
                    </div>
                    <div class="subuser1">
                        <img src="../images/user_image.png" alt="Sub User 4" class="circle">
                        <p>Sub User 4</p>
                        <p class="user_names">Name</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>

    <table>
        <tr>

            <th>SLP Mumbers</th>
            <th>SLP Income</th>
            <th>floor Mumbers</th>
            <th>floor Income</th>

        </tr>
        <tr>
            <td>50</td>
            <td>50</td>
            <td>50</td>
            <td>50</td>
        </tr>
    </table>


</section>

<section>
    <center>
        <div class="floor_with">
            <div>
                <p style="font-weight: bold;">floor Income</p>
            </div>
            <div>
                <p style="font-weight: bold;">1500 / 0</p>
            </div>
            <div>
                <input type="submit" class="fl_wt_btn" value="Withdrow">
            </div>
        </div>
    </center>
</section><BR><BR><BR><BR>