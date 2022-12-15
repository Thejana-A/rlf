<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    require_once(__DIR__.'/MaterialSupplier.php');
    require_once(__DIR__.'/send_email/SendMail.php');
    require_once(__DIR__.'/IDBModel.php');
    class Supplier implements IDBModel{
        
        private $supplierID;
        private $firstName;
        private $lastName;
        private $NIC;
        private $email;
        private $password;
        private $contactNo;
        private $city;
        private $verifyStatus;
         
        function __construct($args) {
            $this->firstName = $args["first_name"];
            $this->lastName = $args["last_name"];
            $this->NIC = $args["NIC"];
            $this->email = $args["email"];
            $this->password = $args["password"];
            $this->contactNo = $args["contact_no"];
            $this->city = $args["city"]; 
            $this->verifyStatus = $args["verify_status"];     
            $this->emailOTP = $args["email_otp"];    
        }

        public function add(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $OTP = rand(1000,9999);
            $message = "Click <a href='http://localhost/rlf/view/supplier/verify_email.php?email=".$this->email."'>here</a> for email verification.";
            $sendMail = new SendMail($this->firstName, $this->lastName, $this->email, $OTP, $message); 
            $sendMail->sendTheEmail();
            $sql = "INSERT INTO supplier (first_name, last_name, NIC , email, password , contact_no, city, verify_status,email_otp) SELECT ?,?,?,?,?,?,?,?,? WHERE NOT EXISTS (SELECT supplier_id FROM supplier WHERE email = '$this->email')";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "sssssssss", $this->firstName, $this->lastName, $this->NIC, $this->email, md5($this->password), $this->contactNo, $this->city, $this->verifyStatus,md5($OTP));
                mysqli_stmt_execute($stmt);
                $this->supplierID = $conn->insert_id;
                $publicSupplierID = $this->supplierID;
                if($this->supplierID == 0){
                    echo "Sorry ! That email already exists.";
                }else{
                  
                    $materialSupplierModel = new MaterialSupplier($_POST, $publicSupplierID); 
                    $materialSupplierModel->insertMaterialSupplied();
                    ?><script>alert("Supplier was added successfully");</script><?php
                    echo "Check your email inbox for verification";
                }
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 
            $stmt->close(); 
            $conn->close(); 
        }
        public function view(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->supplierID = $_POST["supplier_id"];
            $sql = "SELECT supplier_id, first_name, last_name, NIC, email, contact_no, city, verify_status FROM supplier where supplier_id='$this->supplierID'";
            $path = mysqli_query($conn, $sql);
            $result = $path->fetch_array(MYSQLI_ASSOC);
            if($result = mysqli_query($conn, $sql)){
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_array($result);
                    return $row;
                }else {
                    echo "0 results";
                }
            }else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
        public function update(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->customerID = $_POST["customer_id"];
            //$sql = "UPDATE employee SET name=?, username=?, password=?, email=?, contact_no=?, user_type=?, address_line1=?, address_line2=?, address_line3=?,DOB=?, joined_date=?, active_status=? WHERE employee_id='$this->employeeID' AND NOT EXISTS (SELECT employee_id FROM employee WHERE username = '$this->username')";    
            $sql = "UPDATE customer SET first_name=?,last_name=?, NIC=?, email=?, contact_no=?, city=? WHERE customer_id='$this->customerID'";        
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssss", $this->firstName, $this->lastName, $this->NIC, $this->email, $this->contactNo, $this->city);
                mysqli_stmt_execute($stmt);
                $affectedRows = mysqli_stmt_affected_rows($stmt);
                if($affectedRows == -1){
                    echo "Sorry ! An error occured.";
                }else{
                    echo "Supplier was updated successfully";
                    echo "<table>";
                    echo "<tr><td>Customer ID </td><td>: $this->customerID</td></tr>";
                    echo "<tr><td>First name </td><td>: $this->firstName</td></tr>";
                    echo "<tr><td>Last name </td><td>: $this->lastName</td></tr>"; 
                    echo "<tr><td>NIC </td><td>: $this->NIC</td></tr>"; 
                    echo "<tr><td>Email </td><td>: $this->email</td></tr>"; 
                    echo "<tr><td>Contact number </td><td>: $this->contactNo</td></tr>"; 
                    echo "<tr><td>City </td><td>: $this->city</td></tr>";
                    echo "</table>";
                }
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 
            $stmt->close(); 
            $conn->close(); 
        }
        public function delete(){

        }


        public function addSupplier() {
            $this->add();
        }

        public function updateSupplier() {
            $this->update();
        }

        public function viewSupplier() {
            $row = $this->view();
            return $row;
        }
        public function editSelfProfile() {
            
        }
        public function signUp(){
            $this->add();
        }
        
        public function login() {
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "SELECT * from supplier where email='$this->email';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if(md5($this->password) == $row["password"]){
                if($row["verify_status"]=="approve"){
                    if($row["email_verification"] == 1){
                        session_start();
                        $_SESSION["email"] = $row["email"]; 
                        $_SESSION["username"] = $row["first_name"]." ".$row["last_name"]; 
                        $_SESSION["supplier_id"] = $row["supplier_id"]; 
                        header("location: http://localhost/rlf/view/supplier/profile.php");   
                    }else{
                        ?><script>alert("Your email isn't verified");</script><?php
                        echo "Please verify email and try again.";
                    }  
                }else{
                    ?><script>alert("Your account is inactive");</script><?php
                    echo "Please try again later.<br />";
                }
            }else{
                ?><script>alert("Sorry ! Your credentials are invalid.");</script><?php
                echo "Please try again.<br />";
            }     
            $conn->close();
        }
                
        public function logout() {
            header("location: http://localhost/rlf/view/supplier/login/login.php");
        }
    
        public function verifyEmail() {
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "SELECT * from supplier where email='$this->email';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if(md5($this->emailOTP) == $row["email_otp"]){
                $sql_update = "UPDATE supplier SET email_verification = ? WHERE email = '$this->email'";        
                if ($stmt = mysqli_prepare($conn, $sql_update)) {
                    $validValue = 1;
                    mysqli_stmt_bind_param($stmt, "i", $validValue);
                    mysqli_stmt_execute($stmt);
                    $affectedRows = mysqli_stmt_affected_rows($stmt);
                    if($affectedRows == -1){
                        ?><script>alert("Sorry ! Email wasn't verified");</script><?php
                        echo "Please try again later.";
                    }else{
                        ?><script>alert("Email was verified successfully");</script><?php
                        echo "Now you can log in";
                    }
                } else {
                    echo "Error: <br>" . mysqli_error($conn);
                } 
                $stmt->close(); 
                $conn->close();
            }else{
                ?><script>alert("Sorry ! Your OTP code is incorrect");</script><?php
                echo "Please try again";
            }
        }
        public function requestForgotPassword(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "SELECT * from supplier where email='$this->email';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if($this->email == $row["email"]){
                $OTP = rand(1000,9999);
                $message = "Click <a href='http://localhost/rlf/view/supplier/reset_forgot_password.php?email=".$this->email."'>here</a> to reset password.";
                $sendMail = new SendMail($row["first_name"], $row["last_name"], $this->email, $OTP, $message); 
                $sendMail->sendTheEmail();
                $sql_update = "UPDATE supplier SET email_otp = ? WHERE email = '$this->email'";        
                if ($stmt = mysqli_prepare($conn, $sql_update)) {
                    mysqli_stmt_bind_param($stmt, "s", md5($OTP));
                    mysqli_stmt_execute($stmt);
                    ?><script>alert("Check your email inbox");</script><?php
                    echo "Use the OTP code and link in your email to reset your password";
                } else {
                    echo "Error: <br>" . mysqli_error($conn);
                } 
                $stmt->close(); 
                $conn->close();
            }else{
                ?><script>alert("Sorry! Your email is invalid");</script><?php
                echo "Enter your email again";
            }
        }
        public function resetForgotPassword(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "SELECT * from supplier where email='$this->email';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if(md5($this->emailOTP) == $row["email_otp"]){
                $sql_update = "UPDATE supplier SET password = ? WHERE email = '$this->email'";        
                if ($stmt = mysqli_prepare($conn, $sql_update)) {
                    $validValue = 1;
                    mysqli_stmt_bind_param($stmt, "s", md5($this->password));
                    mysqli_stmt_execute($stmt);
                    $affectedRows = mysqli_stmt_affected_rows($stmt);
                    if($affectedRows == -1){
                        ?><script>alert("Sorry ! Password wasn't changed");</script><?php
                        echo "Please try again later.";
                    }else{
                        ?><script>alert("Password was changed successfully");</script><?php
                        echo "Log in with your new password";
                    }
                } else {
                    echo "Error: <br>" . mysqli_error($conn);
                } 
                $stmt->close(); 
                $conn->close();
            }else{
                ?><script>alert("Sorry ! Your OTP code is incorrect");</script><?php
                echo "Please try again";
            } 
        }
    }
?>