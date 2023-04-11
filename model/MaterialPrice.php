<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    class MaterialPrice{
        
        private $requestQuantity;
        private $unitPrice;
        
        function __construct($args, $publicQuotationID) {
            $this->quotationID = $publicQuotationID;
            $this->materialID = $args["material_id"];
            $this->requestQuantity = $args["request_quantity"];
            $this->unitPrice = $args["unit_price"];
        }

        public function setQuantity(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            for($materialCount = 0;$materialCount<count($this->materialID);$materialCount++){
                if($this->requestQuantity[$materialCount] > 0){
                    $sql = "INSERT INTO rlf.material_price (quotation_id, material_id, request_quantity, unit_price) VALUES (?,?,?,?);";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        mysqli_stmt_bind_param($stmt, "iidi", $this->quotationID, $this->materialID[$materialCount], $this->requestQuantity[$materialCount], $this->unitPrice[$materialCount]);
                        mysqli_stmt_execute($stmt);
                        $insertedRow = $conn -> affected_rows;
                        if($insertedRow == -1){
                            echo "<br>Material ID : ".$this->materialID[$materialCount]."<br>Sorry ! That material already exists.<br>";
                        }
                    } else {
                        echo "Error: <br>" . mysqli_error($conn);
                    } 
                }
            }	
            $stmt->close(); 	
            $conn->close(); 
            
        }

        public function viewQuantityPrice(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->quotationID = $_POST["quotation_id"];
            $sql = "SELECT * FROM material_price WHERE quotation_id='$this->quotationID';";
            
            $result = $conn->query($sql);
            $quantity_price_array = array();
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()) {
                    array_push($quantity_price_array, $row); 
                    print_r($row);
                    echo "<br>";
                }
                return $quantity_price_array;
            }else{
                echo "0 results";
            } 
            mysqli_close($conn);

        }

        /*public function editQuantityPrice(){
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
        } */

        /*public function delete(){

        }*/

        
    }
?>