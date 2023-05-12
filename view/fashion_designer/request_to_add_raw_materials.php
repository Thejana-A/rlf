<?php
    error_reporting(E_ERROR | E_PARSE);
?>
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
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="home.php">Fashion Designer </a> > Request to add Raw materials
                </div>

   <div id="form-box">
                    <form method="post" name="rawMaterialForm" action="../RouteHandler.php" enctype="multipart/form-data">
                    <input type="text" hidden="true" name="framework_controller" value="raw_material/add" />
                    <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/fashion_designer/home.php" />
                    <input type="text" hidden="true" name="fashion_designer_id" value="<?php echo $_SESSION["employee_id"]; ?>">
                    
                        <center>
                            <h2>Raw Material Request Form</h2>
                        </center>

                    <div class="form-row">
                        <div class="form-row-theme">
                            Material Type : 
                        </div>
                        <div class="form-row-data">
                            <input type="text" name="name" id="name" placeholder="Material Name" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-row-theme">
                            Design view : 
                        </div>
                        <div class="form-row-data">
                        <input type="file" name="image" id="image" accept="image/png, image/gif, image/jpeg, image/tiff" required>
                        </div>
                    </div>
                    <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                                <select name="size" id="size">
                                    <option value="XS">XS</option>
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
                                <textarea id="" name="description" rows="4" cols="30"></textarea>
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