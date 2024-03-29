<?php
    session_start();
    error_reporting(E_ERROR | E_PARSE);
    $_SESSION["username"] = "";
    $_SESSION["employee_id"] = "";
    $_SESSION["user_type"] = "";
    $_SESSION["email"] = "";
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/login_page.css" />
    </head>

    <body style="background-image: url('../icons/login_bg.jpeg');">
        <center>
        <div id="login-box">
            <form name="loginForm" id="loginForm" method="post" action="../RouteHandler.php">
                <input type="text" hidden="true" name="framework_controller" value="employee/login" />
                <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                <table>
                    <tr>
                        <td>
                            <img src="../icons/login_logo.png" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                                <h2>Login</h2>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            Email : <br />
                            <input type="email" name="email" id="email" placeholder="Enter E mail" style="padding:5px;" required />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            Password : <br />
                            <input type="password" name="password" id="password" placeholder="Enter password" style="padding:5px;" required />
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:right;padding-right:20px;">
                            <br /><a href="request_forgot_password.php" style="text-decoration:none;">Forgot password ?</a>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <center>
                                <input type="submit" value="Login" class="login-button" />
                            <center>
                        </td>
                    </tr>
                </table>
            </form>
        </div>  
        </center>
    </body>
</html>