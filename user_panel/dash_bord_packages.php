<?php
include('../connect.php');
include('./user_header.php');
?>
<style>
@media only screen and (max-width: 768px) {
 
    .card_container {
        width: 100%;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    .card_body{
        width: 35%;
       height: 64vw;
      border-radius: 13px;
        border: solid 1px greenyellow;
        padding: 15px;
        -webkit-box-shadow: 0px 0px 16px 0px rgba(0,0,0,0.75);
  -moz-box-shadow: 0px 0px 16px 0px rgba(0,0,0,0.75);
  box-shadow: 0px 0px 16px 0px rgba(0,0,0,0.75);
  margin: 2vw 0;
    }

 
    .card_data{
        font-size: 2vw;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-around;
        
    }
    
    .card_button{
        border: solid 1px green;
        border-radius: 12px;
        font-size: 2vw;
        width: 10vw;
        padding: 0.6vw 12vw ;
        color: white;
        text-decoration: none;
        background-color: greenyellow;
         position: relative;
        top: -6.5vw;
        left: -1.5vw;
    }
    

    .packages {
        width: 100vw;
        position: relative;
        top: 2vw;
    }
    .image_prod{
        width: 90px;
        height: 90px;
         position: relative;
        top: -2.5vw;
    }
    .h_name{
         font-size: 2.5vw;
    }
    .h_name1{
        font-size: 2vw;
    }
}
@media only screen and (min-width: 1025px) {
    .card_container {
        width: 100%;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    .card_body{
        width: 18%;
       height: 30.5vw;
      border-radius: 13px;
        border: solid 1px greenyellow;
        padding: 15px;
        -webkit-box-shadow: 0px 0px 16px 0px rgba(0,0,0,0.75);
  -moz-box-shadow: 0px 0px 16px 0px rgba(0,0,0,0.75);
  box-shadow: 0px 0px 16px 0px rgba(0,0,0,0.75);
  margin: 2vw 0;
    }

 
    .card_data{
        font-size: 1.3vw;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-around;
        
    }
    
    .card_button{
        border: solid 2px green;
        border-radius: 12px;
        font-size: 1.5vw;
        width: 5vw;
        padding: 0vw 6.3vw ;
        color: white;
        text-decoration: none;
        background-color: greenyellow;
         
    }
    

    .packages {
        width: 100vw;
        position: relative;
        top: 2vw;
    }
    .image_prod{
        width: 180px;
        height: 180px;
         position: relative;
        
        left: 2.4vw;
    }
    .h_name{
         font-size: 1.5vw;
    }
    .h_name1{
        font-size: 1vw;
    }
}
</style>
<section class="packages">
<h1 style="position: relative; left: 2vw;">Packages</h1>
    <div class="card_container">

        <?php
        $sql = "SELECT * FROM cartdata WHERE packageorproduct = 'Package'";
        $result = $con->query($sql);
        while ($row = $result->fetch_assoc()) { ?>
            <div class="card_body">


                <div>
                    <p class="h_name1">ID:<?php echo $row["productcode"]; ?></p>
                    <img class="image_prod" src="<?php echo $row["images"]; ?>" alt="" />
                </div>
                <center>
                    <h2 class="h_name"><?php echo $row["packagename"]; ?></h2>
                </center>
                <div class="card_data">
                    <div>

                        <span>Price</span></br>
                        <span>Cash Back</span></br>
                        <span>SPV</span></br>
                        <span>Pack Vailed</span></br>
                    </div>
                    <div>
                        <span>:</span></br>
                        <span>:</span></br>
                        <span>:</span></br>
                        <span>:</span></br>
                    </div>
                    <div>
                        <span><?php echo $row["dp"]; ?></span></br>
                        <span><?php echo $row["cashbackamount"]; ?></span></br>
                        <span><?php echo $row["spv"]; ?></span></br>
                        <span><?php echo $row["packagealgibulity"]; ?></span></br>
                    </div>
                </div></br>

                <div>
                   
                    <a href="product_viwe.php?product_code=<?php echo $row["productcode"]; ?> "  class ="card_button">View</a>
                        
                       
                   
                    
                </div>

            </div>
        <?php } ?>
    </div></br></br></br>
</section>
<script>
    // Get the button element
    const button = document.getElementById('product-button');

    // Add an event listener to the button
    button.addEventListener('click', () => {
        // Get the product ID from the button's data attribute
        const productId = button.getAttribute('data-product-id');

        // Create the URL for the hyperlink page
        const url = `https://example.com/product/${productId}`;

        // Redirect to the hyperlink page
        window.location.href = url;
    });
</script>