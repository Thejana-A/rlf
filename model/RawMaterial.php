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
            $this->image = $_FILES["image"]["name"];
            $this->description = $args["description"];
            $this->managerApproval = $args["manager_approval"];
            $this->approvalDescription = $args["approval_description"];
            $this->approvalDate = $args["approval_date"];
            $this->measuringUnit = $args["measuring_unit"];
            $this->quantityInStock = $args["quantity_in_stock"]; 
            $this->supplierID = $args["supplier_id"];
            $this->fashionDesignerID = $args["fashion_designer_id"];
        }

        public function add(){
            while (true) {
                $newImageName = uniqid().".".explode("/", $_FILES["image"]["type"])[1];
                if (!file_exists("raw-material-image/".$newImageName)) break;
            }
            
            $target = "../view/raw-material-image/";		
            $fileTarget = $target.$newImageName;	
            $tempFileName = $_FILES["image"]["tmp_name"];
            $result = move_uploaded_file($tempFileName,$fileTarget);
            if($result) { 
                $connObj = new DBConnection();
                $conn = $connObj->getConnection();
                $sql = "INSERT INTO raw_material (name, size, measuring_unit, image, description, manager_approval, approval_description, approval_date,quantity_in_stock,supplier_id,fashion_designer_id) SELECT ?,?,?,?,?,?,?,?,?,?,? WHERE NOT EXISTS (SELECT material_id FROM raw_material WHERE name = '$this->name')";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sssssssssii", $this->name, $this->size, $this->measuringUnit, $newImageName, $this->description, $this->managerApproval, $this->approvalDescription, $this->approvalDate, $this->quantityInStock, $this->supplierID, $this->fashionDesignerID);
                    mysqli_stmt_execute($stmt);
                    $this->materialID = $conn->insert_id;
                    if($this->materialID == 0){
                        echo "Sorry ! That material name already exists.";
                    }else{
                        echo "New raw material was added successfully";
                        echo "<table>";
                        echo "<tr><td>Raw material ID </td><td>: $this->materialID</td></tr>";
                        echo "<tr><td>Name </td><td>: $this->name</td></tr>";
                        echo "<tr><td>Size </td><td>: $this->size</td></tr>"; 
                        echo "<tr><td>Image </td><td>: $this->image</td></tr>"; 
                        echo "<tr><td>Measuring unit </td><td>: $this->measuringUnit</td></tr>"; 
                        echo "<tr><td>Description </td><td>: $this->description</td></tr>"; 
                        echo "</table>";
                    }
                } else {
                    echo "Error: <br>" . mysqli_error($conn);
                } 				
            }else{			
                echo "Sorry !!! There was an error in uploading your file";			
            }
            
            $stmt->close(); 
            $conn->close(); 
        }

        public function view(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->materialID = $_GET["material_id"];
            $sql = "SELECT * FROM raw_material where material_id='$this->materialID'";
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
            $this->RawMaterialID = $_POST["material_id"];    
            $sql = "UPDATE raw_material SET name=?, size=?, image=?, description=?, manager_approval=?, approval_description=?, approval_date=?, measuring_unit=?, quantity_in_stock=?, supplier_id=?, fashion_designer_id=? WHERE material_id='$this->materialID'";        
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "sssssssssii", $this->name, $this->size, $this->image, $this->description, $this->manager_approval, $this->approval_description, $this->approval_date, $this->measuring_unit, $this->quantity_in_stock, $this->supplierID, $this->fashionDesignerID);
                mysqli_stmt_execute($stmt);
                $affectedRows = mysqli_stmt_affected_rows($stmt);
                if($affectedRows == -1){
                    echo "Sorry ! That username already exists.";
                }else{
                    echo "RawMaterial was updated successfully";
                    echo "<table>";
                    echo "<tr><td>Raw material ID </td><td>: $this->materialID</td></tr>";
                    echo "<tr><td>Name </td><td>: $this->name</td></tr>";
                    echo "<tr><td>Size </td><td>: $this->size</td></tr>"; 
                    echo "<tr><td>Image </td><td>: $this->image</td></tr>"; 
                    echo "<tr><td>Measuring unit </td><td>: $this->measuringUnit</td></tr>"; 
                    echo "<tr><td>Description </td><td>: $this->description</td></tr>"; 
                    echo "<tr><td>Manager's approval </td><td>: $this->managerApproval</td></tr>"; 
                    echo "<tr><td>Approval description </td><td>: $this->approvalDescription</td></tr>"; 
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