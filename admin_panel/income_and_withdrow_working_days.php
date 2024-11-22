<section>



<?php 
    include ('header.php');
    include('../connect.php');
    ?>
    <section>
<div class="page-container">



    <div class="check-details">
        <center>
            <h1 style="font-size: 150%;">Income and Withdrow working Days</h1>
        </center>
        <div>
            <table class="Inn-Wit-Table" >
                <tr>
                    <th class="Inn-Wit-h">Working Days</th>
                    <th class="Inn-Wit-h">Add Income Days</th>
                    <th class="Inn-Wit-h">Add Withdrow Days</th>
                </tr>
                <tr>
                    <td class="Inn-Wit-h">Dailey</td>
                    <td class="Inn-Wit-h" align="center"><input type="checkbox"></td>
                    <td class="Inn-Wit-h" align="center"><input type="checkbox"></td>
                </tr>
                <tr>
                    <td class="Inn-Wit-h">Monday</td>
                    <td class="Inn-Wit-h" align="center"><input type="checkbox"></td>
                    <td class="Inn-Wit-h" align="center"><input type="checkbox"></td>
                </tr>
                <tr>
                    <td class="Inn-Wit-h">Tuesday</td>
                    <td class="Inn-Wit-h" align="center"><input type="checkbox"></td>
                    <td class="Inn-Wit-h" align="center"><input type="checkbox"></td>
                </tr>
                <tr>
                    <td class="Inn-Wit-h">Wednesday</td>
                    <td class="Inn-Wit-h" align="center"><input type="checkbox"></td>
                    <td class="Inn-Wit-h" align="center"><input type="checkbox"></td>
                </tr>
                <tr>
                    <td class="Inn-Wit-h">Thursday</td>
                    <td class="Inn-Wit-h" align="center"><input type="checkbox"></td>
                    <td class="Inn-Wit-h" align="center"><input type="checkbox"></td>
                </tr>
                <tr>
                    <td class="Inn-Wit-h">Friday</td>
                    <td class="Inn-Wit-h" align="center"><input type="checkbox"></td>
                    <td class="Inn-Wit-h" align="center"><input type="checkbox"></td>
                </tr>
                <tr>
                    <td class="Inn-Wit-h">Saturday</td>
                    <td class="Inn-Wit-h" align="center"><input type="checkbox"></td>
                    <td class="Inn-Wit-h" align="center"><input type="checkbox"></td>
                </tr>
                <tr>
                    <td class="Inn-Wit-h">Sunday</td>
                    <td class="Inn-Wit-h" align="center"><input type="checkbox"></td>
                    <td class="Inn-Wit-h" align="center"><input type="checkbox"></td>
                </tr>
            </table>
        </div>


        <div class="button-check-div">
            <a href="./managers.php"><button type="button" class="button-check red">BACK</button></a>
            <button type="button" class=" button-check green" style="position: relative; left: 3vw;" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                Save
            </button>
        </div><br><br><br><br>
</section>