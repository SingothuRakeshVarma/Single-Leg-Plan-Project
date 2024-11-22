<?php
include('./header.php')
?>
<style>
    .h1_line{
        text-align: center;
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
</style>
<section>
 <center>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"><br><br>
        <div>
            <center>
                <h1 class="prof_label h1_line">Wallet To Wallet</h1>
            </center>
        </div><br><br>

        <div class="page-container">


            <!--<div class="avatar-img">-->
            <!--    <img class="check-avatar" src="<?php echo $image; ?>" style="align-items: center;">-->
            <!--</div>-->
            <div class="check-details">
                <div class="check-items">
                    <label for="name" class="prof_label">User ID</label><BR>
                    <input type="text" class="prof_text" name="user_id" value="User ID">
                
                </div>
                <div class="check-items">
                    
                    <label for="name" class="prof_label">Wallet Available USDT</label><BR>
                    <input type="text" class="prof_text" name="user_id" value="Wallet Available USDT">
                
                </div>

                <div class="check-items">
                    <label for="name" class="prof_label">To User ID</label><BR>
                    <input type="text" class="prof_text" name="to_user_id" placeholder="Enter To User ID" id="active_id" onblur="fetchActiveName(this.value)">
                </div>
                <div class="check-items">
                    <label for="name" class="prof_label">To User Name</label><BR>
                    <input type="text" name="active_id_name" id="active_id_name" class="prof_text" placeholder="Enter To User Name" readonly />
                </div>
                <div class="check-items">
                    <label for="name" class="prof_label">Amount</label><BR>
                    <input type="text" class="prof_text" name="amount" placeholder="Enter Amount">
                </div><br><br>
                <div class="button-check-div">
                    <a href="./profile_pro.php"><button type="button" class="button-check red">BACK</button></a>
                    <button type="button" class=" button-check green" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Pay Now
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

                        <label for="name" class="prof_label">Transaction Pin</label><BR>
                        <input type="text" class="prof_text" name="tpassword" placeholder="Enter Transaction Pin">

                    </div>
                    <div class="modal-footer">

                        <input type="submit" class="btn btn-success" name="submit" value="submit">


                    </div>
                </div>
            </div>

        </div>
    </form>
</center>
</section>
<script>
    function fetchActiveName(active_id) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_referral_name.php?id=' + active_id, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('active_id_name').value = xhr.responseText;
                }
            };
            xhr.send();
        }
</script>