
<!DOCTYPE html>
<head>
	<title>Signup</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	    <link rel="stylesheet" type="text/css" href="../css/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/view_list_style.css" />
        
	    <link rel = "stylesheet" href="login.css">
	<script>
            function validateForm(){
                var first_name = document.forms["supplierForm"]["first_name"].value;
                var last_name = document.forms["supplierForm"]["last_name"].value;
                var email = document.forms["supplierForm"]["email"].value;
                var NIC = document.forms["supplierForm"]["NIC"].value;
                var password = document.forms["supplierForm"]["password"].value;
                var confirm_password = document.forms["supplierForm"]["confirm_password"].value;

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
                }else if (password.length <8) {
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
<body style="background-image: url('../../icons/login_bg.jpeg');">
<button type="button" onclick="goback()" class="back">Go Back</button>
<center>
        <div id="signup-box">
	
			<form method="post" class="signup" name="supplierForm"  onSubmit="return validateForm()" action="../../RouteHandler.php" enctype ="multipart/form-data">
            <input type="text" hidden="true" name="framework_controller" value="supplier/sign_up" />
			<input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
			
			
			<table>
                    <tr>
                        <td>
                            <center>
                                <img src="../../icons/login_logo.png" />
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                                <h2>Supplier Signup</h2>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            <b>First name : </b> <br />
                            <input type="text" name="first_name" id="first_name" placeholder ="Enter first name" required />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            <b>Last name : </b> <br />
                            <input type="text" name="last_name" id="last_name"  placeholder ="Enter last name" required />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            <b>NIC : </b> <br />
                            <input type="text" name="NIC" id="NIC" placeholder ="Enter your NIC" required />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            <b>Email : </b> <br />
                            <input type="email" name="email" id="email" placeholder ="name@gmail.com" required />
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="data-box">
                            <b>Contact number : </b> <br />
                            <input type="tel" name="contact_no" id="contact_no" pattern="[0-9]{2} [0-9]{3} [0-9]{3} [0-9]{3}" placeholder="94 123 456 789" required />
                        </td>
                    </tr>
					<tr>
                        <td class="data-box">
                            <b>City : </b> <br />
                            <input type="text" name="city" id="city" placeholder ="Enter city" required />
                        </td>
                    </tr>
					<tr>
                        <td class="data-box">
							<b>NIC Front Image : </b> <br />
                            <input type="file" name="NIC_front_image" id="NIC_front_image" accept="image/png, image/gif, image/jpeg, image/tiff" required>
                        </td>
                    </tr>
					<tr>
                        <td class="data-box">
							<b>NIC Rear Image : </b> <br />
                            <input type="file" name="NIC_rear_image" id="NIC_rear_image" accept="image/png, image/gif, image/jpeg, image/tiff" required>
                        </td>
                    </tr>
					<tr>
                        <td class="data-box">
							<b>Business Certificate : </b> <br />
                            <input type="file" name="business_certificate" id="business_certificate" accept="image/png, image/gif, image/jpeg, image/tiff" required>
                        </td>
                    </tr>
					<tr>
                        <td class="data-box">
							<b>Raw materials : </b> <br />
                            <?php 
					$conn = new mysqli("localhost", "root", "", "rlf");
					if($conn->connect_error){
						die("Connection Failed: ". $conn->connect_error);
					}
					$sql = "SELECT material_id, name FROM raw_material WHERE manager_approval = 'approve'";
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
                        </td>
                    </tr>
			
				
              <tr>
                        <td class="data-box">
                            <b>Password : </b> <br />
                            <input type="password" name="password" id="password" placeholder ="Enter password" required />
                        </td>
                    </tr>
                    <tr>
                        <td class="data-box">
                            <b>Confirm password : </b> <br />
                            <input type="password" name="confirm_password" id="confirm_password" placeholder ="Enter confirm password" required />
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
                            <p>Have an account already? <a href = "login.php">Log in</a></p>
                        </td>
                    </tr>
                    
                </table>
            </form>
        </div>  
        </center>
    <script>
    function goback(){
        window.location.href = "../../../index.php";

    }
    </script>
</body>
</html>