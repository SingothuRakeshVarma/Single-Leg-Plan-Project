<?php
include('./header.php');

?>

<style>
    .check-avatar {
        width: 300px;
        height: 300px;
    }
.amount{
    font-size: 10px;
    padding: 5px;
}
.money-btn{
    font-size: 10px;
    
}
.btn-outline-primary.money-btn {
  color: #20c997; /* this is the default primary color in Bootstrap */
  border-color: #20c997;
}

.btn-outline-primary.money-btn:hover {
  color: #fff;
  background-color: lightseagreen;
  border-color: lightseagreen;
}

.btn-check:checked + .btn-outline-primary.money-btn {
  color: #fff;
  background-color: lightseagreen;
  border-color: lightseagreen;
}
.button-check{
    width: 30%;
    height: 30%;
    border: solid 2px lightseagreen;
    border-radius: 30px;
    color: white;
    background-color: transparent;
    margin-left: 30px;
    margin-right: 20px;
}
.button-check:hover{
    width: 30%;
    height: 30%;
    border: solid 2px lightseagreen;
    border-radius: 30px;
    color: white;
    background-color: lightseagreen;
}
    @media only screen and (max-width: 768px) {
        .check-avatar {
            width: 280px;
            height: 280px;
        }

    }
</style>
<section>
    <center>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div>
                <center>
                    <h1 style="color: white;">Wallet Deposit</h1>
                </center>
            </div>
            <div class="page-container">


                <div class="avatar-img">
                    <img class="check-avatar" src="<?php echo $qr_code; ?>">
                </div>
                <div class="check-details">
                    <div class="check-items">
                        <label for="name" class="prof_label">USER ID</label><BR>
                        <input type="text" class="prof_text" name="user_id" value="" readonly>
                    </div>
                    <div class="check-items">
                        <label for="name" class="prof_label">USDT&nbsp;:</label><BR>
                        <input type="text" class="prof_text" id="amountInput" name="amount" placeholder="Enter USDT" readonly required>
                    </div><BR>
                    
                        <div class="btn-group amount" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                            <label class="btn btn-outline-primary money-btn bg-lightseagreen" onclick="setAmount('20USDT')" for="btnradio1">20USDT</label>

                            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                            <label class="btn btn-outline-primary money-btn bg-lightseagreen" onclick="setAmount('50USDT')" for="btnradio2">50USDT</label>

                            <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                            <label class="btn btn-outline-primary money-btn bg-lightseagreen" onclick="setAmount('100USDT')" for="btnradio3">100USDT</label>

                            <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
                            <label class="btn btn-outline-primary money-btn bg-lightseagreen" onclick="setAmount('250USDT')" for="btnradio4">250USDT</label>

                            <input type="radio" class="btn-check" name="btnradio" id="btnradio5" autocomplete="off">
                            <label class="btn btn-outline-primary money-btn bg-lightseagreen" onclick="setAmount('500USDT')" for="btnradio5">500USDT</label>
                        </div><br>
                        <div class="btn-group amount" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio6" autocomplete="off">
                            <label class="btn btn-outline-primary money-btn bg-lightseagreen" onclick="setAmount('1000USDT')" for="btnradio6">1000USDT</label>

                            <input type="radio" class="btn-check" name="btnradio" id="btnradio7" autocomplete="off">
                            <label class="btn btn-outline-primary money-btn bg-lightseagreen" onclick="setAmount('5000USDT')" for="btnradio7">5000USDT</label>

                            <input type="radio" class="btn-check" name="btnradio" id="btnradio8" autocomplete="off">
                            <label class="btn btn-outline-primary money-btn bg-lightseagreen" onclick="setAmount('10000USDT')" for="btnradio8">10000USDT</label>

                        </div>

                    <br><br>
                    <div class="check-items">
                        <label for="name" class="prof_label">Add Your Trust Wallet Addres</label><BR>
                        <input type="text" class="prof_text" name="trid" minlength="12" maxlength="12" placeholder="Enter Trust Wallet Addres" required>
                    </div> <br>
                    <div class="button-check-div">
                        <a href="./profile_pro.php"><button type="button" class="button-check">BACK</button></a>
                        <!-- Button trigger modal -->
                        <button type="button" class="button-check" data-bs-toggle="modal" name="deposit" data-bs-target="#exampleModal">
                            Prosses
                        </button>

                        <!-- Modal -->
                    </div><br><br><br><br>
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

                            <label for="name" class="prof_label">Transaction Pin</label><BR>
                            <input type="text" class="prof_text" name="tpassword" placeholder="Enter Transaction Pin">

                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-success" name="submit" value="submit">

                        </div>
                    </div>
                </div>
            </div><br><br><br>
    </center>
    </form>
</section>
<script>
    function setAmount(amount) {
        document.getElementById('amountInput').value = amount;
    }
</script>