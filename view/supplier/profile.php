<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Profile</title>
	<link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
    <link rel="stylesheet" type="text/css" href="../supplier/css/view_list_style.css" />
	<style>
	/* Container holding the image and the text */
.container {
  position: relative;
}

/* Bottom right text */
.text-block {
  position: absolute;
  bottom: 250px;
  right: 850px;
  color: black;
  background-color: transparent;
  padding-left: 20px;
  padding-right: 20px;
}
</style>
</head>
<body>

	<?php include 'header.php';?>

	<div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="index.php">Welcome </a> >
                    <a href="login.php">Login </a> >
                    <a href="home.php">Supplier </a> > All raw materials                    
                </div>
			
				<div class="container">
					<img src="img.jpg" alt="img"  style="width: 1200px;height: 500px;">
					<div class="text-block">
					<?php if(check_login(false)):?>
							<h2><b>Hi, <?=$_SESSION['USER']->first_name?></b></h2>
					<br><br>
						<center>
							<h3><i>Some people want it to happen, <br> some wish it would happen, <br> others make it happen."</i></h3></center>
						<br><br>
					<?php endif;?>
				
				</div>
				</div>
		</div>
		</div>
		<?php include 'footer.php';?>
</body>
</html>