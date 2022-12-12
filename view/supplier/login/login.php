<?php  

require "functions.php";

$errors = array();

if($_SERVER['REQUEST_METHOD'] == "POST")
{

	$errors = login($_POST);

	if(count($errors) == 0)
	{
		header("Location: ../profile.php");
		die;
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link rel = "stylesheet" href="../css/login.css">
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
		<form name="loginForm" id="loginForm" method="post" action="../../RouteHandler.php">
        <input type="text" hidden="true" name="framework_controller" value="supplier/login" />
		<h1>Login</h1>
		<div>
			<label for="email">Email</label>
			<input type="email" name="email" placeholder="Email">
		</div>
		<div>
			<label for="password">Password</label>
			<input type="password" name="password" placeholder="Password"><br>
			<a href = "#">Forgot password? </a>

			
			<input type="submit" value="Login">
			<p>Not a registered user? <a href = "signup.php">Create account</a></p>
			
		</form>
	</div>
 </div>
</body>
</html>