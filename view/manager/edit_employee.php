<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit employee</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <?php
            require_once '../../model/DBConnection.php';
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $employeeID = $_GET["employee_id"];
            $sql = "SELECT * FROM employee where employee_id='$employeeID'";
            $path = mysqli_query($conn, $sql);
            $result = $path->fetch_array(MYSQLI_ASSOC);
            if($result = mysqli_query($conn, $sql)){
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_array($result);
                }else {
                    echo "0 results";
                }
            }else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }
            mysqli_close($conn);
        ?>
        <script>
            function validateForm(){
                var first_name = document.forms["employeeForm"]["first_name"].value;
                var last_name = document.forms["employeeForm"]["last_name"].value;
                var NIC = document.forms["employeeForm"]["NIC"].value;
                var active_status = document.forms["employeeForm"]["active_status"].value;
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
                }else if (NIC.length == 10) {
                    if((NIC.charAt(9)=='x')||(NIC.charAt(9)=='X')||(NIC.charAt(9)=='v')||(NIC.charAt(9)=='V')){
                        var validity = 1;    
                    }else{
                        alert("NIC is invalid");
                        return false;
                    }
                }else if ((NIC.length == 12)&&(/^[0-9]+$/.test(NIC) == false)) {
                    alert("NIC is invalid");
                    return false;
                }else if (password.length<8) {
                    alert("Password must have at least 8 characters");
                    return false;
                }else if (active_status == "") {
                    alert("Active status must be filled out");
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
                    <a href="#">Employees </a> > Edit
                </div> 

                <div id="form-box-small">
                    <form method="post" name="employeeForm" action="../RouteHandler.php" onSubmit="return validateForm()">
                        <input type="text" hidden="true" name="framework_controller" value="employee/update" />
                        <center>
                            <h2>Edit employee</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Employee ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="employee_id" value="<?php echo $_GET["employee_id"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                First name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="first_name" id="first_name" value="<?php echo $row["first_name"]; ?>" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Last name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="last_name" id="last_name" value="<?php echo $row["last_name"]; ?>" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                NIC : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="NIC" id="NIC" value="<?php echo $row["NIC"]; ?>" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Email : 
                            </div>
                            <div class="form-row-data">
                                <input type="email" name="email" id="email" value="<?php echo $row["email"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Contact number : 
                            </div>
                            <div class="form-row-data">
                                <input type="tel" name="contact_no" id="contact_no" pattern="[0-9]{2} [0-9]{3} [0-9]{3} [0-9]{3}" placeholder="94 123 456 789" value="<?php echo $row["contact_no"]; ?>" required />
                            </div>
                        </div>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                User type :
                            </div>
                            <div class="form-row-data">
                                <select name="user_type">
                                    <option value="merchandiser" <?php echo ($row["user_type"]=="merchandiser")?'selected':'' ?>>Merchadiser</option>
                                    <option value="fashion designer" <?php echo ($row["user_type"]=="fashion designer")?'selected':'' ?>>Fashion designer</option>
                                </select>
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
                                <input type="date" name="DOB" value="<?php echo $row["DOB"]; ?>" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Joined date : 
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="joined_date" value="<?php echo $row["joined_date"]; ?>" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Active status :
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="active_status" class="input-radio" value="enable" <?php echo ($row["active_status"]=="enable")?'checked':'' ?> /> Enable
                                        </td>
                                        <td>
                                            <input type="radio" name="active_status" class="input-radio" value="disable" <?php echo ($row["active_status"]=="disable")?'checked':'' ?> /> Disable
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
        <script>
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; 
            var yyyy = today.getFullYear();
            var max_DOB = yyyy-18 + '-' + mm + '-' + dd;
            var max_joined_date = yyyy + '-' + mm + '-' + dd;
            document.getElementById("DOB").setAttribute("max", max_DOB);
            document.getElementById("joined_date").setAttribute("max", max_joined_date);
        </script>
    </body> 
</html>
