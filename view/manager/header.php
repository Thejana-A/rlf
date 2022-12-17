<link rel="stylesheet" type="text/css" href="../css/merchandiser/header_style.css" />

<div id="top-header">
    <span id="rlf-logo-span">
        <center><a href="#"><img src="../icons/rlf_logo.png" /></a></center>
    </span> 
    <span id="logout-button-span">
        <a href="./login.php" id="logout-button">Logout</a>
    </span>  
</div>

<div style="height:1px;background-color:#aaaaaa;"></div>

<div id="top-nav">
    <button onclick="displayLeftNav()">
        <img src="../icons/left-nav-button.png" />
    </button>    
    <a href="edit_self_profile.php"> <span id="top-nav-username"><?php echo $_SESSION["username"]; ?><img src="../icons/user_icon.png" style="width:30px;" /></span></a>
</div>
