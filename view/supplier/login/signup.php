
<!DOCTYPE html>
<head>
	<title>Signup</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel = "stylesheet" href="../css/login.css">
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
<body>
<div class="form-container">
	
			<form method="post" class="signup" name="supplierForm"  onSubmit="return validateForm()" action="../../RouteHandler.php" enctype ="multipart/form-data">
            <input type="text" hidden="true" name="framework_controller" value="supplier/sign_up" />
			<center><h1>Signup</h1></center>
			
				<label for="first_name">First Name</label>
				<input type="text" name="first_name" placeholder="Enter First Name" required>
			
				<label for="last_name">Last Name</label>
				<input type="text" name="last_name" placeholder="Enter Last Name" required>
			
				<label for="NIC">NIC</label>
				<input type="text" name="NIC" placeholder="Enter your NIC" required>
			
				<label for="email">Email</label>
				<input type="email" name="email" placeholder="name@gmail.com" required>
			
				<label for="contact_no">Contact Number</label>
				<input type="tel" name="contact_no"  pattern="[0-9]{2} [0-9]{3} [0-9]{3} [0-9]{3}" placeholder="94 123 456 789" required />
			
				<label for="city">City</label>
				<input type="text" name="city" placeholder="Enter City" required>
			
				<label for="NIC_front_image">NIC Front Image</label>
                <input type="file" name="NIC_front_image"  accept="image/png, image/gif, image/jpeg, image/tiff" required>
            
				<label for="NIC_rear_image">NIC Front Image</label>
                <input type="file" name="NIC_rear_image"  accept="image/png, image/gif, image/jpeg, image/tiff" required>
            
				<label for="business_certificate">Business Certificate</label>
                <input type="file" name="business_certificate"  accept="image/png, image/gif, image/jpeg, image/tiff" required>
            
				<label for="material_id">Raw materials</label>
				<?php 
					$conn = new mysqli("localhost", "root", "", "rlf");
					if($conn->connect_error){
						die("Connection Failed: ". $conn->connect_error);
					}
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
            
				<label for="password">Password</label>
				<input type="password" name="password" placeholder="Enter Password" required>
			
				<label for="confirm_password">Confirm Password</label>
				<input type="password" name="confirm_password" placeholder="Enter Confirm Password" required>
				
			
				<input type="submit" value="Signup">
				<p>Have an account already? <a href = "login.php">Log in</a></p>
			</form>
</body>
</html>