<?php
    error_reporting(E_ERROR | E_PARSE);
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign up</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/login_page.css" />
        <script>
            function validateForm(){
                var first_name = document.forms["employeeForm"]["first_name"].value;
                var last_name = document.forms["employeeForm"]["last_name"].value;
                var NIC = document.forms["employeeForm"]["NIC"].value;
                var password = document.forms["employeeForm"]["password"].value;
                var confirm_password = document.forms["employeeForm"]["confirm_password"].value;
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
                }
                else if (password != confirm_password) {
                    alert("Confirm your password correctly");
                    return false;
                }else{
                    return true;
                }
            }
            
        </script>
    </head>

    <body style="background-image: url('../icons/login_bg.jpeg');">
        <center>
        <div id="signup-box">
            <form name="employeeForm" id="employeeForm" onSubmit="return validateForm()" method="post" action="../RouteHandler.php">
                <input type="text" hidden="true" name="framework_controller" value="employee/sign_up" />
                <table>
                    <tr>
                        <td>
                            <center>
                                <img src="../icons/login_logo.png" />
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                                <h2>Sign up</h2>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            First name : <br />
                            <input type="text" name="first_name" id="first_name" required />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            Last name : <br />
                            <input type="text" name="last_name" id="last_name" required />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            NIC : <br />
                            <input type="text" name="NIC" id="NIC" required />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            Email : <br />
                            <input type="email" name="email" id="email" required />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            Password : <br />
                            <input type="password" name="password" id="password" required />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            Confirm password : <br />
                            <input type="password" name="confirm_password" id="confirm_password" required />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            Contact number : <br />
                            <input type="tel" name="contact_no" id="contact_no" pattern="[0-9]{2} [0-9]{3} [0-9]{3} [0-9]{3}" placeholder="94 123 456 789" required />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            User type : <br />
                            <select name="user_type" id="user_type" required>
                                <option disabled value="" selected>Select user type</option>
                                <option value="fashion designer">Fashion designer</option>
                                <option value="merchandiser">Merchandiser</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            Address line 1 : <br />
                            <input type="text" name="address_line1" id="address_line1" required />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            Address line 2 : <br />
                            <input type="text" name="address_line2" id="address_line2" />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            Address line 3 : <br />
                            <input type="text" name="address_line3" id="address_line3" />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            Date of birth : <br />
                            <input type="date" name="DOB" id="DOB" required />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            Joined date : <br />
                            <input type="date" name="joined_date" id="joined_date" required />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                                <input type="submit" value="Save" class="login-button" />
                            <center>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                                <input type="reset" value="Cancel" class="login-button" />
                            <center>
                        </td>
                    </tr>
                </table>
            </form>
        </div>  
        </center>
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