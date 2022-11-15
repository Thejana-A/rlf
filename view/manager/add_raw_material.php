<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add raw material</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>
        <div id="page-body">
            
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Manager </a> >
                    <a href="#">View raw materials </a> > Add new raw material
                </div>

                <div id="form-box-ultra-small">
                    <form method="post" name="rawMaterialForm" onSubmit="return validateForm()" action="../RouteHandler.php">
                    <input type="text" hidden="true" name="framework_controller" value="raw_material/add" />
                        <center>
                            <h2>Add raw material</h2>
                        </center>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw material name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="name" id="name" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                                <select name="size" id="size">
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
                                <select name="measuring_unit" id="measuring_unit">
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
                                Image :
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
                                <textarea id="description" name="description" rows="4" cols="40"></textarea>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Approval status :
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="manager_approval" class="input-radio" id="" /> Approve
                                        </td>
                                        <td>
                                            <input type="radio" name="manager_approval" class="input-radio" id="" /> Deny
                                        </td>
                                    </tr>
                                </table>
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
