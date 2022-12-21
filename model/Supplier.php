<?php
    error_reporting(E_ERROR | E_PARSE);
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
        private $NICFrontImage;
        private $NICRearImage;
        private $business_certificate;
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
            //print_r($_POST);
            while (true) {
                $nicFrontImage = uniqid().".".explode("/", $_FILES["NIC_front_image"]["type"])[1];
                if (!file_exists("../view/NIC-front-image/".$nicFrontImage)) break;
            }
            while (true) {
                $nicRearImage = uniqid().".".explode("/", $_FILES["NIC_rear_image"]["type"])[1];
                if (!file_exists("../view/NIC-rear-image/".$nicRearImage)) break;
            }
            while (true) {
                $businessCertificate = uniqid().".".explode("/", $_FILES["business_certificate"]["type"])[1];
                if (!file_exists("../view/business-certificate/".$businessCertificate)) break;
            } 
            
            $nicFrontImageTarget = "../view/NIC-front-image/".$nicFrontImage;
            $nicRearImageTarget = "../view/NIC-rear-image/".$nicRearImage;
            $businessCertificateTarget = "../view/business-certificate/".$businessCertificate;

            $tempNICFrontImage = $_FILES["NIC_front_image"]["tmp_name"];
            $tempNICRearImage = $_FILES["NIC_rear_image"]["tmp_name"];
            $tempBusinessCertificate = $_FILES["business_certificate"]["tmp_name"]; 

            $nicFrontImageResult = move_uploaded_file($tempNICFrontImage, $nicFrontImageTarget);
            $nicRearImageResult = move_uploaded_file($tempNICRearImage, $nicRearImageTarget);
            $businessCertificateResult = move_uploaded_file($tempBusinessCertificate, $businessCertificateTarget);

            if($nicFrontImageResult&&$nicRearImageResult&&$businessCertificateResult) { 
                $connObj = new DBConnection();
                $conn = $connObj->getConnection();
                $OTP = rand(1000,9999);
                $message = "Click <a href='http://localhost/rlf/view/supplier/verify_email.php?email=".$this->email."'>here</a> for email verification.";
                $sendMail = new SendMail($this->firstName, $this->lastName, $this->email, $OTP, $message); 
                $sendMail->sendTheEmail();
                $sql = "INSERT INTO supplier (first_name, last_name, NIC , email, password , contact_no, NIC_front_image, NIC_rear_image, business_certificate, city, verify_status, email_otp) SELECT ?,?,?,?,?,?,?,?,?,?,?,? WHERE NOT EXISTS (SELECT customer_id FROM customer WHERE email = '$this->email')";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssssssssssss", $this->firstName, $this->lastName, $this->NIC, $this->email, md5($this->password), $this->contactNo, $nicFrontImage, $nicRearImage, $businessCertificate, $this->city, $this->verifyStatus, md5($OTP));
                    mysqli_stmt_execute($stmt);
                    $this->supplierID = $conn->insert_id;
                    $publicSupplierID = $this->supplierID;
                    if($this->supplierID == 0){
                        echo "Sorry ! That email already exists.";
                    }else{
                        echo "<center><div style='background-color:#ffcc99;border-radius:6px;padding:15px;margin:30px;clear:inherit;font-family:sans-serif;'>";
                        echo "New supplier was added";
                        echo "<table>";
                        echo "<tr><td>Supplier ID </td><td>: $this->supplierID</td></tr>";
                        echo "<tr><td>First name </td><td>: $this->firstName</td></tr>";
                        echo "<tr><td>Last name </td><td>: $this->lastName</td></tr>"; 
                        echo "<tr><td>NIC </td><td>: $this->NIC</td></tr>"; 
                        echo "<tr><td>Email </td><td>: $this->email</td></tr>"; 
                        echo "<tr><td>Contact number </td><td>: $this->contactNo</td></tr>"; 
                        echo "<tr><td>City </td><td>: $this->city</td></tr>";
                        echo "</table>";
                        echo "</div></center>";
                        $materialSupplierModel = new MaterialSupplier($_POST, $publicSupplierID); 
                        $materialSupplierModel->insertMaterialSupplied();
                    }
                } else {		
                    echo "Error : ".$sql;			
                }
                    
                $stmt->close(); 
                $conn->close();
            } else {		
                echo "Sorry !!! There was an error in uploading your file";			
            }
        }
        public function view(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->supplierID = $_POST["supplier_id"];
            $sql = "SELECT supplier_id, first_name, last_name, NIC, email, contact_no, NIC_front_image, NIC_rear_image, business_certificate, city, verify_status FROM supplier where supplier_id='$this->supplierID'";
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
            $this->supplierID = $_POST["supplier_id"];
            $sql = "UPDATE supplier SET first_name=?,last_name=?, NIC=?, email=?, contact_no=?, city=?, verify_status=? WHERE supplier_id='$this->supplierID'";        
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "sssssss", $this->firstName, $this->lastName, $this->NIC, $this->email, $this->contactNo, $this->city, $this->verifyStatus);
                mysqli_stmt_execute($stmt);
                $affectedRows = mysqli_stmt_affected_rows($stmt);
                if($affectedRows == -1){
                    echo "<center><div style='background-color:#ffcc99;border-radius:6px;padding:15px;margin:30px;clear:inherit;font-family:sans-serif;'>";
                    echo "Sorry ! An error occured.";
                    echo "</div></center>";
                }else{
                    echo "<center><div style='background-color:#ffcc99;border-radius:6px;padding:15px;margin:30px;clear:inherit;font-family:sans-serif;'>";
                    echo "Supplier was updated successfully";
                    echo "<table>";
                    echo "<tr><td>Supplier ID </td><td>: $this->supplierID</td></tr>";
                    echo "<tr><td>First name </td><td>: $this->firstName</td></tr>";
                    echo "<tr><td>Last name </td><td>: $this->lastName</td></tr>"; 
                    echo "<tr><td>NIC </td><td>: $this->NIC</td></tr>"; 
                    echo "<tr><td>Email </td><td>: $this->email</td></tr>"; 
                    echo "<tr><td>Contact number </td><td>: $this->contactNo</td></tr>"; 
                    echo "<tr><td>City </td><td>: $this->city</td></tr>";
                    echo "<tr><td>Verify status </td><td>: $this->verifyStatus</td></tr>";
                    echo "</table>";
                    echo "</div></center>";
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
            $this->update();
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
            header("location: http://localhost/rlf/view/supplier/login.php");
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
                        echo "Now you can log in. <a href='http://localhost/rlf/view/supplier/login/login.php'>Log in</a>";
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