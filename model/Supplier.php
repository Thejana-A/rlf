<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    require_once(__DIR__.'/MaterialSupplier.php');
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
        }

        public function add(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "INSERT INTO supplier (first_name, last_name, NIC , email, password , contact_no, city, verify_status) SELECT ?,?,?,?,?,?,?,? WHERE NOT EXISTS (SELECT customer_id FROM customer WHERE email = '$this->email')";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssssss", $this->firstName, $this->lastName, $this->NIC, $this->email, md5($this->password), $this->contactNo, $this->city, $this->verifyStatus);
                mysqli_stmt_execute($stmt);
                $this->supplierID = $conn->insert_id;
                $publicSupplierID = $this->supplierID;
                if($this->supplierID == 0){
                    echo "Sorry ! That email already exists.";
                }else{
                    echo "New supplier was added successfully";
                    echo "<table>";
                    echo "<tr><td>Supplier ID </td><td>: $this->supplierID</td></tr>";
                    echo "<tr><td>First name </td><td>: $this->firstName</td></tr>";
                    echo "<tr><td>Last name </td><td>: $this->lastName</td></tr>"; 
                    echo "<tr><td>NIC </td><td>: $this->NIC</td></tr>"; 
                    echo "<tr><td>Email </td><td>: $this->email</td></tr>"; 
                    echo "<tr><td>Contact number </td><td>: $this->contactNo</td></tr>"; 
                    echo "<tr><td>City </td><td>: $this->city</td></tr>";
                    echo "<tr><td>City </td><td>: $this->verifyStatus</td></tr>";
                    echo "</table>";
                    $materialSupplierModel = new MaterialSupplier($_POST, $publicSupplierID); 
                    $materialSupplierModel->insertMaterialSupplied();
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
            $sql = "SELECT * FROM customer where customer_id='$this->customerID'";
            $path = mysqli_query($conn, $sql);
            $result = $path->fetch_array(MYSQLI_ASSOC);
            if($result = mysqli_query($conn, $sql)){
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_array($result);
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

        }


        public function addSupplier() {
            $this->add();
        }

        public function updateSupplier() {
            $this->update();
        }

        public function viewSupplier() {
            $this->view();
        }
        public function editSelfProfile() {
            
        }
        public function signUp(){
            $this->add();
        }
        
        public function login() {
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            if($this->userType=="merchandiser"){
                $sql = "SELECT * from employee where username='$this->username';";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                if(md5($this->password) == $row["password"]){
                    session_start();
                    $_SESSION["username"] = $row["username"]; 
                    $_SESSION["employee_id"] = $row["employee_id"]; 
                    $_SESSION["user_type"] = $row["user_type"]; 
                    header("location: http://localhost/rlf/view/supplier/home.php");
                    exit;
                }else{
                    echo "Sorry ! Your credentials are invalid. Please try again.<br />";
                }  
            }
            
            $conn->close();
        }
        public function logout() {
            header("location: http://localhost/rlf/view/supplier/login.php");
        }
    }
?>