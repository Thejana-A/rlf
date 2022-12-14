<?php
    error_reporting(E_ERROR | E_PARSE);
?>
<html>
<head>
<title>Sign up</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/fashion_designer/signup_page.css" />
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
	<form name="employeeForm" id="employeeForm" onSubmit="return validateForm()" method="post" action="../RouteHandler.php">
        <input type="text" hidden="true" name="framework_controller" value="employee/sign_up" />
	<section id="image1">
		<img src="../icons/login_logo.png"class="logo" href="#">
	<div id="signupbox">
	<img src="../icons/avatar.png" class="avatar">
	<h1>Sign up</h1>
	<form>
        <p>First Name</p>
			<input type="text" name="first_name" id="first_name" placeholder="Enter First Name" required>
		<p>Last Name</p>
			<input type="text" name="last_name" id="last_name" placeholder="Enter Last Name" required>
        <p>NIC</p>
			<input type="text" name="NIC" id="NIC" placeholder="Enter NIC" required>
        <p>Email</p>
			<input type="email" name="email" id="email" placeholder="Enter Email" required>
        <p>Password</p>
			<input type="password" name="password" id="password" placeholder="Enter Password" required>
        <p>Confirm Password</p>
			<input type="password" name="confirm_password" id="confirm_password" placeholder="Enter Password" required>
        <p>Contact Number</p>
			<input type="tel" name="contact_no" id="contact_no" pattern="[0-9]{2} [0-9]{3} [0-9]{3} [0-9]{3}" placeholder="94 123 456 789" required>
        <p>User Type</p>
        <div class="selection">
			<select>
                <option disabled value="" selected>Select User Type</option>
                <option>Fashion Designer</option>
                <option>Merchandiser</option>
            </select>
        </div>
        <p>Address Line 1</p>
			<input type="Text" name="address_line1" id="address_line1" placeholder="Line 1" required>
        <p>Address Line 2</p>
			<input type="Text" name="address_line2" id="address_line2" placeholder="Line 2" required>
        <p>Address Line 3</p>
			<input type="Text" name="address_line3" id="address_line3" placeholder="Line 3" required>
        <div class="data-box">
        <p>Date of Birth</p>
			<input type="Date" name="DOB" id="DOB" placeholder="dd/mm/yyyy" required>
        </div>
        <div class="data-box">
        <p>Joined Date</p>
			<input type="Date" name="joined_date" id="joined_date" placeholder="dd/mm/yyyy" required><br><br>
        </div>

            
		<input type="submit" name="" value="Sign up">
        <input type="reset" name="" value="Cancel"><br>
		<a href="./login.php">Login here</a>
				</form>
			</div>
    	</section>
	</form>
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