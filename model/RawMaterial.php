<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    require_once(__DIR__.'/IDBModel.php');
    class RawMaterial implements IDBModel{
        
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
            $this->supplierID = explode("-" ,$args["supplier_id"])[0];
            $this->fashionDesignerID = $args["fashion_designer_id"];
        }

        public function add(){
            while (true) {
                $newImageName = uniqid().".".explode("/", $_FILES["image"]["type"])[1];
                if (!file_exists("../view/raw-material-image/".$newImageName)) break;
            }
            
            $target = "../view/raw-material-image/";		
            $fileTarget = $target.$newImageName;	
            $tempFileName = $_FILES["image"]["tmp_name"];
            $result = move_uploaded_file($tempFileName,$fileTarget);
            $this->quantityInStock = 0;
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
                        /*echo "<center><div style='background-color:#ffcc99;border-radius:6px;padding:15px;margin:30px;clear:inherit;font-family:sans-serif;'>";
                        echo "New raw material was added successfully";
                        echo "<table>";
                        echo "<tr><td>Raw material ID </td><td>: $this->materialID</td></tr>";
                        echo "<tr><td>Name </td><td>: $this->name</td></tr>";
                        echo "<tr><td>Size </td><td>: $this->size</td></tr>"; 
                        echo "<tr><td>Image </td><td>: $this->image</td></tr>"; 
                        echo "<tr><td>Measuring unit </td><td>: $this->measuringUnit</td></tr>"; 
                        echo "<tr><td>Description </td><td>: $this->description</td></tr>"; 
                        echo "</table>";
                        echo "</div></center>"; */
                        ?><script>
                        alert("New raw material was saved successfully");
                        window.location.href='<?php echo $_POST["home_url"]; ?>';
                        </script><?php  
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
            $this->materialID = $_POST["material_id"];
            $sql = 
            "SELECT material_id,name,size,measuring_unit,quantity_in_stock,description,image, raw_material.supplier_id as requester_id,'supplier' as requester_role, first_name,last_name,manager_approval,approval_description FROM raw_material,supplier where raw_material.supplier_id = supplier.supplier_id and material_id = '$this->materialID'
            UNION
            SELECT material_id,name,size,measuring_unit,quantity_in_stock,description,image, raw_material.fashion_designer_id as requester_id,'fashion designer' as requester_role, first_name,last_name,manager_approval,approval_description FROM raw_material,employee where raw_material.fashion_designer_id = employee.employee_id and material_id = '$this->materialID'
            UNION
            SELECT material_id,name,size,measuring_unit,quantity_in_stock,description,image,'' as requester_id,'' as requester_role, '' as first_name,'' as last_name,manager_approval,approval_description FROM raw_material where fashion_designer_id is null and supplier_id is null AND material_id = '$this->materialID';";
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
            $this->RawMaterialID = $_POST["material_id"];    
            $sql = "UPDATE raw_material SET name=?, size=?, image=?, description=?, manager_approval=?, approval_description=?, approval_date=?, measuring_unit=?, quantity_in_stock=?, supplier_id=?, fashion_designer_id=? WHERE material_id='$this->materialID'";        
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "sssssssssii", $this->name, $this->size, $this->image, $this->description, $this->manager_approval, $this->approval_description, $this->approval_date, $this->measuring_unit, $this->quantity_in_stock, $this->supplierID, $this->fashionDesignerID);
                mysqli_stmt_execute($stmt);
                $affectedRows = mysqli_stmt_affected_rows($stmt);
                if($affectedRows == -1){
                    echo "Sorry ! That username already exists.";
                }else{
                    echo "Raw material was updated successfully";
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
            $row = $this->view();
            return $row; 
        }


        public function deleteRawMaterial() {
            $this->delete();
        }
    
        
    }
?>