<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add supplier</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <script>
            function validateForm(){
                var first_name = document.forms["supplierForm"]["first_name"].value;
                var last_name = document.forms["supplierForm"]["last_name"].value;
                var NIC = document.forms["supplierForm"]["NIC"].value;
                var password = document.forms["supplierForm"]["password"].value;
                var confirm_password = document.forms["supplierForm"]["confirm_password"].value;
                var verify_status = document.forms["supplierForm"]["verify_status"].value;
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
                }else if (password.length < 8) {
                    alert("Password must have at least 8 characters");
                    return false;
                }else if (password != confirm_password) {
                    alert("Confirm your password correctly");
                    return false;
                }else if (verify_status == "") {
                    alert("Verify status is required");
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
                    <a href="#">Suppliers </a> > Add new suppliers
                </div>

                <div id="form-box-small">
                    <form method="post" name="supplierForm" onSubmit="return validateForm()" action="../RouteHandler.php" enctype="multipart/form-data">
                        <input type="text" hidden="true" name="framework_controller" value="supplier/add" />
                        <center>
                            <h2>Add suppliers</h2>
                        </center>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                First name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="first_name" id="first_name" value="<?php echo isset($_POST['first_name'])?$_POST['first_name']:''; ?>" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Last name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="last_name" id="last_name" value="<?php echo isset($_POST['last_name'])?$_POST['last_name']:''; ?>" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                NIC : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="NIC" id="NIC" value="<?php echo isset($_POST['NIC'])?$_POST['NIC']:''; ?>" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Email : 
                            </div>
                            <div class="form-row-data">
                                <input type="email" name="email" id="email" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Contact number : 
                            </div>
                            <div class="form-row-data">
                            <input type="tel"  id="contact_no" name="contact_no" pattern="[0-9]{2} [0-9]{3} [0-9]{3} [0-9]{3}" placeholder="94 123 456 789" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                NIC (front side) :
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="NIC_front_image" accept="image/png, image/gif, image/jpeg, image/tiff" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                NIC (rear side) :
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="NIC_rear_image" accept="image/png, image/gif, image/jpeg, image/tiff" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Business certificate :
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="business_certificate" accept="image/png, image/gif, image/jpeg, image/tiff" required />
                            </div>
                        </div> 
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                City : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="city" id="city" />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw materials : 
                            </div>
                            <div class="form-row-data">
                                <?php 
                                    require_once('../../model/DBConnection.php');
                                    $connObj = new DBConnection();
                                    $conn = $connObj->getConnection();
                                    $sql = "SELECT material_id, name FROM raw_material";
                                    if($result = mysqli_query($conn, $sql)){
                                        if(mysqli_num_rows($result) > 0){
                                            echo "<select name='material_id[]' id='material_id' multiple size='2' required>";
                                            echo "<option disabled>ID - Material name</option>";
                                            while($row = mysqli_fetch_array($result)){
                                                echo "<option value='".$row["material_id"]."'>".$row["material_id"]." - ".$row["name"]."</option>";
                                            }
                                            echo "</select>";
                                        }else {
                                            echo "0 results";
                                        }
                                    }else{
                                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                                    }
                                    mysqli_close($conn);
                                ?>
                                <!--<select name="" id="" multiple size="3" required>
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
                                            <input type="radio" name="verify_status" class="input-radio" value="approve" /> Approve
                                        </td>
                                        <td>
                                            <input type="radio" name="verify_status" class="input-radio" value="deny" /> Deny
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Password : 
                            </div>
                            <div class="form-row-data">
                                <input type="password" name="password" id="password" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Confirm password : 
                            </div>
                            <div class="form-row-data">
                                <input type="password" name="confirm_password" id="confirm_password" required />
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
