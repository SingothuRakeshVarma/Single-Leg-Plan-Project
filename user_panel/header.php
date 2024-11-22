<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>header</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="./styles.css">
    <script src="./java.js"></script>
<style>
    .bicnt {
    border-radius: 50%;
    background-image: url(../images/purple-color-burst-hd-wallpaper-wallpaper-preview.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    padding: 20px 25px;
    font-size: 30px;
}
</style>
</head>

<body>
    <section>
            <div  class="container_head">
                <div>

                    <p class="username"><img src="../images/LOGO 1.png" class="logo_img"><samp class="hi">HI,</samp><br>Singthu Rakesh Varma</p>
                </div>
                <div>
                    <img class="profile_imag " src="../images/360_F_571067620_JS5T5TkDtu3gf8Wqm78KoJRF1vobPvo6.jpg"
                        alt="profil_img">
                </div>
            </div>
        
    </section>
    <section>
        <div class="bot_nav fixed-bottom">
            <div>
                <a href="./home_page.php" onclick="changeIconAndNameColor(event)">
                    <i class="bi bi-house bis" style="color: white;"></i>
                    <div class="icone_name">Home</div>
                </a>
            </div>
            <div>
                <a href="./pramotion.php" onclick="changeIconAndNameColor(event)">
                    <i class="bi bi-person-fill-up bis" style="color: white;"></i>
                    <div class="icone_name">Promotion</div>
                </a>
            </div>
            <div>
                <a href="./packages.php" onclick="changeIconAndNameColor(event)">
                    <i class="bi bi-airplane bis bicnt" style="color: white;"></i>
                    <div class="icone_name" style="position: relative; left:28px;">Traed</div>
                </a>
            </div>
            <div>
                <a href="./wallet.php" onclick="changeIconAndNameColor(event)">
                    <i class="bi bi-wallet2 bis" style="color: white;"></i>
                    <div class="icone_name">Wallet</div>
                </a>
            </div>
            <div>
                <a href="./profile_pro.php" onclick="changeIconAndNameColor(event)">
                    <i class="bi bi-person bis" style="color: white;"></i>
                    <div class="icone_name">Profile</div>
                </a>
            </div>
        </div>
    </section>
    <script>
        // Function to change the color of the icon and icon name
        function changeIconAndNameColor(event) {
            // Reset color of all icons and icon names to white
            document.querySelectorAll('.bis').forEach(icon => {
                icon.style.color = "white";
            });
            document.querySelectorAll('.icone_name').forEach(div => {
                div.style.color = "white";
            });

            // Get the parent element of the clicked element (the hyperlink)
            var parent = event.target.parentNode;

            // Get the icon and icon name elements within the parent
            var icon = parent.querySelector('.bi');
            var iconName = parent.querySelector('.icone_name');

            // Toggle color of the icon and icon name
            icon.style.color = icon.style.color === "greenyellow" ? "white" : "greenyellow";
            iconName.style.color = iconName.style.color === "greenyellow" ? "white" : "greenyellow";

        }

        // const header = window.location.pathname;
        // const navLinks = document.querySelectorAll('nav a').forEach(link => {
        //     if (link.href.includes(`${header}`)) {
        //         link.classList.add('active');
        //         console.log(link);
        //     }
        // })
    </script>
</body>

</html>