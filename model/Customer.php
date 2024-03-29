<?php
    
    error_reporting(E_ERROR | E_PARSE);

    require_once(__DIR__.'/DBConnection.php');
    require_once(__DIR__.'/send_email/SendMail.php');
    require_once(__DIR__.'/IDBModel.php');
    class Customer implements IDBModel{
        
        private $customerID;
        private $firstName;
        private $lastName;
        private $NIC;
        private $email;
        private $password;
        private $contactNo;
        private $city;
        private $emailOTP;
        private $emailVerification;
        
         
        function __construct($args) {
            $this->firstName = $args["first_name"];
            $this->lastName = $args["last_name"];
            $this->NIC = $args["NIC"];
            $this->email = $args["email"];
            $this->password = $args["password"];
            $this->contactNo = $args["contact_no"];
            $this->city = $args["city"];
            $this->emailOTP = $args["email_otp"];   
  
        }


        public function add(){
            //print_r($_POST);
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql_supplier = "SELECT * FROM supplier where email = '$this->email';";
            $result_supplier = $conn->query($sql_supplier);
            $sql_employee = "SELECT * FROM employee where email = '$this->email';";
            $result_employee = $conn->query($sql_employee);
            if(($result_supplier->num_rows) > 0){
                ?><script>
                alert("Sorry ! That email already exists.");
                window.location.href='<?php echo $_POST["page_url"]; ?>';
                </script><?php 
            }else if(($result_employee->num_rows) > 0){
                ?><script>
                alert("Sorry ! That email already exists.");
                window.location.href='<?php echo $_POST["page_url"]; ?>';
                </script><?php 
            }else{
                $OTP = rand(1000,9999);
                $message = "Click <a href='http://localhost/rlf/view/customer/verify_email.php?email=".$this->email."'>here</a> for email verification.";
                $sendMail = new SendMail($this->firstName, $this->lastName, $this->email, $OTP, $message); 
                $sendMail->sendTheEmail(); 
                $sql = "INSERT INTO customer (first_name, last_name, NIC , email, password , contact_no, city,email_otp) SELECT ?,?,?,?,?,?,?,? WHERE NOT EXISTS (SELECT customer_id FROM customer WHERE email = '$this->email')";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssssssss", $this->firstName, $this->lastName, $this->NIC, $this->email, md5($this->password), $this->contactNo, $this->city, md5($OTP));
                    mysqli_stmt_execute($stmt);
                    $this->customerID = $conn->insert_id;
                    if($this->customerID == 0){
                        ?><script>
                        alert("Sorry ! That email or NIC already exists.");
                        window.location.href='<?php echo $_POST["page_url"]; ?>';
                        </script><?php
                    }else{
                        ?><script>alert("Customer was added successfully");
                        alert("Check email inbox for verification");
                        window.location.href='<?php echo $_POST["page_url"]; ?>';
                        </script><?php             
                    }
                } else {
                    echo "Error: <br>" . mysqli_error($conn);
                } 
                $stmt->close(); 
                $conn->close();  
            }
        }
        

        public function view(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->customerID = $_POST["customer_id"];
            $sql = "SELECT customer_id, first_name, last_name, NIC, email, contact_no, city FROM customer WHERE customer_id='$this->customerID'";
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
            
            $sql = "UPDATE customer SET first_name=?,last_name=?, NIC=?, email=?, contact_no=?, city=? WHERE customer_id='$this->customerID'";        
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssss", $this->firstName, $this->lastName, $this->NIC, $this->email, $this->contactNo, $this->city);
                mysqli_stmt_execute($stmt);
                $affectedRows = mysqli_stmt_affected_rows($stmt);
                if($affectedRows == -1){
                    ?><script>
                    alert("Sorry ! An error occured.");
                    window.location.href='<?php echo $_POST["page_url"]; ?>';
                    </script><?php  
                }else{
                    ?><script>
                    alert("Customer was updated successfully");
                    window.location.href='<?php echo $_POST["home_url"]; ?>';
                    </script><?php  
                    
                }
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 
            $stmt->close(); 
            $conn->close(); 
            
        }

        public function delete(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->customerID = $_POST["customer_id"];
            $sql = "DELETE FROM customer WHERE customer_id = ?";        
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $this->customerID);
                mysqli_stmt_execute($stmt);
                $affectedRows = mysqli_stmt_affected_rows($stmt);
                if($affectedRows == -1){
                    ?><script>
                    alert("Sorry ! That customer can't be deleted.");
                    window.location.href='<?php echo $_POST["page_url"]; ?>';
                    </script><?php
                }else{

                    ?><script>
                    alert("Customer was deleted successfully");
                    window.location.href='<?php echo $_POST["home_url"]; ?>';
                    </script><?php
                }
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 
            $stmt->close(); 
            $conn->close(); 
        }


        public function addCustomer() {
            $this->add();
        }

        public function updateCustomer() {
            $this->update();
        }

        public function viewCustomer() {
            $row = $this->view();
            return $row;
        }

        public function deleteCustomer() {
            $this->delete();
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
            $sql = "SELECT * from customer where email='$this->email';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if(md5($this->password)==$row["password"]){
                if($row["email_verification"]==1){
                    session_start();
                    $_SESSION["customer_id"] = $row["customer_id"]; 
                    $_SESSION["first_name"] = $row["first_name"]; 
                    $_SESSION["last_name"] = $row["last_name"]; 
                    $_SESSION["NIC"] = $row["NIC"];
                    $_SESSION["email"] = $row["email"];
                    $_SESSION["contact_no"] = $row["contact_no"];
                    $_SESSION["city"] = $row["city"];
                    header("location: http://localhost/rlf/view/customer/customer_UI.php");
                }else{
                    ?><script>
                    alert("Sorry ! Your email isn't verified.");
                    window.location.href='<?php echo $_POST["page_url"]; ?>';
                    </script><?php
                }
                
                
                exit;
            }else{
                ?><script>
                alert("Sorry ! Your credentials are invalid. Please try again.");
                window.location.href='<?php echo $_POST["page_url"]; ?>';
                </script><?php
            }  
            
            
            $conn->close();
        }
        
        public function verifyEmail() {
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "SELECT * from customer where email='$this->email';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if(md5($this->emailOTP) == $row["email_otp"]){
                $sql_update = "UPDATE customer SET email_verification = ? WHERE email = '$this->email'";        
                if ($stmt = mysqli_prepare($conn, $sql_update)) {
                    $validValue = 1;
                    mysqli_stmt_bind_param($stmt, "i", $validValue);
                    mysqli_stmt_execute($stmt);
                    $affectedRows = mysqli_stmt_affected_rows($stmt);
                    if($affectedRows == -1){
                        ?><script>
                        alert("Sorry ! Email wasn't verified. Please try again later.");
                        window.location.href='<?php echo $_POST["page_url"]; ?>';
                        </script><?php
                    }else{
                        ?><script>
                        alert("Email was verified successfully and now you can log in");
                        window.location.href='http://localhost/rlf/view/customer/customer_login.php';
                        </script><?php
                    }
                } else {
                    echo "Error: <br>" . mysqli_error($conn);
                } 
                $stmt->close(); 
                $conn->close();
            }else{
                ?><script>
                alert("Sorry ! Your OTP code is incorrect");
                window.location.href='<?php echo $_POST["page_url"]; ?>';
                </script><?php
            }
        }

        public function logout() {
            header("location: http://localhost/rlf/view/customer/customer_login.php");
        }
        
        public function resetPassword(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->customerID = $_POST["customer_id"];
            $sql = "SELECT * from customer where customer_id = '$this->customerID';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if(md5($this->password) == $row["password"]){
                $sql_reset_password = "UPDATE customer SET password=? WHERE customer_id='$this->customerID'";        
                if ($stmt = mysqli_prepare($conn, $sql_reset_password)) {
                    mysqli_stmt_bind_param($stmt, "s", md5($_POST["new_password"]));
                    mysqli_stmt_execute($stmt);
                    $affectedRows = mysqli_stmt_affected_rows($stmt);
                    if($affectedRows == -1){
                        ?><script>
                        alert("Sorry ! Password wasn't updated.")
                        window.location.href='<?php echo $_POST["page_url"]; ?>';
                        </script><?php  
                    }else{
                        ?><script>
                        alert("Password was updated successfully")
                        window.location.href='<?php echo $_POST["home_url"]; ?>';
                        </script><?php  
                    }
                }
            }else{
                ?><script>
                alert("Sorry ! Your current password is wrong.");
                window.location.href='<?php echo $_POST["page_url"]; ?>';
                </script><?php  
            } 

        }
        public function resetForgotPassword(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "SELECT * from customer where email='$this->email';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if(md5($this->emailOTP) == $row["email_otp"]){
                $sql_update = "UPDATE customer SET password = ? WHERE email = '$this->email'";        
                if ($stmt = mysqli_prepare($conn, $sql_update)) {
                    $validValue = 1;
                    mysqli_stmt_bind_param($stmt, "s", md5($this->password));
                    mysqli_stmt_execute($stmt);
                    $affectedRows = mysqli_stmt_affected_rows($stmt);
                    if($affectedRows == -1){
                        ?><script>
                        alert("Sorry ! Password wasn't changed. Please try again later.");
                        window.location.href='<?php echo $_POST["page_url"]; ?>';
                        </script><?php  
                    }else{
                        ?><script>
                        alert("Password was changed successfully. Log in with your new password.");
                        window.location.href='http://localhost/rlf/view/customer/customer_login.php';
                        </script><?php
                    }
                } else {
                    echo "Error: <br>" . mysqli_error($conn);
                } 
                $stmt->close(); 
                $conn->close();
            }else{
                ?><script>
                alert("Sorry ! Your OTP code is incorrect. Please try again");
                window.location.href='<?php echo $_POST["page_url"]; ?>';
                </script><?php  
            } 
        } 
    }
?>