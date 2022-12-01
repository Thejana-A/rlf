<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
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
        }

        public function add(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "INSERT INTO employee (first_name, last_name, NIC , email, password , contact_no, user_type, address_line1, address_line2, address_line3, DOB, joined_date, active_status) SELECT ?,?,?,?,?,?,?,?,?,?,?,?,? WHERE NOT EXISTS (SELECT employee_id FROM employee WHERE email = '$this->email')";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "sssssssssssss", $this->firstName, $this->lastName, $this->NIC, $this->email, md5($this->password), $this->contactNo, $this->userType, $this->addressLine1, $this->addressLine2, $this->addressLine3, $this->DOB, $this->joinedDate, $this->activeStatus);
                mysqli_stmt_execute($stmt);
                $this->employeeID = $conn->insert_id;
                if($this->employeeID == 0){
                    echo "Sorry ! That email already exists.";
                }else{
                    echo "New employee was added successfully";
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
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            }  
            $stmt->close(); 
            $conn->close(); 
        }
        public function view(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->employeeID = $_GET["employee_id"];
            $sql = "SELECT * FROM employee where employee_id='$this->employeeID'";
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
                    echo "Employee was updated successfully";
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
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "SELECT * from employee where email='$this->email';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if(md5($this->password) == $row["password"]){
                if($row["active_status"]=="enable"){
                    session_start();
                    $_SESSION["email"] = $row["email"]; 
                    $_SESSION["employee_id"] = $row["employee_id"]; 
                    $_SESSION["username"] = $row["first_name"]." ".$row["last_name"]; 
                    $_SESSION["user_type"] = $row["user_type"]; 
                    if($_SESSION["user_type"]=="manager"){
                        header("location: http://localhost/rlf/view/manager/home.php");
                    }else if($_SESSION["user_type"]=="merchandiser"){
                        header("location: http://localhost/rlf/view/merchandiser/home.php");
                    }else if($_SESSION["user_type"]=="fashion designer"){
                        header("location: http://localhost/rlf/view/fashion_designer/home.php");
                    }else{
                        echo "Your credentials are invalid. Please try again.<br />";
                    } 
                }else{
                    echo "Your account is inactive.<br />";
                }
                
            }else{
                echo "Sorry ! Your credentials are invalid. Please try again.<br />";
            }  
            $conn->close(); 
        }

        public function logout() {
                header("location: http://localhost/rlf/view/merchandiser/login.php");
                
        } 
    }
?>