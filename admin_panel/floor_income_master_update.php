<?php
include('./header.php');
include('../connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM `floor_income_master` WHERE floor_name = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $level_1 =  $row['level_1_income'];
    $level_2 =  $row['level_2_income'];
    $level_3 =  $row['floor_value'];
    $level_4 =  $row['drb'];
    $level_5 =  $row['total_floor_income'];

   

}

if (isset($_POST['submit'])) {
    $name = $_POST['floor_name'];
    $level_1 =  $_POST['level_1'];
    $level_2 =  $_POST['level_2'];
    $level_3 =  $_POST['total_flr_value'];
    $level_4 =  $_POST['drb'];
    $level_5 =  $_POST['total_flr_income'];

    $query = "UPDATE `floor_income_master` SET `floor_name`='$name',`level_1_income`='$level_1',`level_2_income`='$level_2',`total_floor_income`='$level_5',`floor_value`='$level_3',`drb`='$level_4' WHERE `floor_name`='$name'";
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
                        <h1 class="prof_label h1_line">Floor Income Master</h1>
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
                            $floor_name = $row['floor_name'];
                            echo "<option class='options' value='" . $floor_name . "'>" . $floor_name . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="check-items">

                    <label for="name" class="prof_label">Level-1</label><BR>
                    <input type="text" class="prof_text" name="level_1" value="<?php echo $level_1; ?>">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Level-2</label><BR>
                    <input type="text" class="prof_text" name="level_2" value="<?php echo $level_2; ?>">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Total Floor Value</label><BR>
                    <input type="text" class="prof_text" name="total_flr_value" value="<?php echo $level_3; ?>">">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">DRB</label><BR>
                    <input type="text" class="prof_text" name="drb" value="<?php echo $level_4; ?>">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Total Floor Income</label><BR>
                    <input type="text" class="prof_text" name="total_flr_income" value="<?php echo $level_5; ?>">>
                </div>
                <br>
                <div class="button-check-div">
                    <a href="./floor_income_master_table.php"><button type="button" class="button-check back">BACK</button></a>
                    <input type="submit" class=" button-check green" value="Update" name="submit">
                </div>
            </div>
        </center>
    </form><br><br><br><br><br><br>
</section>