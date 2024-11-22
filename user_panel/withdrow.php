<?php 
include('./header.php')
?>
<style>
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
.h1_line{
        text-align: center;
    }
  
</style>
<section>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"><BR><br>
        <center><div class="page-container">

        <div>
            <center>
                <h1 class="prof_label h1_line">Withdrows</h1>
            </center>
        </div><br>
            <div class="check-details"><br><br>
            <label for="name" class="prof_label">USER ID</label><BR>
            <input type="text" class="prof_text" name="user_id" value="" readonly>
                </div>
                <div class="check-items">
                   
                    <label for="name" class="prof_label">Wallet Total USDT</label><BR>
                        <input type="text" class="prof_text" name="user_id" value="Wallet Total USDT" readonly>
                </div>
                
                <div class="check-items">
                    <label for="name" class="prof_label">USDT</label><BR>
                    <input type="text" class="prof_text" name="amount" id="amount" onblur="fetchNetAmount(this.value)" placeholder="Enter USDT">
                </div>
                <div class="check-items">
                    <label for="name" class="prof_label">Net USDT</label><BR>
                    <input type="text" class="prof_text" name="net_amount" id="net_amount" value="USDT" readonly>
                </div><br>
                <div class="button-check-div">
                    <a href="./profile_pro.php"><button type="button" class="button-check back">BACK</button></a>
                    <button type="button" class=" button-check green" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Withdrow
                    </button>

                    <!-- Modal -->
                </div><br><br><br><br><br>
            </div>
        </div></center>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Transaction Mathed</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <label for="name" class="active-id">Transaction Pin</label><BR>
                        <input type="text" class="prof_text" name="tpassword" placeholder="Enter Transaction Pin">

                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" name="submit" value="submit">

                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
<script>
    function fetchNetAmount(amount) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetch_net_amount.php?id=' + amount, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('net_amount').value = xhr.responseText;
            }
        };
        xhr.send();
    }
</script>