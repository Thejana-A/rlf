<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    class DesignMaterial{
        
        private $quantity;
        private $unitPrice;
        
        function __construct($args, $publicDesignID) {
            $this->designID = $publicDesignID;
            $this->materialID = $args["material_id"];
            $this->unitPrice = $args["unit_price"];
            $this->quantity = $args["quantity"];
        }

        public function add(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            for($materialCount = 0;$materialCount<count($this->materialID);$materialCount++){
                $sql = "INSERT INTO rlf.design_material (design_id, material_id, unit_price, quantity) VALUES (?,?,?,?);";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "iiid", $this->designID, $this->materialID[$materialCount], $this->unitPrice[$materialCount], $this->quantity[$materialCount]);
                    mysqli_stmt_execute($stmt);
                    $insertedRow = $conn -> affected_rows;
                    if($insertedRow == -1){
                        echo "<br>Material ID : ".$this->materialID[$materialCount]."<br>Sorry ! That material already exists.<br>";
                    }else{
                        echo "<br><table>";
                        echo "<tr><td>Raw material ID </td><td>:". $this->materialID[$materialCount]."</td></tr>";
                        echo "<tr><td>Unit price </td><td>:". $this->unitPrice[$materialCount]."</td></tr>";
                        echo "<tr><td>Quantity </td><td>:". $this->quantity[$materialCount]."</td></tr>"; 
                        echo "</table>";
                    } 
                    	
                } else {
                    echo "Error: <br>" . mysqli_error($conn);
                } 
                $stmt->close(); 
            }		
            $conn->close(); 
        }

        public function view(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->materialID = $_GET["material_id"];
            $sql = "SELECT * FROM design_material where design_id='$this->designID'";
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

        public function insertMaterialQuantity() {
            $this->add();
        }

        public function updateMaterialQuantity() {
            $this->update();
        }

        public function viewMaterialQuantity() {
            $row = $this->view();
            return $row;
        }
        public function deleteMaterialQuantity() {
            $this->delete();
        }
    
        
    }
?>