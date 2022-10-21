
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome</title>
        <link rel="stylesheet" type="text/css" href="./view/css/merchandiser/header_style.css" />
        <link rel="stylesheet" type="text/css" href="./view/css/merchandiser/footer_style.css" />
        <link rel="stylesheet" type="text/css" href="./view/css/index_page.css" />
    </head>

    <body>
        <div id="top-header">
            <span id="rlf-logo-span">
                <center><a href="#"><img src="./view/icons/rlf_logo.png" /></a></center>
            </span> 
            <span id="rlf-header-link-span">
                <center>
                  <a href="#">About us</a>
                  <a href="#">Contact us</a>
                  <a href="#">Help</a>
                </center>
            </span>
            <span id="header-button-span">
                <a href="./signup.php" id="signup-button">Signup</a>
                <a href="./login.php" id="login-button">Login</a>
            </span>  
        </div>

        <div style="height:1px;background-color:#aaaaaa;"></div>
  
        <div id="top-nav">
        </div>

        <div class="group-image" style="display:block;position:relative;">
            <!--<a href="#" style="text-decoration: none;color:#000000;background-color: #ffffff;padding:5px;border-radius:5px;position:absolute;top:60px;right:20%;font-family:sans-serif;"><b>Request customized design</b></a></div> -->
            <img src="./view/icons/web_banner.jpg" width="100%" style="margin-top:5px;" />
        </div>

        <center>
            <a href="#" id="request-customized-button">Request customized design</a>
        </center>
        
        <div id="page-footer">
            <hr color="#cccccc" size="8px" width="100%" style="margin:0;" /> 
            <div id="footer-left-column">
                <b>Contact us</b><br /><br />
                <span><img src="./view/icons/telephone.jpg" />&nbsp +94 774 719 095 </span><br />
                <span><img src="./view/icons/email.jpg" />&nbsp rlfapparel@gmail.com </span><br />
                <span><img src="./view/icons/location_logo.png" />&nbsp 341/c/194 , 6th Lane ,<br />&nbsp Mahayaya Watta , Piliyandala </span>
                
            </div>
            <div id="footer-middle-column">
                <b>Follow us</b><br /><br />
                <a href="#"><img src="./view/icons/instagram.png" /></a>
                <a href="#"><img src="./view/icons/facebook.png" /></a>
                <a href="#"><img src="./view/icons/twitter.png" /></a>
                <br /><br />
                <b>Pay with</b><br /><br />
                <img src="./view/icons/visa_card.jpeg" id="visa-card-icon" />
            </div>
            <div id="footer-right-column">
                <b>Your message</b><br /><br />
                <form method="post" action="">
                    <input type="text" name="name" width="30%" placeholder="Name" /><br />
                    <input type="text" name="email" width="30%" placeholder="Email" /><br />
                    <textarea name="message" rows="4" cols="30" placeholder="Message"></textarea><br />
                    <input type="submit" value="Send" />
                </form>
            </div>
        </div> 

    </body>
</html>
    

