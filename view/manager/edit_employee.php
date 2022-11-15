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
                var name = document.forms["employeeForm"]["name"].value;
                var username = document.forms["employeeForm"]["username"].value;
                var password = document.forms["employeeForm"]["password"].value;
                var email = document.forms["employeeForm"]["email"].value;
                var contact_no = document.forms["employeeForm"]["contact_no"].value;
                var user_type = document.forms["employeeForm"]["user_type"].value;
                var address_line1 = document.forms["employeeForm"]["address_line1"].value;
                var DOB = document.forms["employeeForm"]["DOB"].value;
                var joined_date = document.forms["employeeForm"]["joined_date"].value;
                var active_status = document.forms["employeeForm"]["active_status"].value;
                if (name == "") {
                    alert("Name must be filled out");
                    return false;
                }else if (/^[a-zA-Z\s]+$/.test(name) == false) {
                    alert("Name must have only letters and spaces");
                    return false;
                }else if (username == "") {
                    alert("Username must be filled out");
                    return false;
                }else if (password == "") {
                    alert("Password must be filled out");
                    return false;
                }else if (email == "") {
                    alert("email must be filled out");
                    return false;
                }else if (contact_no == "") {
                    alert("Contact number must be filled out");
                    return false;
                }else if (user_type == "") {
                    alert("User type must be filled out");
                    return false;
                }else if (address_line1 == "") {
                    alert("Address must have at least one line");
                    return false;
                }else if (DOB == "") {
                    alert("Date of birth must be filled out");
                    return false;
                }else if (joined_date == "") {
                    alert("Joined date must be filled out");
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
                                <input type="text" name="employee_id" value="" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                First name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="name" id="name" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Last name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="name" id="name" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                NIC : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="name" id="name" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Email : 
                            </div>
                            <div class="form-row-data">
                                <input type="email" name="email" id="email" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Contact number : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="contact_no" value="" />
                            </div>
                        </div>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                User type :
                            </div>
                            <div class="form-row-data">
                                <select name="user_type">
                                    <option value="merchandiser">Merchadiser</option>
                                    <option value="fashion designer">Fashion designer</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Address line 1 : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="address_line1" value="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Address line 2 : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="address_line2" value="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Address line 3 : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="address_line3" value="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Date of birth : 
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="DOB" value="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Joined date : 
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="joined_date" value="" />
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
                                            <input type="radio" name="active_status" class="input-radio" value="enable" /> Enable
                                        </td>
                                        <td>
                                            <input type="radio" name="active_status" class="input-radio" value="disable" /> Disable
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
