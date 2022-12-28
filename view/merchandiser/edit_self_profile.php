<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit self profile</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <?php
            $employeeID = $_SESSION["employee_id"];
            $conn = new mysqli("localhost", "root", "", "rlf");
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }
            $sql = "SELECT * FROM employee WHERE employee_id = '$employeeID';";
                             
            if($result = mysqli_query($conn, $sql)){
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_array($result);
                }
            }
        ?>
        <script>
            function validateEditProfileForm(){
                var first_name = document.forms["employeeForm"]["first_name"].value;
                var last_name = document.forms["employeeForm"]["last_name"].value;
                var NIC = document.forms["employeeForm"]["NIC"].value;
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
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Merchandiser </a> > Edit self profile
                </div> 

                <div id="form-box-small">
                    <form method="post" name="employeeForm" action="../RouteHandler.php" onSubmit="return validateEditProfileForm()">
                        <input type="text" hidden="true" name="framework_controller" value="employee/update" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/merchandiser/home.php" />
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <center>
                            <h2>Edit self profile</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Employee ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="employee_id" id="employee_id" value="<?php echo $employeeID; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                First name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="first_name" value="<?php echo $row["first_name"]; ?>" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Last name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="last_name" value="<?php echo $row["last_name"]; ?>" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                NIC : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="NIC" value="<?php echo $row["NIC"]; ?>" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Email : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="email" id="email" value="<?php echo $row["email"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Contact no : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="contact_no" value="<?php echo $row["contact_no"]; ?>" required />
                            </div>
                        </div>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                User type :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="user_type" value="<?php echo $row["user_type"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Address line 1 :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="address_line1" value="<?php echo $row["address_line1"]; ?>" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Address line 2 :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="address_line2" value="<?php echo $row["address_line2"]; ?>" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Address line 3 :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="address_line3" value="<?php echo $row["address_line3"]; ?>" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Date of birth : 
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="DOB" id="DOB" value="<?php echo $row["DOB"]; ?>" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Joined date : 
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="joined_date" id="joined_date" value="<?php echo $row["joined_date"]; ?>" required />
                                <input type="text" hidden="true" name="active_status" value="<?php echo $row["active_status"]; ?>" />
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
                        <input type="text" hidden="true" name="framework_controller" value="employee/reset_password" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/merchandiser/home.php" />
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
                                <input type="text" hidden="true" name="employee_id" value="<?php echo $_SESSION["employee_id"]; ?>" />
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
        <script>
            function addLeadingZeros(num, totalLength) {
                return String(num).padStart(totalLength, '0');
            }
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; 
            var yyyy = today.getFullYear();
            var max_DOB = yyyy-18 + '-' + addLeadingZeros(mm,2) + '-' + addLeadingZeros(dd,2);
            var max_joined_date = yyyy + '-' + addLeadingZeros(mm,2) + '-' + addLeadingZeros(dd,2);
            document.getElementById("DOB").setAttribute("max", max_DOB);
        </script>
    </body> 
</html>
