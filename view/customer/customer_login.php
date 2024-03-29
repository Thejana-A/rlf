<?php
    session_start();
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    $_SESSION["email"] = "";
    $_SESSION["customer_id"] = "";
    $_SESSION["username"] = "";
    $_SESSION["employee_id"] = "";
    $_SESSION["supplier_id"] = "";
    $_SESSION["user_type"] = "";

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
  <button type="button" onclick="goback()" class="back">Go Back</button>

  <form action="../RouteHandler.php" method="post" class="container">
  <input type="text" hidden="true" name="framework_controller" value="employee/login" />
  <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />

      <center><div class="loginlogo"><img src="../Icon/logo-login.png" width="200px"/></div>
      <h2>Login</h2></center>

      <label><b>E mail</b></label>
      <input type="text" placeholder="Enter E mail" name="email" required>

      <label><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required>

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
    <script>
    function goback(){
        window.location.href = "../../index.php";

    }
    </script>

</body>
</html>