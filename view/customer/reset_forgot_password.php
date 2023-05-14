<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reset forgot password</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/login_page.css" />
        <script>
            function validateForm(){
                var password = document.forms["resetPasswordForm"]["password"].value;
                var confirm_password = document.forms["resetPasswordForm"]["confirm_password"].value;
                if (password.length < 8) {
                    alert("Password must have at least 8 characters");
                    return false;
                }else if (password != confirm_password) {
                    alert("Confirm your password correctly");
                    return false;
                }else{
                    return true;
                }
            }
        </script>
    </head>

    <body style="background-image: url('../icons/login_bg.jpeg');">
        <center>
        <div id="login-box">
            <form name="resetPasswordForm" id="resetPasswordForm" method="post" onSubmit="return validateForm()" action="../RouteHandler.php">
                <input type="text" hidden="true" name="framework_controller" value="customer/reset_forgot_password" />
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
                                <h2>Reset password</h2>
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
                            <input type="text" name="email_otp" id="email_otp" required />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            New password : <br />
                            <input type="password" name="password" id="password" required />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            Confirm password : <br />
                            <input type="password" name="confirm_password" id="confirm_password" required />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                                <input type="submit" value="Save" class="login-button" />
                            <center>
                        </td>
                    </tr>
                </table>
            </form>
        </div>  
        </center> 
    </body>
</html>