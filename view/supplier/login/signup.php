<?php
    error_reporting(E_ERROR | E_PARSE);
?>
<?php  

require "functions.php";

$errors = array();

if($_SERVER['REQUEST_METHOD'] == "POST")
{

	$errors = signup($_POST);

	if(count($errors) == 0)
	{
		header("Location: login.php");
		die;
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Signup</title>
	<link rel = "stylesheet" href="../css/login.css">
</head>
<body>
<div class="form-container">
	
			<div>
				<?php if(count($errors) > 0):?>
					<?php foreach ($errors as $error):?>
						<?= $error?> <br>	
					<?php endforeach;?>
				<?php endif;?>

			</div>
			<form name="supplierForm" id="supplierForm" method="post" action="../../RouteHandler.php">
            <input type="text" hidden="true" name="framework_controller" value="supplier/sign_up" />
			<center><h1>Signup</h1></center>
			<div>
				<label for="first_name">First Name</label>
				<input type="text" name="first_name" placeholder="First Name">
			</div>
			<div>
				<label for="last_name">Last Name</label>
				<input type="text" name="last_name" placeholder="Last Name">
			</div>
			<div>
				<label for="password">Password</label>
				<input type="password" name="password" placeholder="Password">
			</div>
			<div>
				<label for="confirm_password">Confirm Password</label>
				<input type="password" name="password2" placeholder="Confirm Password">
				
			</div>
			<div>
				<label for="NIC">NIC</label>
				<input type="text" name="NIC" placeholder="NIC">
			</div>
			<div>
				<label for="email">Email</label>
				<input type="email" name="email" placeholder="Email">
			</div>
			<div>
				<label for="contact_no">Contact Number</label>
				<input type="tel" name="contact_no" placeholder="Contact Number" pattern="[0-9]{2} [0-9]{3} [0-9]{3} [0-9]{3}" placeholder="94 123 456 789" required />
			</div>
			<div>
				<label for="city">City</label>
				<input type="text" name="city" placeholder="City">
			</div>
				<input type="submit" value="Signup">
				<p>Have an account already? <a href = "login.php">Log in</a></p>
			</form>
		</div>
	</div>
</body>
</html>