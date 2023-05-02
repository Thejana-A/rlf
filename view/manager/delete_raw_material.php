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
                //parse_str($_SERVER['REQUEST_URI'],$row);
                $row = $_SESSION["row"];
                //print_r($row);
            }

            $materialID = $row["material_id"];
            //$conn = new mysqli("localhost", "root", "", "rlf");
            require_once('../../model/database.php');
            $conn = mysqli_connect($db_params['servername'], $db_params['username'], $db_params['password'], $db_params['dbname']);
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }
            
            $sql_material_supplier = "SELECT supplier.supplier_id , supplier.first_name, supplier.last_name FROM `supplier` INNER JOIN `material_supplier` ON material_supplier.supplier_id = supplier.supplier_id WHERE material_supplier.material_id = '$materialID' AND `verify_status` = 'approve';";
            $sql_material_design = "SELECT costume_design.design_id, name FROM `costume_design` INNER JOIN `design_material` ON design_material.design_id = costume_design.design_id WHERE design_material.material_id = '$materialID';";
            //$sql_all_design = "SELECT design_id, name FROM `costume_design`";

            date_default_timezone_set("Asia/Colombo");
        ?>

        <script>
            function confirmDeletion(){
                var confirmation = confirm("Are you sure ?");
                if (confirmation==true) {
                    return true;
                }else{
                    return false;
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
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="home.php">Manager</a> >
                    <a href="raw_materials.php">View raw materials </a> > Delete
                </div>

                <div id="form-box-ultra-small">
                    <form method="post" onSubmit="return confirmDeletion()" action="../RouteHandler.php">
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
                                <input type="text" name="name" id="name" value="<?php echo $row["name"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                                <select name="size" id="size" disabled>
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
                                <select name="measuring_unit" id="measuring_unit" disabled>
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
                        <!--<div class="form-row">
                            <div class="form-row-theme">
                                Update image : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="image" id="image" accept="image/png, image/gif, image/jpeg, image/tiff" />
                            </div>
                        </div> -->
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quantity in stock : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="quantity_in_stock" value="<?php echo $row["quantity_in_stock"]; ?>" readonly />
                            </div>
                        </div>
                        <?php
                            if($row["requester_id"] != ""){
                                echo "<div class='form-row'>";
                                echo "<div class='form-row-theme'>";
                                echo "Requester's ID : ";
                                echo "</div>";
                                echo "<div class='form-row-data'>";
                                echo "<input type='text' name='requester_id' id='requester_id' value='".$row["requester_id"]."' readonly />";
                                echo "</div>";
                                echo "</div>";
                                echo "<div class='form-row'>";
                                echo "<div class='form-row-theme'>";
                                echo "Requester's name : ";
                                echo "</div>";
                                echo "<div class='form-row-data'>";
                                echo "<input type='text' name='requester_name' id='requester_name' value='".$row["first_name"]." ".$row["last_name"]."' readonly />";
                                echo "</div>";
                                echo "</div>";
                                echo "<div class='form-row'>";
                                echo "<div class='form-row-theme'>";
                                echo "Requester's role : ";
                                echo "</div>";
                                echo "<div class='form-row-data'>";
                                echo "<input type='text' name='requester_role' id='requester_role' value='".$row["requester_role"]."' readonly />";
                                echo "</div>";
                                echo "</div>";
                            }
                        ?>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Approval status :
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="manager_approval" class="input-radio" value="approve" <?php echo ($row["manager_approval"] == "approve")?'checked':'disabled' ?> /> Approve
                                        </td>
                                        <td> 
                                            <input type="radio" name="manager_approval" class="input-radio" value="reject" <?php echo ($row["manager_approval"] == "reject")?'checked':'disabled' ?> /> Reject
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
                                <textarea id="approval_description" name="approval_description" rows="4" cols="40" readonly><?php echo $row["approval_description"]; ?></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-center-button">
                                <input type="submit" value="Delete" />
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
                                    /*$material_supplier_id = array();
                                    if($result = mysqli_query($conn, $sql_material_supplier)){
                                        if(mysqli_num_rows($result) > 0){
                                            while($material_supplier_row = mysqli_fetch_array($result)){
                                                array_push($material_supplier_id, $material_supplier_row["supplier_id"]);
                                            }
                                        }
                                    } */
                                    $supplier_select = "";
                                    if($result = mysqli_query($conn, $sql_material_supplier)){
                                        if(mysqli_num_rows($result) > 0){
                                            $supplier_select .= "<select name='supplier_id[]' id='supplier_id[]' multiple size='3' onClick='window.location.href=this.value'>";
                                            $supplier_select .= "<option disabled>ID - Supplier name</option>";
                                            while($supplier_row = mysqli_fetch_array($result)){
                                                $supplier_select .= "<option value=edit_supplier.php?supplier_id=".$supplier_row["supplier_id"].">".$supplier_row["supplier_id"]." - ".$supplier_row["first_name"]." ".$supplier_row["last_name"]."</option>";
                                            }
                                            $supplier_select .= "</select>";
                                        }else {
                                            $supplier_select = "No suppliers available";
                                        }
                                        echo $supplier_select;
                                    }else{
                                        echo "ERROR: Could not able to execute $sql_supplier. " . mysqli_error($conn);
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
                                    /*$material_design_id = array();
                                    if($result = mysqli_query($conn, $sql_material_design)){
                                        if(mysqli_num_rows($result) > 0){
                                            while($material_design_row = mysqli_fetch_array($result)){
                                                array_push($material_design_id, $material_design_row["design_id"]);
                                            }
                                        }
                                    } */
                                    $design_select = "";
                                    if($result = mysqli_query($conn, $sql_material_design)){
                                        if(mysqli_num_rows($result) > 0){
                                            $design_select .= "<select name='design_id[]' id='design_id[]' multiple size='3' onClick='window.location.href=this.value'>";
                                            $design_select .= "<option disabled>ID - Design name</option>";
                                            while($design_row = mysqli_fetch_array($result)){
                                                $design_select .= "<option value=edit_costume_design.php?design_id=".$design_row["design_id"].">".$design_row["design_id"]." - ".$design_row["name"]."</option>";
                                            }
                                            $design_select .= "</select>";
                                        }else {
                                            $design_select = "No costume designs available";
                                        }
                                        echo $design_select;
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
                        
                    </form>
                </div> 
                  

            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
