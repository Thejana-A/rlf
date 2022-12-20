<link rel="stylesheet" type="text/css" href="../supplier/css/header_style.css" />
<div id="top-header">
    <span id="rlf-logo-span">
        <center><a href="#"><img src="../icons/rlf_logo.png" /></a></center>
    </span> 
    <span id="rlf-header-link-span">
                <center>
                  <a href="about_us.php">About us</a>
                  <a href="contact_us.php">Contact us</a>
                  <a href="help.php">Help</a>
                </center>
            </span>
    <span id="logout-button-span">
        <a href="./login/login.php" id="logout-button">Logout</a>
    </span>  
</div>

<div style="height:2px ;background-color:#aaaaaa;"></div>

<div id="top-nav">
    <button onclick="displayLeftNav()">
        <img src="../icons/left-nav-button.png" />
    </button>    
    <a href="edit_self_profile.php"> <span id="top-nav-username"><?php echo $_SESSION["username"]; ?><!-- Nayomi Karunaratne --> &nbsp<img src="../icons/user_icon.png" style="width:30px;" /></span></a>
</div>
