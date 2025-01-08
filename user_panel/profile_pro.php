<?php
include('./header.php')
?>
<style>
      .bi{
        font-size: 20px;
        color: lightseagreen;
        
    }
    .pro_container{
        width: 95%;
    }
    hr {
    border: none;
    height: 2px;
    width: 90%;
    background-color: white;
    margin: 10px 20px 10px 20px;

}
@media only screen and (min-width: 768px) {
    .pro_container{
        width: 98%;
    }

}
.pro_account_data {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    }
</style>
<section >
    
    <div class="pro_container">
    <h1 class="pro_acct">
         Account
    </h1>
        <div class="pro_account_data">
            <div>
            <i class="bi bi-person-bounding-box"></i><samp> Profile</samp>
            </div>
            <div>
           <a href="./profile.php"> <i class="bi bi-chevron-right"></i></a>
            </div>
        </div><hr>
        <div class="pro_account_data">
            <div>
            <i class="bi bi-bank"></i><samp> Account Details</samp>
            </div>
            <div>
            <a href="./account_details.php"><i class="bi bi-chevron-right"></i></a>
            </div>
        </div><hr>
        <div class="pro_account_data">
            <div >
            <i class="bi bi-diagram-2"></i><samp> My Referrals</samp>
            </div>
            <div>
            <a href="./my_referrals.php"><i class="bi bi-chevron-right"></i></a>
            </div>
        </div><hr>
        <div class="pro_account_data">
            <div>
            <i class="bi bi-house-lock"></i><samp> Security</samp>
            </div>
            <div>
            <a href="./privacy_password.php"><i class="bi bi-chevron-right"></i></a>
            </div>
        </div>
    </div><br>
    <div class="pro_container">
    <h1 class="pro_acct">
         Reports
    </h1>
    <div class="pro_account_data">
            <div>
            <i class="bi bi-arrow-bar-up"></i><samp> Withdrow</samp>
            </div>
            <div>
            <a href="./withdraw_report.php"><i class="bi bi-chevron-right"></i></a>
            </div>
        </div><hr>
        <div class="pro_account_data">
            <div>
            <i class="bi bi-arrow-bar-down"></i><samp> Deposit</samp>
            </div>
            <div>
            <a href="./deposit_report.php"><i class="bi bi-chevron-right"></i></a>
            </div>
        </div><hr>
        <div class="pro_account_data">
            <div >
            <i class="bi bi-bezier"></i><samp> Floor Report</samp>
            </div>
            <div>
            <a href="./floor_report.php"><i class="bi bi-chevron-right"></i></a>
            </div>
        </div>
    <hr>
    <div class="pro_account_data">
            <div >
            <i class="bi bi-bezier2"></i><samp> SLP Report</samp>
            </div>
            <div>
            <a href="./slp_report.php"><i class="bi bi-chevron-right"></i></a>
            </div>
        </div>
        </div>
    <div class="pro_container">
    <h1 class="pro_acct">
         Others
    </h1>
    <div class="pro_account_data">
            <div>
            <i class="bi bi-chevron-right"></i><samp> Contact Us</samp>
            </div>
            <div>
            <a href="#"><i class="bi bi-chevron-right"></i></a>
            </div>
        </div><hr>
        <!-- <div class="pro_account_data">
            <div>
            <i class="bi bi-chevron-right"></i><samp> Add Buyers</samp>
            </div>
            <div>
            <a href="#"><i class="bi bi-chevron-right"></i></a>
            </div>
        </div><hr> -->
        <div class="pro_account_data">
            <div >
            <i class="bi bi-chevron-right"></i><samp>Team Policy</samp>
            </div>
            <div>
            <a href="#"><i class="bi bi-chevron-right"></i></a>
            </div>
        </div>
    </div><br><br><br>
</section>
