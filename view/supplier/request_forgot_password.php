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
        <input type="text" hidden="true" name="framework_controller" value="supplier/request_forgot_password" />
		<h1>Forgot Password ?</h1>
		<div>
			<label for="email">Email</label>
			<input type="email" name="email" placeholder="Email">
		</div>
		

			
			<input type="submit" value="Confirm email">
			
			
		</form>
	</div>
 </div>
</body>
</html>