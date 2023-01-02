<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Delete supplier</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <?php 
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            if(isset($_GET['data'])){ 
                parse_str($_SERVER['REQUEST_URI'],$row);
                //print_r($row);
            }

            $supplierID = $row["supplier_id"];
            $conn = new mysqli("localhost", "root", "", "rlf");
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }
            $sql_supplier_material = "SELECT material_supplier.material_id, raw_material.name, raw_material.size, raw_material.measuring_unit FROM `material_supplier` INNER JOIN `raw_material` ON material_supplier.material_id=raw_material.material_id WHERE material_supplier.supplier_id = '$supplierID';";
            $sql_all_material = "SELECT material_id, name, measuring_unit FROM `raw_material` where `manager_approval` = 'approve'";
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
                    <a href="#">Suppliers </a> > Delete
                </div>

                <div id="form-box-small">
                    <form method="post" action="">
                    <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                        <center>
                            <h2>Delete suppliers</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Supplier ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="supplier_id" id="supplier_id" value="<?php echo $row["supplier_id"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                First name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="first_name" id="first_name" value="<?php echo $row["first_name"] ?>" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Last name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="last_name" id="last_name" value="<?php echo $row["last_name"] ?>" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                NIC : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="NIC" id="NIC" value="<?php echo $row["NIC"] ?>" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Email : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="email" id="email" value="<?php echo $row["email"] ?>" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Contact number : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="contact_no" id="contact_no" value="<?php echo $row["contact_no"] ?>" />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                NIC :
                            </div>
                            <div class="form-row-data">
                                <img src="../NIC-front-image/<?php echo $row["NIC_front_image"]; ?>" class="material-image" />
                                <img src="../NIC-rear-image/<?php echo $row["NIC_rear_image"]; ?>" class="material-image" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Business certificate :
                            </div>
                            <div class="form-row-data">
                                <img src="../business-certificate/<?php echo $row["business_certificate"]; ?>" class="material-image" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                City : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="city" id="city" value="<?php echo $row["city"]; ?>" />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw materials : 
                            </div>
                            <div class="form-row-data">
                                <?php  
                                    $supplier_material_id = array();
                                    if($result = mysqli_query($conn, $sql_supplier_material)){
                                        if(mysqli_num_rows($result) > 0){
                                            while($supplier_material_row = mysqli_fetch_array($result)){
                                                array_push($supplier_material_id, $supplier_material_row["material_id"]);
                                            }
                                        }
                                    }
                                    $all_material_select = "";
                                    if($result = mysqli_query($conn, $sql_all_material)){
                                        if(mysqli_num_rows($result) > 0){
                                            $all_material_select .= "<select name='material_id[]' id='material_id[]' multiple size='2' required>";
                                            $all_material_select .= "<option disabled>ID - Material name</option>";
                                            while($all_material_row = mysqli_fetch_array($result)){
                                                $all_material_select .= "<option value=".$all_material_row["material_id"];
                                                if(in_array($all_material_row["material_id"], $supplier_material_id)){
                                                    $all_material_select .= " selected>".$all_material_row["material_id"]." - ".$all_material_row["name"]." - (".$all_material_row["measuring_unit"].")</option>";
                                                }else{
                                                    $all_material_select .= ">".$all_material_row["material_id"]." - ".$all_material_row["name"]." - ".$all_material_row["measuring_unit"]."</option>";
                                                }
                                            }
                                            $all_material_select .= "</select>";
                                        }else {
                                            $all_material_select = "0 results";
                                        }
                                        echo $all_material_select;
                                    }else{
                                        echo "ERROR: Could not able to execute $sql_all_material. " . mysqli_error($conn);
                                    }  
                                ?>
                                <!--<select name="" id="" multiple size="3">
                                    <option disabled>ID - Material name</option>
                                    <option>0004 - Black Thread-S</option>
                                    <option>0014 - Blue Thread-S</option>
                                    <option>0022 - Red anchor button-L</option>
                                </select> -->
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Verify :
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="verify_status" value="approve" class="input-radio" <?php echo ($row["verify_status"]=="approve")?'checked':'' ?> /> Approve
                                        </td>
                                        <td>
                                            <input type="radio" name="verify_status" value="deny" class="input-radio" <?php echo ($row["verify_status"]=="deny")?'checked':'' ?> /> Deny
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-center-button">
                                <input type="submit" value="Delete" />
                            </div>
                        </div> 
                        
                    </form>
                </div> 

            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
