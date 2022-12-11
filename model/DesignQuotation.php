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
            for($costumeCount = 0;$costumeCount<count($this->designID);$costumeCount++){
                if($this->quantity[$costumeCount] > 0){
                    $sql = "INSERT INTO rlf.design_quotation (quotation_id, design_id, unit_price, quantity) VALUES (?,?,?,?);";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        mysqli_stmt_bind_param($stmt, "iiii", $this->quotationID, explode("-",$this->designID[$costumeCount])[0], $this->unitPrice[$costumeCount], $this->quantity[$costumeCount]);
                        mysqli_stmt_execute($stmt);
                        $insertedRow = $conn -> affected_rows;
                        if($insertedRow == -1){
                            echo "<br>Material ID : ".$this->materialID[$materialCount]."<br>Sorry ! That costume already exists in quotation.<br>";
                        }else{
                            echo "<br><table>";
                            echo "<tr><td>Costume ID </td><td>:". $this->designID[$costumeCount]."</td></tr>";
                            echo "<tr><td>Unit price </td><td>:". $this->unitPrice[$costumeCount]."</td></tr>";
                            echo "<tr><td>Quantity </td><td>:". $this->quantity[$costumeCount]."</td></tr>"; 
                            echo "</table>";
                        } 
                    	
                    } else {
                        echo "Error: <br>" . mysqli_error($conn);
                    } 
                    $stmt->close(); 
                }
            }		
            $conn->close();  
        }

        public function updateQuantityPrice(){

        }

        public function viewQuantityPrice(){

        }
    }
?>

