<?php
include('./header.php');
include('../connect.php');

    $id = "admin";

    $query = "SELECT * FROM `admin_charges` WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $level_0 =  $row['Min_withdrows'];
    $level_1 =  $row['max_withdrows'];
    $level_2 =  $row['max_referrals'];
    $level_3 =  $row['spv'];
    $level_4 =  $row['tds'];
    $level_5 =  $row['admin_charges'];
    $level_6 =  $row['ft_charges'];
    $level_7 =  $row['others'];
    



if (isset($_POST['submit'])) {
    $level_0 =  $_POST['level_0'];
    $level_1 =  $_POST['level_1'];
    $level_2 =  $_POST['level_2'];
    $level_3 =  $_POST['level_3'];
    $level_4 =  $_POST['level_4'];
    $level_5 =  $_POST['level_5'];
    $level_6 =  $_POST['level_6'];
    $level_7 =  $_POST['level_7'];

    $query = "UPDATE `admin_charges` SET `Min_withdrows`='$level_0',`max_withdrows`='$level_1',`max_referrals`='$level_2',`spv`='$level_3',`tds`='$level_4',`admin_charges`='$level_5',`ft_charges`='$level_6',`others`='$level_7' WHERE `id`='admin'";
    $result = mysqli_query($con, $query);
    if ($result) {
        echo "Data Updated Successfully";
    } else {
        echo "Data Not Updated";
    }
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
        margin-right: 20px;

    }

    .button-check:hover {
        width: 30%;
        height: 30%;
        border: solid 2px lightseagreen;
        border-radius: 30px;
        color: white;
        background-color: lightseagreen;
    }

    .h1_line {
        text-align: center;
    }
    .options{
    text-align: center;
    color: darkcyan;
}
</style>
<section>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"><BR><br>
        <center>
            <div class="page-container">

                <div>
                    <center>
                        <h1 class="prof_label h1_line">Admin Charges Master</h1>
                    </center>
                </div><br>
                <div class="check-items">

                    <label for="name" class="prof_label">Minimum Withdrawals</label><BR>
                    <input type="text" class="prof_text" name="level_0" value="<?php echo $level_0 ?>">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Maximum Withdrawals</label><BR>
                    <input type="text" class="prof_text" name="level_1" value="<?php echo $level_1 ?>">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Maximum Referrals</label><BR>
                    <input type="text" class="prof_text" name="level_2" value="<?php echo $level_2 ?>">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">SPV %</label><BR>
                    <input type="text" class="prof_text" name="level_3" value="<?php echo $level_2 ?>">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">TDS %</label><BR>
                    <input type="text" class="prof_text" name="level_4" value="<?php echo $level_4 ?>">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Admin Charge %</label><BR>
                    <input type="text" class="prof_text" name="level_5" value="<?php echo $level_5 ?>">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Fund Transfer charge %</label><BR>
                    <input type="text" class="prof_text" name="level_6" value="<?php echo $level_6 ?>">
                </div>
                
                <div class="check-items">

                    <label for="name" class="prof_label">Others %</label><BR>
                    <input type="text" class="prof_text" name="level_7" value="<?php echo $level_7 ?>">
                </div>

                <br>
                <div class="button-check-div">
                    <a href="./masters.php"><button type="button" class="button-check back">BACK</button></a>
                    <input type="submit" class=" button-check green" value="Save" name="submit">
                </div>
            </div>
        </center>
    </form><br><br><br><br><br><br>
</section>