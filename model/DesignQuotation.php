<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    class DesignQuotation{
        
        private $unitPrice;
        private $quantity;
        
        function __construct($args, $publicQuotationID) {
            $this->quotationID = $publicQuotationID;
            $this->designID = $args["design_id"];
            $this->unitPrice = $args["unit_price"];
            $this->quantity = $args["quantity"];
        }

        public function insertQuantityPrice(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            for($materialCount = 0;$materialCount<count($this->materialID);$materialCount++){
                $sql = "INSERT INTO rlf.design_quotation (design_id, material_id, unit_price, quantity) VALUES (?,?,?,?);";
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

        public function updateQuantityPrice(){

        }

        public function viewQuantityPrice(){

        }
    }
?>

