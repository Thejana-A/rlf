<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View raw material</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <?php
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            if(isset($_GET['data'])){ 
                //parse_str($_SERVER['REQUEST_URI'],$row);
                $row = $_SESSION["row"];
                //print_r($row);
            }
            
            $materialID = $row["material_id"];
            $merchandiserID = $_SESSION["employee_id"];

            require_once('../../model/database.php');
            $conn = mysqli_connect($db_params['servername'], $db_params['username'], $db_params['password'], $db_params['dbname']);
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }

            $sql_material_supplier = "SELECT supplier.supplier_id , supplier.first_name, supplier.last_name FROM `supplier` INNER JOIN `material_supplier` ON material_supplier.supplier_id = supplier.supplier_id WHERE material_supplier.material_id = '$materialID' AND `verify_status` = 'approve';";
            $sql_all_supplier = "SELECT supplier_id, first_name, last_name FROM `supplier` where `verify_status` = 'approve';";
            $sql_material_design = "SELECT costume_design.design_id, name FROM `costume_design` INNER JOIN `design_material` ON design_material.design_id = costume_design.design_id WHERE design_material.material_id = '$materialID' AND costume_design.merchandiser_id = '$merchandiserID';";
            $sql_all_design = "SELECT design_id, name FROM `costume_design` WHERE merchandiser_id = '$merchandiserID';";
        
            date_default_timezone_set("Asia/Colombo");
        ?>

        <script>
            function validateStorageLogForm(){
                var store_action = document.forms["storageLogForm"]["store_action"].value;
                var quantity_in_stock = document.forms["storageLogForm"]["quantity_in_stock"].value;
                var quantity = document.forms["storageLogForm"]["quantity"].value;
                if (store_action == "") {
                    alert("Storage action is required");
                    return false;
                }else if((parseFloat(quantity_in_stock) < parseFloat(quantity))&&(store_action == "retrieve")){
                    alert("Sorry, quantity in stock isn't enough");
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
                    <a href="#">Merchandiser </a> >
                    <a href="#">View raw materials </a> > View
                </div>

                <div id="form-box-small">
                    <form method="post" action="">
                        <center>
                            <h2>View raw material</h2>
                        </center>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw material ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="material_id" id="material_id" value="<?php echo $row["material_id"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw material name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="name" id="name" value="<?php echo $row["name"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                                <select name="size" id="size" readonly>
                                    <option value="XS" <?php echo ($row["size"]=="XS")?'selected':'' ?>>XS</option>
                                    <option value="S" <?php echo ($row["size"]=="S")?'selected':'' ?>>S</option>
                                    <option value="M" <?php echo ($row["size"]=="M")?'selected':'' ?>>M</option>
                                    <option value="L" <?php echo ($row["size"]=="L")?'selected':'' ?>>L</option>
                                    <option value="XL" <?php echo ($row["size"]=="XL")?'selected':'' ?>>XL</option>
                                    <option value="XXL" <?php echo ($row["size"]=="XXL")?'selected':'' ?>>XXL</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Measuring unit : 
                            </div>
                            <div class="form-row-data">
                                <select name="measuring_unit" id="measuring_unit" readonly>
                                <option value="units" <?php echo ($row["measuring_unit"]=="units")?'selected':'' ?>>Units</option>
                                    <option value="m" <?php echo ($row["measuring_unit"]=="m")?'selected':'' ?>>metre</option>
                                    <option value="kg" <?php echo ($row["measuring_unit"]=="kg")?'selected':'' ?>>kilogram</option>
                                    <option value="l" <?php echo ($row["measuring_unit"]=="l")?'selected':'' ?>>litre</option>
                                    <option value="yards" <?php echo ($row["measuring_unit"]=="yards")?'selected':'' ?>>yards</option>
                                    <option value="m^2" <?php echo ($row["measuring_unit"]=="m^2")?'selected':'' ?>>m^2</option>
                                </select>
                            </div>
                        </div>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Description :
                            </div>
                            <div class="form-row-data">
                                <textarea id="description" name="description" rows="4" cols="40" readonly><?php echo $row["description"]; ?></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Image :
                            </div>
                            <div class="form-row-data">
                                <img src="../raw-material-image/<?php echo $row["image"]; ?>" class="material-image" />
                            </div>
                        </div>

                        <center>
                            <h2>Related details</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Suppliers : 
                            </div>
                            <div class="form-row-data">
                                <?php  
                                    $material_supplier_id = array();
                                    if($result = mysqli_query($conn, $sql_material_supplier)){
                                        if(mysqli_num_rows($result) > 0){
                                            while($material_supplier_row = mysqli_fetch_array($result)){
                                                array_push($material_supplier_id, $material_supplier_row["supplier_id"]);
                                            }
                                        }
                                    }
                                    $all_supplier_select = "";
                                    if($result = mysqli_query($conn, $sql_all_supplier)){
                                        if(mysqli_num_rows($result) > 0){
                                            $all_supplier_select .= "<select name='supplier_id[]' id='supplier_id[]' multiple size='3' onClick='window.location.href=this.value'>";
                                            $all_supplier_select .= "<option disabled>ID - Supplier name</option>";
                                            while($all_supplier_row = mysqli_fetch_array($result)){
                                                $all_supplier_select .= "<option value=view_supplier.php?supplier_id=".$all_supplier_row["supplier_id"];
                                                if(in_array($all_supplier_row["supplier_id"], $material_supplier_id)){
                                                    $all_supplier_select .= " selected>".$all_supplier_row["supplier_id"]." - ".$all_supplier_row["first_name"]." ".$all_supplier_row["last_name"]."</option>";
                                                }else{
                                                    $all_supplier_select .= ">".$all_supplier_row["supplier_id"]." - ".$all_supplier_row["first_name"]." ".$all_supplier_row["last_name"]."</option>";
                                                } 
                                            }
                                            $all_supplier_select .= "</select>";
                                        }else {
                                            $all_supplier_select = "0 results";
                                        }
                                        echo $all_supplier_select;
                                    }else{
                                        echo "ERROR: Could not able to execute $sql_all_supplier. " . mysqli_error($conn);
                                    }  
                                ?>
                                <!--<select name="" id="" multiple size="2">
                                    <option disabled>Supplier ID - Supplier name</option>
                                    <option>0001-John A</option>
                                    <option>0004-John B</option>
                                    <option>0010-John C</option>
                                    <option>0011-John D</option>
                                </select> -->
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Costume designs : 
                            </div>
                            <div class="form-row-data">
                                <?php  
                                    $material_design_id = array();
                                    if($result = mysqli_query($conn, $sql_material_design)){
                                        if(mysqli_num_rows($result) > 0){
                                            while($material_design_row = mysqli_fetch_array($result)){
                                                array_push($material_design_id, $material_design_row["design_id"]);
                                            }
                                        }
                                    }
                                    $all_design_select = "";
                                    if($result = mysqli_query($conn, $sql_all_design)){
                                        if(mysqli_num_rows($result) > 0){
                                            $all_design_select .= "<select name='design_id[]' id='design_id[]' multiple size='3' onClick='window.location.href=this.value'>";
                                            $all_design_select .= "<option disabled>ID - Design name</option>";
                                            while($all_design_row = mysqli_fetch_array($result)){
                                                $all_design_select .= "<option value=edit_costume_design.php?design_id=".$all_design_row["design_id"];
                                                if(in_array($all_design_row["design_id"], $material_design_id)){
                                                    $all_design_select .= " selected>".$all_design_row["design_id"]." - ".$all_design_row["name"]."</option>";
                                                }else{
                                                    $all_design_select .= ">".$all_design_row["design_id"]." - ".$all_design_row["name"]."</option>";
                                                } 
                                            }
                                            $all_design_select .= "</select>";
                                        }else {
                                            $all_design_select = "No costume designs assigned yet";
                                        }
                                        echo $all_design_select;
    
                                    }else{
                                        echo "ERROR: Could not able to execute $sql_all_design. " . mysqli_error($conn);
                                    }  
                                ?>
                                <!--<select name="" id="" multiple size="2">
                                    <option disabled>Design ID - Design name</option>
                                    <option>0002-Black T-shirt-S</option>
                                    <option>0007-Blue T-shirt-M</option>
                                    <option>0012-Red stipped top-XXL</option>
                                    <option>0013-Green Chinese collar-M</option>
                                </select> -->
                            </div>
                        </div>
                        
                    </form>
                </div> 
                
                <div id="form-box-small">
                <form method="post" name="storageLogForm" action="../RouteHandler.php" onSubmit="return validateStorageLogForm()">
                        <input type="text" hidden="true" name="framework_controller" value="storage_log/manage" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/merchandiser/home.php" />
                        <center>
                            <h2>Retrieve from storage</h2>
                        </center>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw material ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="merchandiser_id" hidden="true" value="<?php echo $_SESSION["employee_id"]; ?>" />
                                <input type="text" name="material_id" value="<?php echo $row["material_id"]; ?>" readonly />
                                <input type="text" name="time_stamp" hidden="true" value="<?php echo date("Y-m-d H:i:s"); ?>" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Measuring unit : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="measuring_unit" value="<?php echo $row["measuring_unit"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quantity in storage :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="quantity_in_stock" value="<?php echo $row["quantity_in_stock"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quantity :
                            </div>
                            <div class="form-row-data">
                                <input type="number" step="0.01" min="0.01" name="quantity" id="quantity" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Action :
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="store_action" class="input-radio" value="store" /> Store
                                        </td>
                                        <td>
                                            <input type="radio" name="store_action" class="input-radio" value="retrieve" /> Retrieve
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
