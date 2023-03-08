<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit self profile</title>
        <link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
        <?php
            $employeeID = $_SESSION["supplier_id"];
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
            <?php include 'leftnav.php';
            require_once('../../model/DBConnection.php');?>
            <div id="page-content">
                <div id="breadcrumb">
                    <a href="index.php">Welcome </a> >
                    <a href="login.php">Login </a> >
                    <a href="home.php">Supplier </a> > Edit self profile
                </div> 

                <div id="form-box-small">
                    <form method="post" name="supplierForm" action="../RouteHandler.php" onSubmit="return validateEditProfileForm()" enctype="multipart/form-data">
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
                                <input type="text" name="first_name" id="first_name" value ="<?php echo $row["first_name"];?>" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Last name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="last_name" id="last_name" value ="<?php echo $row["last_name"];?>" />
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
                                <input type="text" name="contact_no" id="contact_no" value ="<?php echo $row["contact_no"];?>" />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                City : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="city" id="city" value ="<?php echo $row["city"];?>"/>
                                <input type="text" hidden="true" name="verify_status" id="verify_status" value ="<?php echo $row["verify_status"];?>"/>
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
