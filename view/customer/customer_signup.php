<?php 
error_reporting(E_ERROR | E_PARSE); ?>
<!DOCTYPE html>
<head>
    <title>Signup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
    <script>
            function validateForm(){
                var first_name = document.forms["customerForm"]["first_name"].value;
                var last_name = document.forms["customerForm"]["last_name"].value;
                var email = document.forms["customerForm"]["email"].value;
                var NIC = document.forms["customerForm"]["NIC"].value;
                var password = document.forms["customerForm"]["password"].value;
                var confirm_password = document.forms["customerForm"]["confirm_password"].value;

                if (/^[a-zA-Z\s]+$/.test(first_name) == false) {
                    alert("First name must have only letters and spaces");
                    return false;
                }else if (/^[a-zA-Z\s]+$/.test(last_name) == false) {
                    alert("Last name must have only letters and spaces");
                    return false;
                }else if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)==false){
                    alert("You have entered an invalid email address!");
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
                }else if (password.length < 8) {
                    alert("Password must have at least 8 characters");
                    return false;
                }else if (password != confirm_password) {
                    alert("Confirm your password correctly");
                    return false;
                }else{
                    return true;
                }
            }
            
    </script>           
</head>
<body style="background-image: url('../image/login.png'); 
min-height:100%;
background-size: cover;
background-position: center; 
background-repeat: no-repeat; 
background-attachment: fixed;
margin: 0;
padding: 0;">
<button type="button" onclick="goback()" class="back">Go Back</button>

<form method="post"  class="signup" name="customerForm" onSubmit="return validateForm()" action="../RouteHandler.php">
    <input type="text" hidden="true" name="framework_controller" value="customer/sign_up" />

    <center><div class="loginlogo"><img src="../Icon/logo-login.png" width="130px"/></div>
    <h4>Customer Signup</h4></center>


   
    <label for="name"><b>First Name</b><span>*</span></label>
    <input type="text" placeholder="Enter first Name" name="first_name" required>

    <label for="lastname"><b>Last Name</b> <span>*<span></label>
    <input type="text" placeholder="Enter last Name" name="last_name" required>

    <label for="nic"><b>NIC</b> <span>*<span></label>
    <input type="text" placeholder="Enter your NIC" name="NIC" required>
    

    <label for="email"><b>Email</b><span>*</span></label>
    <input type="email" placeholder="name@gmail.com" name="email" required>

    <label for="contact"><b>Contact Number</b><span>*<span></label>
    <input type="tel" placeholder="071 1234567" name="contact_no" pattern="[0-9]{3} [0-9]{7}" required />

    <label for="city"><b>City</b><span>*<span></label>
    <input type="text" placeholder="Enter City" name="city" required>

    <label for="psw"><b>Password</b><span>*<span></label>
    <input type="password" placeholder="Enter Password" name="password" required>

    <label for="psw"><b>Confirm Password</b><span>*<span></label>
    <input type="password" placeholder="Enter Confirm Password" name="confirm_password" required>

    <br />
    <br />
    <button type="submit" class="btn">Signup</button>


  </form>
  <script>
    function goback(){
        window.location.href = "../../index.php";

    }
 </script>

</body>
</html>