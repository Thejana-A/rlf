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
                    mysqli_stmt_bind_param($stmt, "ssssssss", $this->firstName, $this->lastName, $this->NIC, $this->email, ($this->password), $this->contactNo, $this->city,md5($OTP));
                    mysqli_stmt_execute($stmt);
                    $this->customerID = $conn->insert_id;
                    if($this->customerID == 0){
                        echo "Sorry ! That email already exists.";
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

            /*$connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->customerID = $_POST["customer_id"];
            $sql = "SELECT * FROM customer where customer_id = '$this->customerID'";
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
            mysqli_close($conn); */
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
                    echo "Customer was updated successfully";
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
            /*echo "<table>";
            echo "<tr><td>Customer ID </td><td>: $this->customerID</td></tr>";
            echo "<tr><td>First name </td><td>: $this->firstName</td></tr>";
            echo "<tr><td>Last name </td><td>: $this->lastName</td></tr>"; 
            echo "<tr><td>NIC </td><td>: $this->NIC</td></tr>"; 
            echo "<tr><td>Email </td><td>: $this->email</td></tr>"; 
            echo "<tr><td>Contact number </td><td>: $this->contactNo</td></tr>"; 
            echo "<tr><td>City </td><td>: $this->city</td></tr>";
            echo "</table>";*/
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
            if(($this->password)==$row["password"]){
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
                    ?><script>alert("Sorry ! Your email isn't verified.");</script> <?php
                }
                
                
                exit;
            }else{
                ?><script>alert("Sorry ! Your credentials are invalid. Please try again.");</script> <?php
                //header("location: http://localhost/RLF/view/customer/customer_login.php");
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
                        ?><script>alert("Sorry ! Email wasn't verified");</script><?php
                        echo "Please try again later.";
                    }else{
                        echo "<script> alert('Email was verified successfully And Now You can log in');
                        window.location.href='customer/customer_login.php';
                        </script>";
                        //echo "Now you can log in";
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
            if(($this->password) == $row["password"]){
                $sql_reset_password = "UPDATE customer SET password=? WHERE customer_id='$this->customerID'";        
                if ($stmt = mysqli_prepare($conn, $sql_reset_password)) {
                    mysqli_stmt_bind_param($stmt, "s", ($_POST["new_password"]));
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
            $sql = "SELECT * from employee where email='$this->email';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if(md5($this->emailOTP) == $row["email_otp"]){
                $sql_update = "UPDATE employee SET password = ? WHERE email = '$this->email'";        
                if ($stmt = mysqli_prepare($conn, $sql_update)) {
                    $validValue = 1;
                    mysqli_stmt_bind_param($stmt, "s", ($this->password));
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