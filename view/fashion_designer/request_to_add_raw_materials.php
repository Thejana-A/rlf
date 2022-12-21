<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<html>
	<head>
	      <Meta name="viewpoint" content="width=device-width, initial-scale=1">
              <title> Request to add Raw materials </title>
              <link rel="stylesheet" type="text/css" href="../css/fashion_designer/data_form_style.css" />
	</head>

<body>
	<?php include 'header.php';?>

	<div id="page-body">
            <?php include 'leftnav.php';?>

	<div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Fashion Designer </a> > Request to add Raw materials
                </div>

	<div id="form-box">
                    <form method="post" action="">
                    <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/fashion_designer/home.php" />
                        <center>
                            <h2>Raw Material Request Form</h2>
                        </center>

                    <div class="form-row">
                        <div class="form-row-theme">
                            Material Type : 
                        </div>
                        <div class="form-row-data">
                            <input type="text" name="" id="" />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-row-theme">
                            Design view : 
                        </div>
                        <div class="form-row-data">
                            <input type="file" name="" id="" />
                        </div>
                    </div>
                    <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                                <select name="" id="">
                                    <option>XS</option>
                                    <option>S</option>
                                    <option>M</option>
				                    <option>L</option>
				                    <option>XL</option>
                                    <option>XXL</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="form-row-theme">
                            Measuring unit : 
                        </div>
                        <div class="form-row-data">
                            <select name="measuring_unit" id="measuring_unit" required>
                                <option value="units">Units</option>
                                <option value="m">metre</option>
                                <option value="kg">kilogram</option>
                                <option value="l">litre</option>
                                <option value="yards">yards</option>
                                <option value="m^2">m^2</option>
                            </select>
                        </div>
                    </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                               Description :
                            </div>
                            <div class="form-row-data">
                                <textarea id="" name="" rows="4" cols="30"></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-submit">
                                <input type="submit" value="Submit" />
                            </div>
                            <div class="form-row-reset">
                                <input type="reset" value="Cancel" />
                            </div>
                        </div> 
                    </form>
		        </div>
	        </div>
	    </div>
                    




        <?php include 'footer.php';?>

</body> 
</html>