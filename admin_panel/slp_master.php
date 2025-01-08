<?php
include('./header.php');
include('../connect.php');


if (isset($_POST['submit'])) {
    $name = $_POST['floor_name'];
    $level_1 =  $_POST['level_1'];
    $level_2 =  $_POST['level_2'];
    $level_3 =  $_POST['level_3'];
    $level_4 =  $_POST['level_4'];
   

    $query = "INSERT INTO `slp_master`(`floor_name`, `add_mumbers`, `mumber_share`, `no_of_days`, `total_income`) VALUES ('$name','$level_1','$level_2','$level_3','$level_4')";
    $result = mysqli_query($con, $query);
    if ($result) {
         echo "<script>alert('Data Inserted Successfully')</script>";
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
                        <h1 class="prof_label h1_line">Slp Masterr</h1>
                    </center>
                </div><br>
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
                    $sql = "SELECT floor_name FROM floor_master WHERE  floor_name !='' ORDER BY floor_name";

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

                    <label for="name" class="prof_label">ADD Members</label><BR>
                    <input type="text" class="prof_text" name="level_1" placeholder="Enter Mumbers">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Member Share</label><BR>
                    <input type="text" class="prof_text" name="level_2" placeholder="Enter Share">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">NO.OF Days</label><BR>
                    <input type="text" class="prof_text" name="level_3" placeholder="Enter Days">
                </div>
                <div class="check-items">

                    <label for="name" class="prof_label">Total Income</label><BR>
                    <input type="text" class="prof_text" name="level_4" placeholder="Enter Income">
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