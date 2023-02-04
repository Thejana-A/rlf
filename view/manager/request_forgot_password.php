
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Verify email</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/login_page.css" />
    </head>

    <body style="background-image: url('../icons/login_bg.jpeg');">
        <center>
        <div id="login-box">
            <form method="post" action="../RouteHandler.php">
                <input type="text" hidden="true" name="framework_controller" value="employee/request_forgot_password" />
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
                                <h2>Forgot password ?</h2>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            Email : <br />
                            <input type="email" name="email" id="email" required />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                                <input type="submit" value="Confirm email" class="login-button" />
                            <center>
                        </td>
                    </tr>
                </table>
            </form>
        </div>  
        </center> 
    </body>
</html>