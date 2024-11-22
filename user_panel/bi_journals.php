<?php
include('user_header.php');

?>
<style>
    
    .dash-bord-details {

       
        height: 23vw;
        box-shadow: 5px 15px 35px 0 rgb(0, 0, 0.1);
        background: transparent;
        animation: color 12s ease-in-out infinite;
        border-radius: 10px;
       

    }




    
    .dash-bord-details{
         width: 85%;
         
    }

    .pink1 {
        background-image: url('https://c4.wallpaperflare.com/wallpaper/552/454/447/background-color-brightness-colors-wallpaper-preview.jpg');
        background-size: cover;
        /* cover the entire element */
        background-repeat: no-repeat;
        /* don't repeat the image */
        background-position: center;
        /* center the image horizontally and vertically */
    }

    .pink2 {
        background-image: url('https://c4.wallpaperflare.com/wallpaper/947/644/4/blue-background-color-wallpaper-preview.jpg');
        background-size: cover;
        /* cover the entire element */
        background-repeat: no-repeat;
        /* don't repeat the image */
        background-position: center;
        /* center the image horizontally and vertically */
    }

    .pink3 {
        background-image: url('https://e0.pxfuel.com/wallpapers/532/356/desktop-wallpaper-maroon-and-gold-burgundy-and-gold-thumbnail.jpg');
        background-size: cover;
        /* cover the entire element */
        background-repeat: no-repeat;
        /* don't repeat the image */
        background-position: center;
        /* center the image horizontally and vertically */
    }

    .pink4 {
        background-image: url('https://c4.wallpaperflare.com/wallpaper/834/812/932/circles-spirals-color-shade-wallpaper-preview.jpg');
        background-size: cover;
        /* cover the entire element */
        background-repeat: no-repeat;
        /* don't repeat the image */
        background-position: center;
        /* center the image horizontally and vertically */
    }



    .main_container {
        width: 95%;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-around;
        
        
    }
    .dash-bord-cuntinar{
        width: 40%;
        
        margin: 5% 3%;
    }
    .db-headline{
        position: relative;
         top: 45%;
         font-size: 3vw;
    }
    a {
      text-decoration: none;
    }
    .titel{
        font-size: 5vw;
    }
</style>



<section><center>
    <h class ="titel" >ALL REPORTS</h>
    <div class="main_container">
        <div class="dash-bord-cuntinar">


            
            <a href="./user_details_reports.php"><div class="dash-bord-details pink2">
                 <h2 class="db-headline">LEVEL REPORT</h2>
                
            </div></a>

            
        </div>
        <div class="dash-bord-cuntinar ">

            
            <a href="./repots_tran.php"><div class="dash-bord-details pink1">
                <h2 class="db-headline">PAYMENT SUMMARY</h2>
                
            </div></a>

            
            
        </div>
        <div class="dash-bord-cuntinar ">

            
            
             <a href="./pvs_report.php"><div class="dash-bord-details pink4">
                <h2 class="db-headline">PV SUMMARY</h2>
               
            </div></a>

            
        </div>
        <div class="dash-bord-cuntinar ">

            
             <a href="./auto_pool_income.php"><div class="dash-bord-details pink3">
                <h2 class="db-headline">AUTO POOL INCOME</h2>
                
            </div></a>

           
        </div>
        



    </div></br></br></br></br>

    </center>
</section>