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
<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/fashion_designer/style.css" />
</head>
<body style="background-image: url('../icons/login_bg.jpeg'); height:100vh;">
		<form name="loginForm" id="loginForm" method="post" action="../RouteHandler.php">
        	<input type="text" hidden="true" name="framework_controller" value="employee/login" />
			<section id="image1">
					<img src="../icons/login_logo.png"class="logo" href="#"/>
				<div class="loginbox">
						<img src="../icons/avatar.png" class="avatar">
						<h1>Login Here</h1>
					<form>
						<p>Email</p>
							<input type="email" name="" placeholder="Enter Username" required />
						<p>Password</p>
							<input type="password" name="" placeholder="Enter Password" required />
							<input type="submit" name="" value="login">
							<a href="#">Forget Password ?</a><br>
							<a href="#">Create an account</a>
					</form>
				</div>
    		</section>
		</form>
</body>
</html>