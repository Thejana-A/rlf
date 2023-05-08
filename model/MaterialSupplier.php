<?php
    //error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    class MaterialSupplier{
        
        function __construct($args, $publicSupplierID) {
            $this->supplierID = $publicSupplierID;
            $this->materialID = $args["material_id"];
        }
        
        public function add(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            
            for($materialCount = 0;$materialCount<count($this->materialID);$materialCount++){
                $sql = "INSERT INTO rlf.material_supplier (supplier_id, material_id) VALUES (?,?);";
                
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ii", $this->supplierID, $this->materialID[$materialCount]);
                    mysqli_stmt_execute($stmt);  	
                } else {
                    echo "Error: <br>" . mysqli_error($conn);
                }  
                $stmt->close(); 
            }	
            $conn->close(); 
        }

        
        public function insertMaterialSupplied() {
            $this->add();
        }
    
        
    }
?>