<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    require_once(__DIR__.'/send_email/SendMail.php');
    require_once(__DIR__.'/IDBModel.php');
    class Employee implements IDBModel{
        
        private $employeeID;
        private $firstName;
        private $lastName;
        private $NIC;
        private $email;
        private $password;
        private $contactNo;
        private $userType;
        private $addressLine1;
        private $addressLine2;
        private $addressLine3;
        private $DOB;
        private $joinedDate;
        private $activeStatus;
        private $emailOTP;
        private $emailVerification;
         
        function __construct($args) {
            $this->firstName = $args["first_name"];
            $this->lastName = $args["last_name"];
            $this->NIC = $args["NIC"];
            $this->email = $args["email"];
            $this->password = $args["password"];
            $this->contactNo = $args["contact_no"];
            $this->userType = $args["user_type"];
            $this->addressLine1 = $args["address_line1"];
            $this->addressLine2 = $args["address_line2"];
            $this->addressLine3 = $args["address_line3"];
            $this->DOB = $args["DOB"];
            $this->joinedDate = $args["joined_date"];
            $this->activeStatus = $args["active_status"];   
            $this->emailOTP = $args["email_otp"];    
        }

        public function add(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql_customer = "SELECT * FROM customer where email = '$this->email';";
            $result_customer = $conn->query($sql_customer);
            $sql_supplier = "SELECT * FROM supplier where email = '$this->email';";
            $result_supplier = $conn->query($sql_supplier);
            if(($result_customer->num_rows) > 0){
                ?><script>
                alert("Sorry ! That email already exists. xx");
                window.location.href='<?php echo $_POST["page_url"]; ?>';
                </script><?php 
            }else if(($result_supplier->num_rows) > 0){
                ?><script>
                alert("Sorry ! That email already exists. xy");
                window.location.href='<?php echo $_POST["page_url"]; ?>';
                </script><?php 
            }else{
                $OTP = rand(1000,9999);
                $message = "Click <a href='http://localhost/rlf/view/merchandiser/verify_email.php?email=".$this->email."'>here</a> for email verification.";
                $sendMail = new SendMail($this->firstName, $this->lastName, $this->email, $OTP, $message); 
                $sendMail->sendTheEmail();  
                $sql = "INSERT INTO employee (first_name, last_name, NIC , email, password , contact_no, user_type, address_line1, address_line2, address_line3, DOB, joined_date, active_status, email_otp) SELECT ?,?,?,?,?,?,?,?,?,?,?,?,?,? WHERE NOT EXISTS (SELECT employee_id FROM employee WHERE email = '$this->email')";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssssssssssssss", $this->firstName, $this->lastName, $this->NIC, $this->email, md5($this->password), $this->contactNo, $this->userType, $this->addressLine1, $this->addressLine2, $this->addressLine3, $this->DOB, $this->joinedDate, $this->activeStatus, md5($OTP));
                    mysqli_stmt_execute($stmt);
                    $this->employeeID = $conn->insert_id;
                    if($this->employeeID == 0){
                        ?><script>
                        alert("Sorry ! That email or NIC already exists.");
                        window.location.href='<?php echo $_POST["page_url"]; ?>';
                        </script><?php 
                    }else{
                        ?><script>
                        alert("Employee was added successfully. Check email for verification");</script><?php 
                        if($_POST["home_url"]==""){ ?><script>
                            window.location.href='<?php echo $_POST["page_url"]; ?>';</script><?php
                        }else{ ?><script>
                            window.location.href='<?php echo $_POST["home_url"]; ?>';</script><?php
                        }
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
            $this->employeeID = $_POST["employee_id"];
            $sql = "SELECT employee_id, first_name, last_name, NIC, email, contact_no, user_type, address_line1, address_line2, address_line3, DOB, joined_date, active_status FROM employee where employee_id='$this->employeeID'";
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
            $this->employeeID = $_POST["employee_id"];
              
            $sql = "UPDATE employee SET first_name=?,last_name=?, NIC=?, email=?, contact_no=?, user_type=?, address_line1=?, address_line2=?, address_line3=?,DOB=?, joined_date=?, active_status=? WHERE employee_id='$this->employeeID'";        
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssssssssss", $this->firstName, $this->lastName, $this->NIC, $this->email, $this->contactNo, $this->userType, $this->addressLine1, $this->addressLine2, $this->addressLine3, $this->DOB, $this->joinedDate, $this->activeStatus);
                mysqli_stmt_execute($stmt);
                $affectedRows = mysqli_stmt_affected_rows($stmt);
                if($affectedRows == -1){
                    ?><script>
                    alert("Sorry ! An error occured.");
                    window.location.href='<?php echo $_POST["page_url"]; ?>';
                    </script><?php 
                }else{
                    ?><script>
                    alert("Employee was updated successfully");
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
            $this->employeeID = $_POST["employee_id"];
            $sql = "DELETE FROM employee WHERE employee_id = ?";        
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $this->employeeID);
                mysqli_stmt_execute($stmt);
                $affectedRows = mysqli_stmt_affected_rows($stmt);
                if($affectedRows == -1){
                    ?><script>
                        alert("Sorry ! That employee can't be deleted.");
                        window.location.href='<?php echo $_POST["page_url"]; ?>';
                    </script><?php
                }else{
                    ?><script>
                        alert("Employee was deleted successfully");
                        window.location.href='<?php echo $_POST["home_url"]; ?>';
                    </script><?php
                }
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 
            $stmt->close(); 
            $conn->close(); 
        }


        public function addEmployee() {
            $this->add();
            
        }

        public function updateEmployee() {
            $this->update();
        }

        public function viewEmployee() {
            $row = $this->view();
            return $row;
        }

        public function deleteEmployee() {
            $this->delete();
        }

        public function editSelfProfile() {
            $this->update();
        }
        
        public function login() {   
            //print_r($_POST);
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql_employee = "SELECT * from employee where email='$this->email';";
            $result_employee = $conn->query($sql_employee);
            $row_employee = $result_employee->fetch_assoc();
            $sql_customer = "SELECT * from customer where email='$this->email';";
            $result_customer = $conn->query($sql_customer);
            $row_customer = $result_customer->fetch_assoc();
            $sql_supplier = "SELECT * from supplier where email='$this->email';";
            $result_supplier = $conn->query($sql_supplier);
            $row_supplier = $result_supplier->fetch_assoc();
            if(md5($this->password) == $row_employee["password"]){
                if($row_employee["active_status"] == "enable"){
                    if($row_employee["email_verification"] == 1){
                        session_start();
                        $_SESSION["email"] = $row_employee["email"]; 
                        $_SESSION["employee_id"] = $row_employee["employee_id"]; 
                        $_SESSION["username"] = $row_employee["first_name"]." ".$row_employee["last_name"]; 
                        $_SESSION["user_type"] = $row_employee["user_type"]; 
                        if($_SESSION["user_type"] == "manager"){
                            header("location: http://localhost/rlf/view/manager/home.php");
                        }else if($_SESSION["user_type"] == "merchandiser"){
                            header("location: http://localhost/rlf/view/merchandiser/home.php");
                        }else if($_SESSION["user_type"] == "fashion designer"){
                            header("location: http://localhost/rlf/view/fashion_designer/home.php");
                        }else{
                            ?><script>
                            alert("Your credentials are invalid. Please try again.");
                            window.location.href='<?php echo $_POST["page_url"]; ?>';
                            </script><?php  
                        } 
                    }else{
                        ?><script>
                        alert("Your email isn't verified");
                        window.location.href='<?php echo $_POST["page_url"]; ?>';
                        </script><?php  
                    }
                    
                }else{
                    ?><script>
                    alert("Your account is inactive");
                    window.location.href='<?php echo $_POST["page_url"]; ?>';
                    </script><?php  
                }
            }else if(md5($this->password)==$row_customer["password"]){
                if($row_customer["email_verification"]==1){
                    session_start();
                    $_SESSION["customer_id"] = $row_customer["customer_id"]; 
                    $_SESSION["first_name"] = $row_customer["first_name"]; 
                    $_SESSION["last_name"] = $row_customer["last_name"]; 
                    $_SESSION["NIC"] = $row_customer["NIC"];
                    $_SESSION["email"] = $row_customer["email"];
                    $_SESSION["contact_no"] = $row_customer["contact_no"];
                    $_SESSION["city"] = $row_customer["city"];
                    header("location: http://localhost/rlf/view/customer/customer_UI.php");
                }else{
                    ?><script>alert("Sorry ! Your email isn't verified.");
                    window.location.href='<?php echo $_POST["page_url"]; ?>';
                    </script><?php  
                }
                
                
                exit;
            }else if(md5($this->password) == $row_supplier["password"]){
                if($row_supplier["verify_status"]=="approve"){
                    if($row_supplier["email_verification"] == 1){
                        session_start();
                        $_SESSION["email"] = $row_supplier["email"]; 
                        $_SESSION["username"] = $row_supplier["first_name"]." ".$row_supplier["last_name"]; 
                        $_SESSION["first_name"] = $row_supplier["first_name"];
                        $_SESSION["supplier_id"] = $row_supplier["supplier_id"]; 
                        header("location: http://localhost/rlf/view/supplier/profile.php");   
                    }else{
                        ?><script>alert("Your email isn't verified");
                        window.location.href='<?php echo $_POST["page_url"]; ?>';
                        </script><?php  
                    }  
                }else{
                    ?><script>alert("Your account is inactive");
                    window.location.href='<?php echo $_POST["page_url"]; ?>';
                    </script><?php  
                }
                
            }else{
                ?><script>
                alert("Sorry ! Your credentials are invalid.");
                window.location.href='<?php echo $_POST["page_url"]; ?>';
                </script><?php  
            }  
            $conn->close(); 
        }
        

        public function logout() {
                header("location: http://localhost/rlf/view/customer/customer_login.php");
        }

        public function resetPassword(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->employeeID = $_POST["employee_id"];
            $sql = "SELECT * from employee where employee_id = '$this->employeeID';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if(md5($this->password) == $row["password"]){
                $sql_reset_password = "UPDATE employee SET password=? WHERE employee_id='$this->employeeID'";        
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


        public function verifyEmail() {
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "SELECT * from employee where email='$this->email';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if(md5($this->emailOTP) == $row["email_otp"]){
                $sql_update = "UPDATE employee SET email_verification = ? WHERE email = '$this->email'";        
                if ($stmt = mysqli_prepare($conn, $sql_update)) {
                    $validValue = 1;
                    mysqli_stmt_bind_param($stmt, "i", $validValue);
                    mysqli_stmt_execute($stmt);
                    $affectedRows = mysqli_stmt_affected_rows($stmt);
                    if($affectedRows == -1){
                        ?><script>
                        alert("Sorry ! Email wasn't verified. Please try again.");
                        window.location.href='<?php echo $_POST["page_url"]; ?>';
                        </script><?php  
                    }else{
                        ?><script>alert("Email was verified successfully and now you can log in");
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
        
        public function requestForgotPassword(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql_employee = "SELECT * from employee where email='$this->email';";
            $result_employee = $conn->query($sql_employee);
            $row_employee = $result_employee->fetch_assoc();
            $sql_customer = "SELECT * from customer where email='$this->email';";
            $result_customer = $conn->query($sql_customer);
            $row_customer = $result_customer->fetch_assoc();
            $sql_supplier = "SELECT * from supplier where email='$this->email';";
            $result_supplier = $conn->query($sql_supplier);
            $row_supplier = $result_supplier->fetch_assoc();
            if($this->email == $row_employee["email"]){
                $OTP = rand(1000,9999);
                $message = "Click <a href='http://localhost/rlf/view/merchandiser/reset_forgot_password.php?email=".$this->email."'>here</a> to reset password.";
                $sendMail = new SendMail($row_employee["first_name"], $row_employee["last_name"], $this->email, $OTP, $message); 
                $sendMail->sendTheEmail();
                $sql_update = "UPDATE employee SET email_otp = ? WHERE email = '$this->email'";        
                if ($stmt = mysqli_prepare($conn, $sql_update)) {
                    mysqli_stmt_bind_param($stmt, "s", md5($OTP));
                    mysqli_stmt_execute($stmt);
                    ?><script>
                    alert("Check your email inbox. Use the OTP code and link in your email to reset your password");
                    window.location.href='http://localhost/rlf/';
                    </script><?php
                } else {
                    echo "Error: <br>" . mysqli_error($conn);
                } 
                $stmt->close(); 
                $conn->close();
            }else if($this->email == $row_customer["email"]){
                $OTP = rand(1000,9999);
                $message = "Click <a href='http://localhost/rlf/view/customer/reset_forgot_password.php?email=".$this->email."'>here</a> to reset password.";
                $sendMail = new SendMail($row_customer["first_name"], $row_customer["last_name"], $this->email, $OTP, $message); 
                $sendMail->sendTheEmail();
                $sql_update = "UPDATE customer SET email_otp = ? WHERE email = '$this->email'";        
                if ($stmt = mysqli_prepare($conn, $sql_update)) {
                    mysqli_stmt_bind_param($stmt, "s", md5($OTP));
                    mysqli_stmt_execute($stmt);
                    ?><script>
                    alert("Check your email inbox. Use the OTP code and link in your email to reset your password");
                    window.location.href='http://localhost/rlf/';
                    </script><?php
                } else {
                    echo "Error: <br>" . mysqli_error($conn);
                } 
                $stmt->close(); 
                $conn->close();
            }else if($this->email == $row_supplier["email"]){
                $OTP = rand(1000,9999);
                $message = "Click <a href='http://localhost/rlf/view/supplier/reset_forgot_password.php?email=".$this->email."'>here</a> to reset password.";
                $sendMail = new SendMail($row_supplier["first_name"], $row_supplier["last_name"], $this->email, $OTP, $message); 
                $sendMail->sendTheEmail();
                $sql_update = "UPDATE supplier SET email_otp = ? WHERE email = '$this->email'";        
                if ($stmt = mysqli_prepare($conn, $sql_update)) {
                    mysqli_stmt_bind_param($stmt, "s", md5($OTP));
                    mysqli_stmt_execute($stmt);
                    ?><script>
                    alert("Check your email inbox. Use the OTP code and link in your email to reset your password");
                    window.location.href='http://localhost/rlf/';
                    </script><?php
                } else {
                    echo "Error: <br>" . mysqli_error($conn);
                } 
                $stmt->close(); 
                $conn->close();
            }else{
                ?><script>
                alert("Sorry! Your email is invalid. Enter your email again.");
                window.location.href='<?php echo $_POST["page_url"]; ?>';
                </script><?php
            }
        } 
        
        public function resetForgotPassword(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "SELECT * from employee where email='$this->email';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if(md5($this->emailOTP) == $row["email_otp"]){
                $sql_update = "UPDATE employee SET password = ? WHERE email = '$this->email'";        
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
                alert("Sorry ! Your OTP code is incorrect. Please try again.");
                window.location.href='<?php echo $_POST["page_url"]; ?>';
                </script><?php
            } 
        } 
    }
?>