<?php
include('user_header.php');


?>
<section>

    <div>
        <center>
            <h1 class="w-recharge-h1">Coin Conversion</h1>
        </center>
    </div>
    <div class="page-container">


        <div class="check-details">
            <div class="check-items">
                <h2 class="head-lines">User ID</h2>
                <div>
                    <input type="text" class="txt-user-id" name="user_id" placeholder="Enter User ID">
                </div>
            </div>
            <div class="check-items">
                <h2 class="head-lines">Coins Balence</h2>
                <div>
                    <input type="text" class="txt-user-id" name="user_id" placeholder="coins" readonly>
                </div>

            </div>


            <div class="check-items">
                <label for="name" class="active-id" style="font-size: 1.2vw;">No. of Conversion Coins</label><BR>
                <input type="text" class="txt-user-id" placeholder="Enter Coins">
            </div>
            <div class="check-items">
                <h2 class="head-lines">Coin Conversion Amount</h2>
                <div>
                    <input type="text" class="txt-user-id" name="user_id" placeholder="coins" readonly>
                </div>
            </div>
            <div class="button-check-div">
                <a href="./graph_up_arrow.php"><button type="button" class="button-check red">BACK</button></a>
                <button type="button" class=" button-check green" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add Wallet
                </button>

                <!-- Modal -->
            </div><br><br><br><br><br>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Transaction Mathed</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <label for="name" class="active-id">Transaction Pin</label><BR>
                    <input type="text" class="txt-user-id" name="tpassword" placeholder="Enter Transaction Pin">

                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" name="submit" value="submit">

                </div>
            </div>
        </div>
    </div>
</section>