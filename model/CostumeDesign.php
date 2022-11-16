<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    class CostumeDesign{
        
        private $designID;
        private $name;
        private $size;
        private $frontView;
        private $rearView;
        private $leftView;
        private $rightView;
        private $publishStatus;
        private $materialPriceApproval;
        private $materialPriceDescription;
        private $description;
        private $finalPrice;
        private $customizedDesignApproval;
        private $designApprovalDescription;
        private $designapprovalDate;
        
        function __construct($args) {
            $this->name = $args["name"];
            $this->size = $args["size"];
            $this->frontView = $_FILES["front_view"]["name"];
            $this->rearView = $_FILES["rear_view"]["name"];
            $this->leftView = $_FILES["left_view"]["name"];
            $this->rightView = $_FILES["right_view"]["name"];
            $this->publishStatus = $args["publish_status"];
            $this->materialPriceApproval = $args["material_price_approval"];
            $this->materialPriceDescription = $args["material_price_description"];
            $this->description = $args["description"];
            $this->finalPrice = $args["final_price"];
            $this->customizedDesignApproval = $args["customized_design_approval"]; 
            $this->designApprovalDescription = $args["design_approval_description"];
            $this->designApprovalDate = $args["design_approval_date"];
            $this->customerID = $args["customer_id"];
            $this->merchandiserID = $args["merchandiser_id"];
            $this->fashionDesignerID = $args["fashion_designer_id"];
        }

        public function add(){
            while (true) {
                $newFrontImage = uniqid().".".explode("/", $_FILES["image"]["type"])[1];
                if (!file_exists("raw-material-image/".$newImageName)) break;
            }
            
            $target = "/opt/lampp/htdocs/rlf/view/raw-material-image/";		
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