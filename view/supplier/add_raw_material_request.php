<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add raw material request</title>
        <link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>
        <div id="page-body">
            
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="index.php">Welcome </a> >
                    <a href="login.php">Login </a> >
                    <a href="home.php">Supplier </a> >Request to add
                </div>

                <div id="form-box-ultra-small">
                <form method="post" name="rawMaterialForm" action="../RouteHandler.php" enctype="multipart/form-data">
                    <input type="text" hidden="true" name="framework_controller" value="raw_material/add" />
                        <center>
                            <h2> Add raw material request</h2>
                        </center>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw material name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="name" id="" required/>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                                <select name="size" id="">
                                    <option>XS</option>                                 
                                    <option>S</option>
                                    <option>M</option>
                                    <option>L</option>
                                    <option>XL</option>
                                    <option>XXL</option>
                                    <option>XXXL</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Measuring unit : 
                            </div>
                            <div class="form-row-data">
                                <select name="measuring_unit" id="" >
                                    <option>Units</option>
                                    <option>m</option>
                                    <option>yards</option>
                                    <option>reels</option>
                                    <option>m^2</option>
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
                                <input type="submit" value="Reset" />
                            </div>
                        </div>           
                    </form>                
                </div>
            </div>

        </div>
                        
                       
        <?php include 'footer.php';?>

    </body> 
</html>
