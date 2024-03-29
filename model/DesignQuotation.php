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
            for($costumeCount = 0;$costumeCount < count($this->designID);$costumeCount++){
    
                $sql = "INSERT INTO rlf.design_quotation (quotation_id, design_id, unit_price, quantity) VALUES (?,?,?,?);";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "iiii", $this->quotationID, explode("-",$this->designID[$costumeCount])[0], $this->unitPrice[$costumeCount], $this->quantity[$costumeCount]);
                    mysqli_stmt_execute($stmt);
                    $insertedRow = $conn -> affected_rows;
                    if($insertedRow == -1){
                        ?><script>
                        var materialID = "<?php echo $this->materialID[$materialCount]; ?>";
                        var message = "Sorry ! That material already exists. - ".concat(materialID);
                        alert(message);
                        </script><?php  
                        
                    }else{
                    
                    } 
                    
                } else {
                    echo "Error: <br>" . mysqli_error($conn);
                } 
                $stmt->close();
            }		
            $conn->close();  
        }

    }
?>

