<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add raw material</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <script>
            function validateForm(){
                var manager_approval = document.forms["rawMaterialForm"]["manager_approval"].value;
                if(manager_approval == ""){
                    alert("Manager's approval is required!");
                    return false;
                }else{
                    return true;
                }
            }
        </script>
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
                    <form method="post" name="rawMaterialForm" onSubmit="return validateForm()" action="../RouteHandler.php" enctype="multipart/form-data">
                        <input type="text" hidden="true" name="framework_controller" value="raw_material/add" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <center>
                            <h2>Add raw material</h2>
                        </center>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw material name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="name" id="name" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                                <select name="size" id="size" required>
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
                                <select name="measuring_unit" id="measuring_unit" required>
                                    <option value="units">Units</option>
                                    <option value="metre">metre</option>
                                    <option value="kilogram">kilogram</option>
                                    <option value="litre">litre</option>
                                    <option value="yards">yards</option>
                                    <option value="m^2">m^2</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Image :
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="image" id="image" accept="image/png, image/gif, image/jpeg, image/tiff" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Description :
                            </div>
                            <div class="form-row-data">
                                <textarea id="description" name="description" rows="4" cols="40" required></textarea>
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
                                            <input type="radio" name="manager_approval" class="input-radio" id="" value="approve" onClick="setApprovalDate()" /> Approve
                                        </td>
                                        <td>
                                            <input type="radio" name="manager_approval" class="input-radio" id="" value="deny" onClick="setApprovalDate()" /> Deny
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <input type="date" hidden="true" name="approval_date" id="approval_date" value="<?php echo Date('Y-m-d'); ?>" />
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
