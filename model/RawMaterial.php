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
            $this->fashionDesignerID = explode("-" ,$args["fashion_designer_id"])[0];
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
            if($this->approvalDate == ''){
                $this->approvalDate = NULL;
            }
            if($this->fashionDesignerID == ''){
                $this->fashionDesignerID = NULL;
            }
            if($this->supplierID == ''){
                $this->supplierID = NULL;
            }
            if($result) { 
                $connObj = new DBConnection();
                $conn = $connObj->getConnection();
                $sql = "INSERT INTO raw_material (name, size, measuring_unit, image, description, manager_approval, approval_description, approval_date, quantity_in_stock, supplier_id, fashion_designer_id) SELECT ?,?,?,?,?,?,?,?,?,?,? WHERE NOT EXISTS (SELECT material_id FROM raw_material WHERE name = '$this->name')";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssssssssdii", $this->name, $this->size, $this->measuringUnit, $newImageName, $this->description, $this->managerApproval, $this->approvalDescription, $this->approvalDate, $this->quantityInStock, $this->supplierID, $this->fashionDesignerID);
                    mysqli_stmt_execute($stmt);
                    $this->materialID = $conn->insert_id;
                    if($this->materialID == 0){
                        echo "Sorry ! That material name already exists.";
                    }else{
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
            $this->materialID = $_POST["material_id"];   

            if($_FILES["image"]["name"] != ""){
                while (true) {
                    $rawMaterialImage = uniqid().".".explode("/", $_FILES["image"]["type"])[1];
                    if (!file_exists("../view/raw-material-image/".$rawMaterialImage)) break;
                }

                $rawMaterialImageTarget = "../view/raw-material-image/".$rawMaterialImage;
                $tempRawMaterialImage = $_FILES["image"]["tmp_name"];
                $rawMaterialImageResult = move_uploaded_file($tempRawMaterialImage, $rawMaterialImageTarget);
                $sql_reset_image = "UPDATE raw_material SET image = ? WHERE material_id = '$this->materialID'";        
                if ($stmt = mysqli_prepare($conn, $sql_reset_image)) {
                    mysqli_stmt_bind_param($stmt, "s", $rawMaterialImage);
                    mysqli_stmt_execute($stmt);
                }
            } 
             
            $sql = "UPDATE raw_material SET name=?, size=?, measuring_unit=?, description=?, manager_approval=?, approval_description=?, approval_date=?, quantity_in_stock=? WHERE material_id='$this->materialID'";        
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "sssssssd", $this->name, $this->size, $this->measuringUnit, $this->description, $this->managerApproval, $this->approvalDescription, $this->approvalDate, $this->quantityInStock);
                mysqli_stmt_execute($stmt);
                $affectedRows = mysqli_stmt_affected_rows($stmt);
                if($affectedRows == -1){
                    echo "Sorry ! Material couldn't be updated.<br>";
                }else{
                    ?><script>
                    alert("Raw material was updated successfully");
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
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->materialID = $_POST["material_id"];
            $sql = "DELETE FROM raw_material WHERE material_id = ?";        
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $this->materialID);
                mysqli_stmt_execute($stmt);
                $affectedRows = mysqli_stmt_affected_rows($stmt);
                if($affectedRows == -1){
                    ?><script>
                        alert("Sorry ! That material can't be deleted.");
                        window.location.href='<?php echo $_POST["page_url"]; ?>';
                    </script><?php
                }else{
                    ?><script>
                        alert("Material was deleted successfully");
                        window.location.href='<?php echo $_POST["home_url"]; ?>';
                    </script><?php
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
            $row = $this->view();
            return $row; 
        }


        public function deleteRawMaterial() {
            $this->delete();
        }
    
        
    }
?>