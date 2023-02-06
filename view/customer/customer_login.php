<?php
    session_start();
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    $_SESSION["email"] = "";
    $_SESSION["customer_id"] = "";

    
    
?>
<!DOCTYPE html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
</head>
<body style="background-image: url('../image/login.png'); 
min-height:100%;
background-size: cover;
background-position: center; 
background-repeat: no-repeat; 
background-attachment: fixed;
margin: 0;
padding: 0;">

  <form action="../RouteHandler.php" method="post" class="container">
  <input type="text" hidden="true" name="framework_controller" value="customer/login" />

      <center><div class="loginlogo"><img src="../Icon/logo-login.png" width="200px"/></div>
      <h2>Login</h2></center>

    <?php if (isset($_GET['error'])) { ?>

    <p class="error"><?php echo $_GET['error']; ?></p>

    <?php } ?>

      <label><b>E mail</b></label>

      <input type="text" placeholder="Enter E mail" name="email" required>

      <label><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required>
      <!--<label for="usertype"><b>UserType</b></label><br />
      <select name="usertype" class="selection">
        <option value="customer">Customer</option>
        <option value="supplier">Supplier</option>
        <option value="merchandiser">Merchandiser</option>
        <option value="fashiondesigner">Fashion Designer</option>
      </select>-->
      <a href="../merchandiser/request_forgot_password.php" style="float:right;">forgot Password ?</a> 
      <br />
      <br />
      <br />
      <button type="submit" class="btn" name="Login">Login</button>
      Don't have any account
      <br />
      <br/>
      <a href="signup_as.html" style="color: red;">Create one Now..!</a> 

    </form>


</body>
</html>