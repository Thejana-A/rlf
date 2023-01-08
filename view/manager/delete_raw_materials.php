<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Delete raw material</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <?php 
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            if(isset($_GET['data'])){ 
                parse_str($_SERVER['REQUEST_URI'],$row);
                //print_r($row);
            }

            $materialID = $row["material_id"];
            $conn = new mysqli("localhost", "root", "", "rlf");
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }
            $sql_material_supplier = "SELECT supplier.supplier_id , supplier.first_name, supplier.last_name FROM `supplier` INNER JOIN `material_supplier` ON material_supplier.supplier_id = supplier.supplier_id WHERE material_supplier.material_id = '$materialID' AND `verify_status` = 'approve';";
            $sql_all_supplier = "SELECT supplier_id, first_name, last_name FROM `supplier` where `verify_status` = 'approve';";
            $sql_material_design = "SELECT costume_design.design_id, name FROM `costume_design` INNER JOIN `design_material` ON design_material.design_id = costume_design.design_id WHERE design_material.material_id = '$materialID';";
            $sql_all_design = "SELECT design_id, name FROM `costume_design`";

            date_default_timezone_set("Asia/Colombo");
        ?>
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
                    <a href="#">View raw materials </a> > Delete
                </div>

                <div id="form-box-ultra-small">
                    <form method="post" action="../RouteHandler.php">
                        <input type="text" hidden="true" name="framework_controller" value="raw_material/delete">
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                        <center>
                            <h2>Delete raw material</h2>
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
                            <div class="form-row-center-button">
                                <input type="submit" value="Delete" />
                            </div>
                        </div> 

                        <center>
                            <h2>Related details</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>Verified suppliers : </b>
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
                                                $all_supplier_select .= "<option value=edit_supplier.php?supplier_id=".$all_supplier_row["supplier_id"];
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
                                <b>Costume designs : </b>
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
                                            $all_design_select = "0 results";
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
                  

            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
