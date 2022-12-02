<!DOCTYPE html>
<html>
	<head>
	      <Meta name="viewpoint" content="width=device-width, initial-scale=1">
              <title> Add costume design </title>
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
                    <a href="#">Fashion Designer </a> > Add costume design
                </div>

	<div id="form-box">
                    <form method="post" action="">
                        <center>
                            <h2>Add Costume Design</h2>
                        </center>

		<div class="form-row">
                            <div class="form-row-theme">
                                Design name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
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
                                </select>
                            </div>
                        </div>

		<div class="form-row">
                            <div class="form-row-theme">
                                Front view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Rear view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Left view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Right view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="" id="" />
                            </div>
                        </div>

		<div class="form-row">
                            <div class="form-row-theme">
                               Description :
                            </div>
                            <div class="form-row-data">
                                <textarea id="" name="" rows="4" cols="40"></textarea>
                            </div>
                        </div>

		<div class="form-row">
                            <div class="form-row-theme">
                                <b>ID - Material name </b>
                            </div>
                            <div class="form-row-data">
                                <span><b>Quantity</b></span>
                                <span><b>Unit(LKR)</b></span>
                            </div>
                        </div>

		 <div class="form-row">
                            <div class="form-row-theme">
                                <select name="" id="">
                                    <option>Pink linen clothe</option>
                                    <option>black silk clothe</option>
                                    <option>red flat button</option>
                                </select>
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                            </div>
			    <div class="form-row">
                            	<div class="form-row-submit">
                                	<input type="submit" value="+" />
                            	</div>
			    </div>
                        </div>

		<div class="form-row">
                            <div class="form-row-submit">
                                <input type="submit" value="Save" />
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
