<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
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
                    echo "<br><table>";
                    echo "<tr><td>Raw material ID </td><td>:". $this->materialID[$materialCount]."</td></tr>";
                    echo "</table>";
                    	
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

        public function delete(){

        }

        public function insertMaterialSupplied() {
            $this->add();
        }

        public function viewMaterialSupplied() {
            $this->view();
        }
        public function deleteMaterialSupplied() {
            $this->delete();
        }
    
        
    }
?>