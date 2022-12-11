<?php
    error_reporting(E_ALL ^ E_WARNING);
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
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
        }


        public function add(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "INSERT INTO customer (first_name, last_name, NIC , email, password , contact_no, city) SELECT ?,?,?,?,?,?,? WHERE NOT EXISTS (SELECT customer_id FROM customer WHERE email = '$this->email')";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "sssssss", $this->firstName, $this->lastName, $this->NIC, $this->email, md5($this->password), $this->contactNo, $this->city);
                mysqli_stmt_execute($stmt);
                $this->customerID = $conn->insert_id;
                if($this->customerID == 0){
                    echo "Sorry ! That email already exists.";
                }else{
                    ?><script>alert("Customer was added successfully");</script><?php
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
            $this->customerID = $_POST["customer_id"];
            $sql = "SELECT customer_id, first_name, last_name, NIC, email, contact_no, city FROM customer where customer_id = '$this->customerID'";
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
            $this->customerID = $_GET["customer_id"];
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
            //$sql = "UPDATE customer SET first_name=?,last_name=?, NIC=?, email=?, contact_no=?, city=? WHERE customer_id='$this->customerID' AND NOT EXISTS (SELECT customer_id FROM customer WHERE email = '$this->email')";    
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


        public function addCustomer() {
            $this->add();
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

        public function updateCustomer() {
            $this->update();
        }

        public function viewCustomer() {
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
            $sql = "SELECT * from customer where email='$this->email';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if(md5($this->password) == $row["password"]){
                session_start();
                $_SESSION["customer_id"] = $row["customer_id"]; 
                $_SESSION["first_name"] = $row["first_name"]; 
                $_SESSION["last_name"] = $row["last_name"]; 
                   
                header("location: http://localhost/RLF/view/customer/customer_UI.php");
                
                exit;
            }else{
                ?><script>alert("Sorry ! Your credentials are invalid. Please try again.");</script> <?php
                //header("location: http://localhost/RLF/view/customer/customer_login.php");
            }  
            
            
            $conn->close();
        }
        public function logout() {
            header("location: http://localhost/RLF/view/customer/customer_login.php");
        }
    }
?>