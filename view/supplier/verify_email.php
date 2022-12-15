<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Verify email</title>
	<link rel = "stylesheet" href="css/login.css">
</head>
<body>


<div class="form-container">

		<form method="post" action="../RouteHandler.php">
        <input type="text" hidden="true" name="framework_controller" value="supplier/verify_email" />
		<h1>Verify email</h1>
		<div>
			<label for="email">Email</label>
			<input type="email" name="email" id="email" placeholder="Email" value="<?php echo $_GET["email"]; ?>" readonly required>
		</div>
        <div>
			<label for="otp">OTP code :</label>
			<input type="text" name="email_otp" placeholder="Email OTP" id="email_otp" required >
			
			<input type="submit" value="Verify">
			
		</form>
	</div>
 </div>
</body>
</html>