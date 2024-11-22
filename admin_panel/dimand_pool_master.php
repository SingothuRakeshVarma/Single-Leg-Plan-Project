<?php
include('header.php');
include('../connect.php');

if(isset($_POST["submit"])){
    $level_1 = $_POST["level_1_no"];
    $level_1_no = $_POST["level_1_no_share"];
    $level_2_no = $_POST["level_2_no_share"];
    $level_3_no = $_POST["level_3_no_share"];
    $level_4_no = $_POST["level_4_no_share"];
    $level_5_no = $_POST["level_5_no_share"];

    $query = "UPDATE `dimend_pool_master` SET `level_1_mumbers`='$level_1',`level_1_mumbers_share`='$level_1_no',`level_2_mumbers_share`='$level_2_no',`level_3_mumbers_share`='$level_3_no',`level_4_mumbers_share`='$level_4_no',`level_5_mumbers_share`='$level_5_no' WHERE userid = 'admin'";
    $result = mysqli_query($con, $query);
    if($result){
        echo '<script>alert("Dimand pool data Updated Successfully");window.location.href = "dimand_pool_master.php";</script>';
        
        } else {
            echo '<script>alert("Error in updating Dimand pool data");window.location.href = "dimand_pool_master.php";</script>';
        }
    


}


?>
<style>
    .red{
        position: relative;
        left: 0.5vw;
    }
</style>
<section>


    <form class="page-container" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">


        <div class="check-details">
            <center>
                <h1 style="font-size: 150%;">Dimend Pool Master</h1>
            </center>



            <div class="check-items">
                <label for="name" class="active-id">Level-1 members</label><BR>
                <input type="text" class="txt-user-id" name="level_1_no" placeholder="Enter Level Value">
            </div>
            <div class="check-items">
                <label for="name" class="active-id">Level-1 Members Share</label><BR>
                <input type="text" class="txt-user-id" name="level_1_no_share" placeholder="Enter Add Value">
            </div>

            <div class="check-items">
                <label for="name" class="active-id">Level-2 members Share</label><BR>
                <input type="text" class="txt-user-id" name="level_2_no_share" placeholder="Enter Add Value">
            </div>

            <div class="check-items">
                <label for="name" class="active-id">Level-3 members Share</label><BR>
                <input type="text" class="txt-user-id" name="level_3_no_share" placeholder="Enter Add Value">
            </div>

            <div class="check-items">
                <label for="name" class="active-id">Level-4 members Share</label><BR>
                <input type="text" class="txt-user-id" name="level_4_no_share" placeholder="Enter Add Value">
            </div>

            <div class="check-items">
                <label for="name" class="active-id">Level-5 members Share</label><BR>
                <input type="text" class="txt-user-id" name="level_5_no_share" placeholder="Enter Add Value">
            </div>

            <div class="button-check-div">
                <a href="./masters.php"><button type="button" class="button-check red">BACK</button></a>
                <input type="submit" class="button-check green" name="submit" value="submit">
            </div><br><br><br><br><br><br>
        </div>
    </form>
</section>