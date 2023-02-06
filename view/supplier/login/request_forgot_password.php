<?php
	session_start();
    error_reporting(E_ERROR | E_PARSE);
	$_SESSION["supplier_id"] = "";
?>
<?php  

$errors = array();

if($_SERVER['REQUEST_METHOD'] == "POST")
{

	$errors = login($_POST);

	if(count($errors) == 0)
	{
		header("Location: reset_forgot_passowrd.php");
		die;
	}
}

?>

<!DOCTYPE html>
<html>
<head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Verify email</title>
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
        <form method="post" action="../../RouteHandler.php">
                <input type="text" hidden="true" name="framework_controller" value="supplier/request_forgot_password" />
                <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
		<h1>Forgot password?</h1>
		<div>
			<label for="email">Email</label>
			<input type="email" name="email" placeholder="Email" id="email"  required>
		
			<input type="submit" value="Confirm email">
			
		</form>
	</div>
 </div>
</body>
</html>
