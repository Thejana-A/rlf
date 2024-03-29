<?php
    error_reporting(E_ERROR | E_PARSE);
?>
<?php
    session_start();
 require_once 'redirect.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add tender request</title>
        <link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>
        <div id="page-body">
            
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="profile.php">Supplier </a> >Add new raw material
                </div>

                <div id="form-box-ultra-small">
                <form method="post" name="rawMaterialForm" action="../RouteHandler.php" enctype="multipart/form-data">
                    <input type="text" hidden="true" name="framework_controller" value="raw_material/add" />
                    <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/supplier/profile.php" />
                    <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                    <input type="text" hidden="true" name="supplier_id" value="<?php echo $_SESSION["supplier_id"]; ?>">

                        <center>
                            <h2> Add a raw material request</h2>
                        </center>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw material name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="name" id="name" placeholder="Material Name-Size" required/>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                                <select name="size" id="">
                                    <option value="XS">XS</option>                                 
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                    <option value="XXL">XXL</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Measuring unit : 
                            </div>
                            <div class="form-row-data">
                                <select name="measuring_unit" id="" >
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
                                <textarea id="" name="description" rows="4" cols="40" required ></textarea>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Image :
                            </div>
                            <div class="form-row-data">
                            <input type="file" name="image" id="image" accept="image/png, image/gif, image/jpeg, image/tiff" required>
                            </div>  
                        </div>
                          
                            <div class="form-row">
                            <div class="form-row-submit">
                                <input type="submit" value="Submit" />
                            </div>
                            <div class="form-row-reset">
                                <input type="reset" value="Reset" />
                            </div>
                        </div>           
                    </form>                
                </div>
            </div>

        </div>
                        
                       
        <?php include 'footer.php';?>

    </body> 
</html>
