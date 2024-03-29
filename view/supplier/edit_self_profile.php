<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit self profile</title>
        <link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
        <?php
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            
            $conn = new mysqli("localhost", "root", "", "rlf");
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }
            $sql = "SELECT * FROM supplier WHERE supplier_id = '$supplierID';";
                             
            if($result = mysqli_query($conn, $sql)){
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_array($result);
                }
            }
            $supplierID = $_SESSION["supplier_id"];
            $sql_supplier_material = "SELECT material_supplier.material_id, raw_material.name, raw_material.size, raw_material.measuring_unit FROM `material_supplier` INNER JOIN `raw_material` ON material_supplier.material_id=raw_material.material_id WHERE material_supplier.supplier_id = '$supplierID';";
            $sql_all_material = "SELECT material_id, name, measuring_unit FROM `raw_material` where `manager_approval` = 'approve'";
        ?>
        <script>
            function validateEditProfileForm(){
                var first_name = document.forms["supplierForm"]["first_name"].value;
                var last_name = document.forms["supplierForm"]["last_name"].value;
                var NIC = document.forms["supplierForm"]["NIC"].value;
                const date = new Date();
                if (/^[a-zA-Z\s]+$/.test(first_name) == false) {
                    alert("First name must have only letters and spaces");
                    return false;
                }else if (/^[a-zA-Z\s]+$/.test(last_name) == false) {
                    alert("Last name must have only letters and spaces");
                    return false;
                }else if ((NIC.length != 10)&&(NIC.length != 12)) {
                    alert("NIC is invalid");
                    return false;
                }else if ((NIC.length == 10)&&(/^[0-9]+$/.test(NIC.slice(0,9)) == false)) {
                    alert("NIC is invalid");
                    return false;
                }else if ((NIC.length == 10)&&((NIC.charAt(9)!='x')&&(NIC.charAt(9)!='X')&&(NIC.charAt(9)!='v')&&(NIC.charAt(9)!='V'))) {
                    alert("NIC is invalid");
                    return false;
                }else if ((NIC.length == 12)&&(/^[0-9]+$/.test(NIC) == false)) {
                    alert("NIC is invalid");
                    return false;
                }else{
                    return true;
                }
            }

            function validateResetPassword(){
                var newPassword = document.forms["resetPasswordForm"]["new_password"].value;
                var confirmPassword = document.forms["resetPasswordForm"]["confirm_password"].value;
                if(newPassword.length < 8){
                    alert("New password should have at least 8 characters");
                    return false;
                }else if(newPassword != confirmPassword){
                    alert("Confirm new password correctly");
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
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="profile.php">Supplier </a> > Edit self profile
                </div> 

                <div id="form-box-small">
                    <form method="post" name="supplierForm" onSubmit="return validateEditProfileForm()" action="../RouteHandler.php" enctype="multipart/form-data">
                    <input type="text" hidden="true" name="framework_controller" value="supplier/edit_self_profile" />
                    <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/supplier/profile.php" />
                    <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />    
                        <center>
                            <h2>Edit profile</h2>
                        </center>
                        <?php 
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            if(isset($_SESSION['supplier_id'])){
                                $supplier_id = $_SESSION['supplier_id'];
                                $sql = "SELECT supplier_id, first_name,last_name, NIC, password, email, contact_no,city, verify_status FROM supplier WHERE supplier_ID = '$supplier_id' ";
                                $result = mysqli_query($conn, $sql);
                           
                                if(mysqli_num_rows($result) > 0)
                                {
                                    $row = $result->fetch_assoc();
                                    //print_r($row);
                                }else{
                                    echo "No result";
                                }
                            }else{
                                echo "No supplier result";
                            }
                        ?>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Supplier ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="supplier_id" id="supplier_id" value ="<?php echo $row["supplier_id"];?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                First name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="first_name" id="first_name" value ="<?php echo $row["first_name"];?>" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Last name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="last_name" id="last_name" value ="<?php echo $row["last_name"];?>" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                NIC : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="NIC" id="NIC" value ="<?php echo $row["NIC"];?>" readonly />
                            </div>
                        </div>
                                            
                        <div class="form-row">
                            <div class="form-row-theme">
                                Email :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="email" id="email" value ="<?php echo $row["email"];?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Contact no : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="contact_no" id="contact_no" value ="<?php echo $row["contact_no"];?>" required />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                City : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="city" id="city" value ="<?php echo $row["city"];?>" required/>
                                <input type="text" hidden="true" name="verify_status" id="verify_status" value ="<?php echo $row["verify_status"];?>" />
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
                                            $all_material_select .= "<select name='material_id[]' id='material_id[]' multiple size='4' >";
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
                
                <div id="form-box-small">
                <form method="post" name="resetPasswordForm" action="../RouteHandler.php" onSubmit="return validateResetPassword()">
                        <input type="text" hidden="true" name="framework_controller" value="supplier/reset_password" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/supplier/profile.php" />
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <center>
                            <h2>Reset password</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Current password : 
                            </div>
                            <div class="form-row-data">
                                <input type="password" name="password" />
                                <input type="text" hidden="true" name="supplier_id" value="<?php echo $_SESSION["supplier_id"]; ?>" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                New password : 
                            </div>
                            <div class="form-row-data">
                                <input type="password" name="new_password" id="new_password" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Confirm password : 
                            </div>
                            <div class="form-row-data">
                                <input type="password" name="confirm_password" id="confirm_password" required/>
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
