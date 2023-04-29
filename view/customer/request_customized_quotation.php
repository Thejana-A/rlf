<?php require_once 'redirect_customer_login.php' ?>
<?php
 error_reporting(E_ERROR | E_PARSE);
?>
<!DOCTYPE html>
<head>
    <title>Customized Request Qutation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
    <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
</head>
<body>
        <div id="breadcrumb">
            <a href="customer_home.php">Home </a> > Request Customized Design
        </div>
        <div id="form-box">
                        <form method="post" name="costumeDesignForm" action="../RouteHandler.php" enctype="multipart/form-data">
                            <input type="text" hidden="true" name="framework_controller" value="costume_design/add_customized_design" />
                            <input type="text" hidden="true" name="home_url" value="customer/customer_home.php" />
                            <input type="text" hidden="true" name="customer_id" value="<?php echo $_SESSION["customer_id"] ?>" />
                            <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                            <center>
                                <h2>Request Customized Design</h2>
                            </center>
                            
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Proposed Name : 
                                </div>
                                <div class="form-row-data">
                                    <input type="text" name="name" id="name" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    
                                </div>
                                <div class="form-row-data">
                                    <img src="../image/size-chart- new.png" width="60%">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Size : 
                                </div>
                                <div class="form-row-data">
                                <select name="size[]" multiple required>
                                    <option value="XS" selected >XS</option>
                                    <option value="S" selected>S</option>
                                    <option value="M" selected>M</option>
                                    <option value="L" selected>L</option>
                                    <option value="XL" selected>XL</option>
                                    <option value="XXL" selected>XXL</option>
                                    
                                </select>
                                </div>
                            </div>

                            
                            
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Front view : 
                                </div>
                                <div class="form-row-data">
                                    <input type="file" name="front_view" id="front_view" accept="image/png, image/gif, image/jpeg, image/tiff" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Rear view : 
                                </div>
                                <div class="form-row-data">
                                    <input type="file" name="rear_view" id="rear_view" accept="image/png, image/gif, image/jpeg, image/tiff" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Left view : 
                                </div>
                                <div class="form-row-data">
                                    <input type="file" name="left_view" id="left_view" accept="image/png, image/gif, image/jpeg, image/tiff" required/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Right view : 
                                </div>
                                <div class="form-row-data">
                                    <input type="file" name="right_view" id="right_view" accept="image/png, image/gif, image/jpeg, image/tiff" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Description
                                </div>
                                <div class="form-row-data">
                                    <textarea rows="4" cols="40" name="description" id="description" required></textarea>
                                </div>
                            </div>

                            

                            <div class="form-row">
                                <div class="form-row-submit">
                                    <a href="request_customized_quotation.php">
                                        <input type="submit" value="Request Design Quotation" />
                                    </a>
                                </div>
                                <div class="form-row-reset">
                                    <input type="reset" value="Cancel" />
                                </div>
                            </div> 
                        </form>
                    </div> 

    <?php include 'footer.php';?>
</body>
</html>