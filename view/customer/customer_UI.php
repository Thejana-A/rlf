<?php 

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

 ?>

<!DOCTYPE html>
<head>
    <link rel = "icon" href ="../Icon/logo.png"type = "image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="RLF_customer_css.css" />
    <title>RLF Apparel Factory</title>
</head>
<body>
    <header  class="header">
        <div id="header-top">
            <span id="logo">
               <center> <img src="../Icon/logo.png"></center>
            </span>
            <span id="centertitle">
                    <button>About Us</button>
                    <button>Contact Us</button>
                    <button>Help</button>
            </span>
            <span id ="button">
                <button id="logoutbutton" onclick="window.location.href='index.php';">
                    Logout
                </button>
            </span>
        </div>

        <div id="header-bottom">
            <button id="menubutton" onclick="openNav()">
                <img src="../Icon/menu.png">
            </button>
                <a href="#"><span id="username">Diani Dickovita &nbsp <img src="../Icon/user.png"/></span></a>
        </div>
    </header>
            <div>

                    <div id="mySidenav" class="sidenav">
                        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                        <a href="#">Customer</a>
                        <a href="customer_home.php" target="iframe_a">Home</a>
                        <a href="#">Notification</a>
                        <a href="view_all_quotation.php" target="iframe_a">View All Quotation</a>
                        <a href="view_all_order.html" target="iframe_a">View All Order</a>
                    </div>

                    <div id="main">
                        <iframe src="customer_home.php" name="iframe_a" class="iframe"></iframe>
                      </div>
            <div>

          <script>
          function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";

          }
          
          function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft= "0";
          }
          </script>



</body>
</html>

<?php 

}else{

     header("Location: customer_login.php");

     exit();

}

 ?>