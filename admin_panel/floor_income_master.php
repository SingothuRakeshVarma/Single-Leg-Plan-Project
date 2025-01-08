<?php
include('./header.php');
include('../connect.php');

if (isset($_POST['submit'])) {
    $name = $_POST['floor_name'];
    $level_1 =  $_POST['level_1'];
    $level_2 =  $_POST['level_2'];
    $level_3 =  $_POST['total_flr_value'];
    $level_4 =  $_POST['drb'];
    $level_5 =  $_POST['total_flr_income'];

    $query = "INSERT INTO `floor_income_master`(`floor_name`, `level_1_income`, `level_2_income`, `total_floor_income`, `floor_value`, `drb`) VALUES ('$name','$level_1','$level_2','$level_5','$level_3','$level_4')";
    $result = mysqli_query($con, $query);
    if ($result) {
        echo "Data Inserted Successfully";
    } else {
        echo "Data Not Inserted";
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
                        <h1 class="prof_label h1_line">Level Income Master</h1>
                    </center>
                </div><br>
                <div>
                    <label for="name" class="prof_label">Package Name</label><BR>
                </div>
                <div>
                    <?php
                    // Connect to the database
                    // $con = mysqli_connect("localhost", "root", "", "success_slp");
                    $con = mysqli_connect("localhost", "trcelioe_success_slp", "success_slp", "trcelioe_success_slp");

                    // Check connection
                    if (!$con) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    // Query to fetch data from the database
                    $sql = "SELECT floor_name FROM floor_master WHERE  floor_name !=''";

                    $result = mysqli_query($con, $sql);
                    ?>
                    <select class='prof_text options' name="floor_name">
                        <option class="options" value=''>Select Package Name</option>
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
                    <input type="text" class="prof_text" name="level_1" placeholder="Enter Amount">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Level-2</label><BR>
                    <input type="text" class="prof_text" name="level_2" placeholder="Enter Amount">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Total Floor Value</label><BR>
                    <input type="text" class="prof_text" name="total_flr_value" placeholder="Enter Amount">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">DRB</label><BR>
                    <input type="text" class="prof_text" name="drb" placeholder="Enter Amount">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Total Floor Income</label><BR>
                    <input type="text" class="prof_text" name="total_flr_income" placeholder="Enter Amount">
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