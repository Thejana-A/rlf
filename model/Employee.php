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
                    echo "Sorry ! That email already exists.";
                }else{
                    ?><script>alert("Employee was added successfully");</script><?php
                    echo "Check email inbox for verification";
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
            //$sql = "UPDATE employee SET name=?, username=?, password=?, email=?, contact_no=?, user_type=?, address_line1=?, address_line2=?, address_line3=?,DOB=?, joined_date=?, active_status=? WHERE employee_id='$this->employeeID' AND NOT EXISTS (SELECT employee_id FROM employee WHERE username = '$this->username')";    
            $sql = "UPDATE employee SET first_name=?,last_name=?, NIC=?, email=?, contact_no=?, user_type=?, address_line1=?, address_line2=?, address_line3=?,DOB=?, joined_date=?, active_status=? WHERE employee_id='$this->employeeID'";        
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssssssssss", $this->firstName, $this->lastName, $this->NIC, $this->email, $this->contactNo, $this->userType, $this->addressLine1, $this->addressLine2, $this->addressLine3, $this->DOB, $this->joinedDate, $this->activeStatus);
                mysqli_stmt_execute($stmt);
                $affectedRows = mysqli_stmt_affected_rows($stmt);
                if($affectedRows == -1){
                    echo "Sorry ! An error occured.";
                }else{
                    /*echo "Employee was updated successfully";
                    echo "<table>";
                    echo "<tr><td>Employee ID </td><td>: $this->employeeID</td></tr>";
                    echo "<tr><td>First name </td><td>: $this->firstName</td></tr>";
                    echo "<tr><td>Last name </td><td>: $this->lastName</td></tr>"; 
                    echo "<tr><td>NIC </td><td>: $this->NIC</td></tr>"; 
                    echo "<tr><td>Email </td><td>: $this->email</td></tr>"; 
                    echo "<tr><td>Contact number </td><td>: $this->contactNo</td></tr>"; 
                    echo "<tr><td>User type </td><td>: $this->userType</td></tr>";
                    echo "<tr><td>Address line 1 </td><td>: $this->addressLine1</td></tr>"; 
                    echo "<tr><td>Address line 2 </td><td>: $this->addressLine2</td></tr>"; 
                    echo "<tr><td>Address line 3 </td><td>: $this->addressLine3</td></tr>";
                    echo "<tr><td>Date of birth </td><td>: $this->DOB</td></tr>";
                    echo "<tr><td>Joined date </td><td>: $this->joinedDate</td></tr>";
                    echo "<tr><td>Active status </td><td>: $this->activeStatus</td></tr>";
                    echo "</table>"; */
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

        }


        public function addEmployee() {
            $this->add();
            echo "<table>";
            echo "<tr><td>Employee ID </td><td>: $this->employeeID</td></tr>";
            echo "<tr><td>First name </td><td>: $this->firstName</td></tr>";
            echo "<tr><td>Last name </td><td>: $this->lastName</td></tr>"; 
            echo "<tr><td>NIC </td><td>: $this->NIC</td></tr>"; 
            echo "<tr><td>Email </td><td>: $this->email</td></tr>"; 
            echo "<tr><td>Contact number </td><td>: $this->contactNo</td></tr>"; 
            echo "<tr><td>User type </td><td>: $this->userType</td></tr>";
            echo "<tr><td>Address line 1 </td><td>: $this->addressLine1</td></tr>"; 
            echo "<tr><td>Address line 2 </td><td>: $this->addressLine2</td></tr>"; 
            echo "<tr><td>Address line 3 </td><td>: $this->addressLine3</td></tr>";
            echo "<tr><td>Date of birth </td><td>: $this->DOB</td></tr>";
            echo "<tr><td>Joined date </td><td>: $this->joinedDate</td></tr>";
            echo "<tr><td>Active status </td><td>: $this->activeStatus</td></tr>";
            echo "</table>";
        }
        public function signUp() {
            $this->add();
        }

        public function updateEmployee() {
            $this->update();
        }

        public function viewEmployee() {
            $row = $this->view();
            return $row;
        }
        public function editSelfProfile() {
            $this->update();
        }
        
        public function login() {   
            //print_r($_POST);
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "SELECT * from employee where email='$this->email';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if(md5($this->password) == $row["password"]){
                if($row["active_status"] == "enable"){
                    if($row["email_verification"] == 1){
                        session_start();
                        $_SESSION["email"] = $row["email"]; 
                        $_SESSION["employee_id"] = $row["employee_id"]; 
                        $_SESSION["username"] = $row["first_name"]." ".$row["last_name"]; 
                        $_SESSION["user_type"] = $row["user_type"]; 
                        if($_SESSION["user_type"] == "manager"){
                            header("location: http://localhost/rlf/view/manager/home.php");
                        }else if($_SESSION["user_type"] == "merchandiser"){
                            header("location: http://localhost/rlf/view/merchandiser/home.php");
                        }else if($_SESSION["user_type"] == "fashion designer"){
                            header("location: http://localhost/rlf/view/fashion_designer/home.php");
                        }else{
                            echo "Your credentials are invalid. Please try again.<br />";
                        } 
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
                header("location: http://localhost/rlf/view/merchandiser/login.php");
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
                        ?><script>alert("Sorry ! Password wasn't updated.")</script><?php
                        echo "Please try again";
                    }else{
                        ?><script>alert("Passwrod was updated successfully")</script><?php
                        echo "Use your new password to login next time";
                    }
                }
            }else{
                ?><script>alert("Sorry ! Your current password is wrong.")</script><?php
                echo "Please try again";
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
                        ?><script>alert("Sorry ! Email wasn't verified");</script><?php
                        echo "Please try again later.";
                    }else{
                        ?><script>alert("Email was verified successfully and now you can log in");
                        window.location.href='http://localhost/rlf/view/customer/login_as.html';
                        </script><?php
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
            $sql = "SELECT * from employee where email='$this->email';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if($this->email == $row["email"]){
                $OTP = rand(1000,9999);
                $message = "Click <a href='http://localhost/rlf/view/merchandiser/reset_forgot_password.php?email=".$this->email."'>here</a> to reset password.";
                $sendMail = new SendMail($row["first_name"], $row["last_name"], $this->email, $OTP, $message); 
                $sendMail->sendTheEmail();
                $sql_update = "UPDATE employee SET email_otp = ? WHERE email = '$this->email'";        
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