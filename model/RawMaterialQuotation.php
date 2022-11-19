<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    require_once(__DIR__.'/MaterialPrice.php');
    class RawMaterialQuotation{
        
        private $quotationID;
        private $expectedDeliveryDate;
        private $supplierApproval;
        private $approvalDescrition;
        private $requestDate;
        private $issueDate;
        private $validTill;
         
        function __construct($args) {
            $this->expectedDeliveryDate = $args["expected_delivery_date"];
            $this->supplierApproval = $args["supplier_approval"];
            $this->approvalDescrition = $args["approval_description"];
            $this->requestDate = $args["request_date"];
            $this->issueDate = $args["issue_date"];
            $this->validTill = $args["valid_till"];
            $this->supplierID = $args["supplier_id"];
            $this->merchandiserID = $args["merchandiser_id"]; 
        }

        public function add(){
            print_r($_POST);
            /*$connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "INSERT INTO raw_material_quotation (expected_delivery_date, supplier_approval, approval_description, request_date, issue_date, valid_till, supplier_id, merchandiser_id) VALUES (?,?,?,?,?,?,?,?);";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssssii", $this->expectedDeliveryDate, $this->supplierApproval, $this->approvalDescription, $this->requestDate, $this->issueDate, $this->validTill, $this->supplierID, $this->merchandiserID);
                mysqli_stmt_execute($stmt);
                $this->quotationID = $conn->insert_id;
                $publicQuotationID = $this->quotationID;
                if($this->quotationID == 0){
                    echo "Sorry ! An error occured.";
                }else{
                    echo "Material quotation request was added successfully";
                    echo "<table>";
                    echo "<tr><td>Quotation ID </td><td>: $this->quotationID</td></tr>";
                    echo "<tr><td>Expected delivery date </td><td>: $this->expectedDeliveryDate</td></tr>";
                    echo "<tr><td>Request date </td><td>: $this->requestDate</td></tr>"; 
                    echo "<tr><td>Supplier ID </td><td>: $this->supplierID</td></tr>"; 
                    echo "</table>";
                    $materialPriceModel = new MaterialPrice($_POST, $publicQuotationID); 
                    $materialPriceModel->setQuantity();
                }
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 
            $stmt->close(); 
            $conn->close(); */
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
                mysqli_stmt_bind_param($stmt, "sssssss", $this->firstName, $this->lastName, $this->NIC, $this->email, $this->contactNo, $this->city);
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


        public function addMaterialQuotation() {
            $this->add();
        }

        public function updateMaterialQuotation() {
            $this->update();
        }

        public function viewMaterialQuotation() {
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
                if($this->password==$row["password"]){
                    session_start();
                    $_SESSION["username"] = $row["username"]; 
                    $_SESSION["employee_id"] = $row["employee_id"]; 
                    $_SESSION["user_type"] = $row["user_type"]; 
                    header("location: http://localhost/rlf/view/merchandiser/home.php");
                    exit;
                }else{
                    echo "Sorry ! Your credentials are invalid. Please try again.<br />";
                }  
            }
            
            $conn->close();
        }
        public function logout() {
            header("location: http://localhost/rlf/view/merchandiser/login.php");
        }
    }
?>