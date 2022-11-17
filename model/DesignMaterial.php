<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    class DesignMaterial{
        
        private $quantity;
        private $unitPrice;
        
        function __construct($args) {
            $this->designID = $args["design_id"];
            $this->materialID = $args["material_id"];
            $this->unitPrice = $args["unit_price"];
            $this->quantity = $args["quantity"];
        }

        public function add(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "INSERT INTO design_material (design_id, material_id,  unit_price, quantity) VALUES (?,?,?,?);";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "iiid", $this->designID, $this->materialID, $this->unitPrice, $this->quantity);
                mysqli_stmt_execute($stmt);
                echo "<table>";
                echo "<tr><td>Design ID </td><td>: $this->designID</td></tr>";
                echo "<tr><td>Raw material ID </td><td>: $this->materialID</td></tr>";
                echo "<tr><td>Unit price </td><td>: $this->unitPrice</td></tr>";
                echo "<tr><td>Quantity </td><td>: $this->quantity</td></tr>"; 
                echo "</table>";
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 				
            $stmt->close(); 
            $conn->close(); 
        }

        public function view(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->materialID = $_GET["material_id"];
            $sql = "SELECT * FROM design_material where material_id='$this->materialID' AND design_id='$this->designID'";
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