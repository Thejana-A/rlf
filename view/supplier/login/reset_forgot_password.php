

<!DOCTYPE html>
<html>
<head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reset forgot password</title>
	<link rel = "stylesheet" href="../css/login.css">
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


	<div>
		<div>
			<?php if(count($errors) > 0):?>
				<?php foreach ($errors as $error):?>
					<?= $error?> <br>	
				<?php endforeach;?>
			<?php endif;?>

		</div>
        <form name="resetPasswordForm" id="resetPasswordForm" method="post" onSubmit="return validateForm()" action="../../RouteHandler.php">
                <input type="text" hidden="true" name="framework_controller" value="supplier/reset_forgot_password" />
                <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
		<h1>Reset password</h1>
		<div>
			<label for="email">Email</label>
			<input type="email" name="email" placeholder="Email" id="email" value="<?php echo $_GET["email"]; ?>" readonly required>
		</div>
        <div>
			<label for="email_otp">Email otp</label>
			<input type="text" name="email_otp" placeholder="Email" id="email_otp"  required>
		</div>
		<div>
			<label for="password"> New Password</label>
			<input type="password" name="password" placeholder="Password" id="password" required ><br>
		</div>
        <div>
			<label for="password"> Confirmssword</label>
			<input type="password" name="confirm_password" placeholder="Password" id="confirm_password" required ><br>
		</div>
	
			<input type="submit" value="Save">
			
		</form>
	</div>
 </div>
</body>
</html>