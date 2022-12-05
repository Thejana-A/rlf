<!DOCTYPE html>
<html>
	<head>
	      <Meta name="viewpoint" content="width=device-width, initial-scale=1">
              <title> Edit costume design </title>
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
                    <a href="#">Merchandiser </a> >
                    <a href="#">Edit costume designs </a> > Edit
                </div>

                <div id="form-box">
                    <form method="post" action="">
                        <center>
                            <h2>Costume Design</h2>
                        </center>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Design ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
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
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Design View :
                            </div>
                            <div class="form-row-data">
                                <img src="../icons/shirt.png" alt="All-views" class="design-view" />
                            </div>
                        </div>

                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>ID - Material name </b>
                            </div>
                            <div class="form-row-data">
                                <span><b>Quantity</b></span>
                                <span><b>Unit</b></span>
                            </div>
                        </div>

		 <div class="form-row">
                            <div class="form-row-theme">
                                <select name="" id="">
                                    <option>0001-Pink linen clothe</option>
                                    <option>0120-black silk clothe</option>
                                    <option>0015-red flat button</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                0001-Pink linen clothe(m)
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" value="5000" class="column-textfield"  />
                                <input type="text" name="" id="" value="m"class="column-textfield" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                0120-black silk clothe
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" value="1000"class="column-textfield" />
                                <input type="text" name="" id="" value="m"class="column-textfield" />
                            </div>
                        </div>
                        <div class="form-row-add">
                                    <input type="submit" value="+" />
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

