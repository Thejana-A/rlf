
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Verify email</title>
		<link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../supplier/css/view_list_style.css" />
		<link rel = "stylesheet" href="../supplier/login/login.css">
    </head>

    <body style="background-image: url('../icons/login_bg.jpeg');">
        <center>
        <div id="login-box">
            <form name="verifyEmailForm" id="verifyEmailForm" method="post" action="../RouteHandler.php">
                <input type="text" hidden="true" name="framework_controller" value="supplier/verify_email" />
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
                                <h2>Verify email</h2>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            Email : <br />
                            <input type="email" name="email" id="email" value="<?php echo $_GET["email"]; ?>" readonly required />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            OTP code : <br />
                            <input type="email_otp" name="email_otp" id="email_otp" required />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                                <input type="submit" value="Verify" class="login-button" />
                            <center>
                        </td>
                    </tr>
                </table>
            </form>
        </div>  
        </center> 
    </body>
</html>