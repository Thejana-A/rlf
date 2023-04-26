<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit raw material</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <?php
            $_SESSION["view_costume_path"] = "costume_design";
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            //$conn = new mysqli("localhost", "root", "", "rlf");
            require_once('../../model/database.php');
            $conn = mysqli_connect($db_params['servername'], $db_params['username'], $db_params['password'], $db_params['dbname']);
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            } 
            
            if(isset($_GET['data'])){ 
                //parse_str($_SERVER['REQUEST_URI'],$row);
                $row = $_SESSION["row"];
                //print_r($row);
            }else{
                $sql_view_raw_material = 
                "SELECT material_id,name,size,measuring_unit,quantity_in_stock,description,image, raw_material.supplier_id as requester_id,'supplier' as requester_role, first_name,last_name,manager_approval,approval_description FROM raw_material,supplier where raw_material.supplier_id = supplier.supplier_id and material_id = '".$_GET["material_id"]."'
                UNION
                SELECT material_id,name,size,measuring_unit,quantity_in_stock,description,image, raw_material.fashion_designer_id as requester_id,'fashion designer' as requester_role, first_name,last_name,manager_approval,approval_description FROM raw_material,employee where raw_material.fashion_designer_id = employee.employee_id and material_id = '".$_GET["material_id"]."'
                UNION
                SELECT material_id,name,size,measuring_unit,quantity_in_stock,description,image,'' as requester_id,'' as requester_role, '' as first_name,'' as last_name,manager_approval,approval_description FROM raw_material where fashion_designer_id is null and supplier_id is null AND material_id = '".$_GET["material_id"]."';";
                $result_view_raw_material = mysqli_query($conn, $sql_view_raw_material);
                $row = mysqli_fetch_array($result_view_raw_material);
            }
            
            $materialID = $row["material_id"];

            $sql_material_supplier = "SELECT supplier.supplier_id , supplier.first_name, supplier.last_name FROM `supplier` INNER JOIN `material_supplier` ON material_supplier.supplier_id = supplier.supplier_id WHERE material_supplier.material_id = '$materialID' AND `verify_status` = 'approve';";
            $sql_material_design = "SELECT costume_design.design_id, name FROM `costume_design` INNER JOIN `design_material` ON design_material.design_id = costume_design.design_id WHERE design_material.material_id = '$materialID';";
            $sql_material_quotation = "SELECT raw_material_quotation.quotation_id, material_price.material_id, measuring_unit, request_quantity, unit_price, valid_till, supplier_approval, raw_material_quotation.supplier_id, first_name, last_name FROM raw_material_quotation, material_price, raw_material,supplier WHERE material_price.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material.material_id = '$materialID' AND supplier_approval = 'approve' AND material_price.material_id = '$materialID';";


            date_default_timezone_set("Asia/Colombo");
        ?>

        <script>
            function validateStorageLogForm(){
                var store_action = document.forms["storageLogForm"]["store_action"].value;
                var quantity_in_stock = document.forms["storageLogForm"]["quantity_in_stock"].value;
                var quantity = document.forms["storageLogForm"]["quantity"].value;
                var quotation_id = document.forms["storageLogForm"]["quotation_id"].value;
                if (store_action == "") {
                    alert("Storage action is required");
                    return false;
                }else if((parseFloat(quantity_in_stock) < parseFloat(quantity))&&(store_action == "retrieve")){
                    alert("Sorry, quantity in stock isn't enough");
                    return false;
                }else if((quotation_id.split("-")[1] < parseFloat(quantity))&&(store_action == "store")){
                    alert("Sorry, quantity can't exceed quotation quantity");
                    return false;
                }else if((typeof quotation_id.split("-")[1] === 'undefined')&&(store_action == "store")){
                    alert("A quotation should be selected");
                    return false;
                }else{
                    return true;
                }
            }

            function disableQuotationID(){
                document.getElementById("quotation_id").disabled = true;
            }
            function enableQuotationID(){
                document.getElementById("quotation_id").disabled = false;
            }
        </script>
    </head>

    <body>
        <?php include 'header.php';?>
        <div id="page-body">
            
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="home.php">Manager</a> >
                    <a href="raw_materials.php">View raw materials </a> > Edit
                </div>

                <div id="form-box-ultra-small">
                    <form method="post" action="../RouteHandler.php" enctype="multipart/form-data">
                        <input type="text" hidden="true" name="framework_controller" value="raw_material/update" />
                        <input type="text" name="approval_date" hidden="true" value="<?php echo ($row["approval_date"]==""?Date("Y-m-d"):$row["approval_date"]); ?>" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <center>
                            <h2>Edit raw material</h2>
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
                                <input type="text" name="name" id="name" value="<?php echo $row["name"]; ?>" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                                <select name="size" id="size">
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
                                <select name="measuring_unit" id="measuring_unit">
                                    <option value="units" <?php echo ($row["measuring_unit"]=="units")?'selected':'' ?>>Units</option>
                                    <option value="metre" <?php echo ($row["measuring_unit"]=="m")?'selected':'' ?>>metre</option>
                                    <option value="kilogram" <?php echo ($row["measuring_unit"]=="kg")?'selected':'' ?>>kilogram</option>
                                    <option value="litre" <?php echo ($row["measuring_unit"]=="l")?'selected':'' ?>>litre</option>
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
                                <textarea id="description" name="description" rows="4" cols="40"><?php echo $row["description"]; ?></textarea>
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
                        <div class="form-row">
                            <div class="form-row-theme">
                                Update image : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="image" id="image" accept="image/png, image/gif, image/jpeg, image/tiff" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quantity in stock : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="quantity_in_stock" value="<?php echo $row["quantity_in_stock"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Requester's ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="requester_id" id="requester_id" value="<?php echo $row["requester_id"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Requester's name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="requester_name" id="requester_name" value="<?php echo $row["first_name"]." ".$row["last_name"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Requester's role : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="requester_role" id="requester_role" value="<?php echo $row["requester_role"]; ?>" readonly />
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
                                            <input type="radio" name="manager_approval" class="input-radio" value="approve" <?php echo ($row["manager_approval"] == "approve")?'checked':'' ?> /> Approve
                                        </td>
                                        <td> 
                                            <input type="radio" name="manager_approval" class="input-radio" value="reject" <?php echo ($row["manager_approval"] == "reject")?'checked':'' ?> /> Reject
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Approval description :
                            </div>
                            <div class="form-row-data">
                                <textarea id="approval_description" name="approval_description" rows="4" cols="40"><?php echo $row["approval_description"]; ?></textarea>
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
                    
                    <form>
                        <center>
                            <h2>Related details</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>Verified suppliers : </b>
                            </div>
                            <div class="form-row-data">
                                <?php  
                                    $material_supplier_select = "";
                                    if($result = mysqli_query($conn, $sql_material_supplier)){
                                        if(mysqli_num_rows($result) > 0){
                                            $material_supplier_select .= "<select name='view_supplier_id[]' id='view_supplier_id[]' multiple size='3' onClick='window.location.href=this.value'>";
                                            $material_supplier_select .= "<option disabled>ID - Supplier name</option>";
                                            while($material_supplier_row = mysqli_fetch_array($result)){
                                                $material_supplier_select .= "<option value=edit_supplier.php?supplier_id=".$material_supplier_row["supplier_id"].">".$material_supplier_row["supplier_id"]." - ".$material_supplier_row["first_name"]." ".$material_supplier_row["last_name"]."</option>";
                        
                                            }
                                            $material_supplier_select .= "</select>";
                                        }else {
                                            $material_supplier_select = "No suppliers available";
                                        }
                                        echo $material_supplier_select;
                                    }else{
                                        echo "ERROR: Could not able to execute $sql_material_supplier. " . mysqli_error($conn);
                                    }  
                                ?>
                                
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>Costume designs : </b>
                            </div>
                            <div class="form-row-data">
                                <?php  
                                    $material_design_select = "";
                                    if($result = mysqli_query($conn, $sql_material_design)){
                                        if(mysqli_num_rows($result) > 0){
                                            $material_design_select .= "<select name='design_id[]' id='design_id[]' multiple size='3' onClick='window.location.href=this.value'>";
                                            $material_design_select .= "<option disabled>ID - Design name</option>";
                                            while($material_design_row = mysqli_fetch_array($result)){
                                                $material_design_select .= "<option value=edit_costume_design.php?design_id=".$material_design_row["design_id"].">".$material_design_row["design_id"]." - ".$material_design_row["name"]."</option>";
                                            }
                                            $material_design_select .= "</select>";
                                        }else {
                                            $material_design_select = "No costume designs available";
                                        }
                                        echo $material_design_select;
                                    }else{
                                        echo "ERROR: Could not able to execute $sql_material_design. " . mysqli_error($conn);
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
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>Material quotations : </b>
                            </div>
                            <div class="form-row-data">
                                <?php
                                    $focused_quotation_id = array();
                                    $focused_quotation_sql = "SELECT material_price.quotation_id, COUNT(material_price.quotation_id), supplier_approval FROM raw_material_quotation, material_price WHERE supplier_approval = 'approve' AND material_price.quotation_id = raw_material_quotation.quotation_id GROUP BY material_price.quotation_id HAVING COUNT(material_price.quotation_id) = 1;";
                                    if($result = mysqli_query($conn, $focused_quotation_sql)){
                                        if(mysqli_num_rows($result) > 0){
                                            while($focused_quotation_row = mysqli_fetch_array($result)){
                                                array_push($focused_quotation_id, $focused_quotation_row["quotation_id"]);
                                            }
                                        }
                                    }
                                
                                    $material_quotation_select = "";
                                    if($result = mysqli_query($conn, $sql_material_quotation)){
                                        if(mysqli_num_rows($result) > 0){
                                            $material_quotation_select .= "<select name='quotation_id[]' id='quotation_id[]' multiple size='3' onClick='window.location.href=this.value'>";
                                            $material_quotation_select .= "<option disabled>Quote. ID - (Supplier ID-Name)Quantity-Unit price (Valid till)</option>";
                                            while($material_quotation_row = mysqli_fetch_array($result)){
                                                $material_quotation_select .= "<option value=view_material_quotation.php?quotation_id=".$material_quotation_row["quotation_id"];
                                                if(in_array($material_quotation_row["quotation_id"], $focused_quotation_id)){
                                                    $material_quotation_select .= " selected>".$material_quotation_row["quotation_id"]." - (".$material_quotation_row["supplier_id"]."-".$material_quotation_row["first_name"]." ".$material_quotation_row["last_name"].")".$material_quotation_row["request_quantity"]." ".$material_quotation_row["measuring_unit"]."-".$material_quotation_row["unit_price"]."LKR (".$material_quotation_row["valid_till"].")</option>";
                                                }else{
                                                    $material_quotation_select .= ">".$material_quotation_row["quotation_id"]." - (".$material_quotation_row["supplier_id"]."-".$material_quotation_row["first_name"]." ".$material_quotation_row["last_name"].")".$material_quotation_row["request_quantity"]." ".$material_quotation_row["measuring_unit"]."-".$material_quotation_row["unit_price"]."LKR (".$material_quotation_row["valid_till"].")</option>";
                                                } 
                                            }
                                            $material_quotation_select .= "</select>";
                                        }else {
                                            $material_quotation_select = "No quotations available";
                                        }
                                        echo $material_quotation_select;
                                    }else{
                                        echo "ERROR: Could not able to execute $sql_material_quotation. " . mysqli_error($conn);
                                    }  
                                ?>
                                
                            </div>
                        </div>
                        
                    </form>
                </div> 

                <div id="form-box-ultra-small">
                    <form method="post" name="materialQuotationForm" action="../RouteHandler.php">
                        <input type="text" hidden="true" name="framework_controller" value="raw_material_quotation/add" />
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                        <center>
                            <h2>Send raw material quotation request</h2>
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
                                Supplier ID : 
                            </div>
                            <div class="form-row-data">
                                <?php  
                                    $material_supplier_select = "";
                                    if($result = mysqli_query($conn, $sql_material_supplier)){
                                        if(mysqli_num_rows($result) > 0){
                                            $material_supplier_select .= "<select name='supplier_id[]' id='supplier_id[]' multiple size='3' required>";
                                            $material_supplier_select .= "<option disabled>ID - Supplier name</option>";
                                            while($material_supplier_row = mysqli_fetch_array($result)){
                                                $material_supplier_select .= "<option value=".$material_supplier_row["supplier_id"].">".$material_supplier_row["supplier_id"]." - ".$material_supplier_row["first_name"]." ".$material_supplier_row["last_name"]."</option>";
                        
                                            }
                                            $material_supplier_select .= "</select>";
                                        }else {
                                            $material_supplier_select = "No suppliers available";
                                        }
                                        echo $material_supplier_select;
                                    }else{
                                        echo "ERROR: Could not able to execute $sql_material_supplier. " . mysqli_error($conn);
                                    }  
                                ?>
                                <input type="text" hidden="true" name="merchandiser_id" value="<?php echo $_SESSION["employee_id"]; ?>" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quantity (In <?php echo $row["measuring_unit"]; ?>) : 
                            </div>
                            <div class="form-row-data">
                                <input type="number" name="request_quantity" id="request_quantity" min="0.001" step="0.001" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Expected delivery date :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="expected_delivery_date" id="expected_delivery_date" required />
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


                <div id="form-box-ultra-small">
                    <form method="post" name="storageLogForm" action="../RouteHandler.php" onSubmit="return validateStorageLogForm()">
                        <input type="text" hidden="true" name="framework_controller" value="storage_log/manage" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
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
                                Quotation ID :
                            </div>
                            <div class="form-row-data">
                                <select name="quotation_id" id="quotation_id">  
                                    <option disabled>Quotation ID - Maximum quantity</option>
                                    <?php
                                        $sql_quotation = "SELECT raw_material_quotation.quotation_id, request_quantity FROM raw_material_quotation, raw_material_order, material_price WHERE raw_material_quotation.quotation_id = raw_material_order.quotation_id AND raw_material_quotation.quotation_id = material_price.quotation_id AND dispatch_date IS NOT NULL AND material_id = ".$row["material_id"];
                                        $result_quotation = mysqli_query($conn, $sql_quotation);
                                        while($row_result_quotation = mysqli_fetch_array($result_quotation)){
                                            echo "<option value='".$row_result_quotation['quotation_id']."-".$row_result_quotation['request_quantity']."'>".$row_result_quotation['quotation_id']." - ".$row_result_quotation['request_quantity']." ".$row['measuring_unit']."</option>";
                                        }
                                        mysqli_close($conn);
                        
                                    ?>
                                </select>
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
                                            <input type="radio" name="store_action" class="input-radio" value="store" onChange="enableQuotationID()" /> Store
                                        </td>
                                        <td>
                                            <input type="radio" name="store_action" class="input-radio" value="retrieve" onChange="disableQuotationID()" /> Retrieve
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-submit">
                                <?php 
                                    if($row["manager_approval"] == "approve"){
                                        echo "<input type='submit' value='Save' />";
                                    }else{
                                        echo "<input type='submit' value='Save' disabled />";
                                    }
                                ?>
                            </div>        
                            <div class="form-row-reset">
                                <?php 
                                    if($row["manager_approval"] == "approve"){
                                        echo "<input type='reset' value='Cancel' />";
                                    }else{
                                        echo "<input type='reset' value='Cancel' disabled />";
                                    }    
                                ?>
                            </div>
                        </div> 
                    </form>
                </div>   
                  

            </div> 
        </div> 

        <?php include 'footer.php';?>
        <script>
            function addLeadingZeros(num, totalLength) {
                return String(num).padStart(totalLength, '0');
            }
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; 
            var yyyy = today.getFullYear();
            var min_EDD = yyyy + '-' + addLeadingZeros(mm,2) + '-' + addLeadingZeros(dd,2);
            document.getElementById("expected_delivery_date").setAttribute("min", min_EDD);
        </script>

    </body> 
</html>
