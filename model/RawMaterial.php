<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    class RawMaterial{
        
        private $materialID;
        private $name;
        private $size;
        private $image;
        private $description;
        private $managerApproval;
        private $approvalDescription;
        private $approvalDate;
        private $measuringUnit;
        private $quantityInStock;
        
        function __construct($args) {
            $this->name = $args["name"];
            $this->size = $args["size"];
            $this->image = $args["image"];
            $this->description = $args["description"];
            $this->managerApproval = $args["manager_approval"];
            $this->approvalDescription = $args["approval_description"];
            $this->approvalDate = $args["approval_date"];
            $this->measuringUnit = $args["measuring_unit"];
            $this->quantityInStock = $args["quantity_in_stock"];    
        }

        public function add(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "INSERT INTO raw_material (name, size, image, description, manager_approval, approval_description, approval_date, measuring_unit,quantity_in_stock) SELECT ?,?,?,?,?,?,?,?,?,?,?,?,? WHERE NOT EXISTS (SELECT RawMaterial_id FROM RawMaterial WHERE email = '$this->email')";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "sssssssssssss", $this->firstName, $this->lastName, $this->NIC, $this->email, $this->password, $this->contactNo, $this->userType, $this->addressLine1, $this->addressLine2, $this->addressLine3, $this->DOB, $this->joinedDate, $this->activeStatus);
                mysqli_stmt_execute($stmt);
                $this->RawMaterialID = $conn->insert_id;
                if($this->RawMaterialID == 0){
                    echo "Sorry ! That username already exists.";
                }else{
                    echo "New RawMaterial was added successfully";
                    echo "<table>";
                    echo "<tr><td>RawMaterial ID </td><td>: $this->RawMaterialID</td></tr>";
                    echo "<tr><td>First name </td><td>: $this->fistName</td></tr>";
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
            $this->RawMaterialID = $_GET["RawMaterial_id"];
            $sql = "SELECT * FROM RawMaterial where RawMaterial_id='$this->RawMaterialID'";
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
            $this->RawMaterialID = $_POST["RawMaterial_id"];
            //$sql = "UPDATE RawMaterial SET name=?, username=?, password=?, email=?, contact_no=?, user_type=?, address_line1=?, address_line2=?, address_line3=?,DOB=?, joined_date=?, active_status=? WHERE RawMaterial_id='$this->RawMaterialID' AND NOT EXISTS (SELECT RawMaterial_id FROM RawMaterial WHERE username = '$this->username')";    
            $sql = "UPDATE RawMaterial SET first_name=?,last_name=?, NIC=?, email=?, password=?, contact_no=?, user_type=?, address_line1=?, address_line2=?, address_line3=?,DOB=?, joined_date=?, active_status=? WHERE RawMaterial_id='$this->RawMaterialID'";        
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssssssssss", $this->name, $this->username, $this->password, $this->email, $this->contactNo, $this->userType, $this->addressLine1, $this->addressLine2, $this->addressLine3, $this->DOB, $this->joinedDate, $this->activeStatus);
                mysqli_stmt_execute($stmt);
                $affectedRows = mysqli_stmt_affected_rows($stmt);
                if($affectedRows == -1){
                    echo "Sorry ! That username already exists.";
                }else{
                    echo "RawMaterial was updated successfully";
                    echo "<table>";
                    echo "<tr><td>RawMaterial ID </td><td>: $this->RawMaterialID</td></tr>";
                    echo "<tr><td>Name </td><td>: $this->name</td></tr>";
                    echo "<tr><td>Username </td><td>: $this->username</td></tr>"; 
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
        public function addRawMaterial() {
            $this->add();
        }

        public function updateRawMaterial() {
            $this->update();
        }

        public function viewRawMaterial() {
            $this->view();
        }
        public function deleteRawMaterial() {
            $this->delete();
        }
    
        
    }
?>