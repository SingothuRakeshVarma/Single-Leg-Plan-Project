<?php
include('./header.php');
include('../connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM `slp_master` WHERE floor_name = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $floor_name= $row['floor_name'];
    $level_1 =  $row['add_mumbers'];
    $level_2 =  $row['mumber_share'];
    $level_3 =  $row['no_of_days'];
    $level_4 =  $row['total_income'];
   

}

if (isset($_POST['submit'])) {
    $name = $_POST['floor_name'];
    $level_1 =  $_POST['level_1'];
    $level_2 =  $_POST['level_2'];
    $level_3 =  $_POST['level_3'];
    $level_4 =  $_POST['level_4'];
   

    $query = "UPDATE `slp_master` SET `floor_name`='$name',`add_mumbers`='$level_1',`mumber_share`='$level_2',`no_of_days`='$level_3',`total_income`='$level_4' WHERE `floor_name`='$name'";
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
                        <h1 class="prof_label h1_line">SLP MASTER</h1>
                    </center>
                </div><br>
                <div>
                    <label for="name" class="prof_label">Floor Name</label><BR>
                </div>
                <div>
                    <?php
                    // Connect to the database
                    $con = mysqli_connect("localhost", "root", "", "success_slp");
                    // $con = mysqli_connect("localhost", "trcelioe_realvisinewebsite", "Realvisine", "trcelioe_user_data");

                    // Check connection
                    if (!$con) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    // Query to fetch data from the database
                    $sql = "SELECT floor_name FROM floor_master WHERE  floor_name !=''";

                    $result = mysqli_query($con, $sql);
                    ?>
                    <select class='prof_text options' name="floor_name">
                        <option class="options" value='<?php echo $row['floor_name']; ?>'><?php echo $row['floor_name']; ?></option>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            $product_name = $row['floor_name'];
                            echo "<option class='options' value='" . $product_name . "'>" . $product_name . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="check-items">

                    <label for="name" class="prof_label">ADD Membors</label><BR>
                    <input type="text" class="prof_text" name="level_1" value="<?php echo $level_1; ?>">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Member Share</label><BR>
                    <input type="text" class="prof_text" name="level_2" value="<?php echo $level_2; ?>">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">NO.OF Days</label><BR>
                    <input type="text" class="prof_text" name="level_3" value="<?php echo $level_3; ?>">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Total Income</label><BR>
                    <input type="text" class="prof_text" name="level_4" value="<?php echo $level_4; ?>">
                </div>
                

                <br>
                <div class="button-check-div">
                    <a href="./slp_master_table.php"><button type="button" class="button-check back">BACK</button></a>
                    <input type="submit" class=" button-check green" value="Update" name="submit">
                </div>
            </div>
        </center>
    </form><br><br><br><br><br><br>
</section>