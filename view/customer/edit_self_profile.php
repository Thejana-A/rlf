<?php 
    session_start();
?>
<!DOCTYPE html>
    <head>
        <title>Reset Password </title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <script>
            function validateResetPassword(){
                var newPassword = document.forms["resetPasswordForm"]["new_password"].value;
                var confirmPassword = document.forms["resetPasswordForm"]["confirm_password"].value;
                if(newPassword.length < 8){
                    alert("New password should have at least 8 characters");
                    return false;
                }else if(newPassword != confirmPassword){
                    alert("Confirm new password correctly");
                    return false;
                }else{
                    return true;
                } 
            }
        </script>
    </head>
    <body>
    <div id="page-content">       
        <div id="form-box-small">
            <form method="post" name="resetPasswordForm" action="../RouteHandler.php" onSubmit="return validateResetPassword()">
                <input type="text" hidden="true" name="framework_controller" value="customer/reset_password" />
                <input type="text" hidden="true" name="home_url" value="customer/customer_home.php" />
                <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                <center>
                    <h2>Reset password</h2>
                </center>
                <div class="form-row">
                    <div class="form-row-theme">
                        Current password : 
                    </div>
                    <div class="form-row-data">
                        <input type="password" name="password" />
                        <input type="text" hidden="true" name="customer_id" value="<?php echo $_SESSION["customer_id"]; ?>" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-row-theme">
                        New password : 
                    </div>
                    <div class="form-row-data">
                        <input type="password" name="new_password" id="new_password" required />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-row-theme">
                        Confirm password : 
                    </div>
                    <div class="form-row-data">
                        <input type="password" name="confirm_password" id="confirm_password" required />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-row-submit">
                        <input type="submit" value="Save" />
                    </div>
                    <div class="form-row-reset">
                        <input type="reset" value="Cancel" />
                    </div>
                </div> 
            </form>
        </div> 
        </div>
    </body>
</html>

            