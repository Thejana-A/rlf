<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Reset forgot password</title>
	<link rel = "stylesheet" href="css/login.css">
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
<body>


<div class="form-container">

		<form method="post" onSubmit="return validateForm()" action="../RouteHandler.php">
        <input type="text" hidden="true" name="framework_controller" value="supplier/reset_forgot_password" />
		<h1>Reset password</h1>
		<div>
			<label for="email">Email</label>
			<input type="email" name="email" id="email" placeholder="Email" value="<?php echo $row ["email"]; ?>" readonly required>
		</div>
        <div>
			<label for="otp">OTP code :</label>
			<input type="text" name="email_otp" placeholder="Email OTP" id="email_otp" required >
		</div>
		<div>
			<label for="password">New password</label>
			<input type="password" name="password" id = "password" placeholder="Password" required><br>

        </div>
        <div>
			<label for="password">Confirm password</label>
			<input type="password" name="confirm_password" id = "confirm_password" placeholder=" Confirm Password" required><br>

			
			<input type="submit" value="Login">
			
		</form>
	</div>
 </div>
</body>
</html>